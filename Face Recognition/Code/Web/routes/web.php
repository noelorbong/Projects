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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/studentlist', 'Students\StudentsController@index')->name('studentlist');
Route::get('/studentadd', 'Students\StudentsController@add')->name('studentadd');
Route::get('/faceregister/{id}', 'Students\RegisterController@index')->name('faceregister');
Route::get('/studentlogs', 'Logs\LogsController@index')->name('studentlogs');
Route::get('/smslogs', 'Logs\LogsController@smsLogIndex')->name('smslogs');

Route::get('/report', 'Logs\LogsController@report')->name('report');
Route::get('/sms', 'Extras\MessagesController@index')->name('sms');

Route::get('/profile/{id}', 'Students\StudentsController@profile')->name('profile');
//Api

Route::get('/camera', 'CameraController@index')->name('camera');
Route::get('/edit/{id}', 'Students\StudentsController@edit')->name('edit');

Route::get('/takecamera/{id}', 'Students\RegisterController@takeDataset')->name('takecamera');
Route::get('/sortstudents/{sortcolum}/{sort}', 'Students\StudentsController@list')->name('sortstudents');
Route::get('/searchstudents/{search}', 'Students\StudentsController@search')->name('searchstudents');

Route::get('/countinout/{date}', 'Logs\LogsController@countInOut')->name('countinout');
Route::get('/currentlog', 'Logs\LogsController@currentLog')->name('currentlog');

Route::post('/studentstore', 'Students\StudentsController@store')->name('studentstore');
Route::post('/studentupdate', 'Students\StudentsController@update')->name('studentupdate');
Route::get('/regcount', 'Students\RegisterController@regCount')->name('regcount');
Route::get('/selectlogs/{startdate}/{enddate}', 'Logs\LogsController@selectLogs')->name('selectlogs');
Route::get('/print/{startdate}/{enddate}', 'Logs\LogsController@printLogs')->name('print');

Route::get('/smslist', 'Extras\MessagesController@pendingList')->name('smslist');
Route::get('/smssetting', 'Extras\MessagesController@smsSetting')->name('smssetting');
Route::post('/smsupdate', 'Extras\MessagesController@smsUpdate')->name('smsupdate');
Route::get('/selectsmslogs/{startdate}/{enddate}', 'Logs\LogsController@selectSMSLogs')->name('selectsmslogs');

Route::get('/emailsetting', 'Extras\EmailController@emailSetting')->name('emailsetting');
Route::post('/emailupdate', 'Extras\EmailController@emailUpdate')->name('emailupdate');
Route::post('/emailstore', 'Extras\EmailController@store')->name('emailstore');
