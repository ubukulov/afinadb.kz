<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EducationController extends BaseController
{
    /**
     * Начальное обучене
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function education()
    {
        $this->seo()->setTitle('Начальное обучене');
        return view('education');
    }

    /**
     * Обучение при стажировке
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function internshipTraining()
    {
        $this->seo()->setTitle('Обучение при стажировке');
        return view('internship-training');
    }

    /**
     * Обучение для менеджера
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function managerTraining()
    {
        $this->seo()->setTitle('Обучение для менеджера');
        return view('manager-training');
    }

    /**
     * Обучение для руководителей
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leadershipTraining()
    {
        $this->seo()->setTitle('Обучение для руководителей');
        return view('leadership-training');
    }

    /**
     * Закрытая часть для руководителей
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privat()
    {
        $this->seo()->setTitle('Закрытая часть для руководителей');
        return view('private');
    }

    /**
     * Все вебинары
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function webinars()
    {
        $this->seo()->setTitle('Все вебинары');
        return view('webinars');
    }

    public function trainingFromTo()
    {
        $this->seo()->setTitle('Обучение от ТО');
        return view('training_from_to');
    }

    public function literatureForSelfDevelopment()
    {
        $this->seo()->setTitle('Литература для самостоятельного развития');
        return view('literature_for_self_development');
    }
}
