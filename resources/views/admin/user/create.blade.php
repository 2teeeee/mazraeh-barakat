@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('user/store') }}">
                @csrf

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="codemelli" class="col-form-label text-md-right">{{ __('validation.attributes.codemelli') }}</label>
                        <input id="codemelli" type="text" class="form-control {{ $errors->has('codemelli') ? ' is-invalid' : '' }}" name="codemelli" value="{{ old('codemelli') }}" autofocus>
                        @if ($errors->has('codemelli'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('codemelli') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="name" class="col-form-label text-md-right">{{ __('validation.attributes.name') }}</label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" >
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="mobile" class="col-form-label text-md-right">{{ __('validation.attributes.mobile') }}</label>
                        <input id="mobile" type="text" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" >
                        @if ($errors->has('mobile'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="email" class="col-form-label text-md-right">{{ __('validation.attributes.email') }}</label>
                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" >
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="password" class="col-form-label text-md-right">{{ __('validation.attributes.password') }}</label>
                        <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" >
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 p-0">
                        <label for="city_id" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.city_id') }} <span class="text-danger">*</span></label>

                        <div class="col-md-12">
                            <select name="city_id" id="kood_id" class="form-control {{ $errors->has('city_id') ? ' is-invalid' : '' }}">
                                <option disabled selected value> -- شهر محل سکونت خود را انتخاب کنید-- </option>
                                @foreach ($citys as $city)
                                    <option {{ (old('city_id') == $city->id)?'selected':'' }} value="{{ $city->id }}">{{ $city->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('city_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="company" class="col-form-label text-md-right">{{ __('validation.attributes.company') }}</label>
                        <input id="company" type="text" class="form-control {{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" value="{{ old('company') }}" >
                        @if ($errors->has('company'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('company') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>
                        <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" >
                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row" style="margin: 15px 0;">
                    <div class="form-group col-sm-12">
                        <label for="role" class="col-form-label text-md-right">{{ __('validation.attributes.role') }}</label>
                        <select name="role[]" id="role_id" class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" multiple="multiple">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>
                
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="father_name" class="col-form-label text-md-right">{{ __('validation.attributes.father_name') }}</label>
                        <input id="father_name" type="text" class="form-control {{ $errors->has('father_name') ? ' is-invalid' : '' }}" name="father_name" value="{{ old('father_name') }}" >
                        @if ($errors->has('father_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('father_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="birth_date" class="col-form-label text-md-right">{{ __('validation.attributes.birth_date') }}</label>
                        <input id="birth_date" type="text" class="form-control {{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" >
                        @if ($errors->has('birth_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('birth_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="level_tahsil" class="col-form-label text-md-right">{{ __('validation.attributes.level_tahsil') }}</label>
                        <input id="level_tahsil" type="text" class="form-control {{ $errors->has('level_tahsil') ? ' is-invalid' : '' }}" name="level_tahsil" value="{{ old('level_tahsil') }}" >
                        @if ($errors->has('level_tahsil'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('level_tahsil') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="reshte_tahsil" class="col-form-label text-md-right">{{ __('validation.attributes.reshte_tahsil') }}</label>
                        <input id="reshte_tahsil" type="text" class="form-control {{ $errors->has('reshte_tahsil') ? ' is-invalid' : '' }}" name="reshte_tahsil" value="{{ old('reshte_tahsil') }}" >
                        @if ($errors->has('reshte_tahsil'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('reshte_tahsil') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.register') }}
                            </button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
            
        </div>

</div>
@stop

@section('script')
<script type="text/javascript">

$(document).ready(function() {
    $('#role_id').select2({
        dir: "rtl"
    });
});
	
</script>
@endsection