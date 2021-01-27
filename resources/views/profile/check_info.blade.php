@extends('layouts.main')

@section('title', 'وب سایت من')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 my-5 p-0">
            <div class="card">
                <div class="card-header text-center">
                    <h4>
                        بررسی اطلاعات
                    </h4>
                </div>
                <div class="card-body"> 
                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('infoValid') }}">
                        @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            نام و نام خوانوادگی: {{ $model->name }}
                        </div>
                        <div class="form-group col-md-6">
                             کد ملی: {{ $model->codemelli }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            موبایل: {{ $model->mobile }}
                        </div>
                        <div class="form-group col-md-6">
                             نام پدر: {{ $model->fathername }}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6 p-0">
                            <label for="city_id" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.city_id') }} <span class="text-danger">*</span></label>

                            <div class="col-md-12">
                                <select name="city_id" id="city_id" class="form-control {{ $errors->has('city_id') ? ' is-invalid' : '' }}">
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
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 p-0">
                            <label for="address" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.address') }} <span class="text-danger">*</span></label>

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
<?php /*                    <div class="row">
                        <div class="col-md-6">
                            تاریخ تولد: {{ $model->birth_date }}
                        </div>
                        <div class="col-md-6">
                             شماره شناسنامه: {{ $model->shsh }}
                        </div>
                    </div>
                    <hr/>
                    
                    <div class="row">
                        <div class="col-md-6">
                            شماره پهنه: {{ $model->num_pahne }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            شهر: {{ $model->info->city_name }}
                        </div>
                        <div class="col-md-6">
                             منطقه: {{ $model->info->mantaghe }}
                        </div>
                    </div> */ ?>
                    <div class="row mt-3">
                        <button type="submit" class="btn btn-success">
                            مورد تایید است
                        </button>
                        <a href="{{ url('infoUnValid') }}" class="btn btn-danger mr-2">
                            مورد تایید نیست
                        </a>
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

$(document).ready(function() {
    $('#city_id').select2({
        dir: "rtl"
    });
});
    
</script>
@endsection