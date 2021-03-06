<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum\ClassSubject;
use App\Models\Campus;
use App\Models\Classes;

use Yajra\DataTables\Facades\DataTables;
use DB;

class ClassSubjectController extends Controller
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
            $ClassSubjects = ClassSubject::leftjoin('campuses as cam', 'class_subjects.campus_id', '=', 'cam.id')
            ->leftjoin('classes as c', 'class_subjects.class_id', '=', 'c.id')->select(['class_subjects.id',
        'class_subjects.chapters',
        'class_subjects.description',
        'class_subjects.passing_percentage',
        'cam.campus_name as campus_name',
        'c.title as class_name',
        DB::raw("CONCAT(COALESCE(class_subjects.name, ''),' (',COALESCE(class_subjects.code,''),')') as subject_name")

        ]);
            return Datatables::of($ClassSubjects)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html= '<div class="dropdown">
                             <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                             <ul class="dropdown-menu" style="">';
                        $html.='<li><a class="dropdown-item  edit_class_subject_button"data-href="' . action('Curriculum\ClassSubjectController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';               
                        $html.='<li><a class="dropdown-item "href="' . action('Curriculum\ClassSubjectLessonController@show', [$row->id]) . '"><i class="lni lni-eye "></i> ' . __("lang.manage_subject") . '</a></li>';               
                        $html.='<li><a class="dropdown-item  delete_class_subject_button"data-href="' . action('Curriculum\ClassSubjectController@destroy', [$row->id]) . '"><i class="bx bxs-trash "></i> ' . __("lang.delete") . '</a></li>';               
    
                       $html .= '</ul></div>';
    
                        return $html;
                    }
                )
                ->editColumn('passing_percentage', '{{$passing_percentage}}%')
                ->removeColumn('id')
                ->rawColumns(['action','campus_name','class_name','subject_name'])
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
    /**
     * Gets the ClassSubject for 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $class_idcampus_id
     * @return \Illuminate\Http\Response
     */
    public function getSubjects(Request $request)
    {
        if (!empty($request->input('class_id'))) {
            $class_id = $request->input('class_id');
            
            $classSubject = ClassSubject::forDropdown($class_id);
            $html = '<option value="">' . __('lang.please_select') . '</option>';
            //$html = '';
            if (!empty($classSubject)) {
                foreach ($classSubject as $id => $name) {
                    $html .= '<option value="' . $id .'">' . $name. '</option>';
                }
            }

            return $html;
        }
    }
}
