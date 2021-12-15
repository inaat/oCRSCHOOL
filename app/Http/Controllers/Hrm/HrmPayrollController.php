<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campus;
use App\Models\Hrm\HrmEmployee;
use App\Models\Hrm\HrmDeduction;
use App\Models\Hrm\HrmAllowance;
use App\Models\Hrm\HrmAllowanceTransactionLine;
use App\Models\Hrm\HrmDeductionTransactionLine;
use App\Utils\Util;
use App\Utils\EmployeeUtil;
use App\Models\HRM\HrmTransaction;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


use DB;

class HrmPayrollController extends Controller
{
    /**
     * All Utils instance.
     *
     */
   
    protected $employeeUtil;

    /**
     * Constructor
     *
    * @param EmployeeUtil $employeeUtil
     * @return void
     */
    public function __construct(EmployeeUtil $employeeUtil)
    {
        $this->employeeUtil = $employeeUtil;
        $this->employee_status_colors = [
            'active' => 'bg-success',
            'inactive' => 'bg-info',
            'resign' => 'bg-danger',
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
    public function index()
    {    //dd($this->getListPayrollTransaction(1)->get());
        if (request()->ajax()) {
            $fee_transactions=$this->getListPayrollTransaction(1);
            $datatable = Datatables::of($fee_transactions)
        ->addColumn(
            'action',
            function ($row) {
                $html= '<div class="dropdown">
                     <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                     <ul class="dropdown-menu" style="">';
                if ($row->payment_status == "due") {
                    $html.='<li><a class="dropdown-item "href="' . action('HRM\HrmPayrollController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';
                }
                if ($row->payment_status != "paid" && (auth()->user()->can("sell.create") || auth()->user()->can("direct_sell.access")) && auth()->user()->can("sell.payments")) {
                    $html .= '<li><a href="' . action('HRM\HrmTransactionPaymentController@addPayment', [$row->id]) . '" class="dropdown-item add_payment_modal"><i class="fas fa-money-bill-alt"></i> ' . __("lang.add_payment") . '</a></li>';
                }
                $html .= '<li><a href="' . action('HRM\HrmTransactionPaymentController@show', [$row->id]) . '" class="dropdown-item view_payment_modal"><i class="fas fa-money-bill-alt"></i> ' . __("lang.view_payments") . '</a></li>';

                $html .= '</ul></div>';

                return $html;
            }
        )
        ->editColumn(
            'payment_status',
            function ($row) {
                $payment_status = HrmTransaction::getPaymentStatus($row);
                return (string) view('Hrm\payroll.partials.payment_status', ['payment_status' => $payment_status, 'id' => $row->id]);
            }
        )
        ->editColumn('employee_name', function ($row) {
            return ucwords($row->employee_name);
        })
        ->editColumn('father_name', function ($row) {
            return ucwords($row->father_name);
        })
        ->editColumn('employeeID', function ($row) {
            return ucwords($row->employeeID);
        })
     
         ->editColumn('status', function ($row) {
             $status_color = !empty($this->employee_status_colors[$row->status]) ? $this->employee_status_colors[$row->status] : 'bg-gray';
             $status='<span class="badge badge-mark ' . $status_color .'">' .ucwords($row->status).   '</span>';
             return $status;
         })
        ->addColumn('total_remaining', function ($row) {
            $total_remaining =  $row->final_total - $row->total_paid;
            $total_remaining_html = '<span class="payment_due" data-orig-value="' . $total_remaining . '">' . $this->employeeUtil->num_f($total_remaining, true) . '</span>';

            
            return $total_remaining_html;
        })
        ->editColumn(
            'total_paid',
            '<span class="total-paid" data-orig-value="{{$total_paid}}">@format_currency($total_paid)</span>'
        )
        ->editColumn(
            'final_total',
            '<span class="final-total" data-orig-value="{{$final_total}}">@format_currency($final_total)</span>'
        )
        ->editColumn('transaction_date', '{{@format_date($transaction_date)}}')
        ->filterColumn('employeeID', function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('hrm_employees.employeeID', 'like', "%{$keyword}%");
            });
        })
        ->filterColumn('employee_name', function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('hrm_employees.first_name', 'like', "%{$keyword}%");
            });
        })
        ->filterColumn('father_name', function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('hrm_employees.father_name', 'like', "%{$keyword}%");
            });
        })
        ->removeColumn('id');
     
      

            $rawColumns = ['action','status','campus_name','transaction_date','ref_no','payment_status','final_total','total_remaining','total_paid','employeeID'];
        
            return $datatable->rawColumns($rawColumns)
              ->make(true);
        }
        $campuses=Campus::forDropdown();
        

        return view('Hrm\payroll.index')->with(compact('campuses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $system_settings_id = session()->get('user.system_settings_id');
       

        $campuses=Campus::forDropdown();
        $now_month = \Carbon::now()->month;
        
        return view('Hrm\payroll.create')->with(compact('campuses', 'now_month'));
    }
    public function payrollAssignSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'campus_id' => "required",
            'month_year' => "required"
        ]);
        $month_year=$input['month_year'];
        $status=$input['status'];
        $campus_id=$input['campus_id'];
        $month_year_arr = explode('/', request()->input('month_year'));
        $month = $month_year_arr[0];
        $year = $month_year_arr[1];
     
        $transaction_date = $year . '-' . $month . '-01';
        $start_date = $transaction_date;
        $end_date = \Carbon::parse($start_date)->lastOfMonth();
        $month_name = $end_date->format('F');
        $campuses=Campus::forDropdown();

        //check if payrolls exists for the month year
        $payrolls = HrmTransaction::whereDate('transaction_date', $transaction_date)
                    ->get('employee_id', 'first_name');
        $already_exists = [];
        if (!empty($payrolls)) {
            foreach ($payrolls as $key => $value) {
                array_push($already_exists, $value->employee_id);
            }
        }
        $employees=$this->employeeUtil->getEmployeeList($campus_id, $already_exists);
        $allowances = HrmAllowance::get();
        $deductions = HrmDeduction::get();
        return view('Hrm\payroll.payroll_assign')->with(compact('employees', 'status', 'campuses', 'campus_id', 'month_year', 'month_name', 'transaction_date', 'year', 'deductions', 'allowances'));
    }
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }
        // dd(array_sum(array_column($request->input('allowances'), 'amount')));
      // dd($request);
     
        try {
            $employee_ids = request()->input('employee_checked');
            $month_year_arr = explode('/', request()->input('month_year'));
            $month = $month_year_arr[0];
            $year = $month_year_arr[1];
    
            $transaction_date = $year . '-' . $month . '-01';
           
            //check if payrolls exists for the month year
            $payrolls = HrmTransaction::WhereIn('employee_id', $employee_ids)
                        ->whereDate('transaction_date', $transaction_date)
                        ->get();
    
            $add_payroll_for = array_diff($employee_ids, $payrolls->pluck('employee_id')->toArray());
            if (!empty($add_payroll_for)) {
                DB::beginTransaction();
                $input=$request->input();
                foreach ($add_payroll_for as $employee_id) {
                    $employee = HrmEmployee::find($employee_id);
                    $transaction=$this->createPayrollTransaction($employee, $request);
                }
         
                DB::commit();
                $output = ['success' => true,
                'msg' => __("hrm.added_success")
            ];
            } else {
                return redirect('hrm-payroll/create')
                ->with(
                    'status',
                    [
                        'success' => true,
                        'msg' => __("payroll_already_added_for_given_user")
                    ]
                );
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }
        return redirect('hrm-payroll')->with('status', $output);
    }



    public function createPayrollTransaction($employee, $request)
    {
        $user_id = $request->session()->get('user.id');
        $system_settings_id = $request->session()->get('user.system_settings_id');
        $basic_salary =  $this->employeeUtil->num_uf($employee->basic_salary);
        $month_year_arr = explode('/', $request->input('month_year'));
        $month = $month_year_arr[0];
        //Update reference count
        $ob_ref_count = $this->employeeUtil->setAndGetReferenceCount('payroll', false, true);
        $total_allowance=$this->sum_deduction_allowance($request->input('allowances'));
        $total_deduction=$this->sum_deduction_allowance($request->input('deductions'));
        $transaction = HrmTransaction::create([
                    'campus_id' => $employee->campus_id,
                    'type' => 'pay_roll',
                    'status' => $request->input('status'),
                    'payroll_group_name' => $request->input('payroll_group_name'),
                    'allowances_amount'=>$this->employeeUtil->num_uf($request->input('allowance_amount')),
                    'deductions_amount'=>$this->employeeUtil->num_uf($request->input('deduction_amount')),
                    'payment_status' => 'due',
                    'ref_no'=> $this->employeeUtil->generateReferenceNumber('payroll', $ob_ref_count, $system_settings_id),
                    'session_id'=>$this->employeeUtil->getActiveSession(),
                    'month' => $month,
                    'employee_id' => $employee->id,
                    'transaction_date' =>$request->input('transaction_date'),
                    'final_total' => ($basic_salary+$total_allowance)-$total_deduction,
                    'basic_salary'=>$basic_salary,
                    'created_by' => $user_id,
                ]);
        
        $lines_formatted = $this->hrmAllowanceTransactionLine($request->input('allowances'), $transaction->id);
        $deduction_lines_formatted =  $this->hrmDeductionTransactionLine($request->input('deductions'), $transaction->id);
        
        if (!empty($lines_formatted)) {
            $transaction->allowance()->saveMany($lines_formatted);
        }
        if (!empty($lines_formatted)) {
            $transaction->deduction()->saveMany($deduction_lines_formatted);
        }
        return $transaction;
    }


    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $transaction = HrmTransaction::where('id', $id)->where('payment_status', '=', 'due')
        ->with(['employee', 'campus','allowance','allowance.hrm_allowance','deduction','deduction.hrm_deduction'])
        ->first();
        
        $allowance_id_remover=[];
        if (!empty($transaction->allowance)) {
            foreach ($transaction->allowance as $key => $value) {
                array_push($allowance_id_remover, $value->allowance_id);
            }
        }
        $deduction_id_remover=[];
        if (!empty($transaction->deduction)) {
            foreach ($transaction->deduction as $key => $value) {
                array_push($deduction_id_remover, $value->deduction_id);
            }
        }
        $allowances = HrmAllowance::WhereNotIn('id', $allowance_id_remover)->get();
        $deductions = HrmDeduction::WhereNotIn('id', $deduction_id_remover)->get();
         
       
        return view('Hrm\payroll.edit')->with(compact('transaction', 'deductions', 'allowances'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $input=$request->input();
            DB::beginTransaction();

            $payroll = HrmTransaction::with(['allowance','deduction'])->where('payment_status', '!=', 'paid')->where('type', 'pay_roll')
            ->findOrFail($id);
            $payroll->final_total = $this->employeeUtil->num_uf($input['gross_final_total']);
            $payroll->deductions_amount = $this->employeeUtil->num_uf($input['deduction_amount']);
            $payroll->allowances_amount = $this->employeeUtil->num_uf($input['allowance_amount']);
            $payroll->save();
            $lines_formatted = $this->hrmAllowanceTransactionLine($input['allowances'], $id);
            $deduction_lines_formatted =  $this->hrmDeductionTransactionLine($input['deductions'], $id);
            if (!empty($lines_formatted)) {
                $payroll->allowance()->saveMany($lines_formatted);
            }
            if (!empty($lines_formatted)) {
                $payroll->deduction()->saveMany($deduction_lines_formatted);
            }
            DB::commit();
            $output = ['success' => true,
        'msg' => __("hrm.updated_success")
    ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
    
            $output = ['success' => false,
        'msg' => __("messages.something_went_wrong")
    ];
        }
        return redirect('hrm-payroll')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
    }


    public function hrmAllowanceTransactionLine($allowances, $transaction_id)
    {
        $lines_formatted = [];
        foreach ($allowances as $key => $value) {
            if (!empty($value['allowance_line_id'])) {
                if (!empty($value['is_enabled'])) {
                    $allowance_line=HrmAllowanceTransactionLine::where('hrm_transaction_id', $transaction_id)->where('id', $value['allowance_line_id'])->first();
                    $allowance_line->amount=$this->employeeUtil->num_uf($value['amount']);
                    $allowance_line->save();
                } else {
                    $delete_allowance_line=HrmAllowanceTransactionLine::where('hrm_transaction_id', $transaction_id)->where('id', $value['allowance_line_id'])->first();
                    $delete_allowance_line->delete();
                }
            } else {
                if (!empty($value['is_enabled'])) {
                    $line=[
            'is_enabled'=>$value['is_enabled'],
            'allowance_id'=>$value['allowance_id'],
            'hrm_transaction_id'=>$transaction_id,
            'amount'=>$this->employeeUtil->num_uf($value['amount'])
        ];
                    $lines_formatted[] = new HrmAllowanceTransactionLine($line);
                }
            }
        }

        return $lines_formatted;
    }
    public function hrmDeductionTransactionLine($deductions, $transaction_id)
    {
        $lines_formatted = [];
        $edit_lines_formatted=[];
        
        foreach ($deductions as $key => $value) {
            if (!empty($value['deduction_line_id'])) {
                if (!empty($value['is_enabled'])) {
                    $deduction_line=HrmDeductionTransactionLine::where('hrm_transaction_id', $transaction_id)->where('id', $value['deduction_line_id'])->first();
                    $deduction_line->amount=$this->employeeUtil->num_uf($value['amount']);
                    $deduction_line->divider=$value['divider'];
                    $deduction_line->save();
                } else {
                    $delete_deduction_line=HrmDeductionTransactionLine::where('hrm_transaction_id', $transaction_id)->where('id', $value['deduction_line_id'])->first();
                    $delete_deduction_line->delete();
                }
            } else {
                if (!empty($value['is_enabled'])) {
                    $line=[
                'is_enabled'=>$value['is_enabled'],
                'divider'=>$value['divider'],
                'deduction_id'=>$value['deduction_id'],
                'hrm_transaction_id'=>$transaction_id,
                'amount'=>$this->employeeUtil->num_uf($value['amount'])
            ];
                    $lines_formatted[] = new HrmDeductionTransactionLine($line);
                }
            }
        }

        return $lines_formatted;
    }



    /**
    * common function to get
    * list sell
    * @param int $system_settings_id
    *
    * @return object
    */
    public function getListPayrollTransaction($system_settings_id)
    {
        $transactions = HrmTransaction::leftJoin('hrm_employees', 'hrm_transactions.employee_id', '=', 'hrm_employees.id')
           
                 ->leftJoin('users as u', 'hrm_transactions.created_by', '=', 'u.id')
                ->leftJoin('sessions', 'hrm_transactions.session_id', '=', 'sessions.id')
                ->join(
                    'campuses AS campus',
                    'hrm_transactions.campus_id',
                    '=',
                    'campus.id'
                )
                ->where('hrm_transactions.status', 'final')
                ->where('hrm_transactions.type', 'pay_roll')
                ->select(
                    'hrm_transactions.id',
                    'hrm_transactions.transaction_date',
                    'hrm_transactions.ref_no',
                    'hrm_transactions.payment_status',
                    'hrm_transactions.final_total',
                    'hrm_employees.father_name',
                    'hrm_employees.employeeID as employeeID',
                    'hrm_employees.status',
                    DB::raw("concat(sessions.title, ' - ' '(', sessions.status, ') ') as session_info"),
                    DB::raw("CONCAT(COALESCE(hrm_employees.first_name, ''),' ',COALESCE(hrm_employees.last_name,'')) as employee_name"),
                    DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by"),
                    DB::raw('(SELECT SUM(IF(TP.is_return = 1,-1*TP.amount,TP.amount)) FROM hrm_transaction_payments AS TP WHERE
                        TP.hrm_transaction_id=hrm_transactions.id) as total_paid'),
                    'campus.campus_name as campus_name',
                )->orderBy('hrm_transactions.transaction_date', 'desc');

        return $transactions;
    }

    public function check_deduction_allowance($input)
    {
        $allowances=$input['allowances'];
        $allowances_check=false;
        $deductions=$input['deductions'];
        $deductions_check=false;
        foreach ($allowances as $key => $value) {
            if (!empty($value['is_enabled'])) {
                $allowances_check =true;
            }
        }
        foreach ($deductions as $key => $value) {
            if (!empty($value['is_enabled'])) {
                $deductions_check =true;
            }
        }

        if ($allowances_check == false && $deductions_check == false) {
            return false;
        }
        return true;
    }
    public function sum_deduction_allowance($input)
    {
        $total=0;

        foreach ($input as $key => $value) {
            if (!empty($value['is_enabled'])) {
                $amount=$this->employeeUtil->num_uf($value['amount']);
                $total +=$amount;
            }
        }
        return $total;

    }
}
