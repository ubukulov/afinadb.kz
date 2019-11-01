<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerLead extends Model
{
    public $timestamps = false;

    protected $table = 'manager_leads';

    protected $fillable = [
        'id', 'lead_id', 'manager_id', 'tm', 'type', 'ss'
    ];

    public function lead()
    {
        return $this->belongsTo('App\Models\Lead', 'lead_id');
    }

    public function manager()
    {
        return $this->belongsTo('App\Models\User', 'manager_id');
    }

    public static function exists($lead_id)
    {
        $result = ManagerLead::where(['lead_id' => $lead_id])->first();
        return ($result) ? true : false;
    }
}
