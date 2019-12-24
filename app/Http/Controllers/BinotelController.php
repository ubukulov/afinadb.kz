<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Binotel;

class BinotelController extends BaseController
{
    /**
     * входящие звонки
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function incomingCalls()
    {
        $this->seo()->setTitle('Входящие звонки');
        $all_calls_per_day = Binotel::getCalls();
        return view('binotel.incoming_calls', compact('all_calls_per_day'));
    }

    /**
     * исходящие звонки
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function outgoingCalls()
    {
        $this->seo()->setTitle('Исходящие звонки');
        $all_calls_per_day = Binotel::getCalls();
        return view('binotel.outgoing_calls', compact('all_calls_per_day'));
    }

    /**
     * Пропущенные звонки
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function missingCalls()
    {
        $this->seo()->setTitle('Пропущенные звонки');
        $missing_calls = Binotel::missingCalls();
        return view('binotel.missing_calls', compact('missing_calls'));
    }

    /**
     * Получить аудио записи с клиентами
     * @param Request $request
     * @return string
     */
    public function getAudioTalkingWithCustomers(Request $request)
    {
        $phone = $request->input('phone');
        $phone = preg_replace("/[^+0-9]/", '', $phone);
        if (strlen($phone) ==  12) {
            $phone = '8'.substr($phone, 2);
        }

        if (strlen($phone) == 11 && $phone[0] == 8) {
            $audio_talks = Binotel::getHistoryByNumber($phone);
            $audios = [];
            foreach($audio_talks as $audio_talk) {
                if ($audio_talk['billsec'] != 0) {
                    $audios[] = Binotel::getRecordByCallId($audio_talk['callID']);
                }
            }
            return json_encode($audios);
        }
    }
}
