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

//select the project code
Route::get('/user/get_project_description','UsersController@get_project_description');

//route for posting user-projects connection
Route::post('/user/submit_porjects','UsersController@submit_projects');

//route for selecting the existing projects for the users
Route::get('/user/user_connected_project','UsersController@user_connected_project'); 

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

//route for user role
Route::get('/roles/user_roles','RoleController@user_roles');

//get all roles for the users
Route::get('/role/get_all_users_role','RoleController@get_all_users_role');

//submit user role
Route::post('/roles/submit_user_role','RoleController@submit_user_role');

Route::get('/role/ajax/get_all_roles','RoleController@ajax_get_all_roles');

//role edit route
Route::get('/roles/{id}/role_edit','RoleController@role_edit');

//show roles for an specific user
Route::get('/roles/roles_for_specific_user','RoleController@roles_for_specific_user');

Route::resource('/roles','RoleController');



/**
 * routes for permissions
 */
//route for all the permissions
Route::get('/permissions/get_all_permissions','PermissionController@get_all_permissions');

//role permission list
Route::get('/permissions/roles_list','PermissionController@roles_list');

//ajax request for user-role-permissions details
Route::get('/permissions/user_role_permissions_details','PermissionController@user_role_permissions_details');

//ajax request of permission for an user
Route::get('/permissions/get_permissions_for_roles','PermissionController@get_permissions_for_roles');

//ajax request for permission details
Route::get('/permissions/permission_details','PermissionController@permission_details');

//submit the role permission 
Route::post('/permissions/submit_role_permission','PermissionController@submit_role_permission');

//ajax get existing permissions for a role
Route::get('/permissions/get_old_permissions_roles','PermissionController@get_old_permissions_roles');

Route::resource('/permissions','PermissionController');



/**
 * routes for all teh departments
 */
//route for all the departments
Route::get('/departments/get_all_departments','DepartmentController@get_all_departments');

//get the valid departments for a ajax request
Route::get('/ajax/ajax_get_departments','DepartmentController@ajax_get_departments');

Route::resource('/departments','DepartmentController');


/**
 * route for time sheet
 */
Route::get('/timesheet/project_details_for_timesheet/{id}/{start_date}/{end_date}','TimeSheetController@project_details_for_timesheet');

//route for sending time log for the porjects to their respective line manager
Route::post('/timesheet/send_to_linemanager','TimeSheetController@send_to_linemanager');

//route for displaying the line manager page

Route::get('/timesheet/display_line_manager','TimeSheetController@display_line_manager');

//when the line manager sends the time log to the accounts manager
Route::post('/timesheet/submit_to_accounts_manager','TimeSheetController@submit_to_accounts_manager');

Route::get('/timesheet/lineManager_to_accountManager','TimeSheetController@lineManager_to_accountManager');

//getting the details of the timesheet that has been sent to accounts from line manager
Route::get('/timesheet/lineManager_to_accountManager/old_records/{id}/{start_date}/{end_date}',
	'TimeSheetController@old_records_for_line_managers');

Route::post('/timesheet/linemanager_refer_back_subordinate','TimeSheetController@line_manager_refering_subordinates');

//route for gethering the users who have submitted their time sheet to their line managers
Route::get('/timesheet/get_submitted_users','TimeSheetController@get_submitted_users');

Route::get('/timesheet/time_log_for_submitted_users/{id}/{start_date}/{end_date}','TimeSheetController@time_log_for_submitted_users');

//previous/submitted time logs for the users
Route::get('/timesheet/old_time_logs_users','TimeSheetController@old_time_logs_users');

//details of the previous time log for the user
Route::get('/timesheet/previous_details_time_log_users/{start_date}/{end_date}',
	'TimeSheetController@previous_details_time_log_users');

//route for accounts manager, the data that line manager sends to the accounts manager 
Route::get('/timesheet/time_log_accounts_display','TimeSheetController@time_log_accounts_display');

Route::get('/timesheet/details_for_accounts_manager/{id}/{start_date}/{end_date}',
	'TimeSheetController@details_for_accounts_manager');

//if accoutns manager wants to edit the time sheet
Route::get('/timesheet/{id}/edit_by_accounts','TimeSheetController@edit_by_accounts');

//accounts manager sending the tiemsheet back the line manager for correction
Route::post('/timesheet/accounts_manager_refer_back_to_line_manager','TimeSheetController@accounts_manager_refer_back_to_line_manager');

//route for sending the timesheet for reporting
Route::post('/timesheet/sending_timesheet_for_reporting','TimeSheetController@sending_timesheet_for_reporting');

//route for the ajax request 
Route::get('/timesheet/get_recently_created_timesheet','TimeSheetController@get_recently_created_timesheet');


//testing pdf
Route::get('/timesheet/pdf','TimeSheetController@test_pdf');


Route::resource('/timesheet','TimeSheetController');


/**
 * rerports for specific projects
 */
Route::post('/timesheet_Reports/specific_project','TimeSheetReportController@get_report_for_specific_project');

Route::get('/timesheet_Reports/get_user_projects','TimeSheetReportController@get_user_projects');

Route::resource('/timesheet_Reports','TimeSheetReportController');


Route::resource('/base_home','TimeChartController');

/**
 * routes for normal user profile
 */
Route::resource('/user_profile','UserProfileController');




/**
 * routes for pabcontacts
 */

// route for categories
Route::get('/contact_categories/get_all_categories','CategoriesController@get_all_categories');

Route::resource('/contact_categories','CategoriesController');

//route for theme
Route::get('/contact_theme/get_all_contact_theme','ContactThemeController@get_all_contact_theme');

Route::resource('/contact_theme','ContactThemeController');


/**
 * routes for contacts
 */


//getting all the categories
Route::get('/pab_contacts/get_all_catogies','ContactsController@get_all_categories');

Route::resource('/pab_contacts','ContactsController');









