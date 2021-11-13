<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\FeeTransaction;
use App\Models\FeeTransactionPayment;
use App\Events\FeeTransactionPaymentUpdated;

use App\Utils\FeeTransactionUtil;
use DB;
class FeeTransactionPaymentController extends Controller
{
    protected $feeTransactionUtil;

     /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
     * @return void
     */
    public function __construct(FeeTransactionUtil $feeTransactionUtil)
    {
        $this->feeTransactionUtil = $feeTransactionUtil;
        
    } 
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $transaction = FeeTransaction::where('id', $id)
                                        ->with(['student'])
                                        ->first();
           // dd($transaction);
            $payments_query = FeeTransactionPayment::where('fee_transaction_id', $id);

        
            $accounts_enabled = true;
            $payments_query->with(['payment_account']);
            $payments = $payments_query->get();
            $payment_types = $this->feeTransactionUtil->payment_types();
            return view('fee_transaction_payment.show_payments')
                    ->with(compact('transaction', 'payments', 'payment_types', 'accounts_enabled'));
        }
    }
    /**
     * Shows contact's payment due modal
     *
     * @param  int  $student_id
     * @return \Illuminate\Http\Response
     */
    public function getPayStudentDue($student_id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $query = Student::where('students.id', $student_id)
                            ->leftJoin('classes as c-class', 'students.current_class_id', '=', 'c-class.id')
                            ->join('fee_transactions AS t', 'students.id', '=', 't.student_id');
      
            $query->select(
                DB::raw("SUM(IF(t.type = 'admission_fee' AND t.status = 'final', final_total, 0)) as total_admission_fee"),
                DB::raw("SUM(IF(t.type = 'admission_fee' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)) as total_admission_fee_paid"),
            
            );
            $query->addSelect(
                DB::raw("SUM(IF(t.type = 'fee' AND t.status = 'final', final_total, 0)) as total_fee"),
                DB::raw("SUM(IF(t.type = 'fee' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)) as total_fee_paid"),
            );
            
            

            //Query for opening balance details
            $query->addSelect(
                DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
                DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(amount) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)) as opening_balance_paid"),
                DB::raw("CONCAT(COALESCE(students.first_name, ''),' ',COALESCE(students.last_name,'')) as student_name"),
                'c-class.title as current_class',
                'students.roll_no',
                'students.father_name',
                'students.id as student_id'



            );
            $query->addSelect([
                DB::raw("COALESCE(SUM(IF(t.type = 'fee' AND t.status = 'final', final_total, 0)),0)-COALESCE(SUM(IF(t.type = 'fee' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'opening_balance', final_total, 0)),0) -COALESCE(SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'admission_fee', final_total, 0)),0) -COALESCE(SUM(IF(t.type = 'admission_fee', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)),0) as total_due")
            ]);
            $student_details = $query->first();
            $payment_line = new FeeTransactionPayment();
           
                $student_details->total_fee = empty($student_details->total_fee) ? 0 : $student_details->total_fee;
                $student_details->total_admission_fee = empty($student_details->total_admission_fee) ? 0 : $student_details->total_admission_fee;

                $payment_line->amount = $student_details->total_fee -
                                    $student_details->total_fee_paid +($student_details->total_admission_fee - $student_details->total_admission_fee_paid);
            

            //If opening balance due exists add to payment amount
            $student_details->opening_balance = !empty($student_details->opening_balance) ? $student_details->opening_balance : 0;
            $student_details->opening_balance_paid = !empty($student_details->opening_balance_paid) ? $student_details->opening_balance_paid : 0;
            $ob_due = $student_details->opening_balance - $student_details->opening_balance_paid;
            if ($ob_due > 0) {
                $payment_line->amount += $ob_due;
            }

            $amount_formatted = $this->feeTransactionUtil->num_f($payment_line->amount);

            $student_details->total_fee_paid = empty($student_details->total_fee_paid) ? 0 : $student_details->total_fee_paid;
            
            $payment_line->method = 'cash';
            $payment_line->paid_on = \Carbon::now()->toDateTimeString();
                   
            $payment_types = $this->feeTransactionUtil->payment_types();

            //Accounts
            $accounts = $this->feeTransactionUtil->accountsDropdown(1, 1,false,false,true,true);

            return view('fee_transaction_payment.pay_student_due_modal')
                        ->with(compact('student_details', 'payment_types', 'payment_line', 'ob_due', 'amount_formatted', 'accounts'));
        }
    }


      /**
     * Adds Payments for Student due
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPayStudentDue(Request  $request)

    {

        
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }
        $student_id = $request->input('student_id');
        try {
            DB::beginTransaction();
            
            $this->feeTransactionUtil->payStudent($request);

            DB::commit();
            $output = ['success' => true,
                            'msg' => __('purchase.payment_added_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                          'msg' => "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage()
                      ];
        }
    
        return redirect('students')->with(['status' => $output]);
    }
      /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $system_settings_id = request()->session()->get('user.system_settings_id');

            $payment_line = FeeTransactionPayment::where('method', '!=', 'advance')->findOrFail($id);

            $transaction = FeeTransaction::where('id', $payment_line->fee_transaction_id)
                                        ->with(['student', 'campus'])
                                        ->first();
            $payment_types = $this->feeTransactionUtil->payment_types();

            //Accounts
            $accounts =$this->feeTransactionUtil->accountsDropdown($system_settings_id,$transaction->campus_id,false,false,true,true);

            return view('fee_transaction_payment.edit_payment_row')
                        ->with(compact('transaction', 'payment_types', 'payment_line', 'accounts'));
        }
    }
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $inputs = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
            'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
            'cheque_number', 'bank_account_number']);
            $inputs['paid_on'] = $this->feeTransactionUtil->uf_date($request->input('paid_on'), true);
            $inputs['amount'] = $this->feeTransactionUtil->num_uf($inputs['amount']);

         

            if (!empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

            $payment = FeeTransactionPayment::where('method', '!=', 'advance')->findOrFail($id);
            //Update parent payment if exists
            if (!empty($payment->parent_id)) {
                $parent_payment = FeeTransactionPayment::find($payment->parent_id);
                $parent_payment->amount = $parent_payment->amount - ($payment->amount - $inputs['amount']);

                $parent_payment->save();
            }

            $system_settings_id = $request->session()->get('user.system_settings_id');

            $transaction = FeeTransaction::where('system_settings_id', $system_settings_id)
                                ->find($payment->fee_transaction_id);
            $transaction_before = $transaction->replicate();

            $document_name = $this->feeTransactionUtil->uploadFile($request, 'document', 'documents');
            if (!empty($document_name)) {
                $inputs['document'] = $document_name;
            }
                               
            DB::beginTransaction();

            $payment->update($inputs);

            //update payment status
            $payment_status = $this->feeTransactionUtil->updatePaymentStatus($payment->fee_transaction_id);
            $transaction->payment_status = $payment_status;


            DB::commit();

            //event
            event(new FeeTransactionPaymentUpdated($payment, $transaction->type));


            $output = ['success' => true,
                            'msg' => __('purchase.payment_updated_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                          'msg' => __('messages.something_went_wrong')
                      ];
        }

        return redirect()->back()->with(['status' => $output]);
    }
      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {

                $payment = FeeTransactionPayment::findOrFail($id);
               // dd($payment);
                DB::beginTransaction();

                if (!empty($payment->transaction_id)) {
                    FeeTransactionPayment::deletePayment($payment);
                } else { //advance payment
                    $adjusted_payments = FeeTransactionPayment::where('parent_id', 
                                                $payment->id)
                                                ->get();

                    $total_adjusted_amount = $adjusted_payments->sum('amount');

                    //Get customer advance share from payment and deduct from advance balance
                    $total_customer_advance = $payment->amount - $total_adjusted_amount;
                    // if ($total_customer_advance > 0) {
                    //     $this->transactionUtil->updateContactBalance($payment->payment_for, $total_customer_advance , 'deduct');
                    // }

                    //Delete all child payments
                    foreach ($adjusted_payments as $adjusted_payment) {
                        //Make parent payment null as it will get deleted
                        $adjusted_payment->parent_id = null;
                        FeeTransactionPayment::deletePayment($adjusted_payment);
                    }

                    //Delete advance payment
                    FeeTransactionPayment::deletePayment($payment);
                }
                
                DB::commit();

                $output = ['success' => true,
                                'msg' => __('purchase.payment_deleted_success')
                            ];
            } catch (\Exception $e) {
                DB::rollBack();

                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                
                $output = ['success' => false,
                                'msg' => __('messages.something_went_wrong')
                            ];
            }

            return $output;
        }
    }
}
