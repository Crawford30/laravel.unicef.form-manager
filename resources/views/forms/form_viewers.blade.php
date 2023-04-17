@extends('layouts.app')
@section('content')
<div class="w-100 p-3">
    <form-viewers 
        :records="{{ json_encode($records) }}"
        :forms="{{ $forms }}" 
        :users="{{ $users }}" 
        :data="{{ $data }}"
        :viewers="{{ $viewers }}"
        :assignments="{{ json_encode($assignments) }}"
        :user='{{ json_encode(auth()->user()) }}' />
</div>

@stop