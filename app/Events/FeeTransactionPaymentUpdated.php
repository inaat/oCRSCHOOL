<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

use App\Models\FeeTransactionPayment;

class FeeTransactionPaymentUpdated
{
    use SerializesModels;

    public $feeTransactionPayment;

    public $transactionType;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FeeTransactionPayment $feeTransactionPayment, $transactionType)
    {
        $this->feeTransactionPayment = $feeTransactionPayment;
        $this->transactionType = $transactionType;
    }
}
