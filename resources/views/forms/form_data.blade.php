@extends('layouts.app')
@section('content')
<div class="w-100 p-3">
    <form-data 
        :users="{{ $users }}" 
        :data="{{ $data }}"
        :viewers="{{ $viewers }}"
        :stats="{{ json_encode($stats) }}"
        :user='{{ json_encode(auth()->user()) }}' />
</div>

@stop