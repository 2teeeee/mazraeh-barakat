@if(!empty($crumb))
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach ($crumb as $cr)
	    @if ($cr['class'] == "")
	    	<li class="breadcrumb-item"><a href="{{ url($cr['url']) }}">{{ $cr['title'] }}</a></li>    
	    @else
	    	<li class="{{ url($cr['class']) }} breadcrumb-item active" aria-current="page">{{ $cr['title'] }}</li>  
	    @endif
        @endforeach
    </ol>
</nav>
@endif


