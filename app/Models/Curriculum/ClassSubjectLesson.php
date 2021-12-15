<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSubjectLesson extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
   /**
       * Return list of   $ClassSubjectLesson for a organization
       *
       * @param int $  $ClassSubjectLesson
       * @param boolean $show_none = false
       *
       * @return array
       */
      public static function forDropdown($subject_id,$chapter_number,$show_none = false)
      {
          $query=ClassSubjectLesson::where('subject_id',$subject_id);
  
          if(!empty($chapter_number)){
              $query->where('chapter_number',$chapter_number);
          }
          
  
          $lessons=$query->orderBy('id', 'asc')
          ->pluck('name', 'id');
          if ($show_none) {
              $lessons->prepend(__('lang.none'), '');
          }
  
          return  $lessons;
      }
  }

