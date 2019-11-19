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

    # Обучение
    Route::get('/education', 'EducationController@education')->name('education');
    Route::get('/internship-training', 'EducationController@internshipTraining')->name('internship-training');
    Route::get('/manager-training', 'EducationController@managerTraining')->name('manager-training');
    Route::get('/leadership-training', 'EducationController@leadershipTraining')->name('leadership-training');
    Route::get('/private', 'EducationController@privat')->name('private');
    Route::get('/all-webinars', 'EducationController@webinars')->name('all-webinars');

    # Звонки
    Route::get('/incoming/calls', 'BinotelController@incomingCalls')->name('incoming.calls'); // входящие звонки
    Route::get('/outgoing/calls', 'BinotelController@outgoingCalls')->name('outgoing.calls'); // исходящие звонки
    Route::get('/missing/calls', 'BinotelController@missingCalls')->name('missing.calls'); // пропущенные звонки

    # Статистика
    Route::get('/stats/leads', 'StatController@getStatsOfLeads')->name('stats.leads'); // статистика запросов
    Route::get('/stats/managers', 'StatController@getStatsOfManagers')->name('stats.managers'); // статистика менеджеров
});

Route::group(['prefix' => 'manager'], function(){
    Route::get('leads', 'ManagerController@leads')->name('manager.leads'); // список лидов
    Route::get('my_leads', 'ManagerController@myLeads')->name('myLeads'); // список лидов менеджера
    Route::post('/lead/{lead_id}', 'ManagerController@setLeadForMe'); // закрепить лид за менеджером
    Route::get('leads/free', 'ManagerController@getFreeLeads'); // получить список новых лидов
    Route::get('/my/leads', 'ManagerController@getMyLeads'); // получить список моих лидов
    Route::post('/change/lead/status', 'ManagerController@changeLeadStatus'); // изменить статус лида
    Route::get('/pending/leads', 'ManagerController@pendingLeads')->name('pending.leads'); // список отложенных запросов
});

Route::group(['prefix' => 'call_center'], function(){
    Route::get('/leads', 'CallCenterController@leads')->name('call_center.leads');
    Route::post('/manager/set/lead', 'CallCenterController@setLeadForManager');
    Route::post('/user/ban', 'CallCenterController@banUser');
    Route::get('/accounts', 'CallCenterController@accounts')->name('accounts');
    Route::get('/rejected_leads', 'CallCenterController@rejectedLeads')->name('rejected.leads');
    Route::get('/list/rejected-leads', 'CallCenterController@listRejectedLeads');
    Route::get('/list/completed-leads', 'CallCenterController@listCompletedLeads');
    Route::get('/list/processed-leads', 'CallCenterController@listProcessedLeads');
    Route::post('/lead/restore', 'CallCenterController@restoreLead'); //
    Route::post('/lead/remove', 'CallCenterController@removeLead'); // удалить лид
    Route::post('/lead/return', 'CallCenterController@returnLead'); // возвращать лид обратно к менеджеру
    Route::post('/create/lead', 'CallCenterController@createLead'); // создать лид
    Route::post('/lead/comments', 'CallCenterController@leadComments');
    Route::post('/lead/file', 'CallCenterController@loadLeadFromFile');
});

Route::group(['prefix' => 'director'], function(){
    Route::get('/leads', 'DirectorController@leads')->name('director.leads');
    Route::get('/leads/list', 'DirectorController@getLeads');
});

Route::post('/triphacker', 'IndexController@triphacker'); // принимает данные из поисковика TripHacker
Route::post('/ajax', 'IndexController@leadsFromOtherSources');