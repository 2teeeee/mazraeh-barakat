@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
            فرم ارسال ضمایم برای درخواست سم
            </h4>
        </div>
    <div class="">
        {!! $grid->make() !!}
    </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            
            <form method="POST" action="{{ route('request/getFile', $model->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="file" class="col-form-label text-md-right">عکس مشکل محصول خود را ارسال کنید</label>
                        <input id="file" type="file" accept="image/*;capture=camera"  class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" value="{{ old('file') }}" >
                        @if ($errors->has('file'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>                    
                    <div class="form-group col-sm-6">
                        <label for="sound" class="col-form-label text-md-right">مشکل محصول خود را ضبط و ارسال کنید</label>
                        <input id="sound" type="file" accept="audio/*;capture=microphone" class="form-control {{ $errors->has('sound') ? ' is-invalid' : '' }}" name="sound" value="{{ old('sound') }}" >
                        @if ($errors->has('sound'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sound') }}</strong>
                            </span>
                        @endif
                    </div>                    
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="comment" class="col-form-label text-md-right">{{ __('validation.attributes.comment') }}</label>
                        <textarea id="comment" class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" >{{ old('comment') }}</textarea>
                        @if ($errors->has('comment'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('comment') }}</strong>
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
                            <a href="{{ url('request/endSave/'.$model->id) }}" class="btn btn-success">
                                {{ __('validation.attributes.end_step') }}
                            </a>
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
});
	
        $("#ab_start_date").persianDatepicker();
        $("#kesht_date").persianDatepicker();
</script>
@endsection