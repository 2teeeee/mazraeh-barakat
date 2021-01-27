@extends('layouts.profile_layout')



@section('content')



<div class="container mt-2">

    <div class="row py-2">
        @if (Session::has('message'))
            <div class="alert alert-info col-12">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success col-12">{{ Session::get('success') }}</div>
        @endif

<!--        <h4 style="text-align: center;">

         {{ Auth::user()->name }}

        </h4>-->

    </div>
    
    <div class="row">
        <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">
            پنل کاربر
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-3 mb-2 p-0">
            <a href="{{ url('profile/index.html') }}" class="btn btn-link text-dark text-decoration-none">
                <img src="{{ asset('image/icon/home.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                خانه
            </a>
        </div>
        <div class="col-12 col-md-3 mb-2 p-0">
            <a href="{{ url('profile/changeInfo.html') }}" class="btn btn-link text-dark text-decoration-none">
                <img src="{{ asset('image/icon/text-editor.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                ویرایش اطلاعات کاربری
            </a>
        </div>
        <div class="col-12 col-md-3 mb-2 p-0">
            <a href="{{ url('profile/changePassword.html') }}" class="btn btn-link text-dark text-decoration-none">
                <img src="{{ asset('image/icon/system-lock-screen.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                تغییر کلمه عبور
            </a>
        </div>
        <div class="col-12 col-md-3 mb-2 p-0">
            <a class="btn btn-link text-danger text-decoration-none" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                <img src="{{ asset('image/icon/log-out.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                خروج
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
            </form>
        </div>
    </div>

    @if(Auth::user()->authorizeCheck(['admin','manager','programmer','managerJahad','takhsis']))
        <div class="row">
            <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">
                مدیریت
            </div>
        </div>
        <div class="row">
            @if(Auth::user()->authorizeCheck(['admin','manager','programmer']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('user/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/users.svg') }}" alt="" style="width:64px;" class="img-fluid border-left  pl-2 ml-2" />
                    کاربرها
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','takhsis']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('cityKood/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/loc.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    تخصیص کود شهرستان ها
                </a>
            </div>
            @endif
            
            @if(Auth::user()->authorizeCheck(['admin','managerJahad']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('brokerKood/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/brokers.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    کارگزاران
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','managerJahad','takhsis']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('productKoodValue/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/time.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    زمان تخصیص کود
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','managerJahad','takhsis']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('report/koods') }}" class="btn btn-link text-dark text-decoration-none">
					<img src="{{ asset('image/icon/Mazra-6.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
					گزارش تخصیص
				</a>
            </div>
            @endif
            
        </div>

    @endif
    
<?php /*
    <div class="row">

        

        @if (Session::has('bahrebardar'))            

            <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">

                {{ Session::get('bahrebardar') }}

                <a href="{{ url('bahrebardar/new') }}" class="alert-link">اینجا</a> می توانید مزرعه خود را ثبت کنید. 

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif

        @if (Session::has('clinic'))            

            <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">

                {{ Session::get('clinic') }}

                <a href="{{ url('clinic/new') }}" class="alert-link">اینجا</a> می توانید کلینیک خود را ثبت کنید. 

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif

        @if (Session::has('store'))            

            <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">

                {{ Session::get('store') }}

                <a href="{{ url('store/new') }}" class="alert-link">اینجا</a> می توانید فروشگاه خود را ثبت کنید. 

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif

        <div class="col-12 bg-info rounded p-2 font-light font-weight-bold">

            بخش ها

        </div>

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','orchardist','planter','greenhouseOwner','ornamentalWork','agency']))

            <div class="col-6 col-md-3 mb-2">       

                <a href="{{ url('bahrebardar/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/map.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.locationTitle') }}

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','clinic']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('clinic/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/heart.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.clinicTitle') }}

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','pesticideShop']))

            <div class="col-6 col-md-3 mb-2">



                <a href="{{ url('store/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/grocery.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.storeTitle') }}

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','dafAfat','operator']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('dafAfat/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/sprayer.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.sprayerTitle') }}

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','waterAndSoilLaboratory']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('azmayeshgah/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/chemistry.png') }}" alt="" style="width:100%;" />

                    آزمایشگاه آب و خاک

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','insectarium']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('insectarium/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/debugging.png') }}" alt="" style="width:100%;" />

                    اینسکتاریوم

                </a>

            </div>

        @endif

        
<?php /*
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','pesticideShop']))

            <div class="col-6 col-md-3 mb-2">



                <a href="{{ url('kargozar/index.html') }}" class="btn btn-link" style="width:100%;">

                    <img src="{{ asset('image/icon/bag2.png') }}" alt="" style="width:100%;" />

                    کارگزار

                </a>

            </div>

        @endif

    </div>
*/ ?>     
    @if(Auth::user()->authorizeCheck(['admin','manager','programmer','orchardist','planter','greenhouseOwner','ornamentalWork']))

    <div class="row">

        <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">

            درخواست کود

        </div>
  <?php /*
            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/sam/create') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/medical-history.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.formSamTitle') }}

                </a>

            </div>

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/kood/create') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/book2.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.formKoodTitle') }}

                </a>

            </div>
*/ ?>
            <div class="col-12 col-md-6 mb-2 p-0 border-left  pl-2">
                <?php $ch = true; ?>
                @if(Auth::user()->keshts != null)
                    @foreach (Auth::user()->keshtCity() as $kesht)
				<?php /*
                        @if($kesht->product_id == 1 or $kesht->product_id == 2 or $kesht->product_id == 11)
						*/ ?>
                        <?php $ch = false; ?>
                            <a href="{{ url('koodReq/create/'.$kesht->id) }}" class="btn btn-link text-dark text-decoration-none w-100 border-bottom">
                                <div class="row"> 
                                    <img src="{{ asset('image/icon/prod.svg') }}" alt="" style="width:100%" class="img-fluid col-2 border-left pl-2 ml-2" />
                                    <div class="col-9 text-right">
                                        <div class="row">
                                            <div class="col-12">
                                            درخواست برای محصول {{ $kesht->product->title }} {{ $kesht->ab?$kesht->ab->title:'' }}
                                            </div>
                                            <div class="col-6">
                                                <small>متراژ زیر کشت: {{ str_replace('.','/', $kesht->sum) }}  هکتار</small>
                                            </div>
                                            <div class="col-6">
                                                شهرستان:
                                                {{ $kesht->ct?$kesht->ct->title:"" }}
                                            </div>
                                        </div> 
                                        
                                    </div>
                                </div>
                            </a>
				<?php /*
                        @endif */ ?>
                    @endforeach
                    @endif
                @if($ch)
                    <div class="alert alert-danger mt-2">برای شما اطلاعات هیچ محصولی که شامل سهمیه کود شود ثبت نشده است.</div>
                @endif
            </div>
        
<?php /*
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','agency','clinic','pesticideShop','ornamentalWork']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/sam/createManager') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/clipboard2.png') }}" alt="" style="width:100%;" />

                    ثبت درخواست برای بهره بردار

                </a>

            </div>

        @endif
*/ ?>
        
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('koodReq/list') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/Mazrae-15.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    درخواست های داده شده
                </a>
            </div>


     <?php /*   

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','agency']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/listPahne') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/location.png') }}" alt="" style="width:100%;" />

                    درخواست های پهنه

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','clinic']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/clinicList') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/donor.png') }}" alt="" style="width:100%;" />

                    درخواست های در انتظار نسخه

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','pesticideShop']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/storeList') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/store.png') }}" alt="" style="width:100%;" />

                    درخواست های در انتظار قیمت دهی

                </a>

            </div>

        @endif

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','pestAndDisinfectionCompany']))

            <div class="col-6 col-md-3 mb-2">

                <a href="{{ url('request/afatkoshShopList') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/spray.png') }}" alt="" style="width:100%;" />

                    درخواست های خدمت

                </a>

            </div>

        @endif

        <?php /* <div class="col-12 bg-info rounded p-2 font-light font-weight-bold">

            خدمات دیگر

        </div>

        

        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','orchardist','planter','greenhouseOwner','ornamentalWork','agency']))

            <div class="col-6 col-md-3 mb-2">       

                <a href="{{ url('bazdidRequest/list') }}" class="btn btn-link">

                    <img src="{{ asset('image/icon/calendar.png') }}" alt="" style="width:100%;" />

                    {{ __('validation.attributes.bazdidRequest') }}

                </a>

            </div>

        @endif

        */ ?>
    </div>

        @endif
        
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','broker']))
            <div class="row">
                <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">
                    درخواست ها
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3 mb-2 p-0">
                    <a href="{{ url('brokerKoodReq/list') }}" class="btn btn-link text-dark text-decoration-none">
                        <img src="{{ asset('image/icon/Mazrae-16.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
						<span class="col-12 p-0">
							درخواست های جدید
							<?php /* Auth::user()->brokerReqNewCount() */ ?>
						</span>
                    </a>
                </div>
                <div class="col-12 col-md-3 mb-2 p-0">
                    <a href="{{ url('brokerKoodReq/sendList') }}" class="btn btn-link text-dark text-decoration-none">
                        <img src="{{ asset('image/icon/Mazrae-17.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
						<span class="col-12 p-0">
							درخواست های ارسال شده
							<?php /* {{ Auth::user()->brokerReqSendCount() }} */ ?>
						</span>
						
                    </a>
                </div>
                <div class="col-12 col-md-3 mb-2 p-0">
                    
					<a href="{{ url('brokerKoodReq/lastList') }}" class="btn btn-link text-dark text-decoration-none">
                        <img src="{{ asset('image/icon/Mazrae-18.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
						<span class="col-12 p-0">
							درخواست تاریخ گذشته
							<?php /* {{ Auth::user()->brokerReqLastCount() }} */ ?>
							
						</span>
						
                    </a>
                </div>
                <div class="col-12 col-md-3 mb-2 p-0">
					
					<a href="{{ url('brokerKoodReq/backList') }}" class="btn btn-link text-dark text-decoration-none">
                        <img src="{{ asset('image/icon/Mazrae-19.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
						<span class="col-12 p-0">
							درخواست های مرجوع شده
							<?php /* {{ Auth::user()->brokerReqBackCount() }} */ ?>
							
						</span>
						
                    </a>
                </div>
				
				<div class="col-12 col-md-3 mb-2 p-0">
					<a href="{{ url('report/brokerKoods') }}" class="btn btn-link text-dark text-decoration-none">
						<img src="{{ asset('image/icon/Mazra-6.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
						گزارش تخصیص
					</a>
				</div>
            </div>
        
        @endif
        @if(Auth::user()->authorizeCheck(['admin','manager','programmer','broker']))
            <div class="row">
                <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">
                    گزارش ها
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3 mb-2 p-0">
					<a href="{{ url('brokerKood/view') }}" class="btn btn-link text-dark text-decoration-none">
						<img src="{{ asset('image/icon/Mazrae-21.svg') }}" alt="" style="width:64px;" class="img-fluid border-left  pl-2 ml-2" />
						کود های اختصاصی
					</a>
                </div>
                
            </div>
        
        @endif
</div>



@endsection
