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
                   @if($pay->status == 0)
                <div class="alert col-md-12 alert-danger">
                    پرداخت نا موفق
                    <br/>
                    <div>لطفأ برای درخواست سهمیه دیگر محصولات خود به صفحه اصلی سامانه برگردید و درخواست خود را ثبت نمایید.</div>
                    <a href="{{ url('profile/index.html') }}">بازگشت به صفحه خانه</a> 
                </div>
                @elseif($pay->status == 1)
                <div class="alert col-md-12 alert-success">
                    پرداخت موفقیت آمیز
                <br/>
                    <div>لطفأ برای درخواست سهمیه دیگر محصولات خود به صفحه اصلی سامانه برگردید و درخواست خود را ثبت نمایید.</div>
                    <a href="{{ url('profile/index.html') }}">بازگشت به صفحه خانه</a> 
                </div>
                @elseif($pay->status == 2)
                <div class="alert col-md-12 alert-danger">
                    چنین تراکنشی وجود ندارد
                <br/>
                    <div>لطفأ برای درخواست سهمیه دیگر محصولات خود به صفحه اصلی سامانه برگردید و درخواست خود را ثبت نمایید.</div>
                    <a href="{{ url('profile/index.html') }}">بازگشت به صفحه خانه</a> 
                </div>
                @endif

            <div class="col-md-12 border py-2">
                مبلغ:  {{ number_format($pay->price) }} ریال
            </div>
            <div class="col-md-12 border py-2">
                کد تراکنش: {{ ltrim($pay->transactionCode,0) }}
            </div>
            <div class="col-md-12 border py-2">
                @if($model)
                @if($model->status == 1)
                <div class="card-body" id="text">
                    <div class="text-center">بسمه تعالی</div><br/>
                    <div class="h4 text-center">حواله توزیع کود {{ $model->kood->title }}</div><br/>
                    <div class="text-left">
                        کد : {{ $model->code }}
                        <br/>
                        تاریخ: {{ jdate($model->created_at)->format("Y/m/d") }}
                    </div><br/>                    <div>
                       کارگزار محترم آقای / خانم {{ $model->broker->name }} 
                    </div><br/>
                    <div>با سلام</div><br/>
                    <div>
                        <span>بدینوسیله آقای/خانم </span>
                        <span>{{ $model->user->name }} </span> 
                        <span>با کد ملی </span>
                        <span>{{ $model->user->codemelli }} </span>
                        <span>با سطح زیر کشت </span>
                        <span>{{ $model->kesht->square }} هکتار محصول زراعی {{ $model->kesht->product->title }} </span>
                        <span>و شماره تماس </span>
                        <span>{{ $model->user->mobile }} </span>
                        <span>جهت دریافت</span>
                        <span>{{ $model->value }}</span>
                        <span>کیسه 50 کیلویی کود </span>
                        <span>{{ $model->kood->title }}</span>
                        <span>به حضور معرفی می گردد.</span><br/><br/>
                        <span>لازم به ذکر است مشخصات نامبرده در لیست توزیع آن کارگزاری ثبت و اخذ اثر انگشت و امضاء الزامی می باشد.</span>
                        <span></span>
                        
                    </div>
                </div>
                <div class="card-body text-left">
                    <a href="#print" onclick="openWin()" class="btn btn-info" title="چاپ">
                        <i class="fas fa-print"></i>
                        پرینت
                    </a>
                </div>
                @endif
                @endif
            </div>

                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')
<script>
    function openWin()
    {
        var printContents = document.getElementById('text').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

@endsection