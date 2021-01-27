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
                   @if($model->status == 0)
                <div class="alert col-md-12 alert-danger">
                    پرداخت نا موفق
                </div>
                @elseif($model->status == 1)
                <div class="alert col-md-12 alert-success">
                    پرداخت موفقیت آمیز
                </div>
                @elseif($model->status == 2)
                <div class="alert col-md-12 alert-danger">
                    چنین تراکنشی وجود ندارد
                </div>
                @endif

            <div class="col-md-12 border py-2">
                مبلغ:  {{ number_format($model->price) }} تومان
            </div>
            <div class="col-md-12 border py-2">
                کد تراکنش: {{ ltrim($model->transactionCode,0) }}
            </div>
            <div class="col-md-12 border py-2">

            </div>
            <div class="col-md-12 border py-2">
                <a href="{{ url('/request/'.$model->paymentBag->pay->request_id.'/userClinic') }}">بازگشت به فاکتور</a> 
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection