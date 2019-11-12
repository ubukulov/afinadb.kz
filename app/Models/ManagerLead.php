<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ManagerLead extends Model
{
    public $timestamps = false;

    protected $table = 'manager_leads';

    protected $fillable = [
        'id', 'lead_id', 'manager_id', 'tm', 'type', 'ss'
    ];

    public function lead()
    {
        return $this->belongsTo('App\Models\Lead', 'lead_id');
    }

    public function manager()
    {
        return $this->belongsTo('App\Models\User', 'manager_id');
    }

    public static function exists($lead_id)
    {
        $result = ManagerLead::where(['lead_id' => $lead_id])->first();
        return ($result) ? true : false;
    }

    public static function getStatsOfManagers()
    {
        $manager_leads = DB::select("SELECT 
        CONCAT(accounts.name, ' ', accounts.last_name) AS fio,
        companies.title AS com_title,
        cities.title AS city,
        SUM(manager_leads.type='0') AS suc,
        SUM(manager_leads.type='1') AS pro,
        SUM(manager_leads.type='2') AS can
        FROM `manager_leads`
        INNER JOIN accounts ON accounts.id=manager_leads.manager_id
        INNER JOIN leads ON leads.id=manager_leads.lead_id
        INNER JOIN companies ON companies.id=accounts.company_id
        INNER JOIN cities ON cities.id=accounts.city_id
        WHERE manager_leads.tm >= CURDATE()
        GROUP BY manager_leads.manager_id, accounts.name, accounts.last_name, companies.title, cities.title");
        return $manager_leads;
    }

    public static function getStatsOfLeads()
    {
        $leads = DB::select("SELECT
        SUM(manager_leads.type='0') AS suc,
        SUM(manager_leads.type='1') AS pro,
        SUM(manager_leads.type='2') AS can,
        SUM(leads.ss='1') AS new
        FROM leads
        LEFT JOIN manager_leads ON manager_leads.lead_id=leads.id
        WHERE leads.tm >= CURDATE()");
        return $leads;
    }
}
