@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                  انتقال به درگاه بانک...
                    <div class="col-md-12 border py-2">
						<form action="https://sep.shaparak.ir/payment.aspx" method="POST" id="frm">
							<input name='Token' type='hidden' value='{{ $result }}'>
							<input name='RedirectURL' type='hidden' value='{{ $ReturnUrl }}'>
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