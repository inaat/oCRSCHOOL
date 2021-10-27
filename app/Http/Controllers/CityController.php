<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;

class CityController extends Controller
{
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param Util $commonUtil
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('discount.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $system_settings_id = session()->get('user.system_settings_id');

            $city = City::where('cities.system_settings_id', $system_settings_id)
                        ->leftjoin('districts as d', 'cities.district_id', '=', 'd.id')
                        ->leftjoin('currencies as c', 'cities.country_id', '=', 'c.id')
                        ->leftjoin('provinces as p', 'cities.province_id', '=', 'p.id')
                        ->select(['cities.id', 'cities.name','d.name as district_name','c.country as country_name','p.name as province_name']);

            return DataTables::of($city)
                           ->addColumn(
                               'action',
                               '<div class="d-flex order-actions">

                               <button data-href="{{action(\'CityController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_city_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                                   &nbsp;


                                   <button data-href="{{action(\'CityController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_city_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>

                               </div>'
                           )
                           ->removeColumn('id')
                           ->rawColumns(['action', 'name','district_name','country_name','province_name'])
                           ->make(true);
        }
        return view('admin\global_configuration\cities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('discount.create')) {
            abort(403, 'Unauthorized action.');
        }
        $system_settings_id = session()->get('user.system_settings_id');
        $countries=$this->commonUtil->allCountries();
        return view('admin\global_configuration\cities.create')->with(compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('session.create')) {
            abort(403, 'Unauthorized action.');
        }

       try {
            $input = $request->only(['name','country_id','province_id','district_id']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $city = City::create($input);
            $output = ['success' => true,
                            'data' => $city,
                            'msg' => __("city.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                            'msg' => __("lang.something_went_wrong")
                        ];
        }

        return $output;
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
        $system_settings_id = session()->get('user.system_settings_id');
        $countries=$this->commonUtil->allCountries();
        $city = City::where('system_settings_id', $system_settings_id)->find($id);
        $provinces = Province::forDropdown($system_settings_id, false, $city->country_id);
        $districts = District::forDropdown($system_settings_id, false, $city->province_id);
        return view('admin\global_configuration\cities.edit')->with(compact('countries', 'districts', 'provinces','city'));

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
        try {
            $input = $request->only(['name','country_id','province_id','district_id']);
            $system_settings_id = session()->get('user.system_settings_id');
            $city = City::where('system_settings_id', $system_settings_id)->find($id);
            $city->fill($input);
            $city->save();
            $output = ['success' => true,
            'msg' => __("class.updated_success")
        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
            'msg' => __("lang.something_went_wrong")
            ];
        }

        return  $output;

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

    
    /**
     * Gets the Cities .
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $district_id
     * @return \Illuminate\Http\Response
     */
    public function getCities(Request $request)
    {
        if (!empty($request->input('district_id'))) {
            $district_id = $request->input('district_id');
            $system_settings_id = session()->get('user.system_settings_id');
            $cities = City::forDropdown($system_settings_id, false, $district_id);
            $html = '<option value="">' . __('lang.please_select') . '</option>';
            //$html = '';
            if (!empty($cities)) {
                foreach ($cities as $id => $name) {
                    $html .= '<option value="' . $id .'">' . $name. '</option>';
                }
            }

            return $html;
        }
    }
}
