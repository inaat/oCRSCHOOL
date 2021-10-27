<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


class Session extends Model
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
     * Return list of brands for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($show_none = false ,$passed=false)
    {

        $query = Session::select('id', DB::raw("concat(title, ' - ' '(', status, ') ') as info"))->orderBy('status', 'asc');
        if ($passed) {
            $query->where('status','!=','PASSED');
        }
      
        $sessions=$query->pluck('info', 'id');
        if ($show_none) {
            $sessions->prepend(__('lang.none'), '');
        }
        return $sessions;
    }
}
