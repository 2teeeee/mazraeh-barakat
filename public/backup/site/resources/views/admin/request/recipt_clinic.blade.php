
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            
            <h5>
            نسخه درخواست رفع آفت شماره {{ $model->request_id }}
            </h5>
        </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            <div class="row border p-2">
                <div class="col-md-9 p-0">
                     کلینیک: {{ $model->clinic?$model->clinic->title:"" }}
                </div>
                <div class="col-md-3">
                    تاریخ: {{ jdate($model->created_at)->format('%Y/%m/%d ساعت: H:i:s ') }}
                </div>
            </div>
            <div class="row border border-top-0 p-2">
                تشخیص: {{ $model->tashkhis }}
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
                                    <th class="disc">
                                        <span>{{ trans('validation.attributes.noskhe_disc') }}</span>
                                    </th>	
                                    <th class="formul">
                                        <span>{{ trans('validation.attributes.noskhe_formul') }}</span>
                                    </th>	
                                    <th class="food">
                                        <span>{{ trans('validation.attributes.noskhe_food') }}</span>
                                    </th>	
                                    <th class="ravesh">
                                        <span>{{ trans('validation.attributes.noskhe_ravesh') }}</span>
                                    </th>	
                                    <th class="mizan">
                                        <span>{{ trans('validation.attributes.noskhe_mizan') }}</span>
                                    </th>	
                                    <th class="behtarin_zaman">
                                        <span>{{ trans('validation.attributes.noskhe_behtarin_zaman') }}</span>
                                    </th>	
                                </tr>										</tr>
                            </thead>			
                            <tbody>
                                    @foreach($model->items as $key => $item)
                                    <tr id='row-{{ $item->id }}'>
                                        <th>
                                            {{ $key+1 }}
                                        </th> 
                                        <td class='field noskhe_title'>
                                            {{ $item->product?$item->product->title:"" }}
                                        </td>
                                        <td class='filed noskhe_disc'>
                                            {{ $item->disc }}
                                        </td>
                                        <td class='field noskhe_formul'>
                                            {{ $item->formul }}
                                        </td>
                                        <td class='field noskhe_food'>
                                            {{ $item->food }}
                                        </td>
                                        <td class='field noskhe_ravesh'>
                                            {{ $item->ravesh }}
                                        </td>
                                        <td class='field noskhe_mizan'>
                                            {{ $item->mizan }}
                                        </td>
                                        <td class='field noskhe_behtarin_zaman'>
                                            {{ $item->behtarin_zaman }}
                                        </td>
                                    </tr>                                    
                                    @endforeach
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