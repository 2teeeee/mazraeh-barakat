@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="col-12 bg-info rounded p-2 font-light font-weight-bold">
        شرکت های  دفع آفت
    </div>
    <div class="row">
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('dafAfat/new') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/paper-clip.png') }}" alt="" style="width:100%;" />
                {{ __('validation.attributes.new_dafafat_request') }}
            </a>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('dafAfat/list') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/folder.png') }}" alt="" style="width:100%;" />
                شرکت دفع آفت من
            </a>
        </div>
        <?php /*
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer']))
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('dafAfat/create') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/clipboard.png') }}" alt="" style="width:100%;" />
                ثبت شرکت دفع آفت جدید
            </a>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('dafAfat/all') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/book.png') }}" alt="" style="width:100%;" />
                تمام شرکت های دفع آفت
            </a>
        </div>
        @endif
        */ ?>
    </div>
    
</div>
@stop
