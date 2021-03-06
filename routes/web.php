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

Route::view('/', 'index');
Route::post('/send/one', 'SMSController@sendOne')->name('send.one');
Route::post('/send/many', 'SMSController@sendMany')->name('send.many');
Route::get('/mpesa/token', 'MpesaController@tokenize')->name('mpesa.token');
Route::post('/mpesa/callback', 'MpesaController@callback')->name('mpesa.callback');
Route::post('/mpesa/lipa', 'MpesaController@lipa')->name('mpesa.lipa');



