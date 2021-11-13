<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSection;
use App\Models\Classes;
use App\Models\Campus;
use App\Models\Session;
use App\Models\Category;
use App\Models\District;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\StudentGuardian;
use App\Models\FeeTransaction;
use App\Models\Discount;
use App\Models\FeeHead;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\StudentUtil;
use App\Utils\FeeTransactionUtil;
use Carbon;
use DB;
use PDFS;
use File;

class StudentController extends Controller
{
    protected $studentUtil;
    protected $feeTransactionUtil;

    /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
     * @return void
     */
    public function __construct(StudentUtil $studentUtil  , FeeTransactionUtil $feeTransactionUtil)
    {
        $this->studentUtil = $studentUtil;
        $this->feeTransactionUtil = $feeTransactionUtil;
            $this->student_status_colors = [
            'active' => 'bg-success',
            'packed' => 'bg-info',
            'shipped' => 'bg-navy',
            'delivered' => 'bg-green',
            'cancelled' => 'bg-red',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $system_settings_id = session()->get('user.system_settings_id');

            $student_list=Student::leftJoin('campuses', 'students.campus_id', '=', 'campuses.id')
            ->leftjoin('fee_transactions AS t', 'students.id', '=', 't.student_id')
           ->leftJoin('classes as c-class', 'students.current_class_id', '=', 'c-class.id')
           ->leftJoin('classes as adm-class', 'students.adm_class_id', '=', 'adm-class.id')
            ->where('students.system_settings_id', $system_settings_id)
            ->select(
                'campuses.campus_name',
                'adm-class.title as adm_class',
                'c-class.title as current_class',
                'students.father_name',
                'students.roll_no',
                'students.admission_no',
                'students.status',
                'students.id as id',
                'students.student_image',
                'students.admission_date',
                DB::raw("CONCAT(COALESCE(students.first_name, ''),' ',COALESCE(students.last_name,'')) as student_name")
            );
            $student_list->addSelect([
                DB::raw("COALESCE(SUM(IF(t.type = 'fee' AND t.status = 'final', final_total, 0)),0)-COALESCE(SUM(IF(t.type = 'fee' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'opening_balance', final_total, 0)),0) -COALESCE(SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)),0)
                +COALESCE(SUM(IF(t.type = 'admission_fee', final_total, 0)),0) -COALESCE(SUM(IF(t.type = 'admission_fee', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM fee_transaction_payments WHERE fee_transaction_payments.fee_transaction_id=t.id), 0)),0) as total_due")
            ]);
            // $permitted_locations = auth()->user()->permitted_locations();
            // if ($permitted_locations != 'all') {
            //     $student_list>whereIn('transactions.location_id', $permitted_locations);
            // }
            if (request()->has('campus_id')) {
                $campus_id = request()->get('campus_id');
                if (!empty($campus_id)) {
                    $student_list->where('students.campus_id', $campus_id);
                }
            }
            if (request()->has('class_id')) {
                $class_id = request()->get('class_id');
                if (!empty($class_id)) {
                    $student_list->where('students.current_class_id', $class_id);
                }
            }
            if (request()->has('class_section_id')) {
                $class_section_id = request()->get('class_section_id');
                if (!empty($class_section_id)) {
                    $student_list->where('students.current_class_section_id', $class_section_id);
                }
            }
            if (request()->has('admission_no')) {
                $admission_no = request()->get('admission_no');
                if (!empty($admission_no)) {
                    $student_list->where('students.admission_no', 'like', "%{$admission_no}%");
                }
            }
            if (request()->has('roll_no')) {
                $roll_no = request()->get('roll_no');
                if (!empty($roll_no)) {
                    $student_list->where('students.roll_no', 'like', "%{$roll_no}%");
                }
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $student_list->whereDate('students.admission_date', '>=', $start)
                            ->whereDate('students.admission_date', '<=', $end);
            }
            
            $student_list->groupBy('students.id');

            $datatable = Datatables::of($student_list)
            ->addColumn(
                'action',
                function ($row) {
                    $html= '<div class="dropdown">
                         <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                         <ul class="dropdown-menu" style="">';
                    $html.='<li><a class="dropdown-item "href="' . action('StudentController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';
                    $check=FeeTransaction::where('type','admission_fee')->where('student_id',$row->id)->first();
                   if (empty($check)) {
                       $html.='<li><a class="dropdown-item admission_add_button" data-href="'.action('StudentController@addAdmissionFee', [$row->id]).'" data-container=".admission_fee_modal"><i class="bx bxs-plus-square  "></i>'. __("lang.create_admission_voucher").'</a></li>';
                   }
                //    $html .= '<li><a href="' . action('FeeTransactionPaymentController@getPayStudentDue', [$row->id]) . '" class="pay_fee_due"><i class="fas fa-money-bill-alt" aria-hidden="true"></i>' . __("lang.pay_due_amount") . '</a></li>';
                   if ($row->total_due!=0) {
                       $html.='<li><a class="dropdown-item pay_fee_due "href="' . action('FeeTransactionPaymentController@getPayStudentDue', [$row->id]) . '"><i class="fas fa-money-bill-alt "></i> ' . __("lang.pay_due_amount") . '</a></li>';
                   }
                   $html .= '</ul></div>';

                    return $html;
                }
            )
               ->editColumn('student_name', function ($row)  {
                $image = !empty($row->student_image) ? $row->student_image: 'default.png';
                $status='<div><a  href="https://demo.mozzine.work/csms/manager/student/profile/14">
                <img src="'.url('uploads/student_image/' . $image).'" class="rounded-circle " width="50" height="50" alt="" >
                '.ucwords($row->student_name).'
                </a></div>';
                return $status;
            })
               ->editColumn('status', function ($row)  {
                $status_color = !empty($this->student_status_colors[$row->status]) ? $this->student_status_colors[$row->status] : 'bg-gray';
                // $status = lass="label ' . $status_color .'">' . $shipping_statuses[$row->shipping_status] . '</span></a>' : '';
                $status='<span class="badge badge-mark ' . $status_color .'">' .ucwords($row->status).   '</span>';
                return $status;
            })
            ->editColumn('admission_date', '{{@format_date($admission_date)}}')

            ->removeColumn('id','student_image','total_due');
         
          

            $rawColumns = ['action','campus_name','adm_class','current_class','father_name','status','student_name'];
            
            return $datatable->rawColumns($rawColumns)
                  ->make(true);
        }
       // dd($query);
       

        $campuses=Campus::forDropdown();
        

        return view('students.index')->with(compact('campuses'));
        
    }
    // public function index()
    // {
    
    //         // echo $now->weekOfYear;
    //     // $results=Student::with(['guardian','guardian.student_guardian'])->select('id', DB::raw("concat(first_name,' ',last_name ,'  ', '(',roll_no,')') as info"))->find(1);
    //     // dd(json_encode($results));
    //     $logo = 'Pk';
    //     // dd($system_settings->pdf);
    //     // dd(public_path());
    //     if (File::exists(public_path('uploads/pdf/admission-form.pdf'))) {
    //         File::delete(public_path('uploads/pdf/admission-form.pdf'));
    //     }
    //     $pdf_name='admission-form'.'.pdf';
    //     $snappy = \WPDF::loadView('pdf.invoice-bill');
    //     $headerHtml = view()->make('pdf.wkpdf-header', compact('logo'))->render();
    //     $footerHtml = view()->make('pdf.wkpdf-footer')->render();
    //     $snappy->setOption('header-html', $headerHtml);
    //     $snappy->setOption('footer-html', $footerHtml);
    //     $snappy->setPaper('a4')->setOption('margin-top', 35)->setOption('margin-left', 0)->setOption('margin-right', 0);
    //     $snappy->save('uploads/pdf/'.$pdf_name);//save pdf file
    //     return view('students.index')->with(compact('pdf_name'));
    //     ;
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $system_settings_id = session()->get('user.system_settings_id');
        $countries = $this->studentUtil->allCountries();

        $campuses=Campus::forDropdown();
        $discounts=Discount::forDropdown();
        $categories=Category::forDropdown();
        $sessions=Session::forDropdown(false, true);
        $ref_admission_no=$this->studentUtil->setAndGetReferenceCount('admission_no', true, false);
        $admission_no=$this->studentUtil->generateReferenceNumber('admission', $ref_admission_no);
        //dd($ref_admission_no);
        // dd($session);
        
        $districts = District::forDropdown($system_settings_id, false);

        return view('students.create')->with(compact('campuses', 'countries', 'sessions', 'admission_no', 'categories', 'districts', 'discounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
        
            $input = $request->except('_token');
    
            if (!empty($input['guardian_link_id']) && !empty($input['sibling_id'])) {
                $this->studentUtil->studentCreate($request, $input['guardian_link_id']);
            } else {
                $this->studentUtil->studentCreate($request);
            }

            $this->studentUtil->setAndGetReferenceCount('admission_no', false, true);

            $this->studentUtil->setAndGetRollNoCount('roll_no', false, true, $input['adm_session_id']);

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
        return redirect('students')->with('status', $output);
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
        $countries = $this->studentUtil->allCountries();

        $campuses=Campus::forDropdown();
        $discounts=Discount::forDropdown();
        $categories=Category::forDropdown();
        $sessions=Session::forDropdown(false, true);
        $domicile = District::forDropdown($system_settings_id, false);
        $student=Student::with(['guardian','guardian.student_guardian'])->find($id);
        //dd($student->guardian->student_guardian->id);
        $siblings=StudentGuardian::with(['student_guardian','students'])->where('student_id','!=',$student->id)->where('guardian_id',$student->guardian->student_guardian->id)->get();
        // dd($siblings->students->first_name);
        
        // dd($student->guardian->student_guardian->guardian_name);
        $classes=Classes::forDropdown($system_settings_id);
        $sections=ClassSection::forDropdown($system_settings_id, false, $student->class_id);
        $provinces = Province::forDropdown($system_settings_id, false, $student->country_id);
        $districts = District::forDropdown($system_settings_id, false, $student->province_id);
        $cities = City::forDropdown($system_settings_id, false, $student->district_id);
        $regions = Region::forDropdown($system_settings_id, false, $student->city_id);
        $ob_transaction =  FeeTransaction::where('student_id', $id)
        ->where('type', 'opening_balance')
        ->first();
        $opening_balance = !empty($ob_transaction->final_total) ? $ob_transaction->final_total : 0;
        //Deduct paid amount from opening balance.
        if (!empty($opening_balance)) {
            // $opening_balance_paid = $this->transactionUtil->getTotalAmountPaid($ob_transaction->id);
            // if (!empty($opening_balance_paid)) {
            //     $opening_balance = $opening_balance - $opening_balance_paid;
            // }

            $opening_balance = $this->studentUtil->num_f($opening_balance);
        }
        return view('students.edit')->with(compact(
            'student',
            'campuses',
            'countries',
            'sessions',
            'categories',
            'districts',
            'discounts',
            'classes',
            'sections',
            'provinces',
            'domicile',
            'cities',
            'regions', 
            'opening_balance','siblings'
        ));
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
            DB::beginTransaction();
        
            $input = $request->except('_token');
            
            if(!empty($input['remove-sibling'])){
                $this->studentUtil->removeSibling($input['guardian'],$id);
            }
            if (!empty($input['guardian_link_id']) && !empty($input['sibling_id'])) {
                $this->studentUtil->updateStudent($request, $id, $input['guardian_link_id']);
            } else {
                $this->studentUtil->updateStudent($request,$id);
            }
            // $this->studentUtil->setAndGetReferenceCount('admission_no', false, true);
            // $this->studentUtil->setAndGetRollNoCount('roll_no', false, true, $input['adm_session_id']);
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
        return redirect('students')->with('status', $output);
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



    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function addSibling()
    {
        $system_settings_id = session()->get('user.system_settings_id');
        
        $campuses=Campus::forDropdown();
        $classes=Classes::forDropdown($system_settings_id);
        return view('students.sibling')->with(compact('campuses', 'classes'));
    }
    public function getByClassAndSection(Request $request)
    {
        if (!empty($request->input('class_id'))) {
            $class_id = $request->input('class_id');
            $section_id = $request->input('section_id');
            $system_settings_id = session()->get('user.system_settings_id');
            $students = Student::forDropdown($system_settings_id, false, $class_id, $section_id);
            $html = '<option value="">' . __('lang.please_select') . '</option>';
            //$html = '';
            if (!empty($students)) {
                foreach ($students as $id => $name) {
                    $html .= '<option value="' . $id .'">' . $name. '</option>';
                }
            }

            return $html;
        }
    }
    public function getStudentRecordByID(Request $request)
    {
        if (!empty($request->input('student_id'))) {
            $student_id = $request->input('student_id');
            $system_settings_id = session()->get('user.system_settings_id');
            $results=Student::with(['guardian','guardian.student_guardian'])->select('id', DB::raw("concat(first_name,' ',last_name ,'  ', '(',roll_no,')') as full_name"))->find($student_id);
           
            return  json_encode($results);
        }
    }



        /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function addAdmissionFee($id)
    {
        $system_settings_id = session()->get('user.system_settings_id');
        $student=Student::with(['guardian','guardian.student_guardian'])->find($id);
        $fee_heads=$this->studentUtil->getAdmissionFeeHeads($student->campus_id,$student->current_class_id);
        return view('students/partials.admission_fee')->with(compact('student','fee_heads'));
    }
    public function postAdmissionFee(Request $request)
    {
       
        try {
            DB::beginTransaction();
            $transaction=$this->feeTransactionUtil->createFeeTransaction($request,'admission_fee');
            $this->feeTransactionUtil->createFeeTransactionLines($request->fee_heads,$transaction);   
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
