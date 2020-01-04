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

Route::get('/register', 'UsersController@register');

Route::get('/user/activation/{token}', 'UsersController@userActivation');

Route::get('/postItem', 'ItemsController@PostItem');
Route::get('/items', 'ItemsController@index');

Route::get('/items/{id}', 'ItemsController@Filtered');

Route::get('login' , 'UsersController@login');

