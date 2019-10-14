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
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/authenticate', 'AuthController@authenticate')->name('authenticate');

Route::group(['middleware' => ['web', 'auth']], function(){
    Route::get('/', 'IndexController@welcome')->name('home');
    Route::get('/contacts', 'IndexController@contacts')->name('contacts');
    Route::get('/bonus', 'IndexController@bonus')->name('bonus');
    Route::get('/suggestions', 'IndexController@suggestions')->name('suggestions');
    Route::get('/marketing', 'IndexController@marketing')->name('marketing');
    Route::get('/chemodan', 'IndexController@chemodan')->name('chemodan');
    Route::get('/abk', 'IndexController@abk')->name('abk');
    Route::get('/logout', 'IndexController@logout')->name('logout');
    Route::get('/leads', 'IndexController@leads')->name('leads');
});