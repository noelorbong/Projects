<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth
Auth::routes();

//HomeController
Route::get('/home', 'HomeController@index')->name('home');

//DashboardController
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/usermanual', 'DashboardController@usermanual')->name('usermanual');

//StudentsController
Route::get('/studentlist', 'Students\StudentsController@index')->name('studentlist');
Route::get('/studentadd', 'Students\StudentsController@add')->name('studentadd');
Route::get('/profile/{id}', 'Students\StudentsController@profile')->name('profile');
Route::get('/edit/{id}', 'Students\StudentsController@edit')->name('edit');
Route::get('/sortstudents/{sortcolum}/{sort}', 'Students\StudentsController@list')->name('sortstudents');
Route::get('/searchstudents/{search}', 'Students\StudentsController@search')->name('searchstudents');
Route::get('/profiledelete/{id}', 'Students\StudentsController@delete');
Route::post('/studentstore', 'Students\StudentsController@store')->name('studentstore');
Route::post('/studentupdate', 'Students\StudentsController@update')->name('studentupdate');
Route::get('/listgrade', 'Students\StudentsController@listGrade');
Route::get('/sections/{grade_level}', 'Students\StudentsController@listSection');
Route::get('/sectionlist/{grade_level}/{section}', 'Students\StudentsController@listSectionIndex');
Route::get('/listsectionstudents/{grade_level}/{section}', 'Students\StudentsController@listSectionStudents');
Route::get('/searchlistsectionstudents/{grade_level}/{section}/{search}', 'Students\StudentsController@searchListSectionStudents');

//RegisterController
Route::get('/faceregister/{id}', 'Students\RegisterController@index')->name('faceregister');
Route::get('/takecamera/{id}', 'Students\RegisterController@takeDataset')->name('takecamera');
Route::get('/updatecamera', 'Students\RegisterController@updateDataset')->name('updatecamera');
Route::get('/deletecamera', 'Students\RegisterController@deleteDataset')->name('deletecamera');
Route::get('/regcount', 'Students\RegisterController@regCount')->name('regcount');

//LogsController
Route::get('/studentlogs', 'Logs\LogsController@index')->name('studentlogs');
Route::get('/smslogs', 'Logs\LogsController@smsLogIndex')->name('smslogs');
Route::get('/report', 'Logs\LogsController@report')->name('report');
Route::get('/countinout/{date}', 'Logs\LogsController@countInOut')->name('countinout');
Route::get('/currentlog', 'Logs\LogsController@currentLog')->name('currentlog');
Route::get('/selectlogs/{startdate}/{enddate}', 'Logs\LogsController@selectLogs')->name('selectlogs');
Route::get('/print/{startdate}/{enddate}', 'Logs\LogsController@printLogs')->name('print');
Route::get('/poplog', 'Logs\LogsController@popLog');
Route::get('/selectlastlog', 'Logs\LogsController@selectLastLog');
Route::get('/selectsmslogs/{startdate}/{enddate}', 'Logs\LogsController@selectSMSLogs')->name('selectsmslogs');
Route::get('/listgradelog', 'Logs\LogsController@listGrade');
Route::get('/sectionslog/{grade_level}', 'Logs\LogsController@listSection');
Route::get('/sectionlistlog/{grade_level}/{section}', 'Logs\LogsController@listSectionIndex');
Route::get('/selectsectionlogs/{grade_level}/{section}/{startdate}/{enddate}', 'Logs\LogsController@listSectionStudents');
Route::get('/printsection/{grade_level}/{section}/{startdate}/{enddate}', 'Logs\LogsController@printSectionLogs');
Route::get('/listunknownlog', 'Logs\LogsController@listUnknownLog');
// Route::get('/listsectionstudentslog/{grade_level}/{section}', 'Logs\LogsController@listSectionStudents');

//MessagesController
Route::get('/sms', 'Extras\MessagesController@index')->name('sms');
Route::get('/smslist', 'Extras\MessagesController@pendingList')->name('smslist');
Route::get('/smssetting', 'Extras\MessagesController@smsSetting')->name('smssetting');
Route::post('/smsupdate', 'Extras\MessagesController@smsUpdate')->name('smsupdate');

//EmailController
Route::get('/emailsetting', 'Extras\EmailController@emailSetting')->name('emailsetting');
Route::post('/emailupdate', 'Extras\EmailController@emailUpdate')->name('emailupdate');
Route::post('/emailstore', 'Extras\EmailController@store')->name('emailstore');

//CameraController
Route::get('/camera', 'CameraController@index')->name('camera');

