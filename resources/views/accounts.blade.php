@extends('layouts.app')
@section('content')
    <div class="content_title">
        Учетные записи менеджеров

        <button class="btn btn-primary"><i class="fas phpdebugbar-fa-edit"></i>Добавить учетную запись</button>
    </div>
    <table class="table leads_table table-bordered table-striped">
        <thead class="thead-light">
        <th width="100">#ID</th>
        <th width="100">Логин</th>
        <th width="150">Пароль</th>
        <th>ФИО</th>
        <th>Роль в системе</th>
        <th>Компания</th>
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
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@stop