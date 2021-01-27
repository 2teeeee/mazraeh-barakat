@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            
            <h4>
            پیش فاکتور تعهد نامه دریافت کود اوره فصل زراعی 1399 - 1400
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
            <form method="POST" action="{{ route('userReq/ezharPay',['id'=>$model->id]) }}">
                @csrf
                
				<div class="row m-0 p-3 rounded bg-white" style="line-height: 30px;font-weight: 18px;">
					<span>اینجانب</span>&nbsp;
					<strong> {{ $model->name }} </strong>&nbsp;
					<span>فرزند</span>&nbsp;
					<strong>{{ $model->father_name }}</strong>&nbsp;
					<span>با کد ملی</span>&nbsp;
					<strong>{{ $model->codemelli }}</strong>&nbsp;
					<span>بهره بردار</span>&nbsp;
					<strong>{{ $model->roosta }}</strong>&nbsp;
					<span>متعهد شده ام که در فصل زراعی ۹۹-۱۴۰۰ کشت </span>&nbsp;
					<strong>{{ $model->product->title }}</strong>&nbsp;
					<span>در سطح</span>&nbsp;
					<strong>{{ $model->zaminSize }} هکتار</strong>&nbsp;
					<span>داشته باشم.</span>&nbsp;
					<span>متعهد می شوم چنانچه پس از دریافت سهمیه کودهای شیمیایی یارانه دار بر اساس سطح زیر کشت اعلامی صحت اظهارات اینجانب در بررسی و بازدید توسط مدیر پهنه مغایرت داشت حق دریافت کودهای یارانه دار در ادامه فصل و کشت های آتی را از خویش سلب می نمایم و تابع قوانین و مقررات سازمان جهاد کشاورزی استان در این زمینه هستم.</span>&nbsp;
				</div>
                <div class="row m-0 p-3 mt-2 bg-white rounded">
					<div class="col-md-12">
						متراژ متعهد شده: <strong>{{ $model->zaminSize }} </strong>هکتار
					</div>
					<div class="col-md-12">
						تعداد کیسه کود اوره تخصیص داده شده: <strong>{{ $model->zaminSize * 1 }} </strong>کیسه 50 کیلویی
					</div>
					<div class="col-md-12">
						مبلغ هر کیسه: <strong>{{ number_format($model->kood->price) }} </strong>تومان
					</div>
					<div class="col-md-12">
						مجموع مبلغ قابل پرداخت: <strong>{{ number_format($model->zaminSize * 1 * $model->kood->price) }} </strong>تومان
					</div>
					<div class="form-group">
						<label for="broker_id" class="col-form-label text-md-right">{{ __('validation.attributes.broker_id') }} <span class="text-danger">*</span></label>
						<select name="broker_id" id="broker_id" class="form-control {{ $errors->has('broker_id') ? ' is-invalid' : '' }}">
							<option disabled selected value> -- کارگزار را جهت دریافت کود انتخاب کنید -- </option>
							@foreach ($activeBroker as $key => $broker)
								<option {{ (old('broker_id') == $key)?'selected':'' }} value="{{ $key }}">{{ $broker }}</option>
							@endforeach
						</select>
						@if ($errors->has('broker_id'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('broker_id') }}</strong>
							</span>
						@endif
						<div class="alert alert-danger mt-2 d-none" id="check_broker">کارگزار انتخابی شما برای کود مورد نظرتان موجودی کافی ندارد. لطفا کارگزار دیگری انتخاب کنید.</div>
					</div>
				</div>
				<div class="row m-0 p-3 mt-2 rounded alert alert-danger">
					<strong>تذکر:</strong>&nbsp; در صورت ثبت اطلاعات خلاف واقع و مشخص شدن مغایرت اظهارات فوق در هر مرحله ای علاوه بر سلب امتیاز دریافت کود &nbsp;<strong>مبالغ واریز شده به هیچ عنوان قابل استرداد نیست</strong>.
				</div>
                <div class="panel-footer mt-2">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                قبول شرایط و پرداخت وجه
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
    $('#broker_id').select2({
        dir: "rtl"
    });
});
	
</script>
@endsection