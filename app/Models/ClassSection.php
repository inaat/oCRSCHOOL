<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSection extends Model
{    use HasFactory;
     use SoftDeletes;

        /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
  /**
     * Return list of ClassLevels for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($system_settings_id,$show_none = false ,$check_permission = false)
    {
        $query=ClassSection::where('system_settings_id', $system_settings_id);

        if ($check_permission) {
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('id', $permitted_locations);
            }
        }
        if ($show_none) {
            $query->prepend(__('global_lang.none'), '');
        }
       
        $result = $query->get();

        $classes = $result->pluck('title', 'id');
        return $classes;
    }
}