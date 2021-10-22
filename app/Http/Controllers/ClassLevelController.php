<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassLevel;
use Yajra\DataTables\Facades\DataTables;

class ClassLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //if PASSED IN PAST
    public function index()
    {
        if (request()->ajax()) {
            $classLevel = ClassLevel::select(['title', 'description', 'id']);
            return Datatables::of($classLevel)
                ->addColumn(
                    'action',
                    '<div class="d-flex order-actions">

                    <button data-href="{{action(\'ClassLevelController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_class_level_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("global_lang.edit")</button>
                        &nbsp;


                        <button data-href="{{action(\'ClassLevelController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_class_level_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("global_lang.delete")</button>

                    </div>'
                )

                ->removeColumn('id')
                ->rawColumns(['action','description','title'])
                ->make(true);
        }

        return view('admin\global_configuration\class_levels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin\global_configuration\class_levels.create');
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
            $input = $request->only(['title','description']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $class_level = ClassLevel::create($input);
            $output = ['success' => true,
                            'data' => $class_level,
                            'msg' => __("class_level.added_success")
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
            $class_level = ClassLevel::find($id);
            return view('admin\global_configuration\class_levels.edit')
                ->with(compact('class_level'));
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
                $input = $request->only(['title','description']);

                $class_level = ClassLevel::findOrFail($id);
                $class_level->title = $input['title'];
                $class_level->description= $input['description'];
                $class_level->save();

                $output = ['success' => true,
                            'msg' => __("class_level.updated_success")
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
                $class_level = ClassLevel::findOrFail($id);
                $class_level->delete();

                $output = ['success' => true,
                            'msg' => __("class_level.deleted_success")
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
