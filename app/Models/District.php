<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
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
    protected $table_name='districts';
  /**
     * Return list of ClassLevels for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($system_settings_id,$show_none = false,$province_id =null)
    {
        $query=District::where('system_settings_id',$system_settings_id);

       
        if(!empty($province_id)){
            $query->where('province_id',$province_id);
        }
        

        $districts=$query->orderBy('id', 'asc')
        ->pluck('name', 'id');
        if ($show_none) {
            $districts->prepend(__('lang.none'), '');
        }

        return  $districts;
    }
}


