<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{

    use HasFactory;
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
     * Return list of Designations for a business
     *
     * @param int $system_settings_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($show_none = false)
    {

        $session=Designation::orderBy('title', 'asc')
                    ->pluck('title', 'id');

        if ($show_none) {
            $session->prepend(__('lang.none'), '');
        }

        return $session;
    }
}
