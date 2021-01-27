@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')



<div class="col-sm-12">
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    
    <?php $key = 0; $c=0; ?> 
    @foreach($model as $key => $card)
    <?php $c = 1; ?>
        @if(($key % 3) == 0)
            <div class="row">
        @endif
        
        <div class="card col-md-12">
            
            <div class="row card-body py-1 pt-3">
                
                <div class="col-md-9">
                    <h5 class="card-title">{{ $card->clinic?$card->clinic->title:"کلینیک موجود نیست!" }}</h5>
                    
                        @if($card->status == 1)
                            <p class="alert alert-danger">
                                برای تشخیص نیاز به مستندات بیشتری می باشد.
                        
                            </p>
                        @endif
                        @if($card->status == 2)
                            <p class="alert alert-danger">
                                برای تشخیص نیاز به بازدید میدانی می باشد.
                            </p>
                        @endif
                        @if($card->status == 8)
                            <p class="alert alert-danger">
                                برای تشخیص نیاز به آزمایش آب و خاک می باشد.
                            </p>
                        @endif
                        @if($card->status == 9)
                            <p class="alert alert-danger">
                                برای ارائه نسخه باید اینستکاریو بررسی های لازم را انجام دهد.
                            </p>
                        @endif
                </div>
                <div class="col-md-3 p-0">
                    @if($card->status == 3)
                        <a href="{{ url('request/clinicSelect/'.$card->id) }}" class="btn btn-success">
                            <i class="far fa-check-square"></i>
                            {{ trans('validation.attributes.select_clinic') }}
                        </a>
                    @endif
                    @if($card->status == 1)
                        <a href="{{ url('request/getFile/'.$card->request_id) }}" class="btn btn-primary">
                            <i class="far fa-eye"></i>
                            ارائه مستندات بیشتر
                        </a>
                    @endif
                    @if($card->status == 2)
                    <a href="{{ url('bazdidRequest/create/'.$card->request_id).'/'.$card->id }}" class="btn btn-primary">
                            <i class="far fa-eye"></i>
                            درخواست بازدید میدانی
                        </a>
                    @endif
                    @if($card->status == 8)
                        <a href="{{ url('/main/alertc/'.$card->request_id) }}" class="btn btn-primary">
                            <i class="far fa-eye"></i>
                            درخواست انجام آزمایش
                        </a>
                    @endif
                    @if($card->status == 9)
                        <a href="{{ url('main/alertc/'.$card->request_id) }}" class="btn btn-primary">
                            <i class="far fa-eye"></i>
                            درخواست بازدید اینستکاریو
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        @if(($key % 3) == 2)
            </div>
        @endif
    @endforeach
    @if($key != 2)
        </div>
    @endif
</div>
@if($c == 0)
<div class="container">
    @if($req->status == 3)
        <div class="alert alert-warning">{{ $req->pahneComment }}</div>
    @else
        <div class="alert alert-info">درخواست با موفقیت ثبت شده است. تا ثبت نسخه توسط کلینیک ها صبر کنید.</div>
    @endif
</div>
@endif
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
