@extends('layouts.app')
@section('content')
<div class="w-100 p-3">
    <form-users 
        :records="{{ json_encode($records) }}"
        :assignments="{{ json_encode($assignments) }}"
        :forms="{{ $forms }}" 
        :users="{{ $users }}" 
        :data="{{ $data }}"
        :viewers="{{ $viewers }}"
        :section="{{ json_encode($section) }}"
        :user='{{ json_encode(auth()->user()) }}' />
</div>

@stop