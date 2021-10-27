<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;
class RegionController extends Controller
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
    
    public function index()
    {
        if (request()->ajax()) {
            $system_settings_id = session()->get('user.system_settings_id');

            $regions = Region::where('regions.system_settings_id', $system_settings_id)
            ->leftjoin('districts as d', 'regions.district_id', '=', 'd.id')
            ->leftjoin('currencies as c', 'regions.country_id', '=', 'c.id')
            ->leftjoin('provinces as p', 'regions.province_id', '=', 'p.id')
            ->leftjoin('cities as ct', 'regions.city_id', '=', 'ct.id')
            ->select(['regions.id', 'regions.name','d.name as district_name','c.country as country_name','p.name as province_name','ct.name as city_name']);

            return Datatables::of($regions)
                ->addColumn(
                    'action',
                    '<div class="d-flex order-actions">

                    <button data-href="{{action(\'RegionController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_region_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;


                        <button data-href="{{action(\'RegionController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_region_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>

                    </div>'
                )

                ->removeColumn('id')
                ->rawColumns(['action', 'name','district_name','country_name','province_name','city_name'])
                ->make(true);
        }

        return view('admin\global_configuration\regions.index');
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
        return view('admin\global_configuration\regions.create')->with(compact('countries'));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->only(['name','country_id','province_id','district_id','city_id']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $region = Region::create($input);
            $output = ['success' => true,
                            'data' => $region,
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
            $region = Region::where('system_settings_id', $system_settings_id)->find($id);
            $provinces = Province::forDropdown($system_settings_id, false, $region->country_id);
            $districts = District::forDropdown($system_settings_id, false, $region->province_id);
            $cities = City::forDropdown($system_settings_id, false, $region->city_id);
            return view('admin\global_configuration\regions.edit')->with(compact('countries', 'districts', 'provinces','cities','region'));
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
                $input = $request->only(['name','country_id','province_id','district_id','city_id']);
                $region = Region::findOrFail($id);
                $region->fill($input);
                $region->save();

                $output = ['success' => true,
                            'msg' => __("lang.updated_success")
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $region = Region::findOrFail($id);
                $region->delete();

                $output = ['success' => true,
                            'msg' => __("lang.deleted_success")
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
}
