@extends('layouts.profile_layout')

@section('content')

<div class="col-md-12 p-0">
    <div class="card">
        <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-key fa-3x"></i>
            </div>
            <h4>
            {{ __('validation.attributes.changePassword') }}
            </h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card-body">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('profile/changePassword.html') }}">
                        @csrf


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('validation.attributes.password') }}</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="newPassword" class="col-md-4 col-form-label text-md-right">{{ __('validation.attributes.newPassword') }}</label>

                            <div class="col-md-7">
                                <input id="newPassword" type="password" class="form-control{{ $errors->has('newPassword') ? ' is-invalid' : '' }}" name="newPassword">

                                @if ($errors->has('newPassword'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('newPassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="newPassword_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('validation.attributes.newPasswordConfirmed') }}</label>

                            <div class="col-md-7">
                                <input id="newPassword_confirmation" type="password" class="form-control" name="newPassword_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('validation.attributes.changePassword') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
    </div>
</div>


@endsection
