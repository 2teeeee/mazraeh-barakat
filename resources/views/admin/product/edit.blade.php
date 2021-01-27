@extends('layouts.admin')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all()) }}
        </div>
            <div class="panel-body">
            <form method="POST" action="{{ route('product/update', $model->id) }}" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                @csrf

                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-6">
                        <label for="title" class="col-form-label text-md-right">{{ __('validation.attributes.title') }}</label>
                        <input id="title" type="text" class="form-control {{ $errors->has('natitleme') ? ' is-invalid' : '' }}" name="title" value="{{ old('title')?old('title'):$model->title }}" >
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="code" class="col-form-label text-md-right">{{ __('validation.attributes.code') }}</label>
                        <input id="code" type="text" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" value="{{ old('code')?old('code'):$model->code }}" >
                        @if ($errors->has('code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="bagValue" class="col-form-label text-md-right">{{ __('validation.attributes.bagValue') }}</label>
                        <input id="bagValue" type="text" class="form-control {{ $errors->has('bagValue') ? ' is-invalid' : '' }}" name="bagValue" value="{{ old('bagValue')?old('bagValue'):$model->bagValue }}" >
                        @if ($errors->has('bagValue'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('bagValue') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="price" class="col-form-label text-md-right">{{ __('validation.attributes.price') }}</label>
                        <input id="price" type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price')?old('price'):$model->price }}" >
                        @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
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

</script>
@endsection