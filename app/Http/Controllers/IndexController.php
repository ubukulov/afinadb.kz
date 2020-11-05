<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Cache;

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

    public function bulkMailing()
    {
        $client = new \GuzzleHttp\Client();
        $apiTokenInstance = "4fd9d8c66efb9d865cc850d88fa67a9d7313e2500b10163bb4";
        $idInstance = 7774;
        $api_get_contacts = "https://api.green-api.com/waInstance$idInstance/GetContacts/$apiTokenInstance";
        if (Cache::has('contacts')) {
            $contacts = Cache::get('contacts');
        } else {
            $contacts = $client->get($api_get_contacts)->getBody()->getContents();
            $contacts = json_decode($contacts);
            $contacts = collect($contacts);
            $contacts = $contacts->filter(function($val, $key){
                if($val->type == 'user') {
                    return $val;
                }
            });
            Cache::put('contacts', $contacts, 86400);
        }

        return view('bulk_mailing', compact('contacts'));
    }

    public function bulkMailingSend(Request $request)
    {
        $chatId = $request->input('contact_id');
        $message = $request->input('message');
        $apiTokenInstance = "4fd9d8c66efb9d865cc850d88fa67a9d7313e2500b10163bb4";
        $idInstance = 7774;
        $api_send_message = "https://api.green-api.com/waInstance$idInstance/sendMessage/$apiTokenInstance";

        if ($chatId == 0) {
            $contacts = Cache::get('contacts');

        } else {
            $data = [
                'chatId' => $chatId,
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
            echo $res;
        }
    }
}
