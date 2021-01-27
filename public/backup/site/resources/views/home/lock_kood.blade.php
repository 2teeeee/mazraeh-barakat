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
					کشاورز محترم، جنابعالی سهمیه تخصیص کود شیمیایی اوره خود را قبلا بصورت حواله دستی ( سنتی) دریافت نموده اید. جهت اطلاعات بیشتر به مرکز جهاد خود مراجعه یا تماس حاصل نمایید.
                    <br/><br/>
                    <a href="{{ url('/') }}" class="btn btn-info" >بازگشت به صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection