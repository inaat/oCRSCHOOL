<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSection;
use App\Models\Classes;
use App\Models\Campus;
use App\Models\Session;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Util;
use DB;
use PDFS;
use File;


class StudentController extends Controller
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
    public function index()
    {
        $logo = 'Pk';
        // dd($system_settings->pdf);

        if (File::exists(public_path('uploads/pdf/admission-form.pdf'))) {
            File::delete(public_path('uploads/pdf/admission-form.pdf'));
        }
        $pdf_name='admission-form'.'.pdf';
        $snappy = \WPDF::loadView('pdf.invoice-bill');
        $headerHtml = view()->make('pdf.wkpdf-header',compact('logo'))->render();
        $footerHtml = view()->make('pdf.wkpdf-footer')->render();
        $snappy->setOption('header-html', $headerHtml);
        $snappy->setOption('footer-html', $footerHtml);
        $snappy->setPaper('a4')->setOption('margin-top', 35)->setOption('margin-left', 0)->setOption('margin-right', 0);
        return $snappy->inline(date('Y-m-d-h:i:-a').'-invoice-bill.pdf');
        // $group=4444;

        // // $pdf = PDFS::loadView('pdf.receipt',['logo'=> $system_settings]);
        // // $pdf->setOption('header-html', View::make('pdf.report')->render());
        // $headerHtml = view()->make('pdf.report')->render();
        // // dd($headerHtml);

        // $pdf = PDFS::loadView('pdf.receipt',['logo'=> $system_settings])
        // ->setPaper('a5');
        // $pdf->setOption('header-html','www.google.com');

        
        return $pdf->stream('invoice.pdf');

        //return $pdf->download('onlinewebtutorblog.pdf');
    //    $logo = session()->get('system_details.pdf');

    //     $data = [
	// 		'foo' => 'bar'
	// 	];        $pdf_name='admission-form'.'.pdf';

        
	// 	$pdf = PDF::loadView('pdf.receipt')->w;
        // $pdf->save('uploads/pdf/'.$pdf_name);//save pdf file

     // return url('uploads/pdf/'.$pdf_name);//return pdf url
		//return view('students.index')->with(compact('file'));
       
        // return view('students.index')->with(compact('pdf_name'));;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->commonUtil->allCountries();
        //dd($countries);
        $campuses=Campus::forDropdown();
        $categories=Category::forDropdown();
        $sessions=Session::forDropdown(false,true);
        $ref_admission_no=$this->commonUtil->setAndGetReferenceCount('admission_no',true,false);
        $admission_no=$this->commonUtil->generateReferenceNumber('addmission', $ref_admission_no);
        //dd($ref_admission_no);
       // dd($session);
       return view('students.create')->with(compact('campuses','countries','sessions','admission_no','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
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
}
