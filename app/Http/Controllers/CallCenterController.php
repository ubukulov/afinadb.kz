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
use Excel;
use App\Models\BlockedUser;

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
                DB::commit();
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
            'comment' => 'required'
        ], [
            'required' => 'Поля обязательно к заполнению'
        ]);
        $data = $request->all();
        $type = $data['type'];
        $company = $data['company'];
        $tm = (empty($data['selected_date'])) ? Carbon::now() : date("Y-m-d H:i:s", strtotime($data['selected_date']));
        Lead::create([
            'url' => '/', 'comment' => $data['comment'], 'phone' => $data['phone'], 'email' => $data['email'],
            'name' => $data['first_name'], 'type' => "$type", 'ss' => '1', 'city_id' => $data['city_id'], 'company' => "$company",
            'type_app' => $data['type_app'], 'tm' => $tm
        ]);
        return response('Запрос успешно создан');
    }

    // Комментарии к запросу
    public function leadComments(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $manager_lead = RejectedLead::where(['lead_id' => $lead_id])->first();
        if ($manager_lead) {
            return json_decode($manager_lead->comment, true);
        }
        return response('К этому запросу нет комментарии', 409);
    }

    public function loadLeadFromFile(Request $request)
    {
        $file = $request->file('file');
        $city_id = $request->input('city_id');
        $company_id = $request->input('company_id');
        Excel::selectSheetsByIndex(0)->load($file->getPathname(), function($reader) use ($city_id, $company_id){
            $worksheet = $reader->getActiveSheet();
            $numberLastRow = $worksheet->getHighestDataRow();
            for($i=2; $i <= $numberLastRow; $i++) {
                $type = $this->parseType($worksheet->getCell('L'.$i)->getValue());
                Lead::create([
                    'url' => '/', 'tm' => Carbon::now(), 'comment' => "Комментарий: ".$worksheet->getCell('H'.$i)->getValue(), 'phone' => $worksheet->getCell('N'.$i)->getValue(),
                    'name' => $worksheet->getCell('M'.$i)->getValue(), 'type' => "$type",
                    'ss' => '1', 'company' => $company_id, 'city_id' => $city_id
                ]);
            }
            return response('Лиды успешно импортированы');
        });
    }

    public function parseType($a) {
        if ($a==='ig') {
            return 1; // инстаграмм
        } else if ($a==='fb') {
            return 2; // facebook
        } elseif ($a==='wa') {
            return 3; // whatsapp
        } else return 0;
    }

    public function getArchiveLeads()
    {
        $this->seo()->setTitle('Архивные запросы');
        return view('callcenter.archive_leads');
    }

    public function setLeadNew(Request $request)
    {
        $lead_id = $request->input('lead_id');
        DB::beginTransaction();
        try {
            DB::update("UPDATE leads SET ss='1' WHERE id='$lead_id'");
            DB::delete("DELETE FROM manager_leads WHERE lead_id='$lead_id'");
            DB::delete("DELETE FROM rejected_leads WHERE lead_id='$lead_id'");
            DB::commit();
            return response("Запрос успешно стало новым.", 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response("Ошибка сервера: $exception", 500);
        }
    }
    # Список заблокированных пользователей
    public function blockedUsers()
    {
        $this->seo()->setTitle('Список заблокированных пользователей');
        return view('callcenter.blocked_users');
    }

    # Заблокировать пользователя по номер телефону
    public function lockUser(Request $request)
    {
        $phone = $request->input('phone');
        if (BlockedUser::exists($phone)) {
            return response('Такой пользователь уже добавлен');
        } else {
            BlockedUser::create([
                'phone' => $phone, 'blocked' => 1
            ]);
            return response('Пользователь добавлен.');
        }
    }
}
