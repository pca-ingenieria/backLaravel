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

Route::get('/getusers', 'ApiController@getUsers')->middleware('cors');
Route::get('/getusersautomatic', 'ApiController@getUsersAutomatic')->middleware('cors');
Route::post('/saveuser', 'ApiController@saveUser')->middleware('cors');
Route::post('/updatebet', 'ApiController@updateBet')->middleware('cors');
Route::get('/showuser/{id}', 'ApiController@showUser')->middleware('cors');
Route::post('/edituser', 'ApiController@editUser')->middleware('cors');
Route::get('/deleteuser/{id}', 'ApiController@deleteUser')->middleware('cors');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
