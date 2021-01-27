@extends('layouts.profile_layout')

@section('title', 'وب سایت من')

@section('content')
<div class="col-sm-12">
    <div class="card-header text-center">
            <div class="rounded-circle border border-info py-3 px-2 text-info mx-auto mb-2" style="width: 75px;height: 75px;">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h4>
                ارائه نسخه
            </h4>
        </div>
    <div class="panel panel-default">
        <!-- if there are creation errors, they will show here -->
        <div class="panel-body"> 
            {{ Html::ul($errors->all(),['class'=>'invalid-feedback']) }}
        </div>
        <div class="panel-body">
            
            <form method="POST" action="{{ route('request/saveNoskhe') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="noskhe_id" value="{{ $model->id }}" />
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="tashkhis" class="col-form-label text-md-right">{{ __('validation.attributes.tashkhis') }}</label>
                        <textarea id="tashkhis" class="form-control {{ $errors->has('tashkhis') ? ' is-invalid' : '' }}" name="tashkhis" >{{ old('tashkhis') }}</textarea>
                        @if ($errors->has('tashkhis'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tashkhis') }}</strong>
                            </span>
                        @endif
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{ trans('validation.attributes.noskhe') }}
                    </div>
                    <div class="col-md-12">
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed grid" id="relTable">
                                <thead>
                                    <tr>
                                        <th class="title title">
                                            <span>نام سم</span>
                                        </th>	
                                        <th class="disc disc">
                                            <span>{{ __('validation.attributes.noskhe_disc') }}</span>
                                        </th>	
                                        <th class="formul formul">
                                            <span>{{ __('validation.attributes.noskhe_formul') }}</span>
                                        </th>	
                                        <th class="food food">
                                            <span>{{ __('validation.attributes.noskhe_food') }}</span>
                                        </th>	
                                        <th class="ravesh ravesh">
                                            <span>{{ __('validation.attributes.noskhe_ravesh') }}</span>
                                        </th>	
                                        <th class="mizan mizan">
                                            <span>{{ __('validation.attributes.noskhe_mizan') }}</span>
                                        </th>	
                                        <th class="behtarin_zaman behtarin_zaman">
                                            <span>{{ __('validation.attributes.noskhe_behtarin_zaman') }}</span>
                                        </th>	
                                    </tr>										</tr>
                                </thead>			
                                <tbody>
                                    @if($grid != null)
                                        @foreach($grid as $item)
                                        <tr id='row-{{ $item->id }}'>
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
                                            <td>
                                                <a onclick='deletePart({{ $item->id }})' href='#relTable' class='btn btn-danger' title='حذف'>
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>                                    
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="card border-primary col-md-12 mb-2">
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <label for="noskhe_title" class="col-form-label text-md-right">نام سم</label>
                                <select name="noskhe_title" id="noskhe_title" class="form-control {{ $errors->has('noskhe_title') ? ' is-invalid' : '' }}">
                                    <option disabled selected value> -- {{ trans('validation.attributes.samSelect') }} -- </option>
                                    @foreach ($samType as $sam)
                                        <option {{ (old("noskhe_title") == $sam->id )?"selected":"" }} value="{{ $sam->id }}">{{ $sam->title }}</option>
                                    @endforeach
                                </select>
                            </div>             
                            <div class="form-group col-sm-4">
                                <label for="noskhe_disc" class="col-form-label text-md-right">{{ __('validation.attributes.noskhe_disc') }}</label>
                                <input type="text" id="noskhe_disc" class="form-control {{ $errors->has('noskhe_disc') ? ' is-invalid' : '' }}" name="noskhe_disc" value="{{ old('noskhe_disc') }}" />
                            </div>        
                        </div>
                        <div class="row">    
                            <div class="form-group col-sm-8">
                                <label for="noskhe_ravesh" class="col-form-label text-md-right">{{ __('validation.attributes.noskhe_ravesh') }}</label>
                                <input type="text" id="noskhe_ravesh" class="form-control {{ $errors->has('noskhe_ravesh') ? ' is-invalid' : '' }}" name="noskhe_ravesh" value="{{ old('noskhe_ravesh') }}" />
                            </div>    
                            <div class="form-group col-sm-4">
                                <label for="noskhe_food" class="col-form-label text-md-right">{{ __('validation.attributes.noskhe_food') }}</label>
                                <input type="text" id="noskhe_food" class="form-control {{ $errors->has('noskhe_food') ? ' is-invalid' : '' }}" name="noskhe_food" value="{{ old('noskhe_food') }}" />
                            </div>               
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="noskhe_formul" class="col-form-label text-md-right">{{ __('validation.attributes.noskhe_formul') }}</label>
                                <input type="text" id="noskhe_formul" class="form-control {{ $errors->has('noskhe_formul') ? ' is-invalid' : '' }}" name="noskhe_formul" value="{{ old('noskhe_formul') }}" />
                            </div> 
                            <div class="form-group col-sm-4">
                                <label for="noskhe_mizan" class="col-form-label text-md-right">{{ __('validation.attributes.noskhe_mizan') }}</label>
                                <input type="text" id="noskhe_mizan" class="form-control {{ $errors->has('noskhe_mizan') ? ' is-invalid' : '' }}" name="noskhe_mizan" value="{{ old('noskhe_mizan') }}" />
                            </div>  
                            <div class="form-group col-sm-4">
                                <label for="noskhe_behtarin_zaman" class="col-form-label text-md-right">{{ __('validation.attributes.noskhe_behtarin_zaman') }}</label>
                                <input type="text" id="noskhe_behtarin_zaman" class="form-control {{ $errors->has('noskhe_behtarin_zaman') ? ' is-invalid' : '' }}" name="noskhe_behtarin_zaman" value="{{ old('noskhe_behtarin_zaman') }}" />
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="comment" class="col-form-label text-md-right">{{ __('validation.attributes.comment') }}</label>
                                <textarea id="comment" class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment">{{ old('comment') }}</textarea>
                            </div> 
                        </div>
                        <div class="row">
                            <a class="btn btn-success m-2" href="#"  onclick="save()">
                                اضافه کردن به نسخه
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('validation.attributes.end_step') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
            
        </div>

</div>
@stop

@section('script')
<script type="text/javascript">

    $(document).ready(function() {
        $('#bahrebardar_id').select2({
            dir: "rtl"
        });
        $('#noskhe_title').select2({
            dir: "rtl",
        });
    });
	
    $("#ab_start_date").persianDatepicker();
    $("#kesht_date").persianDatepicker();
        
        
    function save()
    {
        var title = $("#noskhe_title").val();
        var disc = $('#noskhe_disc').val();
        var ravesh = $("#noskhe_ravesh").val();
        var food = $("#noskhe_food").val();
        var formul = $("#noskhe_formul").val();
        var mizan = $("#noskhe_mizan").val();
        var behtarin_zaman = $("#noskhe_behtarin_zaman").val();
        var comment = $("#comment").val();
        var id = {{ $model->id }};
       
        $.ajax({
            type: 'GET',
            url: "{{ url('/request/saveItemNoskhe') }}#",
            data: {id:id , title:title, disc:disc, ravesh:ravesh, 
                food:food, formul:formul, mizan:mizan, behtarin_zaman:behtarin_zaman, comment:comment}, 
            dataType:'json',
            success: function(result){
                if(result != 0)
                {
                    $("#relTable > tbody").append("<tr id='row-"+result.pid+"'><td class='field noskhe_title'>"+result.title+
                        "</td><td class='filed noskhe_disc'>"+result.disc+
                        "</td><td class='field noskhe_formul'>"+result.formul+
                        "</td><td class='field noskhe_food'>"+result.food+
                        "</td><td class='field noskhe_ravesh'>"+result.ravesh+
                        "</td><td class='field noskhe_mizan'>"+result.mizan+
                        "</td><td class='field noskhe_behtarin_zaman'>"+result.behtarin_zaman+
                        "</td><td>\n\
                            <a onclick='deletePart("+result.pid+")' href='#relTable' class='btn btn-danger' title='حذف'><i class='fas fa-trash-alt'></i></a>\n\
                        </td></tr>");
                        
                        $("#noskhe_title").val("");
                        $("#noskhe_disc").val("");
                        $("#noskhe_ravesh").val("");
                        $("#noskhe_food").val("");
                        $("#noskhe_formul").val("");
                        $("#noskhe_mizan").val("");
                        $("#noskhe_behtarin_zaman").val("");
                        $("#comment").val("");
                  }
            }
        });
    }
    
    function deletePart(id)
    {
        if(!confirm( "{{ trans('validation.attributes.conf_delete') }}" )) return false;

        $.ajax({
            type: 'GET',
            url: "{{ url('/request/deleteItemNoskhe') }}",
            data: {id:id}, 
            success: function(result){
                $("#row-"+id).remove();
            }
        });
    }
        
</script>
@endsection