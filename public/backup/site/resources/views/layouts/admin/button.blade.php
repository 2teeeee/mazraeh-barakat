<class class="buttons col-sm-12">
@if(Request::path() != 'profile/index.html')
<a href="{{ url('/') }}" class="btn btn-info mt-2" >بازگشت به صفحه اصلی</a>
@endif
@if(!empty($btn))

    @foreach ($btn as $bt)
    <a href="{{  url($bt['url'])  }}" class="btn {{ $bt['class'] }} mt-2"><span class="fa fa-{{ $bt['icon'] }}"></span> {{ $bt['title'] }}</a>  
    @endforeach

@endif
</class>