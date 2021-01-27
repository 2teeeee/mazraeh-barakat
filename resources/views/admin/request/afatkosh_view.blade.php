
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
        <h5>
        {{ $order->type?$order->type->title:"" }} شماره ی  {{ $order->id }}
        </h5>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ostan") }}: {{ $model->location->ostan->title }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.city") }}: {{ $model->location->city->title }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bakhsh") }}: {{ $model->location->bakhsh }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mantaghe") }}: {{ $model->location->mantaghe }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.roosta") }}: {{ $model->location->roosta }}</div>
                <div class="col-md-9 border border-top-0 py-2">{{ trans("validation.attributes.address") }}: {{ $order->address }}</div>
                
                <div class="col-md-12 border border-top-0 py-2">
                    تاریخ انجام درخواستی: {{ $order->sendDate }}
                </div>            
            </div>
            <div class="row">
                <div class="col-sm-12">

                <form method="POST" action="{{ route('request/sendAnswerAfatkoshShop', $order->id) }}" enctype="multipart/form-data">
                @csrf
                {{ Form::hidden('order_id', $order->id) }}
                
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="price" class="col-form-label text-md-right">{{ __('validation.attributes.send_price') }}</label>
                        <input id="price" type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price')?old('price'):'' }}" >
                        @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="work_date" class="col-form-label text-md-right">{{ __('validation.attributes.date') }}</label>
                        <input id="work_date" type="text" class="form-control {{ $errors->has('work_date') ? ' is-invalid' : '' }}" name="work_date" value="{{ old('work_date')?old('work_date'):$order->sendDate }}" >
                        @if ($errors->has('work_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('work_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="comment" class="col-form-label text-md-right">{{ __('validation.attributes.send_comment') }}</label>
                        <input id="comment" type="text" class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{ old('comment')?old('comment'):'' }}" >
                        @if ($errors->has('comment'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('validation.attributes.save_request') }}
                        </button>
                    </div>
                </div>
                </form>
                </div>
            </div>
        </div>
            
    </div>

</div>

@stop

@section('script')
<script type="text/javascript">
    $("#work_date").persianDatepicker();
    
    function plusPrice() {
//        val = parseInt(val, 10);
//        a = parseInt($("#price").val(), 10);
//        var a = a + val;
        var sum = 0; 
        $(".tprice").each(function() {          
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }    
        });
        $("#price").val(sum);
    }
    
</script>
@endsection