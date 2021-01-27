@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')

<div class="col-md-12 p-0">
    <div class="card">
        @if (Session::has('store'))            
            <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">
                {{ Session::get('store') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
            ثبت کارگزاری
            </h4>
        </div>
        <div class="card-body"> 
            @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
        </div>
                <form method="POST" action="{{ route('store/new') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="name" class="col-form-label text-md-right">نام کارگزاری</label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" >
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="ostan" class="col-form-label text-md-right">{{ __('validation.attributes.ostan') }}</label>
                        <select name="ostan" id="ostan" onchange="changeOstan()" class="form-control {{ $errors->has('ostan') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- استان مورد نظر را انتخاب کنید -- </option>
                            @foreach ($ostans as $ostan)
                                <option value="{{ $ostan->id }}">{{ $ostan->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('ostan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ostan') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="city" class="col-form-label text-md-right">{{ __('validation.attributes.city') }}</label>
                        <select name="city" id="city" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- ابتدا استان مورد نظر را انتخاب کنید -- </option>
                        </select>
                        @if ($errors->has('city'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="bakhsh" class="col-form-label text-md-right">{{ __('validation.attributes.bakhsh') }}</label>
                        <input id="bakhsh" type="text" class="form-control {{ $errors->has('bakhsh') ? ' is-invalid' : '' }}" name="bakhsh" value="{{ old('bakhsh') }}" >
                        @if ($errors->has('bakhsh'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bakhsh') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="mantaghe" class="col-form-label text-md-right">{{ __('validation.attributes.mantaghe') }}</label>
                        <input id="mantaghe" type="text" class="form-control {{ $errors->has('mantaghe') ? ' is-invalid' : '' }}" name="mantaghe" value="{{ old('mantaghe') }}" >
                        @if ($errors->has('mantaghe'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mantaghe') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="roosta" class="col-form-label text-md-right">{{ __('validation.attributes.roosta') }}</label>
                        <input id="roosta" type="text" class="form-control {{ $errors->has('roosta') ? ' is-invalid' : '' }}" name="roosta" value="{{ old('roosta') }}" >
                        @if ($errors->has('roosta'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('roosta') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="utm" class="col-form-label text-md-right">{{ __('validation.attributes.utm') }} <span style="font-size: 12px;color:#aaaaaa;">مثلا: 29.6122389,52.4765425</span></label>
                        <div class="row">
                            <div class="form-group col-6 mb-0">
                                <input id="utmLat" type="text" class="form-control {{ $errors->has('utmLat') ? ' is-invalid' : '' }}" name="utmLat" value="{{ old('utmLat') }}" >
                                @if ($errors->has('utmLat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('utmLat') }}</strong>
                                    </span>
                                @endif
                                
                                @if ($errors->has('utmLat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('utmLat') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-6 mb-0">
                                <input id="utmLAng" type="text" class="form-control {{ $errors->has('utmLang') ? ' is-invalid' : '' }}" name="utmLang" value="{{ old('utmLang') }}" >
                                @if ($errors->has('utmLang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('utmLang') }}</strong>
                                    </span>
                                @endif
                                
                                @if ($errors->has('utmLang'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('utmLang') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
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
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="tel" class="col-form-label text-md-right">{{ __('validation.attributes.tel') }}</label>
                        <input id="tel" type="text" class="form-control {{ $errors->has('tel') ? ' is-invalid' : '' }}" name="tel" value="{{ old('tel') }}" >
                        @if ($errors->has('tel'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tel') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="image_mojavez" class="col-form-label text-md-right">{{ __('validation.attributes.image_mojavez') }}</label>
                        <input id="image_mojavez" type="file" class="form-control {{ $errors->has('image_mojavez') ? ' is-invalid' : '' }}" name="image_mojavez" value="{{ old('image_mojavez') }}" >
                        @if ($errors->has('image_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="num_mojavez" class="col-form-label text-md-right">{{ __('validation.attributes.num_mojavez') }}</label>
                        <input id="num_mojavez" type="text" class="form-control {{ $errors->has('num_mojavez') ? ' is-invalid' : '' }}" name="num_mojavez" value="{{ old('num_mojavez') }}" >
                        @if ($errors->has('num_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="num_nezam_mohandesi" class="col-form-label text-md-right">{{ __('validation.attributes.num_nezam_mohandesi') }}</label>
                        <input id="num_nezam_mohandesi" type="text" class="form-control {{ $errors->has('num_nezam_mohandesi') ? ' is-invalid' : '' }}" name="num_nezam_mohandesi" value="{{ old('num_nezam_mohandesi') }}" >
                        @if ($errors->has('num_nezam_mohandesi'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_nezam_mohandesi') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-4">
                        <label for="masool_fani" class="col-form-label text-md-right">{{ __('validation.attributes.masool_fani') }}</label>
                        <input id="masool_fani" type="text" class="form-control {{ $errors->has('masool_fani') ? ' is-invalid' : '' }}" name="masool_fani" value="{{ old('masool_fani') }}" >
                        @if ($errors->has('masool_fani'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('masool_fani') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="date_start_mojavez" class="col-form-label text-md-right">{{ __('validation.attributes.date_start_mojavez') }}</label>
                        <input id="date_start_mojavez" type="text" class="form-control {{ $errors->has('date_start_mojavez') ? ' is-invalid' : '' }}" name="date_start_mojavez" value="{{ old('date_start_mojavez') }}" >
                        @if ($errors->has('date_start_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('date_start_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="date_end_mojavez" class="col-form-label text-md-right">{{ __('validation.attributes.date_end_mojavez') }}</label>
                        <input id="date_end_mojavez" type="text" class="form-control {{ $errors->has('date_end_mojavez') ? ' is-invalid' : '' }}" name="date_end_mojavez" value="{{ old('date_end_mojavez') }}" >
                        @if ($errors->has('date_end_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('date_end_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                    
                <div class="row">                    
                    <div class="form-group col-sm-6">
                        <label for="num_shaba" class="col-form-label text-md-right">{{ __('validation.attributes.num_shaba') }}</label>
                        <input id="num_shaba" type="text" class="form-control {{ $errors->has('num_shaba') ? ' is-invalid' : '' }}" name="num_shaba" value="{{ old('num_shaba') }}" >
                        @if ($errors->has('num_shaba'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_shaba') }}</strong>
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
                </div>
                
            </form>
    </div>
</div>



@stop

@section('script')
<script type="text/javascript">

$(document).ready(function() {
    $('#user_id').select2({
        dir: "rtl"
    });
    $('#ostan').select2({
        dir: "rtl"
    });
    $('#city').select2({
        dir: "rtl"
    });
});

    function changeOstan()
    {
        id = $('#ostan').val();
        
        $.ajax({
            type:'GET', 
            url: '{{ url("ostanSelect") }}',
            data: {id: id},
            success: function(data){
                $("#city").html(data)
            }
        }).done(function(){
        });
    }	
    
    
    $("#date_start_pkasb").persianDatepicker();
    $("#date_end_pkasb").persianDatepicker();
    $("#date_end_mojavez").persianDatepicker();
    $("#date_start_mojavez").persianDatepicker();
</script>
@endsection