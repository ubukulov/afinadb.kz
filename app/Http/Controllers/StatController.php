<?php

namespace App\Http\Controllers;

use App\Models\ManagerLead;
use Illuminate\Http\Request;

class StatController extends BaseController
{
    public function getStatsOfManagers()
    {
        return view('stats.stats_managers', ['manager_leads' => ManagerLead::getStatsOfManagers()]);
    }
}