@extends('layouts.main')

@section('title', 'وب سایت من')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 my-5 p-0">
            <div class="card border-danger">
                <div class="card-header text-white bg-danger text-center">
                    <h4>
                        بررسی اطلاعات
                    </h4>
                </div>
                <div class="card-body"> 
                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                </div>
                <div class="card-body">
                    {{ $message }}
                    <br/>
                    <a href="{{ url('/') }}" class="btn btn-info" >بازگشت به صفحه اصلی</a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script type="text/javascript">

$("#birth_date").persianDatepicker();
    
</script>
@endsection