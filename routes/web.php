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
Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
    session()->flash('alert-success', 'Success logged out');
    return Redirect::to('/');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('projects/create/{company_id?}','ProjectsController@create');
Route::post('projects/adduser','ProjectsController@adduser')->name('projects.adduser');
Route::group(['middleware'=>'auth'],function (){
    Route::resource('companies','CompaniesController');
    Route::resource('projects','ProjectsController');
    Route::resource('roles','RolesController');
    Route::resource('tasks','TasksController');
    Route::resource('users','UsersController');
    Route::resource('comments','CommentsController');
});
Route::group(['middleware'=>'user'],function () {
});
