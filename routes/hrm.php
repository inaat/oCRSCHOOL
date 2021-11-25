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
Route::resource('hrm-designation', 'HRM\HrmDesignationController');
Route::resource('hrm-education', 'HRM\HrmEducationController');
Route::resource('hrm-leave_category', 'HRM\HrmLeaveCategoryController');
Route::resource('hrm-shift', 'HRM\HrmShiftController');
Route::get('/shift/assign-users/{shift_id}', 'HRM\HrmShiftController@getAssignUsers');
        Route::post('/shift/assign-users', 'HRM\HrmShiftController@postAssignUsers');

