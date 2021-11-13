<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\AccountTransaction;


class UpdateAccountTransaction
{
   
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        AccountTransaction::updateAccountTransaction($event->feeTransactionPayment, $event->transactionType);
    }
}
