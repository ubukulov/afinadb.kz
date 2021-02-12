<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendMessage extends Model
{
    protected $table = 'sending_messages';

    protected $fillable = [
        'message', 'status', 'created_at', 'updated_at'
    ];
}
