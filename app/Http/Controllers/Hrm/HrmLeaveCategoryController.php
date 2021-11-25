<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hrm\HrmLeaveCategory;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class HrmLeaveCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('HrmLeaveCategory.view') && !auth()->user()->can('HrmLeaveCategory.create')) {
            abort(403, 'Unauthorized action.');
        }
  
        if (request()->ajax()) {
            $hrmLeaveCategories = HrmLeaveCategory::select(['leave_category','max_leave_count',  'id']);
            return Datatables::of($hrmLeaveCategories)
                ->addColumn(
                    'action',
                    '
                    <div class="d-flex order-actions">
                    <button data-href="{{action(\'HRM\HrmLeaveCategoryController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_leave_category_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;
                        <button data-href="{{action(\'HRM\HrmLeaveCategoryController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_leave_category_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>
                    </div>
                    '
                )
                
                ->removeColumn('id')
                ->rawColumns([2])
                ->make(false);
        }
  
        return view('Hrm\leave_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('HrmLeaveCategory.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        return view('Hrm\leave_category.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('HrmLeaveCategory.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $hrm_leave_category = Validator::make($request->all(), [
            'leave_category' => 'required|unique:hrm_leave_categories|max:100',
        ]);
        if($hrm_leave_category->passes()) {
            try {
                $input = $request->only(['leave_category','max_leave_count', 'leave_count_interval']);

                $user_id = $request->session()->get('user.id');
                $input['created_by'] = $user_id;
                $leave_category = HrmLeaveCategory::create($input);
      

                $output = ['success' => true,
                        'data' => $leave_category,
                        'msg' => __("hrm.added_success")
                    ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => false,
            'msg' => __("lang.something_went_wrong")
        ];
            }
            return $output;
        }
       return response()->json(['error'=>$hrm_leave_category->errors()]);

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
        // if (!auth()->user()->can('HrmLeaveCategory.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            $leave_category = HrmLeaveCategory::find($id);
            return view('Hrm\leave_category.edit')
                ->with(compact('leave_category'));
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
        // if (!auth()->user()->can('HrmLeaveCategory.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            $leave_category = $this->validate(request(), [
                'leave_category' => 'required|max:100',
            ]);
            try {
                $input = $request->only(['leave_category','max_leave_count', 'leave_count_interval']);
  
                $leave_category = HrmLeaveCategory::findOrFail($id)->update($input);

             
  
                $output = ['success' => true,
                            'msg' => __("hrm.updated_success")
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
      
      // if (!auth()->user()->can('HrmLeaveCategory.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                $leave_category = HrmLeaveCategory::findOrFail($id);
                $leave_category->delete();

                $output = ['success' => true,
                        'msg' => __("hrm.deleted_success")
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
