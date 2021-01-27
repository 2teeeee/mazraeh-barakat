@extends('layouts.profile_layout')

@section('content')

<div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ trans('validation.attributes.name_family') }}</th>
                        <th>{{ trans('validation.attributes.tel') }}</th>
                        <th>{{ trans('validation.attributes.device') }}</th>
                        <th>{{ trans('validation.attributes.status') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($model as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name." ".$value->family }}</td>
                        <td>{{ $value->tel }}</td>
                        <td>
                            @foreach($value->parts as $part)
                                {{ ($part->cartridge_id == null)?
                                trans('validation.numb_device',['numb'=>$part->numb,'device'=>$part->printer->title]):
                                trans('validation.numb_device',['numb'=>$part->numb,'device'=>$part->cartridge->title]) }}
                                <br/>
                            @endforeach
                        </td>
                        <td>{{ $value->status }}</td>
                        <!-- we will also add show, edit, and delete buttons -->
                        <td>

                            <!-- edit this role (uses the edit method found at GET /role/{id}/edit -->
<!--                            <a class="btn btn-small btn-info" title="{{ trans('validation.attributes.view') }}" href="{{ URL::to('request/'.$value->id) }}">
                                <i class="fa fa-eye"></i>
                            </a>-->

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
