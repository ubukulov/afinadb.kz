<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;

class BinotelController extends BaseController
{
    protected $client;

    public function __construct()
    {
        parent::__construct();
        try {
            $this->client = new \denostr\Binotel\Client(env('BINOTEL_KEY'), env('BINOTEL_SECRET'));
        } catch (\denostr\Binotel\Exception $e) {
            printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
        }
    }

    /**
     * входящие звонки
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function incomingCalls()
    {
        $this->seo()->setTitle('Входящие звонки');
        if (Cache::has('all_calls_per_day')) {
            $all_calls_per_day = Cache::get('all_calls_per_day');
        } else {
            $all_calls_per_day = $this->client->stats->listOfCallsPerDay();
            Cache::put('all_calls_per_day', $all_calls_per_day, 300);
        }
        return view('binotel.incoming_calls', compact('all_calls_per_day'));
    }

    /**
     * исходящие звонки
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function outgoingCalls()
    {
        $this->seo()->setTitle('Исходящие звонки');
        if (Cache::has('all_calls_per_day')) {
            $all_calls_per_day = Cache::get('all_calls_per_day');
        } else {
            $all_calls_per_day = $this->client->stats->listOfCallsPerDay();
            Cache::put('all_calls_per_day', $all_calls_per_day, 300);
        }
        return view('binotel.outgoing_calls', compact('all_calls_per_day'));
    }

    /**
     * Пропущенные звонки
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function missingCalls()
    {
        $this->seo()->setTitle('Пропущенные звонки');
        if (Cache::has('missing_calls')) {
            $missing_calls = Cache::get('missing_calls');
        } else {
            $missing_calls = $this->client->stats->listOfLostCallsToday();
            Cache::put('missing_calls', $missing_calls, 300);
        }
        return view('binotel.missing_calls', compact('missing_calls'));
    }

    public function getAudioTalkingWithCustomers(Request $request)
    {
        $phone = $request->input('phone');
        $arr = [
            '+7 771 800 0093',
            '+77027606701',
            '87477928926',
            '7 701 284 -22-71'
        ];
        $phone = preg_replace("/[^+0-9]/", '', $phone);
        if (strlen($phone) ==  12) {
            $phone = '8'.substr($phone, 2);
        }

        if (strlen($phone) == 11 && $phone[0] == 8) {
            $audio_talks = $this->client->stats->historyByNumber([
                'number' => $phone
            ]);
            $audios = [];
            foreach($audio_talks as $audio_talk) {
                if ($audio_talk['billsec'] != 0) {
                    $audios[] = $this->client->stats->callRecord([
                        'callID' => $audio_talk['callID']
                    ]);
                }
            }
            return json_encode($audios);
        }
    }
}
