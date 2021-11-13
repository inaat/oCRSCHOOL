<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Discount extends Model
{
    use HasFactory;
       /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
      /**
     * Return list of dis$discounts for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($system_settings_id=null,$show_none = false)
    {
      // DB::raw("IF(discount_type = 'fixed','','%') as infos"))->orderBy('id', 'asc');

      $query = Discount::select('id', DB::raw("concat(discount_name, ' - ' '(', FORMAT(discount_amount,2), ') ', IF(discount_type = 'fixed','','%')) as info"),)->orderBy('id', 'asc');
      $discounts=$query->pluck('info', 'id');

        if ($show_none) {
            $discounts->prepend(__('lang.none'), '');
        }

        return $discounts;
    }

  
}
