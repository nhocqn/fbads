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

Route::get('/home', function () {
    return redirect()->to(url('posts'));
});

Route::get('/facebook/login', 'FaceBookController@fb_login');
Route::get('/facebook/callback', 'FaceBookController@fb_callback');
Route::get('/facebook/upload-pictures', 'FaceBookController@fb_callback');
Route::get('/facebook/upload-videos', 'FaceBookController@fb_callback');

Route::get('/facebook/push/posts/{id}', 'FaceBookController@fb_push_post');
Route::post('/facebook/push/image-posts', 'FaceBookController@image_upload');
Route::post('/facebook/push/video-posts', 'FaceBookController@video_upload');
Route::post('/facebook/push/status-posts', 'FaceBookController@status_upload');

Route::resource('posts', 'PostsController');

Route::post('post/add-image', ['as' => 'imageUpload', 'uses' => 'PostImageController@store']);
Route::post('post/delete-image/{id}', ['as' => 'imageUpload', 'uses' => 'PostImageController@destroy']);

Route::post('post/add-video', ['as' => 'videoUpload', 'uses' => 'PostVideoController@store']);
Route::post('post/delete-video/{id}', ['as' => 'videoUpload', 'uses' => 'PostVideoController@destroy']);