<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum\ClassSubject;
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
            $questionBank = ClassSubjectQuestionBank::leftjoin('campuses as cam', 'class_subjects.campus_id', '=', 'cam.id')
            ->leftjoin('class_subject_lessons as l', 'class_subject_question_banks.lesson_id', '=', 'l.id')->select(['class_subject_question_banks.id',
        'class_subject_question_banks.chapters',
        'class_subject_question_banks.question',
        'cam.campus_name as campus_name',
        'l.name as class_name',
        ]);
            return Datatables::of($questionBank)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html= '<div class="dropdown">
                             <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                             <ul class="dropdown-menu" style="">';
                        $html.='<li><a class="dropdown-item  edit_class_subject_button"data-href="' . action('Curriculum\ClassSubjectQuestionBankController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';               
                        $html.='<li><a class="dropdown-item  delete_class_subject_button"data-href="' . action('Curriculum\ClassSubjectQuestionBankController@destroy', [$row->id]) . '"><i class="bx bxs-trash "></i> ' . __("lang.delete") . '</a></li>';               
    
                       $html .= '</ul></div>';
    
                        return $html;
                    }
                )
                ->removeColumn('id')
                ->rawColumns(['action','campus_name'])
                ->make(true);
        }
  
        return view('Curriculum\class_subject.index');
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

        return view('Curriculum\class_subject.create')->with(compact('campuses'));
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
            $input = $request->only(['campus_id','class_id','name','code','chapters','description','passing_percentage']);
           
            $user_id = $request->session()->get('user.id');
            $input['created_by'] = $user_id;
            $class_subject = ClassSubject::create($input);
      

            $output = ['success' => true,
                        'data' => $class_subject,
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
        // if (!auth()->user()->can('ClassSubject.update')) {
        //     abort(403, 'Unauthorized action.');
        // }
  
        if (request()->ajax()) {
            $campuses=Campus::forDropdown();

            $class_subject = ClassSubject::find($id);
            $classes=Classes::forDropdown(1);

            return view('Curriculum\class_subject.edit')
                ->with(compact('class_subject','campuses','classes'));
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
                $input = $request->only(['campus_id','class_id','name','code','chapters','description','passing_percentage']);
                $class_subject = ClassSubject::findOrFail($id);
                $class_subject->fill($input);
                $class_subject->save();
  
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
                $class_subject = ClassSubject::findOrFail($id);
                $class_subject->delete();

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
