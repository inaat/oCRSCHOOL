<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\ReferenceCount;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;


class SessionController extends Controller
{
    
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
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
    public $STATUS_ACTIVE='ACTIVE';                 //if ACTIVE
    public $STATUS_UPCOMING='UPCOMING';             //if UPCOMING
    public $STATUS_PASSED='PASSED';                 //if PASSED IN PAST
    public function index()
    {
        if (!auth()->user()->can('session.view') && !auth()->user()->can('session.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            $sessions = Session::select(['title', 'status','start_date','end_date','prefix', 'id']);
            return Datatables::of($sessions)
                ->addColumn(
                    'action',
                    '
                    @if($status!="PASSED")
                    <div class="d-flex order-actions">
                    <button data-href="{{action(\'SessionController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_session_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                        &nbsp;
                        <button data-href="{{action(\'SessionController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_session_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>
                    </div>
                    @endif'

                )
                ->editColumn(
                    'status',
                    function ($row) {
                        return (string) view('admin\global_configuration\session.session_status',['status'=>$row->status,'id' => $row->id]);
                    }
                )
                ->editColumn('start_date', ' @if(!empty($start_date)) {{@format_date($start_date)}} @endif')
                ->editColumn('end_date', ' @if(!empty($end_date)) {{@format_date($end_date)}} @endif')
                ->removeColumn('id')
                ->rawColumns(['action','status','title','prefix','start_date','end_date'])
                ->make(true);
        }

        return view('admin\global_configuration\session.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('session.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin\global_configuration\session.create');
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

            $input = $request->only(['title','prefix']);
           $system_settings_id = session()->get('user.system_settings_id');

            DB::beginTransaction();

            $session = Session::create($input);
            
            $new_ref = ReferenceCount::create([
                'ref_type' => 'roll_no',
                'system_settings_id' => $system_settings_id,
                'session_id' => $session->id,
                'session_close' =>'open',
                'ref_count' => 0
            ]
            
        );
       DB::commit();
            $output = ['success' => true,
                            'data' => $session,
                            'msg' => __("session.added_success")
                        ];
        } catch (\Exception $e) {
           DB::rollBack();
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
    public function activateSession($id)
    {
               if (!auth()->user()->can('session.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {

                $session = Session::findOrFail($id);
                DB::beginTransaction();

                if($session->status==$this->STATUS_UPCOMING){
                    $session->status = $this->STATUS_ACTIVE;
                    $session->start_date = \Carbon::now()->format('Y-m-d');

                    $session->save();
                }
                else if($session->status==$this->STATUS_ACTIVE){
                    $session->status = $this->STATUS_PASSED;
                    $session->end_date = \Carbon::now()->format('Y-m-d');
                    $session->save();
                    $ref_count = ReferenceCount::where('session_id',$id)->first();
                    $ref_count->session_close='close';
                    $ref_count->save();
                }
                DB::commit();

                $output = ['success' => true,
                            'msg' => __("session.updated_success")
                            ];
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => false,
                            'msg' => __("lang.something_went_wrong")
                        ];
            }

            return $output;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('session.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            $session = Session::find($id);
            return view('admin\global_configuration\session.edit')
                ->with(compact('session'));
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
        if (!auth()->user()->can('session.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['title','prefix']);

                $session = Session::findOrFail($id);
                $session->title = $input['title'];
                $session->prefix = $input['prefix'];
                $session->save();

                $output = ['success' => true,
                            'msg' => __("session.updated_success")
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

        if (!auth()->user()->can('session.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {


                $session = Session::findOrFail($id);
                $session->delete();

                $output = ['success' => true,
                            'msg' => __("session.deleted_success")
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
     * Gets the roll Number for the given unit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $session_id
     * @return \Illuminate\Http\Response
     */
    public function getRollNo(Request $request)
    {
        if (!empty($request->input('session_id'))) {
            $session_id = $request->input('session_id');
            $ref_roll_no=$this->commonUtil->setAndGetRollNoCount('roll_no',  true,  false ,$session_id);
            $session = Session::findOrFail($session_id);
            $prefix=$session->prefix;
            $roll_no=$this->commonUtil->generateReferenceNumber('roll_no', $ref_roll_no,null,$prefix);


            return $roll_no;
        }
    }
    
}
