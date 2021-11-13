<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeTransaction extends Model
{
    use HasFactory;



    protected $guarded = ['id'];



    public function fee_lines()
    {
        return $this->hasMany(FeeTransactionLine::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // public function payment_lines()
    // {
    //     return $this->hasMany(TransactionPayment::class, 'transaction_id');
    // }

    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function create_person()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getPaymentStatus($transaction)
    {
        $payment_status = $transaction->payment_status;

        // if (in_array($payment_status, ['partial', 'due']) && !empty($transaction->pay_term_number) && !empty($transaction->pay_term_type)) {
        //     $transaction_date = \Carbon::parse($transaction->transaction_date);
        //     $due_date = $transaction->pay_term_type == 'days' ? $transaction_date->addDays($transaction->pay_term_number) : $transaction_date->addMonths($transaction->pay_term_number);
        //     $now = \Carbon::now();
        //     if ($now->gt($due_date)) {
        //         $payment_status = $payment_status == 'due' ? 'overdue' : 'partial-overdue';
        //     }
        // }

        return $payment_status;
    }

}
