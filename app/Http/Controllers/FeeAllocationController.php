<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSection;
use App\Models\Classes;
use App\Models\Campus;
use App\Models\Session;
use App\Models\Student;
use App\Models\FeeTransaction;
use App\Models\Discount;
use App\Models\FeeHead;
use App\Models\FeeTransactionPayment;
use App\Models\FeeTransactionLine;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\StudentUtil;
use App\Utils\FeeTransactionUtil;

use Illuminate\Support\Facades\Validator;
use DB;
use File;

class FeeAllocationController extends Controller
{
    protected $studentUtil;
    protected $feeTransactionUtil;

    /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
     * @return void
     */
    public function __construct(StudentUtil $studentUtil, FeeTransactionUtil $feeTransactionUtil)
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
    {    //dd($this->feeTransactionUtil->getListSells(1)->get());
        if (request()->ajax()) {
            $fee_transactions=$this->feeTransactionUtil->getListSells(1);
            $datatable = Datatables::of($fee_transactions)
        ->addColumn(
            'action',
            function ($row) {
                $html= '<div class="dropdown">
                     <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">'. __("lang.actions").'</button>
                     <ul class="dropdown-menu" style="">';
                $html.='<li><a class="dropdown-item "href="' . action('StudentController@edit', [$row->id]) . '"><i class="bx bxs-edit "></i> ' . __("lang.edit") . '</a></li>';
              
                if ($row->payment_status != "paid" && (auth()->user()->can("sell.create") || auth()->user()->can("direct_sell.access")) && auth()->user()->can("sell.payments")) {
                    $html .= '<li><a href="' . action('FeeTransactionPaymentController@addPayment', [$row->id]) . '" class="dropdown-item add_payment_modal"><i class="fas fa-money-bill-alt"></i> ' . __("lang.add_payment") . '</a></li>';
                }
                $html .= '<li><a href="' . action('FeeTransactionPaymentController@show', [$row->id]) . '" class="dropdown-item view_payment_modal"><i class="fas fa-money-bill-alt"></i> ' . __("lang.view_payments") . '</a></li>';

                $html .= '</ul></div>';

                return $html;
            }
        )
        ->editColumn(
            'payment_status',
            function ($row) {
                $payment_status = FeeTransaction::getPaymentStatus($row);
                return (string) view('fee_allocation.partials.payment_status', ['payment_status' => $payment_status, 'id' => $row->id]);
            }
        )
        ->editColumn('student_name', function ($row) {
            return ucwords($row->student_name);
        })
        ->editColumn('father_name', function ($row) {
            return ucwords($row->father_name);
        })
        ->editColumn('roll_no', function ($row) {
            return ucwords($row->roll_no);
        })
        ->editColumn('current_class', function ($row) {
            return ucwords($row->current_class);
        })
           ->editColumn('status', function ($row) {
               $status_color = !empty($this->student_status_colors[$row->status]) ? $this->student_status_colors[$row->status] : 'bg-gray';
               $status='<span class="badge badge-mark ' . $status_color .'">' .ucwords($row->status).   '</span>';
               return $status;
           })
        ->addColumn('total_remaining', function ($row) {
            $total_remaining =  $row->final_total - $row->total_paid;
            $total_remaining_html = '<span class="payment_due" data-orig-value="' . $total_remaining . '">' . $this->feeTransactionUtil->num_f($total_remaining, true) . '</span>';

            
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
        ->editColumn('fee_transaction_date', '{{@format_date($fee_transaction_date)}}')

        ->removeColumn('id');
     
      

            $rawColumns = ['action','status','campus_name','fee_transaction_date','voucher_no','payment_status','final_total','total_remaining','total_paid' ];
        
            return $datatable->rawColumns($rawColumns)
              ->make(true);
        }
        $campuses=Campus::forDropdown();
        

        return view('fee_allocation.index')->with(compact('campuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $system_settings_id = session()->get('user.system_settings_id');
       

        $campuses=Campus::forDropdown();
        $now_month = \Carbon::now()->month;
        
        return view('fee_allocation.create')->with(compact('campuses', 'now_month'));
    }
    public function feesAssignSearch(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class_id' => "required",
            'month_id' => "required"
        ]);
        $month_id=$input['month_id'];
        $campus_id=$input['campus_id'];
        $class_id=$input['class_id'];
        $class_section_id=$input['class_section_id'];
        $system_settings_id = session()->get('user.system_settings_id');
        $classes=Classes::forDropdown($system_settings_id, false, $input['campus_id']);
        $sections=ClassSection::forDropdown($system_settings_id, false, $input['class_id']);
        $fee_heads=$this->studentUtil->getFeeHeads($campus_id, $class_id);

        $campuses=Campus::forDropdown();
     
        $query=Student::leftJoin('campuses', 'students.campus_id', '=', 'campuses.id')
        ->leftJoin('classes as c-class', 'students.current_class_id', '=', 'c-class.id')
         ->where('students.system_settings_id', $system_settings_id)
         ->where('students.current_class_id', $class_id)
         ->select(
             'campuses.campus_name',
             'c-class.title as current_class',
             'students.father_name',
             'students.roll_no',
             'students.admission_no',
             'students.gender',
             'students.id as id',
             'students.student_image',
             'students.admission_date',
             DB::raw("CONCAT(COALESCE(students.first_name, ''),' ',COALESCE(students.last_name,'')) as student_name")
         );
         
        if (!empty($class_section_id)) {
            $query->where('students.current_class_section_id', $class_section_id);
        }
        
        $students=$query->get();
        return view('fee_allocation.fees_assign')->with(compact('students', 'fee_heads', 'campuses', 'classes', 'sections', 'campus_id', 'class_id', 'class_section_id', 'month_id'));
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
            $input=$request->input();
            $fee_heads=$input['fee_heads'];
            $month=$input['month_id'];
            $user_id = $request->session()->get('user.id');
            $system_settings_id = $request->session()->get('user.system_settings_id');
            foreach ($input['student_checked'] as $student_id) {
                $student=Student::find($student_id);
                $discount=Discount::find($student->discount_id);
                $lines_formatted = [];
                foreach ($fee_heads as $key => $value) {
                    if (!empty($value['is_enabled'])) {
                        $line=[
                    'fee_head_id'=>$value['fee_head_id'],
                    'amount'=>$this->studentUtil->num_uf($value['amount'])
                ];
                        $lines_formatted[] = new FeeTransactionLine($line);
                    }
                }
                $fee_transaction=FeeTransaction::where('type', '=', 'fee')->where('session_id', $this->feeTransactionUtil->getActiveSession())->where('student_id', $student_id)->where('month', $month)->first();
                if (empty($fee_transaction)) {
                    $tuition_fee=[
                'fee_head_id'=>2,
                'amount'=>$this->studentUtil->num_uf($student->student_tuition_fee)
            ];
                    $lines_formatted[]=new FeeTransactionLine($tuition_fee);
                    if ($student->is_transport) {
                        $transport_fee=[
                    'fee_head_id'=>3,
                    'amount'=>$this->studentUtil->num_uf($student->student_transport_fee)
                ];
                        $lines_formatted[]=new FeeTransactionLine($transport_fee);
                    }
                }

                $final_total=$this->feeTransactionUtil->getFinalWithoutDiscount($lines_formatted, $discount);
                if ($final_total !=0) {
                    $transaction=$this->feeTransactionUtil->multiFeeTransaction($student, 'fee', $system_settings_id, $user_id, $lines_formatted, $final_total, $discount, $month);
                } else {
                    $output = ['success' => false,
                   'msg' => __("lang.something_went_wrong")];
            
        
                    return redirect('students')->with('status', $output);
                }
            }
            DB::commit();

            $output = ['success' => true,
                'msg' => __("lang.updated_success")
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
        $current_transaction=FeeTransaction::with(['session','campus','student','fee_lines.feeHead','student_class','student_class_section'])->find($id);
       // dd($current_transaction);
        $query = FeeTransaction::where('fee_transactions.student_id', $current_transaction->student_id)
        ->where('session_id', $current_transaction->session_id)
        ->whereIn('type', ['fee','admission_fee','opening_balance'])
        ->select(['month', DB::raw("SUM(IF(status = 'final', final_total, 0)) as total_invoice"),
        ])->groupBy('month')->orderBy('month', 'asc')->get();
        $old_due = $this->feeTransactionUtil->getStudentDue(1,9);
       // dd($per_transaction);
        $fee_transaction_payment=$this->__paymentQuery($current_transaction->student_id,$current_transaction->session_id);
        $transaction_formatted=$this->__transaction_format($query);
        $payment_formatted=[];
        foreach ($fee_transaction_payment as $p) {
            foreach (__('lang.index_months') as $key=>$month) {
                if ($p->month == $key) {
                    $payment_formatted[$month]=$p->total_paid;
                } else {
                    if (empty($payment_formatted[$month])) {
                        $payment_formatted[$month]=0;
                    }
                }
            }
        }
        $balance=$this->__transaction_paid_total_final_format($transaction_formatted,$payment_formatted,$old_due);

      
        $logo = 'Pk';
        if (File::exists(public_path('uploads/pdf/feecard.pdf'))) {
            File::delete(public_path('uploads/pdf/feecard.pdf'));
        }

        $pdf_name='feecard'.'.pdf';
        $snappy  = \WPDF::loadView('feecard.feecard',compact('current_transaction','transaction_formatted','payment_formatted','balance'));
        $headerHtml = view()->make('feecard._header', compact('logo'))->render();
        $footerHtml = view()->make('feecard._footer')->render();
        $snappy->setOption('header-html', $headerHtml);
        $snappy->setOption('footer-html', $footerHtml);
        $snappy->setPaper('a5')->setOption('orientation','landscape')->setOption('margin-top', 25)->setOption('margin-left', 0)->setOption('margin-right', 0)->setOption('margin-bottom', 5);
       $snappy->save('uploads/pdf/'.$pdf_name);//save pdf file
      // return $snappy->stream();
        return view('students.pdfindex')->with(compact('pdf_name'));
    }
    /**
     * Query to get payment details for a customer
     *
     */
    private function __transaction_paid_total_final_format($fee_transaction,$payment_formatted,$old_due)
    {   
        $old_due=$old_due; 
       // dd($payment_formatted);
       if(empty($payment_formatted)){
        $payment_formatted=[1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
       }
        $total=[1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        $bF=[1=>$old_due,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        $balance=[1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        foreach($fee_transaction as $key => $t){
            if($key==1){
                $total[$key]=$bF[$key]+$t;
            }   
        }
        foreach ($payment_formatted as $key => $p) {
            if ($key==1) {
                $balance[$key]=$total[$key]-$p;

            }else{
                $bF[$key]=$balance[$key-1];
                $total[$key]=$fee_transaction[$key]+$bF[$key];
                $balance[$key]=$total[$key]-$p;
            }    
        }
    
     $details=['bf'=>$bF,'total'=>$total,'balance'=>$balance];
     return $details;

    }
    private function __transaction_format($query){

        $transaction_formatted=[];
        foreach ($query as $q) {
            foreach (__('lang.index_months') as $key=>$month) {
                if ($q->month == $key) {
                    $transaction_formatted[$month]=$q->total_invoice;
                } else {
                    if (empty($transaction_formatted[$month])) {
                        $transaction_formatted[$month]=0;
                    }
                }
            }
        }
       return $transaction_formatted;
    }
    private function __paymentQuery($student_id, $session_id)
    {

        $query = FeeTransactionPayment::where('fee_transaction_payments.payment_for', $student_id)
        //->whereNotNull('transaction_payments.transaction_id');
        ->whereNull('fee_transaction_payments.parent_id')
        ->where('session_id','=',$session_id);
        $query->select([DB::raw("SUM(amount) as total_paid"),
                      DB::raw('MONTH(paid_on) month')
                      ])->groupBy('month');

        return $query->get();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function allFeeTransaction()
    {
    }
}
