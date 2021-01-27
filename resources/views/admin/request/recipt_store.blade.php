
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            @if($model->requestType_id == 157)
            <h5>
            نسخه درخواست سم شماره {{ $model->id }}
            </h5>
            @elseif($model->requestType_id == 158)
            <h5>
            نسخه درخواست کود شماره {{ $model->id }}
            </h5>
            @endif
        </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            <div class="row border p-2">
                <div class="col-md-9 p-0">
                     گیرنده: 
                </div>
                <div class="col-md-3">
                    تاریخ: {{ jdate($model->order->created_at)->format('H:i:s %Y/%m/%d') }}
                </div>
            </div>
            <div class="row border border-top-0 p-0">
                <div class="col-md-6 py-2">
                    تلفن: {{ $model->order->mobile }}
                </div>
                <div class="col-md-6 border-right py-2">
                    تاریخ ارسال: {{ $model->order->offerSelect()->sendTime }}
                </div>
                
            </div>
            <div class="row border border-top-0 p-2">
                آدرس: {{ $model->order->address }}
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-condensed grid" id="relTable">
                            <thead>
                                <tr>
                                    <th class="radif">
                                        ردیف
                                    </th>	
                                    <th class="title">
                                        <span>{{ trans('validation.attributes.noskhe_title') }}</span>
                                    </th>	
                                    <th class="mizan">
                                        <span>{{ trans('validation.attributes.value') }}</span>
                                    </th>	
                                    <th class="behtarin_zaman">
                                        <span>{{ trans('validation.attributes.price') }}</span>
                                    </th>	
                                </tr>										
                            </thead>			
                            <tbody>
                                    @foreach($model->order->offerSelect()->prices as $key => $item)
                                    <tr id='row-{{ $item->id }}'>
                                        <th>
                                            {{ $key+1 }}
                                        </th> 
                                        <td class='field noskhe_title'>
                                            {{ $item->orderProduct->product->title }}
                                        </td>
                                        <td class='field noskhe_mizan'>
                                            {{ $item->orderProduct->value }}
                                        </td>
                                        <td class='field noskhe_behtarin_zaman'>
                                            {{ number_format($item->price) }}
                                            {{ trans('validation.attributes.toman') }}
                                        </td>
                                    </tr>                                    
                                    @endforeach
                                    
                                    <tr id='row-{{ $item->id }}'>
                                        <th colspan="2">
                                        </th> 
                                        <td class='field noskhe_mizan'>
                                            مجموع
                                        </td>
                                        <td class='field noskhe_behtarin_zaman'>
                                            {{ number_format($model->order->offerSelect()->sumPrice()) }} 
                                            {{ trans('validation.attributes.toman') }}
                                        </td>
                                    </tr>   
                            </tbody>
                        </table>
                    </div>
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