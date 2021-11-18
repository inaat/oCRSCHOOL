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

