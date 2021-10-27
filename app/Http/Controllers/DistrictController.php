<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;

class DistrictController extends Controller
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

            $district = District::where('districts.system_settings_id', $system_settings_id)
                        ->leftjoin('currencies as c', 'districts.country_id', '=', 'c.id')
                        ->leftjoin('provinces as p', 'districts.province_id', '=', 'p.id')
                        ->select(['districts.id', 'districts.name','c.country as country_name','p.name as province_name']);

            return DataTables::of($district)
                           ->addColumn(
                               'action',
                               '<div class="d-flex order-actions">

                               <button data-href="{{action(\'DistrictController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_district_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                                   &nbsp;


                                   <button data-href="{{action(\'DistrictController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_district_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>

                               </div>'
                           )
                           ->removeColumn('id')
                           ->rawColumns(['action', 'districts.name','country_name','province_name'])
                           ->make(true);
        }
        return view('admin\global_configuration\districts.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $countries=$this->commonUtil->allCountries();
        return view('admin\global_configuration\districts.create')->with(compact('countries'));
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
            $input = $request->only(['name','country_id','province_id']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $district = District::create($input);
            $output = ['success' => true,
                            'data' => $district,
                            'msg' => __("lang.added_success")
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
        $district = District::where('system_settings_id', $system_settings_id)->find($id);
        $countries=$this->commonUtil->allCountries();
        $provinces = Province::forDropdown($system_settings_id, false, $district->country_id);
        return view('admin\global_configuration\districts.edit')->with(compact('countries', 'district', 'provinces'));
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
            $input = $request->only(['name','country_id']);
            $system_settings_id = session()->get('user.system_settings_id');
            $district = District::where('system_settings_id', $system_settings_id)->find($id);
            $district->fill($input);
            $district->save();
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
        if (request()->ajax()) {
            try {
                $district = District::findOrFail($id);
                $district->delete();

                $output = ['success' => true,
                            'msg' => __("district.deleted_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => false,
                            'msg' => __("lang.something_went_wrong")
                        ];
            }

            return $output;
        }
    }


    /**
     * Gets the Districts for the given unit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $Country_id
     * @return \Illuminate\Http\Response
     */
    public function getDistricts(Request $request)
    {
        if (!empty($request->input('province_id'))) {
            $province_id = $request->input('province_id');
            
            $system_settings_id = session()->get('user.system_settings_id');
            $districts = District::forDropdown($system_settings_id, false, $province_id);
            $html = '<option value="">' . __('lang.please_select') . '</option>';
            //$html = '';
            if (!empty($districts)) {
                foreach ($districts as $id => $name) {
                    $html .= '<option value="' . $id .'">' . $name. '</option>';
                }
            }

            return $html;
        }
    }
}
