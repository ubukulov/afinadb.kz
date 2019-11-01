@extends('layouts.app')
@section('content')
    <call-center-leads
            v-bind:cities="{{ json_encode($cities) }}"
            v-bind:companies="{{ json_encode($companies) }}"
            v-bind:source-list="{{ json_encode($source_list) }}">
    </call-center-leads>
@stop