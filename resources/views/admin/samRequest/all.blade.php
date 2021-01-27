@extends('layouts.profile_layout')

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
<!--
        <div class="panel-body">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>نام</th>
                <th>موبایل</th>
                <th>پست الکترونیک</th>
                <th>نوع کاربر</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($model as $key => $value)
            <tr id="row-{{ $value->id }}">
                <td>{{ $value->id }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->mobile }}</td>
                <td>{{ $value->email }}</td>
                <td></td>

                 we will also add show, edit, and delete buttons 
                <td>

                     delete the user (uses the destroy method DESTROY /user/{id} 
                    
                    <a class="delete btn btn-small btn-danger" onclick="deleteItem({{ $value->id }})" title="" data-toggle="tooltip" href="#delete" data-original-title="{{ trans('validation.attributes.delete') }}">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>

                     show the nerd (uses the show method found at GET /user/{id} 
                    <a class="btn btn-small btn-success" data-toggle="tooltip" href="{{ URL::to('user/' . $value->id) }}" data-original-title="{{ trans('validation.attributes.view') }}">
                        <i class="glyphicon glyphicon-eye-open"></i>
                    </a>

                     edit this user (uses the edit method found at GET /user/{id}/edit 
                    <a class="btn btn-small btn-info" data-toggle="tooltip" href="{{ URL::to('user/' . $value->id . '/edit') }}" data-original-title="{{ trans('validation.attributes.edit') }}">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>


                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
        </div>-->
    </div>
</div>
@stop

<script>

//function deleteItem(id){
//    if(!confirm('Are you sure you want to delete this item?')) return false;
//        $.ajax({
//            type: 'GET',
//            url: "{{ url('user/delete') }}",
//            data: {id:id}, 
//            success: function(result){
//                $("#row-"+id).remove();    
//            }
//        });
//};

</script>