<?php

namespace App\Models\HumanRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmDeduction extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
    /**
     * Return list of HrmDeduction for a business
     *
     * 
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($show_none = false)
    {
        $query=HrmDeduction::orderBy('id', 'asc')
        ->pluck('deduction', 'id');

       
        

        $deductions=$query;
        if ($show_none) {
            $deductions->prepend(__('lang.none'), '');
        }

        return  $deductions;
    }
}
