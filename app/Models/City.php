<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{  use HasFactory;
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
    protected $table_name='cities';
   /**
     * Return list of ClassLevels for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($system_settings_id,$show_none = false,$district_id =null)
    {
        $query=City::where('system_settings_id',$system_settings_id);

       
        if(!empty($district_id)){
            $query->where('district_id',$district_id);
        }
        

        $cities=$query->orderBy('id', 'asc')
        ->pluck('name', 'id');
        if ($show_none) {
            $cities->prepend(__('lang.none'), '');
        }

        return  $cities;
    }
}
