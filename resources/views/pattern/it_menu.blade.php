<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('call_center/accounts*') ? 'active' : '' }}" href="{{ route('accounts') }}">Учетные записы</a></li>
    </ul>
</div>