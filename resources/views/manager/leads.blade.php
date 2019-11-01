@extends('layouts.app')
@section('content')
    <manager-lead-free
            v-bind:source-list="{{ json_encode($source_list) }}">
    </manager-lead-free>
@stop