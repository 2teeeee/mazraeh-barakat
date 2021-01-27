@extends('layouts.content')

@section('content')
        @if(Cart::isEmpty())
        <div class="col-sm-12">
            <div class="alert alert-warning">
                سبد خرید شما خالی می باشد...
            </div>
        </div>
        @else
            <div class="row panel panel-info" style="margin-left: 5px;">
                <div class="panel-heading">
                    <h4>سبد خرید</h4>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'product/recipt','id'=>'ff')) }}
                        <div class="col-sm-9" style="border-left: 1px solid rgba(0,0,0,.125)">
                            <div class="row">
                                <!-- if there are creation errors, they will show here -->
                                <div class="panel-body"> 
                                    {{ Html::ul($errors->all()) }}
                                </div>
                                <div class="panel-body">
                                    <div class=row>
                                        <div class="form-group col-sm-6">
                                            {{ Form::label('name', trans('validation.attributes.name')) }}
                                            {{ Form::text('name', Input::old('name')?Input::old('name'):(Auth::check()?Auth::user()->fullname():""), array('class' => 'form-control')) }}
                                        </div>
                                        <div class="form-group col-sm-6">
                                            {{ Form::label('tel', trans('validation.attributes.mobile')) }}
                                            {{ Form::text('tel', Input::old('tel')?Input::old('tel'):(Auth::check()?Auth::user()->mobile:""), array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class=row>
                                        <div class="form-group col-sm-12">
                                            {{ Form::label('address', trans('validation.attributes.address')) }}
                                            {{ Form::text('address', Input::old('address')?Input::old('address'):(Auth::check()?Auth::user()->address:""), array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="col-sm-3">
                            <p>
                                {{ trans('validation.attributes.sum') }}: <span id='sum-total'>{{ Cart::getTotal() }}</span> {{ trans('validation.attributes.toman') }}
                            </p>
                            <p>
                                {{ trans('validation.attributes.peyk_price') }}: <span id='peykp'>0</span> {{ trans('validation.attributes.toman') }}
                            </p>
                            <p>
                                {{ trans('validation.attributes.sum_total') }}: <span id='pay-total'>{{ Cart::getTotal() }}</span> {{ trans('validation.attributes.toman') }}
                            </p>
                            <input type="hidden" id="sumt" name="sumt" value="{{ Cart::getTotal() }}" />
                            <a href="#" class="btn btn-success" onclick="submit()">
                                <i class="fa fa-arrow-left"></i>
                                {{ trans('validation.attributes.save') }}
                            </a>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
        
@endsection

@section('script')
<script>
    function submit()
    {
        $("#ff").submit();
    }
    
    function inc2(id)
    {
        numb = $('#pr-'+id).val();
        
        $.ajax({
            type: 'GET',
            url: "{{ url('product/inc') }}",
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

