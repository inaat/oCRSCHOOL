<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    /**
        * The attributes that aren't mass assignable.
        *
        * @var array
        */
    protected $guarded = ['id'];
  /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ref_no_prefixes' => 'array',
        // 'enabled_modules' => 'array',
        'email_settings' => 'array',
        'sms_settings' => 'array',
        'common_settings' => 'array'
        // 'weighing_scale_setting' => 'array'
    ];
    /**
     * Returns the date formats
     */
    public static function date_formats()
    {
        return [
            'd-m-Y' => 'dd-mm-yyyy',
            'm-d-Y' => 'mm-dd-yyyy',
            'd/m/Y' => 'dd/mm/yyyy',
            'm/d/Y' => 'mm/dd/yyyy'
        ];
    }

    /**
     * Get the owner details
     */
    // public function owner()
    // {
    //     return $this->hasOne(\App\Model\User::class, 'id', 'owner_id');
    // }

    /**
     * Get the Business currency.
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }
}
