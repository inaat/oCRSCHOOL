<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSection;
use App\Models\Classes;
use App\Models\Campus;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;
class ClassSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if (!auth()->user()->can('discount.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $system_settings_id = session()->get('user.system_settings_id');

            $classes = ClassSection::where('class_sections.system_settings_id', $system_settings_id)
                        ->leftjoin('campuses as c', 'class_sections.campus_id', '=', 'c.id')
                        ->leftjoin('classes as l', 'class_sections.class_id', '=', 'l.id')
                        ->select(['class_sections.id', 'class_sections.section_name','l.title as class_name',
                           'c.campus_name as campus_name']);

            return DataTables::of($classes)
                           ->addColumn(
                               'action',
                               '<div class="dropdown">
                               <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang("messages.actions")</button>
                               <ul class="dropdown-menu">
                                   <li><a class="dropdown-item edit_class_section_button" data-href="{{action(\'ClassSectionController@edit\',[$id])}}" data-container=".discounts_model"><i class="bx bxs-edit f-16 mr-15 "></i> @lang("messages.edit")</a>
                                   </li>
                               </ul>
                           </div>'
                           )
                           ->removeColumn('id')
                           ->rawColumns(['action', 'classes.title','campus_name','class_name'])
                           ->make(true);
        }
        return view('admin\class_section.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('discount.create')) {
            abort(403, 'Unauthorized action.');
        }
        $system_settings_id = session()->get('user.system_settings_id');
        $campuses=Campus::forDropdown();
        $classes=Classes::forDropdown($system_settings_id);
        return view('admin\class_section.create')->with(compact('campuses','classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (!auth()->user()->can('session.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['section_name','campus_id','class_id']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $class_section=ClassSection::create($input);
            $output = ['success' => true,
                            'data' => $class_section,
                            'msg' => __("class_section.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                            'msg' => __("global_lang.something_went_wrong")
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
        $system_settings_id = session()->get('user.system_settings_id');
        $sections = ClassSection::where('system_settings_id', $system_settings_id)->find($id);
        $campuses=Campus::forDropdown();
        $classes=Classes::forDropdown($system_settings_id);
        return view('admin\class_section.edit')->with(compact('classes','campuses','sections'));

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
        try {
            $input = $request->only(['section_name','campus_id','class_id']);
            $system_settings_id = session()->get('user.system_settings_id');
            $sections = ClassSection::where('system_settings_id', $system_settings_id)->find($id);
            $sections->fill($input);
            $sections->save();
            $output = ['success' => true,
            'msg' => __("class_section.updated_success")
        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
    
            $output = ['success' => false,
            'msg' => __("messages.something_went_wrong")
            ];
        }
    
        return  $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
