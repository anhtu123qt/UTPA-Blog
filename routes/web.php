<?php

use Illuminate\Support\Facades\Route;

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
Route::get('index','Frontend\BlogController@index');
Route::group(['prefix' => 'admin','middleware' =>'auth'],function(){
    Route::get('/dashboard','Admin\UserController@dashboard')->name('admin.dashboard');
    Route::resource('category',Admin\CategoryController::class);
    Route::resource('post',Admin\PostController::class);
    Route::post('checkStatusPost','Admin\PostController@check_status_post');
});

require __DIR__.'/auth.php';
