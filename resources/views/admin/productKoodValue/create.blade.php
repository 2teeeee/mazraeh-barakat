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
            <form method="POST" action="{{ route('productKoodValue/store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="product_id" class="col-form-label text-md-right">{{ __('validation.attributes.product_id') }} <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-control {{ $errors->has('product_id') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- محصول مورد نظر خود را انتخاب کنید -- </option>
                            @foreach ($products as $product)
                                <option {{ (old('product_id') == $product->id)?'selected':'' }} value="{{ $product->code }}">{{ $product->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('product_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('product_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="kood_id" class="col-form-label text-md-right">{{ __('validation.attributes.kood_id') }} <span class="text-danger">*</span></label>
                        <select name="kood_id" id="kood_id" class="form-control {{ $errors->has('kood_id') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- نوع کود مورد نظر خود را انتخاب کنید -- </option>
                            @foreach ($koods as $kood)
                                <option {{ (old('kood_id') == $kood->id)?'selected':'' }} value="{{ $kood->id }}">{{ $kood->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('kood_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kood_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="abType" class="col-form-label text-md-right">{{ __('validation.attributes.abType') }} <span class="text-danger">*</span></label>
                        <select name="abType" id="abType" class="form-control {{ $errors->has('abType') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- نوع آبیاری مورد نظر خود را انتخاب کنید -- </option>
                            @foreach ($abTypes as $ab)
                                <option {{ (old('abType') == $ab->id)?'selected':'' }} value="{{ $ab->id }}">{{ $ab->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('abType'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('abType') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="city_id" class="col-form-label text-md-right">{{ __('validation.attributes.city_id') }} <span class="text-danger">*</span></label>
                        <select name="city_id" id="city_id" class="form-control {{ $errors->has('city_id') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- شهر مورد نظر خود را انتخاب کنید -- </option>
                            @foreach ($cities as $city)
                                <option {{ (old('city_id') == $city->id)?'selected':'' }} value="{{ $city->ct_id }}">{{ $city->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('city_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('city_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="startDate" class="col-form-label text-md-right">{{ __('validation.attributes.startDate') }} <span class="text-danger">*</span></label>
                        <input id="startDate" type="text" class="form-control{{ $errors->has('startDate') ? ' is-invalid' : '' }} date" name="startDate" value="{{ old('startDate') }}">
                        @if ($errors->has('startDate'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('startDate') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="endDate" class="col-form-label text-md-right">{{ __('validation.attributes.endDate') }} <span class="text-danger">*</span></label>
                        <input id="endDate" type="text" class="form-control{{ $errors->has('endDate') ? ' is-invalid' : '' }} date" name="endDate" value="{{ old('endDate') }}">
                        @if ($errors->has('endDate'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('endDate') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="value" class="col-form-label text-md-right">{{ __('validation.attributes.value') }} (کیلو گرم)<span class="text-danger">*</span></label>
                        <input id="value" type="text" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value" value="{{ old('value') }}">
                        @if ($errors->has('value'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('value') }}</strong>
                            </span>
                        @endif
                    </div>
					<div class="form-group col-sm-6">
                        <input id="userKeshtReqStatus" {{ old('userKeshtReqStatus')?'checked':'' }} type="checkbox" class="{{ $errors->has('userKeshtReqStatus') ? ' is-invalid' : '' }}" name="userKeshtReqStatus" value="1">
                        <label for="userKeshtReqStatus" class="col-form-label text-md-right">{{ __('validation.attributes.userKeshtReqStatus') }}</label>
                        @if($errors->has('userKeshtReqStatus'))
						
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>این گزینه باید انتخاب شود.</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.save') }}
                            </button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
            
        </div>

</div>
@endsection

@section('script')
    
<script>
    $('.date').persianDatepicker({
         format: 'YYYY/MM/DD',
         initialValue: false
    });    
</script>

<script type="text/javascript">

$(document).ready(function() {
    $('#product_id').select2({
        dir: "rtl"
    });
    $('#kood_id').select2({
        dir: "rtl",
    });
    $('#city_id').select2({
        dir: "rtl",
    });
    $('#abType').select2({
        dir: "rtl",
    });
});
</script>
@endsection