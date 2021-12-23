<?php
namespace App\Utils;

use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;

use App\Models\HumanRM\HrmTransaction;
use App\Models\HumanRM\HrmEmployee;
use App\Models\HumanRM\HrmTransactionPayment;

use App\Events\HrmTransactionPaymentAdded;

class HrmTransactionUtil extends Util
{
  
  

  

    public function payEmployee($request, $format_data = true)
    {
        $employee_id = $request->input('employee_id');
        $system_settings_id = auth()->user()->system_settings_id;
        $inputs = $request->only(['amount', 'discount_amount','method', 'note', 'card_number', 'card_holder_name',
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
        $inputs['payment_for'] = $employee_id;
        $employee = HrmEmployee::findOrFail($employee_id);
        $due_payment_type = 'pay_roll';
        $prefix_type = 'pay_roll_payment';
        $ref_count = $this->setAndGetReferenceCount($prefix_type, false, true);
        //Generate reference number
        $payment_ref_no = $this->generateReferenceNumber($prefix_type, $ref_count, $system_settings_id);

        $inputs['payment_ref_no'] = $payment_ref_no;

        if (!empty($request->input('account_id'))) {
            $inputs['account_id'] = $request->input('account_id');
        }

        //Upload documents if added
        $inputs['document'] = $this->uploadFile($request, 'document', 'documents');
        

        $parent_payment = HrmTransactionPayment::create($inputs);
        $inputs['transaction_type'] = $due_payment_type;
        event(new HrmTransactionPaymentAdded($parent_payment, $inputs));

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
        $types = ['opening_balance', $type];

        $due_transactions = HrmTransaction::where('employee_id', $parent_payment->payment_for)
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
                if ($transaction->type == 'pay_roll' && $transaction->status != 'final') {
                    continue;
                }
                if ($total_amount > 0) {
                    $total_paid = $this->getTotalPaid($transaction->id);
                    $due = $transaction->final_total - $total_paid;

                    $now = \Carbon::now()->toDateTimeString();

                    $array = [
                            'hrm_transaction_id' => $transaction->id,
                            'session_id'=>$this->getActiveSession(),
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

                
                    $prefix_type = 'pay_roll_payment';
                    
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
                HrmTransactionPayment::insert($tranaction_payments);
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
        $total_paid = HrmTransactionPayment::where('hrm_transaction_id', $transaction_id)
                ->select(DB::raw('SUM(IF( is_return = 0, amount, amount*-1))as total_paid'))
                ->first()
                ->total_paid;

        return $total_paid;
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
        HrmTransaction::where('id', $transaction_id)
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
            $final_amount = HrmTransaction::find($transaction_id)->final_total;
        }

        $status = 'due';
        if ($final_amount <= $total_paid) {
            $status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
            $status = 'partial';
        }

        return $status;
    }



    public function getStudentDue($employee_id, $session_id)
    {
        $fee_transaction =HrmTransaction::where('employee_id', $employee_id)
        ->where('session_id','!=',$this->getActiveSession()) ->select(DB::raw('COALESCE(SUM(final_total),0)as total'))
        ->first();
        $query = HrmTransactionPayment::where('payment_for', $employee_id)
        ->where('session_id','!=',$this->getActiveSession()) ->select(DB::raw('COALESCE(SUM(IF( is_return = 0, amount, amount*-1)),0)as total_paid'))
        ->first();
    
        return $fee_transaction->total - $query->total_paid;
    }
}
