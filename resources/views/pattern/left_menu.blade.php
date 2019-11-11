<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('contacts*') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a></li>
        <li><a class="{{ \Request::is('bonus*') ? 'active' : '' }}" href="{{ route('bonus') }}">Бонусы</a></li>
        <li><a class="{{ \Request::is('suggestions*') ? 'active' : '' }}" href="{{ route('suggestions') }}">Рекомендуемые отели</a></li>
        <li><a class="{{ \Request::is('chemodan*') ? 'active' : '' }}" href="{{ route('chemodan') }}">Презентации от Тур Операторов</a></li>
        <li><a class="{{ \Request::is('abk*') ? 'active' : '' }}" href="{{ route('abk') }}">Обзор отелей (АВК)</a></li>
        <li><a class="{{ \Request::is('accounts*') ? 'active' : '' }}" href="{{ route('accounts') }}">Учетные записы</a></li>
    </ul>
</div>