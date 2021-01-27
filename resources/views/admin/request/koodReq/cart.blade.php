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
                @if (Session::has('error'))
                    <div class="alert alert-danger my-2">{{ Session::get('error') }}</div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success my-2">{{ Session::get('success') }}</div>
                @endif
	
                    <div class="alert alert-info my-2">مبلغ بدهی / بستانکار اختلاف کود خریداری شده شما با مبلغ اعلامی جدید می باشد.</div>
	
                    <div class="alert alert-danger"> برای دریافت سهمیه سایر محصولات کشت شده ی خود به صفحه اصلی رفته و درخواست محصول مورد نظر خود را ثبت کنید.
                        <br/>
                        <a href="{{ url('profile/index.html') }}">بازگشت به صفحه اصلی</a> 
                    </div>
                    
                <div class="row mx-0 mb-2">
                    
                    <div class="col-sm-9" style="border-left: 1px solid rgba(0,0,0,.125)">
                        <?php $sendVal = 0; ?>
                    @foreach(Cart::getContent() as $item)
                    <?php $sendVal = $sendVal + $item->attributes->req->send->value; ?>
                    <div class="row p-2">
                        <div class="col-sm-1 p-0">
                            <a href="{{ url('koodReq/remove/'.$item->id) }}" class="btn btn-danger" style="margin: 40px 0;color:#FFFFFF;" title="{{ trans('validation.attributes.remove') }}" ><i class="far fa-trash-alt"></i></a>
                        </div>
<!--                        <div class="col-sm-2 padding-0">
                            <img src="{{ asset('image/'.$item->attributes->image) }}" style="width:100%;margin-right:3px;" />
                        </div>-->
                        <div class="col-sm-6">
                            <h5>کود {{ $item->name }}</h5>
                            <p class="mb-0">محصول کشت شده: {{ $item->attributes->req->product->title }} {{ $item->attributes->req->ab->title }}</p>
                            <p class="mb-0">شهرستان: {{ $item->attributes->req->ct?$item->attributes->req->ct->title:"" }}</p>
                            @if($item->attributes->req->send->id == 164)
                            <p class="mb-0">هزینه ارسال: {{ number_format($item->attributes->req->send->value) }} ریال</p>
                            @else 
                            <p class="mb-0">هزینه ارسال: توافقی با کارگزار</p>
                            @endif
                            <p class="mb-0">کارگزار: {{ $item->attributes->req->broker->name }} ({{ $item->attributes->req->broker->company }})</p>
                        </div>
                        <div class="col-sm-5 basket-vertical-center">
                            <div class="col-sm-12 padding-0">
                                {{ trans('validation.attributes.numb') }}: 
                                <span>{{ $item->quantity }} کیسه 50 کیلویی</span>
                            </div>
                            <div class="col-sm-12">
                                {{ trans('validation.attributes.price') }} واحد: {{ number_format($item->price) }} {{ trans('validation.attributes.toman') }}
                            </div>
                            <div class="col-sm-12">
                                مجموع : {{ number_format($item->price * $item->quantity) }} {{ trans('validation.attributes.toman') }}
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
                        <form method="POST" action="{{ url('koodReq/endSale') }}" >
                            @csrf
                            <div>
                                {{ trans('validation.attributes.sum') }}: <span id='sum-total'>{{ number_format(Cart::getTotal()) }}</span> {{ trans('validation.attributes.toman') }}
                            </div>
                            <div>
                                هزینه ارسال: {{ number_format($sendVal) }} ریال
                            </div>
                            <div>
                                بدهی / بستانکار: 
								
								<span style="color: {{ ($credit>=0)?'black':'red' }}"><span dir="ltr">0</span> ریال</span>
							
							</div>
                            <div class="border-top mt-2 py-2">
                                مجموع کل: {{ number_format($sendVal + Cart::getTotal()) }} ریال
                            </div>
<!--                        <div class="row">
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
                        </div>-->
                        <div class="form-group row mb-0 mt-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-arrow-left"></i>
                                    ثبت نهایی درخواست ها
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