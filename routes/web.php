<?php

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
    return  redirect('/login');  //view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); // {{ route('home')}}


Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
   
        // Specialty 


        Route::get('/specialties','SpecialtyController@index');
        Route::get('/specialties/create','SpecialtyController@create'); //form registro
        Route::get('/specialties/{specialty}/edit','SpecialtyController@edit');

        Route::post('/specialties','Specialtycontroller@store'); // envio del form 
        Route::put('/specialties/{specialty}','SpecialtyController@update');
        Route::delete('/specialties/{specialty}','SpecialtyController@destroy');


        // Doctors

        Route::resource('doctors', 'DoctorController');

        // Patients 

        Route::resource('patients', 'PatientController');

        // Charts 

        Route::get('/charts/appointments/line', 'ChartController@appointments');
        Route::get('/charts/doctors/column', 'ChartController@doctors');
        Route::get('/charts/doctors/column/data', 'ChartController@doctorsJson');

});


Route::middleware(['auth', 'doctor'])->namespace('doctor')->group(function () {

     Route::get('/shedule', 'SheduleController@index');
     Route::post('/shedule', 'SheduleController@store');  
});


Route::middleware('auth')->group(function(){

    Route::get('/appointments/create', 'AppointmentController@create');
    Route::post('/appointments', 'AppointmentController@store');



    Route::get('/appointments', 'AppointmentController@index');
    Route::get('/appointments/{appointment}', 'AppointmentController@show');
    
    Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm');
    Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel');

    Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm');

    //JSON
    Route::get('/specialties/{specialty}/doctors','Api\SpecialtyController@doctors');
    Route::get('/shedule/hours','Api\SheduleController@hours');
});














