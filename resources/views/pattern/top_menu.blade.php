<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">
        @if(Auth::user()->type == 0)
        <img src="{{ asset('images/logo.png') }}" width="150" alt="">
        @else
        <img src="{{ asset('images/257.png') }}" width="150" alt="">
        @endif
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="user_info">
        <p><i class="fas fa-user"></i>&nbsp;{{ Auth::user()->getFullName()." | ".Auth::user()->status }} </p>
        <p><i class="fas fa-map-marker-alt"></i>&nbsp; {{ Auth::user()->city->title }}</p>
        @if(Auth::user()->status == 'CEO')
        <p><i class="fas fa-building"></i>&nbsp;CEO</p>
        @else
        <p><i class="fas fa-building"></i>&nbsp;{{ Auth::user()->company->title }}</p>
        @endif
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            {{--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Справка
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Инструкция</a>
                    <a class="dropdown-item" href="#">Статьи</a>
                </div>
            </li>--}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-align-justify"></i>&nbsp;Статистика
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('stats.leads') }}">Статистика запросов</a>
                    <a class="dropdown-item" href="{{ route('stats.managers') }}">Статистика менеджеров</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('stats.sources') }}">Статистика по источникам</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-phone"></i>&nbsp;Звонки
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('incoming.calls') }}">Входящие</a>
                    <a class="dropdown-item" href="{{ route('outgoing.calls') }}">Исходящие</a>
                    <a class="dropdown-item" href="{{ route('missing.calls') }}">Пропущенные звонки</a>
                </div>
            </li>
            {{--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Компаний
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">chemodan.kz</a>
                    <a class="dropdown-item" href="#">257.kz</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Контакты
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Мой дела
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>&nbsp;Выйти</a>
            </li>
        </ul>
    </div>
</nav>