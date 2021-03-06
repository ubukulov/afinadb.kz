@extends('layouts.app')
@section('content')
    <div class="content_title">Обучение для Руководителей</div>
    <div class="block">
        <div class="block_title">Закрытая часть для Руководителей</div>
        <div class="block_content">
            <div class="bc_title">Работа с файлом График дежурств</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/GQoXJaD2M8U">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Работа с файлами Движение Денежных Средств (ДДС), Текущий Баланс</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/CcbqAC5sfWs">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Начисление заработной платы</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/BRFfR9xAi8c">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Инструкция по приёму на работу</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/49vqy53EbOQ">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Ведение файла Кадровый учёт</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/OEAtSYklxMw">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Ведение файла Отзывы клиентов</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/Ll5dMSf7taM">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Анализ звонков. Ошибки</div>
            <a href="/sources/Анализ звонков.Ошибки..xlsx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Летучка</div>
            <a href="/sources/Летучка.xlsx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Чек-лист анализа звонков менеджеров СЕТЬ</div>
            <a href="/sources/Чек-лист анализа звонков менеджеров СЕТЬ.xlsx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Правила и стандарты работы офиса</div>
            <a href="/sources/Правила и стандарты работы офиса.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Турист в офисе</div>
            <a href="/sources/Турист в офисе.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
		<div class="block_content">
            <div class="bc_title">Как работать с клиентами из другого города</div>
            <a href="/sources/Как работать с клиентами из другого города.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Вопросы бинотел</div>
            <a href="/sources/вопросы бинотел.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Договор Трудовой</div>
            <a href="/sources/Договор Трудовой.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Допик на инфошник</div>
            <a href="/sources/допик на инфошник.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Шаблон доверенность</div>
            <a href="/sources/Шаблон доверенность.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Договор на корпоративное обслуживание чистый</div>
            <a href="/sources/files/Договор_на_корпоративное_обслуживание_чистый.doc" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Памятка ДЛЯ ПАРТНЕРА Евразийский</div>
            <a href="/sources/files/Памятка_ДЛЯ_ПАРТНЕРА_Евразийский.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Рассрочка от Банк Хоум Кредит для Алматы</div>
            <a href="/sources/files/Рассрочка_от_Банк_Хоум_Кредит_для_Алматы.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Рассрочка от Каспи памятка</div>
            <a href="/sources/files/Рассрочка_от_Каспи_памятка.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
    </div>

    <div class="block">
        <div class="block_title">Бухгалтерия</div>
        <div class="block_content">
            <div class="bc_title">МРП для исчисления ИПН с 1 апреля 2020 года </div>
            <a href="/sources/files/bux/МРП для исчисления ИПН с 1 апреля 2020 года .docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Презентация - оплата и возвраты</div>
            <a href="/sources/files/bux/Презентация - оплата и возвраты.pptx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Презентация режим налогообложения</div>
            <a href="/sources/files/bux/Презентация режим налогообложения.pptx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Ставки налогов и социальных платежей в 2020 году.</div>
            <a href="/sources/files/bux/Ставки налогов и социальных платежей в 2020 году..docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Ставки налогов и социальных платежей в 2020 году.</div>
            <a href="/sources/files/bux/ТОО общеустановленный режим налогообложения особенности ведения.docx" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Презентация Режим налогообложения</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/Q03f6E0P18A">Смотреть</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Презентация оплаты и возвраты</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this)" data-video="https://www.youtube.com/embed/sWFXqBOHJY0">Смотреть</div>
        </div>
    </div>
@stop
