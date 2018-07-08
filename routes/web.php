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
Route::get('/', 'HomeController@index');

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::resource('stations', 'StationsController');
Route::get('spots/create', 'SpotsController@create')->name('spots.create');
Route::get('stations/{post_id}', 'StationsController@index')->name('stations.index');
Route::get('exits/{station_id}', 'ExitsController@index')->name('exits.index');
Route::get('spots/{exit_id}', 'SpotsController@index')->name('spots.index');
Route::get('search/', 'HomeController@search')->name('search');
Route::get('getExits/', 'HomeController@getExits')->name('getExits');
Route::post('spots/store', 'SpotsController@store')->name('spots.store');

Route::get('home/auto_search','HomeController@autoSearch');
Route::post('spots/get_station_list/','SpotsController@getStationList');
Route::post('spots/get_exit_list/','SpotsController@getExitList');
