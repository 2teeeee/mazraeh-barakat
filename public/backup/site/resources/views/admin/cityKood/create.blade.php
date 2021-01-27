@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-header text-center">
            <h4>
            افزایش سهمیه کود شهرستان {{ $model->title }}
            </h4>
        </div>
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body bg-white p-2">
            <form method="POST" action="{{ route('cityKood/store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    
                    <div class="form-group col-sm-6">
                        <label for="city" class="col-form-label text-md-right">شهرستان: </label>
                        <span>{{ $model->title }}</span>
                        <input id="id" type="hidden" class="form-control" name="id" value="{{ $model->id }}" >
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="kood" class="col-form-label text-md-right">کود: </label>
                        <span>{{ $kood->title }}</span>
                        <input id="kood" type="hidden" class="form-control" name="kood" value="{{ $kood->id }}" >
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="form-group col-sm-6">
                        <label for="value" class="col-form-label text-md-right">{{ __('validation.attributes.value') }} ({{ __('validation.attributes.tonne') }})</label>
                        <input id="value" type="text" class="form-control {{ $errors->has('value') ? ' is-invalid' : '' }} persian-number" name="value" value="{{ old('value') }}" >
                        @if ($errors->has('value'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('value') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                </div>
                
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                افزودن
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