<?php

namespace App\Console\Commands;

use App\Models\AstroUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Esputnik;
use Illuminate\Support\Facades\DB;
//use Crypt;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Установка пакетов';

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
        
    }
}
