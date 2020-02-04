<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Traits\SEOTools;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Jenssegers\Agent\Agent;
use View;
use Cache;
use Auth;

class BaseController extends Controller
{
    use SEOToolsTrait;

    protected $agent;
    protected $source_list =
        [
            0 => 'Website',
            1 => 'Instagram',
            2 => 'Facebook',
            3 => 'Whatsapp',
            4 => 'chemodan.kz',
            5 => '257.kz',
            6 => 'turkish.kz',
            7 => 'alanya.kz',
            8 => 'Звонок в офис',
            9 => 'JivoSite',
            10 => 'File Client',
            11 => 'Sletat.ru',
            12 => 'Знакомые Руководители',
            13 => 'ПЦВП',
            14 => 'mardan.kz',
            15 => 'egipt.kz',
            16 => 'emirat.kz',
            17 => 'chekhiya.kz',
            18 => 'ispaniya.kz',
            19 => 'WantResult',
            20 => 'emirat.kz - Nur-Sultan',
            21 => 'tailand.kz',
            22 => 'tailand.kz - Nur-Sultan',
            23 => 'hainan.kz',
            24 => 'hainan.kz - Nur-Sultan',
            25 => 'goa-india.kz',
            26 => 'goa-india.kz - Nur-Sultan',
            27 => 'WhatsApp-Chemodan.kz',
            28 => 'WhatsApp-mardan.kz',
            29 => 'WhatsApp-tailand.kz',
            30 => 'WhatsApp-turkish.kz',
            31 => 'WhatsApp-egipt.kz',
            32 => 'WhatsApp-hainan.kz',
            33 => 'WhatsApp-alanya.kz',
            34 => 'WhatsApp-emirat.kz',
            35 => 'WhatsApp-goa-india.kz',
            36 => 'JivoSite-chemodan.kz',
            37 => 'JivoSite-mardan.kz',
            38 => 'JivoSite-tailand.kz',
            39 => 'JivoSite-turkish.kz',
            40 => 'JivoSite-egipt.kz',
            41 => 'JivoSite-hainan.kz',
            42 => 'JivoSite-alanya.kz',
            43 => 'JivoSite-emirat.kz',
            44 => 'JivoSite-goa-india.kz',
            45 => 'Дубай',
            46 => 'Дубай-Nur-Sultan',
            47 => 'Абу-Даби',
            48 => 'Абу-Даби-Nur-Sultan',
            49 => 'Шарджа',
            50 => 'Шарджа-Nur-Sultan',
            51 => 'Рас-эль-Хайма',
            52 => 'Рас-эль-Хайма-Nur-Sultan',
            53 => 'Фуджейра',
            54 => 'Фуджейра - Nur-Sultan',
            55 => 'Whatsapp-дубай',
            56 => 'Whatsapp-Абу Даби',
            57 => 'Whatsapp-Шарджа',
            58 => 'Whatsapp-Рас-эль-Хайма',
            59 => 'Whatsapp-Фуджерай',
            60 => 'JivoSite-Дубай',
            61 => 'JivoSite-Абу Даби',
            62 => 'JivoSite-Шарджа',
            63 => 'JivoSite-Рас-эл-Хайма',
            64 => 'JivoSite-Фуджейра',
            65 => 'dominicana.kz',
            66 => 'dominicana.kz - Nur-Sultan',
            67 => 'franchise.chemodan.kz',
            68 => 'Whatsapp-dominicana.kz',
            69 => 'JivoSite-dominicana.kz',
            70 => 'maldiv.kz',
            71 => 'maldiv.kz-Nur-Sultan',
            72 => 'WhatsApp-Мальдивы',
            73 => 'JivoSite-Мальдивы',
            74 => 'education.chemodan.kz',
            75 => 'usa-visa.kz',
            76 => 'visa-china.kz',
            77 => 'visa-germany.kz',
            78 => 'visa-canada.kz',
            79 => 'visas.kz'
        ];
    protected $cities;
    protected $companies;
    protected $disposition = [
        'ANSWER' => 'успешный звонок',
        'TRANSFER' => 'успешный звонок который был переведен',
        'ONLINE' => 'звонок в онлайне',
        'BUSY' => 'неуспешный звонок по причине занято',
        'NOANSWER' => 'неуспешный звонок по причине нет ответа',
        'CANCEL' => 'неуспешный звонок по причине отмены звонка',
        'CONGESTION' => 'неуспешный звонок',
        'CHANUNAVAIL' => 'неуспешный звонок',
        'VM' => 'голосовая почта без сообщения',
        'VM-SUCCESS' => 'голосовая почта с сообщением',
        'SMS-SENDING' => 'SMS сообщение на отправке',
        'SMS-SUCCESS' => 'SMS сообщение успешно отправлено',
        'SMS-FAILED' => 'SMS сообщение не отправлено',
        'SUCCESS' => 'успешно принятый факс',
        'FAILED' => 'непринятый факс',
        'CALLING' => 'Идет звонок'
    ];

    protected $user;

    public function __construct()
    {
        $this->agent = new Agent();
        if (Cache::has('cities')) {
            View::share('cities', Cache::get('cities'));
        } else {
            $this->cities = City::all();
            Cache::put('cities', $this->cities, 2592000); // сохранем в кэше за месяц
            View::share('cities', $this->cities);
        }
        if (Cache::has('companies')) {
            View::share('companies', Cache::get('companies'));
        } else {
            $this->companies = Company::all();
            Cache::put('companies', $this->companies, 2592000); // сохранем в кэше за месяц
            View::share('companies', $this->companies);
        }

        $this->user = (Auth::check()) ? Auth::user() : null;

        View::share('agent', $this->agent);
        View::share('source_list', $this->source_list);
        View::share('disposition', $this->disposition);
    }
}