<?php

namespace App\Models;

use App\Http\Resources\LeadResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Lead extends Model
{
    protected $fillable = [
        'id', 'url', 'tm', 'comment', 'phone', 'email', 'name', 'type', 'ss', 'manager', 'status', 'company', 'city_id'
    ];

    public $timestamps = false;

    public static function getLeads($role = null)
    {
        if ($role == 'MANAGER') {
            if (Auth::user()->city_id == 1) {
                if (Auth::user()->company_id == 1 || Auth::user()->company_id == 2) {
                    $result = Lead::orderBy('leads.id', 'ASC')
                        ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                        ->where(['city_id' => Auth::user()->city_id, 'ss' => '1'])
                        ->where('company', '<>', '2')
                        ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 15 DAY)')
                        ->paginate(10);
                } else {
                    // Для менеджеров франшизы закрыть источники: File Client и Звонок в офис
                    $result = Lead::orderBy('leads.id', 'ASC')
                        ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                        ->where(['city_id' => Auth::user()->city_id, 'ss' => '1'])
                        ->where('leads.type', '!=', '10') // не брать лиды из источника File Client
                        ->where('leads.type', '!=', '8') // не брать лиды из источника Звонок в офис
                        ->where('company', '<>', '2')
                        ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 15 DAY)')
                        ->paginate(10);
                }
            } else {
                $result = Lead::orderBy('leads.id', 'ASC')
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                    ->where(['city_id' => Auth::user()->city_id, 'ss' => '1'])
                    ->where('leads.type', '!=', '10') // не брать лиды из источника File Client
                    ->where('company', '<>', '2')
                    ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 15 DAY)')
                    ->paginate(10);
            }
        } else {
            $result = Lead::orderBy('leads.id', 'DESC')
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, manager_leads.type AS m_type, accounts.name as user_name, accounts.last_name, companies.title as com_title'))
                ->leftJoin('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
                ->leftJoin('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                ->leftJoin('companies', 'companies.id', '=', 'accounts.company_id')
                ->where('leads.company', '<>', '2')
                ->paginate(30);
        }

        return $result;
    }

    public static function getLeadsForVisas()
    {
        $result = Lead::orderBy('leads.id', 'ASC')
            ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
            ->where(['city_id' => Auth::user()->city_id, 'ss' => '1', 'company' => '2'])
            ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 15 DAY)')
            ->paginate(10);

        return $result;
    }

    public static function getLeadsOfCity($city_id)
    {
        $leads = Lead::where(['leads.city_id' => $city_id])
            ->orderBy('leads.id', 'DESC')
            ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, manager_leads.type AS m_type, accounts.name as user_name, accounts.last_name, companies.title as com_title'))
            ->leftJoin('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
            ->leftJoin('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
            ->leftJoin('companies', 'companies.id', '=', 'accounts.company_id')
            ->paginate(30);
        return LeadResource::collection($leads);
    }

    public function isCompleted()
    {
        $manager_lead = ManagerLead::where(['lead_id' => $this->id])->first();
        if ($manager_lead && $manager_lead->type == '0') {
            return $manager_lead;
        }

        return false;
    }

    public function isCanceled()
    {
        $manager_lead = ManagerLead::where(['lead_id' => $this->id])->first();
        if ($manager_lead && $manager_lead->type == '2') {
            return true;
        }

        return false;
    }

    public function isProcessed()
    {
        $manager_lead = ManagerLead::where(['lead_id' => $this->id])->first();
        if ($manager_lead && $manager_lead->type == '1') {
            return true;
        }

        return false;
    }

    public function isNew()
    {
        return ($this->ss == '1') ? true : false;
    }

    public static function getLeadsOfManager($manager)
    {
        if ($manager->company_id == 21) {
            $result = Lead::orderBy('leads.id', 'DESC')
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, manager_leads.type AS m_type'))
                ->where(['manager_leads.manager_id' => $manager->id, 'leads.city_id' => $manager->city_id, 'leads.company' => '2'])
                ->join('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
                ->get();
        } else {
            $result = Lead::orderBy('leads.id', 'DESC')
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, manager_leads.type AS m_type'))
                ->where(['manager_leads.manager_id' => $manager->id, 'leads.city_id' => $manager->city_id])
                ->where('leads.company', '<>', '2')
                ->join('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
                ->get();
        }

        return $result;
    }

    // Получить новые лиды
    public static function getLeadsOfFree($user_id)
    {
        $user = User::findOrFail($user_id);
        $leads = Lead::orderBy('tm', 'DESC')->where(['city_id' => $user->city_id, 'ss' => '1'])->take(200)->limit(200)->paginate(20);
        return $leads;
    }

    // Получить список отказанных запросов
    public static function getRejectedLeads()
    {
        $user = Auth::user();
        if($user->company_id == 21){
            $leads = Lead::where(['rejected_leads.ss' => '1'])
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                ->join('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                ->join('accounts', 'accounts.id', '=', 'rejected_leads.manager_id')
                ->where('leads.company', '=', '2')
                ->orderBy('rejected_leads.id', 'DESC')
                ->limit(20)
                ->get();
        } else {
            if ($user->status == 'CALL_CENTER') {
                $leads = Lead::where(['rejected_leads.ss' => '1'])
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                    ->join('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                    ->join('accounts', 'accounts.id', '=', 'rejected_leads.manager_id')
                    ->where('leads.company', '<>', '2')
                    ->orderBy('rejected_leads.id', 'DESC')
                    ->limit(20)
                    ->get();
            } else {
                $leads = Lead::where(['rejected_leads.ss' => '1'])
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                    ->join('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                    ->join('accounts', 'accounts.id', '=', 'rejected_leads.manager_id')
                    ->where('leads.city_id', '=', $user->city_id)
                    ->where('leads.company', '<>', '2')
                    ->orderBy('rejected_leads.id', 'DESC')
                    ->limit(20)
                    ->get();
            }
        }

        return LeadResource::collection($leads);
    }

    // Получить список обработанных запросов
    public static function getCompletedLeads()
    {
        $user = Auth::user();
        if($user->company_id == 21){
            $leads = ManagerLead::where(['manager_leads.ss' => '0', 'manager_leads.type' => '0'])
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                ->join('leads', 'leads.id', '=', 'manager_leads.lead_id')
                ->leftJoin('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                ->where('leads.company', '=', '2')
                ->orderBy('manager_leads.id', 'DESC')
                ->limit(20)
                ->get();
        } else {
            if ($user->status == 'CALL_CENTER') {
                $leads = ManagerLead::where(['manager_leads.ss' => '0', 'manager_leads.type' => '0'])
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                    ->join('leads', 'leads.id', '=', 'manager_leads.lead_id')
                    ->leftJoin('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                    ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                    ->where('leads.company', '<>', '2')
                    ->orderBy('manager_leads.id', 'DESC')
                    ->limit(20)
                    ->get();
            } else {
                $leads = ManagerLead::where(['manager_leads.ss' => '0', 'manager_leads.type' => '0'])
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                    ->join('leads', 'leads.id', '=', 'manager_leads.lead_id')
                    ->leftJoin('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                    ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                    ->where('leads.city_id', '=', $user->city_id)
                    ->where('leads.company', '<>', '2')
                    ->orderBy('manager_leads.id', 'DESC')
                    ->limit(20)
                    ->get();
            }
        }

        return LeadResource::collection($leads);
    }

    // Получить список запросов которые в процессе
    public static function getProcessingLeads()
    {
        $user = Auth::user();
        if ($user->company_id == 21){
            $leads = ManagerLead::where(['manager_leads.ss' => '0', 'manager_leads.type' => '1'])
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                ->join('leads', 'leads.id', '=', 'manager_leads.lead_id')
                ->leftJoin('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                ->where('leads.company', '=', '2')
                ->orderBy('manager_leads.id', 'DESC')
                ->limit(20)
                ->get();
        } else {
            if ($user->status == 'CALL_CENTER') {
                $leads = ManagerLead::where(['manager_leads.ss' => '0', 'manager_leads.type' => '1'])
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                    ->join('leads', 'leads.id', '=', 'manager_leads.lead_id')
                    ->leftJoin('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                    ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                    ->where('leads.company', '<>', '2')
                    ->orderBy('manager_leads.id', 'DESC')
                    ->limit(20)
                    ->get();
            } else {
                $leads = ManagerLead::where(['manager_leads.ss' => '0', 'manager_leads.type' => '1'])
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, rejected_leads.comment as comm, accounts.name as first_name, accounts.last_name'))
                    ->join('leads', 'leads.id', '=', 'manager_leads.lead_id')
                    ->leftJoin('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                    ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                    ->where('leads.city_id', '=', $user->city_id)
                    ->where('leads.company', '<>', '2')
                    ->orderBy('manager_leads.id', 'DESC')
                    ->limit(20)
                    ->get();
            }
        }

        return LeadResource::collection($leads);
    }

    // Восстановить запрос
    public static function restoreLead($lead_id)
    {
        DB::beginTransaction();
        try {
            DB::update("UPDATE leads SET ss = '1' WHERE id='$lead_id'");
            DB::update("UPDATE manager_leads SET ss = '1' WHERE lead_id = '$lead_id'");
            DB::update("UPDATE rejected_leads SET ss = '0' WHERE lead_id = '$lead_id'");
            DB::commit();
            return response('Запрос успешно восстановлено', 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response("Ошибка сервера: $exception", 500);
        }
    }

    // Удаление запроса
    public static function remove($lead_id)
    {
        DB::beginTransaction();
        try {
            DB::update("UPDATE manager_leads SET ss = '1' WHERE lead_id='$lead_id'");
            DB::update("UPDATE rejected_leads SET ss = '0' WHERE lead_id='$lead_id'");
            DB::commit();
            return response('Запрос успешно восстановлено', 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response("Ошибка сервера: $exception", 500);
        }
    }

    // Получить список лидов для директоров компании
    public static function getLeadsForDirectors()
    {
        $user = Auth::user();
        if ($user->city_id == 1) {
            if ($user->company_id == 1 || $user->company_id == 2) {
                $leads = Lead::orderBy('leads.id', 'ASC')
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                    ->where(['city_id' => $user->city_id, 'ss' => '1'])
                    ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)')
                    ->paginate(10);
            } elseif ($user->company_id == 21){
                $leads = Lead::orderBy('leads.id', 'ASC')
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                    ->where(['city_id' => $user->city_id, 'ss' => '1'])
                    ->where('leads.company', '=', '2')
                    ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)')
                    ->paginate(10);
            } else {
                $leads = Lead::orderBy('leads.id', 'ASC')
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                    ->where(['city_id' => $user->city_id, 'ss' => '1'])
                    ->where('leads.type', '!=', '10') // не брать источник File Client
                    ->where('leads.type', '!=', '8') // не брать источник Звонок в офис
                    ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)')
                    ->paginate(10);
            }
        } else {
            if ($user->company_id == 21){
                $leads = Lead::orderBy('leads.id', 'ASC')
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                    ->where(['city_id' => $user->city_id, 'ss' => '1'])
                    ->where('leads.company', '=', '2')
                    ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)')
                    ->paginate(10);
            } else {
                $leads = Lead::orderBy('leads.id', 'ASC')
                    ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                    ->where(['city_id' => $user->city_id, 'ss' => '1'])
                    ->where('leads.type', '!=', '10') // не брать источник File Client
                    ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)')
                    ->paginate(10);
            }
        }

        return LeadResource::collection($leads);
    }

    public static function getArchiveLeads()
    {
        $leads = Lead::orderBy('leads.id', 'DESC')
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn, accounts.name as user_name, accounts.last_name'))
                ->join('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
                ->join('rejected_leads', 'rejected_leads.lead_id', '=', 'leads.id')
                ->join('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                ->where(['manager_leads.ss' => '1', 'rejected_leads.ss' => '0', 'manager_leads.type' => '2'])
                ->paginate(30);
        return $leads;
    }
}