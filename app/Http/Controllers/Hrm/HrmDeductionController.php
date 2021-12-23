<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HumanRM\HrmDeduction;
use Yajra\DataTables\Facades\DataTables;

class HrmDeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('HrmDeduction.view') && !auth()->user()->can('HrmDeduction.create')) {
            abort(403, 'Unauthorized action.');
        }
  
        if (request()->ajax()) {
            $HrmDeductions = HrmDeduction::select(['deduction', 'id']);
            return Datatables::of($HrmDeductions)
                ->addColumn(
                    'action',
                    '
                    <div class="d-flex order-actions">
                    <button data-href="{{action(\'HRM\HrmDeductionController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_deduction_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;
                        <button data-href="{{action(\'HRM\HrmDeductionController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_deduction_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>
                    </div>
                    '
                )
                
                ->removeColumn('id')
                ->rawColumns(['action','deduction'])
                ->make(true);
        }
  
        return view('Hrm\deduction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('HrmDeduction.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        return view('Hrm\deduction.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('HrmDeduction.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $input = $request->only(['deduction']);

            $user_id = $request->session()->get('user.id');
            $input['created_by'] = $user_id;
            $deduction = HrmDeduction::create($input);
      

            $output = ['success' => true,
                        'data' => $deduction,
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
        // if (!auth()->user()->can('HrmDeduction.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            $deduction = HrmDeduction::find($id);
            return view('Hrm\deduction.edit')
                ->with(compact('deduction'));
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
        // if (!auth()->user()->can('HrmDeduction.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            try {
                $input = $request->only(['deduction']);
  
                $deduction = HrmDeduction::findOrFail($id);
                $deduction->deduction = $input['deduction'];
                $deduction->save();
  
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
      
      // if (!auth()->user()->can('HrmDeduction.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                $deduction = HrmDeduction::findOrFail($id);
                $deduction->delete();

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
