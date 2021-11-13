<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{ use HasFactory;
    use SoftDeletes;

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
     * Return list of Regions for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($system_settings_id,$show_none = false,$city_id =null)
    {
        $query=Region::where('system_settings_id',$system_settings_id);

       
        if(!empty($city_id)){
            $query->where('city_id',$city_id);
        }
        

        $regions=$query->orderBy('id', 'asc')
        ->pluck('name', 'id');
        if ($show_none) {
            $regions->prepend(__('lang.none'), '');
        }

        return  $regions;
    }
}
