@extends('layouts.app')
@section('content')
    <div class="content_title">Обучение при Стажировке</div>

    @include('partials.sales_standarts')

    <div class="block">
        <div class="block_title">Бронирование АВИА и ЖД</div>
        <div class="block_content">
            <div class="bc_title">Презентация IATI:</div>
            <a href="/sources/Презентация IATI.pptx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Начало работы в системе IATI</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/gOxjWFWLF24">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Видео инструкция по авиа в STF Agent</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/CkAE_4o3Mw8">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Сантуфей:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/7prJqwWP5no">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Тикетс ЖД:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/p39z64W3HmQ">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Трансавиа:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/CjFO_vNmH_c">Смотреть</div>
        </div>
    </div>
    <div class="block">
        <div class="block_title">Стажировка</div>

        <div class="block_content">
            <div class="bc_title">Общие принципы работы менеджера с туристическим оператором:</div>
            <a href="/sources/files/Общие принципы работы менеджера с туристическим оператором (2).docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Отдел Бронирования ТО и поддержка Агентств:</div>
            <a href="/sources/Отдел Бронирования ТО и поддержка Агентств.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
    </div>
    <div class="block">
        <div class="block_title">Куделько</div>

        <div class="block_content">
            <div class="bc_title">День 1: Технология продажи туров. Часть 1</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/8JO3Yy9KfzU">Смотреть</div>
        </div>

        <div class="block_content">
            <div class="bc_title">День 2: Технология продажи туров. Часть 2</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/E53mtA_oi_Y">Смотреть</div>
        </div>

        <div class="block_content">
            <div class="bc_title">День 3: Работа с возражениями туристов</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/LXbhNeadY3Y">Смотреть</div>
        </div>

        <div class="block_content">
            <div class="bc_title">День 4: Инструменты эффективного продавца</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/ppozAj5QF9g">Смотреть</div>
        </div>

        <div class="block_content">
            <div class="bc_title">День 5: Как доводить каждую сделку до результата</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/Mbta-LdnyE0">Смотреть</div>
        </div>
		
		<div class="block_content">
            <div class="bc_title">Как перестать консультировать и начать продавать туры массово</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/RLx_Z0YGu4Y">Смотреть</div>
        </div>
    </div>
    <div class="block">
        <div class="block_title">Изучение СРМ системы U-ON travel</div>
        <div class="block_content">
            <div class="bc_title">Бонусная программа для туристов:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/MF5QG0TAGM0">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">создание заявки и обращения в ЮОНЕ ДЖОКСИ:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/0IIwDuwtGYk">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Вебинар для новичков</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/An9oGdJOAcY">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Создание заявки</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/fyqJTbSTH2w">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Создание обращения</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/nmn4ANzkEr8">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Создание туриста</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/9uhKPgb0s6I">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Видео #5:</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/nO81fyQBTZw">Смотреть</div>
        </div>
    </div>
    <div class="block">
        <div class="block_title">Стандарты обслуживания клиентов</div>
        <div class="block_content">
            <div class="bc_title">Должностная Инструкция Менеджера Чемодан:</div>
            <a href="/sources/Должностная Инструкция Менеджера Чемодан.rtf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">спец -задание:</div>
            <a href="/sources/спец -задание.rtf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
    </div>
    <div class="block">
        <div class="block_title">Ступеньки роста менеджера</div>
        <div class="block_content">
            <div class="bc_title">Портрет идеального менеджера:</div>
            <a href="/sources/портрет идеального менеджера.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Ступеньки роста менеджера:</div>
            <a href="/sources/Ступеньки роста менеджера.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
    </div>
@stop