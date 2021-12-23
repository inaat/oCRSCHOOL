<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmDesignation extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
    /**
     * Return list of HrmDesignation for a business
     *
     * 
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($show_none = false)
    {
        $query=HrmDesignation::orderBy('id', 'asc')
        ->pluck('designation', 'id');

       
        

        $designations=$query;
        if ($show_none) {
            $designations->prepend(__('lang.none'), '');
        }

        return  $designations;
    }
}
