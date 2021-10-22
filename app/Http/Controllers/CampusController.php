<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Utils\AccountTransactionUtil;
use App\Models\Campus;
use DB;
use Yajra\DataTables\Facades\DataTables;

class CampusController extends Controller
{
    protected $accountTransactionUtil;

    /**
     * Constructor
     *
     * @param AccountTransactionUtil $accountTransactionUtil
     * @return void
     */
    public function __construct(AccountTransactionUtil $accountTransactionUtil)
    {
        $this->accountTransactionUtil = $accountTransactionUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('campus.create')) {
            abort(403, 'Unauthorized action.');
        }

        $system_settings_id = session()->get('user.system_settings_id');
        if (request()->ajax()) {
            $campuses = Campus::where('system_settings_id', $system_settings_id)
                                ->select(['id','campus_name','registration_code','registration_date','mobile','phone','address']);
            
            return DataTables::of($campuses)
                            ->addColumn(
                                'action',
                                '<div class="dropdown">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang("messages.actions")</button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item "href="{{action(\'CampusController@edit\',[$id])}}" ><i class="bx bxs-edit f-16 mr-15 "></i> @lang("messages.edit")</a>
                                    </li>
                                </ul>
                            </div>')
                            ->editColumn('registration_date', function ($row) {
                                return $this->accountTransactionUtil->format_date($row->registration_date);
                            })
                            ->removeColumn('id')
                            ->rawColumns(['action','campus_name','registration_code','registration_date','mobile','phone','address','address'])
                            ->make(true);
        }



      return view('admin\campuses.index');

    }
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('campus.update')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin\campuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('campus.create')) {
            abort(403, 'Unauthorized action.');
        }
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['campus_name','registration_code','registration_date','mobile','phone','address']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            if (!empty($input['registration_date'])) {
                $input['registration_date'] = $this->accountTransactionUtil->uf_date($input['registration_date']);
            }
            DB::beginTransaction();

            $campus=Campus::create($input);
            $this->accountTransactionUtil->create_Account($input['campus_name'], $user_id, $input['registration_code'], $system_settings_id);
    
            DB::commit();
            $output = ['success' => true,
        'msg' => __("campus.added_success")
    ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
        'msg' => __("messages.something_went_wrong")
        ];
        }

        return redirect('campuses')->with('status', $output);
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
        if (!auth()->user()->can('campus.update')) {
            abort(403, 'Unauthorized action.');
        }
        $system_settings_id = session()->get('user.system_settings_id');
        $campuses = Campus::where('system_settings_id', $system_settings_id)->find($id);
       
        return view('admin\campuses.edit')->with(compact('campuses'));

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
        if (!auth()->user()->can('campus.update')) {
            abort(403, 'Unauthorized action.');
        }
        try{
        $input = $request->only(['campus_name','registration_code','registration_date','mobile','phone','address']);
        $system_settings_id = session()->get('user.system_settings_id');
        if (!empty($input['registration_date'])) {
            $input['registration_date'] = $this->accountTransactionUtil->uf_date($input['registration_date']);
        }
        $campuses = Campus::where('system_settings_id', $system_settings_id)->find($id);
        $campuses->fill($input);
        $campuses->save();
        $output = ['success' => true,
        'msg' => __("campus.updated_success")
    ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
        'msg' => __("messages.something_went_wrong")
        ];
        }

        return redirect('campuses')->with('status', $output);
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
