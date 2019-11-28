<div class="left_menu">
    <ul>
        <li><a class="{{ \Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a></li>
        <li><a class="{{ \Request::is('director/leads*') ? 'active' : '' }}" href="{{ route('director.leads') }}">Запросы</a></li>
        <li><a class="{{ \Request::is('director/my_leads*') ? 'active' : '' }}" href="{{ route('director.myLeads') }}">Мои запросы</a></li>
        <li><a class="{{ \Request::is('call_center/rejected_leads*') ? 'active' : '' }}" href="{{ route('rejected.leads') }}">Отказанные запросы</a></li>
        <li><a class="{{ \Request::is('marketing*') ? 'active' : '' }}" href="{{ route('marketing') }}">Маркетинг</a></li>
        <li>
            <a class="all_education" href="#">Все обучение</a>
            <ul class="all_education_content" style="display: none;">
                <li><a href="{{ route('education') }}">&gt;&nbsp;Начальное обучение</a></li>
                <li><a href="{{ route('internship-training') }}">&gt;&nbsp;Обучение при стажировке</a></li>
                <li><a href="{{ route('manager-training') }}">&gt;&nbsp;Обучение для менеджера</a></li>
                <li><a href="{{ route('leadership-training') }}">&gt;&nbsp;Обучение для руководителей</a></li>
                <li><a href="{{ route('private') }}">&gt;&nbsp;Закрытая часть</a></li>
            </ul>
        </li>
        <li><a href="#">Архив и Статистика</a></li>
    </ul>
</div>