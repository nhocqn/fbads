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
Route::get('/login', function () {
    return redirect()->to(url('/facebook/login'));
});

Route::get('/facebook/login', 'FaceBookController@fb_login')->name("login");
Route::get('/facebook/callback', 'FaceBookController@fb_callback');
Route::get('/facebook/upload-pictures', 'FaceBookController@fb_callback');
Route::get('/facebook/upload-videos', 'FaceBookController@fb_callback');

Route::get('/facebook/push/posts/{id}', 'FaceBookController@fb_push_post');
Route::post('/facebook/push/posts', 'FaceBookController@push_upload');


Route::post('/facebook/load-post/image', 'FaceBookController@getImagePost');
Route::post('/facebook/load-post/feed', 'FaceBookController@getFeedPost');
Route::post('/facebook/load-post/video', 'FaceBookController@getVideoPost');

Route::resource('campaigns', 'CampaignController');
Route::resource('posts', 'PostsController');
Route::resource('adsets', 'AdsetController');
Route::resource('ad_videos', 'AdVideoController');
Route::resource('ad_images', 'AdImageController');
Route::resource('facebook_posts', 'FacebookPostController');

Route::post('post/add-image', ['as' => 'imageUpload', 'uses' => 'PostImageController@store']);
Route::post('post/delete-image/{id}', ['as' => 'imageUpload', 'uses' => 'PostImageController@destroy']);

Route::post('post/add-video', ['as' => 'videoUpload', 'uses' => 'PostVideoController@store']);
Route::post('post/delete-video/{id}', ['as' => 'videoUpload', 'uses' => 'PostVideoController@destroy']);

Route::get('/facebook_posts/create', function () {
    return redirect()->to(url('/not-found'));
});
