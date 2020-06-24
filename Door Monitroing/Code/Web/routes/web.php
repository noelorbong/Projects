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
Route::get('/cameraalone', function () {
    return view('camera.cameraalone');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/smslist', 'SMS\SMSController@index')->name('smslist');
Route::get('/smsget/{sortcolum}/{sort}', 'SMS\SMSController@list')->name('smsget');
Route::get('/smsadd', 'SMS\SMSController@add')->name('smsadd');
Route::post('/smsstore', 'SMS\SMSController@store')->name('smsstore');
Route::get('/smsedit/{id}', 'SMS\SMSController@edit')->name('smsedit');
Route::post('/smsupdate', 'SMS\SMSController@update')->name('smsupdate');
Route::get('/smssearch/{search}', 'SMS\SMSController@search')->name('smssearch');
Route::get('/smsdelete/{id}', 'SMS\SMSController@delete')->name('smsdelete');
Route::get('/updatesmsstatus/{id}/{status}', 'SMS\SMSController@updateStatus')->name('updatestatus');


Route::get('/emaillist', 'Email\EmailController@index')->name('emaillist');
Route::get('/emailget/{sortcolum}/{sort}', 'Email\EmailController@list')->name('emailget');
Route::get('/emailadd', 'Email\EmailController@add')->name('emailadd');
Route::post('/emailstore', 'Email\EmailController@store')->name('emailstore');
Route::get('/emailedit/{id}', 'Email\EmailController@edit')->name('emailedit');
Route::post('/emailupdate', 'Email\EmailController@update')->name('emailupdate');
Route::get('/emailsearch/{search}', 'Email\EmailController@search')->name('emailsearch');
Route::get('/emaildelete/{id}', 'Email\EmailController@delete')->name('emaildelete');
Route::get('/updateemailstatus/{id}/{status}', 'Email\EmailController@updateStatus')->name('updateemailstatus');

Route::get('/smssetting', 'Setting\SMSController@smsSetting')->name('smssetting');
Route::post('/smssettingupdate', 'Setting\SMSController@smsUpdate')->name('smssettingupdate');
Route::get('/emailsetting', 'Setting\EmailController@emailSetting')->name('emailsetting');
Route::post('/emailsettingupdate', 'Setting\EmailController@emailUpdate')->name('emailupdate');

Route::get('/emaillog', 'Logs\LogsController@emailLogIndex')->name('emaillog');
Route::get('/smslog', 'Logs\LogsController@smsLogIndex')->name('smslog');
Route::get('/sensorlog', 'Logs\LogsController@sensorLogIndex')->name('sensorlog');
Route::get('/selectsmslog/{startdate}/{enddate}', 'Logs\LogsController@selectSMSLog')->name('selectsmslog');
Route::get('/selectemaillog/{startdate}/{enddate}', 'Logs\LogsController@selectEmailLog')->name('selectemaillog');
Route::get('/selectsensorlog/{startdate}/{enddate}', 'Logs\LogsController@selectSensorLog')->name('selectsensorlog');
Route::get('/countalllog/{date}', 'Logs\LogsController@countAllLog')->name('countalllog');

Route::get('/camera', 'Extras\CameraController@index')->name('camera');
