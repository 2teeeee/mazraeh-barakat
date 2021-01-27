<div class="row" style="text-align: justify;">
    <div class="card" style="padding: 8px 0;">
        <div class="col-sm-12"> 
            <span>
                در صورتی که نیاز به محصولی دارید که در فروشگاه موجود نمی باشد. می توانید درخواست آن محصول را وارد کنید.
            </span>
            <br/><br/>
            
            <a style="width:100%;" class="btn btn-info" href='{{ url("/productRequest/create") }}'><i class="fa fa-pencil-square-o"></i> {{ trans('validation.attributes.product_request') }}</a>
        </div>
    </div> 
<hr/>
</div>
<div class="row card">
    <div class="col-sm-12" style="border: 1px solid #eee;background:#ddd;">
        <h5>گروه های محصولات</h5>
    </div>
    <ul class="cat-list">
        @foreach($mainCats as $cat)
        <li>
            <a href="{{ url('product/list',$cat->id) }}" class="btn">
                
                @if(isset($id))
                    @if($id == $cat->id)
                        <i class="fa fa-angle-down"></i>
                    @else
                        <i class="fa fa-angle-left"></i>
                    @endif
                @else
                    <i class="fa fa-angle-left"></i>
                @endif
                {{ $cat->title }}
            </a>
            @if(isset($id))
                @if($id == $cat->id)
                <ul class="cat-list-sub">
                    @foreach($cat->cats as $subCat)
                    
                    <li>
                        <i class="fa fa-angle-left"></i>
                        <a href="{{ url('product/list',$subCat->id) }}" class="btn btn-link">{{ $subCat->title }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            @endif
        </li>
        @endforeach
    </ul>
</div>