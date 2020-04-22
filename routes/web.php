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

Route::group(['middleware'=>'auth:web'], function()
{
    Route::get('profile/view', 'ProfileController@getProfileView');

    Route::post('profile/view', 'ProfileController@postProfile');
    
    Route::get('tasks', 'TaskController@getList');

    Route::get('tasks/create', 'TaskController@getCreateTask');

    Route::post('tasks/create', 'TaskController@postCreateTask');

    Route::get('tasks/excel', 'TaskController@getListExcel');

    Route::get('tasks/{id}/pdf', 'TaskController@getViewTaskPdf');

    Route::get('/tasks/{id}', 'TaskController@getViewTask');

    Route::delete('/tasks/{id}', 'TaskController@postDelete');
});