<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;
;
class ProvinceController extends Controller
{
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
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
        if (request()->ajax()) {

            $system_settings_id = session()->get('user.system_settings_id');

            $regions = Province::where('system_settings_id',$system_settings_id)
            ->leftjoin('currencies as c', 'provinces.country_id', '=', 'c.id')
            ->select(['c.country as country_name', 'name', 'provinces.id']);
            return Datatables::of($regions)
                ->addColumn(
                    'action',
                    '<div class="d-flex order-actions">

                    <button data-href="{{action(\'ProvinceController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_province_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;


                        <button data-href="{{action(\'ProvinceController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_province_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>

                    </div>'
                )

                ->removeColumn('id')
                ->rawColumns(['action','village','city'])
                ->make(true);
        }

        return view('admin\global_configuration\provinces.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->commonUtil->allCountries();

        return view('admin\global_configuration\provinces.create')->with(compact('countries'));


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
            $input = $request->only(['country_id','name']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $province = Province::create($input);
            $output = ['success' => true,
                            'data' => $province,
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
        $countries = $this->commonUtil->allCountries();
        $system_settings_id = session()->get('user.system_settings_id');

        $province = Province::where('system_settings_id',$system_settings_id)->find($id);
        return view('admin\global_configuration\provinces.edit')->with(compact('countries','province'));

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
            $input = $request->only(['country_id','name']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $province = Province::where('system_settings_id',$system_settings_id)->find($id);
            $province->name=$input['name'];
            $province->country_id=$input['country_id'];
            $province->save();
            $output = ['success' => true,
                            'data' => $province,
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
        if (!auth()->user()->can('session.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {


                $province = Province::findOrFail($id);
                $province->delete();

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

       /**
     * Gets the Provinces for the given unit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $Country_id
     * @return \Illuminate\Http\Response
     */
    public function getProvinces(Request $request){
        if (!empty($request->input('country_id'))) {
            $country_id = $request->input('country_id');
            
            $system_settings_id = session()->get('user.system_settings_id');
            $provinces = Province::forDropdown($system_settings_id,false,$country_id);
            $html = '<option value="">' . __('lang.please_select') . '</option>';
            //$html = '';
            if (!empty($provinces)) {
                foreach ($provinces as $id => $name) {
                    $html .= '<option value="' . $id .'">' . $name. '</option>';
                }
            }

            return $html;
        }

    }
}
