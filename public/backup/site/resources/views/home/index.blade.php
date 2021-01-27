@extends('layouts.main')

@section('content')

<div class="container">
    <h5 class="my-2">به مزرعه خوش آمدید</h5>
    <div class="card-header">
        محصولات
    </div>
    <div class="row">
        @foreach($model as $prod)
            <div class="card col-sm-6 col-md-3">
                <img class="card-img-top" style="height: 150px;" src="{{ asset('image/'.$prod->image) }}" alt="{{ $prod->title }}">
                <div class="card-body">
                    <h6 class="card-title">{{ $prod->title }}</h6>
                    <span class="font-bold">قیمت: {{ $prod->price }} تومان</span>
                    <p class="card-text">{{ $prod->comment }}</p>
                    <a href="{{ url('prod/addCard/'.$prod->id.'/1') }}" class="btn btn-primary col-12">اضافه به سبد خرید</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
    
@endsection