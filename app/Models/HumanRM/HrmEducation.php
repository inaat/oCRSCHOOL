<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmEducation extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];

    /**
     * Return list of HrmEducation for a business
     *
     * 
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($show_none = false)
    {
        $query=HrmEducation::orderBy('id', 'asc')
        ->pluck('education', 'id');

       
        

        $educations=$query;
        if ($show_none) {
            $educations->prepend(__('lang.none'), '');
        }

        return  $educations;
    }
}
