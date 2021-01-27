<nav class="navbar navbar-expand-lg navbar-light bg-header">
	<div class="row mx-0">
		<div class="col-10 col-md-12">
			<a class="navbar-brand col-md-2" href="{{ Auth::Guest()?url('/home'):url('/profile/index.html') }}">
			  	<img src="{{ asset('image/icon/logo.png') }}" height="64" class="float-right ml-2" />

		  	</a>
		</div>
		<div class="col-2 col-md-12 mt-4 m-md-0">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
		  </button>
		</div>
	</div>
  
  
  

    
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
<!--    <form class="form-inline my-2 my-lg-0 col-8">
        <input class="form-control mr-sm-2 col-10" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>-->
       
    <ul class="navbar-nav mr-auto">
        
        @guest
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('login') }}">
                    <img src="{{ asset('image/icon/log-in.svg') }}" style="width: 26px;" />
                    {{ trans('validation.attributes.login') }}
                </a>
            </li>
            
<!--            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">
                    {{ trans('validation.attributes.register') }}
                </a>
            </li>-->
        @else
        <?php /*
            @if(Auth::user()->status == 1)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('profile/index.html') }}">
                        <i class="fas fa-chart-area"></i>
                        <span>{{ __("validation.attributes.userProfile") }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('profile/changeInfo.html') }}">
                        <i class="fas fa-pencil-alt"></i>
                        <span>{{ __("validation.attributes.changeInfo") }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('profile/changePassword.html') }}">
                        <i class="fas fa-key"></i>
                        <span>{{ __("validation.attributes.changePassword") }}</span>
                    </a>
                </li>
                 @if (!Auth::guest() && (Auth::user()->authorizeCheck(['admin','manager','programmer'])))
                 <li class="nav-item">
                    <a class="nav-link" target="_blank" href="{{ url('admin/index.html') }}">
                        <i class="fab fa-canadian-maple-leaf"></i>
                        <span>{{ __("validation.attributes.adminPanel") }}</span>
                    </a>
                 </li>
                 @endif
             @endif
             
             */ ?>
            <li class="nav-item border-left"> 
                <a class="nav-link text-dark font-weight-bold" href="{{ url('profile/changeInfo.html') }}"> 
					
                    <img src="{{ asset('image/icon/profile-user.svg') }}" style="width: 26px;" />
                	{{ Auth::user()->name }}
                </a>
            </li>
            <li class="nav-item"> 
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    <img src="{{ asset('image/icon/log-out.svg') }}" style="width: 26px;" />
                    <span>{{ trans('validation.attributes.logout') }}</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                </form>
            </li>
            <li class="nav-item">
                <a href="{{ url('koodReq/cart') }}" class="btn btn-outline-info">
                    <img src="{{ asset('image/icon/shopping.svg') }}" style="width: 26px;" />
                    سبد خرید
                    <span class="{{ Cart::isEmpty()?'bg-danger':'bg-success' }} text-white rounded-circle  px-2" id="basket-num">
                    {{ Cart::getContent()->count() }}
                    </span>
                </a>
            </li>
        @endguest
        
    </ul>
  </div>
</nav>
<!--
<div class="line-v bg-line"></div>

<div class="container-fluid mb-1 d-none d-md-block border-bottom border-bottom-green">
        <nav class="nav nav-pills flex-column flex-md-row text-dark">
            <a class="flex-md-fill text-sm-center menu-color nav-link border-left py-3" href="{{ url('/category') }}">
                <i class="fas fa-list fa-2x"></i>
                <span class="">همه تخفیف ها</span>
            </a>
            <a class="flex-md-fill text-sm-center menu-color nav-link border-left py-3" href="{{ url('/category') }}">
                <i class="fas fa-utensils fa-2x"></i>
                <span>رستوران و کافی شاپ</span>
            </a>
            <a class="flex-md-fill text-sm-center menu-color nav-link border-left py-3" href="{{ url('/category') }}">
                <i class="fas fa-futbol fa-2x"></i>
                <span>تفریحی و ورزشی</span>
            </a>
            <a class="flex-md-fill text-sm-center menu-color nav-link border-left py-3" href="{{ url('/category') }}">
                <i class="fas fa-heartbeat fa-2x"></i>
                <span>پرشکی و سلامت</span>
            </a>
            <a class="flex-md-fill text-sm-center menu-color nav-link border-left py-3" href="{{ url('/category') }}">
                <i class="fas fa-paint-brush fa-2x"></i>
                <span>فرهنگی و هنری</span>
            </a>
            <a class="flex-md-fill text-sm-center menu-color nav-link border-left py-3" href="{{ url('/category') }}">
                <i class="fas fa-female fa-2x"></i>
                <span>زیبایی و آرایشی</span>
            </a>
            <a class="flex-md-fill text-sm-center menu-color nav-link py-3" href="{{ url('/category') }}">
                <i class="fas fa-truck fa-2x"></i>
                <span>سایر تخفیف ها</span>
            </a>
        </nav>
</div>-->