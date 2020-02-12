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
Route::get('/get-user','Api\UserController@getUser')->middleware('auth:api');

Route::post('/register','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');

Route::post('/set-template','Api\TemplateController@setTemplate')->middleware('auth:api');
Route::post('/get-template','Api\TemplateController@getTemplate')->middleware(['auth:api','auth.admin']);
Route::post('/set-attendance','Api\AttendanceController@setAttendance')->middleware('auth:api');

