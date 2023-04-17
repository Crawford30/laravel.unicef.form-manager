@extends('layouts.app')

@section('content')
    <div class="w-100 p-3">
        @if(in_array('forms', auth()->user()->permissions))
            @if($forms > 0)
                <Dashboard 
                    stats="{{ json_encode($dataStats) }}"
                    records="{{ json_encode($records) }}"
                    assignments="{{ json_encode($assignments) }}"
                    forms="{{ $forms }}" 
                    users="{{ $users }}" 
                    data="{{ $data }}">
                </Dashboard>
            @else
                <DashboardNoFormsCreated></DashboardNoFormsCreated>
            @endif
        @else
            @if($forms > 0)
                <DashboardNoPermission 
                    timeline="{{ json_encode($timeline) }}"
                    stats="{{ json_encode($dataStats) }}"
                    forms="{{ $forms }}" 
                    users="{{ $users }}" 
                    data="{{ $data }}">
                </DashboardNoPermission>
            @else
                <DashboardNoFormsAssigned></DashboardNoFormsAssigned>
            @endif
        @endif
    </div
@stop