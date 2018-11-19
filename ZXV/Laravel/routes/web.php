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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/',        		 	 	['uses' => 'CouponController@show']);
Route::get('show/{type}',        	['uses' => 'CouponController@show']);
Route::get('sheet/view',         	['uses' => 'CouponController@sheetview']);
Route::get('sheet/backup',       	['uses' => 'CouponController@backup']);
Route::get('showbackup/{type}',  	['uses' => 'CouponController@showbackup']);
