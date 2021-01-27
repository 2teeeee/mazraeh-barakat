@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 my-5 p-0">
            <div class="card border-danger">
                <div class="card-header text-white bg-danger text-center">
                    <h4>
                    </h4>
                </div>
                    @if (Session::has('message'))
                    <div class="card-body"> 
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    </div>
                    @endif
                <div class="card-body">
                    طبق برنامه تعیین شده از طرف جهاد کشاورزی شهرستان {{ $city }} در این تاریخ برای مزارع {{ $product }} {{ $ab }} نمی توان درخواست کود ثبت کرد.<br/>
                    توزیع کود سری جدید در "اپلیکیشن مزرعه برکت" متعاقبا اعلام میگردد.
                    <br/><br/>
                    <a href="{{ url('/') }}" class="btn btn-info" >بازگشت به صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection