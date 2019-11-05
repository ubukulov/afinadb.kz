@extends('layouts.app')
@section('content')
    <director-leads v-bind:source-list="{{ json_encode($source_list) }}">

    </director-leads>
@stop