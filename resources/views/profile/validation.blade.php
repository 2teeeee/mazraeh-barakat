@extends('layouts.main')

@section('title', 'وب سایت من')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8  my-5 p-0">
            <div class="card">
                <div class="card-header text-center">
                    <h4>
                        اطلاعات تکمیلی
                    </h4>
                </div>
                <div class="card-body"> 
                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('profile/validationInfo.html') }}">
                @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.name') }}</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')?old('name'):$model->name }}" autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mobile" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.mobile') }}</label>

                                    <div class="col-md-12">
                                        <input id="mobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile')?old('mobile'):$model->mobile }}">

                                        @if ($errors->has('mobile'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.email') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email')?old('email'):$model->email }}">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="codemelli" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.codemelli') }}</label>

                                    <div class="col-md-12">
                                        <input id="codemelli" readonly type="text" class="form-control{{ $errors->has('codemelli') ? ' is-invalid' : '' }}" name="codemelli" value="{{ old('codemelli')?old('codemelli'):$model->codemelli }}">

                                        @if ($errors->has('codemelli'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codemelli') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="address" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>

                                    <div class="col-md-12">
                                        <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address')?old('address'):$model->address }}">

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
                                        <input id="father_name" type="text" class="form-control{{ $errors->has('father_name') ? ' is-invalid' : '' }}" name="father_name" value="{{ old('father_name')?old('father_name'):$model->father_name }}">

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
                                        <input id="birth_date" type="text" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date')?old('birth_date'):$model->birth_date }}">

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
                                        <input id="reshte_tahsil" type="text" class="form-control{{ $errors->has('reshte_tahsil') ? ' is-invalid' : '' }}" name="reshte_tahsil" value="{{ old('reshte_tahsil')?old('reshte_tahsil'):$model->reshte_tahsil }}">

                                        @if ($errors->has('reshte_tahsil'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('reshte_tahsil') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <?php /*
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="role" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.yourWork') }}</label>
                                    <div class="col-md-12 row">
                                        <div class="col-md-6 pr-4">
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="orchardist" {{ old("role")?(in_array(6,old("role"))?"checked":""):(Auth::user()->checkRole(6)?"checked":"") }} name="role[]" value="6">
                                                    <label class="form-check-label mr-4" for="orchardist">باغ دارم.</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="planter" {{ old("role")?(in_array(7,old("role"))?"checked":""):(Auth::user()->checkRole(7)?"checked":"") }} name="role[]" value="7">
                                                    <label class="form-check-label mr-4" for="planter">زمین کشاورزی دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="greenhouseOwner" {{ old("role")?(in_array(8,old("role"))?"checked":""):(Auth::user()->checkRole(8)?"checked":"") }} name="role[]" value="8">
                                                    <label class="form-check-label mr-4" for="greenhouseOwner">گلخانه دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="ornamentalWork" {{ old("role")?(in_array(9,old("role"))?"checked":""):(Auth::user()->checkRole(9)?"checked":"") }} name="role[]" value="9">
                                                    <label class="form-check-label mr-4" for="ornamentalWork">گیاه زینتی کارم.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="clinic" {{ old("role")?(in_array(10,old("role"))?"checked":""):(Auth::user()->checkRole(10)?"checked":"") }} name="role[]" value="10">
                                                    <label class="form-check-label mr-4" for="clinic">کلینیک دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="pestAndDisinfectionCompany" {{ old("role")?(in_array(16,old("role"))?"checked":""):(Auth::user()->checkRole(16)?"checked":"") }} name="role[]" value="16">
                                                    <label class="form-check-label mr-4" for="pestAndDisinfectionCompany">شرکت دفع آفات و ضد عفونی دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="pesticideShop" {{ old("role")?(in_array(13,old("role"))?"checked":""):(Auth::user()->checkRole(13)?"checked":"") }} name="role[]" value="13">
                                                    <label class="form-check-label mr-4" for="pesticideShop">فروشگاه دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="waterAndSoilLaboratory" {{ old("role")?(in_array(15,old("role"))?"checked":""):(Auth::user()->checkRole(15)?"checked":"") }} name="role[]" value="15">
                                                    <label class="form-check-label mr-4" for="waterAndSoilLaboratory">آزمایشگاه آب و خاک دارم.</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="insecarium" {{ old("role")?(in_array(20,old("role"))?"checked":""):(Auth::user()->checkRole(20)?"checked":"") }} name="role[]" value="20">
                                                    <label class="form-check-label mr-4" for="insecarium">اینسکتاریوم دارم.</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            */ ?>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <a href="{{ url('terms.html') }}">شرایط و قوانین استفاده از اپلیکیشن مزرعه</a>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('validation.attributes.validationInfo') }}
                                    </button>
                                </div>
                            </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
<script type="text/javascript">

$("#birth_date").persianDatepicker();
    
</script>
@endsection