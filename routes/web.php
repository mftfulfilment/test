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
Route::get('/profile_update', 'User_Management@profile_info');
Route::get('/profile_update', 'User_Management@profile_update');

#This all are admin route
// Authentication Routes...

Route::get('admin/home', 'AdminController@index');
Route::get('/admin', 'admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin', 'admin\LoginController@login');


// Registration Routes...
Route::get('admin-register', 'Admin\RegisterController@showRegistrationForm')->name('admin.register');
Route::post('admin-register', 'Admin\RegisterController@register');

// Password Reset Routes...
Route::get('admin-password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin-password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('adnub.password.reset');
Route::post('admin-password/reset', 'Admin\ResetPasswordController@reset');


//admin user control

#user and profile setting
Route::get('admin/leave_req', 'AdminController@leave_req');
Route::get('admin/make_user', 'AdminController@make_user')->name('make_user');
Route::get('admin/all_users', 'AdminController@all_users')->name('all_users');
Route::get('admin/profile/{id}', 'AdminController@view_profile')->name('profile');

Route::post('admin/password_update/{user_id}', 'AdminController@password_update')->name('update_req');

Route::get('admin/update_user_pass/{id}','AdminController@update_user_pass')->name('update_password');

#End user and profiles Route

#leave request and setting
Route::get('admin/view_setting','LeaveController@view_setting')->name('view_setting');
Route::post('/add_leave','LeaveController@add_leave')->name('insert_leave');
Route::get('/add_leave','LeaveController@leave_add_form')->name('add_leave');

Route::get('/leave_req','LeaveController@get_leave_req_list')->name('view_leave_req');
Route::get('/leave_history_list','LeaveController@leave_history')->name('leave_history_list');
Route::get('/leave_approve','LeaveController@leave_approve')->name('leave_approve');
Route::get('/leave_cancel','LeaveController@leave_cancel')->name('leave_cancel');


#user route system start here
Route::get('/leave_apply','User_Management@leave_apply')->name('leave_apply');
Route::post('/leave_apply','User_Management@apply_to_leave')->name('apply_to_leave');
Route::get('/leave_history','User_Management@leave_history')->name('leave_history');
Route::get('/leave_process','User_Management@leave_process')->name('leave_process');
Route::get('/password_update','User_Management@show_password_update_form')->name('password_update');
Route::post('/password_update','User_Management@password_update')->name('password_update_req');

