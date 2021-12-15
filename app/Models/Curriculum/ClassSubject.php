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
    // public static function forDropdown($show_none = false)
    // {
    //     $query=HrmAllowance::orderBy('id', 'asc')
    //     ->pluck('allowance', 'id');

       
        

    //     $allowances=$query;
    //     if ($show_none) {
    //         $allowances->prepend(__('lang.none'), '');
    //     }

    //     return  $allowances;
    // }
}
