<?php

namespace App\Utils;

use App\Models\Account;

class AccountTransactionUtil extends Util
{

    /**
     * Updates tax amount of a tax group
     *
     * @param int $group_tax_id
     *
     * @return void
     */
    // public function updateGroupTaxAmount($group_tax_id)
    // {
    //     $amount = 0;
    //     $tax_rate = TaxRate::where('id', $group_tax_id)->with(['sub_taxes'])->first();
    //     foreach ($tax_rate->sub_taxes as $sub_tax) {
    //         $amount += $sub_tax->amount;
    //     }
    //     $tax_rate->amount = $amount;
    //     $tax_rate->save();
    // }
    /**
     * Updates tax amount of a tax group
     *
     * @param int $group_tax_id
     *
     * @return void
     */
    public function create_Account($campus_name,$user_id,$account_number,$system_settings_id){
        $ob_account_data = [
            'name' =>$campus_name.'Fee collector',
            'account_number' => $account_number,
            'system_settings_id' => $system_settings_id,
            'created_by' => $user_id
        ];

        $account = Account::create($ob_account_data);

        return $account;

    }
}
