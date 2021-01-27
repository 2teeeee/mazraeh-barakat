@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
<!--            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>-->
            <h4>
            فرم درخواست کود
            </h4>
        </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('koodReq/store') }}">
                @csrf
                
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
<!--                            <label for="prod_id" class="col-form-label text-md-right">لیست محصولات کشت شده در مزرعه شما <span class="text-danger">*</span></label>
                            <select name="prod_id" id="prod_id" class="form-control {{ $errors->has('prod_id') ? ' is-invalid' : '' }}">
                                <option disabled selected value> -- انتخاب محصول مورد نظر جهت تخصیص کود -- </option>
                                @foreach (Auth::user()->keshts as $kesht)
                                    <option {{ (old('prod_id') == $kesht->product_id)?'selected':'' }} value="{{ $kesht->product_id }}">{{ $kesht->product->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('prod_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('prod_id') }}</strong>
                                </span>
                            @endif-->
                        </div>
                        <div>
                            <label for="kood_id" class="col-form-label text-md-right">{{ __('validation.attributes.kood_id') }} <span class="text-danger">*</span></label>
                            <select name="kood_id" id="kood_id" class="form-control {{ $errors->has('kood_id') ? ' is-invalid' : '' }}">
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
                        <div>
                            <label for="sendType" class="col-form-label text-md-right"><span class="text-danger">*</span>{{ __('validation.attributes.sendType') }} </label>
                            <select name="sendType" id="sendType" class="form-control {{ $errors->has('sendType') ? ' is-invalid' : '' }}">
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
                        <div>
                            <label for="broker_id" class="col-form-label text-md-right">{{ __('validation.attributes.broker_id') }} <span class="text-danger">*</span></label>
                            <select name="broker_id" id="broker_id" class="form-control {{ $errors->has('broker_id') ? ' is-invalid' : '' }}">
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
                        </div>
                    </div>
                    <div class="form-group col-sm-5">
                        <div class="border-primary rounded shadow mt-2">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th scope="row">مساحت مزرعه: </th>
                                        <td><span id="squere">{{ $zaminkesht->square }}</span> هکتار</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">تعداد کود سهمیه:</th>
                                        <td><span id="koodNum">0</span> کیسه 50 کیلویی</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">مبلغ هر کیسه کود:</th>
                                        <td><span id="total-item">0</span> ریال</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">هزینه ارسال کود:</th>
                                        <td><span id="sendValue">0</span> ریال</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">جمع کل قابل پرداخت:</th>
                                        <td><span id="total-price">0</span> ریال</td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="p-2 text-danger text-center mb-2">
                                حداکثر زمان تحویل کود اختصاصی به مدت 40 روز کاری خواهد بود.
                            </span>
                        </div>
                        
                    </div>
                </div>
                
                <div class="panel-footer mt-2">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                ثبت درخواست و پرداخت وجه
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
    $('#prod_id').select2({
        dir: "rtl",
    });
    $('#broker_id').select2({
        dir: "rtl",
    });
});


    $('#kood_id').on('change', function() {
        var id = this.value;
        var send = $('#sendType :selected').val();
        var prod = $('#prod_id').val();

        //alert(arr);
        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod: prod},
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
	
        
    $('#sendType').on('change', function() {
        var id = $('#kood_id :selected').val();
        var prod = $('#prod_id').val();
        var send = this.value;

        if(send == 165)
            $("#addressBox").removeClass("d-none");
        else
            $("#addressBox").addClass("d-none");
        
        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod:prod},
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

        

        $.ajax({
            type: "GET",
            url: '{{ url("koodReq/checkKood") }}',
            data: {id: id,send:send,prod:prod},
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
</script>
@endsection