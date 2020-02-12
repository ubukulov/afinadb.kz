@extends('layouts.app')
@section('content')
    <div class="content_title">Тестирование</div>
    <form action="{{ route('test.store') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="text" name="test_title" class="form-control" required placeholder="Наименование теста">
        </div>

        <hr>

        <input type="hidden" id="q_ite" value="1">

        <div class="row">
            <div class="col-md-4 question_block" data-id="1">
                <div class="form-group">
                    <label id="q_t">#1</label>
                    <input type="text" name="question[1]" required placeholder="Название вопроса" class="form-control">
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">A</label>
                            <div class="col-sm-11">
                                <input type="text" name="answer[1][]" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">B</label>
                            <div class="col-sm-11">
                                <input type="text" name="answer[1][]" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">C</label>
                            <div class="col-sm-11">
                                <input type="text" name="answer[1][]" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">D</label>
                            <div class="col-sm-11">
                                <input type="text" name="answer[1][]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group mt-4">
            <button type="button" class="btn btn-primary" onclick="cloneQuestion()">Добавить поле</button>
        </div>

        <hr>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Создать тест</button>
        </div>
    </form>
@stop