@extends('layouts.app')
@section('content')
    <div class="content_title">Результаты тестирование по тему - {{ $test->title }}</div>
    <div class="text-center">
        <div class="mb-3">
            <i class="fas fa-check-circle" style="font-size: 60px; color: green;"></i>
        </div>
        <h4>Тест закончился!</h4>
    </div>

    @php
        $cnt_r = count($count_right_answers);
        $cnt_w = count($count_wrong_answers);
        $cnt_all = count($count_all_questions);
    @endphp

    <div class="row mt-5">

        <div class="col-md-3">
            <strong>Количество вопросов:</strong> {{ $cnt_all }}
        </div>

        <div class="col-md-3">
            <strong>Правильные ответы:</strong> {{ $cnt_r }}
        </div>

        <div class="col-md-3">
            <strong>Неправильные ответы:</strong> {{ $cnt_w }}
        </div>

        <div class="col-md-3">
            <strong>Не отвечено:</strong> {{ $cnt_all - ($cnt_r + $cnt_w) }}
        </div>
    </div>
@stop