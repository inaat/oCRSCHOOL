<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmDeductionTransactionLine extends Model
{
    use HasFactory;

        /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function hrm_transaction()
    {
        return $this->belongsTo(HrmTransaction::class, 'hrm_transaction_id');
    }

    public function hrm_deduction()
    {
        return $this->belongsTo(HrmDeduction::class, 'deduction_id');
    }
}
