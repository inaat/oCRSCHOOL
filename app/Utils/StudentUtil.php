<?php

namespace App\Utils;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\StudentGuardian;
use App\Models\FeeTransaction;
use DB;

class StudentUtil extends Util
{
    public function StudentCreate($request, $guardian_link_id= null)
    {
        if ($guardian_link_id == null) {
            $student_input=$request->only(['campus_id','adm_session_id','admission_no','admission_date','roll_no','adm_class_id','adm_class_section_id',
                                    'first_name','last_name','gender','birth_date','category_id','domicile_id','religion','mobile_no','email','cnic_no',
                                    'blood_group','nationality','mother_tongue','medical_history','father_name','father_phone','father_occupation',
                                    'father_cnic_no','mother_name','mother_phone','mother_occupation','mother_cnic_no','country_id','province_id',
                                    'district_id','city_id','region_id','std_current_address','std_permanent_address','student_tuition_fee','discount_id',
                                    'remark','previous_school_name','last_grade','student_image','opening_balance']);
            if (!empty($student_input['student_image'])) {
                $student_image = $this->uploadFile($request, 'student_image', 'student_image', 'image', $student_input['roll_no']);
                $student_input['student_image'] = $student_image;
            }
            $user_id = $request->session()->get('user.id');
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $student_input['system_settings_id'] = $system_settings_id;
            $student_input['created_by'] = $user_id;
            $student_input['admission_date']=$this->uf_date($student_input['admission_date']);
            $student_input['birth_date']=$this->uf_date($student_input['birth_date']);
            $student_input['current_class_id']=$student_input['adm_class_id'];
            $student_input['current_class_section_id']=$student_input['adm_class_section_id'];
            $student_input['cur_session_id']=$student_input['adm_session_id'];

            $student_input['opening_balance'] = $this->num_uf($student_input['opening_balance']);

            $opening_balance = isset($student_input['opening_balance']) ? $student_input['opening_balance'] : 0;
            if (isset($student_input['opening_balance'])) {
                unset($student_input['opening_balance']);
            }
            $student=Student::create($student_input);
            //Add opening balance
            if (!empty($opening_balance)) {
                $this->createOpeningBalanceTransaction($student->system_settings_id,$student, $opening_balance, false);
            }
            $this->CreateLogin($student, 'student', $student->id);
      
            $guardian = Guardian::create($request['guardian']);
            $studentGuardian = StudentGuardian::create([
                'student_id' => $student->id,
                'guardian_id' => $guardian->id,
            ]);
        } else {
            $student_input=$request->only(['campus_id','adm_session_id','admission_no','admission_date','roll_no','adm_class_id','adm_class_section_id',
                                    'first_name','last_name','gender','birth_date','category_id','domicile_id','religion','mobile_no','email','cnic_no',
                                    'blood_group','nationality','mother_tongue','medical_history','student_tuition_fee','discount_id',
                                    'remark','previous_school_name','last_grade','student_image','opening_balance',]);
            if (!empty($student_input['student_image'])) {
                $student_image = $this->uploadFile($request, 'student_image', 'student_image', 'image', $student_input['roll_no']);
                $student_input['student_image'] = $student_image;
            }
            $user_id = $request->session()->get('user.id');
            $system_settings_id = $request->session()->get('user.system_settings_id');
            $student_input['system_settings_id'] = $system_settings_id;
            $student_input['created_by'] = $user_id;
            $student_input['admission_date']=$this->uf_date($student_input['admission_date']);
            $student_input['birth_date']=$this->uf_date($student_input['birth_date']);
            $student_input['current_class_id']=$student_input['adm_class_id'];
            $student_input['current_class_section_id']=$student_input['adm_class_section_id'];
            $student_input['cur_session_id']=$student_input['adm_session_id'];
            $sibling_details=Student::find($request['sibling_id']);
            $student_input['father_name']=$sibling_details->father_name;
            $student_input['father_phone']=$sibling_details->father_phone;
            $student_input['father_occupation']=$sibling_details->father_occupation;
            $student_input['father_cnic_no']=$sibling_details->father_cnic_no;
            $student_input['mother_name']=$sibling_details->mother_name;
            $student_input['mother_phone']=$sibling_details->mother_phone;
            $student_input['mother_occupation']=$sibling_details->mother_occupation;
            $student_input['mother_cnic_no']=$sibling_details->mother_cnic_no;
            $student_input['country_id']=$sibling_details->country_id;
            $student_input['province_id']=$sibling_details->province_id;
            $student_input['district_id']=$sibling_details->district_id;
            $student_input['city_id']=$sibling_details->city_id;
            $student_input['region_id']=$sibling_details->region_id;
            $student_input['std_current_address']=$sibling_details->std_current_address;
            $student_input['std_permanent_address']=$sibling_details->std_permanent_address;

            $student_input['opening_balance'] = $this->num_uf($student_input['opening_balance']);

            $opening_balance = isset($student_input['opening_balance']) ? $student_input['opening_balance'] : 0;
            if (isset($student_input['opening_balance'])) {
                unset($student_input['opening_balance']);
            }
            $student=Student::create($student_input);
            //Add opening balance
            if (!empty($opening_balance)) {
                $this->createOpeningBalanceTransaction($student->system_settings_id, $student, $opening_balance, false);
            }
            $this->CreateLogin($student, 'student', $student->id);
            $studentGuardian = StudentGuardian::create([
                'student_id' => $student->id,
                'guardian_id' => $guardian_link_id,
            ]);
        }

    }
    public function CreateLogin($data, $type, $hook_id)
    {
        if ($type=='student') {
            if (!empty($data['email'])) {
                $details=[
                'email'=>$data['email'],
                'user_type'=>$type,
                'hook_id'=>$hook_id,
                'password'=>Hash::make('111111111')
            ];
                $user=User::create($details);
                return $user;
            } else {
                $details=[
                'email'=>$data['roll_no'].'@edu.pk',
                'user_type'=>$type,
                'hook_id'=>$hook_id,
                'password'=>Hash::make('111111111')
            ];
                $user=User::create($details);
                return $user;
            }
        }
    }



    
    /**
     * Creates a new opening balance transaction for a contact
     *
     * @param  int $system_settings_id
     * @param  int $student_id
     * @param  int $amount
     *
     * @return void
     */
    public function createOpeningBalanceTransaction($system_settings_id, $student, $amount, $uf_data = true)
    {
        $final_amount = $uf_data ? $this->num_uf($amount) : $amount;
        $now = \Carbon::now();

        $ob_data = [
                    'system_settings_id' => $system_settings_id,
                    'campus_id' => $student->campus_id,
                    'type' => 'opening_balance',
                    'status' => 'final',
                    'payment_status' => 'due',
                    'session_id'=>$student->adm_session_id,
                    'class_id'=>$student->adm_class_id,
                    'class_section_id'=>$student->adm_class_section_id,
                    'month' => $now->month,
                    'student_id' => $student->id,
                    'transaction_date' =>$now,
                    'final_total' => $final_amount,
                    'created_by' => $student->created_by
                ];
        //Update reference count
        $ob_ref_count = $this->setAndGetReferenceCount('opening_balance', false, true);
        //Generate reference number
        $ob_data['ref_no'] = $this->generateReferenceNumber('opening_balance', $ob_ref_count, $system_settings_id);
        //Create opening balance transaction
        FeeTransaction::create($ob_data);
    }


