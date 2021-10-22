<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
       /**
        * The attributes that aren't mass assignable.
        *
        * @var array
        */
        protected $guarded = ['id'];

        public static function forDropdown($show_none = false)
        {
    
            $campuses=Campus::orderBy('campus_name', 'asc')
                        ->pluck('campus_name', 'id');
    
            if ($show_none) {
                $campuses->prepend(__('global_lang.none'), '');
            }
    
            return $campuses;
        }
}
