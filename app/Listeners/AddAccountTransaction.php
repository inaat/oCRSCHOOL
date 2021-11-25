<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\AccountTransaction;

use App\Events\FeeTransactionPaymentAdded;
use App\Utils\FeeTransactionUtil;
class AddAccountTransaction
{
    protected $feeTransactionUtil;

    /**
    * Constructor
    *
    * @param FeeTransactionUtil $feeTransactionUtil
    * @return void
    */
   public function __construct(FeeTransactionUtil $feeTransactionUtil)
   {
       $this->feeTransactionUtil = $feeTransactionUtil;
       
   }
    
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FeeTransactionPaymentAdded $event)
    {
       // echo "<pre>";print_r($event->transactionPayment->toArray());exit;
        // if ($event->transactionPayment->method == 'advance') {
        //     $this->$feeTransactionUtil->updateContactBalance($event->transactionPayment->payment_for, $event->transactionPayment->amount, 'deduct');
        // }

        // if (!$this->moduleUtil->isModuleEnabled('account')) {
        //     return true;
        // }

        // //Create new account transaction
        if (!empty($event->formInput['account_id'])) {
            $account_transaction_data = [
                'amount' => $event->formInput['amount']-$event->formInput['discount_amount'],
                'account_id' => $event->formInput['account_id'],
                'type' => AccountTransaction::getAccountTransactionType($event->formInput['transaction_type']),
                'operation_date' => $event->feeTransactionPayment->paid_on,
                'created_by' => $event->feeTransactionPayment->created_by,
                'transaction_id' => $event->feeTransactionPayment->transaction_id,
                'transaction_payment_id' =>  $event->feeTransactionPayment->id
            ];

            //If change return then set type as debit
            // if ($event->formInput['transaction_type'] == 'sell' && isset($event->formInput['is_return']) && $event->formInput['is_return'] == 1) {
            //     $account_transaction_data['type'] = 'debit';
            // }
             //dd($account_transaction_data);
            AccountTransaction::createAccountTransaction($account_transaction_data);
        }
    }
}

