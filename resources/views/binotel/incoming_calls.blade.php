@extends('layouts.app')
@section('content')
    <div class="content_title">Входящие звонки</div>
    <table class="table table-striped">
        <thead>
        <th>Дата</th>
        <th>вн.номер</th>
        <th>Номер клиента</th>
        <th>Сотрудник</th>
        <th>Длительность разговора</th>
        <th>Состояние звонка</th>
        <th>Тип</th>
        </thead>
        <tbody>
        @foreach($all_calls_per_day as $item)
            @if($item['callType'] == 0)
                <tr>
                    <td>{{ date("d.m.Y H:i", $item['startTime']) }}</td>
                    <td>{{ $item['internalNumber'] }}</td>
                    <td>{{ $item['externalNumber'] }}</td>
                    <td>{{ $item['employeeName'] }}</td>
                    <td>{{ abs($item['billsec']) }}&nbsp;сек.</td>
                    <td>{{ $disposition[$item['disposition']] }}</td>
                    <td>
                        @if($item['isNewCall'] == 0)
                            новый входящий звонок
                        @else
                            звонил ранее
                        @endif
                    </td>
                </tr>
        @endif
        @endforeach
        </tbody>
    </table>
@stop