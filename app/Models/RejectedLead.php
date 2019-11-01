<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
