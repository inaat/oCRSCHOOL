<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSection extends Model
{    use HasFactory;
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
    public function classes()
    {
        return $this->belongsTo(\App\Models\Classes::class, 'class_id');
    }
    public function campuses()
    {
        return $this->belongsTo(\App\Models\Campus::class, 'campus_id');
    }
    public function time_table()
    {
        return $this->hasMany(\App\Models\Curriculum\ClassTimeTable::class, 'class_section_id');
    }
    
  /**
     * Return list of ClassLevels for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($system_settings_id,$show_none = false ,$class_id=null)
    {
        $query=ClassSection::where('system_settings_id', $system_settings_id);
        
        if($class_id){
            $query->where('class_id',$class_id);
        }
        $sections=$query->pluck('section_name', 'id');

        if ($show_none) {
            $sections->prepend(__('lang.none'), '');
        }
       
      
        return $sections;
    }
}