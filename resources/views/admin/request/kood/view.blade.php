
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            
            <h5>
            درخواست کود شماره {{ $model->id }}
            </h5>
        </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <div class="row justify-content-center border py-2">
                <div class="col-md-9">
                    {{ $model->location->title }}
                </div>
                <div class="col-md-3">
                    {{ jdate($model->created_at)->format('%Y/%m/%d ساعت: H:i:s ') }}
                </div>
                
                @if($model->payStatus != 0)
                    <div class="col-md-3" style="text-align: center;">
                        <span style="width:100%;float: right;">فرآیند شما به اتمام رسیده<br/> میزان رضایت خود را ثبت کنید</span>
                        <form class="rating">
                            <label>
                                <input type="radio" {{ ($model->rate == 1)?"checked":"" }} name="stars" value="1" />
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" {{ ($model->rate == 2)?"checked":"" }} name="stars" value="2" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" {{ ($model->rate == 3)?"checked":"" }} name="stars" value="3" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>   
                            </label>
                            <label>
                                <input type="radio" {{ ($model->rate == 4)?"checked":"" }} name="stars" value="4" />
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" {{ ($model->rate == 5)?"checked":"" }} name="stars" value="5" />
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
            <div class="row card-header">
                مکان مزرعه
            </div>
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ostan") }}: {{ $model->location->ostan?$model->location->ostan->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.city") }}: {{ $model->location->city?$model->location->city->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bakhsh") }}: {{ $model->location->bakhsh }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mantaghe") }}: {{ $model->location->mantaghe }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.roosta") }}: {{ $model->location->roosta }}</div>
                <div class="col-md-9 border border-top-0 py-2">{{ trans("validation.attributes.address") }}: {{ $model->location->address }}</div>
                
            </div>
            <div class="row card-header">
                اطلاعات محصول در حال کشت برای درخواست:
            </div>
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mahsool_name") }}: {{ $model->info?$model->info->product->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_sath") }}: {{ $model->info?$model->info->sath_value:"" }} {{ $model->info->sath_type?"متر مربع":"هکتار" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_date") }}: {{ $model->zamin?$model->zamin->keshtDate:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_type") }}: {{ $model->zamin?$model->zamin->keshtType->title:"" }}</div>
                
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bazr_type") }}: {{ $model->info?$model->info->bazr->title:"" }}</div>
                
<?php /*                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ab_ec") }}: {{ $model->info?$model->info->abType->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.khak_ec") }}: {{ $model->info?$model->info->khakColor->title:"" }}</div>
*/ ?>                <div class="col-md-9 border border-top-0 py-2"> </div>
                <?php /*
                <div class="col-md-12 border border-top-0 py-2">
                    {{ trans("validation.attributes.kood_type") }}: 
                    @foreach($model->koods as $kood)
                        {{ $kood->kood?$kood->kood->title:"" }}
                    @endforeach
                </div>
                
                <div class="col-md-6 border border-top-0 py-2">
                    {{ trans("validation.attributes.alafType") }}: 
                    @foreach($model->alafs as $alaf)
                        {{ $alaf->alaf?$alaf->alaf->title:"" }}
                    @endforeach
                </div>
                <div class="col-md-6 border border-top-0 py-2">
                    {{ trans("validation.attributes.alafkoshType") }}: 
                    @foreach($model->alafkoshs as $alafkosh)
                        {{ $alafkosh->alafkosh?$alafkosh->alafkosh->title:"" }}
                    @endforeach
                </div>
                */ ?>
            </div>
            @if($model->getKood)
                <div class="row card-header">
                    کود درخواستی:
                </div>
                <div class="row">
                    <div class="col-md-3 border border-top-0 py-2">نام کود: {{ $model->getKood->product->title }}</div>
                    <div class="col-md-3 border border-top-0 py-2">مقدار: {{ $model->getKood->value }}</div>
                    <div class="col-md-6 border border-top-0 py-2">نوع ارسال: {{ $model->getKood->sendType?$model->getKood->sendType->title:"" }}</div>
                </div>
            @endif
            @if($model->status >= 1)
            <div class="row">
                <div class="col-sm-12">

                
                @if($model->status == 8)
                <div class="row">
                    <div class="card-header col-md-12">
                        <h4>پیشنهادات ارائه شده</h4>
                    </div>
                    <div class="card col-md-12">
                    @foreach($model->order->offers as $store)
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
                
                @if($model->status > 8)
                <div class="row">
                    <div class="card-header col-md-12">
                        <h4>پیشنهاد تایید شده</h4>
                    </div>
                    <div class="card col-md-12">
                        <div class="card-body row border border-success">
                            @if($model->order->offerSelect())
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 border py-2">نام فروشگاه: {{ $model->order->offerSelect()->store?$model->order->offerSelect()->store->title:"" }}</div>
                                        <div class="col-md-4 border py-2">قیمت ارائه شده: {{ $model->order->offerSelect()->sumPrice() }} {{ trans('validation.attributes.toman') }}</div>
                                        <div class="col-md-4 border py-2">تاریخ ارسال: {{ $model->order->offerSelect()->sendTime }}</div>
                                        <div class="col-md-12 border border-top-0 py-2">توضیحات: {{ $model->order->offerSelect()->comment }}</div>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
                @endif
                
                @foreach($model->others as $other)
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
                
                @if($model->payStatus == 1)
<?php /*                    <div class="row">
                        <div class="card-header col-md-12">
                            <h4>اطلاعات پرداخت</h4>
                        </div>
                        <div class="card col-md-12">
                            <div class="card-body row border border-success">
                                @if($model->paymentOk())
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
                            {{ number_format($model->paymentSum()) }} {{ trans('validation.attributes.toman') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 border border-top-0 py-2">
                            مبلغ مانده:
                        </div>
                        <div class="col-md-3 border border-top-0 py-2">
                            {{ number_format($totalSum-$model->paymentSum()) }} {{ trans('validation.attributes.toman') }}
                        </div>
                    </div>
                    
                </div>
                @if($model->status > 7)
                <div class="row my-2">
                    <div class="col-md-12">
                        @if($model->payStatus == 0)
                            <a href="{{ url('pay/'.$model->id) }}" class="btn btn-success ml-2">پرداخت فاکتور</a>
                            <a href="{{ url('request/other/'.$model->id) }}" class="btn btn-info ml-2">درخواست خدمات دیگر</a>
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
        var id = {{ $model->id }};
        
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