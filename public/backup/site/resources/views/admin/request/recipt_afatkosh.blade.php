
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            <h5>
            {{ $model->type->title }} شماره {{ $model->id }}
            </h5>
        </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            <div class="row border p-2">
                <div class="col-md-9 p-0">
                     گیرنده: 
                </div>
                <div class="col-md-3">
                    تاریخ: {{ jdate($model->created_at)->format('H:i:s %Y/%m/%d') }}
                </div>
            </div>
            <div class="row border border-top-0 p-0">
                <div class="col-md-6 py-2">
                    تلفن: {{ $model->mobile }}
                </div>
                <div class="col-md-6 border-right py-2">
                    تاریخ ارسال: {{ $model->selectOffer()->sendTime }}
                </div>
                
            </div>
            <div class="row border border-top-0 p-2">
                آدرس: {{ $model->address }}
            </div>
            <div class="row border border-success">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 border py-2">قیمت ارائه شده: {{ $model->selectOffer()->price }} {{ trans('validation.attributes.toman') }}</div>
                        <div class="col-md-4 border py-2">تاریخ انجام: {{ $model->selectOffer()->sendTime }}</div>
                        <div class="col-md-4 border py-2"></div>
                        <div class="col-md-12 border border-top-0 py-2">توضیحات: {{ $model->selectOffer()->comment }}</div>
                    </div>
                </div>
            </div>
        </div>
            
    </div>

</div>

@stop


@section('script')
<script type="text/javascript">

</script>
@endsection