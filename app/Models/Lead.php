<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lead extends Model
{
    protected $fillable = [
        'id', 'url', 'tm', 'comment', 'phone', 'email', 'name', 'type', 'ss', 'manager', 'status', 'company', 'city_id'
    ];

    public $timestamps = false;

    public static function getLeads($role = null)
    {
        if ($role == 'MANAGER') {
            $result = Lead::orderBy('id', 'DESC')
                ->select(DB::raw('leads.*, date_format(leads.tm, "%d.%m.%Y %H:%i") as dt, datediff(CURRENT_TIMESTAMP(), leads.tm) as dn'))
                ->where(['city_id' => \Auth::user()->city_id, 'ss' => '1'])
                ->whereRaw('leads.tm >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)')
                ->paginate(20);
        } else {
            $result = Lead::orderBy('leads.tm', 'DESC')
                ->select('leads.*', 'manager_leads.type AS m_type', 'accounts.name as user_name', 'accounts.last_name')
                ->leftJoin('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
                ->leftJoin('accounts', 'accounts.id', '=', 'manager_leads.manager_id')
                ->paginate(20);
        }

        return $result;
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
        $result = Lead::orderBy('id', 'DESC')
            ->where(['manager_leads.manager_id' => $manager->id, 'leads.city_id' => $manager->city_id])
            ->select('leads.*', 'manager_leads.type AS m_type')
            ->join('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
            ->paginate(20);

        return $result;
    }

    // Получить новые лиды
    public static function getLeadsOfFree($user_id)
    {
        $user = User::findOrFail($user_id);
        $leads = Lead::orderBy('id', 'DESC')->where(['city_id' => $user->city_id, 'ss' => '1'])->take(200)->limit(200)->paginate(20);
        return $leads;
    }
}
