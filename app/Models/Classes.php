<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
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
    protected $table_name = 'classes';
  /**
     * Return list of ClassLevels for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
 
   
    public static function forDropdown($system_settings_id,$show_none = false ,$campus_id=null)
    {
        $query=Classes::where('system_settings_id', $system_settings_id);

        if($campus_id){
            $query->where('campus_id',$campus_id);
        }

        $result = $query->get();

        $classes = $result->pluck('title', 'id');
        if ($show_none) {
            $classes->prepend(__('lang.none'), '');
        }
       
        return $classes;
    }
}


