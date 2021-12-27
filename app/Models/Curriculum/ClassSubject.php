<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSubject extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
    /**
     * Return list of ClassSubject for a business
     *
     * 
     * @param boolean $show_none = false
     *
     * @return array
     */
    public function classes()
    {
        return $this->belongsTo(\App\Models\Classes::class, 'class_id');
    }
    public function employees()
    {
        return $this->belongsTo(\App\Models\HumanRM\HrmEmployee::class, 'teacher_id');
    }
    
    public static function forDropdown($class_id,$show_none = false)
    {
        $query=ClassSubject::orderBy('id', 'asc')->where('class_id',$class_id)
        ->pluck('name', 'id');
        $subjects=$query;
        if ($show_none) {
            $subjects->prepend(__('lang.none'), '');
        }

        return  $subjects;
    }
}
