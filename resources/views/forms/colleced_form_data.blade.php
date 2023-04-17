@extends('layouts.app')
@section('content')
<div class="w-100 p-3">
    <collected-form-data
        :form="{{ json_encode($form) }}"
        :users="{{ json_encode($users) }}"
        :user='{{ json_encode(auth()->user()) }}' />
</div>

@stop