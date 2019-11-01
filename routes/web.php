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
    Route::get('/accounts', 'IndexController@accounts')->name('accounts');
    # Обучение
    Route::get('/education', 'EducationController@education')->name('education');
    Route::get('/internship-training', 'EducationController@internshipTraining')->name('internship-training');
    Route::get('/manager-training', 'EducationController@managerTraining')->name('manager-training');
    Route::get('/leadership-training', 'EducationController@leadershipTraining')->name('leadership-training');
    Route::get('/private', 'EducationController@privat')->name('private');
});

Route::group(['prefix' => 'manager'], function(){
    Route::get('leads', 'ManagerController@leads')->name('manager.leads'); // список лидов
    Route::get('my_leads', 'ManagerController@myLeads')->name('myLeads'); // список лидов менеджера
    Route::post('/lead/{lead_id}', 'ManagerController@setLeadForMe'); // закрепить лид за менеджером
    Route::get('leads/free', 'ManagerController@getFreeLeads'); // получить список новых лидов
    Route::get('/my/leads', 'ManagerController@getMyLeads'); // получить список моих лидов
    Route::post('/change/lead/status', 'ManagerController@changeLeadStatus'); // изменить статус лида
});

Route::group(['prefix' => 'call_center'], function(){
    Route::get('/leads', 'CallCenterController@leads')->name('call_center.leads');
    Route::post('/manager/set/lead', 'CallCenterController@setLeadForManager');
    Route::post('/user/ban', 'CallCenterController@banUser');
});