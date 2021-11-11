<?php

namespace App\Console\Commands;

use App\Models\AstroUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Esputnik;
use Illuminate\Support\Facades\DB;
//use Crypt;

class SendPDC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:pdc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'После того как клиенты покупает подписку, мы начинаем каждый день отправлять на почту ПДС';

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
        $users = AstroUser::all();
        foreach ($users as $user) {
            $data = [];

            //$signature = Crypt::encrypt($user->id);
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            //$data['buy_subscription_link'] = route('buy.subscription')."?signature=".$signature;
            //$data['buy_course_link'] = route('show.course')."?signature=".$signature;
            //$data['buy_consultation_link'] = route('show.consultation')."?signature=".$signature;

            if ($user->round == 18) {
                $user->round = 1;
            } else {
                $user->round++;
            }
            $user->save();

            $pdc_Number = Esputnik::getPDCNumber($user->birth_date);
            $pdc = Esputnik::value_lists($pdc_Number, $user);
            $data['pdc'] = $pdc;

            Esputnik::sendEmail(2221563, $data, 3);
        }
    }
}
