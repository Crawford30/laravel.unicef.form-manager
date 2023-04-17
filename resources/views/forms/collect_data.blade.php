@extends('layouts.app_else')
@section('content')
    <div class="w-100 p-3">
        <collect-form-data formid = "{{ $id }}" user="{{ json_encode(auth()->user()) }}"></collect-form-data>
    </div>
@stop