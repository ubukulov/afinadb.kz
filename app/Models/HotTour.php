<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotTour extends Model
{
    protected $table = 'hottours';

    protected $fillable = [
        'url', 'title', 'text', 'price', 'date_from', 'ss', 'ct', 'sale', 'country', 'city'
    ];

    public $timestamps = false;
}
