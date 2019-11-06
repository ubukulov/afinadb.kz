@extends('layouts.app')
@section('content')
    <keep-alive>
    <account v-bind:cities="{{ json_encode($cities) }}" v-bind:companies="{{ json_encode($companies) }}"></account>
    </keep-alive>
@stop