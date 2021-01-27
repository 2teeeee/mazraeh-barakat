@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                </div>

                <div class="card-body">
                    <form target="#">


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-3">
                                         

                                
<!--                                <a class="text-info text-decoration-none" href="{{ route('register') }}">
                                    ثبت نام کاربر جدید
                                </a>-->
<input id="inputTest" type="text" placeholder="Numbers should be converted from Arabic to English here">
<input type="text" id="input"  />
<button onclick="displayEnteredText()">Display</button>
<script>
  
$( "#input" ).keyup(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
     $("#inputTest").val(keycode);
    }
);

</script>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  
</script>
@endsection