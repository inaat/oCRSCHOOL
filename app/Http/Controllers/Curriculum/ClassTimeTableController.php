<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum\ClassTimeTablePeriod;
use App\Models\Curriculum\ClassTimeTable;
use App\Models\Curriculum\ClassSubject;
use App\Models\ClassSection;
use App\Models\Campus;
use App\Utils\Util;
use App\Models\Classes;
use Yajra\DataTables\Facades\DataTables;
use DB;
use File;

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

        $system_settings_id = session()->get('user.system_settings_id');

        $check_period =[];
        $class_time_table_title=[];
        $sections=ClassSection::with(['campuses','classes','time_table','time_table.subjects','time_table.subjects.employees','time_table.periods']);
        if (request()->has('campus_id')) {
            $campus_id = request()->get('campus_id');
            if (!empty($campus_id)) {
                $sections->where('class_sections.campus_id', $campus_id);
               
            }
        }else{
            $campus_id=null;
        }
        if (request()->has('class_id')) {
            $class_id = request()->get('class_id');
            if (!empty($class_id)) {
                $sections->where('class_sections.class_id', $class_id);
               
            }
        }
        else{
            $class_id=null;
        }
        if (request()->has('class_section_id')) {
            $class_section_id = request()->get('class_section_id');
            if (!empty($class_section_id)) {
                $sections->where('class_sections.id', $class_section_id);
               
            }
        }  else{
            $class_section_id=null;
        }
        $sections=$sections->get();
        foreach ($sections as $section){
            foreach ($section->time_table as $time_table){
                $inArray=in_array($time_table->periods->id,$check_period );
                if($inArray ==false){
                    $class_time_table_title[]= $this->commonUtil->format_time($time_table->periods->start_time).' To '.$this->commonUtil->format_time($time_table->periods->end_time).' '.$time_table->periods->name;
                    array_push($check_period,$time_table->periods->id);
                }
            }
        }        
        $campuses=Campus::forDropdown();
        if (!empty($campus_id)) {
            $classes=Classes::forDropdown($system_settings_id, false, $campus_id);
        }else{
            $classes=[];
        }
    
        if (!empty($class_id)) {
            $class_sections=ClassSection::forDropdown($system_settings_id, false, $class_id);
        }else{
            $class_sections=[];
        }
        if (request()->has('print')) {
            $print = request()->get('print');
            if (!empty($print)) {
                $snappy=$this->generateFeeCard($sections,$class_time_table_title);
                return $snappy->stream();            }
        }
        //dd($class_time_table_title);
        return view('Curriculum\class_time_table.index')->with(compact('classes','class_sections','sections','class_time_table_title','campuses','campus_id','class_id','class_section_id'));
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
            $input = $request->only(['campus_id','subject_id','class_id','class_section_id','period_id']);
            $checkClassTimeTable = ClassTimeTable::where('campus_id', $input['campus_id'])->where('class_id',$input['class_id'])
           ->where('class_section_id',$input['class_section_id'])->where('period_id',$input['period_id'])->first();
            //dd($checkClassTimeTable);
            if (Empty($checkClassTimeTable)) {
               ClassTimeTable::create($input);

                $output = ['success' => true,
                            'msg' => __("lang.added_success")
                        ];
            }else{
                $output = ['success' => false,
                'msg' => __("lang.already_exists")

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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $system_settings_id = session()->get('user.system_settings_id');
        $classTimeTable= ClassTimeTable::findOrFail($id);
        $campuses=Campus::forDropdown();
        $classes=Classes::forDropdown($system_settings_id, false, $classTimeTable->campus_id);
        $class_sections=ClassSection::forDropdown($system_settings_id, false, $classTimeTable->class_id);

        $classSubject = ClassSubject::forDropdown($classTimeTable->class_id);
        $classTimeTablePeriod = ClassTimeTablePeriod::forDropdown($classTimeTable->campus_id);

        return view('Curriculum\class_time_table.edit')->with(compact('campuses','classes','class_sections','classSubject','classTimeTablePeriod','classTimeTable'));
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
                $input = $request->only(['campus_id','subject_id','class_id','class_section_id','period_id']);
                $time_table =ClassTimeTable::findOrFail($id);
                $time_table->fill($input);
                $time_table->save();
  
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
                $input = $request->only(['campus_id','subject_id','class_id','class_section_id','period_id']);
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
    private function generateFeeCard($sections,$class_time_table_title)
    {
      
        $sections=$sections;
        $class_time_table_title=$class_time_table_title;
        $logo = 'Pk';
        if (File::exists(public_path('uploads/pdf/time_table.pdf'))) {
            File::delete(public_path('uploads/pdf/time_table.pdf'));
        }
        $pdf_name='time_table'.'.pdf';
        $snappy  = \WPDF::loadView('school-printing/time_table.print', compact('sections','class_time_table_title'));
        $headerHtml = view()->make('school-printing/time_table._header', compact('logo'))->render();
        $footerHtml = view()->make('school-printing/time_table._footer')->render();
        $snappy->setOption('header-html', $headerHtml);
        $snappy->setOption('footer-html', $footerHtml);
        $snappy->setPaper('a4')->setOption('orientation', 'landscape')->setOption('margin-top', 30)->setOption('margin-left', 5)->setOption('margin-right', 5)->setOption('margin-bottom', 15);
        $snappy->save('uploads/pdf/'.$pdf_name);//save pdf file

        return $snappy;
    }
}