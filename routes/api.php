<?php


Route::post('/login', 'AuthController@login');


Route::middleware('auth:api')->group(function () {
    Route::get('/user','UserController@show');
    Route::post('/logout', 'AuthController@logout');

});