<?php

namespace App\Classes;

use Cache;
use Carbon\Carbon;

class Binotel
{
    protected $client = false;

    public function __construct()
    {
        if (!$this->client){
            try {
                $this->client = new \denostr\Binotel\Client(env('BINOTEL_KEY'), env('BINOTEL_SECRET'));
            } catch (\denostr\Binotel\Exception $e) {
                printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
            }
        }
    }

    /**
     * Получить все звонки то есть выходящие и исходящие
     * @return mixed
     */
    public  function getCalls()
    {
        if (Cache::has('all_calls_per_day')) {
            $all_calls_per_day = Cache::get('all_calls_per_day');
        } else {
            $all_calls_per_day = $this->client->stats->listOfCallsPerDay();
            Cache::put('all_calls_per_day', $all_calls_per_day, 300);
        }
        return $all_calls_per_day;
    }

    /**
     * Получить пропущенные звонки
     * @return mixed
     */
    public function missingCalls()
    {
        if (Cache::has('missing_calls')) {
            $missing_calls = Cache::get('missing_calls');
        } else {
            $missing_calls = $this->client->stats->listOfLostCallsToday();
            Cache::put('missing_calls', $missing_calls, 300);
        }
        return $missing_calls;
    }

    /**
     * Получить истории звонка по номеру
     * @param $phone integer
     * @return mixed
     */
    public function getHistoryByNumber($phone)
    {
        $audio_talks = $this->client->stats->historyByNumber([
            'number' => $phone
        ]);
        return $audio_talks;
    }

    /**
     * Получить список записей по ид звонка
     * @param $callID integer
     * @return mixed
     */
    public function getRecordByCallId($callID)
    {
        $str = $this->client->stats->callRecord([
            'callID' => $callID
        ]);
        return $str;
    }

    /**
     * Получить подробную информацию о звонке
     * @param $generalCallID integer
     * @return mixed
     */
    public function getCallDetails($generalCallID)
    {
        return $this->client->stats->callDetails(['generalCallID' => $generalCallID]);
    }

    /**
     * Получение всех CallTracking за выбранный период времени.
     * @param $startTime integer
     * @param $stopTime integer
     * @return mixed
     */
    public function getCallTrackingCallsForPeriod($startTime, $stopTime = 0)
    {
        $stopTime = ($stopTime == 0) ? strtotime(Carbon::now()) : $stopTime;
        return $this->client->stats->callTrackingCallsForPeriod([
            'startTime' => $startTime,
            'stopTime' => $stopTime
        ]);
    }

    public function isCalling($phone)
    {
        $phone = preg_replace("/[^+0-9]/", '', $phone);
        if (strlen($phone) ==  12) {
            $phone = '8'.substr($phone, 2);
        }

        if (strlen($phone) == 11 && $phone[0] == 8) {
            $audio_talks = $this->getHistoryByNumber($phone);
            $audios = [];
            foreach($audio_talks as $audio_talk) {
                if ($audio_talk['billsec'] != 0) {
                    $audios[] = $this->getRecordByCallId($audio_talk['callID']);
                }
            }

            if (count($audios) > 0) {
                return true;
            }
        }

        return false;
    }
}