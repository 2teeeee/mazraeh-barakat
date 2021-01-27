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
                   
                    <div class="alert col-md-12 alert-success">
                        درخواست های شما با موفقیت ثبت شد.
                    </div>

                    <div class="col-md-12 border py-2">
                        برای مشاهده و چاپ حواله های خود به صفحه <a href="{{ url('koodReq/list') }}"><strong>درخواست های داده شده</strong></a> مراجعه کنید.
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