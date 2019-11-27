@extends('layouts.app')
@section('content')
    <div class="content_title">Статистика по источникам</div>
    <table class="table table-bordered">
        <thead>
        <th>Список источников</th>
        <th>за сегодня</th>
        <th>за вчера</th>
        <th>за неделю</th>
        <th>за месяц</th>
        </thead>
        <tbody>
        @foreach($arrs as $name=>$arr)
            @php
                $today = (isset($arr['today'])) ? $arr['today'] : 0;
                $yesterday = (isset($arr['yesterday'])) ? $arr['yesterday'] : 0;
                $week = (isset($arr['week'])) ? $arr['week'] : 0;
                $month = (isset($arr['month'])) ? $arr['month'] : 0;
            @endphp
            <tr>
                <td>
                    {{ $name }}
                </td>
                <td>{{ $today }}</td>
                <td>{{ $yesterday }}</td>
                <td>{{ $week }}</td>
                <td>{{ $month }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop