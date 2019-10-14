@extends('layouts.app')
@section('content')

    <table class="table leads_table table-bordered table-striped">
        <thead class="thead-light">
            <th width="100">Дата</th>
            <th width="100">Имя</th>
            <th width="150">Тел</th>
            <th>Источник</th>
            <th width="100">Комментарии</th>
            <th>Подтверждение</th>
            <th>Компания</th>
        </thead>
        <tbody>
            @foreach($leads as $lead)
            <tr>
                <td>{{ timeCount($lead->tm) . " #".$lead->id }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->phone }}</td>
                <td>{{ $source_list[$lead->type] }}</td>
                <td>{{ $lead->comment }}</td>
                <td>
                    @if($lead->m_type == '0')
                        <div class="status_btn">
                            <div>{{ $lead->name." ".$lead->last_name }}</div>
                            <div class="_completed"></div>
                        </div>
                    @endif

                    @if($lead->m_type == '2')
                        <div class="status_btn">
                            <div>{{ $lead->name." ".$lead->last_name }}</div>
                            <div class="_canceled"></div>
                        </div>
                    @endif

                    @if($lead->m_type == '1')
                        <div class="status_btn">
                            <div>{{ $lead->name." ".$lead->last_name }}</div>
                            <div class="_processed"></div>
                        </div>
                    @endif

                    @if($lead->isNew())
                        <button type="button" class="btn btn-primary">Выбрать Менеджера</button>
                    @endif
                </td>
                <td class="@if($lead->company == 0) chem @else _257 @endif">
                    @if($lead->company == 0) chemodan.kz @endif
                    @if($lead->company == 1) 257.kz @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $leads->links() }}
@stop