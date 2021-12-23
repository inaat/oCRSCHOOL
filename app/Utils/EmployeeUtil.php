<?php

namespace App\Utils;

use Illuminate\Support\Facades\Hash;
use App\Models\HumanRM\HrmEmployee;
use App\Models\HumanRM\HrmEmployeeDocument;
use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\StudentGuardian;
use App\Models\FeeTransaction;
use DB;
use File;

class EmployeeUtil extends Util
{
    public function employeeCreate($request)
    {
        $employee_input = $request->only(['campus_id','employeeID','first_name' ,'last_name','father_name','gender', 'birth_date','joining_date',
        'religion' ,'mobile_no','email','cnic_no','blood_group','nationality' ,'mother_tongue' ,'country_id','province_id' ,
        'district_id' ,'city_id' ,'region_id','current_address','permanent_address','department_id' , 'designation_id' ,
        'education_id' ,'basic_salary' ,'pay_period','employee_image','password','bank_details']);
        $employee_input['birth_date']=$this->uf_date($employee_input['birth_date']);
        $employee_input['joining_date']=$this->uf_date($employee_input['joining_date']);
        if (!empty($employee_input['employee_image'])) {
            $employee_image = $this->uploadFile($request, 'employee_image', 'employee_image', 'image', $employee_input['employeeID']);
            $employee_input['employee_image'] = $employee_image;
        }
        $employee_input['password'] =!empty($employee_input['password']) ?Hash::make($employee_input['password']) :Hash::make($employee_input['employeeID']);
        

        $employee_input['bank_details'] = !empty($employee_input['bank_details']) ? json_encode($employee_input['bank_details']) : null;
        $employee_input['email'] = !empty($employee_input['email']) ? $employee_input['email'] : $employee_input['employeeID'].'@gmail.com';

        $employee_input['password'] = Hash::make($employee_input['password']);

        $employee_input['basic_salary'] = $this->num_uf($employee_input['basic_salary']);
        $employee=HrmEmployee::create($employee_input);
        $employee_document=$request->file('document');
        // -------------- UPLOAD THE DOCUMENTS  -----------------
        $documents = ['resume', 'offerLetter', 'joiningLetter', 'contract', 'IDProof'];


        foreach ($documents as $document) {
            if ($request->hasFile($document)) {
                $filename=$this->uploadFile($request, $document, 'document');
                HrmEmployeeDocument::create([
                    'employee_id' => $employee->id,
                    'filename' => $filename,
                    'type' => $document
                ]);
            }
        }
        return $employee;
    }


    public function employeeUpdate($request, $id)
    {
        $employee_input = $request->only(['campus_id','employeeID','first_name' ,'last_name','father_name','gender', 'birth_date','joining_date',
        'religion' ,'mobile_no','email','cnic_no','blood_group','nationality' ,'mother_tongue' ,'country_id','province_id' ,
        'district_id' ,'city_id' ,'region_id','current_address','permanent_address','department_id' , 'designation_id' ,
        'education_id' ,'basic_salary' ,'pay_period','employee_image','password','bank_details']);
        $employee_input['birth_date']=$this->uf_date($employee_input['birth_date']);
        $employee_input['joining_date']=$this->uf_date($employee_input['joining_date']);
        $employee=HrmEmployee::find($id);

        if (!empty($employee_input['employee_image'])) {
            if (File::exists(public_path('uploads/employee_image/'.$employee->employee_image))) {
                File::delete(public_path('uploads/employee_image/'.$employee->employee_image));
            }
            $employee_image = $this->uploadFile($request, 'employee_image', 'employee_image', 'image', $employee_input['employeeID']);
            $employee_input['employee_image'] = $employee_image;
        }
        if (empty($employee_input['password'])) {
            unset($employee_input['password']);
        } else {
            $employee_input['password'] =!empty($employee) ?Hash::make($employee_input['password']) :Hash::make($employee_input['employeeID']);
        }
        

        $employee_input['bank_details'] = !empty($employee_input['bank_details']) ? json_encode($employee_input['bank_details']) : null;
        $employee_input['email'] = !empty($employee_input['email']) ? $employee_input['email'] : $employee_input['employeeID'].'@gmail.com';
        $employee_input['basic_salary'] = $this->num_uf($employee_input['basic_salary']);
        $employee->fill($employee_input);
        $employee->save();
        // -------------- UPLOAD THE DOCUMENTS  -----------------
        $documents = ['resume', 'offerLetter', 'joiningLetter', 'contract', 'IDProof'];


        foreach ($documents as $document) {
            if ($request->hasFile($document)) {
                $filename=$this->uploadFile($request, $document, 'document');
                $employee_document=HrmEmployeeDocument::where('employee_id', $employee->id)->where('type', $document)->first();
                $employee_document->filename;
                if (!empty($employee_document)) {
                    if (File::exists(public_path('uploads/document/'.$employee_document->filename))) {
                        File::delete(public_path('uploads/document/'.$employee_document->filename));
                    }
                    $employee_document->filename = $filename;
                    $employee_document->save();
                } else {
                    HrmEmployeeDocument::create([
                    'employee_id' => $employee->id,
                    'filename' => $filename,
                    'type' => $document
                ]);
                }
            }
        }
        return $employee;
    }


    public function getEmployeeList($campus_id,$already_exists){

        
        $query=HrmEmployee::leftJoin('campuses', 'hrm_employees.campus_id', '=', 'campuses.id')
        ->where('status','=','active')
        ->whereNotIn('hrm_employees.id',$already_exists)
        ->select(
            'campuses.campus_name',
            'hrm_employees.father_name',
            'hrm_employees.employeeID',
            'hrm_employees.status',
            'hrm_employees.id as id',
            'hrm_employees.basic_salary',
            'hrm_employees.employee_image',
            'hrm_employees.joining_date',
            DB::raw("CONCAT(COALESCE(hrm_employees.first_name, ''),' ',COALESCE(hrm_employees.last_name,'')) as employee_name")
        );
         
        if (!empty($campus_id)) {
            $query->where('hrm_employees.campus_id', $campus_id);
        }
        
        return $query->get();
       

    }
}
