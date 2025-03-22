<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

Route::prefix('api/v1')->group(function () {
	Route::controller(UserController::class)->group(function () {
	    Route::get('/users', 		'index');
	    Route::get('/user/{id}', 	'show');
	    Route::post('/user', 		'store');
	    Route::put('/user/{id}', 	'update');
	    Route::delete('/user/{id}', 'destroy');
	});
});