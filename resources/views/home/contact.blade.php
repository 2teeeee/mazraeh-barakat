@extends('layouts.main')

@section('style')

    <link rel="stylesheet" href="{{ asset('map/css/s.map.min.css') }}">
    <link rel="stylesheet" href="{{ asset('map/css/fa/style.css') }}">
    <style>
        #map {
            width: 100%;
            height: 300px;
            font-size: 10px;
        }
    </style>
@endsection

@section('titleTop', trans('validation.attributes.contactus'))

@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>
                {{ trans('validation.attributes.contactus') }}
            </h2>
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <form method="POST" action="{{ url('contact.html') }}">
                @csrf
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="name" class="col-form-label text-md-right">{{ __('validation.attributes.name') }} *</label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="email" class="col-form-label text-md-right">{{ __('validation.attributes.email') }}</label>
                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="phone" class="col-form-label text-md-right">{{ __('validation.attributes.phone') }} *</label>
                        <input id="phone" type="text" class="form-control {{ $errors->has('phonename') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>  
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="subject" class="col-form-label text-md-right">{{ __('validation.attributes.subject') }}</label>
                        <input id="subject" type="text" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject') }}">
                        @if ($errors->has('subject'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="message" class="col-form-label text-md-right">{{ __('validation.attributes.message') }} *</label>
                        <textarea id="message" rows="7" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message">{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-warning">
                                {{ __('validation.attributes.sendMessage') }}
                            </button>
                        </div>
                    </div>
                </div>
                
            </form>
            
        </div>
        <div class="col-md-6">
<!--            <h3>اپلیکیشن مزرعه ی برکت</h3>-->
            <ul class="list-group bg-transparent text-dark">
                <li class="list-group-item">
                    <span class="font-weight-bold">
                        <i class="fas fa-map-marker"></i> {{ trans('validation.attributes.address') }}: 
                    </span>
                    شیراز - معالی آباد - کوی خلبانان - کوچه 7/1 - مجتمع آریا - واحد 13
                    <br/>
                    کد پستی: 7187737748
                </li>
                <li class="list-group-item">
                    <span class="font-weight-bold">
                        <i class="fas fa-phone-volume"></i> {{ trans('validation.attributes.phone') }}: 
                    </span>
                    <span dir="ltr">071-36361890</span>
                </li>
                <li class="list-group-item">
                    <span class="font-weight-bold">
                        <i class="fas fa-envelope"></i> {{ trans('validation.attributes.email') }}: 
                    </span>
                    info@mazraeh-barakat.ir
                </li>
            </ul>
            <div id="map" style="font-size: 10px;"></div>
        </div>
    </div>
</div>

@endsection

@section('script')

<!--<script src="{{ asset('map/js/jquery-3.2.1.min.js') }}"></script>-->
<script src="{{ asset('map/js/jquery.env.js') }}"></script>
<script src="{{ asset('map/js/s.map.styles.js') }}"></script>
<script src="{{ asset('map/js/s.map.min.js') }}"></script>

<script>
    $(document).ready(function() {
	var map = $.sMap({
            element: '#map',
            presets: {
                latlng: {
                    lat: 29.456555,
                    lng: 52.579494,
                },
                zoom: 15,
            },
	});
        
        $.sMap.layers.static.build({
            layers: {
                base: {
                    default: {
                        server: 'https://map.ir/shiveh',
                        layers: 'Shiveh:ShivehGSLD256',
                        format: 'image/png',
                    },
                },
            },
	});
        $.sMap.zoomControl.implement();
	$.sMap.features();

	$.sMap.features.marker.create({
            name: 'test-marker',

            latlng: {
                lat: 29.456555,
                lng: 52.579494,
            },
	});
    })

</script>
@endsection