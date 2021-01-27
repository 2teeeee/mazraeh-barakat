@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success">درخواست شما با موفقیت ثبت شد.</div>
                    
                    <div class="alert alert-info">در حال انتقال به درگاه بانک...</div>
                </div>
                @if($model)
                <div class="card-body">
                    <div class="text-center">بسمه تعالی</div>
                    <div class="h4 text-center">حواله توزیع کود {{ $model->kood->title }}</div>
                    <div class="text-left">تاریخ: {{ jdate($model->created_at)->format("Y/m/d") }}</div>
                    <div>
                       کارگزار محترم آقای  ................ 
                    </div>
                    <div>با سلام</div>
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
                        <span>به حضور معرفی می گردد.</span><br/>
                        <span>لازم به ذکر است مشخصات نامبرده در لیست توزیع آن کارگزاری ثبت و اخذ اثر انگشت و امضاء الزامی می باشد.</span>
                        <span></span>
                        
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
