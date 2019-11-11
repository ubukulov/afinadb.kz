@extends('layouts.app')
@section('content')
    <div class="content_title">Начальное обучение</div>
    <div class="block">
        <div class="block_title">Введение в туризм</div>
        <div class="block_content">
            <div class="bc_title">Основы туризма</div>
            <a href="/sources/files/Введение_в_Туризм.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Выезд туристов за рубеж/запрет на выезд</div>
            <a href="/sources/files/Выезд_туристов_зарубеж_(запрет)_на_выезд.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <i class="fa fa-re"></i>
        <div class="block_content">
            <div class="bc_title">Основные понятия в туризме:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/jBLOKdZPfrA">Смотреть</div>
        </div>
    </div>
    <div class="content_title">Знание направлений</div>
    <div class="block">
        <div class="block_title">Знание основных направлений</div>
        <div class="block_title attention">ВНИМАНИЕ!!! Смотрите самостоятельно дополнительную информацию по направлениям! В тестах будут вопросы которых нет в видеоуроках.  Например: время перелетов, разница по времени с Астаной, из каких городов Казахстана есть вылеты по направлениям, или священный месяц в ОАЭ и т.д.</div>
        <!--<div class="block_content">
            <div class="bc_title">Турция:</div>
            <div class="b_download_btn">Скачать</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Анталийское побержье:</div>
            <div class="b_download_btn">Скачать</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Эгейское побережье:</div>
            <div class="b_download_btn">Скачать</div>
        </div>-->
        <div class="block_content">
            <div class="bc_title">Турция</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/kv0L5SS2J5U">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">ОАЭ # 1:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/mDg9efQVlYM">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">ОАЭ # 2:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/X2AxXBY-c6E">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Египет:</div>
            <div class="b_download_btn" onclick="return showVideo(this)" data-video="/sources/Египет с Kazunion..mp4">Смотреть</div>
        </div>
    </div>
    <div class="content_title">Продажи</div>
    <div class="block">
        <div class="block_title">Знание и понимание основных этапов продаж и стандартов сети.</div>
        <div class="block_content">
            <div class="bc_title">ANEX TOUR: ТЕХНОЛОГИЯ ПРОДАЖ:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/2FI6zFrDazI">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">ANEX TOUR: работа с претензиями</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/DYNhab_3hCs">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Стандарты работы Чемодан</div>
            <a href="/sources/files/Стандарты_работы.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Правила и стандарты работы офиса</div>
            <a href="/sources/files/Правила_и_стандарты_работы_офиса.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Турист в офисе</div>
            <a href="/sources/files/Турист_в_офисе.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_title">Телефонные разговоры</div>
        <div class="content_title">Хорошие звонки</div>
        <div class="block_content" style="display: none;">
            <div class="bc_title">Пример №1</div>
            <div class="b_download_btn"><audio src="/audio/w-1.wav" controls=""></audio></div>
        </div>
        <div class="block_content">
            <div class="bc_title">Пример №1</div>
            <div class="b_download_btn"><audio src="/audio/w-2.wav" controls=""></audio></div>
        </div>
        <div class="content_title">Плохой звонок</div>
        <div class="block_content">
            <div class="bc_title">Пример №1</div>
            <div class="b_download_btn"><audio src="/audio/w-3.wav" controls=""></audio></div>
        </div>
    </div>
    <div class="content_title">Поиск тура</div>
    <div class="block">
        <div class="block_title">Алгоритм подбора тура. Знакомство с поиском туров.</div>
        <div class="block_content">
            <div class="bc_title">Азы подбора тура КЗ:</div>
            <div class="b_download_btn" onclick="return showVideo(this)" data-video="/sources/Азы подбора тура КЗ.mp4">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Онлайн подбор тура:</div>
            <a href="/sources/Онлайн подбор тура.png" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_title">Задания</div>
        <div class="block_content">
            <div class="bc_title">Задание по подбору тура в ОАЭ и Китай(КЗ)</div>
            <a href="/sources/Задание по подбору тура в ОАЭ и Китай(КЗ).docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Пример письменнои_ презентации (КЗ)</div>
            <a href="/sources/Пример письменнои_ презентации.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_title">Часто задаваемые вопросы при выполнении задания</div>
        <div class="block_content">
            <div class="bc_title">Часто задаваемые вопросы</div>
            <a href="/sources/Часто_задаваемые_вопросы_при_выполнении_задани_по_подбору.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
    </div>
    <div class="content_title">Договорные отношения</div>
    <div class="block">
        <div class="block_title">Знание договора с туристом. Методы решения конфликтных ситуаций.</div>
        <div class="block_content">
            <div class="bc_title">Договорные отношения с туристами:</div>
            <a href="/sources/files/Договорные_отношени_с_туристами_(КЗ).doc" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Как предотвратить рекламацию (претензию) туриста и как работать с ней:</div>
            <a href="/sources/Пордок подачи рекламации_ (КЗ).doc" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
    </div>
@stop