
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            
        <h5>
        درخواست رفع آفت شماره {{ $model->id }}
        </h5>
    </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            
            @if (Session::has('status'))            
                <div class="alert alert-info alert-dismissible fade show col-12" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            
            <div class="row card-header">
                مزرعه
            </div>
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ostan") }}: {{ $model->location->ostan?$model->location->ostan->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.city") }}: {{ $model->location->city?$model->location->city->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bakhsh") }}: {{ $model->location->bakhsh }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mantaghe") }}: {{ $model->location->mantaghe }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.roosta") }}: {{ $model->location->roosta }}</div>
                <div class="col-md-9 border border-top-0 py-2">{{ trans("validation.attributes.address") }}: {{ $model->location->address }}</div>
                
            </div>
            <div class="row card-header">
                اطلاعات محصول در حال کشت برای درخواست:
            </div>
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mahsool_name") }}: {{ $model->info?$model->info->product->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_sath") }}: {{ $model->info?$model->info->sath_value:"" }} {{ $model->info->sath_type?"متر مربع":"هکتار" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_date") }}: {{ $model->zamin?$model->zamin->keshtDate:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_type") }}: {{ $model->zamin?$model->zamin->keshtType->title:"" }}</div>
                
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bazr_type") }}: {{ $model->info?$model->info->bazr->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ab_type") }}: {{ $model->info?($model->info->abyariType?$model->info->abyariType->title:""):"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_old") }}: {{ $model->zamin?$model->zamin->keshtOld->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ab_start_date") }}: {{ $model->zamin?$model->zamin->abyariFirstDate:"" }}</div>
                
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ab_dore") }}: {{ $model->info?$model->info->abDore_id:""." ".trans('validation.attributes.day') }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ab_ec") }}: {{ $model->info?$model->info->abType->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.khak_ec") }}: {{ $model->info?$model->info->khakColor->title:"" }}</div>
                <div class="col-md-3 border border-top-0 py-2"> </div>
                
                <div class="col-md-12 border border-top-0 py-2">
                    {{ trans("validation.attributes.kood_type") }}: 
                    @foreach($model->koods as $kood)
                        {{ $kood->product?$kood->product->title:"" }}
                    @endforeach
                </div>
                
                <div class="col-md-6 border border-top-0 py-2">
                    {{ trans("validation.attributes.alafType") }}: 
                    @foreach($model->alafs as $alaf)
                        {{ $alaf->alaf?$alaf->alaf->title:"" }}
                    @endforeach
                </div>
                <div class="col-md-6 border border-top-0 py-2">
                    {{ trans("validation.attributes.alafkoshType") }}: 
                    @foreach($model->alafkoshs as $alafkosh)
                        {{ $alafkosh->alafkosh?$alafkosh->alafkosh->title:"" }}
                    @endforeach
                </div>
                
            </div>
            <div class="row card-header">
                شرح آفت
            </div>
            @foreach($model->files as $key => $file)
                <div class="row border border-top-0 py-2">
                    <div class="col-md-1">
                        مشکل {{ $key+1 }}:
                    </div>
                    <div class="col-md-11">
                        <p>
                            @if($file->file != null)
                                <a href="{{ asset('image/samRequest/'.$file->file) }}">مشاهده فایل ضمیمه مشکل شماره {{ $key+1 }}</a>
                                <br/>
                            @endif
                            @if($file->sound != null)
                                <a href="{{ asset('image/samRequest/'.$file->sound) }}">گوش دادن به مشکل شماره {{ $key+1 }}</a>
                                <br/>
                            @endif
                            {{ $file->comment }}
                        </p>
                    </div>
                </div>
            @endforeach
            @if($model->statusBazdid)
                <div class="row border border-success rounded mt-1">
                    <div class="alert alert-success fade show col-12 mb-0" role="alert">
                        مزرعه دار فوق 
                        <strong>درخواست بازدید میدانی</strong>
                        دارد.
                    </div>
                </div>
            @endif
            <div class="row mt-2">
                @if($model->status == 2 || $model->status == 4)
                <a href="{{ url('request/needFile/'.$model->id) }}" class="btn btn-danger mt-2 mr-2">
                    <i class="fas fa-edit"></i>
                    نیاز به اطلاعات بیشتری است.
                </a>
                <a href="{{ url('request/needView/'.$model->id) }}" class="btn btn-info mt-2 mr-2">
                    <i class="fas fa-eye"></i>
                    نیاز به بازدید میدانی دارد.
                </a>
                <a href="{{ url('request/needAzmayesh/'.$model->id) }}" class="btn btn-warning mt-2 mr-2">
                    <i class="fas fa-flask"></i>
                    نیاز به آزمایش آب و خاک دارد.
                </a>
                <a href="{{ url('request/needInstkario/'.$model->id) }}" class="btn btn-primary mt-2 mr-2">
                    <i class="fas fa-bug"></i>
                    نیاز به بررسی اینسکتاریوم دارد.
                </a>
                <a href="{{ url('request/alertNoskhe/'.$model->id) }}" class="btn btn-success mt-2 mr-2">
                    <i class="fas fa-book-dead"></i>
                    برای درخواست فوق می توانم نسخه ارائه کنم.
                </a>
                @endif
                
                @if($model->status == 4 and $clinicSend != null)
                    <div class="col-md-12 alert alert-info mt-2">پیشنهاد شما ثبت شده. تا انتخاب کلینیک توسط مزرعه دار صبر کنید.</div>
                @endif
                
                @if($model->status == 5 and $clinicSend != null)
                    <a href="{{ url('request/sendNoskhe/'.$model->id) }}" class="btn btn-info mr-2">ارائه نسخه</a>
                @endif
                
                @if($model->status >= 6 and $clinicSend->clinic_id == $model->clinic_id)
                    <a href="{{ url('request/reciptNoskhe/'.$model->id.'/clinic') }}" class="btn btn-secondary mr-2">مشاهده نسخه</a>
                @endif
            </div>
        </div>
            
    </div>

</div>

@stop


@section('script')
<script type="text/javascript">
    
    setInterval(myMethod, 10000);

    function myMethod( )
    {
        location.reload();
    }
    
</script>
@endsection