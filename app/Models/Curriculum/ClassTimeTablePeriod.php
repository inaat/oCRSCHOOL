<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTimeTablePeriod extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
    protected $table = 'class_timetable_periods';

     /**
       * Return list of   $ClassTimeTablePeriod for a organization
       *
       * @param int $  $ClassTimeTablePeriod
       * @param boolean $show_none = false
       *
       * @return array
       */
      public static function forDropdown($campus_id,$show_none = false)
      {
          $query=ClassTimeTablePeriod::where('campus_id',$campus_id);
          
          $periods=$query->orderBy('id', 'asc')
          ->pluck('name', 'id');
          if ($show_none) {
              $periods->prepend(__('lang.none'), '');
          }
  
          return  $periods;
      }

}
