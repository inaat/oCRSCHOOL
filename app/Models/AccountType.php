<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function sub_types()
    {
        return $this->hasMany(\App\Models\AccountType::class, 'parent_account_type_id');
    }

    public function parent_account()
    {
        return $this->belongsTo(\App\Models\AccountType::class, 'parent_account_type_id');
    }
}
