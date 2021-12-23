<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

use App\Models\HumanRM\HrmTransactionPayment;

class HrmTransactionPaymentUpdated
{
    use SerializesModels;

    public $hrmTransactionPayment;

    public $transactionType;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(HrmTransactionPayment $hrmTransactionPayment, $transactionType)
    {
        $this->hrmTransactionPayment = $hrmTransactionPayment;
        $this->transactionType = $transactionType;
    }
}
