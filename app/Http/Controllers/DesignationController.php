<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Yajra\DataTables\Facades\DataTables;
class DesignationController extends Controller
{
    /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
               
  public function index()
  {
      if (!auth()->user()->can('designation.view') && !auth()->user()->can('designation.create')) {
          abort(403, 'Unauthorized action.');
      }

      if (request()->ajax()) {

          $designations = Designation::select(['title', 'id']);
          return Datatables::of($designations)
              ->addColumn(
                  'action',
                  '
                  <div class="d-flex order-actions">
                  <button data-href="{{action(\'DesignationController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_designation_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("global_lang.edit")</button>
                      &nbsp;
                      <button data-href="{{action(\'DesignationController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_designation_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("global_lang.delete")</button>
                  </div>
                  '

              )
              
              ->removeColumn('id')
              ->rawColumns(['action','title'])
              ->make(true);
      }

      return view('admin\global_configuration\designation.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      // if (!auth()->user()->can('designation.create')) {
      //     abort(403, 'Unauthorized action.');
      // }
      return view('admin\global_configuration\designation.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      // if (!auth()->user()->can('designation.create')) {
      //     abort(403, 'Unauthorized action.');
      // }

      try {
          $input = $request->only(['title']);

          $system_settings_id = request()->session()->get('user.system_settings_id');
          $input['system_settings_id'] = $system_settings_id;
          $designation = Designation::create($input);
        

          $output = ['success' => true,
                          'data' => $designation,
                          'msg' => __("designation.added_success")
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
      // if (!auth()->user()->can('designation.update')) {
      //     abort(403, 'Unauthorized action.');
      // }

      if (request()->ajax()) {

          $designation = Designation::find($id);
          return view('admin\global_configuration\designation.edit')
              ->with(compact('designation'));
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
      // if (!auth()->user()->can('designation.update')) {
      //     abort(403, 'Unauthorized action.');
      // }

      if (request()->ajax()) {
          try {
              $input = $request->only(['title']);

              $designation = Designation::findOrFail($id);
              $designation->title = $input['title'];
              $designation->save();

              $output = ['success' => true,
                          'msg' => __("designation.updated_success")
                          ];
          } catch (\Exception $e) {
              \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

              $output = ['success' => false,
                          'msg' => __("global_lang.something_went_wrong")
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

      // if (!auth()->user()->can('designation.delete')) {
      //     abort(403, 'Unauthorized action.');
      // }

      if (request()->ajax()) {
          try {


              $designation = Designation::findOrFail($id);
              $designation->delete();

              $output = ['success' => true,
                          'msg' => __("designation.deleted_success")
                          ];
          } catch (\Exception $e) {
              \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

              $output = ['success' => false,
                          'msg' => __("global_lang.something_went_wrong")
                      ];
          }

          return $output;
      }
  }
}
