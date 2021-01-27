@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12 bg-white p-2 rounded">
    <div class="card-header text-center">
<!--            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>-->
            <h4>
            فرم درخواست کود برای مزرعه {{ $zaminkesht->product?$zaminkesht->product->title:'' }} واقع در شهرستان  {{ $zaminkesht->ct?$zaminkesht->ct->title:"" }}
            </h4>
        </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
            @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('koodReq/store') }}">
                @csrf
                
				@if($zaminkesht->product_id == 1)
				<div class="row m-0 p-2 mt-2 alert alert-warning">
				بدلیل بروز رسانی هفتگی اطلاعات محصولات تحویلی در صورتی که میزان تحویل نمایش داده شده مغایرت دارد. لطفا ۷ تا ۱۰ روز پس از تاریخ تحویل محصولتان جهت ثبت درخواست کود به سامانه مراجعه فرمایید.
				</div>
					@if($shotValue)
					<div class="row m-0 p-2 mt-2 alert alert-info">
						<span>بهره بردار محترم؛ کل سهمیه کود اوره برای محصول</span>&nbsp;
						<strong>{{ $zaminkesht->product->title }}</strong>&nbsp;
						<span> شما </span>&nbsp;
						<strong>{{ number_format($shotValue / 13 / 50) }} کیسه 50 کیلویی</strong>&nbsp;
						<span>بوده که در این مرحله فعلا</span>&nbsp;
						<strong> 
							@if(($shotValue / 13 / 50) >= (($pkv->value / 50) * $ProductSquare))
							<?php /*	
							{{ number_format(($pkv->value / 50) * $ProductSquare) }}
							*/ ?>
								{{ number_format(($shotValue / 13 / 50) * 30 / 100) }}
							@else
								{{ number_format(($shotValue / 13 / 50) * 30 / 100) }}
							@endif 
						کیسه
						</strong>&nbsp;
						 به شما تعلق می گیرد و در مرحله سرک الباقی سهمیه با تایید مسئول محترم پهنه قابل دریافت است.
					</div>
					@endif
				@endif
                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group col-sm-6">
                        <div>
                            <label class="col-form-label text-md-right">{{ __('validation.attributes.name') }}: </label>
                            {{ Auth::user()->name }}
                            <br/>
                            موبایل: {{ Auth::user()->mobile }}
                            @if(Auth::user()->info)
                                <br/>
                                {{ Auth::user()->info->city_name }},  {{ Auth::user()->info->mantaghe }}
                            @endif
                        </div>
                        <div>
                            <input name="prod_id" id="prod_id" value="{{ $zaminkesht->product_id }}" type="hidden" />
                            <input name="kesht_id" id="kesht_id" value="{{ $zaminkesht->id }}" type="hidden" />
                        </div>
                        <div>
                            <label for="kood_id" class="col-form-label text-md-right">{{ __('validation.attributes.kood_id') }} <span class="text-danger">*</span></label>
                            <select name="kood_id" id="kood_id" onchange="changeVal()" class="form-control {{ $errors->has('kood_id') ? ' is-invalid' : '' }}">
                                <option disabled selected value> -- کود مورد نظر خود را انتخاب کنید -- </option>
                                @foreach ($koods as $kood)
                                    <option {{ (old('kood_id') == $kood->id)?'selected':'' }} value="{{ $kood->id }}">{{ $kood->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('kood_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('kood_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <?php /*
                        <div class="mt-2">
                            <label for="numb" class="text-md-right">{{ __('validation.attributes.numb') }} درخواست  ( کیسه 50 کیلویی ) <span class="text-danger">*</span></label>
                            <input type="text" id="numb" name="numb" onkeyup="changeVal()" class="form-control {{ $errors->has('numb') ? ' is-invalid' : '' }} persian-number" value="{{ old('numb')?old('numb'):0 }}" />
                            <div class="text-danger mt-1" id="numbText"></div>
                            @if ($errors->has('numb'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('numb') }}</strong>
                                </span>
                            @endif
                        </div>
                         
                         */ ?>
                        <div class="form-group">
                            <label for="broker_id" class="col-form-label text-md-right">{{ __('validation.attributes.broker_id') }} <span class="text-danger">*</span></label>
                            <select name="broker_id" id="broker_id" onchange="changeVal()" class="form-control {{ $errors->has('broker_id') ? ' is-invalid' : '' }}">
                                <option disabled selected value> -- کارگزار را جهت دریافت کود انتخاب کنید -- </option>
                                @foreach ($brokers as $broker)
                                    <option {{ (old('broker_id') == $broker->user_id)?'selected':'' }} value="{{ $broker->user_id }}">{{ $broker->name }} ( {{ $broker->company }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('broker_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('broker_id') }}</strong>
                                </span>
                            @endif
                            <div class="alert alert-danger mt-2 d-none" id="check_broker">کارگزار انتخابی شما برای کود مورد نظرتان موجودی کافی ندارد. لطفا کارگزار دیگری انتخاب کنید.</div>
                        </div>
                        <div>
                            <label for="sendType" class="col-form-label text-md-right">{{ __('validation.attributes.sendType') }} <span class="text-danger">*</span></label>
                            <select name="sendType" id="sendType" onchange="changeVal()" class="form-control {{ $errors->has('sendType') ? ' is-invalid' : '' }}">
                                @foreach ($sendType as $kesht)
                                    <option {{ (old("sendType") == $kesht->id )?"selected":"" }} value="{{ $kesht->id }}">{{ $kesht->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('sendType'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('sendType') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div id="addressBox" class="col-form-label text-md-right {{ (old('sendType') == 165)?'':'d-none' }}">
                            <label for="address" class="text-md-right">{{ __('validation.attributes.address') }} گیرنده <span class="text-danger">*</span></label>
                            <input type="text" id="address" name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address')?old('address'):Auth::user()->address }}" />
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                    </div>
                    <div class="form-group col-sm-5">
                        <div class="border-primary rounded shadow mt-2">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">مساحت مزرعه: </th>
                                        <td><span id="ProductSquare">{{ str_replace('.','/', $ProductSquare) }}</span> هکتار</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">مقدار تحویل داده شده: </th>
                                        <td><span id="ProductSquare">{{ $maxShot?number_format($maxShot):0 }}</span> کیلوگرم</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">تعداد کود سهمیه:</th>
                                        <td><span id="koodNum">0</span> کیسه 50 کیلویی</td>
                                    </tr>
<!--                                    <tr>
                                        <th scope="row">تعداد کود اختصاص داده شده:</th>
                                        <td><span id="koodget">0</span> کیسه 50 کیلویی</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">تعداد کود باقی مانده:</th>
                                        <td><span id="koodRem">0</span> کیسه 50 کیلویی</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">تعداد کود  درخواستی:</th>
                                        <td><span id="numbReq">0</span> کیسه 50 کیلویی</td>
                                    </tr>-->
                                    <tr>
                                        <th scope="row">مبلغ هر کیسه کود:</th>
                                        <td><span id="total-item">0</span> ریال</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2">قیمت قطعی کود سفارش داده شده در زمان تحویل تعیین و تسویه حساب خواهد شد.</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">جمع کل قابل پرداخت:</th>
                                        <td><span id="total-price">0</span> ریال</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">هزینه ارسال کود:</th>
                                        <td><span id="sendValue">0 ریال</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="p-2 text-danger text-center mb-2">
                                حداکثر زمان تحویل کود اختصاصی به مدت 40 روز کاری خواهد بود.
                            </span>
                        </div>
                        
                    </div>
						
                </div>
                <div class="alert alert-warning">
                            <input name="check_zamin" id="check_zamin" value="1" type="checkbox" style="width:20px;height:20px;margin-left:10px;" {{ old('check_zamin')?"checked":"" }} />
                            <span for="check_zamin" class="col-form-label text-md-right">
							اطلاعات مربوط به زراعت و زمین کشاورزی اینجانب که توسط مسئول پهنه در سیستم ثبت گردیده مورد تایید اینجانب می باشد.
								<br/>
								در صورت مغایرت عواقب بعدی ناشی از آن بعهده اینجانب می باشد.
							</span>
							@if($errors->has('check_zamin'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('check_zamin') }}</strong>
                                </span>
                            @endif
                        </div>
				
                <div class="panel-footer mt-2">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                ثبت درخواست   
                            </button>
                            <a class="btn btn-danger text-white disabled d-none" id="btnNone">
                                برای محصول انتخابی شما کود مورد نظرتان تخصیص داده نمی شود.
                            </a>
                            
                    
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
    $('#sendType').select2({
        dir: "rtl"
    });
    $('#kood_id').select2({
        dir: "rtl",
    });
//    $('#prod_id').select2({
//        dir: "rtl",
//    });
    $('#broker_id').select2({
        dir: "rtl",
    });
});


    function changeVal() {
        var id = $('#kood_id :selected').val();
        var send = $('#sendType :selected').val();
        var prod = $('#prod_id').val();
        var kesht = $("#kesht_id").val();
     //   var numbReq = $("#numb").val();
        var broker = $("#broker_id :selected").val();

        if(send == 165)
            $("#addressBox").removeClass("d-none");
        else
            $("#addressBox").addClass("d-none");

        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod: prod, broker: broker, kesht:kesht},
            dataType:'json',
            success: function(result) {
                if(result != 0)
                {
                    $("#squere").text(result.squere);
                    $("#koodNum").text(result.num);
                    $("#total-item").text(result.itemPrice);
                    $("#total-price").text(result.totalPrice);
                    $("#sendValue").text(result.sendVal);
              //      $("#koodget").text(result.getKood);
              //      $("#koodRem").text(result.remKood);
              //      $("#numbReq").text(result.numbReq);
              //      $("#numbText").text(result.numbText);
                    $("#numb").val(result.rem);
                    if(result.checkBroker == "1")
                    {
                        $("#check_broker").addClass('d-none');
                    }
                    else
                    {
                        $("#check_broker").removeClass("d-none");
                    }
//                    if(result.btnStatus == "1"){
//                        $("#btnSubmit").removeClass("d-none");
//                        $("#btnNone").addClass('d-none');
//                        
//                    }
//                    else{
//                        $("#btnSubmit").addClass("d-none");
//                        $("#btnNone").removeClass('d-none');
//                    }
                }
            }
        });
    };
	/*
        
    $('#sendType').on('change', function() {
        var id = $('#kood_id :selected').val();
        var prod = $('#prod_id').val();
        var send = this.value;
        var kesht = $("#kesht_id").val();
        var broker = $("#broker_id :selected").val();

        if(send == 165)
            $("#addressBox").removeClass("d-none");
        else
            $("#addressBox").addClass("d-none");
        
        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod:prod,broker:broker, kesht:kesht},
            dataType:'json',
            success: function(result) {
                if(result != 0)
                {
                    $("#squere").text(result.squere);
                    $("#koodNum").text(result.num);
                    $("#total-item").text(result.itemPrice);
                    $("#total-price").text(result.totalPrice);
                    $("#sendValue").text(result.sendVal);
//                    if(result.btnStatus == "1"){
//                        $("#btnSubmit").removeClass("d-none");
//                        $("#btnNone").addClass('d-none');
//                    }
//                    else{
//                        $("#btnSubmit").addClass("d-none");
//                        $("#btnNone").removeClass('d-none');
//                    }
                }
            }
        });
    });
    
    $('#prod_id').on('change', function() {
        var id = $('#kood_id :selected').val();
        var send = $('#sendType :selected').val();
        var prod = this.value;
        var kesht = $("#kesht_id").val();
        var broker = $("#broker_id").val();

        

        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod:prod,broker:broker, kesht:kesht},
            dataType:'json',
            success: function(result) {
                if(result != 0)
                {
                    $("#squere").text(result.squere);
                    $("#koodNum").text(result.num);
                    $("#total-item").text(result.itemPrice);
                    $("#total-price").text(result.totalPrice);
                    $("#sendValue").text(result.sendVal);
//                    if(result.btnStatus == "1"){
//                        $("#btnSubmit").removeClass("d-none");
//                        $("#btnNone").addClass('d-none');
//                        
//                    }
//                    else{
//                        $("#btnSubmit").addClass("d-none");
//                        $("#btnNone").removeClass('d-none');
//                    }
                }
            }
        });
    });
    
    $('#broker_id').on('change', function() {
        var id = $('#kood_id :selected').val();
        var prod = $('#prod_id').val();
        var kesht = $("#kesht_id").val();
        var send = $('#sendType :selected').val();
        var broker = $("#broker_id :selected").val();

        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod:prod,broker:broker, kesht:kesht},
            dataType:'json',
            success: function(result) {
                if(result != 0)
                {
                    $("#squere").text(result.squere);
                    $("#koodNum").text(result.num);
                    $("#total-item").text(result.itemPrice);
                    $("#total-price").text(result.totalPrice);
                    $("#sendValue").text(result.sendVal);
                    if(result.checkBroker == "1")
                    {
                        $("#check_broker").addClass('d-none');
                    }
                    else
                    {
                        $("#check_broker").removeClass("d-none");
                    }
//                    if(result.btnStatus == "1"){
//                        $("#btnSubmit").removeClass("d-none");
//                        $("#btnNone").addClass('d-none');
//                        
//                    }
//                    else{
//                        $("#btnSubmit").addClass("d-none");
//                        $("#btnNone").removeClass('d-none');
//                    }
                }
            }
        });
    });
    */
</script>
@endsection