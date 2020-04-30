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

Route::post('/auth/validate-token', function () {
    return ['data' => 'Token is valid'];
})->middleware('auth:api');

Route::get('/user/get','Api\UserController@get')->middleware('auth:api');
Route::get('/user/get-roles','Api\UserController@getRoles');

Route::post('/auth/register','Api\AuthController@register')->middleware(['auth:api','auth.admin']);
Route::post('auth/login','Api\AuthController@login');
Route::post('/auth/refresh-token','Api\AuthController@refreshToken');
Route::post('/auth/logout','Api\AuthController@logout')->middleware('auth:api');


Route::post('/template/set','Api\TemplateController@set')->middleware('auth:api');
Route::post('/template/get','Api\TemplateController@get')->middleware(['auth:api','auth.admin']);

Route::post('/attendance/set','Api\AttendanceController@set')->middleware('auth:api');
Route::post('/attendance/get','Api\AttendanceController@get')->middleware('auth:api');

Route::post('/add-news','Api\NewsController@add')->middleware(['auth:api','auth.admin']);
Route::get('/news/get','Api\NewsController@get');

Route::post('/department/create','Api\DepartmentController@create')->middleware(['auth:api','auth.admin']);
Route::post('/department/update','Api\DepartmentController@update')->middleware(['auth:api','auth.admin']);
Route::get('/department/get','Api\DepartmentController@get');
Route::get('/department/get-all','Api\DepartmentController@getAll');

Route::post('/specialty/create','Api\SpecialtyController@create')->middleware(['auth:api','auth.admin']);
Route::post('/specialty/update','Api\SpecialtyController@update')->middleware(['auth:api','auth.admin']);
Route::post('/specialty/get','Api\SpecialtyController@get');

Route::post('/group/create','Api\GroupController@create')->middleware(['auth:api','auth.admin']);
Route::post('/group/update','Api\GroupController@update')->middleware(['auth:api','auth.admin']);
Route::get('/group/get','Api\GroupController@get');
Route::get('/group/get-all','Api\GroupController@getAll');


Route::post('/subject/create','Api\SubjectController@create')->middleware(['auth:api','auth.admin']);
Route::post('/subject/update','Api\SubjectController@update')->middleware(['auth:api','auth.admin']);
Route::get('/subject/get','Api\SubjectController@get')->middleware('auth:api');
Route::get('/subject/get-student-weeks','Api\SubjectController@getStudentWeeks')->middleware('auth:api');
Route::get('/subject/get-teacher-weeks','Api\SubjectController@getTeacherWeeks')->middleware('auth:api');
Route::post('/subject/attendance','Api\SubjectController@getAttendance')->middleware('auth:api');
Route::post('/subject/create-lesson','Api\SubjectController@createLesson')->middleware(['auth:api','auth.teacher']);


Route::post('/schedule/create','Api\ScheduleController@create')->middleware(['auth:api','auth.admin']);
Route::post('/schedule/update','Api\ScheduleController@update')->middleware(['auth:api','auth.admin']);
Route::get('/schedule/get','Api\ScheduleController@get');

Route::post('/user/create-appointment','Api\UserController@createAppointment')->middleware(['auth:api','auth.admin']);

Route::post('/file/upload','Api\FileController@upload')->middleware(['auth:api','auth.admin']);

