@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center">
<!--                    <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                        <i class="fas fa-key fa-3x"></i>
                    </div>-->
                    <h4>
                    اعتبار سنجی شماره تلفن همراه
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('resetPasswordComplate') }}">
                        @csrf

                        @if (Session::has('message'))
                            <div class="alert alert-warning">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        
                        <div class="form-group">
                            <label for="resetCode" class="col-form-label text-md-right">کد بازیابی</label>

                            <input id="resetCode" type="text" dir="ltr" class="form-control{{ $errors->has('resetCode') ? ' is-invalid' : '' }} text-x3 text-center my-2 rounded-pill" name="resetCode" value="{{ old('resetCode') }}" autofocus>

                            @if ($errors->has('resetCode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('resetCode') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-user-check"></i>
                                    بررسی کد بازیابی
                                </button>
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
    <script src="{{ asset('inputmask/dist/jquery.inputmask.js') }}"></script>
    <script>
        $("#resetCode").inputmask({"mask": "99999999"});
    </script>
@endsection