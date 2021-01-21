<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cache;

class WhatsApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:run {msg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $apiTokenInstance = "44971ee235c8bbfdbdefeb909203004e22182c7cda4eb03a30";
        $idInstance = 9535;
        $api_send_message = "https://api.green-api.com/waInstance$idInstance/sendMessage/$apiTokenInstance";
        $message = $this->argument('msg');
        $contacts = Cache::get('contacts');
        foreach ($contacts as $contact) {
            $data = [
                'chatId' => $contact->id,
                'message' => $message
            ];
            $data = json_encode($data);

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                [
                    CURLOPT_URL => $api_send_message,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
//                CURLOPT_HTTP_VERSION => CURLOPT_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ]
                ]
            );
            $res = curl_exec($curl);
            curl_close($curl);
            //echo $res;
        }
    }
}
