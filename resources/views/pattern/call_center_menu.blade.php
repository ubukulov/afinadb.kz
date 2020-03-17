<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('call_center/leads*') ? 'active' : '' }}" href="{{ route('call_center.leads') }}">Запросы</a></li>
        <li><a class="{{ \Request::is('call_center/rejected_leads*') ? 'active' : '' }}" href="{{ route('rejected.leads') }}">Отказанные запросы</a></li>
        <li><a class="{{ \Request::is('call_center/archive/leads*') ? 'active' : '' }}" href="{{ route('archive.leads') }}">Архивные запросы</a></li>
        <li><a class="{{ \Request::is('call_center/blocked-users*') ? 'active' : '' }}" href="{{ route('blocked.users') }}">Заблокированные пользователи</a></li>
    </ul>
</div>