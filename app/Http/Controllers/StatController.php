<?php

namespace App\Http\Controllers;

use App\Models\ManagerLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getStatsOfSources()
    {
        $this->seo()->setTitle('Статистика по источникам');

        $sources = $this->source_list;

        $today = DB::select('SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= CURDATE() GROUP BY `type`');
        $yesterday = DB::select('SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= (CURDATE()-1) AND `tm` < CURDATE() GROUP BY `type`');
        $week = DB::select('SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) GROUP BY `type`');
        $month = DB::select('SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY) GROUP BY `type`');

        $arrs = [];

        foreach($today as $t) {
            $arrs[$sources[$t->type]]['today'] = $t->cnt;
        }

        foreach($yesterday as $y){
            if (array_key_exists($sources[$y->type], $arrs)) {
                $arrs[$sources[$y->type]]['yesterday'] = $y->cnt;
            } else {
                $arrs[$sources[$y->type]]['yesterday'] = $y->cnt;
            }
        }

        foreach($week as $w){
            if (array_key_exists($sources[$w->type], $arrs)) {
                $arrs[$sources[$w->type]]['week'] = $w->cnt;
            } else {
                $arrs[$sources[$w->type]]['week'] = $w->cnt;
            }
        }

        foreach($month as $m){
            if (array_key_exists($sources[$m->type], $arrs)) {
                $arrs[$sources[$m->type]]['month'] = $m->cnt;
            } else {
                $arrs[$sources[$m->type]]['month'] = $m->cnt;
            }
        }

        return view('stats.stats_sources', compact('arrs'));
    }
}