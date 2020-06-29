<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('contacts*') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a></li>
        <li><a class="{{ \Request::is('bonus*') ? 'active' : '' }}" href="{{ route('bonus') }}">Бонусы</a></li>
        <li><a class="{{ \Request::is('suggestions*') ? 'active' : '' }}" href="{{ route('suggestions') }}">Рекомендуемые отели</a></li>
        <li>
            <a class="all_education" href="#">Все обучение</a>
            <ul class="all_education_content" style="display: none;">
                <li><a href="{{ route('education') }}">&gt;&nbsp;Начальное обучение</a></li>
                <li><a href="{{ route('internship-training') }}">&gt;&nbsp;Обучение при стажировке</a></li>
                <li><a href="{{ route('manager-training') }}">&gt;&nbsp;Обучение для менеджера</a></li>
                <li><a href="{{ route('leadership-training') }}">&gt;&nbsp;Обучение для руководителей</a></li>
                <li><a class="{{ \Request::is('training-from-to*') ? 'active' : '' }}" href="{{ route('training-from-to') }}">&gt;&nbsp;Обучение от ТО</a></li>
                <li><a href="{{ route('private') }}">&gt;&nbsp;Закрытая часть</a></li>
                <li><a href="{{ route('private') }}">&gt;&nbsp;Литература для самостоятельного развития</a></li>
            </ul>
        </li>
        <li><a class="{{ \Request::is('marketing*') ? 'active' : '' }}" href="{{ route('marketing') }}">Маркетинг</a></li>
        <li><a class="{{ \Request::is('chemodan*') ? 'active' : '' }}" href="{{ route('chemodan') }}">Презентации от Тур Операторов</a></li>
        <li><a class="{{ \Request::is('abk*') ? 'active' : '' }}" href="{{ route('abk') }}">Обзор отелей (АВК)</a></li>
    </ul>
</div>