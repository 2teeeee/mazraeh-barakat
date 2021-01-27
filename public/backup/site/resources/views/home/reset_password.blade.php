@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h5>بازیابی رمز عبور</h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('resetPasswordSend.html') }}">
                        @csrf

                        <div class="form-group">
                            <label for="codemelli" class="col-form-label text-md-right">{{ __('validation.attributes.codemelli') }}</label>

                                <input id="codemelli" type="text" dir="ltr" class="text-center form-control {{ $errors->has('codemelli') ? ' is-invalid' : '' }}" name="codemelli" value="{{ old('codemelli') }}" required autocomplete="codemelli" autofocus>
                                
                                @if ($errors->has('codemelli'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-unlock-alt"></i> 
                                    بازیابی رمز عبور
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
