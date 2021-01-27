@extends('layouts.main')



@section('content')

<div class="container">

    <div class="row justify-content-center my-5">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header text-center">

<!--                    <div class="rounded-circle border border-info p-3 text-info mx-auto mb-2" style="width: 75px;height: 75px;">

                        <i class="fas fa-sign-in-alt fa-3x"></i>

                    </div>-->

                    <h4>

                    {{ __('validation.attributes.loginToSite') }}

                    </h4>

                </div>



                <div class="card-body">

                    @if (Session::has('message'))

                        <div class="alert alert-info">{{ Session::get('message') }}</div>

                    @endif

                    <form method="POST" action="{{ url('login.html') }}">

                        @csrf



                        <div class="form-group row">

                            <label for="uname" class="col-md-4 col-form-label text-md-right">{{ __('validation.attributes.uname') }}</label>



                            <div class="col-md-6">

                                <input id="uname" type="text" placeholder="مثال: 2551234567" class="form-control {{ $errors->has('uname') ? ' is-invalid' : '' }} persian-number" name="uname" value="{{ old('uname') }}" autofocus>



                                @if ($errors->has('uname'))

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $errors->first('uname') }}</strong>

                                    </span>

                                @endif

                            </div>

                        </div>



                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('validation.attributes.password') }} / {{ __('validation.attributes.mobile') }}</label>



                            <div class="col-md-6 position-relative">

                                <input id="password" type="password" placeholder="مثال: 09179171234" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} persian-number" name="password">

								<div class="text-link position-absolute text-gray" onClick="showPass()" id="showPass" style="top: 10px;left: 20px;cursor: pointer">

									<i class="fas fa-eye text-gray" style="    color: #a7a7a7;"></i>

								</div>

                                @if ($errors->has('password'))

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $errors->first('password') }}</strong>

                                    </span>

                                @endif

                            </div>

							

                            

<!--                        <span class="col-md-12 alert alert-info mt-2">

                            <i class="fas fa-info-circle"></i>

                            {{ __('validation.attributes.login_password_message') }}

                        </span>-->

                        </div>

<!--                        <div class="form-group row">

                            <div class="col-md-6 offset-md-4">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>



                                    <label class="form-check-label" for="remember">

                                        {{ __('Remember Me') }}

                                    </label>

                                </div>

                            </div>

                        </div>-->

						<div class="form-group row">

							<label for="captcha" class="col-md-12 col-form-label text-md-right">عبارت امنیتی زیر را وارد کنید:</label>



                            <div class="col-md-4 text-md-right captcha">

							<span>{!! captcha_img() !!}</span>

								<button type="button" class="btn btn-link" id="refresh"><i class="fas fa-refresh"></i>کد جدید!</button>

							</div>

                            <div class="col-md-6 mt-2">

                                <input type="text" name="captcha" id="captcha" class="form-control {{ $errors->has('captcha') ? ' is-invalid' : '' }} persian-number">

								

                                @if ($errors->has('captcha'))

                                    <span class="invalid-feedback d-block" role="alert">

                                        <strong>{{ $errors->first('captcha') }}</strong>

                                    </span>

                                @endif

                            </div>

                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-8 offset-md-3">

                                <button type="submit" class="btn btn-success col-md-4">

                                    {{ __('validation.attributes.login') }}

                                </button>





                                @if (Route::has('password.request'))

                                <div class="mt-3">

                                    <a class="text-info text-decoration-none" href="{{ url('resetPassword.html') }}">

                                        رمز عبور خود را فراموش کرده اید؟

                                    </a>

                                </div>

                                @endif



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

$('#uname').bind('keyup', function(e) {

    $("#uname").val(convertToEnglish($("#uname").val()));

}); 

$('#password').bind('keyup', function(e) {

    $("#password").val(convertToEnglish($("#password").val()));

}); 



</script>

<script type="text/javascript">

$('#refresh').click(function(){

  $.ajax({

     type:'GET',

     url:'{{ url("refreshcaptcha") }}',

     success:function(data){

        $(".captcha span").html(data.captcha);

     }

  });

});

	

function showPass() {

	var x = document.getElementById("password");

	if (x.type === "password") {

		x.type = "text";

		$("#showPass i").removeClass("fa-eye");

		$("#showPass i").addClass("fa-eye-slash");

	} else {

		x.type = "password";

		$("#showPass i").removeClass("fa-eye-slash");

		$("#showPass i").addClass("fa-eye");

	}

}

</script>

@endsection