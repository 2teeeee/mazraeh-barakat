@extends('layouts.admin')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    
    <div class="panel panel-default">
        <div class="panel-body">
            {!! $grid->make() !!}
        </div>
    </div>
</div>
@stop

<script>


</script>