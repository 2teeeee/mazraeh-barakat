@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                  انتقال به درگاه بانک...
                    <div class="col-md-12 border py-2">
                        <form action="https://sep.shaparak.ir/Payment.aspx" method="post" id="frm">
                            <input type="hidden" name="MID" value="{{ $MID }}">
                            <input type="hidden" name="ResNum" value="{{ $ResNum }}">
                            <input type="hidden" name="Amount" value="{{ $Amount }}">
                            <input type="hidden" name="RedirectURL" value="{{ $ReturnUrl }}">
                            <input type="hidden" name="ResNum1" value="{{ $ResNum1 }}">
                            <input type="hidden" name="ResNum2" value="{{ $ResNum2 }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')
    <script>
        $("#frm").submit();
    </script>
@endsection