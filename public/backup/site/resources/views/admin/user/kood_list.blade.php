@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('user/koodList', $model->id) }}">
                @csrf

                @foreach($kargozarKood as $key => $value)
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="kood_{{ $key }}" class="col-form-label text-md-right">{{ $value['name'] }}</label>
                        <input id="kood_{{ $key }}" type="text" class="form-control {{ $errors->has( $key ) ? ' is-invalid' : '' }}" name="kood[{{ $key }}]" value="{{ $value['value'] }}" autofocus>
                    </div>
                </div>
                @endforeach
                
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.save') }}
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
	
</script>
@endsection