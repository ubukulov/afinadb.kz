@extends('layouts.app')
@section('content')
    <div class="content_title">ЛИТЕРАТУРА ДЛЯ САМОСТОЯТЕЛЬНОГО РАЗВИТИЯ</div>
    <div class="block">
        <div class="block_title">Книги</div>
        <div class="block_content">
            <div class="bc_title">Соколов Александр - "DAMNEDAМ или как продавать без скидок"</div>
            <a href="/sources/books/А.Соколов, DAMNEDAM или как продавать без скидок в туризме.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
		<div class="block_content">
            <div class="bc_title">Максим Батырев - "45 татуировок продавана"</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this);" data-video="https://www.youtube.com/embed/h1RFdrH-ChU">Слушать</div>
        </div>
        <div class="block_content">
            <div class="bc_title">Максим Батырев - "45 татуировок продавана"</div>
            <a href="/sources/books/Batyirev_M._45_Tatuirovok_Prodavana.a6.pdf" target="_blank"><div class="b_download_btn">Скачать</div></a>
        </div>
        <div class="block_content">
            <div class="bc_title">Продай или продадут тебе Грант Кардон</div>
            <div class="b_download_btn" onclick="return showVideoYoutube(this);" data-video="https://www.youtube.com/embed/HcKncnkJRjM">Слушать</div>
        </div>
    </div>
@stop