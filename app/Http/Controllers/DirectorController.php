<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\LeadResource;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ManagerLead;
use App\Models\RejectedLead;

class DirectorController extends BaseController
{
    public function leads()
    {
        $this->seo()->setTitle('Список запросов');
        return view('director.leads');
    }

    public function getLeads()
    {
        return Lead::getLeadsForDirectors();
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
        $leads = Lead::getLeadsOfManager(Auth::user());
        return LeadResource::collection($leads);
    }

    // изменение статуса лида
    public function changeLeadStatus(Request $request)
    {
        $lead_id = $request->input('lead_id');
        $manager_id = Auth::user()->id;
        $user = Auth::user();
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
                    if (!RejectedLead::exists($lead_id)) {
                        $comments = [['comment' => $comment, 'name' => $user->getFullName()]];
                        RejectedLead::create([
                            'lead_id' => $lead_id, 'manager_id' => $manager_id, 'ss' => '1', 'tm' => Carbon::now(),
                            'comment' => json_encode($comments, JSON_UNESCAPED_UNICODE)
                        ]);
                        DB::commit();
                        return response('Запрос успешно отменен!', 200);
                    } else {
                        $rejected_lead = RejectedLead::where(['lead_id' => $lead_id])->first();
                        if ($rejected_lead->ss == '2') {
                            $comm = json_decode($rejected_lead->comment, true);
                            $comm[] = ['comment' => $comment, 'name' => $user->getFullName()];
                            $rejected_lead->comment = json_encode($comm, JSON_UNESCAPED_UNICODE);
                            $rejected_lead->ss = '1';
                            $rejected_lead->save();
                        }
                        DB::commit();
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
}
