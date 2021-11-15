<?php
namespace App\Utils;

use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;

use App\Models\FeeTransaction;
use App\Models\FeeTransactionLine;
use App\Models\Student;
use App\Models\FeeTransactionPayment;

use App\Events\FeeTransactionPaymentAdded;

class FeeTransactionUtil extends Util
{
    public function createFeeTransaction($request, $type)
    {
        $user_id = $request->session()->get('user.id');
        $system_settings_id = $request->session()->get('user.system_settings_id');
        $final_total =  $this->num_uf($request->final_total);
        $now = \Carbon::now();
        //Update reference count
        
        $ob_ref_count = $this->setAndGetReferenceCount('challan', false, true);
        $transaction = FeeTransaction::create([
                    'system_settings_id' => $system_settings_id,
                    'campus_id' => $request->campus_id,
                    'type' => $type,
                    'status' => 'final',
                    'payment_status' => 'due',
                    'voucher_no'=> $this->generateReferenceNumber('challan', $ob_ref_count, $system_settings_id),
                    'session_id'=>$this-> getActiveSession(),
                    'class_id'=>$request->class_id,
                    'class_section_id'=>$request->class_section_id,
                    'month' => $now->month,
                    'student_id' => $request->student_id,
                    'transaction_date' =>$now,
                    'final_total' => $final_total,
                    'created_by' => $user_id,
                ]);
           
        return $transaction;
    }
    public function multiFeeTransaction($student, $type, $system_settings_id, $user_id, $lines_formatted, $final_total, $discount, $month)
    {
        $final_total =  $this->num_uf($final_total);
        $now = \Carbon::now();
        //Update reference count
        
        $ob_ref_count = $this->setAndGetReferenceCount('challan', false, true);
        $transaction = FeeTransaction::create([
                    'system_settings_id' => $system_settings_id,
                    'campus_id' => $student->campus_id,
                    'type' => $type,
                    'status' => 'final',
                    'payment_status' => 'due',
                    'voucher_no'=> $this->generateReferenceNumber('challan', $ob_ref_count, $system_settings_id),
                    'session_id'=>$this-> getActiveSession(),
                    'class_id'=>$student->current_class_id,
                    'class_section_id'=>$student->current_class_section_id,
                    'month' => $month,
                    'discount_type' => !empty($discount->discount_type) ? $discount->discount_type : null,
                    'discount_amount' => !empty($discount->discount_amount) ? $discount->discount_amount: 0,
                    'student_id' => $student->id,
                    'transaction_date' =>$now,
                    'final_total' => $final_total,
                    'created_by' => $user_id,
                ]);
        if (!empty($lines_formatted)) {
            $transaction->fee_lines()->saveMany($lines_formatted);
        }
        return $transaction;
    }

    public function createFeeTransactionLines($fee_heads, $transaction)
    {
        $lines_formatted = [];

        foreach ($fee_heads as $key => $value) {
            # code...

            if (!empty($value['is_enabled'])) {
                $line=[
                       'fee_head_id'=>$value['fee_head_id'],
                       'amount'=>$this->num_uf($value['amount'])
                   ];
               
                $lines_formatted[]=new FeeTransactionLine($line);
            }
        }

        if (!empty($lines_formatted)) {
            $transaction->fee_lines()->saveMany($lines_formatted);
        }
    }
    public function getFinalWithoutDiscount($fee_heads, $discount)
    {
        $final_total =0;

        foreach ($fee_heads as $key => $value) {
            $final_total +=$value['amount'];
        }
        if (!empty($discount)) {
            if ($discount->discount_type == 'fixed') {
                $final_total -= $discount->discount_amount;
            } else {
                $final_total = $final_total-(($discount->discount_amount/100)*$final_total);
            }
        }
        return $final_total;
    }

