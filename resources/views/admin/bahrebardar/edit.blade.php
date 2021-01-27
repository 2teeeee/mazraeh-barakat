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
            <form method="POST" action="{{ route('bahrebardar/update', $model->id) }}" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                @csrf

                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-6">
                        <label for="title" class="col-form-label text-md-right">{{ __('validation.attributes.title') }}</label>
                        <input id="title" type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title')?old('title'):$model->title }}" >
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
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
                        <label for="num_pahne" class="col-form-label text-md-right">{{ __('validation.attributes.num_pahne') }}</label>
                        <input id="num_pahne" type="text" class="form-control {{ $errors->has('num_pahne') ? ' is-invalid' : '' }}" name="num_pahne" value="{{ old('num_pahne')?old('num_pahne'):$model->num_pahne }}" >
                        @if ($errors->has('num_pahne'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('num_pahne') }}</strong>
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
                        <label for="type" class="col-form-label text-md-right">{{ __('validation.attributes.type') }}</label>
                        <select name="type" id="user_id" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                        @foreach ($types as $type)
                            <option {{ ($model->type == $type->id)?"selected":"" }} value="{{ $type->id }}">{{ $type->title }}</option>
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