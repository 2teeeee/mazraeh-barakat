@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
<!--                    <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                        <i class="fas fa-key fa-3x"></i>
                    </div>-->
                    <h4>
                    {{ __('validation.attributes.registerToSite') }}
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.name') }} <span class="text-danger">*</span></label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="codemelli" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.codemelli') }} <span class="text-danger">*</span></label>

                                <div class="col-md-12">
                                    <input id="codemelli" type="text" class="form-control{{ $errors->has('codemelli') ? ' is-invalid' : '' }}" name="codemelli" value="{{ old('codemelli') }}">

                                    @if ($errors->has('codemelli'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('codemelli') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="mobile" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.mobile') }} <span class="text-danger">*</span></label>

                                <div class="col-md-12">
                                    <input id="mobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}">

                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                           <div class="form-group col-md-6">
                                <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.email') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password-confirm" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.passwordConfirmed') }}</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="address" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>

                                    <div class="col-md-12">
                                        <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}">

                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="father_name" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.father_name') }}</label>

                                    <div class="col-md-12">
                                        <input id="father_name" type="text" class="form-control{{ $errors->has('father_name') ? ' is-invalid' : '' }}" name="father_name" value="{{ old('father_name') }}">

                                        @if ($errors->has('father_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('father_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="birth_date" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.birth_date') }}</label>

                                    <div class="col-md-12">
                                        <input id="birth_date" type="text" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}">

                                        @if ($errors->has('birth_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('birth_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="level_tahsil" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.level_tahsil') }}</label>

                                    <div class="col-md-12">
                                        <select name="level_tahsil" id="level_tahsil" class="form-control {{ $errors->has('level_tahsil') ? ' is-invalid' : '' }}">
                                            <option disabled selected value> -- سطح تحصیل خود را انتخاب کنید -- </option>
                                            @foreach ($sathTahsil as $key => $tahsil)
                                                <option {{ (old('level_tahsil') == $key)?"selected":"" }} value="{{ $key }}">{{ $tahsil }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('level_tahsil'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('level_tahsil') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="reshte_tahsil" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.reshte_tahsil') }}</label>

                                    <div class="col-md-12">
                                        <input id="reshte_tahsil" type="text" class="form-control{{ $errors->has('reshte_tahsil') ? ' is-invalid' : '' }}" name="reshte_tahsil" value="{{ old('reshte_tahsil') }}">

                                        @if ($errors->has('reshte_tahsil'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('reshte_tahsil') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="role" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.yourWork') }}</label>
                                    <div class="col-md-12 row">
                                        <div class="col-md-6 pr-4">
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="orchardist" {{ old("role")?(in_array(6,old("role"))?"checked":""):'' }} name="role[]" value="6">
                                                    <label class="form-check-label mr-4" for="orchardist">باغ دارم.</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="planter" {{ old("role")?(in_array(7,old("role"))?"checked":""):'' }} name="role[]" value="7">
                                                    <label class="form-check-label mr-4" for="planter">زمین کشاورزی دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="greenhouseOwner" {{ old("role")?(in_array(8,old("role"))?"checked":""):'' }} name="role[]" value="8">
                                                    <label class="form-check-label mr-4" for="greenhouseOwner">گلخانه دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="ornamentalWork" {{ old("role")?(in_array(9,old("role"))?"checked":""):'' }} name="role[]" value="9">
                                                    <label class="form-check-label mr-4" for="ornamentalWork">گیاه زینتی کارم.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="clinic" {{ old("role")?(in_array(10,old("role"))?"checked":""):'' }} name="role[]" value="10">
                                                    <label class="form-check-label mr-4" for="clinic">کلینیک دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="pestAndDisinfectionCompany" {{ old("role")?(in_array(16,old("role"))?"checked":""):'' }} name="role[]" value="16">
                                                    <label class="form-check-label mr-4" for="pestAndDisinfectionCompany">شرکت دفع آفات و ضد عفونی دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="pesticideShop" {{ old("role")?(in_array(13,old("role"))?"checked":""):'' }} name="role[]" value="13">
                                                    <label class="form-check-label mr-4" for="pesticideShop">فروشگاه دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="waterAndSoilLaboratory" {{ old("role")?(in_array(15,old("role"))?"checked":""):'' }} name="role[]" value="15">
                                                    <label class="form-check-label mr-4" for="waterAndSoilLaboratory">آزمایشگاه آب و خاک دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="insecarium" {{ old("role")?(in_array(20,old("role"))?"checked":""):'' }} name="role[]" value="20">
                                                    <label class="form-check-label mr-4" for="insecarium">اینسکتاریوم دارم.</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="terms" name="terms" id="terms" >
                                    <label class="mr-4" for="terms">من <a href="{{ url('terms.html') }}">شرایط و ضوابط عمومی</a> را خوانده و قبول کرده ام.</label>
                                </div>
                                @if ($errors->has('terms'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('terms') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('validation.attributes.register') }}
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
<script type="text/javascript">

$("#birth_date").persianDatepicker();
    
</script>
@endsection