<?php

namespace App\Utils;

use App\User;
use App\Models\ReferenceCount;
use App\Models\Currency;
use App\Models\SystemSetting;

use DB;
use GuzzleHttp\Client;
use Spatie\Permission\Models\Role;
use Config;

class Util
{
    public function getDays()
    {
      return [
            'sunday' => __('lang.sunday'),
            'monday' => __('lang.monday'),
            'tuesday' => __('lang.tuesday'),
            'wednesday' => __('lang.wednesday'),
            'thursday' => __('lang.thursday'),
            'friday' => __('lang.friday'),
            'saturday' => __('lang.saturday')
        ];
    }
    public function getMonthList()
    {
        $months = array(
            1  => __('lang.january'),
            2  => __('lang.february'),
            3  => __('lang.march'),
            4  => __('lang.april'),
            5  => __('lang.may'),
            6  => __('lang.june'),
            7  => __('lang.july'),
            8  => __('lang.august'),
            9  => __('lang.september'),
            10 => __('lang.october'),
            11 => __('lang.november'),
            12 => __('lang.december'));
        return $months;
    }
       /**
     * Gives a list of all currencies
     *
     * @return array
     */
    public function allCurrencies()
    {
        $currencies = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ') as info"))
                ->orderBy('country')
                ->pluck('info', 'id');

        return $currencies;
    }
     /**
     * Gives a list of all countries
     *
     * @return array
     */
    public function allCountries()
    {
        $countries = Currency::orderBy('country')
                ->pluck('country', 'id');

        return $countries;
    }
     /**
     * Gives a list of all timezone
     *
     * @return array
     */
    public function allTimeZones()
    {
        $datetime = new \DateTimeZone("EDT");

        $timezones = $datetime->listIdentifiers();
        $timezone_list = [];
        foreach ($timezones as $timezone) {
            $timezone_list[$timezone] = $timezone;
        }

        return $timezone_list;
    }
      /**
     * Uploads document to the server if present in the request
     * @param obj $request, string $file_name, string dir_name
     *
     * @return string
     */
    public function uploadFile($request, $file_name, $dir_name, $file_type = 'document')
    {
        //If app environment is demo return null
        if (config('app.env') == 'demo') {
            return null;
        }
        
        $uploaded_file_name = null;
        if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {
            
            //Check if mime type is image
            if ($file_type == 'image') {
                if (strpos($request->$file_name->getClientMimeType(), 'image/') === false) {
                    throw new \Exception("Invalid image file");
                }
            }

            if ($file_type == 'document') {
                if (!in_array($request->$file_name->getClientMimeType(), array_keys(config('constants.document_upload_mimes_types')))) {
                    throw new \Exception("Invalid document file");
                }
            }
            
            if ($request->$file_name->getSize() <= config('constants.document_size_limit')) {
                $new_file_name = time() . '_' . $request->$file_name->getClientOriginalName();
                if ($request->$file_name->storeAs($dir_name, $new_file_name)) {
                    $uploaded_file_name = $new_file_name;
                }
            }
        }

        return $uploaded_file_name;
    }
       /**
     * Converts date in System Details format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return string
     */
    public function uf_date($date, $time = false)
    {
        $date_format = session('system_details.date_format');
        $mysql_format = 'Y-m-d';
        if ($time) {
            if (session('system_details.time_format') == 12) {
                $date_format = $date_format . ' h:i A';
            } else {
                $date_format = $date_format . ' H:i';
            }
            $mysql_format = 'Y-m-d H:i:s';
        }

        return !empty($date_format) ? \Carbon::createFromFormat($date_format, $date)->format($mysql_format) : null;
    }

    /**
     * This function unformats a number and returns them in plain eng format
     *
     * @param int $input_number
     *
     * @return float
     */
    public function num_uf($input_number, $currency_details = null)
    {
        $thousand_separator  = '';
        $decimal_separator  = '';

        if (!empty($currency_details)) {
            $thousand_separator = $currency_details->thousand_separator;
            $decimal_separator = $currency_details->decimal_separator;
        } else {
            $thousand_separator = session()->has('currency') ? session('currency')['thousand_separator'] : '';
            $decimal_separator = session()->has('currency') ? session('currency')['decimal_separator'] : '';
        }

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }
     /**
     * Converts date in mysql format to business format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function format_date($date, $show_time = false, $system_details = null)
    {
        $format = !empty($system_details) ? $system_details->date_format : session('system_details.date_format');
        if (!empty($show_time)) {
            $time_format = !empty($system_details) ? $system_details->time_format : session('system_details.time_format');
            if ($time_format == 12) {
                $format .= ' h:i A';
            } else {
                $format .= ' H:i';
            }
        }
        
        return !empty($date) ? \Carbon::createFromTimestamp(strtotime($date))->format($format) : null;
    }



    /**
     * Increments reference count for a given type and given business
     * and gives the updated reference count
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    public function setAndGetReferenceCount($type, $before = false, $after = false)
    {
       
        $system_settings_id = session()->get('user.system_settings_id');

        $ref = ReferenceCount::where('ref_type', $type)
                          ->where('system_settings_id', $system_settings_id)
                          ->first();
        if (!empty($ref)) {
            if($before){
                $ref->ref_count += 1;
                return $ref->ref_count;
            }
            if($after){
                $ref->ref_count += 1;
                $ref->save();
                return $ref->ref_count;
            }
            
        } else {
            $new_ref = ReferenceCount::create([
                'ref_type' => $type,
                'system_settings_id' => $system_settings_id,
                'system_settings_id' => $system_settings_id,
                'ref_count' => 1
            ]);
            return $new_ref->ref_count;
        }
    }
     /**
     * Increments reference count for a given type and given business
     * and gives the updated reference count
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    public function setAndGetRollNoCount($type, $before = false, $after = false ,$session_id)
    {
       
        $system_settings_id = session()->get('user.system_settings_id');
        $ref = ReferenceCount::where('ref_type', $type)
                          ->where('system_settings_id', $system_settings_id)
                         ->where('session_close','=','open')
                          ->where('session_id','=',$session_id)
                          ->first();
        //dd($ref);
        if (!empty($ref)) {

            if($before){
                $ref->ref_count += 1;
                return $ref->ref_count;
            }
            if($after){
                $ref->ref_count += 1;
                $ref->save();
                return $ref->ref_count;
            }
            
        }
    }

     /**
     * Generates reference number
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    public function generateReferenceNumber($type, $ref_count, $system_settings_id = null, $default_prefix = null)
    {
        $prefix = '';
        $system_settings_id = session()->get('user.system_settings_id');

        if (session()->has('system_details') && !empty(request()->session()->get('system_details.ref_no_prefixes')[$type])) {
            $prefix = request()->session()->get('system_details.ref_no_prefixes')[$type];
        }
        if (!empty($system_settings_id )) {
            $system_details = SystemSetting::find($system_settings_id);
            $prefixes = $system_details->ref_no_prefixes;
            $prefix = !empty($prefixes[$type]) ? $prefixes[$type] : '';
        }

        if (!empty($default_prefix)) {
            $prefix = $default_prefix;
        }

        $ref_digits =  str_pad($ref_count, 4, 0, STR_PAD_LEFT);
        if($type == 'roll_no'){
            $ref_number = $prefix .'-'. $ref_digits;

        }else{
            if (!in_array($type, ['admission_no'])) {
                $ref_year = \Carbon::now()->year;
                $ref_number = $prefix .'-'. $ref_year . '-' . $ref_digits;
            } else {
                $ref_number = $prefix . $ref_digits;
            }
        }
        

        return $ref_number;
    }
}
