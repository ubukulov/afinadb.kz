<?php

namespace App\Http\Controllers;

use App\Models\ManagerLead;
use Illuminate\Http\Request;

class StatController extends BaseController
{
    public function getStatsOfManagers()
    {
        $this->seo()->setTitle('Статистика менеджеров');
        return view('stats.stats_managers', ['manager_leads' => ManagerLead::getStatsOfManagers()]);
    }

    public function getStatsOfLeads()
    {
        $this->seo()->setTitle('Статистика запросов');
        return view('stats.stats_leads', ['stats' => ManagerLead::getStatsOfLeads()]);
    }
}