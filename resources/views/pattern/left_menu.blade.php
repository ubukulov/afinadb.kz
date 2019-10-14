<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('leads*') ? 'active' : '' }}" href="{{ route('leads') }}">Запросы</a></li>
        <li><a href="#">Поиск туров</a></li>
        <li><a class="{{ \Request::is('contacts*') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a></li>
        <li><a class="{{ \Request::is('bonus*') ? 'active' : '' }}" href="{{ route('bonus') }}">Бонусы</a></li>
        <li><a class="{{ \Request::is('suggestions*') ? 'active' : '' }}" href="{{ route('suggestions') }}">Рекомендуемые отели</a></li>
        <li>
            <a href="#">Все обучение</a>
            <ul style="display: none;">
                <li><a href="">Начальное обучение</a></li>
                <li><a href="">Обучение при стажировке</a></li>
                <li><a href="">Обучение для менеджера</a></li>
                <li><a href="">Обучение для руководителей</a></li>
                <li><a href="">Тест</a></li>
                <li><a href="">Закрытая часть</a></li>
            </ul>
        </li>
        <li><a class="{{ \Request::is('marketing*') ? 'active' : '' }}" href="{{ route('marketing') }}">Маркетинг</a></li>
        <li><a class="{{ \Request::is('chemodan*') ? 'active' : '' }}" href="{{ route('chemodan') }}">Презентации от Тур Операторов</a></li>
        <li><a class="{{ \Request::is('abk*') ? 'active' : '' }}" href="{{ route('abk') }}">Обзор отелей (АВК)</a></li>
        <li><a href="#">Запросы</a></li>
        <li><a href="#">Горящие туры</a></li>
        <li><a href="#">Отзывы</a></li>
    </ul>
</div>