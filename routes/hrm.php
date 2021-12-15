<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| printing Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::resource('hrm-department', 'HRM\HrmDepartmentController');
Route::resource('hrm-allowance', 'HRM\HrmAllowanceController');
Route::resource('hrm-deduction', 'HRM\HrmDeductionController');
Route::resource('hrm-print', 'HRM\HrmPrintController');
Route::get('employee-list-print', 'HRM\HrmPrintController@employeeListPrintCreate');
Route::post('employee-list-print-post', 'HRM\HrmPrintController@PostEmployeePrint');
Route::resource('hrm-designation', 'HRM\HrmDesignationController');
Route::resource('hrm-education', 'HRM\HrmEducationController');
Route::resource('hrm-leave_category', 'HRM\HrmLeaveCategoryController');
Route::resource('hrm-shift', 'HRM\HrmShiftController');
Route::resource('hrm-employee', 'HRM\HrmEmployeeController');
Route::resource('hrm-payroll', 'HRM\HrmPayrollController');
Route::post('payroll-assign-search', 'HRM\HrmPayrollController@payrollAssignSearch')->name('payroll-assign-search');


Route::get('/payments/pay-employee-due/{employee_id}', 'HRM\HrmTransactionPaymentController@getPayEmployeeDue');
Route::post('/payments/pay-employee-due', 'HRM\HrmTransactionPaymentController@postPayEmployeeDue');
Route::get('/payments/hrm-add_payment/{transaction_id}', 'HRM\HrmTransactionPaymentController@addPayment');
///option 
Route::get('/payments/add_employee_advance_amount_payment/{employee_id}', 'HRM\HrmTransactionPaymentController@addEmployeeAdvanceAmountPayment');
Route::post('/payments/hrm-post_advance_amount_payment', 'HRM\HrmTransactionPaymentController@postAdvanceAmount');
///

Route::resource('hrm_payment', 'HRM\HrmTransactionPaymentController');



Route::post('employee/update-status', 'HRM\HrmEmployeeController@updateStatus');
Route::post('employee/employee-resign', 'HRM\HrmEmployeeController@employeeResign');
Route::post('/employee/register/check-email', 'HRM\HrmEmployeeController@postCheckEmail')->name('employee.postCheckEmail');

Route::get('/shift/assign-users/{shift_id}', 'HRM\HrmShiftController@getAssignUsers');
        Route::post('/shift/assign-users', 'HRM\HrmShiftController@postAssignUsers');

