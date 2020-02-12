<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id', 'title', 'created_at', 'updated_at'
    ];

    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'question_id');
    }
}
