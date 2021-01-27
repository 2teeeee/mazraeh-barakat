@extends('layouts.main')

@section('content')
<div class="container">
        @if(Cart::isEmpty())
        <div class="col-sm-12">
            <div class="alert alert-warning">
                سبد خرید شما خالی می باشد...
            </div>
        </div>
        @else
                <div class="card-header col-md-12">
                <h4>سبد خرید</h4>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-9" style="border-left: 1px solid rgba(0,0,0,.125)">
                    @foreach(Cart::getContent() as $item)
                    <div class="row p-2">
                        <div class="col-sm-1 p-0">
                            <a href="{{ url('prod/remove/'.$item->id) }}" class="btn btn-danger" style="margin: 40px 0;color:#FFFFFF;" title="{{ trans('validation.attributes.remove') }}" ><i class="far fa-trash-alt"></i></a>
                        </div>
                        <div class="col-sm-2 padding-0">
                            <img src="{{ asset('image/'.$item->attributes->image) }}" style="width:100%;margin-right:3px;" />
                        </div>
                        <div class="col-sm-4">
                            <h4>{{ $item->name }}</h4>
                            <p>{{$item->attributes->comment }}</p>
                        </div>
                        <div class="col-sm-5 basket-vertical-center">
                            <div class="col-sm-5 padding-0">
                                {{ trans('validation.attributes.numb') }} 
                                <input type="text" value="{{ $item->quantity }}" style="width:40px" maxlength="3" id='pr-{{ $item->id }}' onchange="inc2({{ $item->id }})" />
                            </div>
                            <div class="col-sm-7">
                                {{ trans('validation.attributes.price') }}: {{ $item->price }} {{ trans('validation.attributes.toman') }}
                            </div>
                        </div>

                    </div>                            
                    <hr/>
                    @endforeach
                    </div>
                    <div class="col-sm-3">
                        <div class="card-body"> 
                            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
                        </div>
                        <form method="POST" action="{{ url('prod/endSale') }}" >
                            @csrf
                        <p>
                            {{ trans('validation.attributes.sum') }}: <span id='sum-total'>{{ Cart::getTotal() }}</span> {{ trans('validation.attributes.toman') }}
                        </p>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="mobile" class="col-form-label text-md-right">{{ __('validation.attributes.mobile') }}</label>
                                <input id="mobile" type="text" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" >
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="name" class="col-form-label text-md-right">{{ __('validation.attributes.name') }}</label>
                                <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" >
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.address') }}</label>
                                <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('adddress') }}" >
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" disabled="true">
                                    <i class="fa fa-arrow-left"></i>
                            {{ trans('validation.attributes.pay') }}
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        @endif
</div>
    
@endsection


@section('script')

<script>
    function inc2(id)
    {
        numb = $('#pr-'+id).val();
        
        $.ajax({
            type: 'GET',
            url: "{{ url('prod/inc') }}",
            data: {id:id ,numb:numb }, 
            success: function(result){
                $("#sum-total").text(result);
              //  b = val*pr;
              //  $("#p"+id).text(" "+b+" نومان");
            }
        });
        
    }
</script>
@endsection
