<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AstroUser extends Model
{
    protected $table = 'astro_users';

    protected $fillable = [
        'name', 'email', 'birth_date', 'round'
    ];

    public $timestamps = false;
}
