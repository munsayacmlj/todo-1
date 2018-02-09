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

Route::post('/task', 'TasksController@saveTask');

Route::get('/', 'TasksController@showTasks');

Route::get('/delete/{id}', 'TasksController@delete');

Route::get('/edit/{id}', 'TasksController@edit');

Route::post('/edit/{id}', 'TasksController@update');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/task/{id}', 'TasksController@showTask');

Route::post('/comment/{id}', 'CommentController@saveComment');

Route::get('/comment/delete/{id}', 'CommentController@deleteComment');

Route::post('/comment/edit/{id}', 'CommentController@editComment');