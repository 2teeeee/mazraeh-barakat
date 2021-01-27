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
                    کلمه عبور جدید
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('newPassword') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password" class="col-form-label text-md-right">{{ __('validation.attributes.password') }}</label>

                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-form-label text-md-right">{{ __('validation.attributes.passwordConfirmed') }}</label>

                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-user-shield"></i>
                                    ثبت کلمه عبور
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
