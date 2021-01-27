@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>
                    حواله توزیع کود {{ $model->kood->title }}
                    </h4>
                </div>

                <div class="card-body">
                   
<!--            <div class="col-md-12 border py-2">
                مبلغ:  {{ number_format($model->price_all) }} ریال
            </div>-->
            <div class="col-md-12 border py-2">
                <div class="card-body" id="text">
                    <div class="text-center">بسمه تعالی</div><br/>
                    <div class="h4 text-center">حواله توزیع کود {{ $model->kood->title }}</div><br/>
                    <div class="text-left">
                        کد : {{ $model->code }}
                        <br/>
                        تاریخ: {{ jdate($model->make_date)->format("Y/m/d") }}
                    </div><br/>
                    <div>
                       کارگزار محترم آقای / خانم {{ $model->broker->name }} 
                    </div><br/>
                    <div>با سلام</div><br/>
                    <div>
                        <span>بدینوسیله آقای/خانم </span>
                        <span><strong>{{ $model->user->name }}</strong> </span> 
                        <span>با کد ملی </span>
                        <span><strong>{{ $model->user->codemelli }}</strong> </span>
                        <span>با سطح زیر کشت </span>
                        <span><strong>{{ str_replace('.','/', $model->user->keshtProduct($model->product_id,$model->abType_id,$model->ct_id)->sum) }}</strong> هکتار محصول زراعی <strong>{{ $model->product->title }} {{ $model->ab?$model->ab->title:'' }}</strong> </span>
                        <span>و شماره تماس </span>
                        <span><strong>{{ $model->user->mobile }}</strong> </span>
                        <span>جهت دریافت</span>
                        <span><strong>{{ $model->value }}</strong></span>
                        <span>کیسه 50 کیلویی کود </span>
                        <span><strong>{{ $model->kood->title }}</strong></span>
                        <span>به حضور معرفی می گردد.</span><br/><br/>
                                 شایان ذکر است مبلغ واریزی جهت حواله فوق توسط ایشان <strong>{{ number_format($model->price_all) }} ریال</strong> می باشد و اعتبار این حواله و مهلت زمانی تحویل کود به بهره بردار فوق از تاریخ <strong>{{ jdate($model->make_date)->format("Y/m/d") }}</strong> به مدت ۴۰ روز کاری است و در صورت تغیر قیمت مصوب اقلام حواله ، ما به التفاوت مبلغ واریزی از نامبرده اخذ و تسویه حساب گردد.  
                        <br/><br/>
                        <span>ضمنا اخذ اثر انگشت و امضاء در موقع تحویل اقلام حواله ، الزامی می باشد.</span>
                        <br/><br/>
                        <span>شماره تماس کارگزار جهت هماهنگی: </span><strong>{{ $model->broker->mobile }}</strong><br/>
                        
                    </div>
                </div>
                <div class="card-body text-left">
                    <a href="#print" onclick="openWin()" class="btn btn-info" title="چاپ">
                        <i class="fas fa-print"></i>
                        پرینت
                    </a>
                </div>
            </div>
            <div class="col-md-12 border py-2">
                <div class="alert alert-danger"> برای دریافت سهمیه سایر محصولات کشت شده ی خود به صفحه اصلی رفته و درخواست محصول مورد نظر خود را ثبت کنید.</div>
                <a href="{{ url('profile/index.html') }}">بازگشت به صفحه اصلی</a> 
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