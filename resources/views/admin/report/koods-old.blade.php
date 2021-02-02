@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info col-12">{{ Session::get('message') }}</div>
    @endif

    
    <div class="panel panel-default">
        <div class="panel-body border-bottom">
			<form method="POST" action="{{ route('report/koodPost') }}">
                        @csrf
                <div class="card-body px-0">
                    <div class="row">
                        <div class="form-group col-md-2 p-0">
                            <label for="city_id" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.city_id') }} </label>

                            <div class="col-md-12">
                                <select name="city_id" id="city_id" class="form-control {{ $errors->has('city_id') ? ' is-invalid' : '' }}">
                                    <option disabled selected value>شهر مورد نظر را انتخاب کنید</option>
                                    @foreach ($citys as $city)
                                        <option {{ (old('city_id') == $city->ct_id)?'selected':(($ct_id == $city->ct_id)?'selected':'') }} value="{{ $city->ct_id }}">{{ $city->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('city_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<div class="form-group col-md-3 p-0">
                            <label for="broker_id" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.broker_id') }} </label>

                            <div class="col-md-12">
                                <select name="broker_id" id="broker_id" class="form-control {{ $errors->has('broker_id') ? ' is-invalid' : '' }}">
                                    <option selected value>همه کارگزاری ها</option>
                                    @foreach ($brokers as $broker)
                                        <option {{ (old('broker_id') == $broker->id)?'selected':(($broker_id == $broker->id)?'selected':'') }} value="{{ $broker->user_id }}">{{ $broker->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('broker_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('broker_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<div class="form-group col-md-2 p-0">
                            <label for="product_id" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.product_id') }} </label>

                            <div class="col-md-12">
                                <select name="product_id" id="product_id" class="form-control {{ $errors->has('product_id') ? ' is-invalid' : '' }}">
                                    <option selected value>همه محصول ها</option>
                                    @foreach ($products as $product)
                                        <option {{ (old('product_id') == $product->id)?'selected':(($product_id == $product->id)?'selected':'') }} value="{{ $product->id }}">{{ $product->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<div class="form-group col-md-2 p-0">
                            <label for="kood_id" class="col-md-12 col-form-label text-md-right">{{ __('validation.attributes.kood_id') }} </label>

                            <div class="col-md-12">
                                <select name="kood_id" id="kood_id" class="form-control {{ $errors->has('kood_id') ? ' is-invalid' : '' }}">
                                    @foreach ($koods as $kood)
                                        <option {{ (old('kood_id') == $kood->id)?'selected':(($kood_id == $kood->id)?'selected':'') }} value="{{ $kood->id }}">{{ $kood->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('kood_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kood_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<div class="form-group col-md-3 p-0">
                            <label for="ab_type" class="col-md-12 col-form-label text-md-right">نوع آبیاری </label>

                            <div class="col-md-12">
                                <select name="ab_type" id="ab_type" class="form-control {{ $errors->has('ab_type') ? ' is-invalid' : '' }}">
                                	<option  value="">همه نوع آبیاری</option>
                                	<option {{ (old('ab_type') == 6)?'selected':(($ab_type == 6)?'selected':'') }} value="6">آبی</option>
                                	<option {{ (old('ab_type') == 7)?'selected':(($ab_type == 7)?'selected':'') }} value="7">دیمی</option>
                                </select>
                                @if ($errors->has('ab_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ab_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<div class="form-group col-md-2">
							<label for="startDate" class="col-form-label text-md-right">{{ __('validation.attributes.startDate') }} </label>
							<input id="startDate" type="text" class="form-control{{ $errors->has('startDate') ? ' is-invalid' : '' }} date" name="startDate" value="{{ old('startDate')?old('startDate'):$startDate }}">
							@if ($errors->has('startDate'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('startDate') }}</strong>
								</span>
							@endif
						</div>
						<div class="form-group col-md-2">
							<label for="endDate" class="col-form-label text-md-right">{{ __('validation.attributes.endDate') }} </label>
							<input id="endDate" type="text" class="form-control{{ $errors->has('endDate') ? ' is-invalid' : '' }} date" name="endDate" value="{{ old('endDate')?old('endDate'):$endDate }}">
							@if ($errors->has('endDate'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('endDate') }}</strong>
								</span>
							@endif
						</div>
                    
						<div class="mt-3 mx-0 col-md-1 pt-1">
							<button type="submit" class="btn btn-success mt-3">
								مشاهده
							</button>
						</div>
                    </div>
                </div>
			</form>
        </div>
        <div class="panel-body mt-2 table-responsive" id="response">
			@component('admin.report._responseCityBroker', [
				'response' => $response, 
				'ch' => $ch
			])

			@endcomponent
			
        </div><div class="text-left">
                    <a href="#print" onclick="openWin()" class="btn btn-info" title="چاپ">
                        <i class="fas fa-print"></i>
                        پرینت
                    </a>
                </div>
    </div>
</div>

<form id="sendFrm" method="get" action="{{ url('report/getbroker/user') }}">
</form>
@stop


@section('script')
<script type="text/javascript">
	
    $('.date').persianDatepicker({
         format: 'YYYY/MM/DD',
         initialValue: false
    });    

    $(document).ready(function(){

		
    $('#city_id').select2({
        dir: "rtl",
    });
    $('#broker_id').select2({
        dir: "rtl",
    });
    $('#kood_id').select2({
        dir: "rtl",
    });
    $('#product_id').select2({
        dir: "rtl",
    });
    $('#ab_type').select2({
        dir: "rtl",
    });
      // Department Change
      $('#city_id').change(function(){

         // Department id
         var id = $(this).val();

         // Empty the dropdown
         $('#broker_id').find('option').not(':first').remove();

         // AJAX request 
         $.ajax({
           url: '{{ url("report/getbroker") }}',
           data: {id: id},
           type: 'get',
           dataType: 'json',
           success: function(response){

             var len = 0;
             if(response != null){
               len = response.length;
             }

             if(len > 0){
               // Read data and create <option >
                 $("#broker_id").append(option); 
				 
               for(var i=0; i<len; i++){

                 var id = response[i].user_id;
                 var name = response[i].name;

                 var option = "<option value='"+id+"'>"+name+"</option>"; 

                 $("#broker_id").append(option); 
               }
             }

           }
        });
      });

    });

	function openWin()
    {
        var printContents = document.getElementById('response').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
	
	function showuser(id)
	{
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
		var kood = $("#kood_id option:selected").val();
		
		$('#sendFrm').append('<input type="hidden" name="sendBroker" value="'+id+'" />');
		$('#sendFrm').append('<input type="hidden" name="sendKood" value="'+kood+'" />');
		$('#sendFrm').append('<input type="hidden" name="sendStartDate" value="'+startDate+'" />');
		$('#sendFrm').append('<input type="hidden" name="sendEndDate" value="'+endDate+'" />');
		$('#sendFrm').submit();
	}
	
</script>

@endsection