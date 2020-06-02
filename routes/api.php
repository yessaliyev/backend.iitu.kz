<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user/get', 'Api\UserController@get');
    Route::post('/auth/logout', 'Api\AuthController@logout');
    Route::get('/subject/get', 'Api\SubjectController@get');
    Route::get('/subject/get-student-weeks', 'Api\SubjectController@getStudentWeeks');
    Route::get('/subject/get-weeks', 'Api\SubjectController@getWeeks');
    Route::post('/subject/attendance', 'Api\SubjectController@getAttendance');

});

Route::middleware(['auth:api', 'auth.admin'])->group(function () {
    Route::get('/user/get-roles', 'Api\UserController@getRoles');
    Route::post('/auth/register', 'Api\AuthController@register');
    Route::post('/department/create', 'Api\DepartmentController@create');
    Route::post('/department/update', 'Api\DepartmentController@update');
    Route::post('/add-news', 'Api\NewsController@add');
    Route::post('/department/create', 'Api\DepartmentController@create');
    Route::post('/department/update', 'Api\DepartmentController@update');
    Route::post('/specialty/create', 'Api\SpecialtyController@create');
    Route::post('/specialty/update', 'Api\SpecialtyController@update');
    Route::post('/group/create', 'Api\GroupController@create');
    Route::post('/group/update', 'Api\GroupController@update');
    Route::post('/subject/create', 'Api\SubjectController@create');
    Route::post('/subject/update', 'Api\SubjectController@update');
    Route::post('/subject/create', 'Api\SubjectController@create');
    Route::post('/subject/update', 'Api\SubjectController@update');
    Route::post('/user/create-appointment', 'Api\UserController@createAppointment');
    Route::post('/file/upload', 'Api\FileController@upload');
});

Route::middleware(['auth:api', 'auth.teacher'])->group(function () {
    Route::get('/attendance/get-course-attendance', 'Api\AttendanceController@getCourseAttendance');
    Route::get('/attendance/get-group-attendance', 'Api\AttendanceController@getGroupAttendance');
    Route::post('/attendance/set-students-attendance', 'Api\AttendanceController@setStudentsAttendance');
    Route::get('/group/get-by-subject', 'Api\GroupController@getBySubject');
    Route::post('/subject/create-lesson', 'Api\SubjectController@createLesson');
    Route::get('/subject/get-types', 'Api\SubjectController@getTypes');
    Route::get('/subject/get-groups', 'Api\SubjectController@getGroups');
    Route::post('/subject/add-to-week', 'Api\SubjectController@addToWeek');
});

Route::middleware(['auth.service'])->group(function () {
    Route::get('/group/get-students', 'Api\GroupController@getStudents');
    Route::post('/template/set', 'Api\TemplateController@set');
    Route::post('/template/get', 'Api\TemplateController@get');
    Route::post('/attendance/set', 'Api\AttendanceController@set');
});

Route::post('/auth/login', 'Api\AuthController@login');
Route::post('/auth/refresh-token', 'Api\AuthController@refreshToken');
Route::get('/news/get', 'Api\NewsController@get');
Route::get('/department/get', 'Api\DepartmentController@get');
Route::get('/department/get-all', 'Api\DepartmentController@getAll');
Route::get('/specialty/get', 'Api\SpecialtyController@get');
Route::get('/group/get-all', 'Api\GroupController@getAll');
Route::get('/schedule/get', 'Api\ScheduleController@get');
Route::get('news/get-by-id','Api\NewsController@getById');



