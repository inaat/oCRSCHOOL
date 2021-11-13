<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    protected $fillable = ['student_id', 'guardian_id'];


    public function student_guardian()
    {
        return $this->hasOne(Guardian::class, 'id', 'guardian_id');
    }
    public function students()
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

}
