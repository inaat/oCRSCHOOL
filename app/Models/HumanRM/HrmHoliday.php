<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmHoliday extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
}
