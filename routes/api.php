<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user'], function () {
    Route::post('login', 'UserController@login');
});

Route::group(['middleware' => 'jwt.auth'], function () {

    /*** TODO and Todo-Tag Routes ***/
    Route::group(['prefix' => 'todo'], function () {
        Route::get('/', 'TodoController@getMyTodo')->name('todo.todos');
        Route::post('store', 'TodoController@storeTodo')->name('todo.store');
        Route::put('update/{todo}', 'TodoController@updateTodo')->name('todo.update');
        Route::get('{todo}/show', 'TodoController@showTodo')->name('todo.show');
        Route::delete('{todo}', 'TodoController@deleteTodo')->name('todo.delete');

        Route::get('get_completed', 'TodoController@getAllCompletedTodo')->name('todo.completed');
        Route::get('get_pending', 'TodoController@getAllPendingTodo')->name('todo.pending');
        Route::get('{todo}/set_status', 'TodoController@markTodoAsCompleteOrPending')->name('todo.status.set');


        Route::group(['prefix' => 'tags'], function () {
            Route::post('{todo}', 'TodoTagController@addTagsToTodo')->name('todo.add.tag');
            Route::get('{todo}', 'TodoTagController@getTagsOfTodo')->name('todo.tags');
        });
    });


    /*** Tags Routes ***/
    Route::group(['prefix' => 'tags'], function () {
        Route::get('', 'TodoTagController@getAllTags')->name('tags.index');
        Route::post('store', 'TodoTagController@storeTag')->name('tags.store');
        Route::get('{tag}/show', 'TodoTagController@showTag')->name('tags.show');
    });
});
