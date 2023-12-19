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

// Get methods
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', 'LoginController@login');
Route::get('/sign_up', 'LoginController@login');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/sign_out', 'DashboardController@signOut');

// Post methods
Route::post('/login', 'LoginController@login_attempt');
Route::post('/sign_up', 'LoginController@signUp');
Route::post('/edit', 'DashboardController@editUser');
Route::post('/edit_user', 'DashboardController@editUserScript');
Route::post('/delete', 'DashboardController@deleteUser');
Route::post('/delete_user', 'DashboardController@deleteUserScript');
Route::post('/preview', 'DashboardController@previewUser');
Route::post('/update_profile', 'DashboardController@uploadPicture');
Route::post('/submit_profile_picture', 'DashboardController@uploadPictureScript');
