@extends('layouts.app')
@section('content')
    <div class="content_title">Массовая рассылка</div>

    <form action="{{ route('bulk.mailing.send') }}" method="post">
        @csrf
        <div class="form-group">
            <label>Список контактов</label>
            <select name="contact_id" class="form-control">
                <option value="0">Все</option>
                @foreach($contacts->all() as $contact)
                    @if(empty($contact->name))
                    <option value="{{$contact->id}}">Нет имени</option>
                    @else
                    <option value="{{$contact->id}}">{{ $contact->name }} {{ ($contact->id) }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Сообщение</label>
            <textarea name="message" required class="form-control" cols="30" rows="4"></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Отправить</button>
        </div>
    </form>
@stop
