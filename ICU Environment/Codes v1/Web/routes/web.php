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

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/camera', 'Extras\CameraController@index')->name('camera');
Route::get('/devices', 'Extras\DevicesController@index')->name('camera');

Route::get('/temperature', 'Sensors\TemperatureController@index')->name('temperature');
Route::get('/humidity', 'Sensors\HumidityController@index')->name('humidity');
Route::get('/co2', 'Sensors\CO2Controller@index')->name('co2');

Route::get('/historytemperature', 'History\TemperatureController@index')->name('historytemperature');
Route::get('/historyhumidity', 'History\HumidityController@index')->name('historyhumidity');
Route::get('/historyco2', 'History\CO2Controller@index')->name('historyco2');

// Api
Route::get('/realtimetemp', 'Sensors\TemperatureController@realTimeTemp')->name('realtimetemp');
Route::get('/realtimetempupdate', 'Sensors\TemperatureController@realTimeTempUpdate')->name('realtimetempupdate');
Route::get('/realtimehumi', 'Sensors\HumidityController@realTimeHumi')->name('realtimehumi');
Route::get('/realtimehumiupdate', 'Sensors\HumidityController@realTimeHumiUpdate')->name('realtimehumipupdate');
Route::get('/realtimeco2', 'Sensors\CO2Controller@realTimeCo2')->name('realtimeco2');
Route::get('/realtimeco2update', 'Sensors\CO2Controller@realTimeCo2Update')->name('realtimeco2update');

Route::get('/selectedtempdate/{startdate}/{enddate}', 'History\TemperatureController@selectedDate')->name('historytemp');
Route::get('/selectedhumidate/{startdate}/{enddate}', 'History\HumidityController@selectedDate')->name('historyhumi');
Route::get('/selectedco2date/{startdate}/{enddate}', 'History\CO2Controller@selectedDate')->name('historyco2');

Route::get('/devicestate', 'Extras\DevicesController@deviceState')->name('devicestate');
