<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeHead;
use App\Models\Campus;
use App\Models\Classes;

use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;
class FeeHeadController extends Controller
{
    protected $commonUtil;
    
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
        if (!auth()->user()->can('discount.access')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $system_settings_id = session()->get('user.system_settings_id');

            $fee_heads = FeeHead::
                          leftjoin('campuses', 'fee_heads.campus_id', '=', 'campuses.id')
                        ->leftjoin('classes as c', 'fee_heads.class_id', '=', 'c.id')
                        ->whereNotNull('fee_heads.class_id')
                        ->select(['fee_heads.id', 'fee_heads.description', 'fee_heads.amount','campuses.campus_name as campus_name','c.title as class_name']);
          
            return DataTables::of($fee_heads)
                           ->addColumn(
                               'action',
                               '<div class="d-flex order-actions">

                               <button data-href="{{action(\'FeeHeadController@edit\', [$id])}}" class="btn btn-sm btn-primary edit_fee_head_button"><i class="bx bxs-edit f-16 mr-15 text-white"></i> @lang("lang.edit")</button>
                                   &nbsp;


                                   <button data-href="{{action(\'FeeHeadController@destroy\', [$id])}}" class="btn btn-sm btn-danger delete_fee_head_button"><i class="bx bxs-trash f-16 text-white"></i> @lang("lang.delete")</button>

                               </div>'
                           )
                           ->editColumn(
                            'amount',
                            '<span class="amount" data-orig-value="{{$amount}}">@format_currency($amount)</span>'
                        )
                           ->removeColumn('id')
                           ->rawColumns(['action', 'campus_name','class_name','description','amount'])
                           ->make(true);
        }
        return view('fee-heads.index');
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
        return view('fee-heads.create')->with(compact('campuses'));
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
            $input = $request->only(['campus_id','class_id','description','amount']);
            $input['amount']=$this->commonUtil->num_uf($input['amount']);
            $fee_head = FeeHead::create($input);
            $output = ['success' => true,
                            'data' => $fee_head,
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
        $fee_head= FeeHead::find($id);
        $system_settings_id = session()->get('user.system_settings_id');
        $campuses=Campus::forDropdown();
        $classes=Classes::forDropdown($system_settings_id,$fee_head->campus_id);
        return view('fee-heads.edit')->with(compact('classes', 'fee_head', 'campuses'));
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
            $input = $request->only(['campus_id','class_id','description','amount']);
            $input['amount']=$this->commonUtil->num_uf($input['amount']);
            $fee_head = FeeHead::find($id);
            $fee_head->fill($input);
            $fee_head->save();
            $output = ['success' => true,
            'msg' => __("lang.updated_success")
        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
            'msg' => __("lang.something_went_wrong")
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
        if (request()->ajax()) {
            try {
                $fee_head =FeeHead::findOrFail($id);
                $fee_head->delete();

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
