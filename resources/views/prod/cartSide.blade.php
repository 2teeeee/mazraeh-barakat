@if(!Cart::isEmpty())
<div class="row panel panel-info" style="margin-top:20px;">
    <div class="panel-heading">
    <h4>سبد خرید</h4>
    </div>
    <div class="panel-body">
        @foreach(Cart::getContent() as $item)
        <div class="row">
            <div class="col-sm-3 padding-0">
                <img src="{{ asset('images/'.$item->attributes->image) }}" style="width:100%;margin-right:3px;" />
                
            </div>
            <div class="col-sm-9">
                <h6>{{ $item->name }}</h6>
                {{ trans('validation.attributes.price') }}: {{ $item->price }} {{ trans('validation.attributes.toman') }}
                <br/>
                {{ trans('validation.attributes.numb') }}: 
                    <input type="text" value="{{ $item->quantity }}" style="width:40px" maxlength="3" id='pr-{{ $item->id }}' onchange="inc2({{ $item->id }})" />
                <div class="remove-card">
                    <a href="{{ url('product/remove/'.$item->id) }}" ><i class="fa fa-remove"></i> {{ trans('validation.attributes.remove') }}</a>
                </div>
            </div>
            
        </div>                            
        <hr/>
        @endforeach
    </div>
    <div class="panel-footer" style="padding-bottom: 10px;">
        <p>
            {{ trans('validation.attributes.sum') }}: <span id='sum-total'>{{ Cart::getTotal() }}</span> {{ trans('validation.attributes.toman') }}
        </p>

        <a href="{{ url('product/getAddress') }}" class="btn btn-info">
            <i class="fa fa-arrow-left"></i>
            {{ trans('validation.next_sale') }}
        </a>
    </div>
</div>

<script>
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

@endif
