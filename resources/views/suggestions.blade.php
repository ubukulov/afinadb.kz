@extends('layouts.app')
@section('content')
    <div class="content_title">Рекомендуемые отели</div>

    <div class="block">
        <div class="block_title">Отели</div>
        <div class="block_content">
            <div class="bc_title">Рекомендованные отели №1:</div>
            <a href="/sources/рекомендованные  отели .xlsx" target="_blank">
                <div class="b_download_btn">Скачать</div>
            </a>
        </div>
        <div class="block_content">
            <div class="bc_title">Иностранные партнеры:</div>
            <a href="/sources/Иностранные партнеры.xlsx" target="_blank">
                <div class="b_download_btn">Скачать</div>
            </a>
        </div>
    </div>
@stop