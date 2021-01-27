@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all()) }}
        </div>
            <div class="panel-body">
            <form method="POST" action="{{ route('clinic/update', $model->id) }}" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                @csrf

                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-6">
                        <label for="user_id" class="col-form-label text-md-right">{{ __('validation.attributes.user') }}</label>
                        <select name="user_id" id="user_id" class="form-control {{ $errors->has('user_id') ? ' is-invalid' : '' }}">
                        @foreach ($users as $user)
                            <option {{ ($model->user_id == $user->id)?"selected":"" }} value="{{ $user->id }}">{{ $user->name." - ".$user->codemelli }}</option>
                        @endforeach
                        </select>
                        @if ($errors->has('user_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('user_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="name" class="col-form-label text-md-right">{{ __('validation.attributes.name') }}</label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')?old('name'):$model->name }}" >
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
                        <input id="bakhsh" type="text" class="form-control {{ $errors->has('bakhsh') ? ' is-invalid' : '' }}" name="bakhsh" value="{{ old('bakhsh')?old('bakhsh'):$model->bakhsh }}" >
                        @if ($errors->has('bakhsh'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bakhsh') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="mantaghe" class="col-form-label text-md-right">{{ __('validation.attributes.mantaghe') }}</label>
                        <input id="mantaghe" type="text" class="form-control {{ $errors->has('mantaghe') ? ' is-invalid' : '' }}" name="mantaghe" value="{{ old('mantaghe')?old('mantaghe'):$model->mantaghe }}" >
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
                        <input id="roosta" type="text" class="form-control {{ $errors->has('roosta') ? ' is-invalid' : '' }}" name="roosta" value="{{ old('roosta')?old('roosta'):$model->roosta }}" >
                        @if ($errors->has('roosta'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('roosta') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="utm" class="col-form-label text-md-right">{{ __('validation.attributes.utm') }}</label>
                        <input id="utm" type="text" class="form-control {{ $errors->has('utm') ? ' is-invalid' : '' }}" name="utm" value="{{ old('utm')?old('utm'):$model->utm }}" >
                        @if ($errors->has('utm'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('utm') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-12">
                        <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>
                        <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address')?old('address'):$model->address }}" >
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
                        <input id="tel" type="text" class="form-control {{ $errors->has('tel') ? ' is-invalid' : '' }}" name="tel" value="{{ old('tel')?old('tel'):$model->tel }}" >
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
                        <input id="num_mojavez" type="text" class="form-control {{ $errors->has('num_mojavez') ? ' is-invalid' : '' }}" name="num_mojavez" value="{{ old('num_mojavez')?old('num_mojavez'):$model->num_mojavez }}" >
                        @if ($errors->has('num_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="num_nezam_mohandesi" class="col-form-label text-md-right">{{ __('validation.attributes.num_nezam_mohandesi') }}</label>
                        <input id="num_nezam_mohandesi" type="text" class="form-control {{ $errors->has('num_nezam_mohandesi') ? ' is-invalid' : '' }}" name="num_nezam_mohandesi" value="{{ old('num_nezam_mohandesi')?old('num_nezam_mohandesi'):$model->num_nezam_mohandesi }}" >
                        @if ($errors->has('num_nezam_mohandesi'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_nezam_mohandesi') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-4">
                        <label for="masool_fani" class="col-form-label text-md-right">{{ __('validation.attributes.masool_fani') }}</label>
                        <input id="masool_fani" type="text" class="form-control {{ $errors->has('masool_fani') ? ' is-invalid' : '' }}" name="masool_fani" value="{{ old('masool_fani')?old('masool_fani'):$model->masool_fani }}" >
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
                        <input id="date_start_mojavez" type="text" class="form-control {{ $errors->has('date_start_mojavez') ? ' is-invalid' : '' }}" name="date_start_mojavez" value="{{ old('date_start_mojavez')?old('date_start_mojavez'):$model->date_start_mojavez }}" >
                        @if ($errors->has('date_start_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('date_start_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label for="date_end_mojavez" class="col-form-label text-md-right">{{ __('validation.attributes.date_end_mojavez') }}</label>
                        <input id="date_end_mojavez" type="text" class="form-control {{ $errors->has('date_end_mojavez') ? ' is-invalid' : '' }}" name="date_end_mojavez" value="{{ old('date_end_mojavez')?old('date_end_mojavez'):$model->date_end_mojavez }}" >
                        @if ($errors->has('date_end_mojavez'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('date_end_mojavez') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.edit') }}
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