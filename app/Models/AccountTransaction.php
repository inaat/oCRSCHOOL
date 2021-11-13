<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FeeTransactionPayment;
class AccountTransaction extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'operation_date',
        'created_at',
        'updated_at'
    ];

    public function media()
    {
        return $this->morphMany(\App\Models\Media::class, 'model');
    }

    // public function transaction()
    // {
    //     return $this->belongsTo(\App\Transaction::class, 'transaction_id');
    // }

    /**
     * Gives account transaction type from payment transaction type
     * @param  string $payment_transaction_type
     * @return string
     */
    public static function getAccountTransactionType($tansaction_type)
    
    {
        
        $account_transaction_types = [
            'fee' => 'credit',
            'opening_balance' => 'credit',
            'purchase' => 'debit',
            'expense' => 'debit',
            'purchase_return' => 'credit',
            'fee_adjustment' => 'debit',
            'payroll' => 'debit',
            'expense_refund' => 'credit'
        ];
        return $account_transaction_types[$tansaction_type];
    }

    /**
     * Creates new account transaction
     * @return obj
     */
    public static function createAccountTransaction($data)
    {
        $transaction_data = [
            'amount' => $data['amount'],
            'account_id' => $data['account_id'],
            'type' => $data['type'],
            'sub_type' => !empty($data['sub_type']) ? $data['sub_type'] : null,
            'operation_date' => !empty($data['operation_date']) ? $data['operation_date'] : \Carbon::now(),
            'created_by' => $data['created_by'],
            'transaction_id' => !empty($data['transaction_id']) ? $data['transaction_id'] : null,
            'transaction_payment_id' => !empty($data['transaction_payment_id']) ? $data['transaction_payment_id'] : null,
            'note' => !empty($data['note']) ? $data['note'] : null,
            'transfer_transaction_id' => !empty($data['transfer_transaction_id']) ? $data['transfer_transaction_id'] : null,
        ];

        $account_transaction = AccountTransaction::create($transaction_data);

        return $account_transaction;
    }

    /**
     * Updates transaction payment from transaction payment
     * @param  obj $transaction_payment
     * @param  array $inputs
     * @param  string $transaction_type
     * @return string
     */
    public static function updateAccountTransaction($transaction_payment, $transaction_type)
    {

        if (!empty($transaction_payment->account_id)) {
            $account_transaction = AccountTransaction::where(
                'transaction_payment_id',
                $transaction_payment->id
            )->first();
            if (!empty($transaction_payment->parent_id)) {
                $payment = FeeTransactionPayment::find($transaction_payment->id);
                $parent_payment = FeeTransactionPayment::find($transaction_payment->parent_id);
                $parent_payment_amount = $parent_payment->amount - ($payment->amount - $transaction_payment->amount);
                $parent_account_transaction = AccountTransaction::where(
                    'transaction_payment_id',
                    $transaction_payment->parent_id)->first();

                    $parent_account_transaction->amount = $parent_payment_amount;
                    $parent_account_transaction->account_id = $transaction_payment->account_id;
                    $parent_account_transaction->save();
                    return $parent_account_transaction;

            } else {
                if (!empty($account_transaction)) {
                    $account_transaction->amount = $transaction_payment->amount;
                    $account_transaction->account_id = $transaction_payment->account_id;
                    $account_transaction->save();
                    return $account_transaction;
                } else {
                    $accnt_trans_data = [
                    'amount' => $transaction_payment->amount,
                    'account_id' => $transaction_payment->account_id,
                    'type' => self::getAccountTransactionType($transaction_type),
                    'operation_date' => $transaction_payment->paid_on,
                    'created_by' => $transaction_payment->created_by,
                    'transaction_id' => $transaction_payment->transaction_id,
                    'transaction_payment_id' => $transaction_payment->id
                ];

                    // //If change return then set type as debit
                    // if ($transaction_payment->transaction->type == 'sell' && $transaction_payment->is_return == 1) {
                    //     $accnt_trans_data['type'] = 'debit';
                    // }

                    self::createAccountTransaction($accnt_trans_data);
                }
            }
        }
    }

    public function transfer_transaction()
    {
        return $this->belongsTo(\App\Models\AccountTransaction::class, 'transfer_transaction_id');
    }

    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_id');
    }
}
