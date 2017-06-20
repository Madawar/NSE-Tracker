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
use Carbon\Carbon;


Route::resource('stock', 'StockController');
Route::resource('share', 'SharesController');
Route::get('/', function () {


    return redirect()->action('SharesController@index');
});
