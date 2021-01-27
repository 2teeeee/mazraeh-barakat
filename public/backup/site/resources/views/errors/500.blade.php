@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div id='sfMainwrapper' class="col-sm-8" >
            <div class='sfWrapper'>
                <div class="sfModule">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-grad">
                                <div class="panel">
                                    <div class="panel-danger">
                                        <div class="panel-heading">
                                            <h2></h2>
                                        </div>
                                        <div class="alert alert-danger">
                                            <p>
                                                مشکلی در برقراری ارتباط با سامانه رخ داده.
                                                <br/>
                                                لطفا به صفحه اصلی بر گشته و مجدد تلاش کنید.
                                            </p>
                                            <br/>
                                            <a href="{{ url('/') }}">بازگشت به صفحه اصلی</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
