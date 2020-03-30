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

Route::post('/auth/register','Api\AuthController@register')->middleware(['auth:api','auth.admin']);
Route::post('auth/login','Api\AuthController@login');
Route::post('/auth/refresh-token','Api\AuthController@refreshToken');


Route::post('/template/set','Api\TemplateController@set')->middleware('auth:api');
Route::post('/template/get','Api\TemplateController@get')->middleware(['auth:api','auth.admin']);

Route::post('/attendance/set','Api\AttendanceController@set')->middleware('auth:api');
Route::post('/attendance/get','Api\AttendanceController@get')->middleware('auth:api');

Route::post('/add-news','Api\NewsController@add')->middleware(['auth:api','auth.admin']);
Route::get('get-news','Api\NewsController@get');

Route::post('/department/create','Api\DepartmentController@create')->middleware(['auth:api','auth.admin']);
Route::post('/department/update','Api\DepartmentController@update')->middleware(['auth:api','auth.admin']);
Route::post('/department/get','Api\DepartmentController@get');

Route::post('/specialty/create','Api\SpecialtyController@create')->middleware(['auth:api','auth.admin']);
Route::post('/specialty/update','Api\SpecialtyController@update')->middleware(['auth:api','auth.admin']);
Route::post('/specialty/get','Api\SpecialtyController@get');

Route::post('/group/create','Api\GroupController@create')->middleware(['auth:api','auth.admin']);
Route::post('/group/update','Api\GroupController@update')->middleware(['auth:api','auth.admin']);
Route::post('/group/get','Api\GroupController@get');

Route::post('/subject/create','Api\SubjectController@create')->middleware(['auth:api','auth.admin']);
Route::post('/subject/update','Api\SubjectController@update')->middleware(['auth:api','auth.admin']);
Route::post('/subject/get','Api\SubjectController@get');

Route::post('/schedule/create','Api\ScheduleController@create')->middleware(['auth:api','auth.admin']);
Route::post('/schedule/update','Api\ScheduleController@update')->middleware(['auth:api','auth.admin']);
Route::post('/schedule/get','Api\ScheduleController@get');

Route::post('/user/create-appointment','Api\UserController@createAppointment')->middleware(['auth:api','auth.admin']);
