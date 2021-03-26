<?php


Route::post('/login', 'AuthController@login');

//JSON
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/{specialty}/doctors','SpecialtyController@doctors');
Route::get('/shedule/hours','SheduleController@hours');


Route::middleware('auth:api')->group(function () {
    Route::get('/user','UserController@show');
    Route::post('/logout', 'AuthController@logout');

    // appointments

    Route::get('/appointments', 'AppointmentController@index');
    Route::post('/appointments', 'Appointmentcontroller@store');
    

});