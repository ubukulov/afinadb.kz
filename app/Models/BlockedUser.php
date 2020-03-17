<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    protected $table = 'blocked_users';
    protected $fillable = [
        'phone', 'blocked', 'created_at', 'updated_at'
    ];
    
    public static function exists($phone)
    {
        $blocked_user = BlockedUser::where(['phone' => $phone])->first();
        return ($blocked_user) ? true : false;
    }
}
