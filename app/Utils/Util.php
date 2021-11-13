<?php

namespace App\Utils;

use App\User;
use App\Models\ReferenceCount;
use App\Models\Currency;
use App\Models\SystemSetting;
use App\Models\FeeHead;
use App\Models\Session;
use App\Models\Account;

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
    public function uploadFile($request, $file_name, $dir_name, $file_type = 'document',$roll_file_name=null)
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
                if(!empty($roll_file_name)){
                    $new_file_name = $roll_file_name.'.'. $request->$file_name->getClientOriginalExtension();
                    if ($request->$file_name->storeAs($dir_name, $new_file_name)) {
                        $uploaded_file_name = $new_file_name;
                    }
                }else{
                $new_file_name = time() . '_' . $request->$file_name->getClientOriginalName();
                if ($request->$file_name->storeAs($dir_name, $new_file_name)) {
                    $uploaded_file_name = $new_file_name;
                }
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
            if (in_array($type, ['admission'])) {
                $ref_year = \Carbon::now()->year;
                $ref_number = $prefix .'-'. $ref_year . '-' . $ref_digits;
            } else {
                $ref_year = \Carbon::now()->year;
                $ref_number = $ref_year .'-'. $ref_digits;
            }
        }
        

        return $ref_number;
    }


     /**
     * This function formats a number and returns them in specified format
     *
     * @param int $input_number
     * @param boolean $add_symbol = false
     * @param array $systems_details = null
     * @param boolean $is_quantity = false; If number represents quantity
     *
     * @return string
     */
    public function num_f($input_number, $add_symbol = false, $systems_details = null, $is_quantity = false)
    {
        $thousand_separator = !empty($systems_details) ? $systems_details->thousand_separator : session('currency')['thousand_separator'];
        $decimal_separator = !empty($systems_details) ? $systems_details->decimal_separator : session('currency')['decimal_separator'];

        $currency_precision = config('constants.currency_precision', 2);

        if ($is_quantity) {
            $currency_precision = config('constants.quantity_precision', 2);
        }

        $formatted = number_format($input_number, $currency_precision, $decimal_separator, $thousand_separator);

        if ($add_symbol) {
            $currency_symbol_placement = !empty($systems_details) ? $systems_details->currency_symbol_placement : session('systems_details.currency_symbol_placement');
            $symbol = !empty($systems_details) ? $systems_details->currency_symbol : session('currency')['symbol'];

            if ($currency_symbol_placement == 'after') {
                $formatted = $formatted . ' ' . $symbol;
            } else {
                $formatted = $symbol . ' ' . $formatted;
            }
        }

        return $formatted;
    }

    public function getFeeHeads($campus_id,$class_id)
    {
            $query=FeeHead::whereNotIn('description',['Admission','Prospectus','Security','Tuition','Transport']);
       
            // $query=FeeHead::where('campus_id', $campus_id)
            // ->where('class_id', $class_id)->whereNotIn('description',['Admission','Prospectus','Security','Tuition','Transport']);
       
            $fee_heads = $query->get();
            return $fee_heads;
 
        
    }
    public function getAdmissionFeeHeads($campus_id,$class_id )
    {
            $query=FeeHead::whereIn('description',['Admission','Prospectus','Security']);
           
            // $query=FeeHead::where('campus_id', $campus_id)
            // ->where('class_id', $class_id)->whereIn('description',['Admission','Prospectus','Security']);
           
            $fee_heads = $query->get();
            return $fee_heads;
 
        
    }
    public function getActiveSession()
    {
        $session = Session::where('status', 'ACTIVE')->first();
        return $session->id;
    }
/**
     * Defines available Payment Types
     *
     * @return array
     */
    public function payment_types($location = null, $show_advance = false, $business_id = null)
    {
        // if(!empty($location)){
        //     $location = is_object($location) ? $location : BusinessLocation::find($location);

        //     //Get custom label from business settings
        //     $custom_labels = Business::find($location->business_id)->custom_labels;
        //     $custom_labels = json_decode($custom_labels, true);
        // } else {
        //     if (!empty($business_id)) {
        //         $custom_labels = Business::find($business_id)->custom_labels;
        //         $custom_labels = json_decode($custom_labels, true);
        //     } else {
        //         $custom_labels = [];
        //     }
        // }
        
        $payment_types = ['cash' => __('lang_v1.cash'), 'card' => __('lang_v1.card'), 'cheque' => __('lang_v1.cheque'), 'bank_transfer' => __('lang_v1.bank_transfer'), 'other' => __('lang_v1.other')];

        // $payment_types['custom_pay_1'] = !empty($custom_labels['payments']['custom_pay_1']) ? $custom_labels['payments']['custom_pay_1'] : __('lang_v1.custom_payment', ['number' => 1]);
        // $payment_types['custom_pay_2'] = !empty($custom_labels['payments']['custom_pay_2']) ? $custom_labels['payments']['custom_pay_2'] : __('lang_v1.custom_payment', ['number' => 2]);
        // $payment_types['custom_pay_3'] = !empty($custom_labels['payments']['custom_pay_3']) ? $custom_labels['payments']['custom_pay_3'] : __('lang_v1.custom_payment', ['number' => 3]);
        // $payment_types['custom_pay_4'] = !empty($custom_labels['payments']['custom_pay_4']) ? $custom_labels['payments']['custom_pay_4'] : __('lang_v1.custom_payment', ['number' => 4]);
        // $payment_types['custom_pay_5'] = !empty($custom_labels['payments']['custom_pay_5']) ? $custom_labels['payments']['custom_pay_5'] : __('lang_v1.custom_payment', ['number' => 5]);
        // $payment_types['custom_pay_6'] = !empty($custom_labels['payments']['custom_pay_6']) ? $custom_labels['payments']['custom_pay_6'] : __('lang_v1.custom_payment', ['number' => 6]);
        // $payment_types['custom_pay_7'] = !empty($custom_labels['payments']['custom_pay_7']) ? $custom_labels['payments']['custom_pay_7'] : __('lang_v1.custom_payment', ['number' => 7]);

        // //Unset payment types if not enabled in business location
        // if (!empty($location)) {
        //     $location_account_settings = !empty($location->default_payment_accounts) ? json_decode($location->default_payment_accounts, true) : [];
        //     $enabled_accounts = [];
        //     foreach ($location_account_settings as $key => $value) {
        //         if (!empty($value['is_enabled'])) {
        //             $enabled_accounts[] = $key;
        //         }
        //     }
        //     foreach ($payment_types as $key => $value) {
        //         if (!in_array($key, $enabled_accounts)) {
        //             unset($payment_types[$key]);
        //         }
        //     }
        // }

        // if ($show_advance) {
        //   $payment_types = ['advance' => __('lang_v1.advance')] + $payment_types;
        // }

        return $payment_types;
    }
    public function accountsDropdown($system_settings_id,$campus_id, $prepend_none = false, $closed = false, $default_campus_account=false, $show_balance = false)
    {
        $dropdown = [];

        // if ($this->isModuleEnabled('account')) {
            $dropdown = Account::forDropdown($system_settings_id, $campus_id,$prepend_none, $closed,$default_campus_account, $show_balance);
        //}

        return $dropdown;
    }

}
