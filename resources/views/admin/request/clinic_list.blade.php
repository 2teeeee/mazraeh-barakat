@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')

@if($model == null)
        <div class="alert alert-info">درخواست با موفقیت ثبت شده است. تا ثبت نسخه توسط کلینیک ها صبر کنید.</div>
@endif

<div class="col-sm-12">
    <?php $key = 0; ?>
    @foreach($model as $key => $card)
        @if(($key % 3) == 0)
            <div class="row">
        @endif
        
        <div class="card col-md-12">
<!--            <img class="card-img-top p-5" src="{{ asset('image/icon/leaf.png') }}" alt="{{ $card->title }}">-->
            <div class="card-body row">
                <div class="col-md-9">
                <strong class="card-title">درخواست رفع آفت شماره {{ $card->id }}</strong>
                <p class="card-text">{{ jdate($card->created_at)->format('%Y/%m/%d ساعت: H:i:s ') }}</p>
                </div>
                <div class="col-md-3">
                    @if($card->status == 5)
                        <a href="{{ url('request/clinicView/'.$card->id) }}" class="btn btn-success col-12">
                            <i class="fas fa-pencil-alt"></i>
                            {{ trans('validation.attributes.write_noskhe') }}
                        </a>
                    @else 
                        <a href="{{ url('request/clinicView/'.$card->id) }}" class="btn btn-primary col-12">
                            <i class="fas fa-eye"></i>
                            {{ trans('validation.attributes.viewRequest') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        @if(($key % 3) == 2)
            </div>
        @endif
    @endforeach
    @if($key != 2)
        </div>
    @endif
</div>
@stop
