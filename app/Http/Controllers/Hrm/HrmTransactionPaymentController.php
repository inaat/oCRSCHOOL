<?php

namespace App\Http\Controllers\HRM;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\HumanRM\HrmEmployee;
use App\Models\HumanRM\HrmTransaction;
use App\Models\HumanRM\HrmTransactionPayment;
use App\Events\HrmTransactionPaymentUpdated;
use App\Events\HrmTransactionPaymentAdded;

use App\Utils\HrmTransactionUtil;
use DB;
class HrmTransactionPaymentController extends Controller
{
    protected $hrmTransactionUtil;

     /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
     * @return void
     */
    public function __construct(HrmTransactionUtil $hrmTransactionUtil)
    {
        $this->hrmTransactionUtil = $hrmTransactionUtil;
        
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
            $transaction = HrmTransaction::where('id', $id)
                                        ->with(['employee'])
                                        ->first();
           // dd($transaction);
            $payments_query = HrmTransactionPayment::where('hrm_transaction_id', $id);

            
            $accounts_enabled = true;
            $payments_query->with(['payment_account']);
            $payments = $payments_query->get();
            $payment_types = $this->hrmTransactionUtil->payment_types();
            return view('Hrm\hrm_transaction_payment.show_payments')
                    ->with(compact('transaction', 'payments', 'payment_types', 'accounts_enabled'));
        }
    }

       /**
     * Adds new payment to the given transaction.
     *
     * @param  int  $transaction_id
     * @return \Illuminate\Http\Response
     */
    public function addPayment($transaction_id)
    {
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments') && !auth()->user()->can('all_expense.access') && !auth()->user()->can('view_own_expense')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $system_settings_id = request()->session()->get('user.system_settings_id');
            $transaction = HrmTransaction::
                                        with(['employee', 'campus'])
                                        ->findOrFail($transaction_id);
            if ($transaction->payment_status != 'paid') {
                $payment_types = $this->hrmTransactionUtil->payment_types();

                $paid_amount = $this->hrmTransactionUtil->getTotalPaid($transaction_id);
                $amount = $transaction->final_total - $paid_amount;
                if ($amount < 0) {
                    $amount = 0;
                }

                $amount_formated = $this->hrmTransactionUtil->num_f($amount);

                $payment_line = new HrmTransactionPayment();
                $payment_line->amount = $amount;
                $payment_line->method = 'cash';
                $payment_line->paid_on = \Carbon::now()->toDateTimeString();

                //Accounts
                $accounts =$this->hrmTransactionUtil->accountsDropdown($system_settings_id,$transaction->campus_id,false,false,true,true);

                $view = view('Hrm\hrm_transaction_payment.payment_row')
                ->with(compact('transaction', 'payment_types', 'payment_line', 'amount_formated', 'accounts'))->render();

                $output = [ 'status' => 'due',
                                    'view' => $view];
            } else {
                $output = [ 'status' => 'paid',
                                'view' => '',
                                'msg' => __('purchase.amount_already_paid')  ];
            }

            return json_encode($output);
        }
    }
    /**
     * Shows contact's payment due modal
     *
     * @param  int  $employee_id
     * @return \Illuminate\Http\Response
     */
    public function getPayEmployeeDue($employee_id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $query = HrmEmployee::where('hrm_employees.id', $employee_id)
                            ->join('hrm_transactions AS t', 'hrm_employees.id', '=', 't.employee_id');
      
            $query->addSelect(
                DB::raw("SUM(IF(t.type = 'pay_roll' AND t.status = 'final', final_total, 0)) as total_hrm"),
                DB::raw("SUM(IF(t.type = 'pay_roll' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)) as total_hrm_paid"),
            );
            
            

            //Query for opening balance details
            $query->addSelect(
                DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
                DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(amount) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)) as opening_balance_paid"),
                DB::raw("CONCAT(COALESCE(hrm_employees.first_name, ''),' ',COALESCE(hrm_employees.last_name,'')) as employee_name"),
                'hrm_employees.employeeID',
                'hrm_employees.father_name',
                'hrm_employees.id as employee_id'



            );
            $query->addSelect([
                DB::raw("COALESCE(SUM(IF(t.type = 'pay_roll' AND t.status = 'final', final_total, 0)),0)-COALESCE(SUM(IF(t.type = 'pay_roll' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'opening_balance', final_total, 0)),0) -COALESCE(SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)),0) as total_due")
            ]);
            $query->addSelect([
                DB::raw("COALESCE(SUM(IF(t.type = 'pay_roll' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)),0) as total_paid")
            ]);
            $employee_details = $query->first();
            $payment_line = new HrmTransactionPayment();
           
                $employee_details->total_hrm = empty($employee_details->total_hrm) ? 0 : $employee_details->total_hrm;

                $payment_line->amount = $employee_details->total_hrm -
                                    $employee_details->total_hrm_paid ;
            

            //If opening balance due exists add to payment amount
            $employee_details->opening_balance = !empty($employee_details->opening_balance) ? $employee_details->opening_balance : 0;
            $employee_details->opening_balance_paid = !empty($employee_details->opening_balance_paid) ? $employee_details->opening_balance_paid : 0;
            $ob_due = $employee_details->opening_balance - $employee_details->opening_balance_paid;
            if ($ob_due > 0) {
                $payment_line->amount += $ob_due;
            }

            $amount_formatted = $this->hrmTransactionUtil->num_f($payment_line->amount);

            $employee_details->total_hrm_paid = empty($employee_details->total_hrm_paid) ? 0 : $employee_details->total_hrm_paid;
            
            $payment_line->method = 'cash';
            $payment_line->paid_on = \Carbon::now()->toDateTimeString();
                   
            $payment_types = $this->hrmTransactionUtil->payment_types();

            //Accounts
            $accounts = $this->hrmTransactionUtil->accountsDropdown(1, 1,false,false,true,true);

            return view('Hrm\hrm_transaction_payment.pay_employee_due_modal')
                        ->with(compact('employee_details', 'payment_types', 'payment_line', 'ob_due', 'amount_formatted', 'accounts'));
        }
    }


      /**
     * Adds Payments for employee due
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPayEmployeeDue(Request  $request)

    {

        
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }
        $employee_id = $request->input('employee_id');
        try {
            DB::beginTransaction();
         
            $this->hrmTransactionUtil->payEmployee($request);

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
    
        return redirect('hrm-employee')->with(['status' => $output]);
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

            $payment_line = HrmTransactionPayment::where('method', '!=', 'advance')->findOrFail($id);

            $transaction = HrmTransaction::where('id', $payment_line->hrm_transaction_id)
                                        ->with(['employee', 'campus'])
                                        ->first();
            $payment_types = $this->hrmTransactionUtil->payment_types();

            //Accounts
            $accounts =$this->hrmTransactionUtil->accountsDropdown($system_settings_id,$transaction->campus_id,false,false,true,true);

            return view('Hrm\hrm_transaction_payment.edit_payment_row')
                        ->with(compact('transaction', 'payment_types', 'payment_line', 'accounts'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       try {
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $transaction_id = $request->input('transaction_id');
            $transaction = HrmTransaction::with(['employee'])->findOrFail($transaction_id);

            $transaction_before = $transaction->replicate();

            if (!(auth()->user()->can('purchase.payments') || auth()->user()->can('sell.payments') || auth()->user()->can('all_expense.access') || auth()->user()->can('view_own_expense'))) {
                abort(403, 'Unauthorized action.');
            }
            if ($transaction->payment_status != 'paid') {
                $inputs = $request->only(['amount','discount_amount', 'method', 'note', 'card_number', 'card_holder_name',
                'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
                'cheque_number', 'bank_account_number']);
                $inputs['paid_on'] = $this->hrmTransactionUtil->uf_date($request->input('paid_on'), true);
                $inputs['hrm_transaction_id'] = $transaction->id;
                $inputs['amount'] = $this->hrmTransactionUtil->num_uf($inputs['amount']);
                $inputs['created_by'] = auth()->user()->id;
                $inputs['payment_for'] = $transaction->employee_id;
                $inputs['account_id'] = $request->input('account_id');
                $inputs['session_id']=$this->hrmTransactionUtil->getActiveSession();


                $prefix_type = 'pay_roll_payment';
                DB::beginTransaction();

                $ref_count = $this->hrmTransactionUtil->setAndGetReferenceCount($prefix_type, false, true);
                        //Generate reference number
                $inputs['payment_ref_no'] = $this->hrmTransactionUtil->generateReferenceNumber($prefix_type, $ref_count, $system_settings_id);

                $inputs['document'] = $this->hrmTransactionUtil->uploadFile($request, 'document', 'documents');

                //Pay from advance balance
                $payment_amount = $inputs['amount'];
                if (!empty($inputs['amount'])) {
                    $tp = HrmTransactionPayment::create($inputs);

                    $inputs['transaction_type'] = $transaction->type;
                    event(new HrmTransactionPaymentAdded($tp, $inputs));
                }

                //update payment status
                $payment_status = $this->hrmTransactionUtil->updatePaymentStatus($transaction_id, $transaction->final_total);
                
                DB::commit();
                
            }

            $output = ['success' => true,
                            'msg' => __('purchase.payment_added_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            $msg = __('messages.something_went_wrong');
            $output = ['success' => false,
                          'msg' => $msg
                      ];
        }
        return redirect()->back()->with(['status' => $output]);
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
            $inputs = $request->only(['amount','discount_amount', 'method', 'note', 'card_number', 'card_holder_name',
            'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
            'cheque_number', 'bank_account_number']);
            $inputs['paid_on'] = $this->hrmTransactionUtil->uf_date($request->input('paid_on'), true);
            $inputs['amount'] = $this->hrmTransactionUtil->num_uf($inputs['amount']);

         

            if (!empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

            $payment = HrmTransactionPayment::where('method', '!=', 'advance')->findOrFail($id);
            //Update parent payment if exists
            if (!empty($payment->parent_id)) {
                $parent_payment = HrmTransactionPayment::find($payment->parent_id);
                $parent_payment->amount = $parent_payment->amount - ($payment->amount - $inputs['amount']);

                $parent_payment->save();
            }

            $system_settings_id = $request->session()->get('user.system_settings_id');

            $transaction = HrmTransaction::find($payment->hrm_transaction_id);
            $transaction_before = $transaction->replicate();

            $document_name = $this->hrmTransactionUtil->uploadFile($request, 'document', 'documents');
            if (!empty($document_name)) {
                $inputs['document'] = $document_name;
            }
                               
            DB::beginTransaction();

            $payment->update($inputs);

            //update payment status
            $payment_status = $this->hrmTransactionUtil->updatePaymentStatus($payment->hrm_transaction_id);
            $transaction->payment_status = $payment_status;

            //dd($payment);
            if(!empty($payment->parent_id)) {
                $adjust_discount=HrmTransactionPayment::find($payment->parent_id);
                //dd($adjust_discount);
                $payment->amount=$payment->amount-$adjust_discount->discount_amount;
                
            }
            //event
            event(new HrmTransactionPaymentUpdated($payment, $transaction->type));
            DB::commit();


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

                $payment = HrmTransactionPayment::findOrFail($id);
               // dd($payment);
                DB::beginTransaction();

                if (!empty($payment->transaction_id)) {
                    HrmTransactionPayment::deletePayment($payment);
                } else { //advance payment
                    $adjusted_payments = HrmTransactionPayment::where('parent_id', 
                                                $payment->id)
                                                ->get();

                    $total_adjusted_amount = $adjusted_payments->sum('amount');

                    //Get customer advance share from payment and deduct from advance balance
                    if ($payment->method == 'advance_pay') {
                        $total_customer_advance = $payment->amount - $total_adjusted_amount;
                        $employee_details = HrmEmployee::findOrFail($payment->payment_for);
                        $employee_details->advance_amount = $employee_details->advance_amount + $total_customer_advance;
                        $employee_details->save();
                    }

                    //Delete all child payments
                    foreach ($adjusted_payments as $adjusted_payment) {
                        //Make parent payment null as it will get deleted
                        $adjusted_payment->parent_id = null;
                        HrmTransactionPayment::deletePayment($adjusted_payment);
                    }

                    //Delete advance payment
                    HrmTransactionPayment::deletePayment($payment);
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

    public function addEmployeeAdvanceAmountPayment($employee_id){
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $system_settings_id = request()->session()->get('user.system_settings_id');

            $employee = HrmEmployee::findOrFail($employee_id);
            $payment_types = $this->hrmTransactionUtil->payment_types();
            $payment_line=[];

            return view('Hrm\hrm_transaction_payment.post_employee_advance_amount')
                        ->with(compact('employee', 'payment_types','payment_line'));
        }
        
    }
    public function postAdvanceAmount(Request $request)
    {
        try {
            $system_settings_id = $request->session()->get('user.system_settings_id');

            if (!(auth()->user()->can('purchase.payments') || auth()->user()->can('sell.payments') || auth()->user()->can('all_expense.access') || auth()->user()->can('view_own_expense'))) {
                abort(403, 'Unauthorized action.');
            }
                $inputs = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
                'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
                'cheque_number', 'bank_account_number']);
                $inputs['paid_on'] = $this->hrmTransactionUtil->uf_date($request->input('paid_on'), true);
                $inputs['amount'] = $this->hrmTransactionUtil->num_uf($inputs['amount']);
                $inputs['created_by'] = auth()->user()->id;
                $inputs['payment_for'] = $request->input('employee_id');
                $inputs['session_id']=$this->hrmTransactionUtil->getActiveSession();


                $prefix_type = 'employee_advance_payment';
                DB::beginTransaction();

                $ref_count = $this->hrmTransactionUtil->setAndGetReferenceCount($prefix_type, false, true);
                        //Generate reference number
                $inputs['payment_ref_no'] = $this->hrmTransactionUtil->generateReferenceNumber($prefix_type, $ref_count, $system_settings_id);


                //Pay from advance balance
                $payment_amount = $inputs['amount'];
                if (!empty($inputs['amount'])) {
                    $payment = HrmTransactionPayment::create($inputs);
                    $employee_details = HrmEmployee::findOrFail($payment->payment_for);
                    $employee_details->advance_amount = $employee_details->advance_amount + $payment->amount;
                    $employee_details->save();
                }
                
                DB::commit();
            

            $output = ['success' => true,
                            'msg' => __('purchase.payment_added_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            $msg = __('messages.something_went_wrong');
            $output = ['success' => false,
                          'msg' => $msg
                      ];
        }
        return redirect()->back()->with(['status' => $output]);   

    }
}
