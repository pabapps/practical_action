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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/base_home',function(){
	return view('layout.main');
});

/**
 * routes for user controller
 */
//get the list of all the valid users
Route::get('/users/get_all_users','UsersController@get_all_users');

//fetch all the users as a line manager
Route::get('/users/get_line_managers','UsersController@get_line_managers');

//user - projects connection view
Route::get('/user/{id}/user_projects','UsersController@user_projects');

//select all the valid projects
Route::get('/user/get_valid_projects','UsersController@get_valid_projects');

//select the project cofe
Route::get('/user/get_project_description','UsersController@get_project_description');

//route for posting user-projects connection
Route::post('/user/submit_porjects','UsersController@submit_projects');

Route::resource('/users','UsersController');


/**
 * routes for designation
 */
//get the list of all designations
Route::get('/get_all_designations','DesignationController@get_all_designations');

//route for select2 to fetch all teh designations
Route::get('/select2/select2_all_designations','DesignationController@select2_all_designations');

Route::resource('/designation','DesignationController');


/**
 * routes for project controller
 */

//get the list of all projects
Route::get('/get_all_projects','ProjectController@get_all_projects');

Route::resource("/projects",'ProjectController');



/**
 * routes for all the roles 
 */
//get all the roles
Route::get('/roles/get_all_roles','RoleController@get_all_roles');

Route::resource('/roles','RoleController');



/**
 * routes for permissions
 */
//route for all the permissions
Route::get('/permissions/get_all_permissions','PermissionController@get_all_permissions');

Route::resource('/permissions','PermissionController');



/**
 * routes for all teh departments
 */
//route for all the departments
Route::get('/departments/get_all_departments','DepartmentController@get_all_departments');

//get the valid departments for a ajax request
Route::get('/ajax/ajax_get_departments','DepartmentController@ajax_get_departments');

Route::resource('/departments','DepartmentController');












