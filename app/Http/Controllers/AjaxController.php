<?php

namespace App\Http\Controllers;

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

    public function leadsForCredit(Request $request)
    {
        $data = $request->all();
        $first_name = $data['name'];
        $phone = $data['phone'];
        $phone_for_bank = substr(preg_replace("/[^0-9]/", '', $phone), 1);
        $iin = $data['iin'];
        $total = $data['sum'];
        $sum = preg_replace("/[^0-9]/", '', $data['sum']);
        $txt = $data['txt'];
        $url = $data['url'];
        $comment = $data['comment'];

        DB::beginTransaction();
        try {
            $last_insert_id = Lead::create([
                'url' => $url, 'tm' => Carbon::now(), 'comment' => $comment, 'phone' => $phone, 'name' => $first_name, 'type' => '4', 'ss' => '1'
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
}
