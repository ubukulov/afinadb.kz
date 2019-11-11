<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\ManagerLead;
use App\Models\RejectedLead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cache;

class CallCenterController extends BaseController
{
    public function leads()
    {
        $this->seo()->setTitle('Список заявок');
        return view('callcenter.leads');
    }

    // список пользователей
    public function accounts()
    {
        $this->seo()->setTitle('Список пользователей');
        return view('callcenter.accounts');
    }

    // Set lead for manager
    public function setLeadForManager(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $manager_id = $request->input('manager_id');
        if (!ManagerLead::exists($lead_id)) {
            DB::beginTransaction();
            try {
                ManagerLead::create([
                    'lead_id' => $lead_id, 'manager_id' => $manager_id, 'tm' => Carbon::now(), 'type' => '1', 'ss' => '0'
                ]);

                $lead = Lead::findOrFail($lead_id);
                $lead->ss = '0';
                $lead->save();

                return response('Запрос успешно закреплен за вами', 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response('Ошибка сервера', 500);
            }
        }

        return response('Запрос уже закреплен за другим менеджером', 409);
    }

    // Ban user
    public function banUser(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        if ($user) {
            if ($user->deleted == '1') {
                $user->deleted = '0';
            } else {
                $user->deleted = '1';
            }
            $user->save();
            return response('Успешно изменен статус', 200);
        }

        return response('Пользователь не найден', 404);
    }

    // Список отказанные запросы
    public function rejectedLeads()
    {
        $this->seo()->setTitle('Список отказанные запросы');
        return view('callcenter.rejected_leads');
    }

    public function listRejectedLeads()
    {
        return Lead::getRejectedLeads();
    }

    public function listCompletedLeads()
    {
        return Lead::getCompletedLeads();
    }

    public function listProcessedLeads()
    {
        return Lead::getProcessingLeads();
    }

    // Восстановить запрос
    public function restoreLead(Request $request)
    {
        $lead_id = $request->input('lead_id');
        Lead::restoreLead($lead_id);
    }

    // Удаление запроса
    public function removeLead(Request $request)
    {
        return Lead::remove($request->input('lead_id'));
    }

    // возвращать лид обратно к менеджеру
    public function returnLead(Request $request)
    {
        return RejectedLead::returnLeadToManager($request->all());
    }

    // создать лид
    public function createLead(Request $request)
    {
        $this->validate($request, [
           'first_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'comment' => 'required'
        ], [
            'required' => 'Поля обязательно к заполнению'
        ]);
        $data = $request->all();
        Lead::create([
            'url' => '/', 'comment' => $data['comment'], 'phone' => $data['phone'], 'email' => $data['email'],
            'name' => $data['first_name'], 'type' => $data['type'], 'ss' => '1', 'city_id' => $data['city_id']
        ]);
        return response('Запрос успешно создан');
    }

    // входящие звонки
    public function incomingCalls()
    {
        $this->seo()->setTitle('Входящие звонки');
        try {
            if (Cache::has('all_calls_per_day')) {
                $all_calls_per_day = Cache::get('all_calls_per_day');
            } else {
                $client = new \denostr\Binotel\Client(env('BINOTEL_KEY'), env('BINOTEL_SECRET'));
                $stats = $client->stats;
                $all_calls_per_day = $stats->listOfCallsPerDay();
                Cache::put('all_calls_per_day', $all_calls_per_day, 300);
            }
            return view('callcenter.calls', compact('all_calls_per_day'));
        } catch (\denostr\Binotel\Exception $e) {
            printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        }
    }
}
