@extends('layouts.app')
@section('content')
    <div class="content_title">Тестирование по тему - {{ $test->title }}</div>
    <form action="{{ route('test.end', ['id' => $test->id]) }}" method="post">
        @csrf
        <div class="row">
            @foreach($questions as $question)
            <div class="col-md-6 question_block">
                <div class="form-group">
                    <label id="q_t">#{{ $loop->iteration }}</label>
                    <span>{{ $question->title }}</span>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        @foreach($question->answers->shuffle() as $answer)
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label"></label>
                            <div class="col-sm-11">
                                <label><input type="radio" name="answer[{{ $question->id }}][]" value="{{ $answer->id }}" class="form-horizontal">&nbsp;{{ $answer->title }}</label>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <hr>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Завершить тест</button>
        </div>
    </form>
@stop