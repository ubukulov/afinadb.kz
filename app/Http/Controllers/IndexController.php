<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
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

    public function triphacker(Request $request)
    {
        $data = $request->all();
        $city_id = ($data['city'] == 'Алматы') ? 1 : 2;
        $comment = $data['country'].", ".$data['name_hotel'].", ".$data['date'].", ".$data['price'].", ".$data['count_day'];
        $comment .= ", Кол-во людей: ".$data['all_people'];
        $lead = Lead::create([
            'url' => '/triphacker', 'tm' => Carbon::now(), 'phone' => $data['phone'], 'email' => $data['email'],
            'name' => $data['name'], 'type' => '0', 'ss' => '1', 'company' => '0', 'city_id' => $city_id,
            'comment' => $comment
        ]);
        return response()->json([
            'success' => $lead
        ]);
    }

    public function leadsFromOtherSources(Request $request)
    {
        $data = $request->all();
        if (!isset($data['leads']['city_id'])) {
            $data['leads']['city_id'] = 1;
        }
        $email = (isset($data['leads']['email'])) ? $data['leads']['email'] : '';
        $lead = Lead::create([
            'url' => $data['leads']['url'], 'tm' => Carbon::now(), 'phone' => $data['leads']['phone'], 'email' => $email,
            'name' => $data['leads']['name'], 'type' => $data['leads']['type'], 'ss' => '1', 'company' => $data['leads']['company'], 'city_id' => $data['leads']['city_id'],
            'comment' => $data['leads']['comment']
        ]);
        if ($lead) {
            return response('Lead successfully created', 200);
        }

        return response('Error: Lead not created', 500);
    }
}
