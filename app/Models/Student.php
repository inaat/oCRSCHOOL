<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Student extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
        * The attributes that aren't mass assignable.
        *
        * @var array
        */
        protected $guarded = ['id'];

    public function guardian()
    {
        return $this->hasOne(StudentGuardian::class, 'student_id', 'id');
    }
    public function campuses()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }

    public static function forDropdown($system_settings_id,$show_none = false,$class_id =null,$section_id =null)
    {
        // $query=Student::where('system_settings_id',$system_settings_id);
        $query = Student::select('id', DB::raw("concat(first_name,' ',last_name ,'  ', '(',roll_no,')') as info"));

       
        if(!empty($class_id)){
            $query->where('current_class_id',$class_id);
        }
        if(!empty($section_id)){
            $query->where('current_class_section_id',$section_id);
        }
        

        $students=$query->orderBy('id', 'asc')
        ->pluck('info', 'id');
        if ($show_none) {
            $students->prepend(__('lang.none'), '');
        }

        return  $students;
    }
}
