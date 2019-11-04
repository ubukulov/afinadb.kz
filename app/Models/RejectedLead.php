<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RejectedLead extends Model
{
    public $timestamps = false;

    protected $table = 'rejected_leads';

    protected $fillable = [
        'id', 'lead_id', 'manager_id', 'comment', 'ss', 'tm'
    ];

    public static function exists($lead_id)
    {
        $result = RejectedLead::where(['lead_id' => $lead_id])->first();
        return ($result) ? true : false;
    }

    // возвращать лид обратно к менеджеру
    public static function returnLeadToManager($data)
    {
        $user = \Auth::user();
        $lead_id = $data['lead_id'];
        if ($user) {
            $rejected_lead = RejectedLead::where(['lead_id' => $lead_id])->where('ss', '!=', '0')->first();
            if ($rejected_lead) {
                if ($rejected_lead->ss == '1') {
                    $comm = json_decode($rejected_lead->comment, true);
                    $comm[] = [
                        'comment' => $data['comment'], 'name' => $user->getFullName()
                    ];
                    DB::beginTransaction();
                    try {
                        $c = json_encode($comm, JSON_UNESCAPED_UNICODE);
                        DB::update("UPDATE rejected_leads SET comment = '$c', ss = '2' WHERE lead_id = '$lead_id'");
                        DB::update("UPDATE manager_leads SET type='1' WHERE lead_id='$lead_id'");
                        return response('Запрос на рассмотрений у Менеджера!', 200);
                    } catch (\Exception $exception) {
                        DB::rollBack();
                        return response("Ошибка сервера: $exception", 500);
                    }
                } else {
                    return response('Запрос на рассмотрений у Менеджера!', 200);
                }
            } else {
                return response('Ошибка. Запрос не может вернуться к менеджеру.', 500);
            }
        } else {
            return response('Ошибка клиента.', 401);
        }
    }
}
