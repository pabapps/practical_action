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
    // return view('welcome');
    return view('layout.main');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * routes for user controller
 */
//get the list of all the valid users
Route::get('/users/get_all_users','UsersController@get_all_users');

Route::resource('/users','UsersController');