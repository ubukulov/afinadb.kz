<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\ManagerLead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
