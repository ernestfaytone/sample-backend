<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'UserController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user-list', 'UserController@userList');
    Route::post('delete/', 'UserController@deleteUser');
    Route::post('update/', 'UserController@updateUser');
}); 

Route::get('user/{id}','UserController@findUser');