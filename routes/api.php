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
    # Пользователи
    Route::get('/users', 'ApiController@getUsers'); // список пользователей
    Route::get('/user/{id}', 'ApiController@getUser'); // получить информацию о менеджере
    Route::post('/user/create', 'ApiController@createUser'); // создать нового пользователя
    Route::post('/user/update', 'ApiController@updateUser'); // обновление информацию о пользователя
    Route::post('/user/destroy', 'ApiController@destroyUser'); // удаление пользователя
    Route::post('/user/delete', 'ApiController@deleteManager'); // удаление менеджера

    Route::get('/leads', 'ApiController@leads'); // все лиды
    Route::post('/leads/city', 'ApiController@getLeadsOfCity'); // получить список лидов по выбранному городу
    Route::get('/managers', 'ApiController@managers'); // список менеджеров
    Route::get('/archive/leads', 'ApiController@getArchiveLeads');

    # Заблокированные пользователи
    Route::get('/blocked-users', 'ApiController@getBlockedUsers');
});