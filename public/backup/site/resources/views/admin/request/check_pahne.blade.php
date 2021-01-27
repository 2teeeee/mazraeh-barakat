
    @extends('layouts.profile_layout')

@section('title', 'نمایش کاربر ها')

@section('content')
    <div class="col-sm-12">
    <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
                @if($model->requestType_id == 157)
                بررسی صحت درخواست سم
                @elseif($model->requestType_id == 158)
                بررسی صحت درخواست کود
                @endif
            
            </h4>
        </div>
    <div class="panel panel-default">
        <div class="panel-body mt-2">
            <div class="row card-header">
                مزرعه
            </div>
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ostan") }}: {{ $model->location->ostan->title }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.city") }}: {{ $model->location->city->title }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bakhsh") }}: {{ $model->location->bakhsh }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mantaghe") }}: {{ $model->location->mantaghe }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.roosta") }}: {{ $model->location->roosta }}</div>
                <div class="col-md-9 border border-top-0 py-2">{{ trans("validation.attributes.address") }}: {{ $model->location->address }}</div>
                
            </div>
            <div class="row card-header">
                اطلاعات محصول در حال کشت برای درخواست:
            </div>
            <div class="row">
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.mahsool_name") }}: {{ $model->info->product->title }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_sath") }}: {{ $model->info->sath_value }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_date") }}: {{ $model->zamin->keshtDate }}</div>
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.kesht_type") }}: {{ $model->zamin->keshtType->title }}</div>
                
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.bazr_type") }}: {{ $model->zamin->bazrType->title }}</div>
                @if($model->info->abyariType)
                <div class="col-md-3 border border-top-0 py-2">{{ trans("validation.attributes.ab_type") }}: {{ $model->info->abyariType->title }}</div>
                <div class="col-md-6 border border-top-0 py-2"> </div>
                @else
                <div class="col-md-9 border border-top-0 py-2"> </div>
                @endif
                
                
                
            </div>
            @if($model->getKood)
                <div class="row card-header">
                    کود درخواستی:
                </div>
                <div class="row">
                    <div class="col-md-3 border border-top-0 py-2">نام کود: {{ $model->getKood->product->title }}</div>
                    <div class="col-md-3 border border-top-0 py-2">مقدار: {{ $model->getKood->value }}</div>
                    <div class="col-md-6 border border-top-0 py-2">نوع ارسال: {{ $model->getKood->sendType?$model->getKood->sendType->title:"" }}</div>
                </div>
            @endif
                <form method="POST" action="{{ route('request/checkNotOk', $model->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    @csrf

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="pahneComment" class="col-form-label text-md-right">{{ __('validation.attributes.pahneComment') }}</label>
                            <textarea id="pahneComment" class="form-control {{ $errors->has('pahneComment') ? ' is-invalid' : '' }}" name="pahneComment">
                                {{ old('pahneComment')?old('pahneComment'):"" }}
                            </textarea>
                            @if ($errors->has('small_comment'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('small_comment') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row my-2">
                        <button type="submit" class="btn btn-danger bt-2">
                            مورد تایید نیست
                        </button>
                        <a href="{{ url('request/checkOk/'.$model->id) }}" class="btn btn-success bt-2 mx-2">مورد تایید است</a>
                    </div>
                </form>
        </div>
            
    </div>

</div>

@stop