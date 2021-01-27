@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            
            <h4>
            فرم تعهد نامه دریافت کود اوره فصل زراعی 1399 - 1400
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
            <form method="POST" action="{{ route('userReq/DeclarativePost',['id'=>$model->id]) }}">
                @csrf
                
				<div class="row m-0 p-3 rounded bg-white" style="line-height: 30px;font-weight: 18px;">
					<span>اینجانب</span>&nbsp;
					<strong> {{ Auth::user()->name }} </strong>&nbsp;
					<span>فرزند</span>&nbsp;
					<strong>{{ Auth::user()->father_name }}</strong>&nbsp;
					<span>با کد ملی</span>&nbsp;
					<strong>{{ Auth::user()->codemelli }}</strong>&nbsp;
					<span>بهره بردار</span>&nbsp;
					<strong>{{ Auth::user()->address }}</strong>&nbsp;
					<span>می باشم. که متقاضی کشت </span>&nbsp;
					<strong>{{ $model->product->title }}</strong>&nbsp;
					<strong>
					<select name="abType_id" id="abType_id" class="form-control {{ $errors->has('abType_id') ? ' is-invalid' : '' }}">
						<option disabled selected value> -- نوع آبیاری -- </option>
							
						<option {{ (old('abType_id') == 0)?'selected':'' }} value="0">آبی</option>
						<option {{ (old('abType_id') == 1)?'selected':'' }} value="1">دیم</option>
						
					</select>
					</strong>&nbsp;
					<span>در سطح</span>&nbsp;
					<strong><input type="text" class="form-control {{ $errors->has('value') ? ' is-invalid' : '' }} persian-number" id="value" name="value" style="width:100px" /></strong>&nbsp;
					<span>هکتار در فصل زراعی 99-400 هستم.</span>&nbsp;
					
                            @if ($errors->has('value'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('value') }}</strong>
                                </span>
                            @endif
					<span>متعهد می شوم چنانچه پس از دریافت سهمیه کودهای شیمیایی یارانه دار بر اساس سطح زیر کشت اعلامی صحت اظهارات اینجانب در بررسی و بازدید توسط مدیر پهنه مغایرت داشت حق دریافت کودهای یارانه دار در ادامه فصل و کشت های آتی را از خویش سلب می نمایم و تابع قوانین و مقررات سازمان جهاد کشاورزی استان در این زمینه هستم.</span>&nbsp;
				
					<div class="alert alert-info">
						در حال حاضر از طریق سامانه مزرعه برکت حداکثر می توانید تا 10 هکتار درخواست کشت محصول ثبت نمایید. در صورتی که می خواهید متراژ بیشتر کشت کنید به جهاد کشاورزی منطقه خود مراجعه فرمایید.
					</div>
				</div>
                
				
                <div class="panel-footer mt-2">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success" id="btnSubmit">
                                قبول شرایط و ثبت تعهدنامه
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

@endsection