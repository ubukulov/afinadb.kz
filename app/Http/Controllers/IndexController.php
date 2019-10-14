<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function welcome()
    {
        $this->seo()->setTitle('Главная страница');
        return view('welcome');
    }

    public function contacts()
    {
        $this->seo()->setTitle('Контакты');
        return view('contacts');
    }

    public function bonus()
    {
        $this->seo()->setTitle('Система бонусов');
        return view('bonus');
    }

    public function suggestions()
    {
        $this->seo()->setTitle('Рекомендуемые отели');
        return view('suggestions');
    }

    public function marketing()
    {
        $this->seo()->setTitle('КОРПОРАТИВНАЯ ИДЕНТИФИКАЦИЯ');
        return view('marketing');
    }

    public function chemodan()
    {
        $this->seo()->setTitle('Презентации');
        return view('chemodan');
    }

    public function abk()
    {
        $this->seo()->setTitle('Спец. предложение по Турции');
        return view('abk');
    }
}
