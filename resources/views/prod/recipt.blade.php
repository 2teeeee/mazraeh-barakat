@extends('layouts.content')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-6 col-sm-offset-3 col-sm-pull-3">
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('validation.attributes.invoice_recipt') }}</div>
        <div class="panel-body">
            <p>
                {{ trans('validation.attributes.porsuit_code') }}: {{ $model->code }}
            </p>
            <hr/>
            <p>
                {{ trans('validation.attributes.name_family') }}: {{ $model->name }}
            </p>
            <hr/>
            <p>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th scope="col">{{ trans('validation.attributes.title') }}</th>
                          <th scope="col">{{ trans('validation.attributes.price').' ('.trans('validation.attributes.toman').'}' }}</th>
                          <th scope="col">{{ trans('validation.attributes.numb') }}</th>
                          <th scope="col">{{ trans('validation.attributes.sum').' ('.trans('validation.attributes.toman').'}' }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $sum = 0; ?>
                         @foreach($model->items as $item)
                         <tr>
                            <td>{{ $item->product->title }}</td>
                            <td>{{ number_format($item->price) }}</td>
                            <td>{{ $item->numb }}</td>
                            <td>{{ number_format($item->numb*$item->price) }}</td>
                        </tr>
                        <?php $sum += $item->numb*$item->price; ?>
                        @endforeach
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                {{ trans('validation.attributes.sum') }}
                            </td>
                            <td>
                                {{ number_format($sum).' '.trans('validation.attributes.toman') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </p>
        </div>

    </div>
</div>
          
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection