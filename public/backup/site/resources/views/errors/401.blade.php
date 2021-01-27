@extends('layouts.main')

@section('content')

<div id='sfMainwrapper' class="col-sm-12" >
    <div class='sfWrapper'>
        <div class="sfModule">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-grad">
                        <div class="panel">
                            <div class="panel-danger">
                                <div class="panel-heading">
                                    <h2>خطای دسترسی</h2>
                                </div>
                                <div class="panel-body">
                                    <p>
                                        شما مجوز استفاده از این صفحه را ندارید.
                                    </p>
                                    <br/>
                                    <a href="{{ url('/home') }}" class="btn btn-success">بازگشت به صفحه اصلی</a>
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
