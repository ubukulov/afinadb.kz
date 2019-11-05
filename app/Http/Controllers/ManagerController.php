<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeadResource;
use App\Models\ManagerLead;
use App\Models\RejectedLead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class ManagerController extends BaseController
{
    // список лидов
    public function leads()
    {
        $this->seo()->setTitle('Список новых заявок');
        return view('manager.leads');
    }

    // список новых лидов
    public function getFreeLeads()
    {
        $leads = Lead::getLeads('MANAGER');
        return LeadResource::collection($leads);
    }

    // список лиды менеджера
    public function myLeads()
    {
        $this->seo()->setTitle('Мои запросы');
        return view('manager.my_leads');
    }

    // получить список моих лидов
    public function getMyLeads()
    {
        $leads = Lead::getLeadsOfManager(\Auth::user());
        return LeadResource::collection($leads);
    }

    // изменение статуса лида
    public function changeLeadStatus(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $manager_id = \Auth::user()->id;
        $user = \Auth::user();
        $comment = $request->input('comment');
        $manager_lead = ManagerLead::where(['lead_id' => $lead_id, 'manager_id' => $manager_id])->first();
        if ($manager_lead) {
            if ($request->input('process') == 'complete') {
                $manager_lead->type = '0';
                $manager_lead->save();
                return response('Запрос успешно обработано!', 200);
            }

            if ($request->input('process') == 'cancel') {
                DB::beginTransaction();
                try {
                    $manager_lead->type = '2';
                    $manager_lead->save();
                    $comments = [
                        [
                            'comment' => $comment, 'name' => $user->name. " ".$user->last_name
                        ]
                    ];
                    if (!RejectedLead::exists($lead_id)) {
                        RejectedLead::create([
                            'lead_id' => $lead_id, 'manager_id' => $manager_id, 'ss' => '1', 'tm' => Carbon::now(),
                            'comment' => json_encode($comments, JSON_UNESCAPED_UNICODE)
                        ]);

                        return response('Запрос успешно отменен!', 200);
                    } else {
                        $rejected_lead = RejectedLead::where(['lead_id' => $lead_id])->first();
                        if ($rejected_lead->ss == '2') {
                            $comm = json_decode($rejected_lead->comment, true);
                            $comm[] = ['comment' => $comments, 'name' => $user->name. " ".$user->last_name];
                            $rejected_lead->comment = json_encode($comm, JSON_UNESCAPED_UNICODE);
                            $rejected_lead->ss = '1';
                            $rejected_lead->save();
                        }

                        return response('Запрос успешно отменен!', 200);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response('Ошибка сервера', 500);
                }
            }
        }

        return response('Запрос уже закреплен под другим менеджером.', 409);
    }

    // Закрепить лид за мной
    public function setLeadForMe($lead_id)
    {
        if (!ManagerLead::exists($lead_id)) {
            ManagerLead::create([
                'lead_id' => $lead_id, 'manager_id' => \Auth::user()->id, 'tm' => Carbon::now(),
                'type' => '1', 'ss' => '0'
            ]);
            return response('Запрос успешно закреплен!', 200);
        }

        return response('Запрос уже закреплен под другим менеджером', 409);
    }

    // Список отложенных запросов
    public function pendingLeads()
    {
        $this->seo()->setTitle('Список отложенных запросов');
        return view('manager.pending_leads');
    }
}