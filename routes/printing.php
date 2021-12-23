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

Route::get('/single-fee-card/{transaction_id}', 'SchoolPrinting\FeeCardPrintController@singlePrint');
Route::get('/create-class-wise-print', 'SchoolPrinting\FeeCardPrintController@createClassWisePrint');
Route::post('/class-wise-print', 'SchoolPrinting\FeeCardPrintController@classWisePrintPost');
Route::post('/class-wise-print-all', 'SchoolPrinting\FeeCardPrintController@classWisePrint');

Route::get('class-subject/create/{id}', [
    'as' => 'class-subject.create',
    'uses' => 'Curriculum\ClassSubjectLessonController@create'
]);
// Route::get('class-subject-progress/create/{id}', [
//     'as' => 'class-subject-progress.create',
//     'uses' => 'Curriculum\ClassSubjectProgressController@create'
// ]);
Route::get('class-curriculum/{class_id}', [
    'as' => 'class-curriculum.index',
    'uses' => 'Curriculum\CurriculumController@index'
]);
Route::get('class-curriculum/create/{id}', [
    'as' => 'class-curriculum.create',
    'uses' => 'Curriculum\CurriculumController@create'
]);
Route::get('class-subject-question/create/{id}', [
    'as' => 'class-subject-question.create',
    'uses' => 'Curriculum\ClassSubjectQuestionBankController@create'
]);

Route::resource('class-curriculum', 'Curriculum\CurriculumController',['except' => ['index','create']]);
Route::resource('curriculum-class-subject', 'Curriculum\ClassSubjectController');
Route::resource('class-subject', 'Curriculum\ClassSubjectLessonController',['except' => 'create']);
Route::resource('class-subject-progress', 'Curriculum\ClassSubjectProgressController',['except' => 'create']);
Route::get('get-chapter-lessons', 'Curriculum\ClassSubjectProgressController@getLessons');
Route::resource('class-subject-question', 'Curriculum\ClassSubjectQuestionBankController',['except' => ['create']]);

Route::resource('class-time-table-period', 'Curriculum\ClassTimeTablePeriodController');
Route::resource('class-time-table', 'Curriculum\ClassTimeTableController');


