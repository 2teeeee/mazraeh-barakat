@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
            فرم درخواست سم
            </h4>
        </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('request/sam/storeManager') }}" enctype="multipart/form-data">
                @csrf

                {{ Form::hidden('requestType_id', $type) }}
                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-6">
                        <label for="location" class="col-form-label text-md-right">{{ __('validation.attributes.bahrebardar') }}</label>
                        <select name="location" id="location" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.bahrebardarSelect') }} -- </option>
                            @foreach ($bahrebardars as $bahrebardar)
                                <option {{ (old('location') == $bahrebardar->id)?'selected':'' }} value="{{ $bahrebardar->id }}">{{ $bahrebardar->user->name }} - {{ $bahrebardar->title }}</option>
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
                    <div class="form-group col-sm-6">
                        <label for="kesht_old" class="col-form-label text-md-right">{{ __('validation.attributes.kesht_old') }}</label>
                        <select name="kesht_old" id="kesht_old" class="form-control {{ $errors->has('kesht_old') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.keshtSelect') }} -- </option>
                            @foreach ($mahsoolType as $mahsool)
                                <option {{ (old("kesht_old") == $mahsool->id )?"selected":"" }} value="{{ $mahsool->id }}">{{ $mahsool->title }}</option>
                            @endforeach
                            <option {{ (old('kesht_old') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('kesht_old'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kesht_old') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                <div class="row">
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
                    
                    <div class="form-group col-sm-6">
                        <label for="ab_start_date" class="col-form-label text-md-right">{{ __('validation.attributes.ab_start_date') }}</label>
                        <input id="ab_start_date" type="text" class="form-control {{ $errors->has('ab_start_date') ? ' is-invalid' : '' }}" name="ab_start_date" value="{{ old('ab_start_date') }}" >
                        @if ($errors->has('ab_start_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ab_start_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="ab_dore" class="col-form-label text-md-right">{{ __('validation.attributes.ab_dore') }} ({{ trans('validation.attributes.day') }})</label>
                        <input id="ab_dore" type="text" class="form-control {{ $errors->has('ab_dore') ? ' is-invalid' : '' }}" name="ab_dore" value="{{ old('ab_dore') }}" >
                        @if ($errors->has('ab_dore'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ab_dore') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="kood_type" class="col-form-label text-md-right">{{ __('validation.attributes.kood_type') }} <span style="font-size: 12px;color:#aaaaaa;">لیست کودهایی که استفاده می کنید را وارد کنید.</span></label>
                        <select name="kood_type[]" id="kood_type" class="form-control {{ $errors->has('kood_type') ? ' is-invalid' : '' }}" multiple="multiple">
                            @foreach ($koodType as $kood)
                                <option {{ old('kood_type')?(in_array($kood->id,old("kood_type"))?"selected":""):"" }} value="{{ $kood->id }}">{{ $kood->title }}</option>
                            @endforeach
                            <option {{ (old('kood_type') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('kood_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kood_type') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ab_ec" class="col-form-label text-md-right">{{ __('validation.attributes.ab_ec') }}</label>
                                <select name="ab_ec" id="ab_ec" class="form-control {{ $errors->has('ab_ec') ? ' is-invalid' : '' }}">
                                    <option disabled selected value> -- {{ trans('validation.attributes.ecAbSelect') }} -- </option>
                                    @foreach ($ecAbType as $ec)
                                        <option {{ (old("ab_ec") == $ec->id )?"selected":"" }} value="{{ $ec->id }}">{{ $ec->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ab_ec'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ab_ec') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="abEc_file" class="col-form-label text-md-right">{{ __('validation.attributes.abEc_file') }}</label>
                                <input id="abEc_file" type="file" class="form-control {{ $errors->has('abEc_file') ? ' is-invalid' : '' }}" name="abEc_file" value="{{ old('abEc_file') }}" >
                                @if ($errors->has('abEc_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('abEc_file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="khak_ec" class="col-form-label text-md-right">{{ __('validation.attributes.khak_ec') }}</label>
                                <select name="khak_ec" id="ab_ec" class="form-control {{ $errors->has('khak_ec') ? ' is-invalid' : '' }}">
                                    <option disabled selected value> -- {{ trans('validation.attributes.ecKhakSelect') }} -- </option>
                                    @foreach ($ecKhakType as $ec)
                                        <option {{ (old("khak_ec") == $ec->id )?"selected":"" }} value="{{ $ec->id }}">{{ $ec->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('khak_ec'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('khak_ec') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="khakEc_file" class="col-form-label text-md-right">{{ __('validation.attributes.khakEc_file') }}</label>
                                <input id="khakEc_file" type="file" class="form-control {{ $errors->has('khakEc_file') ? ' is-invalid' : '' }}" name="khakEc_file" value="{{ old('khakEc_file') }}" >
                                @if ($errors->has('khakEc_file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('khakEc_file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="status_shoore" class="col-form-label text-md-right">{{ __('validation.attributes.status_shoore') }}</label>
                        <div class="row">
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_shoore" id="status_shoore" value="1">
                                    <label class="form-check-label mr-3" for="status_shoore">
                                      بلی
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_shoore" id="status_shoore" value="0" checked>
                                    <label class="form-check-label mr-3" for="status_shoore">
                                      خیر
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('status_shoore'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('status_shoore') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="khak_type" class="col-form-label text-md-right">{{ __('validation.attributes.khak_type') }}</label>
                        <select name="khak_type" id="khak_type" class="form-control {{ $errors->has('khak_type') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.khakTypeSelect') }} -- </option>
                            @foreach ($khakType2 as $ec)
                                <option {{ (old("khak_type") == $ec->id)?"selected":"" }} value="{{ $ec->id }}">{{ $ec->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('khak_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('khak_type') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="ab_type" class="col-form-label text-md-right">{{ __('validation.attributes.ab_type') }}</label>
                        <select name="ab_type" id="ab_type" class="form-control {{ $errors->has('ab_type') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.abSelect') }} -- </option>
                            @foreach ($abType as $ab)
                                <option {{ (old("ab_type") == $ab->id )?"selected":"" }} value="{{ $ab->id }}">{{ $ab->title }}</option>
                            @endforeach
                            <option {{ (old('ab_type') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('ab_type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ab_type') }}</strong>
                            </span>
                        @endif
                    </div>     
                    <div class="form-group col-sm-6">
                        <label for="khak_id" class="col-form-label text-md-right">{{ __('validation.attributes.khak_id') }}</label>
                        <select name="khak_id" id="khak_id" class="form-control {{ $errors->has('khak_id') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- {{ trans('validation.attributes.khakSelect') }} -- </option>
                            @foreach ($khakType as $khak)
                                <option {{ (old("khak_id") == $khak->id )?"selected":"" }} value="{{ $khak->id }}">{{ $khak->title }}</option>
                            @endforeach
                            <option {{ (old('khak_id') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('khak_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('khak_id') }}</strong>
                            </span>
                        @endif
                    </div>     
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="alaf_id" class="col-form-label text-md-right">{{ __('validation.attributes.alafType') }} <span style="font-size: 12px;color:#aaaaaa;">لیست علف های مزرعه خود را انتخاب کنید.</span></label>
                        <select name="alaf_id[]" id="alaf_id" class="form-control {{ $errors->has('alaf_id') ? ' is-invalid' : '' }}" multiple="multiple">
                            @foreach ($alafType as $alaf)
                                <option {{ old('alaf_id')?(in_array($alaf->id,old("alaf_id"))?"selected":""):"" }} value="{{ $alaf->id }}">{{ $alaf->title }}</option>
                            @endforeach
                            <option {{ (old('alaf_id') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('alaf_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('alaf_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="alafkosh_id" class="col-form-label text-md-right">{{ __('validation.attributes.alafkoshType') }} <span style="font-size: 12px;color:#aaaaaa;">علف کش هایی که استفاده کرده اید را انتخاب کنید</span></label>
                        <select name="alafkosh_id[]" id="alafkosh_id" class="form-control {{ $errors->has('alafkosh_id') ? ' is-invalid' : '' }}" multiple="multiple">
                            @foreach ($alafkoshType as $alaf)
                                <option {{ old('alafkosh_id')?(in_array($alaf->id,old("alafkosh_id"))?"selected":""):"" }} value="{{ $alaf->id }}">{{ $alaf->title }}</option>
                            @endforeach
                            <option {{ (old('alafkosh_id') == 1)?'selected':'' }} value="1">سایر</option>
                        </select>
                        @if ($errors->has('alafkosh_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('alafkosh_id') }}</strong>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="bazdid" name="bazdid">
                            <label class="form-check-label mr-3" for="bazdid">
                                می خواهم بازدید میدانی انجام شود.
                            </label>
                        </div>
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
    $('#location').select2({
        dir: "rtl"
    });
    $('#bahrebardar_id').select2({
        dir: "rtl"
    });
    $('#kood_type').select2({
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