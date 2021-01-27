@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
<div class="card-header text-center">
            <h4>
            لیست درخواست های کود
            </h4>
        </div>
    
    <div class="panel panel-default">
        
        <div class="panel-body">
           {!! $grid->make() !!}
        </div>
    </div>
</div>
@stop

<script>

</script>