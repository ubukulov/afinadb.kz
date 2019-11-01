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
    protected $source_list = ['Website','Instagram', 'Facebook','Whatsapp','chemodan.kz','257.kz','turkish.kz','alanya.kz','Звонок в офис','JivoSite','File Client','Sletat.ru','Знакомые Руководители','ПЦВП', 'mardan.kz', 'egipt.kz', 'emirat.kz','turkish.kz - Nur-Sultan', 'fr.alanya.kz', 'egipt.kz - Nur-Sultan', 'emirat.kz - Nur-Sultan', 'tailand.kz', 'tailand.kz - Nur-Sultan', 'hainan.kz', 'hainan.kz - Nur-Sultan', 'goa-india.kz', 'goa-india.kz - Nur-Sultan',
        'WhatsApp-Chemodan.kz','WhatsApp-mardan.kz','WhatsApp-tailand.kz','WhatsApp-turkish.kz','WhatsApp-egipt.kz','WhatsApp-hainan.kz','WhatsApp-alanya.kz','WhatsApp-emirat.kz','WhatsApp-goa-india.kz','JivoSite-chemodan.kz','JivoSite-mardan.kz','JivoSite-tailand.kz','JivoSite-turkish.kz','JivoSite-egipt.kz','JivoSite-hainan.kz','JivoSite-alanya.kz','JivoSite-emirat.kz','JivoSite-goa-india.kz', 'Дубай', 'Дубай-Nur-Sultan',
        'Абу-Даби', 'Абу-Даби-Nur-Sultan', 'Шарджа', 'Шарджа-Nur-Sultan', 'Рас-эль-Хайма', 'Рас-эль-Хайма-Nur-Sultan', 'Фуджейра', 'Фуджейра - Nur-Sultan', 'Whatsapp-дубай','Whatsapp-Абу Даби', 'Whatsapp-Шарджа', 'Whatsapp-Рас-эль-Хайма', 'Whatsapp-Фуджерай', 'JivoSite-Дубай', 'JivoSite-Абу Даби', 'JivoSite-Шарджа', 'JivoSite-Рас-эл-Хайма','JivoSite-Фуджейра', 'dominicana.kz', 'dominicana.kz - Nur-Sultan', 'franchise.chemodan.kz', 'Whatsapp-dominicana.kz', 'JivoSite-dominicana.kz'];
    protected $cities;
    protected $companies;

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

        View::share('agent', $this->agent);
        View::share('source_list', $this->source_list);
    }
}