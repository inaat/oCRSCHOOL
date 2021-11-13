<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\AccountTransaction;

use App\Utils\FeeTransactionUtil;

class DeleteAccountTransaction
{
    protected $feeTransactionUtil;

    /**
     * Constructor
     *
     * @param FeeTransactionUtil $transactionUtil
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
    public function handle($event)
    {
        // //Add contact advance if exists
        // if ($event->transactionPayment->method == 'advance') {
        //     $this->transactionUtil->updateContactBalance($event->transactionPayment->payment_for, $event->transactionPayment->amount);
        // }


        AccountTransaction::where('account_id', $event->feeTransactionPayment ->account_id)
                        ->where('transaction_payment_id', $event->feeTransactionPayment ->id)
                        ->delete();
    }
}
