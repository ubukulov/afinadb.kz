@extends('layouts.app')
@section('content')
    <div class="content_title">Пропущенные звонки</div>
    <table class="table table-striped">
        <thead>
        <th>Дата</th>
        <th>вн.номер</th>
        <th>Номер клиента</th>
        <th>Ожидание до соединения</th>
        <th>Состояние звонка</th>
        <th>Тип</th>
        </thead>
        <tbody>
        @foreach($missing_calls as $item)
            <tr>
                <td>{{ date("d.m.Y H:i", $item['startTime']) }}</td>
                <td>{{ $item['internalNumber'] }}</td>
                <td>{{ $item['externalNumber'] }}</td>
                <td>{{ $item['waitsec'] }}&nbsp;сек.</td>
                <td>{{ $disposition[$item['disposition']] }}</td>
                <td>
                    @if($item['isNewCall'] == 1)
                        Новый входящий звонок
                    @else
                        Звонил ранее
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop