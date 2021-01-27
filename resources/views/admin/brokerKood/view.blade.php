@extends('layouts.profile_layout')

@section('content')

<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    
    <div class="panel panel-default">
        <div class="panel-header text-center">
            <h4>
            تخصیص کود {{ $model->name }} ({{ $model->company }})
            </h4>
        </div>
        <div class="panel-body table-responsive bg-white">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">کود</th>
                        <th scope="col">تخصیص داده شده <small>({{ __('validation.attributes.tonne') }})</small></th>
                        <th scope="col">درخواست ثبت شده <small>({{ __('validation.attributes.tonne') }})</small></th>
                        <th scope="col">باقی مانده <small>({{ __('validation.attributes.tonne') }})</small></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($koods as $kood)
                    <tr>
                        <th scope="row">{{ $kood->title }}</th>
                        <td>{{ round($model->koodAdd($kood->id),2) }}</td>
                        <td>{{ round($model->koodRemove($kood->id),2) }}</td>
                        <td>{{ round($model->koodVal($kood->id),2) }}</td>
                        <td>
							
                            <a href="{{ url('brokerKood/'.$model->id.'/add/'.$kood->id) }}" title="افزایش سهمیه" class="text-success"><i class="fas fa-plus"></i></a>
                         <?php /* 
						 	<a href="{{ url('brokerKood/'.$model->id.'/remove/'.$kood->id) }}" title="کاهش سهمیه" class="text-danger"><i class="fas fa-minus"></i></a>
                           */ ?>
						   <a href="{{ url('brokerKood/report/'.$kood->id.'/'.$model->id) }}" title="گزارش تخصیص سهمیه" class="text-dark"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    
@endsection

@section('script')

@endsection