<?php

namespace App\Models\HRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrmShift extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
       /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'holidays' => 'array',
    ];
}
