<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmAllowanceTransactionLine extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function hrm_transaction()
    {
        return $this->belongsTo(HrmTransaction::class, 'hrm_transaction_id');
    }

    public function hrm_allowance()
    {
        return $this->belongsTo(HrmAllowance::class, 'allowance_id');
    }
}
