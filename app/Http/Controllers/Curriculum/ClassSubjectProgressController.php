<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum\ClassSubject;
use App\Models\Curriculum\ClassSubjectLesson;
use App\Models\Curriculum\ClassSubjectProgress;
use App\Models\Campus;
use App\Models\Classes;
use App\Utils\Util;

use Yajra\DataTables\Facades\DataTables;
use DB;

class ClassSubjectProgressController extends Controller
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
        if (request()->ajax()) {
            $class_subject_progress = ClassSubjectProgress::leftjoin('class_subject_lessons  as csL', 'class_subject_progress.lesson_id', '=', 'csL.id')
            ->where('class_subject_progress.session_id', $this->commonUtil->getActiveSession())
            ->select(['csL.name','class_subject_progress.chapter','class_subject_progress.complete_date','class_subject_progress.start_date','class_subject_progress.status', 'class_subject_progress.id']);
            
            if (request()->has('chapter_number')) {
                $chapter_number = request()->get('chapter_number');
                if (!empty($chapter_number)) {
                    $class_subject_progress->where('chapter', $chapter_number);
                }
            }
            if (request()->has('subject_id')) {
                $subject_id = request()->get('subject_id');
                if (!empty($subject_id)) {
                    $class_subject_progress->where('class_subject_progress.subject_id', $subject_id);
                }
            }
            return Datatables::of($class_subject_progress)
                ->addColumn(
                    'action',
                    function ($row) {
                        return '<a class="dropdown-item  delete_progress_button "data-href="' . action('Curriculum\ClassSubjectProgressController@destroy', [$row->id]) . '"><i class="text-danger bx bxs-trash f-16 mr-15"></a>';    
                    }
                )
                ->editColumn(
                    'status',
                    function ($row) {
                        return (string) view('Curriculum\progress.session_status', ['status'=>$row->status,'id' => $row->id,'start_date'=>$row->start_date,'complete_date'=>$row->complete_date]);
                    }
                )

                ->removeColumn('id', 'start_date', 'complete_date')
                ->rawColumns(['action','status'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // if (!auth()->user()->can('ClassSubjectProgress.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $campuses=Campus::forDropdown();
        $class_subject = ClassSubject::with(['classes'])->find($id);
        $chapters=[];
        for ($i = 1; $i <= $class_subject->chapters; $i++) {
            $chapters[$i]=__('lang.chapter') . '  '.$i;
        }

        return view('Curriculum\progress.create')->with(compact('campuses', 'class_subject', 'chapters'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('ClassSubjectProgress.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $input = $request->only(['lesson_id','start_date','chapter','campus_id','subject_id']);
            $session_id=$this->commonUtil->getActiveSession();
            $check=ClassSubjectProgress::where('lesson_id', $input['lesson_id'])->where('session_id', $session_id)->first();
            if (!empty($check)) {
                $output = ['success' => false,
                'msg' => __("lang.lesson_already_planned_please_choose_another_lesson")
                ];
            
                return $output;
            }

            $user_id = $request->session()->get('user.id');
            $input['created_by'] = $user_id;
            $input['start_date'] = $this->commonUtil->uf_date($input['start_date']);
            $input['session_id'] = $session_id;
            $class_subject_progress = ClassSubjectProgress::create($input);
      

            $output = ['success' => true,
                        'data' => $class_subject_progress,
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
        $class_subject = ClassSubject::with(['classes'])->find($id);
        $chapters=[];
        for ($i = 1; $i <= $class_subject->chapters; $i++) {
            $chapters[$i]=__('lang.chapter') . '  '.$i;
        }
        return view('Curriculum\class_subject_progress.index')->with(compact('class_subject', 'chapters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!auth()->user()->can('ClassSubjectProgress.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
        if (request()->ajax()) {
            try {
                $status = request()->get('status');

                $class_subject_progress = ClassSubjectProgress::find($id);
                $class_subject_progress->status=$status;
                $class_subject_progress->save();
         
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
      
      // if (!auth()->user()->can('ClassSubjectProgress.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                $class_subject_progress = ClassSubjectProgress::findOrFail($id);
                $class_subject_progress->delete();

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
     * Gets the Lessons for the given unit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $subject_id
     * @return \Illuminate\Http\Response
     */
    public function getLessons(Request $request)
    {
        if (!empty($request->input('subject_id'))) {
            $subject_id = $request->input('subject_id');
            $chapter_number = $request->input('chapter_number');
            
            $lesson = ClassSubjectLesson::forDropdown($subject_id, $chapter_number);
            $html = '<option value="">' . __('lang.please_select') . '</option>';
            //$html = '';
            if (!empty($lesson)) {
                foreach ($lesson as $id => $name) {
                    $html .= '<option value="' . $id .'">' . $name. '</option>';
                }
            }

            return $html;
        }
    }
}
