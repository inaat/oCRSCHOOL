<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class FeeTransactionPaymentDeleted
{
    use SerializesModels;

    public $transactionPaymentId;

    public $accountId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($feeTransactionPayment)
    {
        $this->feeTransactionPayment = $feeTransactionPayment;
    }
}
