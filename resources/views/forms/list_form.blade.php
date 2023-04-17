@extends('layouts.app')
@section('content')
<div class="w-100 p-3">
    <form-list :user='{{ json_encode(auth()->user()) }}'></form-list>
</div>

@stop
