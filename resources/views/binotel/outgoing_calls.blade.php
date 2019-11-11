@extends('layouts.app')
@section('content')
    <div class="content_title">Исходящие звонки</div>
    <table class="table table-striped">
        <thead>
        <th>вн.номер</th>
        <th>Номер клиента</th>
        <th>Сотрудник</th>
        <th>Длительность разговора</th>
        <th>Состояние звонка</th>
        </thead>
        <tbody>
        @foreach($all_calls_per_day as $item)
            @if($item['callType'] == 1)
                <tr>
                    <td>{{ $item['internalNumber'] }}</td>
                    <td>{{ $item['externalNumber'] }}</td>
                    <td>{{ $item['employeeName'] }}</td>
                    <td>{{ abs($item['billsec']) }}&nbsp;сек.</td>
                    <td>{{ $disposition[$item['disposition']] }}</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@stop