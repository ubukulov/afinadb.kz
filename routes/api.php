<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => ['auth:api']], function(){
    Route::get('/users', 'ApiController@getUsers'); // список пользователей
    Route::get('/user/{id}', 'ApiController@getUser'); // получить информацию о менеджере
    Route::post('/user/create', 'ApiController@createUser'); // создать нового пользователя
    Route::post('/user/update', 'ApiController@updateUser'); // обновление информацию о пользователя
    Route::get('/leads', 'ApiController@leads'); // все лиды
    Route::get('/managers', 'ApiController@managers'); // список менеджеров
});