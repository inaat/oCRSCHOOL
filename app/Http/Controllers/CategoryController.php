<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $category = Category::select(['cat_name', 'description', 'id']);
            return Datatables::of($category)
                ->addColumn(
                    'action',
                    '<div class="d-flex order-actions">

                    <button data-href="{{action(\'CategoryController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_category_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;


                        <button data-href="{{action(\'CategoryController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_category_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>

                    </div>'
                )

                ->removeColumn('id')
                ->rawColumns(['action','description','cat_name'])
                ->make(true);
        }

        return view('admin\global_configuration\categories.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin\global_configuration\categories.create');
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
            $input = $request->only(['cat_name','description']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $categories = Category::create($input);
            $output = ['success' => true,
                            'data' => $categories,
                            'msg' => __("categories.added_success")
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
        if (request()->ajax()) {
            $category = Category::find($id);
            return view('admin\global_configuration\categories.edit')
                ->with(compact('category'));
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

                $categories = Category::findOrFail($id);
                $categories->cat_name = $input['cat_name'];
                $categories->description= $input['description'];
                $categories->save();

                $output = ['success' => true,
                            'msg' => __("categories.updated_success")
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $categories = Category::findOrFail($id);
                $categories->delete();

                $output = ['success' => true,
                            'msg' => __("categories.deleted_success")
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
