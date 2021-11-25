<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hrm\HrmShift;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;
class HrmShiftController extends Controller
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
     * @return Response
     */
    public function index()
    {

        if (request()->ajax()) {
            $shifts = HrmShift::
                        select([
                            'id',
                            'name',
                            'type',
                            'start_time',
                            'end_time',
                            'holidays'
                        ]);

            return Datatables::of($shifts)
                ->editColumn('start_time', function ($row) {
                    $start_time_formated = $this->commonUtil->format_time($row->start_time);
                    return $start_time_formated ;
                })
                ->editColumn('end_time', function ($row) {
                    $end_time_formated = $this->commonUtil->format_time($row->end_time);
                    return $end_time_formated ;
                })
                ->editColumn('type', function ($row) {
                    return __('hrm.' . $row->type);
                })
                ->editColumn('holidays', function ($row) {
                    if (!empty($row->holidays)) {
                        $holidays = array_map(function ($item) {
                            return __('hrm.' . $item);
                        }, $row->holidays);
                        return implode(', ', $holidays);
                    }
                })
                ->addColumn('action', function ($row) {
                    $html = '<a href="#" data-href="' . action('HRM\HrmShiftController@edit', [$row->id]) . '" data-container="#edit_shift_modal" class="btn-modal btn btn-xs btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> ' . __("messages.edit") . '</a> &nbsp;<a href="#" data-href="' . action('HRM\HrmShiftController@getAssignUsers', [$row->id]) . '" data-container="#user_shift_modal" class="btn-modal btn btn-xs btn-success"><i class="fas fa-users" aria-hidden="true"></i> ' . __("hrm.assign_users") . '</a>';
                    return $html;
                })
                ->removeColumn('id')
                ->rawColumns(['action', 'type'])
                ->make(true);
        }
        return view('Hrm\shift.index');

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $days = $this->commonUtil->getDays();

        return view('Hrm\shift.create')->with(compact('days'));;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
     
        try {
            $input = $request->only(['name', 'type', 'holidays']);

            if ($input['type'] != 'flexible_shift') {
                $input['start_time'] = $this->commonUtil->uf_time($request->input('start_time'));
                $input['end_time'] = $this->commonUtil->uf_time($request->input('end_time'));
            } else {
                $input['start_time'] = null;
                $input['end_time'] = null;
            }
            $user_id = $request->session()->get('user.id');
            $input['created_by'] = $user_id;
            HrmShift::create($input);

            $output = ['success' => true,
                            'msg' => __("hrm.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")

                        ];
        }

        return $output;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('essentials::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        
        $shift = HrmShift::findOrFail($id);

        $days = $this->commonUtil->getDays();

        return view('Hrm\shift.create')->with(compact('shift', 'days'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
           

            $input = $request->only(['name', 'type', 'holidays']);

            if ($input['type'] != 'flexible_shift') {
                $input['start_time'] = $this->commonUtil->uf_time($request->input('start_time'));
                $input['end_time'] = $this->commonUtil->uf_time($request->input('end_time'));
            } else {
                $input['start_time'] = null;
                $input['end_time'] = null;
            }

            if (!empty($input['holidays'])) {
                $input['holidays'] = json_encode($input['holidays']);
            } else {
                $input['holidays'] = null;
            }

            $shift = HrmShift::where('id', $id)
                        ->update($input);

            $output = ['success' => true,
                                'msg' => __("hrm.updated_success")
                            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                
            $output = ['success' => false,
                                'msg' => __("messages.something_went_wrong")

                            ];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAssignUsers($shift_id)
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->commonUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || $this->commonUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
            abort(403, 'Unauthorized action.');
        }
        $shift = HrmShift::where('business_id', $business_id)
                    ->with(['user_shifts'])
                    ->findOrFail($shift_id);

        $users = User::forDropdown($business_id, false);

        $user_shifts = [];

        if (!empty($shift->user_shifts)) {
            foreach ($shift->user_shifts as $user_shift) {
                $user_shifts[$user_shift->user_id] = [
                    'start_date' => !empty($user_shift->start_date) ? $this->commonUtil->format_date($user_shift->start_date) : null,
                    'end_date' => !empty($user_shift->end_date) ? $this->commonUtil->format_date($user_shift->end_date) : null
                ];
            }
        }

        return view('essentials::attendance.add_shift_users')
                ->with(compact('shift', 'users', 'user_shifts'));
    }

    public function postAssignUsers(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->commonUtil->is_admin(auth()->user(), $business_id);

        if (!(auth()->user()->can('superadmin') || $this->commonUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $shift_id = $request->input('shift_id');
            $shift = HrmShift::where('business_id', $business_id)
                        ->find($shift_id);

            $user_shifts = $request->input('user_shift');
            $user_shift_data = [];
            $user_ids = [];
            foreach ($user_shifts as $key => $value) {
                if (!empty($value['is_added'])) {
                    $user_ids[] = $key;
                    EssentialsUserHrmShift::updateOrCreate(
                        [
                            'essentials_shift_id' => $shift_id,
                            'user_id' => $key
                        ],
                        [
                            'start_date' => !empty($value['start_date']) ? $this->commonUtil->uf_date($value['start_date']) : null,
                            'end_date' => !empty($value['end_date']) ? $this->commonUtil->uf_date($value['end_date']) : null,
                        ]
                    );
                }
            }

            EssentialsUserHrmShift::where('essentials_shift_id', $shift_id)
                            ->whereNotIn('user_id', $user_ids)
                            ->delete();
            
            $output = ['success' => true,
                            'msg' => __("lang_v1.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")

                        ];
        }

        return $output;
    }
}
