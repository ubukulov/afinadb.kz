<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('manager/leads*') ? 'active' : '' }}" href="{{ route('manager.leads') }}">Запросы</a></li>
        <li><a class="{{ \Request::is('*my_leads*') ? 'active' : '' }}" href="{{ route('myLeads') }}">Мои запросы</a></li>
        <li>
            <a class="all_education" href="#">Все обучение</a>
            <ul class="all_education_content" @if(!blockAllEducation(substr($_SERVER['REQUEST_URI'], 1))) style="display: none;" @endif>
                <li><a class="{{ \Request::is('education*') ? 'active' : '' }}" href="{{ route('education') }}">&gt;&nbsp;Начальное обучение</a></li>
                <li><a class="{{ \Request::is('internship-training*') ? 'active' : '' }}" href="{{ route('internship-training') }}">&gt;&nbsp;Обучение при стажировке</a></li>
                <li><a class="{{ \Request::is('manager-training*') ? 'active' : '' }}" href="{{ route('manager-training') }}">&gt;&nbsp;Обучение для менеджера</a></li>
                <li><a class="{{ \Request::is('training-from-to*') ? 'active' : '' }}" href="{{ route('training-from-to') }}">&gt;&nbsp;Обучение от ТО</a></li>

                @if(Auth::user()->id == 134 || Auth::user()->id == 34)
                <li><a class="{{ \Request::is('private*') ? 'active' : '' }}" href="{{ route('private') }}">&gt;&nbsp;Закрытая часть</a></li>
                @endif
                <li><a href="{{ route('literature-for-self-development') }}">&gt;&nbsp;Литература для самостоятельного развития</a></li>
            </ul>
        </li>
        <li><a class="{{ \Request::is('all-webinars*') ? 'active' : '' }}" href="{{ route('all-webinars') }}">Все вебинары</a></li>
        <li><a class="{{ \Request::is('suggestions*') ? 'active' : '' }}" href="{{ route('suggestions') }}">Рекомендуемые отели</a></li>
        <li><a class="{{ \Request::is('chemodan*') ? 'active' : '' }}" href="{{ route('chemodan') }}">Презентации от Тур Операторов</a></li>
        <li><a class="{{ \Request::is('abk*') ? 'active' : '' }}" href="{{ route('abk') }}">Обзор отелей (АВК)</a></li>
    </ul>
</div>