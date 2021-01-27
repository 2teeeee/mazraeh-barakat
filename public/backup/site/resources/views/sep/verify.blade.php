@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>
                    فاکتور پرداخت وجه
                    </h4>
                </div>

                <div class="card-body">
                   @if($status == 0)
                <div class="alert col-md-12 alert-danger">
                    {{ $message }} 
                </div>
                @elseif($pay->status == 1)
                    <div class="alert col-md-12 alert-success">
                        {{ $message }}                    
                    </div>
                    <div class="col-md-12 border py-2">
                        مبلغ:  {{ number_format($pay->price) }} تومان
                    </div>
                    <div class="col-md-12 border py-2">
                        کد تراکنش: {{ ltrim($pay->transactionCode,0) }}
                    </div>
                    <div class="col-md-12 border py-2">
                        برای مشاهده و چاپ حواله های خود به صفحه <a href="{{ url('koodReq/list') }}"><strong>درخواست های داده شده</strong></a> مراجعه کنید.
                    </div>
                @endif

                <div class="alert alert-info col-md-12">
                    <div>لطفأ برای درخواست سهمیه دیگر محصولات خود به صفحه اصلی سامانه برگردید و درخواست خود را ثبت نمایید.</div>
                    <a href="{{ url('profile/index.html') }}">بازگشت به صفحه اصلی</a> 
                </div>
            
            </div>
        </div>
    </div>
</div>
    
@endsection