<?php

namespace App\Http\Controllers;

use App\Models\HotTour;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends BaseController
{
    public function leadsFromOtherSources(Request $request)
    {
        $data = $request->all();
        if (!isset($data['leads']['city_id'])) {
            $data['leads']['city_id'] = 1;
        }
        $email = (isset($data['leads']['email'])) ? $data['leads']['email'] : '';
        $url = (isset($data['leads']['url'])) ? $data['leads']['url'] : '/';
        $company = (isset($data['leads']['company'])) ? $data['leads']['company'] : '0';
        $comment = (isset($data['leads']['comment'])) ? $data['leads']['comment'] : '';
        $lead = Lead::create([
            'url' => $url, 'tm' => Carbon::now(), 'phone' => $data['leads']['phone'], 'email' => $email,
            'name' => $data['leads']['name'], 'type' => $data['leads']['type'], 'ss' => '1', 'company' => $company, 'city_id' => $data['leads']['city_id'],
            'comment' => $comment
        ]);
        if ($lead) {
            return response('Lead successfully created', 200);
        }

        return response('Error: Lead not created', 500);
    }

    public function leadsForCredit(Request $request)
    {
        $data = $request->all();
        $first_name = $data['leads_for_credit']['name'];
        $phone = $data['leads_for_credit']['phone'];
        $phone_for_bank = substr(preg_replace("/[^0-9]/", '', $phone), 1);
        $iin = $data['leads_for_credit']['iin'];
        $total = $data['leads_for_credit']['sum'];
        $sum = preg_replace("/[^0-9]/", '', $total);
        $txt = $data['leads_for_credit']['txt'];
        $url = (!empty($data['leads_for_credit']['url'])) ? $data['leads_for_credit']['url'] : '/';
        $type = $data['leads_for_credit']['type'];
        $company = $data['leads_for_credit']['company'];
        $comment = $data['leads_for_credit']['comment'];

        DB::beginTransaction();
        try {
            $last_insert_id = Lead::create([
                'url' => $url, 'tm' => Carbon::now(), 'comment' => $comment, 'phone' => $phone, 'name' => $first_name, 'type' => $type, 'ss' => '1', 'company' => $company
            ])->id;

            $client = new \SoapClient("https://www.afinadb.kz/eshop.wsdl");

            $id = "Chemodan-".$last_insert_id;
            $params = [
                'P_USER' => 'CHEMODAN',
                'P_PASSWORD' => '0000',
                'P_APPL_NUM' => $id,
                'P_IIN' => $iin,
                'P_CL_NAME' => $first_name,
                'P_MOBPHONE' => $phone_for_bank,
                'P_AMOUNT' => $sum,
                'P_GOODS' => $txt,
            ];

            $response = $client->__soapCall("SendAppl", array($params));

            // Отправляем письмо к Call Center
            $message = "
            <html>
                <head>
                    <title>Новая заявка с рассрочкой через HomeCreditBank</title>
                </head>
                <body>
                             <p>Номер заявки в Афине: $last_insert_id</p>
                             <p>Номер заявки в банке: $id</p>
                   <p>Имя: $first_name</p>
                   <p>Телефон: $phone</p>
                             <p>ИИН: $iin</p>
                             <p>Сумма: $total</p>
                   <p>Комментарии: $comment</p>
                </body>
            </html>
            ";

            $to = 'cc@chemodan.kz' . ', ';
            $to .= 'web@chemodan.kz';
            $subject = 'Новая заявка с рассрочкой';
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";

            $headers .= "From: <robot@visa-china.kz>\r\n";
            mail($to, $subject, $message, $headers);
            DB::commit();
            return response("Заявка успешно отправлено", 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response("Ошибка сервера: $exception", 500);
        }
    }

    public function getHotTours()
    {
        $COUNTRY = '';
        if (isset($_GET['country'])) {
            $COUNTRY = " AND `country`='".$_GET['country']."'";
        }
        $CITY = '';
        if (isset($_GET['city'])) {
            $CITY = " AND `city`='".$_GET['city']."'";
        }
        $hot_tours = DB::select("SELECT * FROM `hottours`  WHERE `date_from` >= CURDATE() AND `ss`='0' ".$COUNTRY." ".$CITY." ORDER BY `ct` DESC");
        $tours = [];
        $countries = ['Болгария','Вьетнам','Греция','Индия','Китай','Куба','Малайзия','Грузия','Доминикана','Египет','Мальдивы','ОАЭ','Таиланд','Турция','Чехия','О.Бали','Хургада'];
        $office_list = ['Алматы','Нур-Султан','Актау','Караганда','Шымкент','Актобе','Атырау'];
        foreach($hot_tours as $hot_tour) {
            $tours[] = [
                'url'=> $hot_tour->url, 'id'=> $hot_tour->id, 'title'=> $hot_tour->title, 'text' => $hot_tour->text, 'price' => $hot_tour->price,
                'date_from' => $this->dateDiff($hot_tour->date_from), 'ss' => $hot_tour->ss, 'ct' => $hot_tour->ct, 'sale' => $hot_tour->sale,
                'country' => $countries[$hot_tour->country], 'city' => $office_list[$hot_tour->city]
            ];
        }
        return json_encode($tours);
    }

    public function dateDiff ($d1) {
        // Return the number of days between the two dates:
        return round(abs(strtotime($d1)-strtotime("today"))/86400);
    }
}
