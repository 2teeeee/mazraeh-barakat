@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            
        <h5>
        ثبت درخواست بازدید میدانی
        </h5>
    </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('bazdidRequest/store') }}" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="sam_request_id" value="{{ $samRequest_id }}" />
                <input type="hidden" name="clinic_id" value="{{ $clinic_id }}" />
                
                <div class="row card-header">
                    مزرعه
                </div>
                <div class="row">
                    <div class="col-sm-3 border">
                        <label for="ostan" class="col-form-label text-md-right">{{ __('validation.attributes.ostan') }}</label>
                        <input id="ostan" type="hidden" name="ostan" value="{{ old('ostan')?old('ostan'):$request->bahrebardar->ostan }}" >:
                        <span>{{ $request->bahrebardar->ostanV->title }}</span>
                    </div>
                    
                    <div class="col-sm-3 border">
                        <label for="city" class="col-form-label text-md-right">{{ __('validation.attributes.city') }}</label>
                        <input id="city" type="hidden" name="city" value="{{ old('city')?old('city'):$request->bahrebardar->city }}" >:
                        <span>{{ $request->bahrebardar->cityV->title }}</span>
                    </div>
                    <div class="col-sm-3 border">
                        <label for="bakhsh" class="col-form-label text-md-right">{{ __('validation.attributes.bakhsh') }}</label>:
                        <input id="bakhsh" type="hidden" name="bakhsh" value="{{ old('bakhsh')?old('bakhsh'):$request->bahrebardar->bakhsh }}" >
                        <span>{{ $request->bahrebardar->bakhsh }}</span>
                    </div>
                    <div class="col-sm-3 border">
                        <label for="roosta" class="col-form-label text-md-right">{{ __('validation.attributes.roosta') }}</label>:
                        <input id="roosta" type="hidden" name="roosta" value="{{ old('roosta')?old('roosta'):$request->bahrebardar->roosta }}" >
                        <span>{{ $request->bahrebardar->roosta }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9 border border-top-0">
                        <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>:
                        <input id="address" type="hidden" name="address" value="{{ old('address')?old('address'):$request->bahrebardar->address }}" >
                        <span>{{ $request->bahrebardar->address }}</span>
                    </div>
                    <div class="col-sm-3 border border-top-0">
                        <label for="mobile" class="col-form-label text-md-right">{{ __('validation.attributes.mobile') }}</label>:
                        <input id="mobile" type="hidden" name="mobile" value="{{ old('mobile')?old('mobile'):$request->bahrebardar->mobile }}" >
                        <span>{{ $request->bahrebardar->mobile }}</span>
                    </div>    
                </div>
                <div class="row card-header">
                    اطلاعات محصول در حال کشت برای درخواست:
                </div>
                <div class="row">
                    <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mahsool_name") }}: {{ $request->mahsool?$request->mahsool->title:"" }}</div>
                    <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_sath") }}: {{ $request->kesht_sath }} {{ trans('validation.attributes.squareMeters') }}</div>
                    <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_date") }}: {{ $request->kesht_date }}</div>
                    <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_type") }}: {{ $request->keshtType?$request->keshtType->title:"" }}</div>
                </div>
                
                <div class="row card-header">
                    مبلغ بازدید: {{ number_format("40000") }} {{ trans("validation.attributes.toman") }}
                        <input id="price" type="hidden" name="price" value="{{ old('price')?old('price'):40000 }}" >
                    
                </div>
                <div class="panel-footer mt-2">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.pay') }}
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