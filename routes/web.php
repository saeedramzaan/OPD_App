<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController; 
use App\Http\Controllers\TimeController; 

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


Route::get('/', function () {
    return view('createPatient');
});

Auth::routes();

Route::resource('patient', PatientController::class);

Route::get('/patientInfo', [PatientController::class, 'patientInfo'])->name('patientInfo');

Route::resource('time', TimeController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/create', [PatientController::class,'create'])->name('test');

Route::get('/search', [PatientController::class,'search'] );


Route::get('/del/{id}', [TimeController::class,'delete'] )->name('del');












