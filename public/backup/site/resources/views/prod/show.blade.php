
    @extends('layouts.content')

@section('title', 'نمایش دسترسی ها')

@section('content')

<div id='sfLeft' class="col-sm-3">
    <div class="col-sm-12">
        @include("product.catListSide")
        @include("product.cartSide")
    </div>
</div>
<div class="col-sm-9" >
    <div class="col-sm-12 prod-box">
        <div class="col-sm-4">
            <img src="{{ asset('images/'.$model->image) }}" style="width:100%" />
        </div>
        <div class="col-sm-8">
            <h3>{{ $model->title }}</h3>
            <hr/>
            <p>
                <strong>رنگ: </strong>
                <span>{{ $model->color }}</span>
                <br/>
                <strong>دسته:</strong>
                <span><a href="{{ url('product/list/'.$model->cat_id) }}">{{ $model->cat?$model->cat->title:'' }}</a></span>
                <br/>
                <strong>قیمت: </strong>
                <span>{{ $model->price }} تومان</span>
            </p>
            <div class="row">
                <a href="{{ url('product/addCard/'.$model->id.'/1') }}" class="btn btn-success">
                    <i class="fa fa-shopping-cart"></i>
                    اضافه کردن به سبد خرید
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 prod-box">
        <div class="col-sm-12">
            <p>
                {!!html_entity_decode($model->tozih)!!}
            </p>

        </div>
    </div>
    <div class="col-sm-12 prod-box">
        <div class="col-sm-12">
            <h5>پرینترهای مرتبط:</h5>
            <p>
                {{ $model->printerType }}
            </p>
        </div>
    </div>
</div>

@stop