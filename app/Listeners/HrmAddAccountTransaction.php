<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\AccountTransaction;

use App\Events\HrmTransactionPaymentAdded;
use App\Utils\HrmTransactionUtil;
class HrmAddAccountTransaction
{
    protected $hrmTransactionUtil;

    /**
    * Constructor
    *
    * @param HrmTransactionUtil $hrmTransactionUtil
    * @return void
    */
   public function __construct(HrmTransactionUtil $hrmTransactionUtil)
   {
       $this->hrmTransactionUtil = $hrmTransactionUtil;
       
   }
    
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(HrmTransactionPaymentAdded $event)
    {
       

        // //Create new account transaction
        if (!empty($event->formInput['account_id'])) {
            $account_transaction_data = [
                'amount' => $event->formInput['amount']-$event->formInput['discount_amount'],
                'account_id' => $event->formInput['account_id'],
                'type' => AccountTransaction::getAccountTransactionType($event->formInput['transaction_type']),
                'operation_date' => $event->hrmTransactionPayment->paid_on,
                'created_by' => $event->hrmTransactionPayment->created_by,
                'transaction_id' => $event->hrmTransactionPayment->transaction_id,
                'hrm_transaction_payment_id' =>  $event->hrmTransactionPayment->id
            ];

            //If change return then set type as debit
            // if ($event->formInput['transaction_type'] == 'sell' && isset($event->formInput['is_return']) && $event->formInput['is_return'] == 1) {
            //     $account_transaction_data['type'] = 'debit';
            // }
            AccountTransaction::hrmCreateAccountTransaction($account_transaction_data);
        }
    }
}

