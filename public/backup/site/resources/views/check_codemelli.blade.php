<?php

use App\Models\City;
use App\Models\Product;

?>
@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			
            <form method="GET" action="{{ route('checkcodemelli.html') }}">
               

                <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="form-group col-sm-6">
                        <label for="codemelli" class="col-form-label text-md-right">{{ __('validation.attributes.codemelli') }}</label>
                        <input id="codemelli" type="text" class="form-control {{ $errors->has('codemelli') ? ' is-invalid' : '' }}" name="codemelli" value="{{ old('codemelli') }}" >
                        @if ($errors->has('codemelli'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('codemelli') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6 mb-0 pt-4">
                            <button type="submit" class="btn btn-primary">
                                نمایش
                            </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@if($model)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Type:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['type'])?$model['GetPahneFarmInfoResult']['type']:'' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">کد ملی:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['CodeMeli'])?$model['GetPahneFarmInfoResult']['CodeMeli']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">موبایل:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['Mobile'])?$model['GetPahneFarmInfoResult']['Mobile']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">نام:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['Name'])?$model['GetPahneFarmInfoResult']['Name']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">نام خانوادگی:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['LastName'])?$model['GetPahneFarmInfoResult']['LastName']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">نام پدر:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['FatherName'])?$model['GetPahneFarmInfoResult']['FatherName']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">نام شرکت:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['CompanyName'])?$model['GetPahneFarmInfoResult']['CompanyName']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">CompanyNationalID:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['CompanyNationalID'])?$model['GetPahneFarmInfoResult']['CompanyNationalID']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">PostalCode:</th>
                        <td>{{ isset($model['GetPahneFarmInfoResult']['PostalCode'])?$model['GetPahneFarmInfoResult']['PostalCode']:"" }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Products</th>
                        <td>
                            <table class="table table-bordered table-dark text-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">محصول</th>
                                        <th scope="col">سطح زیر کشت</th>
                                        <th scope="col">نوع آبیاری</th>
                                        <th scope="col">شماره پهنه</th>
                                        <th scope="col">شهر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($model['GetPahneFarmInfoResult']['Products']))
                                        @if($model['GetPahneFarmInfoResult']['Products'] != null)
                                            @foreach($model['GetPahneFarmInfoResult']['Products']['Product'] as $key => $prod)
                                                @if(!is_numeric($key)) 
                                                    <tr>
                                                        <th scope="row">
															<?php $prod = Product::where('code',$model['GetPahneFarmInfoResult']['Products']['Product']['productCode'])->first();
															echo $prod?$prod->title:''; ?>
															{{ $model['GetPahneFarmInfoResult']['Products']['Product']['productCode'] }}
														</th>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['Square'] }}</td>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['AgriType'] }}
															@if($model['GetPahneFarmInfoResult']['Products']['Product']['AgriType'] == 1)
															- آبی
															@elseif($model['GetPahneFarmInfoResult']['Products']['Product']['AgriType'] == 2)
															- دیم
															@endif
														</td>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['Agri_id'] }}</td>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['ct_id'] }}
														<?php
															$city = City::where('ct_id',$model['GetPahneFarmInfoResult']['Products']['Product']['ct_id'])->first();
															echo $city?" - ".$city->title:""; 
															?>
														</td>
                                                    </tr>
                                                    @break
                                                @else
                                                    <tr>
                                                        <th scope="row">
															<?php $prodn = Product::where('code',$prod['productCode'])->first();
															echo $prodn?$prodn->title:''; ?>
														 - {{ $prod['productCode'] }}
														</th>
                                                        <td>{{ $prod['Square'] }}</td>
                                                        <td>{{ $prod['AgriType'] }}
														
														@if($prod['AgriType'] == 1)
															- آبی
															@elseif($prod['AgriType'] == 2)
															- دیم
															@endif
														</td>
                                                        <td>{{ $prod['Agri_id'] }}</td>
                                                        <td>{{ $prod['ct_id'] }}
														<?php
															$city = City::where('ct_id',$prod['ct_id'])->first();
															echo $city?" - ".$city->title:""; 
														?>
														</td>
                                                    </tr>
                                                @endif
                                                
                                            @endforeach
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">errCode:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['errCode'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">errMsg:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['errMsg'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection