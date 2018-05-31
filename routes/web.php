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
    if (auth()->check()) {
        return redirect()->to('home');
    }

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('posts', 'PostController');

Route::view('{user}/achievements', 'users.achievements', compact('user'))->name('users.achievements');
Route::get('{user}/followers', 'UserController@followers')->name('users.followers');

Route::get('{user}/edit', 'UserController@edit')->name('users.edit');
Route::match(['PUT','PATCH'], '{user}', 'UserController@update')->name('users.update');
Route::get('{user}', 'UserController@show')->name('users.show');

Route::post('api/follow', 'Api\Follow');
