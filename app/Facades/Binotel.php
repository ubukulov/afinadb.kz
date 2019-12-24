<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Binotel extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'binotel';
    }
}