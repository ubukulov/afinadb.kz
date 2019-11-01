<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EducationController extends BaseController
{
    public function education()
    {
        $this->seo()->setTitle('Начальное обучене');
        return view('education');
    }

    public function internshipTraining()
    {
        $this->seo()->setTitle('Обучение при стажировке');
        return view('internship-training');
    }

    public function managerTraining()
    {
        $this->seo()->setTitle('Обучение для менеджера');
        return view('manager-training');
    }

    public function leadershipTraining()
    {
        $this->seo()->setTitle('Обучение для руководителей');
        return view('leadership-training');
    }

    public function privat()
    {
        $this->seo()->setTitle('Закрытая часть для руководителей');
        return view('private');
    }
}
