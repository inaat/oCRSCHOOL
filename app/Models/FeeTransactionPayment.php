<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\FeeTransactionPaymentDeleted;
use App\Events\FeeTransactionPaymentUpdated;

class FeeTransactionPayment extends Model
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
        return $this->belongsTo(Account::class, 'account_id');
    }

    /**
     * Get the transaction related to this payment.
     */
    public function fee_transaction()
    {
        return $this->belongsTo(FeeTransaction::class, 'fee_transaction_id');
    }
    public static function deletePayment($payment)
    {
        //Update parent payment if exists
        if (!empty($payment->parent_id)) {
            $parent_payment = FeeTransactionPayment::find($payment->parent_id);
            $parent_payment->amount -= $payment->amount;

            if ($parent_payment->amount <= 0) {
                $parent_payment->delete();
                event(new FeeTransactionPaymentDeleted($parent_payment));
            } else {
                $parent_payment->save();
                //Add event to update parent payment account transaction
                event(new FeeTransactionPaymentUpdated($parent_payment, null));
            }
        }

        $payment->delete();

        if(!empty($payment->fee_transaction_id)) {
            $feeTransactionUtil = new \App\Utils\FeeTransactionUtil();
            //update payment status
            $transaction = $payment->load('fee_transaction')->fee_transaction;
            $transaction_before = $transaction->replicate();

            $payment_status = $feeTransactionUtil->updatePaymentStatus($payment->fee_transaction_id);

            $transaction->payment_status = $payment_status;
            
        }

        //Add event to delete account transaction
        event(new FeeTransactionPaymentDeleted($payment));
        
    }
}
