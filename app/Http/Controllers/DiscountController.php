<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Campus;
use DB;
use App\Utils\Util;

use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
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

            $discounts = Discount::where('discounts.system_settings_id', $system_settings_id)
                        ->leftjoin('campuses as l', 'discounts.campus_id', '=', 'l.id')
                        ->select(['discounts.id', 'discounts.discount_name',
                           'l.campus_name as campus_name','discounts.discount_amount', 'discount_type']);

            return DataTables::of($discounts)
                           ->addColumn(
                               'action',
                               '<div class="dropdown">
                               <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> @lang("lang.actions")</button>
                               <ul class="dropdown-menu">
                                   <li><a class="dropdown-item edit_discount_button" data-href="{{action(\'DiscountController@edit\',[$id])}}" data-container=".discounts_model"><i class="bx bxs-edit f-16 mr-15 "></i> @lang("lang.edit")</a>
                                   </li>
                               </ul>
                           </div>'
                           )
                           ->editColumn('discount_amount', '{{@num_format($discount_amount)}} @if($discount_type == "percentage") % @endif')
                           ->removeColumn('id')
                           ->rawColumns(['action', 'discounts.discount_name','campus_name','discounts.discount_amount', 'discount_type'])
                           ->make(true);
        }
        return view('admin\discounts.index');
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

        if (!auth()->user()->can('discount.create')) {
            abort(403, 'Unauthorized action.');
        }
        $campuses=Campus::forDropdown();
        return view('admin\discounts.create')->with(compact('campuses'));;
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
            $input = $request->only(['discount_name','campus_id','discount_amount', 'discount_type']);
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $user_id = $request->session()->get('user.id');
            $input['discount_amount'] =  $this->commonUtil->num_uf($input['discount_amount']);

            $input['system_settings_id'] = $system_settings_id;
            $input['created_by'] = $user_id;
            $discount = Discount::create($input);
            $output = ['success' => true,
                            'data' => $discount,
                            'msg' => __("discount.added_success")
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
        $system_settings_id = session()->get('user.system_settings_id');
        $discount = Discount::where('system_settings_id', $system_settings_id)->find($id);
        $campuses=Campus::forDropdown();
        return view('admin\discounts.edit')->with(compact('discount','campuses'));

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
        {
            try{
            $input = $request->only(['discount_name','campus_id','discount_amount', 'discount_type']);
            $system_settings_id = session()->get('user.system_settings_id');
            $input['discount_amount'] =  $this->commonUtil->num_uf($input['discount_amount']);
            $discount = Discount::where('system_settings_id', $system_settings_id)->find($id);
            $discount->fill($input);
            $discount->save();
            $output = ['success' => true,
            'msg' => __("discount.updated_success")
        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
    
                $output = ['success' => false,
            'msg' => __("lang.something_went_wrong")
            ];
            }
    
            return  $output;
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
        //
    }
}
