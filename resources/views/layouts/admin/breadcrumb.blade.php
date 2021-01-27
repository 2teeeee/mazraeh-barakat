@if(!empty($crumb))
<ul class="breadcrumb">
    @foreach ($crumb as $cr)
	    @if ($cr['class'] == "")
	    	<li><a href="{{ url($cr['url']) }}">{{ $cr['title'] }}</a></li>    
	    @else
	    	<li class="{{ url($cr['class']) }}">{{ $cr['title'] }}</li>  
	    @endif
    @endforeach
</ul>
@endif