<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Binotel;

class LeadBinotel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lead:binotel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'После того как менеджеры взяли запросы на обработку, проверим успел ли они позвонить в течение 15минут';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $leads = Lead::where(['is_called' => 0])
            ->select('leads.*')
            ->join('manager_leads', 'manager_leads.lead_id', '=', 'leads.id')
            ->where('manager_leads.tm', '>=', DB::raw('DATE_SUB(NOW() , INTERVAL 15 MINUTE)'))
            ->get();
        if ($leads) {
            foreach($leads as $lead){
                if (Binotel::isCalling($lead->phone)) {
                    $one_lead = Lead::findOrFail($lead->id);
                    $one_lead->is_called = 1;
                    $one_lead->save();
                }
            }
        }
        $this->info('Процесс завершен');
    }
}
