@extends('layouts.app')
@section('content')
    <div class="content_title">Тестирование</div>
    <a href="{{ route('test.create') }}" class="btn btn-success">Создать тест</a>

    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Количество вопросов</th>
                <th>Статус</th>
                <th>Дата</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tests as $test)
            <tr>
                <td>{{ $test->id }}</td>
                <td>{{ $test->title }}</td>
                <td>{{ count($test->questions) }}</td>
                <td>
                    @if($test->active == 1)
                        Активно
                    @else
                        Скрыто
                    @endif
                </td>
                <td>
                    {{ date('d.m.Y H:i:s', strtotime($test->created_at)) }}
                </td>
                <td>
                    @if($test->active == 1)
                        <a href="{{ route('test.start', ['id' => $test->id]) }}" class="btn btn-dark"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;Начать</a>
                    @endif
                        <a href="{{ route('test.statistics', ['id' => $test->id]) }}" class="btn btn-info"><i class="fas fa-align-justify"></i>&nbsp;Статистика</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


@stop