@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="col-12 bg-info rounded p-2 font-light font-weight-bold">
        کارگزار
    </div>
    <div class="row">
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('kargozar/new') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/paper-clip.png') }}" alt="" style="width:100%;" />
                {{ __('validation.attributes.new_pahne_request') }}
            </a>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('kargozar/list') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/folder.png') }}" alt="" style="width:100%;" />
                کارگزاری شما
            </a>
        </div>
    </div>
    
</div>
@stop
