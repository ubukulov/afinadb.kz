@extends('layouts.app')
@section('content')
    <div class="content_title">Результаты тестирование по тему - {{ $test->title }}</div>

    @php
        $count_all = count($test->questions);
    @endphp
    <table class="table table-striped mt-4">
        <thead>
        <tr>
            <th>#</th>
            <th>Пользователь</th>
            <th>Правильные</th>
            <th>Неправильные</th>
            <th>Общее</th>
            <th>Оценка</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
            @foreach($result as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['user'] }}</td>
                    <td>{{ $item['r_cnt'] }}</td>
                    <td>{{ $item['c_cnt'] }}</td>
                    <td>{{ $count_all }}</td>
                    <td>{{ $item['r_cnt'] * 5 }} балл из {{ $count_all * 5 }}</td>
                    <td>{{ $item['dt'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop