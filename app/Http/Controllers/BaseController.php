<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Traits\SEOTools;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Jenssegers\Agent\Agent;
use View;

class BaseController extends Controller
{
    use SEOToolsTrait;

    protected $agent;

    public function __construct()
    {
        $this->agent = new Agent();
        View::share('agent', $this->agent);
    }
}
