<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\AccountTransaction;

use App\Utils\HrmTransactionUtil;

class HrmDeleteAccountTransaction
{
    protected $hrmTransactionUtil;

    /**
     * Constructor
     *
     * @param HrmTransactionUtil $transactionUtil
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
    public function handle($event)
    {
        

        AccountTransaction::where('account_id', $event->hrmTransactionPayment ->account_id)
                        ->where('transaction_payment_id', $event->hrmTransactionPayment ->id)
                        ->delete();
    }
}
