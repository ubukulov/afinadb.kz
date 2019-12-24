<?php

namespace App\Http\Controllers;

use App\Models\ManagerLead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Binotel;
use Auth;

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
        $incomingCallsCount = 0;
        $where = '';

        if (Auth::user()->type == 2) {
            // все источники касающихся для ПЦВП
            $all_binotel_calls = Binotel::getCalls();
            $visas_internal_numbers = [
                501, 502, 503, 504, 505, 506, 507, 508, 510, 511, 512, 513, 514, 515
            ];
            foreach($all_binotel_calls as $call){
                if ($call['callType'] == 0 && in_array((int) $call['internalNumber'], $visas_internal_numbers)) {
                    $incomingCallsCount++;
                }
            }
            $where .= " AND company='2'";
        }

        $today = DB::select("SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= CURDATE() $where GROUP BY `type`");
        $yesterday = DB::select("SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= (CURDATE()-1) AND `tm` < CURDATE() $where GROUP BY `type`");
        $week = DB::select("SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) $where GROUP BY `type`");
        $month = DB::select("SELECT count(*) as cnt, `type` FROM `leads` WHERE `tm` >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY) $where GROUP BY `type`");

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