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
    return view('extras.cameraalone');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/userlist', 'Rfid\UsersController@index')->name('userlist');
Route::get('/useradd', 'Rfid\UsersController@addView')->name('useradd');
Route::get('/useredit/{id}', 'Rfid\UsersController@editAccount')->name('useredit');
Route::get('/log', 'Rfid\LogController@index')->name('log');
Route::get('/logowner', 'Rfid\LogOwnerController@index')->name('logowner');
Route::get('/logguest', 'Rfid\LogGuestController@index')->name('logguest');

Route::get('/report', 'Rfid\ReportController@index')->name('report');

Route::get('/camera', 'Extras\CameraController@index')->name('camera');
Route::get('/getip', 'Extras\CameraController@ipCamera')->name('getip');
Route::get('/updatecam/{ip}', 'Extras\CameraController@updateCamera')->name('updatecam');
Route::get('/getplate', 'Extras\CameraController@getPlate')->name('getplate');

// API
Route::post('/userstore', 'Rfid\UsersController@storeRfidAccount')->name('userstore');
Route::post('/userupdate/{id}', 'Rfid\UsersController@updateRfidAccount')->name('userupdate');
Route::get('/userdelete/{id}', 'Rfid\UsersController@deleteAccount')->name('userdelete');
Route::get('/searchrfid/{search}', 'Rfid\UsersController@searchRfid')->name('searchrfid');

Route::get('/deletelog/{id}', 'Rfid\LogController@deleteLog')->name('deletelog');
Route::get('/searchlog/{search}', 'Rfid\LogController@searchLog')->name('searchlog');
Route::get('/searchownerlog/{search}', 'Rfid\LogOwnerController@searchLog')->name('searchownerlog');
Route::get('/searchguestlog/{search}', 'Rfid\LogGuestController@searchLog')->name('searchguestlog');

Route::get('/countinout/{date}', 'Rfid\ReportController@countInOut')->name('countinout');
Route::get('/currentlog', 'Rfid\LogController@currentLog')->name('currentlog');

//Sorting API
Route::get('/sortrfid/{sortcolum}/{sort}', 'Rfid\LogController@sortRfid')->name('sortrfid');
Route::get('/sortrfid/{search}/{sortcolum}/{sort}', 'Rfid\LogController@searchLogSort')->name('sortrfid2');

Route::get('/sortrfidowner/{sortcolum}/{sort}', 'Rfid\LogOwnerController@sortRfid')->name('sortrfidowner');
Route::get('/sortrfidowner/{search}/{sortcolum}/{sort}', 'Rfid\LogOwnerController@searchLogSort')->name('sortrfidowner2');

Route::get('/sortrfidguest/{sortcolum}/{sort}', 'Rfid\LogGuestController@sortRfid')->name('sortrfidguest');
Route::get('/sortrfidguest/{search}/{sortcolum}/{sort}', 'Rfid\LogGuestController@searchLogSort')->name('sortrfidguest2');


Route::get('/sortrfidli/{sortcolum}/{sort}', 'Rfid\UsersController@sortRfid')->name('sortrfidli');
Route::get('/sortrfidli/{search}/{sortcolum}/{sort}', 'Rfid\UsersController@searchLogSort')->name('sortrfidli2');
