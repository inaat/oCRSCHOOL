<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HrmDepartment extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];


    /**
     * Return list of HrmDepartment for a business
     *
     * 
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($show_none = false)
    {
        $query=HrmDepartment::orderBy('id', 'asc')
        ->pluck('department', 'id');

       
        

        $departments=$query;
        if ($show_none) {
            $departments->prepend(__('lang.none'), '');
        }

        return  $departments;
    }
}

