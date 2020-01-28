<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exporter;

class ReportController extends BaseController
{
    // создать отчет
    public function createReport(Request $request)
    {
        $data = $request->all();
        //dd($data, date('d.m.Y', strtotime(substr($data['range_date']['start'],0,10))), date('d.m.Y', strtotime(substr($data['range_date']['end'],0,10))));
        if (empty($data['range_date']['end'])) {
            // указано дата, а не диапозон
            $start = substr($data['range_date']['start'],0,10);
            $leads = Lead::where(DB::raw('date_format(leads.tm, "%Y-%m-%d")'), '=', $start)->get();
        } else {
            // диапозон
            $start = substr($data['range_date']['start'],0,10);
            $end   = substr($data['range_date']['end'],0,10);
            $leads = Lead::whereBetween(DB::raw('date_format(leads.tm, "%Y-%m-%d")'), [$start, $end])->get();
        }

        $records = array();
        foreach($leads as $lead){
            $source = (int) $lead->type;
            if (array_key_exists($source, $records)) {
                $records[$source]['source'] = $this->source_list[$source];
                $records[$source]['cnt'] += 1;
            } else {
                $records[$source]['source'] = $this->source_list[$source];
                $records[$source]['cnt'] = 1;
            }
        }

        $excel = Exporter::make('Excel');
        $excel->load(collect($records));
        $excel->save('reports/test.xls');
        $filename = '/reports/test.xls';
        return $filename;
    }
}
