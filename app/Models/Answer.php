<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id', 'title', 'correct_answer', 'created_at', 'updated_at'
    ];
}
