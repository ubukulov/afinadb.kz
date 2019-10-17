<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'id', 'url', 'tm', 'comment', 'phone', 'email', 'name', 'type', 'ss', 'manager', 'status', 'company', 'city_id'
    ];

    public $timestamps = false;

    public static function getLeads()
    {
        $result = Lead::orderBy('leads.tm', 'DESC')
                ->select('leads.*', 'manager_leads.type AS m_type', 'users.name as user_name', 'users.last_name')
                ->leftJoin('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
                ->leftJoin('users', 'users.id', '=', 'manager_leads.manager_id')
                ->paginate(20);
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
        $lead = ManagerLead::where(['lead_id' => $this->id])->first();
        if ($lead && $lead->type == '2') {
            return true;
        }

        return false;
    }

    public function isProcessed()
    {
        $lead = ManagerLead::where(['lead_id' => $this->id])->first();
        if ($lead && $lead->type == '1') {
            return true;
        }

        return false;
    }

    public function isNew()
    {
        return ($this->ss == '1') ? true : false;
    }
}
