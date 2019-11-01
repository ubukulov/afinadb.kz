@extends('layouts.app')
@section('content')
    <account v-bind:cities="{{ json_encode($cities) }}" v-bind:companies="{{ json_encode($companies) }}"></account>
@stop