<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\HrmTransactionPaymentDeleted;
use App\Events\HrmTransactionPaymentUpdated;

class HrmTransactionPayment extends Model
{
    use HasFactory;
    

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

        /**
     * Get the phone record associated with the user.
     */
    public function payment_account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_id');
    }

    /**
     * Get the transaction related to this payment.
     */
    public function hrm_transaction()
    {
        return $this->belongsTo(HrmTransaction::class, 'hrm_transaction_id');
    }
    public static function deletePayment($payment)
    {
        //Update parent payment if exists
        if (!empty($payment->parent_id)) {
            $parent_payment = HrmTransactionPayment::find($payment->parent_id);
            $parent_payment->amount -= $payment->amount;

            if ($parent_payment->amount <= 0) {
                $parent_payment->delete();
                event(new HrmTransactionPaymentDeleted($parent_payment));
            } else {
                $parent_payment->save();
                //Add event to update parent payment account transaction
                event(new HrmTransactionPaymentUpdated($parent_payment, null));
            }
        }

        $payment->delete();

        if(!empty($payment->hrm_transaction_id)) {
            $hrmTransactionUtil = new \App\Utils\HrmTransactionUtil();
            //update payment status
            $transaction = $payment->load('hrm_transaction')->hrm_transaction;
            $transaction_before = $transaction->replicate();

            $payment_status = $hrmTransactionUtil->updatePaymentStatus($payment->hrm_transaction_id);

            $transaction->payment_status = $payment_status;
            
        }

        //Add event to delete account transaction
        event(new HrmTransactionPaymentDeleted($payment));
        
    }
}
