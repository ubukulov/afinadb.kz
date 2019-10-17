@extends('layouts.app')
@section('content')
    <div class="content_title">
        Учетные записи менеджеров

        <button class="btn btn-primary"><i class="fas phpdebugbar-fa-edit"></i>&nbsp;Добавить учетную запись</button>
    </div>
    <table class="table leads_table table-bordered table-striped">
        <thead class="thead-light">
            <th width="100">#ID</th>
            <th width="100">Логин</th>
            <th width="150">Пароль</th>
            <th width="150">ФИО</th>
            <th width="150">Роль в системе</th>
            <th>Компания</th>
            <th>Действие</th>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->password }}</td>
                <td>{{ $user->name." ".$user->last_name }}</td>
                <td>{{ $user->status }}</td>
                <td class="@if($user->company == 0) chem @else _257 @endif">
                    @if($user->company == 0) chemodan.kz @endif
                    @if($user->company == 1) 257.kz @endif
                </td>
                <td class="accounts_btn">
                    <button type="button"><i class="fas fa-edit"></i></button>
                    <button type="button"><i class="fas fa-power-off"></i></button>
                    <button type="button"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@stop