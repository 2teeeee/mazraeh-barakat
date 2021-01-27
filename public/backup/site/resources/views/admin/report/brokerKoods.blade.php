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
			<form method="POST" action="{{ route('report/brokerKoods') }}">
                        @csrf
                <div class="card-body px-0">
                    <div class="row">
						
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
        <div class="panel-body mt-2" id="response">
			@component('admin.report._responseBroker', [
				'response' => $response, 
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
	
</script>

@endsection