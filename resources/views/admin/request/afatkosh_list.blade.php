<?php

use App\Models\SamRequestClinicStore;

?>
@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    
    <?php $key = 0; $ch = 0; ?>
    @foreach($model as $key => $card)
        <?php $ch = 1; ?>
        @if(($key % 3) == 0)
            <div class="row">
        @endif
        
        <div class="card col-md-12">
            
            <div class="card-body row">
                <div class="col-md-9">
                    <strong class="card-title">
                        <i class="fas fa-check-square fa-2x ml-2"></i>
                        {{ $card->type?$card->type->title:"" }} شماره ی  {{ $card->id }}
                    </strong>
                <p class="card-text">{{ jdate($card->created_at)->format('%Y/%m/%d ساعت: H:i:s ') }}</p>
                </div>
                <div class="col-md-3">
                    @if($card->status == 0)
                        <a href="{{ url('request/afatkoshShopView/'.$card->id) }}" class="btn btn-success col-12">
                            <i class="fas fa-eye"></i>
                            {{ trans('validation.attributes.viewRequest') }}
                        </a>
                    @elseif($card->status == 1 and $card->store_id == $store->id)
                        <a href="{{ url('request/afatkoshView/'.$card->id) }}" class="btn btn-info col-12">
                            <i class="fas fa-file-alt"></i>
                            مشاهده فاکتور
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
    
    @if($ch == 0)
        <div class="alert alert-danger">درخواستی برای ارائه قیمت وجود ندارد.</div>
    @endif
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
