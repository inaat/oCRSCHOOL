<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum\ClassTimeTablePeriod;
use App\Models\Curriculum\ClassSubject;
use App\Models\Campus;
use App\Utils\Util;

use Yajra\DataTables\Facades\DataTables;
use DB;

class ClassTimeTableController extends Controller
{
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
        if (!auth()->user()->can('ClassTimeTablePeriod.view') && !auth()->user()->can('ClassTimeTablePeriod.create')) {
            abort(403, 'Unauthorized action.');
        }
          
        return view('Curriculum\class_time_table.index');
    }
         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('ClassSubject.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $campuses=Campus::forDropdown();

        return view('Curriculum\class_time_table.create')->with(compact('campuses'));
    }
    //   /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Response
    //  */
    public function store(Request $request)
    {
     
        try {
            $input = $request->only(['name', 'type','campus_id']);

            if ($input['type'] != 'flexible_shift') {
                $input['start_time'] = $this->commonUtil->uf_time($request->input('start_time'));
                $input['end_time'] = $this->commonUtil->uf_time($request->input('end_time'));
                $start = strtotime($input['start_time']);
                $end = strtotime($input['end_time']);
                $mins = ($end - $start) / 60;
                $input['total_time'] = $mins;

            } else {
                $input['start_time'] = null;
                $input['end_time'] = null;
            }
           
            ClassTimeTablePeriod::create($input);

            $output = ['success' => true,
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        
        $classTimeTablePeriod = ClassTimeTablePeriod::findOrFail($id);

        $campuses=Campus::forDropdown();

        return view('Curriculum\class_time_table_period.edit')->with(compact('campuses', 'classTimeTablePeriod'));
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
        // if (!auth()->user()->can('ClassSubject.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'type','campus_id']);
                if ($input['type'] != 'flexible_shift') {
                    $input['start_time'] = $this->commonUtil->uf_time($request->input('start_time'));
                    $input['end_time'] = $this->commonUtil->uf_time($request->input('end_time'));
                    $start = strtotime($input['start_time']);
                    $end = strtotime($input['end_time']);
                    $mins = ($end - $start) / 60;
                    $input['total_time'] = $mins;
    
                } else {
                    $input['start_time'] = null;
                    $input['end_time'] = null;
                }
                $period =ClassTimeTablePeriod::findOrFail($id);
                $period->fill($input);
                $period->save();
  
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
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
      // if (!auth()->user()->can('ClassSubject.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                
                $period =ClassTimeTablePeriod::findOrFail($id);
                $period->delete();

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