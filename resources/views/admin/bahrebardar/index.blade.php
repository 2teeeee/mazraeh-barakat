@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="col-12 bg-info rounded p-2 font-light font-weight-bold">
        مکان فعالیت
    </div>
    <div class="row">
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','orchardist','planter','greenhouseOwner','ornamentalWork']))
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('bahrebardar/new') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/paper-clip.png') }}" alt="" style="width:100%;" />
                {{ __('validation.attributes.new_pahne_request') }}
            </a>
        </div>
        @endif
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','orchardist','planter','greenhouseOwner','ornamentalWork']))
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('bahrebardar/list') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/folder.png') }}" alt="" style="width:100%;" />
                مکان های من
            </a>
        </div>
        @endif
        <?php /*
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','agency']))
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('bahrebardar/create') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/clipboard.png') }}" alt="" style="width:100%;" />
                ثبت مکان جدید
            </a>
        </div>
        @endif
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','agency']))
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('bahrebardar/all') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/book.png') }}" alt="" style="width:100%;" />
                تمام مکان ها
            </a>
        </div>
        @endif
        
        */ ?>
    </div>
    
</div>
@stop
