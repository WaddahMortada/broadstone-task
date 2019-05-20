<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('/workers', 'WorkerController@index');

Route::get('/worker/{id}/applications/', 'WorkerApplicationsController@viewApplications');
Route::patch('/worker/{id}/applications/', 'WorkerApplicationsController@update');

Route::fallback(function(){
	return response()->json(
		[
			'message' => 'Page Not Found'
		],
		404
	);
});
