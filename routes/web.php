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

Route::get('/facebook/login','FaceBookController@fb_login');
Route::get('/facebook/callback','FaceBookController@fb_callback');
Route::get('/facebook/upload-pictures','FaceBookController@fb_callback');
Route::get('/facebook/upload-videos','FaceBookController@fb_callback');