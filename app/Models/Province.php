<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory;
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
       * Return list of   $provinces for a organization
       *
       * @param int $  $provinces
       * @param boolean $show_none = false
       *
       * @return array
       */
    public static function forDropdown($system_settings_id,$show_none = false,$country_id =null)
    {
        $query=Province::where('system_settings_id',$system_settings_id);

       
        if(!empty($country_id)){
            $query->where('country_id',$country_id);
        }
        

        $provinces=$query->orderBy('id', 'asc')
        ->pluck('name', 'id');
        if ($show_none) {
            $provinces->prepend(__('lang.none'), '');
        }

        return  $provinces;
    }
}