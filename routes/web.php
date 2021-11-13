<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth','SetSessionData','timezone','superadmin','AdminSidebarMenu'])->group(function () {

 
    Route::resource('session', 'SessionController');
    Route::put('session/activate-session/{id}', 'SessionController@activateSession');
    Route::get('/sessions/get_roll_no', 'SessionController@getRollNo');
    Route::get('/classes/get_campus_classes', 'ClassController@getCampusClass');
    Route::get('/classes/get_class_fee', 'ClassController@getClassFee');
    Route::get('/classes/get_class_section', 'ClassController@getClassSection');
    Route::get('/get_provinces', 'ProvinceController@getProvinces');
    Route::get('/get_districts', 'DistrictController@getDistricts');
    Route::get('/get_cities', 'CityController@getCities');
    Route::get('/get_regions', 'RegionController@getRegions');
    Route::get('/add_sibling', 'StudentController@addSibling');
    Route::get('/add_admission_fee/{id}', 'StudentController@addAdmissionFee');
    Route::post('/post_admission_fee', 'StudentController@postAdmissionFee');
    
    Route::get('student/getByClassAndSection', 'StudentController@getByClassAndSection');
    Route::get('student/getStudentRecordByID', 'StudentController@getStudentRecordByID');
    Route::get('/payments/pay-student-due/{student_id}', 'FeeTransactionPaymentController@getPayStudentDue');
    Route::post('/payments/pay-student-due', 'FeeTransactionPaymentController@postPayStudentDue');




    Route::resource('fee_payment', 'FeeTransactionPaymentController');
    Route::resource('setting', 'SystemSettingController');
    Route::resource('designation', 'DesignationController');
    Route::resource('campuses', 'CampusController');
    Route::resource('awards', 'AwardController');
    Route::resource('discounts', 'DiscountController');
    Route::resource('class_levels', 'ClassLevelController');
    Route::resource('classes', 'ClassController');
    Route::resource('sections', 'ClassSectionController');
    Route::resource('categories', 'CategoryController');
    Route::resource('provinces', 'ProvinceController');
    Route::resource('districts', 'DistrictController');
    Route::resource('cities', 'CityController');

    Route::resource('regions', 'RegionController');
    Route::resource('students', 'StudentController');
    Route::resource('fee-allocation', 'FeeAllocationController');
    Route::post('fees-assign-search', 'FeeAllocationController@feesAssignSearch')->name('fees-assign-search');


    Route::group(['prefix' => 'account'], function () {
        Route::resource('/account', 'AccountController');
        Route::get('/fund-transfer/{id}', 'AccountController@getFundTransfer');
        Route::post('/fund-transfer', 'AccountController@postFundTransfer');
        Route::get('/deposit/{id}', 'AccountController@getDeposit');
        Route::post('/deposit', 'AccountController@postDeposit');
        Route::get('/close/{id}', 'AccountController@close');
        Route::get('/activate/{id}', 'AccountController@activate');
        Route::get('/delete-account-transaction/{id}', 'AccountController@destroyAccountTransaction');
        Route::get('/get-account-balance/{id}', 'AccountController@getAccountBalance');
        // Route::get('/balance-sheet', 'AccountReportsController@balanceSheet');
        // Route::get('/trial-balance', 'AccountReportsController@trialBalance');
        // Route::get('/payment-account-report', 'AccountReportsController@paymentAccountReport');
        // Route::get('/link-account/{id}', 'AccountReportsController@getLinkAccount');
        // Route::post('/link-account', 'AccountReportsController@postLinkAccount');
        Route::get('/cash-flow', 'AccountController@cashFlow');
        Route::get('/debit/{id}', 'AccountController@getDebit');
        Route::post('/debit', 'AccountController@postDebit');
    });
    Route::resource('account-types', 'AccountTypeController');


});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
