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

Route::get('/getusers', 'Apicontroller@getUsers')->middleware('cors');
Route::get('/getusersautomatic', 'Apicontroller@getUsersAutomatic')->middleware('cors');
Route::post('/saveuser', 'Apicontroller@saveUser')->middleware('cors');
Route::post('/updatebet', 'Apicontroller@updateBet')->middleware('cors');
Route::get('/showuser/{id}', 'Apicontroller@showUser')->middleware('cors');
Route::post('/edituser', 'Apicontroller@editUser')->middleware('cors');
Route::get('/deleteuser/{id}', 'Apicontroller@deleteUser')->middleware('cors');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