    public function payStudent($request, $format_data = true)
    {
        $student_id = $request->input('student_id');
        $system_settings_id = auth()->user()->system_settings_id;
        $inputs = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
            'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
            'cheque_number', 'bank_account_number']);

        $payment_types = $this->payment_types();
        $inputs['session_id']=$this->getActiveSession();

        if (!array_key_exists($inputs['method'], $payment_types)) {
            throw new \Exception("Payment method not found");
        }
        $inputs['paid_on'] = $request->input('paid_on', \Carbon::now()->toDateTimeString());
        if ($format_data) {
            $inputs['paid_on'] = $this->uf_date($inputs['paid_on'], true);
            $inputs['amount'] = $this->num_uf($inputs['amount']);
        }
        
        $inputs['created_by'] = auth()->user()->id;
        $inputs['payment_for'] = $student_id;
        $inputs['system_settings_id'] = $system_settings_id;
        $student = Student::where('system_settings_id', $system_settings_id)
                        ->findOrFail($student_id);
        $due_payment_type = 'fee';
        $prefix_type = 'fee_payment';
        $ref_count = $this->setAndGetReferenceCount($prefix_type, false, true);
        //Generate reference number
        $payment_ref_no = $this->generateReferenceNumber($prefix_type, $ref_count, $system_settings_id);

        $inputs['payment_ref_no'] = $payment_ref_no;

        if (!empty($request->input('account_id'))) {
            $inputs['account_id'] = $request->input('account_id');
        }

        //Upload documents if added
        $inputs['document'] = $this->uploadFile($request, 'document', 'documents');
        

        $parent_payment = FeeTransactionPayment::create($inputs);
        $inputs['transaction_type'] = $due_payment_type;
        event(new FeeTransactionPaymentAdded($parent_payment, $inputs));

        //Distribute above payment among unpaid transactions
        $excess_amount = $this->payAtOnce($parent_payment, $due_payment_type);
        //Update excess amount
        // if (!empty($excess_amount)) {
        //     $this->updatestudentBalance($student, $excess_amount);
        // }

        return $parent_payment;
    }
    /**
     * Pay student due at once
     *
     * @param obj $parent_payment, string $type
     *
     * @return void
     */
    public function payAtOnce($parent_payment, $type)
    {

        //Get all unpaid transaction for the student
        $types = ['opening_balance','admission_fee', $type];

        $due_transactions = FeeTransaction::where('student_id', $parent_payment->payment_for)
                                ->whereIn('type', $types)
                                ->where('payment_status', '!=', 'paid')
                                ->orderBy('transaction_date', 'asc')
                                ->get();

        $total_amount = $parent_payment->amount;

        $tranaction_payments = [];
        if ($due_transactions->count()) {
            foreach ($due_transactions as $transaction) {
                $transaction_before = $transaction->replicate();
                //If sell check status is final
                if ($transaction->type == 'fee' && $transaction->status != 'final') {
                    continue;
                }
                if ($total_amount > 0) {
                    $total_paid = $this->getTotalPaid($transaction->id);
                    $due = $transaction->final_total - $total_paid;

                    $now = \Carbon::now()->toDateTimeString();

                    $array = [
                            'fee_transaction_id' => $transaction->id,
                            'session_id'=>$this->getActiveSession(),
                            'system_settings_id' => $parent_payment->system_settings_id,
                            'method' => $parent_payment->method,
                            'transaction_no' => $parent_payment->method,
                            'card_transaction_number' => $parent_payment->card_transaction_number,
                            'card_number' => $parent_payment->card_number,
                            'card_type' => $parent_payment->card_type,
                            'card_holder_name' => $parent_payment->card_holder_name,
                            'card_month' => $parent_payment->card_month,
                            'card_year' => $parent_payment->card_year,
                            'card_security' => $parent_payment->card_security,
                            'cheque_number' => $parent_payment->cheque_number,
                            'bank_account_number' => $parent_payment->bank_account_number,
                            'paid_on' => $parent_payment->paid_on,
                            'created_by' => $parent_payment->created_by,
                            'payment_for' => $parent_payment->payment_for,
                            'parent_id' => $parent_payment->id,
                            'created_at' => $now,
                            'updated_at' => $now
                        ];

                
                    $prefix_type = 'fee_payment';
                    
                    $ref_count = $this->setAndGetReferenceCount($prefix_type, false, true);
                    //Generate reference number
                    $payment_ref_no = $this->generateReferenceNumber($prefix_type, $ref_count, $parent_payment->system_settings_id);
                    $array['payment_ref_no'] = $payment_ref_no;

                    if ($due <= $total_amount) {
                        $array['amount'] = $due;
                        $tranaction_payments[] = $array;

                        //Update transaction status to paid
                        $transaction->payment_status = 'paid';
                        $transaction->save();

                        $total_amount = $total_amount - $due;

                    //$this->activityLog($transaction, 'payment_edited', $transaction_before);
                    } else {
                        $array['amount'] = $total_amount;
                        $tranaction_payments[] = $array;

                        //Update transaction status to partial
                        $transaction->payment_status = 'partial';
                        $transaction->save();
                        $total_amount = 0;
                        //$this->activityLog($transaction, 'payment_edited', $transaction_before);
                        
                        break;
                    }
                }
            }

            //Insert new transaction payments
            if (!empty($tranaction_payments)) {
                FeeTransactionPayment::insert($tranaction_payments);
            }
        }
        return $total_amount;
    }
    /**
     * Get total paid amount for a transaction
     *
     * @param int $transaction_id
     *
     * @return int
     */
    public function getTotalPaid($transaction_id)
    {
        $total_paid = FeeTransactionPayment::where('fee_transaction_id', $transaction_id)
                ->select(DB::raw('SUM(IF( is_return = 0, amount, amount*-1))as total_paid'))
                ->first()
                ->total_paid;

        return $total_paid;
    }

    /**
    * common function to get
    * list sell
    * @param int $system_settings_id
    *
    * @return object
    */
    public function getListSells($system_settings_id)
    {
        $sells = FeeTransaction::leftJoin('students', 'fee_transactions.student_id', '=', 'students.id')
           
                ->leftJoin('users as u', 'fee_transactions.created_by', '=', 'u.id')
                ->leftJoin('classes as c-class', 'students.current_class_id', '=', 'c-class.id')
                ->leftJoin('sessions', 'fee_transactions.session_id', '=', 'sessions.id')
                ->join(
                    'campuses AS campus',
                    'fee_transactions.campus_id',
                    '=',
                    'campus.id'
                )
                ->where('fee_transactions.system_settings_id', $system_settings_id)
                ->where('fee_transactions.status', 'final')
                ->select(
                    'fee_transactions.id',
                    'fee_transactions.transaction_date',
                    'fee_transactions.voucher_no',
                    'fee_transactions.payment_status',
                    'fee_transactions.final_total',
                    'c-class.title as current_class',
                    'students.father_name',
                    'students.roll_no',
                    'students.status',
                    DB::raw("concat(sessions.title, ' - ' '(', sessions.status, ') ') as session_info"),
                    DB::raw("CONCAT(COALESCE(students.first_name, ''),' ',COALESCE(students.last_name,'')) as student_name"),
                    DB::raw('DATE_FORMAT(fee_transactions.transaction_date, "%Y/%m/%d") as fee_transaction_date'),
                    DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by"),
                    DB::raw('(SELECT SUM(IF(TP.is_return = 1,-1*TP.amount,TP.amount)) FROM fee_transaction_payments AS TP WHERE
                        TP.fee_transaction_id=fee_transactions.id) as total_paid'),
                    'campus.campus_name as campus_name',
                )->orderBy('fee_transactions.transaction_date', 'desc');

        return $sells;
    }
    /**
     * Update the payment status for purchase or sell transactions. Returns
     * the status
     *
     * @param int $transaction_id
     *
     * @return string
     */
    public function updatePaymentStatus($transaction_id, $final_amount = null)
    {
        $status = $this->calculatePaymentStatus($transaction_id, $final_amount);
        FeeTransaction::where('id', $transaction_id)
            ->update(['payment_status' => $status]);

        return $status;
    }
    /**
     * Calculates the payment status and returns back.
     *
     * @param int $transaction_id
     * @param float $final_amount = null
     *
     * @return string
     */
    public function calculatePaymentStatus($transaction_id, $final_amount = null)
    {
        $total_paid = $this->getTotalPaid($transaction_id);
        if (is_null($final_amount)) {
            $final_amount = FeeTransaction::find($transaction_id)->final_total;
        }

        $status = 'due';
        if ($final_amount <= $total_paid) {
            $status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
            $status = 'partial';
        }

        return $status;
    }



    public function getStudentDue($student_id, $session_id)
    {
        $fee_transaction =FeeTransaction::where('student_id', $student_id)
        ->where('session_id','!=',$this->getActiveSession()) ->select(DB::raw('COALESCE(SUM(final_total),0)as total'))
        ->first();
        $query = FeeTransactionPayment::where('payment_for', $student_id)
        ->where('session_id','!=',$this->getActiveSession()) ->select(DB::raw('COALESCE(SUM(IF( is_return = 0, amount, amount*-1)),0)as total_paid'))
        ->first();
    
        return $fee_transaction->total - $query->total_paid;
    }
}
