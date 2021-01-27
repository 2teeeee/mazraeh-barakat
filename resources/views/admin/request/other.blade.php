@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
                ارائه درخواست VIP
            </h4>
        </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            
            <form method="POST" action="{{ route('request/saveOther',$model->id) }}">
                @csrf

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="vipType" class="col-form-label text-md-right">{{ __('validation.attributes.vipType') }}</label>
                        <select name="vipType" id="location" class="form-control {{ $errors->has('vipType') ? ' is-invalid' : '' }}">
                            <option disabled selected value> -- نوع خدمت مورد نظرتان را انتخاب کنید -- </option>
                            @foreach ($vipType as $vip)
                                <option {{ (old('vipType') == $vip->id)?'selected':'' }} value="{{ $vip->id }}">{{ $vip->title }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('vipType'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('vipType') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>
                        <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address')?old('address'):Auth::user()->address }}" >
                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="mobile" class="col-form-label text-md-right">{{ __('validation.attributes.mobile') }}</label>
                        <input id="mobile" type="text" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile')?old('mobile'):Auth::user()->mobile }}" >
                        @if ($errors->has('mobile'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="send_date" class="col-form-label text-md-right">{{ __('validation.attributes.send_date') }}</label>
                        <input id="send_date" type="text" class="form-control {{ $errors->has('send_date') ? ' is-invalid' : '' }}" name="send_date" value="{{ old('send_date')?old('send_date'):'' }}" >
                        @if ($errors->has('send_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('send_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.end_step') }}
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
$("#send_date").persianDatepicker();
    
        
</script>
@endsection