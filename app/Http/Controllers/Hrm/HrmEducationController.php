<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hrm\HrmEducation;
use Yajra\DataTables\Facades\DataTables;

class HrmEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('HrmEducation.view') && !auth()->user()->can('HrmEducation.create')) {
            abort(403, 'Unauthorized action.');
        }
  
        if (request()->ajax()) {
            $hrmEducations = HrmEducation::select(['education', 'id']);
            return Datatables::of($hrmEducations)
                ->addColumn(
                    'action',
                    '
                    <div class="d-flex order-actions">
                    <button data-href="{{action(\'HRM\HrmEducationController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_education_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;
                        <button data-href="{{action(\'HRM\HrmEducationController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_education_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>
                    </div>
                    '
                )
                
                ->removeColumn('id')
                ->rawColumns(['action','education'])
                ->make(true);
        }
  
        return view('Hrm\education.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('HrmEducation.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        return view('Hrm\education.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('HrmEducation.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $input = $request->only(['education']);

            $user_id = $request->session()->get('user.id');
            $input['created_by'] = $user_id;
            $education = HrmEducation::create($input);
      

            $output = ['success' => true,
                        'data' => $education,
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
        // if (!auth()->user()->can('HrmEducation.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            $education = HrmEducation::find($id);
            return view('Hrm\education.edit')
                ->with(compact('education'));
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
        // if (!auth()->user()->can('HrmEducation.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            try {
                $input = $request->only(['education']);
  
                $education = HrmEducation::findOrFail($id);
                $education->education = $input['education'];
                $education->save();
  
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
      
      // if (!auth()->user()->can('HrmEducation.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                $education = HrmEducation::findOrFail($id);
                $education->delete();

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
