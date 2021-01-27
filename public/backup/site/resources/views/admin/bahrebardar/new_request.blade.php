@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')

<div class="col-md-12 p-0">
    <div class="card">
        @if (Session::has('bahrebardar'))            
            <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">
                {{ Session::get('bahrebardar') }}
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
            {{ __('validation.attributes.new_pahne_request') }}
            </h4>
        </div>
        <div class="card-body"> 
            @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
        </div>
                <form method="POST" action="{{ route('bahrebardar/new') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">

                <div class="row d-none">
                    <div class="form-group col-sm-6">
                        <label for="title" class="col-form-label text-md-right">{{ __('validation.attributes.title') }} <i class="text-danger">*</i> <span style="font-size: 12px;color:#aaaaaa;">مثلا: زمین منطقه پایین دست</span></label>
                        <input id="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" >
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="num_pahne" class="col-form-label text-md-right">{{ __('validation.attributes.num_pahne') }}</label>
                        <input id="num_pahne" type="text" class="form-control {{ $errors->has('num_pahne') ? ' is-invalid' : '' }}" name="num_pahne" value="{{ old('num_pahne') }}" >
                        @if ($errors->has('num_pahne'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_pahne') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="ostan" class="col-form-label text-md-right">{{ __('validation.attributes.ostan') }} <i class="text-danger">*</i> </label>
                        <select name="ostan" id="ostan" onchange="changeOstan()" class="form-control {{ $errors->has('ostan') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- استان مورد نظر را انتخاب کنید -- </option>
                            @foreach ($ostans as $ostan)
                                <option {{ (old("ostan") == $ostan->id)?"checked":"" }} value="{{ $ostan->id }}">{{ $ostan->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('ostan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('ostan') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="city" class="col-form-label text-md-right">{{ __('validation.attributes.city') }} <i class="text-danger">*</i> </label>
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
                        <label for="bakhsh" class="col-form-label text-md-right">{{ __('validation.attributes.bakhsh') }} <i class="text-danger">*</i> </label>
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
                        <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.address') }} <i class="text-danger">*</i> </label>
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
                        <label for="masahat" class="col-form-label text-md-right">{{ __('validation.attributes.masahat') }} <i class="text-danger">*</i> ({{ __('validation.attributes.hektar') }} / متر)</label>
                        <input id="masahat" type="number" class="form-control {{ $errors->has('masahat') ? ' is-invalid' : '' }}" name="masahat" value="{{ old('masahat') }}" >
                        @if ($errors->has('masahat'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('masahat') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="malekiyat_id" class="col-form-label text-md-right">{{ __('validation.attributes.malekiyat') }} <i class="text-danger">*</i> </label>
                        <select name="malekiyat_id" id="malekiyat_id" class="form-control {{ $errors->has('malekiyat_id') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- نوع مالکیت مکان خود را انتخاب کنید -- </option>
                            @foreach ($typeMalekiyat as $malekiyat)
                                <option value="{{ $malekiyat->id }}">{{ $malekiyat->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('malekiyat_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('malekiyat_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="type" class="col-form-label text-md-right">{{ __('validation.attributes.type') }} <i class="text-danger">*</i> </label>
                        <select name="type" id="type" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- نوع محل بهره برداری خود را انتخاب کنید -- </option>
                            @foreach ($typeMazrae as $type)
                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="madarek_image" class="col-form-label text-md-right">{{ __('validation.attributes.madarek_image') }}</label>
                        <input id="madarek_image" type="file" class="form-control {{ $errors->has('madarek_image') ? ' is-invalid' : '' }}" name="madarek_image" value="{{ old('madarek_image') }}" >
                        @if ($errors->has('madarek_image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('madarek_image') }}</strong>
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
	
</script>
@endsection