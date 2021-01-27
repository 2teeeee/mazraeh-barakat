@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <div class="col-12 bg-info rounded p-2 font-light font-weight-bold">
        فروشگاه
    </div>
    <div class="row">
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('store/new') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/paper-clip.png') }}" alt="" style="width:100%;" />
                {{ __('validation.attributes.new_pahne_request') }}
            </a>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('store/list') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/folder.png') }}" alt="" style="width:100%;" />
                فروشگاه های من
            </a>
        </div>
        <?php /*
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer']))
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('store/create') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/clipboard.png') }}" alt="" style="width:100%;" />
                ثبت فروشگاه جدید
            </a>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <a href="{{ url('store/all') }}" class="btn btn-link">
                <img src="{{ asset('image/icon/book.png') }}" alt="" style="width:100%;" />
                تمام فروشگاه ها
            </a>
        </div>
        @endif 
        */ ?>
    </div>
    
</div>
@stop
