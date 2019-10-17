<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function leads()
    {
        $this->seo()->setTitle('Список заявок');
        $leads = Lead::getLeads();
        return view('leads', compact('leads'));
    }

    public function accounts()
    {
        $users = User::orderBy('id', 'DESC')->paginate(20);
        return view('accounts', compact('users'));
    }
}
