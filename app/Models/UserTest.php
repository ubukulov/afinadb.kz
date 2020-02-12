<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTest extends Model
{
    protected $table = 'user_tests';

    protected $fillable = [
        'test_id', 'user_id', 'question_id', 'answer_id', 'created_at', 'updated_at'
    ];
}
