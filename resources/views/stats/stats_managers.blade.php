@extends('layouts.app')
@section('content')
    <div class="content_title">Статистика менеджеров</div>
    <table class="table table-bordered">
        <thead>
        <th>ФИО</th>
        <th>Компания</th>
        <th>Город</th>
        <th>Обработано</th>
        <th>Отказы</th>
        <th>В процессе</th>
        </thead>
        <tbody>
        @foreach($manager_leads as $manager_lead)
        <tr>
            <td>
                {{ $manager_lead->fio }}
            </td>
            <td>{{ $manager_lead->com_title }}</td>
            <td>{{ $manager_lead->city }}</td>
            <td>{{ $manager_lead->suc }}</td>
            <td>{{ $manager_lead->can }}</td>
            <td>{{ $manager_lead->pro }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@stop