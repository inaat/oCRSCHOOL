<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Utils\Util;
use App\Utils\OrganizationUtil;
use App\Models\Session;
use App\Models\Currency;

class SystemSettingController extends Controller
{
    protected $commonUtil;
    protected $organizationUtil;


    /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
     * @return void
     */
    public function __construct(Util $commonUtil, OrganizationUtil $organizationUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->organizationUtil = $organizationUtil;
        $this->theme_colors = [
            'blue' => 'Blue',
            'black' => 'Black',
            'purple' => 'Purple',
            'green' => 'Green',
            'red' => 'Red',
            'yellow' => 'Yellow',
            'blue-light' => 'Blue Light',
            'black-light' => 'Black Light',
            'purple-light' => 'Purple Light',
            'green-light' => 'Green Light',
            'red-light' => 'Red Light',
        ];

        $this->mailDrivers = [
                'smtp' => 'SMTP',
                // 'sendmail' => 'Sendmail',
                // 'mailgun' => 'Mailgun',
                // 'mandrill' => 'Mandrill',
                // 'ses' => 'SES',
                // 'sparkpost' => 'Sparkpost'
            ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::forDropdown();
        $month_list=$this->commonUtil->getMonthList();
        $currencies = $this->commonUtil->allCurrencies();
        $timezone_list = $this->commonUtil->allTimeZones();
        $system_settings_id = request()->session()->get('user');
        $general_settings=SystemSetting::where('id', $system_settings_id)->first();
        $email_settings = empty($general_settings->email_settings) ? $this->organizationUtil->defaultEmailSettings() : $general_settings->email_settings;

        $sms_settings = empty($general_settings->sms_settings) ? $this->organizationUtil->defaultSmsSettings() : $general_settings->sms_settings;

        $date_formats = SystemSetting::date_formats();
        $mail_drivers = $this->mailDrivers;
        $theme_colors = $this->theme_colors;

        return view('admin\global_configuration.global_configuration')->with(compact('theme_colors','mail_drivers','email_settings','sms_settings','timezone_list', 'date_formats', 'month_list', 'currencies', 'general_settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
        $validated = $request->validate([
                'org_name' => 'required'
            ], [
                'org_name.required' => 'Name is required',
            
        ]);
        $system_details = $request->only(['org_name','org_address','org_contact_number','currency_id','currency_symbol_placement','start_date',
        'email_settings','sms_settings','ref_no_prefixes', 'theme_color','enable_tooltip','date_format','time_format','time_zone','start_month']);


        //upload logo
        $org_favicon = $this->organizationUtil->uploadFile($request, 'org_favicon', 'business_logos', 'image');
        if (!empty($org_favicon)) {
            $system_details['org_favicon'] = $org_favicon;
        }
        $org_logo = $this->organizationUtil->uploadFile($request, 'org_logo', 'business_logos', 'image');
        if (!empty($org_logo)) {
            $system_details['org_logo'] = $org_logo;
        }
        if (!empty($system_details['start_date'])) {
            $system_details['start_date'] = $this->organizationUtil->uf_date($system_details['start_date']);
        }
        $system_details['common_settings'] = !empty($request->input('common_settings')) ? $request->input('common_settings') : [];
        $system_setting = SystemSetting::where('id', 1)->first();
        $system_setting->fill($system_details);
        $system_setting->save();
        //update session data
        $request->session()->put('system_details', $system_setting);

        //Update Currency details
        $currency = Currency::find($system_setting->currency_id);
        $request->session()->put('currency', [
                     'id' => $currency->id,
                     'code' => $currency->code,
                     'symbol' => $currency->symbol,
                     'thousand_separator' => $currency->thousand_separator,
                     'decimal_separator' => $currency->decimal_separator,
                     ]);
          
            $output = ['success' => 1,
                     'msg' => __('business.settings_updated_success')
                 ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
     
            $output = ['success' => 0,
                     'msg' => __('lang.something_went_wrong')
                 ];
        }
        return redirect('setting')->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