    public function updateStudent($request, $student_id, $guardian_link_id= null)
    {
        
        $student_input=$request->only(['campus_id','adm_session_id','admission_no','admission_date','roll_no','adm_class_id','adm_class_section_id',
        'first_name','last_name','gender','birth_date','category_id','domicile_id','religion','mobile_no','email','cnic_no',
        'blood_group','nationality','mother_tongue','medical_history','father_name','father_phone','father_occupation',
        'father_cnic_no','mother_name','mother_phone','mother_occupation','mother_cnic_no','country_id','province_id',
        'district_id','city_id','region_id','std_current_address','std_permanent_address','student_tuition_fee','discount_id',
        'remark','previous_school_name','last_grade','student_image','opening_balance']);
        if (!empty($student_input['student_image'])) {
            $student_image = $this->uploadFile($request, 'student_image', 'student_image', 'image', $student_input['roll_no']);
            $student_input['student_image'] = $student_image;
        }
        $user_id = $request->session()->get('user.id');
        $system_settings_id = $request->session()->get('user.system_settings_id');
        $student_input['system_settings_id'] = $system_settings_id;
        $student_input['created_by'] = $user_id;
        $student_input['admission_date']=$this->uf_date($student_input['admission_date']);
        $student_input['birth_date']=$this->uf_date($student_input['birth_date']);
        // $student_input['current_class_id']=$student_input['adm_class_id'];
        // $student_input['current_class_section_id']=$student_input['adm_class_section_id'];
        // $student_input['cur_session_id']=$student_input['adm_session_id'];
        //Get opening balance if exists
        $ob_transaction =  FeeTransaction::where('student_id', $student_id)
                             ->where('type', 'opening_balance') ->first();
        $opening_balance = isset($student_input['opening_balance']) ? $student_input['opening_balance'] : 0;
        if (isset($student_input['opening_balance'])) {
            unset($student_input['opening_balance']);
        }

        $student=Student::find($student_id);
        $student->fill($student_input);
        $student->save();

        if($guardian_link_id == null){
            $studentGuardian = StudentGuardian::where('student_id',$student_id)->first();
            $guardian = Guardian::where('id',$studentGuardian->guardian_id)->first();
            $guardian->fill($request['guardian']);
            $guardian->save();
            
        }
        else{
            $studentGuardian = StudentGuardian::where('student_id',$student_id)->first();
            $guardian = Guardian::where('id',$studentGuardian->guardian_id)->first();
            $guardian->delete();
            $studentGuardianCreate = StudentGuardian::create([
                'student_id' => $student->id,
                'guardian_id' => $guardian_link_id,
            ]);

        }
     
        if (!empty($ob_transaction)) {
            // $opening_balance_paid = $transactionUtil->getTotalAmountPaid($ob_transaction->id);
            // if (!empty($opening_balance_paid)) {
            //     $opening_balance += $opening_balance_paid;
            // }
            
            $ob_transaction->final_total = $opening_balance;
            $ob_transaction->save();
        //Update opening balance payment status
            // $transactionUtil->updatePaymentStatus($ob_transaction->id, $ob_transaction->final_total);
        } else {
            //Add opening balance
            if (!empty($opening_balance)) {
                $this->createOpeningBalanceTransaction($student->system_settings_id, $student, $opening_balance, false);
            }
        }
    }

    public function removeSibling($guardian,  $student_id){
        $guardian = Guardian::create($guardian);
        $studentGuardian = StudentGuardian::where('student_id',$student_id)->first();
        $studentGuardian->guardian_id=$guardian->id;
        $studentGuardian->save();
    }
    public function getStudentList($system_settings_id,$class_id, $class_section_id){

        
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
        
        return $query->get();
       

    }
}
