<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('manager/leads*') ? 'active' : '' }}" href="{{ route('manager.leads') }}">Запросы</a></li>
        <li><a class="{{ \Request::is('*my_leads*') ? 'active' : '' }}" href="{{ route('myLeads') }}">Мои запросы</a></li>
        <li><a class="{{ \Request::is('leads*') ? 'active' : '' }}" href="{{ route('leads') }}">Отложенные запросы</a></li>
        <li>
            <a class="all_education" href="#">Все обучение</a>
            <ul class="all_education_content" style="display: none;">
                <li><a href="{{ route('education') }}">&gt;&nbsp;Начальное обучение</a></li>
                <li><a href="{{ route('internship-training') }}">&gt;&nbsp;Обучение при стажировке</a></li>
                <li><a href="{{ route('manager-training') }}">&gt;&nbsp;Обучение для менеджера</a></li>
                <li><a href="{{ route('leadership-training') }}">&gt;&nbsp;Обучение для руководителей</a></li>
                <li><a href="">&gt;&nbsp;Тест</a></li>
                <li><a href="{{ route('private') }}">&gt;&nbsp;Закрытая часть</a></li>
            </ul>
        </li>
    </ul>
</div>