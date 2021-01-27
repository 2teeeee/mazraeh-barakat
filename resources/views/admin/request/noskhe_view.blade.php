
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            
            <h5>
            نسخه درخواست رفع آفت شماره {{ $model->request_id }}
            </h5>
        </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <div class="row justify-content-center border py-2">
                <div class="col-md-9">
                    کلینیک: {{ $model->clinic?$model->clinic->name:"" }}
                </div>
                <div class="col-md-3">
                    {{ jdate($model->created_at)->format('%Y/%m/%d ساعت: H:i:s ') }}
                </div>
                
                @if($model->request->payStatus != 0)
                    <div class="col-md-3" style="text-align: center;">
                        <span style="width:100%;float: right;">فرآیند شما به اتمام رسیده<br/> میزان رضایت خود را ثبت کنید</span>
                        <form class="rating">
                            <label>
                                <input type="radio" {{ ($model->request->rate == 1)?"checked":"" }} name="stars" value="1" />
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" {{ ($model->request->rate == 2)?"checked":"" }} name="stars" value="2" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" {{ ($model->request->rate == 3)?"checked":"" }} name="stars" value="3" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>   
                            </label>
                            <label>
                                <input type="radio" {{ ($model->request->rate == 4)?"checked":"" }} name="stars" value="4" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" {{ ($model->request->rate == 5)?"checked":"" }} name="stars" value="5" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                        </form>
                    </div>
                @endif
            </div>
            <div class="row border border-top-0 py-2">
                <div class="col-md-12">
                    تشخیص: {{ $model->tashkhis }}
                </div>
            </div>
            @if($model->status == 4)
                <div class="row mt-2 alert alert-info">شما کلینیک را انتخاب کرده اید. منتظر ارائه نسخه از طرف کلینیک باشید.</div>
            @endif
            @if($model->status >= 5)
            <div class="row">
                <div class="col-sm-12">

                <form method="POST" action="{{ route('request/saveRequestStore', $model->id) }}" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                @csrf
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-condensed grid" id="relTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="title title">
                                        <span>{{ trans('validation.attributes.noskhe_title') }}</span>
                                    </th>	
                                    <th class="disc disc">
                                        <span>{{ trans('validation.attributes.noskhe_disc') }}</span>
                                    </th>	
                                    <th class="formul formul">
                                        <span>{{ trans('validation.attributes.noskhe_formul') }}</span>
                                    </th>	
                                    <th class="food food">
                                        <span>{{ trans('validation.attributes.noskhe_food') }}</span>
                                    </th>	
                                    <th class="ravesh ravesh">
                                        <span>{{ trans('validation.attributes.noskhe_ravesh') }}</span>
                                    </th>	
                                    <th class="mizan mizan">
                                        <span>{{ trans('validation.attributes.noskhe_mizan') }}</span>
                                    </th>	
                                    <th class="behtarin_zaman behtarin_zaman">
                                        <span>{{ trans('validation.attributes.noskhe_behtarin_zaman') }}</span>
                                    </th>	
                                </tr>										</tr>
                            </thead>			
                            <tbody>
                                    @foreach($model->items as $item)
                                    <tr id='row-{{ $item->id }}'>
                                        <th>
                                            <input type="checkbox" {{ $item->status?"checked":"" }} value="{{ $item->id }}" name="sel[]" />
                                        </th>
                                        <td class='field noskhe_title'>
                                            {{ $item->product?$item->product->title:"" }}
                                        </td>
                                        <td class='filed noskhe_disc'>
                                            {{ $item->disc }}
                                        </td>
                                        <td class='field noskhe_formul'>
                                            {{ $item->formul }}
                                        </td>
                                        <td class='field noskhe_food'>
                                            {{ $item->food }}
                                        </td>
                                        <td class='field noskhe_ravesh'>
                                            {{ $item->ravesh }}
                                        </td>
                                        <td class='field noskhe_mizan'>
                                            {{ $item->mizan }}
                                        </td>
                                        <td class='field noskhe_behtarin_zaman'>
                                            {{ $item->behtarin_zaman }}
                                        </td>
                                    </tr>                                    
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="address" class="col-form-label text-md-right">{{ __('validation.attributes.send_address') }}</label>
                        <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address')?old('address'):(($model->status == 5)?Auth::user()->address:$model->send_address) }}" >
                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="mobile" class="col-form-label text-md-right">{{ __('validation.attributes.send_mobile') }}</label>
                        <input id="mobile" type="text" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile')?old('mobile'):(($model->status == 5)?Auth::user()->mobile:$model->send_mobile) }}" >
                        @if ($errors->has('mobile'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="send_date" class="col-form-label text-md-right">{{ __('validation.attributes.send_date') }}</label>
                        <input id="send_date" type="text" class="form-control {{ $errors->has('send_date') ? ' is-invalid' : '' }}" name="send_date" value="{{ old('send_date')?old('send_date'):(($model->status == 5)?'':$model->send_date) }}" >
                        @if ($errors->has('send_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('send_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        @if($model->status == 5)
                        <button type="submit" class="btn btn-primary">
                            {{ __('validation.attributes.save_request') }}
                        </button>
                        @elseif($model->status == 6)
                        <div class="alert alert-warning">درخواست شما قبلا ثبت شده. منتظر اعلام قیمت از طرف فروشگاه باشید.</div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('validation.attributes.update_request') }}
                        </button>
                        @endif
                    </div>
                </div>
                </form>
                @if($model->status == 7)
                <div class="row">
                    <div class="card-header col-md-12">
                        <h4>پیشنهادات ارائه شده</h4>
                    </div>
                    <div class="card col-md-12">
                    @foreach($model->request->order->offers as $store)
                        <div class="card-body border-bottom row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4 border py-2">نام فروشگاه: {{ $store->store?$store->store->title:"" }}</div>
                                    <div class="col-md-4 border py-2">قیمت ارائه شده: {{ $store->sumPrice() }} {{ trans('validation.attributes.toman') }}</div>
                                    <div class="col-md-4 border py-2">تاریخ ارسال: {{ $store->sendTime }}</div>
                                    <div class="col-md-12 border border-top-0 py-2">توضیحات: {{ $store->comment }}</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ url('request/storeSelect/'.$store->id) }}" class="btn btn-success float-left">انتخاب</a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                @endif
                
                @if($model->status == 8)
                <div class="row">
                    <div class="card-header col-md-12">
                        <h4>پیشنهادات تایید شده</h4>
                    </div>
                    <div class="card col-md-12">
                        <div class="card-body row border border-success">
                            @if($model->request->order->offerSelect())
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 border py-2">نام فروشگاه: {{ $model->request->order->offerSelect()->store?$model->request->order->offerSelect()->store->title:"" }}</div>
                                        <div class="col-md-4 border py-2">قیمت ارائه شده: {{ $model->request->order->offerSelect()->sumPrice() }} {{ trans('validation.attributes.toman') }}</div>
                                        <div class="col-md-4 border py-2">تاریخ ارسال: {{ $model->request->order->offerSelect()->sendTime }}</div>
                                        <div class="col-md-12 border border-top-0 py-2">توضیحات: {{ $model->request->order->offerSelect()->comment }}</div>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
                @endif
                
                @foreach($model->request->others as $other)
                <div class="row">
                    <div class="card-header col-md-12">
                        <h4>{{ $other->type?$other->type->title:"" }} شماره {{ $other->id }}</h4>
                    </div>
                    <div class="card col-md-12">
                        @if($other->hasOffer)
                            @if($other->selectOffer())
                                <div class="card-body row border border-success">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 border py-2">نام شرکت: {{ $other->selectOffer()->store?$other->selectOffer()->store->title:"" }}</div>
                                            <div class="col-md-4 border py-2">قیمت ارائه شده: {{ $other->selectOffer()->price }} {{ trans('validation.attributes.toman') }}</div>
                                            <div class="col-md-4 border py-2">تاریخ انجام: {{ $other->selectOffer()->sendTime }}</div>
                                            <div class="col-md-12 border border-top-0 py-2">توضیحات: {{ $other->selectOffer()->comment }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach($other->offers as $store)
                                    <div class="card-body border-bottom row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4 border py-2">نام شرکت: {{ $store->store?$store->store->title:"" }}</div>
                                                <div class="col-md-4 border py-2">قیمت ارائه شده: {{ $store->price }} {{ trans('validation.attributes.toman') }}</div>
                                                <div class="col-md-4 border py-2">تاریخ انجام: {{ $store->sendTime }}</div>
                                                <div class="col-md-12 border border-top-0 py-2">توضیحات: {{ $store->comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ url('request/afatkoshShopSelect/'.$store->id) }}" class="btn btn-success float-left">انتخاب</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @else 
                            <div class="alert alert-warning">درخواست شما قبلا ثبت شده. منتظر اعلام قیمت از طرف شرکت دفع آفات باشید.</div>
                        @endif
                    </div>
                </div>
                @endforeach
                
                @if($model->request->payStatus == 1)
<?php /*                    <div class="row">
                        <div class="card-header col-md-12">
                            <h4>اطلاعات پرداخت</h4>
                        </div>
                        <div class="card col-md-12">
                            <div class="card-body row border border-success">
                                @if($model->storeSelect())
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 border py-2">کد پرداخت: {{ ltrim($model->samRequest->payAuthority,0) }}</div>
                                            <div class="col-md-12 border py-2">زمان پرداخت: {{ jdate($model->samRequest->payTime)->format('%Y/%m/%d ساعت H:i:s ') }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> */ ?>
                @endif
                
                <div class="card-body">
                    <div class="row card-header">
                        فاکتور پرداخت
                    </div>
                    <div class="row">
                        <div class="col-md-3 border border-top-0 py-2">
                            مبلغی که باید پرداخت شود:
                        </div>
                        <div class="col-md-3 border border-top-0 py-2">
                            {{ number_format($totalSum) }} {{ trans('validation.attributes.toman') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 border border-top-0 py-2">
                            مبلغ پرداخت شده:
                        </div>
                        <div class="col-md-3 border border-top-0 py-2">
                            {{ number_format($model->request->paymentSum()) }} {{ trans('validation.attributes.toman') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 border border-top-0 py-2">
                            مبلغ مانده:
                        </div>
                        <div class="col-md-3 border border-top-0 py-2">
                            {{ number_format($totalSum-$model->request->paymentSum()) }} {{ trans('validation.attributes.toman') }}
                        </div>
                    </div>
                    
                </div>
                
                @if($model->status > 7)
                <div class="row my-2">
                    <div class="col-md-12">
                        @if($model->request->payStatus == 0)
                            <a href="{{ url('pay/'.$model->request->id) }}" class="btn btn-success ml-2">پرداخت فاکتور</a>
                            <a href="{{ url('request/other/'.$model->request->id) }}" class="btn btn-info ml-2">درخواست خدمات دیگر</a>
                        @else
<!--                            <a href="#recipt" class="btn btn-success ml-2">مشاهده فاکتور</a>-->
                        @endif
                        
                    </div>
                </div>
                @endif
                
                </div>
            </div>
            @endif
        </div>
            
    </div>

</div>

@stop


@section('script')
<script type="text/javascript">
    $("#send_date").persianDatepicker();

    setInterval(myMethod, 10000);

    function myMethod( )
    {
        location.reload();
    }
    $(':radio').change(function() {
        var rate = this.value;
        var id = {{ $model->request_id }};
        
        $.ajax({
                type: "GET",
                url: '{{ url("request/rate") }}',
                data: {id: id, rate:rate},
                success: function(result) {
                    location.reload();
                }
            });
        });
</script>
@endsection