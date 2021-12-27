<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTimeTable extends Model
{
    use HasFactory;
    //use SoftDeletes;
    
    protected $guarded = ['id'];
    protected $table = 'class_timetables';
    public function subjects()
    {
        return $this->belongsTo(\App\Models\Curriculum\ClassSubject::class, 'subject_id');
    }
    public function periods()
    {
        return $this->belongsTo(\App\Models\Curriculum\ClassTimeTablePeriod::class, 'period_id');
    }

}
