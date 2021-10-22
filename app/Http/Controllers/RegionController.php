<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use Yajra\DataTables\Facades\DataTables;
class RegionController extends Controller
{
    
    public function index()
    {
        if (request()->ajax()) {
            $regions = Region::select(['city', 'village', 'id']);
            return Datatables::of($regions)
                ->addColumn(
                    'action',
                    '<div class="d-flex order-actions">

                    <button data-href="{{action(\'RegionController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_region_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("global_lang.edit")</button>
                        &nbsp;


                        <button data-href="{{action(\'RegionController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_region_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("global_lang.delete")</button>

                    </div>'
                )

                ->removeColumn('id')
                ->rawColumns(['action','village','city'])
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
        return view('admin\global_configuration\regions.create');
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
            $input = $request->only(['city','village']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $region = Region::create($input);
            $output = ['success' => true,
                            'data' => $region,
                            'msg' => __("region.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                            'msg' => __("global_lang.something_went_wrong")
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
        if (request()->ajax()) {
            $region = Region::find($id);
            return view('admin\global_configuration\region.edit')
                ->with(compact('region'));
        }
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
        if (request()->ajax()) {
            try {
                $input = $request->only(['cat_name','description']);

                $region = Region::findOrFail($id);
                $region->cat_name = $input['cat_name'];
                $region->description= $input['description'];
                $region->save();

                $output = ['success' => true,
                            'msg' => __("region.updated_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => false,
                            'msg' => __("global_lang.something_went_wrong")
                        ];
            }

            return $output;
        }
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
                            'msg' => __("region.deleted_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => false,
                            'msg' => __("global_lang.something_went_wrong")
                        ];
            }

            return $output;
        }
    }
}
