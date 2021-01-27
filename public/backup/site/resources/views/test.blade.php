@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Type:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['type'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">CodeMeli:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['CodeMeli'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['Name'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">LastName:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['LastName'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">FatherName:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['FatherName'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">CompanyName:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['CompanyName'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">CompanyNationalID:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['CompanyNationalID'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Mobile:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['Mobile'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">PostalCode:</th>
                        <td>{{ $model['GetPahneFarmInfoResult']['PostalCode'] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Products</th>
                        <td>
                            <table class="table table-bordered table-dark text-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">productCode</th>
                                        <th scope="col">square</th>
                                        <th scope="col">agriType</th>
                                        <th scope="col">Agri_id</th>
                                        <th scope="col">ct_id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($model['GetPahneFarmInfoResult']['Products']))
                                        @if($model['GetPahneFarmInfoResult']['Products'] != null)
                                            @foreach($model['GetPahneFarmInfoResult']['Products']['Product'] as $key => $prod)
                                                @if(!is_numeric($key)) 
                                                    <tr>
                                                        <th scope="row">{{ $model['GetPahneFarmInfoResult']['Products']['Product']['productCode'] }}</th>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['Square'] }}</td>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['AgriType'] }}</td>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['Agri_id'] }}</td>
                                                        <td>{{ $model['GetPahneFarmInfoResult']['Products']['Product']['ct_id'] }}</td>
                                                    </tr>
                                                    @break
                                                @else
                                                    <tr>
                                                        <th scope="row">{{ $prod['productCode'] }}</th>
                                                        <td>{{ $prod['Square'] }}</td>
                                                        <td>{{ $prod['AgriType'] }}</td>
                                                        <td>{{ $prod['Agri_id'] }}</td>
                                                        <td>{{ $prod['ct_id'] }}</td>
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
@endsection