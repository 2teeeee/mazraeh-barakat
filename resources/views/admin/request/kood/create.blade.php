@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
            فرم درخواست کود
            </h4>
        </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('request/kood/store') }}" enctype="multipart/form-data">
                @csrf

                {{ Form::hidden('requestType_id', $type) }}
                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-6">
                        <label for="location" class="col-form-label text-md-right">{{ __('validation.attributes.location') }}</label>
                        <select name="location" id="location" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.bahrebardarSelect') }} -- </option>
                            @foreach ($bahrebardars as $bahrebardar)
                                <option {{ (old('location') == $bahrebardar->id)?'selected':'' }} value="{{ $bahrebardar->id }}">{{ $bahrebardar->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('location'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('location') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="kesht_type" class="col-form-label text-md-right">{{ __('validation.attributes.kesht_type') }}</label>
                        <select name="kesht_type" id="kesht_type" class="form-control {{ $errors->has('kesht_type') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.keshtSelect') }} -- </option>
                            @foreach ($keshtType as $kesht)
                                <option {{ (old("kesht_type") == $kesht->id )?"selected":"" }} value="{{ $kesht->id }}">{{ $kesht->title }}</option>
                            @endforeach
                            <option {{ (old('kesht_type') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('kesht_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kesht_type') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="mahsool_id" class="col-form-label text-md-right">{{ __('validation.attributes.mahsool_name') }}</label>
                        <select name="mahsool_id" id="mahsool_id" class="form-control {{ $errors->has('mahsool_id') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.keshtSelect') }} -- </option>
                            @foreach ($mahsoolType as $mahsool)
                                <option {{ (old("mahsool_id") == $mahsool->id)?"selected":"" }} value="{{ $mahsool->id }}">{{ $mahsool->title }}</option>
                            @endforeach
                            <option {{ (old('mahsool_id') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('mahsool_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mahsool_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="kesht_sath" class="col-form-label text-md-right">{{ __('validation.attributes.kesht_sath') }}</label>
                        <div class="row mx-1">
                            <input id="kesht_sath" type="text" class="col-7 form-control {{ $errors->has('kesht_sath') ? ' is-invalid' : '' }}" name="kesht_sath" value="{{ old('kesht_sath') }}" >
                            <select name="type_sath" id="type_sath" class="col-5 form-control {{ $errors->has('type_sath') ? ' is-invalid' : '' }}">
                                <option value="0">هکتار</option>
                                <option value="1">مترمربع</option>
                            </select>
                        </div>
                        @if ($errors->has('kesht_sath'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kesht_sath') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="bazr_type" class="col-form-label text-md-right">{{ __('validation.attributes.bazr_type') }}</label>
                        <select name="bazr_type" id="bazr_type" class="form-control {{ $errors->has('bazr_type') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.bazrSelect') }} -- </option>
                            @foreach ($bazrType as $bazr)
                                <option {{ (old("bazr_type") == $bazr->id )?"selected":"" }} value="{{ $bazr->id }}">{{ $bazr->title }}</option>
                            @endforeach
                            <option {{ (old('bazr_type') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('bazr_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bazr_type') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    
                    <div class="form-group col-sm-6" id="show-zamin" style="display:none;">
                        <label for="kesht_date" class="col-form-label text-md-right">{{ __('validation.attributes.kesht_date') }}</label>
                        <input id="kesht_date" type="text" class="form-control {{ $errors->has('kesht_date') ? ' is-invalid' : '' }}" name="kesht_date" value="{{ old('kesht_date') }}" >
                        @if ($errors->has('kesht_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kesht_date') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6" id="show-bagh" style="display:none;">
                        <label for="keshtYear" class="col-form-label text-md-right">{{ __('validation.attributes.keshtYear') }}</label>
                        <input id="keshtYear" type="text" class="form-control {{ $errors->has('keshtYear') ? ' is-invalid' : '' }}" name="keshtYear" value="{{ old('keshtYear') }}" >
                        @if ($errors->has('keshtYear'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('keshtYear') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6" id="show-golkhaneh" style="display:none;">
                        <label for="hasZehkeshi" class="col-form-label text-md-right">{{ __('validation.attributes.hasZehkeshi') }}</label>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hasZehkeshi" id="hasZehkeshi" value="1">
                                    <label class="form-check-label mr-3" for="hasZehkeshi">
                                      دارد
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hasZehkeshi" id="hasZehkeshi" value="0" checked>
                                    <label class="form-check-label mr-3" for="hasZehkeshi">
                                      ندارد
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('hasZehkeshi'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('hasZehkeshi') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="small_comment" class="col-form-label text-md-right">{{ __('validation.attributes.small_comment') }}</label>
                        <textarea id="small_comment" rows="4" type="text" class="form-control {{ $errors->has('small_comment') ? ' is-invalid' : '' }}" name="small_comment" >{{ old('small_comment') }}</textarea>
                        @if ($errors->has('small_comment'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('small_comment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="row" style="margin-bottom: 15px;">
                    
                    
                    <div class="form-group col-sm-6">
                        <label for="koodget_type" class="col-form-label text-md-right">{{ __('validation.attributes.koodget_type') }}</label>
                        <select name="koodget_type" id="koodget_type" class="form-control {{ $errors->has('koodget_type') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.koodGetSelect') }} -- </option>
                            @foreach ($allKoodType as $kesht)
                                <option {{ (old("koodget_type") == $kesht->id )?"selected":"" }} value="{{ $kesht->id }}">{{ $kesht->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('koodget_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('koodget_type') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="sendType" class="col-form-label text-md-right">{{ __('validation.attributes.sendType') }}</label>
                        <select name="sendType" id="sendType" class="form-control {{ $errors->has('sendType') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- نوع ارسال را انتخاب کنید -- </option>
                            @foreach ($sendType as $kesht)
                                <option {{ (old("sendType") == $kesht->id )?"selected":"" }} value="{{ $kesht->id }}">{{ $kesht->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('sendType'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sendType') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="panel-footer mt-2">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.next_step') }}
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
    $('#bahrebardar_id').select2({
        dir: "rtl"
    });
    $('#kood_type').select2({
        dir: "rtl",
    });
    $('#koodget_type').select2({
        dir: "rtl",
    });
    $('#send_type').select2({
        dir: "rtl",
    });
    $('#bazr_type').select2({
        dir: "rtl",
    });
    $('#kesht_type').select2({
        dir: "rtl",
    });
    $('#alaf_id').select2({
        dir: "rtl",
    });
    $('#alafkosh_id').select2({
        dir: "rtl",
    });
    $('#mahsool_id').select2({
        dir: "rtl",
    });
    $('#kesht_old').select2({
        dir: "rtl",
    });
    $('#khak_id').select2({
        dir: "rtl",
    });
    $('#ab_type').select2({
        dir: "rtl",
    });

});


$('#location').on('change', function() {
    var id = this.value;
    
    $.ajax({
            type: "GET",
            url: '{{ url("request/checkType") }}',
            data: {id: id},
            success: function(result) {
                if(result == 2)
                {
                    $("#show-zamin").css("display","block");
                    $("#show-bagh").css("display","none");
                    $("#show-golkhaneh").css("display","none");
                }
                if(result == 3)
                {
                    $("#show-zamin").css("display","none");
                    $("#show-bagh").css("display","block");
                    $("#show-golkhaneh").css("display","none");
                }
                if(result == 4)
                {
                    $("#show-zamin").css("display","none");
                    $("#show-bagh").css("display","none");
                    $("#show-golkhaneh").css("display","block");
                }
            }
        });
        
});
	
        $("#ab_start_date").persianDatepicker();
        $("#kesht_date").persianDatepicker();
</script>
@endsection