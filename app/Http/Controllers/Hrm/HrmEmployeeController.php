<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HumanRM\HrmEmployee;
use App\Models\HumanRM\HrmEmployeeDocument;
use App\Models\Campus;
use App\Models\HumanRM\HrmDepartment;
use App\Models\HumanRM\HrmDesignation;
use App\Models\HumanRM\HrmEducation;
use App\Models\District;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\EmployeeUtil;

use DB;
class HrmEmployeeController extends Controller
{  
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('HrmEmployee.view') && !auth()->user()->can('HrmEmployee.create')) {
            abort(403, 'Unauthorized action.');
        }
        
        //dd($HrmEmployees->get());
        if (request()->ajax()) {
            $HrmEmployees = HrmEmployee::leftJoin('campuses', 'hrm_employees.campus_id', '=', 'campuses.id')
            ->leftjoin('hrm_transactions AS t', 'hrm_employees.id', '=', 't.employee_id')

            ->select(
                'campuses.campus_name',
                'hrm_employees.father_name',
                'hrm_employees.employeeID',
                'hrm_employees.status',
                'hrm_employees.id as id',
                'hrm_employees.employee_image',
                'hrm_employees.joining_date',
                DB::raw("CONCAT(COALESCE(hrm_employees.first_name, ''),' ',COALESCE(hrm_employees.last_name,'')) as employee_name")
            );
            if (request()->has('campus_id')) {
                $campus_id = request()->get('campus_id');
                if (!empty($campus_id)) {
                    $HrmEmployees->where('hrm_employees.campus_id', $campus_id);
                }
            }
            if (request()->has('status')) {
                $status = request()->get('status');
                if (!empty($status)) {
                    $HrmEmployees->where('hrm_employees.status', $status);
                }
            }
            if (request()->has('employeeID')) {
                $employeeID = request()->get('employeeID');
                if (!empty($employeeID)) {
                    $HrmEmployees->where('hrm_employees.employeeID', 'like', "%{$employeeID}%");
                }
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $HrmEmployees->whereDate('hrm_employees.joining_date', '>=', $start)
                            ->whereDate('hrm_employees.joining_date', '<=', $end);
            }
            $HrmEmployees->addSelect([
                DB::raw("COALESCE(SUM(IF(t.type = 'pay_roll' AND t.status = 'final', final_total, 0)),0)-COALESCE(SUM(IF(t.type = 'pay_roll' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'opening_balance', final_total, 0)),0) -COALESCE(SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM hrm_transaction_payments WHERE hrm_transaction_payments.hrm_transaction_id=t.id), 0)),0)
               as total_due")
            ]);
            $HrmEmployees->groupBy('hrm_employees.id');
            $datatable = Datatables::of($HrmEmployees)
            ->addColumn(
                'action',
                function ($row) {
                    $html= '<div class="dropdown">
                         <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                         <ul class="dropdown-menu" style="">';
                    $html.='<li><a class="dropdown-item "href="' . action('HRM\HrmEmployeeController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';               
                    if ($row->total_due!=0) {
                        $html.='<li><a class="dropdown-item pay_payroll_due "href="' . action('HRM\HrmTransactionPaymentController@getPayEmployeeDue', [$row->id]) . '"><i class="fas fa-money-bill-alt "></i> ' . __("lang.pay_due_amount") . '</a></li>';
                    }
                    $html .= '<li><a href="#" data-employee_id="' . $row->id .
                   '" data-status="' . $row->status . '" class="update_status dropdown-item"><i class="fas fa-edit" aria-hidden="true" ></i>' . __("lang_v1.update_status") . '</a></li>';
                   
                   if ($row->status != 'resign') {
                       $html .= '<li><a  href="#" data-employee_id="' . $row->id .
                   '" data-employee-name="' . $row->employee_name . '" class="employee_resign dropdown-item"><i class="fas fa-edit" aria-hidden="true" ></i>' . __('hrm.resign') . '</a></li>';
                   }
                   $html .= '</ul></div>';

                    return $html;
                }
            )
               ->editColumn('employee_name', function ($row)  {
                $image = !empty($row->employee_image) ? $row->employee_image: 'default.png';
                $status='<div><a  href="https://demo.mozzine.work/csms/manager/student/profile/14">
                <img src="'.url('uploads/employee_image/' . $image).'" class="rounded-circle " width="50" height="50" alt="" >
                '.ucwords($row->employee_name).'
                </a></div>';
                return $status;
            })
               ->editColumn('status', function ($row)  {
                $status_color = !empty($this->employee_status_colors[$row->status]) ? $this->employee_status_colors[$row->status] : 'bg-gray';
                $status ='<a href="#"'.'data-employee_id="' . $row->id .
                '" data-status="' . $row->status . '" class="update_status">';
                $status .='<span class="badge badge-mark ' . $status_color .'">' .__('hrm.'.$row->status).   '</span></a>';
                return $status;
            })
            ->filterColumn('employeeID', function ($query, $keyword) {
                $query->where( function($q) use($keyword) {
                    $q->where('students.employeeID', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->where( function($q) use($keyword) {
                    $q->where('employees.first_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('father_name', function ($query, $keyword) {
                $query->where( function($q) use($keyword) {
                    $q->where('employees.father_name', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('joining_date', '{{@format_date($joining_date)}}');

         
          

            $rawColumns = ['action','campus_name','father_name','status','employee_name'];
            
            return $datatable->rawColumns($rawColumns)
                  ->make(true);
        }
        $campuses=Campus::forDropdown();

        return view('Hrm\employee.index')->with(compact('campuses'));
    }

    /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function create()
    {
    
        $system_settings_id = session()->get('user.system_settings_id');
        $countries = $this->employeeUtil->allCountries();

        $campuses=Campus::forDropdown();
        $ref_admission_no=$this->employeeUtil->setAndGetReferenceCount('employee_no', true, false);
        $admission_no=$this->employeeUtil->generateReferenceNumber('employee', $ref_admission_no);
        
        $departments = HrmDepartment::forDropdown();
        $designations = HrmDesignation::forDropdown();
        $educations = HrmEducation::forDropdown();


        return view('Hrm\employee.create')->with(compact('campuses', 'countries', 'admission_no','departments','designations','educations'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('HrmEducation.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
           

     
                DB::beginTransaction();
            
                $input = $request->except('_token');
        
                $this->employeeUtil->employeeCreate($request);

                $this->employeeUtil->setAndGetReferenceCount('employee_no', false, true);
    
                $this->employeeUtil->generateReferenceNumber('employee', false, true);       
                $output = ['success' => true,
                            'msg' => __("hrm.added_success")
                        ];
              
                
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
    
                $output = ['success' => false,
                        'msg' => __("lang.something_went_wrong")
                    ];
            }
            return redirect('hrm-employee')->with('status', $output);
    }
        /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
           /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
      public function edit($id)
      {
      
          $system_settings_id = session()->get('user.system_settings_id');
          $countries = $this->employeeUtil->allCountries();
          $employee=HrmEmployee::find($id);
          $provinces = Province::forDropdown($system_settings_id, false, $employee->country_id);
          $districts = District::forDropdown($system_settings_id, false, $employee->province_id);
          $cities = City::forDropdown($system_settings_id, false, $employee->district_id);
          $regions = Region::forDropdown($system_settings_id, false, $employee->city_id);
          $campuses=Campus::forDropdown();
          $departments = HrmDepartment::forDropdown();
          $designations = HrmDesignation::forDropdown();
          $educations = HrmEducation::forDropdown();
          $bank_details=json_decode($employee->bank_details);
          return view('Hrm\employee.edit')->with(compact('campuses','employee', 'bank_details','countries','departments','designations','educations', 'districts','provinces', 'cities', 'regions'));
        
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
        // if (!auth()->user()->can('HrmEducation.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
           

     
            DB::beginTransaction();
        
            $input = $request->except('_token');
    
            $this->employeeUtil->employeeUpdate($request,$id);    
           
            $output = ['success' => true,
                        'msg' => __("hrm.updated_success")
                    ];
          
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                    'msg' => __("lang.something_went_wrong")
                ];
        }
        return redirect('hrm-employee')->with('status', $output);
    }
     /**
     * Handles the validation email
     *
     * @return \Illuminate\Http\Response
     */
    public function postCheckEmail(Request $request)
    {
        $email = $request->input('email');
        $query = HrmEmployee::where('email', $email);
        $exists = $query->exists();
        if (!$exists) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }
    public function updateStatus(Request $request)
  

    {
        if (!auth()->user()->can('session.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                DB::beginTransaction();

                $student = HrmEmployee::find($request->employee_id);
                $student->status = $request->status;
                $student->save();
                
                DB::commit();

                $output = ['success' => true,
                            'msg' => __("hrm.updated_success")
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

    public function employeeResign(Request $request)
  {
    if (!auth()->user()->can('session.update')) {
        abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
        try {
            DB::beginTransaction();

            $employee = HrmEmployee::find($request->employee_id);
            $employee->status = 'resign';
            $employee->resign_remark = $request->resign_remark;
            $employee->save();
            if ($request->hasFile('resign')) {
                $filename=$this->employeeUtil->uploadFile($request, 'resign', 'document');
                HrmEmployeeDocument::create([
                    'employee_id' => $employee->id,
                    'filename' => $filename,
                    'type' => 'resign'
                ]);
            }
            DB::commit();

            $output = ['success' => true,
                        'msg' => __("hrm.updated_success")
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

    
}