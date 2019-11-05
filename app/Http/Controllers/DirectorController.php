<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class DirectorController extends BaseController
{
    public function leads()
    {
        $this->seo()->setTitle('Список запросов');
        return view('director.leads');
    }

    public function getLeads()
    {
        return Lead::getLeadsForDirectors();
    }
}
