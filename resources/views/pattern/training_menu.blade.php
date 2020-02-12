<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li>
            <a class="all_education" href="#">Все обучение</a>
            <ul class="all_education_content" @if(!blockAllEducation(substr($_SERVER['REQUEST_URI'], 1))) style="display: none;" @endif>
                <li><a class="{{ \Request::is('education*') ? 'active' : '' }}" href="{{ route('education') }}">&gt;&nbsp;Начальное обучение</a></li>
{{--                <li><a class="{{ \Request::is('internship-training*') ? 'active' : '' }}" href="{{ route('internship-training') }}">&gt;&nbsp;Обучение при стажировке</a></li>--}}
{{--                <li><a class="{{ \Request::is('manager-training*') ? 'active' : '' }}" href="{{ route('manager-training') }}">&gt;&nbsp;Обучение для менеджера</a></li>--}}
{{--                <li><a class="{{ \Request::is('training-from-to*') ? 'active' : '' }}" href="{{ route('training-from-to') }}">&gt;&nbsp;Обучение от ТО</a></li>--}}
{{--                <li><a class="{{ \Request::is('private*') ? 'active' : '' }}" href="{{ route('private') }}">&gt;&nbsp;Закрытая часть</a></li>--}}
                <li><a class="{{ \Request::is('testing') ? 'active' : '' }}" href="{{ route('testing') }}">&gt;&nbsp;Тест</a></li>
            </ul>
        </li>
    </ul>
</div>