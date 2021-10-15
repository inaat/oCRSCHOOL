<?php

namespace App\Utils;

use App\User;
use App\Models\Currency;

use DB;
use GuzzleHttp\Client;
use Spatie\Permission\Models\Role;
use Config;

class Util
{
    public function getDays()
    {
      return [
            'sunday' => __('global_lang.sunday'),
            'monday' => __('global_lang.monday'),
            'tuesday' => __('global_lang.tuesday'),
            'wednesday' => __('global_lang.wednesday'),
            'thursday' => __('global_lang.thursday'),
            'friday' => __('global_lang.friday'),
            'saturday' => __('global_lang.saturday')
        ];
    }
    public function getMonthList()
    {
        $months = array(
            1  => __('global_lang.january'),
            2  => __('global_lang.february'),
            3  => __('global_lang.march'),
            4  => __('global_lang.april'),
            5  => __('global_lang.may'),
            6  => __('global_lang.june'),
            7  => __('global_lang.july'),
            8  => __('global_lang.august'),
            9  => __('global_lang.september'),
            10 => __('global_lang.october'),
            11 => __('global_lang.november'),
            12 => __('global_lang.december'));
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
}
