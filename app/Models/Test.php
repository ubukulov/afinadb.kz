<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'testing';

    protected $fillable = [
        'user_id', 'title', 'active', 'created_at', 'updated_at'
    ];

    public function questions()
    {
        return $this->hasMany('App\Models\Question', 'test_id');
    }
}
