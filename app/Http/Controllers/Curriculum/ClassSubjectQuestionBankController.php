<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum\ClassSubject;
use App\Models\Curriculum\ClassSubjectLesson;
use App\Models\Curriculum\ClassSubjectQuestionBank;
use App\Models\Campus;
use App\Models\Classes;

use Yajra\DataTables\Facades\DataTables;
use DB;

class ClassSubjectQuestionBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ClassSubject.view') && !auth()->user()->can('ClassSubject.create')) {
            abort(403, 'Unauthorized action.');
        }
  
        if (request()->ajax()) {
            $questionBank = ClassSubjectQuestionBank::
        leftjoin('class_subject_lessons as l', 'class_subject_question_banks.lesson_id', '=', 'l.id')->select(['class_subject_question_banks.id',
        'class_subject_question_banks.chapter_number',
        'class_subject_question_banks.question',
        'class_subject_question_banks.type',
        'class_subject_question_banks.marks',
        'l.name as lesson_name',
        ]);  if (request()->has('subject_id')) {
            $subject_id = request()->get('subject_id');
            if (!empty($subject_id)) {
                $questionBank->where('class_subject_question_banks.subject_id', $subject_id);
            }
        }
            return Datatables::of($questionBank)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html= '<div class="dropdown">
                             <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                             <ul class="dropdown-menu" style="">';
                        $html.='<li><a class="dropdown-item  edit_question_button"data-href="' . action('Curriculum\ClassSubjectQuestionBankController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';               
                        $html.='<li><a class="dropdown-item  delete_question_button"data-href="' . action('Curriculum\ClassSubjectQuestionBankController@destroy', [$row->id]) . '"><i class="bx bxs-trash "></i> ' . __("lang.delete") . '</a></li>';               
    
                       $html .= '</ul></div>';
    
                        return $html;
                    }
                )
                ->editColumn('type', function ($row)  {
                    $type=__('lang.question_type');
                    return $type[$row->type];
                })
                ->removeColumn('id')
                ->rawColumns(['action','question','type'])
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

        return view('Curriculum\question_bank.create')->with(compact('campuses', 'class_subject', 'chapters'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('ClassSubject.create')) {
        //     abort(403, 'Unauthorized action.');
        // }
        try {
            $input = $request->only(['subject_id', 'campus_id', 'chapter_number', 'lesson_id', 'type','marks', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'hint' , 'answer']);
            if($input['type']=='mcq' || $input['type']=='true_and_false'){
                if(!empty($input['answer'])){
                    $user_id = $request->session()->get('user.id');
                    $input['created_by'] = $user_id;
                    $classSubjectQuestionBank = ClassSubjectQuestionBank::create($input);
                    $output = ['success' => true,
                                'data' => $classSubjectQuestionBank,
                                'msg' => __("lang.added_success")
                            ];
                }else{
                    $output = ['success' => false,
                                'msg' => __("lang.answer_required")
                            ];
                }
            }else{
                $user_id = $request->session()->get('user.id');
                $input['created_by'] = $user_id;
                $classSubjectQuestionBank = ClassSubjectQuestionBank::create($input);
                $output = ['success' => true,
                            'data' => $classSubjectQuestionBank,
                            'msg' => __("lang.added_success")
                        ];
            }
        
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
        // if (!auth()->user()->can('ClassSubject.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {

            $class_subject_question_bank = ClassSubjectQuestionBank::find($id);
            $class_subject = ClassSubject::with(['classes'])->find($class_subject_question_bank->subject_id);
            $lesson = ClassSubjectLesson::forDropdown($class_subject_question_bank->subject_id, $class_subject_question_bank->chapter_number);
            $chapters=[];
            for ($i = 1; $i <= $class_subject->chapters; $i++) {
                $chapters[$i]=__('lang.chapter') . '  '.$i;
            }
            return view('Curriculum\question_bank.edit')
                ->with(compact('class_subject_question_bank','chapters','class_subject','lesson'));
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
        // if (!auth()->user()->can('ClassSubject.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            try {
                $input = $request->only(['subject_id', 'campus_id', 'chapter_number', 'lesson_id', 'type','marks', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'hint' , 'answer']);
                $classSubjectQuestionBank = ClassSubjectQuestionBank::findOrFail($id);
                $classSubjectQuestionBank->fill($input);
                $classSubjectQuestionBank->save();
  
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
                $classSubjectQuestionBank = ClassSubjectQuestionBank::findOrFail($id);
                $classSubjectQuestionBank->delete();

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
