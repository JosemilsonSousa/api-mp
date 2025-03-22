<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

Route::prefix('api/v1')->group(function () {
	Route::controller(UserController::class)->group(function () {
	    Route::get('/users', 		'index');
	    Route::get('/user/{user}', 	'show');
	    Route::post('/user', 		'store');
	    Route::put('/user/{user}', 	'update');
	    Route::delete('/user/{user}', 'destroy');
	});
});