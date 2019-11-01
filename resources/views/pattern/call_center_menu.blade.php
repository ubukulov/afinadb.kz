<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('call_center/leads*') ? 'active' : '' }}" href="{{ route('call_center.leads') }}">Запросы</a></li>
        <li><a href="#">Отзывы</a></li>
        <li><a href="#">Отказанные запросы</a></li>
        <li><a class="{{ \Request::is('accounts*') ? 'active' : '' }}" href="{{ route('accounts') }}">Учетные записы</a></li>
        <li><a href="#">Архив и Статистика</a></li>
    </ul>
</div>