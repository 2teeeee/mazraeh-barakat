@extends('layouts.profile_layout')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>
                    حواله توزیع کود اوره
                    </h4>
                </div>

                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-error">{{ Session::get('error') }}</div>
                    @endif
                    <div class="col-md-12">
                        <table class="table">
  
                            <tbody>
                                <tr>
                                    <th scope="row">کد حواله: </th>
                                    <td>{{ $model->code }}</td>
                                    <td class="border-right font-weight-bold">وضعیت: </td>
                                    <td>
                                    @if($model->status == 1)
                                        در انتظار تحویل
                                    @elseif($model->status == 2)
                                        تحویل داده شده
                                    @elseif($model->status == -1)
                                        مرجوع شده
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scopr="row">تاریخ ثبت درخواست:</th>
                                    <td>{{ $model->make_date?jdate(strtotime($model->make_date))->format('Y/m/d'):'' }}</td>
                                    <td class="border-right font-weight-bold">تاریخ تحویل:</td>
                                    <td>{{ $model->send_date?jdate(strtotime($model->send_date))->format('Y/m/d'):'' }}</td>
                                    
                                </tr>
                                <tr>
                                    <th scope="row">کود درخواستی حواله: </th>
                                    <td>{{ $model->kood->title }}</td>
                                    
                                    <td class="border-right font-weight-bold">تعداد :</td>
                                    <td>{{ $model->value }} کیسه 50 کیلویی</td>
                                </tr>
                                <tr>
                                    <th scope="row">نام کشاورز: </th>
                                    <td>{{ $model->user->name }}</td>
                                    <td class="border-right font-weight-bold">کد ملی: </td>
                                    <td>{{ $model->user->codemelli }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">موبایل: </th>
                                    <td>{{ $model->user->mobile }}</td>
                                    <td class="border-right font-weight-bold">شهر:</td>
                                    <td>{{ $model->user->city?$model->user->city->title:'' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">آدرس: </th>
                                    <td colspan="3">{{ $model->address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">نوع ارسال: </th>
                                    <td>{{ $model->send?$model->send->title:"" }}</td>
                                    
                                    <td class="border-right font-weight-bold">مبلغ حواله:</td>
                                    <td>{{ number_format($model->price_all) }} ریال</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($model->status == 1)
                <div class="card-body text-left">
                    @if($model->status == 1)
                        <a href="{{ url('brokerKoodReq/'.$model->id.'/check') }}" class="btn btn-success" title="تحویل داده شد">
                            <i class="fas fa-check"></i>
                            تحویل داده شد
                        </a>
                        @if($model->make_date < date('Y-m-d', strtotime('-5 days')))
                        <a href="{{ url('brokerKoodReq/'.$model->id.'/back') }}" class="btn btn-info" title="تحویل داده شد">
                            <i class="fas fa-check"></i>
                            مرجوع کردن حواله
                        </a>
                        @endif
                    @endif
                </div>
                @endif
            </div>
            
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('script')

@endsection