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

    @if(Auth::user()->authorizeCheck(['admin','manager','programmer','managerJahad','takhsis','nazer','checkPahne']))
        <div class="row">
            <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">
                مدیریت
            </div>
        </div>
        <div class="row">
            @if(Auth::user()->authorizeCheck(['admin','manager','programmer','nazer']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('user/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/users.svg') }}" alt="" style="width:64px;" class="img-fluid border-left  pl-2 ml-2" />
                    کاربرها
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','manager','programmer','checkPahne']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('checkcodemelli.html') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/users.svg') }}" alt="" style="width:64px;" class="img-fluid border-left  pl-2 ml-2" />
                    بررسی سامانه پهنه
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','takhsis','nazer']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('cityKood/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/loc.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    تخصیص کود شهرستان ها
                </a>
            </div>
            @endif
            
            @if(Auth::user()->authorizeCheck(['admin','managerJahad','nazer']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('brokerKood/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/brokers.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    کارگزاران
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','takhsis','nazer']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('productKoodValue/all') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/time.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    زمان تخصیص کود
                </a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','takhsis','nazer']))
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('report/ostanReport') }}" class="btn btn-link text-dark text-decoration-none">
					<img src="{{ asset('image/icon/Mazra-6.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
					گزارش کلی
				</a>
            </div>
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('report/koods') }}" class="btn btn-link text-dark text-decoration-none">
					<img src="{{ asset('image/icon/Mazra-6.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
					گزارش تخصیص
				</a>
            </div>
            @endif
            @if(Auth::user()->authorizeCheck(['admin','managerJahad','nazer']))
            <div class="col-12 col-md-6 mb-2 p-0">
                <a href="{{ url('report/brokerCity') }}" class="btn btn-link text-dark text-decoration-none">
					<img src="{{ asset('image/icon/Mazra-6.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
					گزارش تخصیص شهرستان به تفکیک کارگزار
				</a>
            </div>
            <div class="col-12 col-md-6 mb-2 p-0">
                <a href="{{ url('report/getuser') }}" class="btn btn-link text-dark text-decoration-none">
					<img src="{{ asset('image/icon/Mazra-6.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
					گزارش بهره برداران شهرستان
				</a>
            </div>
            @endif
            
        </div>

    @endif
    
	
    @if(Auth::user()->authorizeCheck(['planter']))

    <div class="row">

        <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">

            درخواست کود ( خرید)

        </div>
 <?php $show = true; ?>
            <div class="col-12 col-md-6 mb-2 p-0 border-left  pl-2">
                <?php $ch = true; ?>
                @if(Auth::user()->keshts != null)
                    @foreach (Auth::user()->keshtCity() as $kesht)
				
                        <?php $ch = false; 
							if($kesht->product->id == 1) $show = false;
						?>
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
                                            <div class="col-6">
                                                <small>مسئول پهنه: {{ $kesht->m_name }} </small>
                                            </div>
                                            <div class="col-6">
                                                موبایل:
                                                {{ $kesht->m_mobile }} 
                                            </div>
                                        </div> 
                                        
                                    </div>
                                </div>
                            </a>
				
                    @endforeach
                    @endif
                @if($ch)
                    <div class="alert alert-danger mt-2">برای شما اطلاعات هیچ محصولی که شامل سهمیه کود شود ثبت نشده است.</div>
                @endif
				<?php /*
				@if(Auth::user()->shotooies != null)
				<hr/>
                    @foreach (Auth::user()->shotooiProd() as $shotooi)
				
                        <?php $ch = false; ?>
                            <a href="{{ url('koodReqShotooi/create/'.$shotooi->product_id) }}" class="btn btn-link text-dark text-decoration-none w-100 border-bottom">
                                <div class="row"> 
                                    <img src="{{ asset('image/icon/prod.svg') }}" alt="" style="width:100%" class="img-fluid col-2 border-left pl-2 ml-2" />
                                    <div class="col-9 text-right">
                                        <div class="row">
                                            <div class="col-12">
                                            درخواست برای محصول {{ $shotooi->product?$shotooi->product->title:'' }} تحویل داده شده
                                            </div>
                                            <div class="col-12">
                                                <small>مقدار تحویل داده شده: {{ $shotooi->sum }}  کیلوگرم</small>
                                            </div>
                                        </div> 
                                        
                                    </div>
                                </div>
                            </a>
				
                    @endforeach
                    @endif
				 */ ?>
				@if($show)
					@if($userReqs != null)
					<hr/>
						@foreach ($userReqs as $ezhar)

							<a href="{{ url('userReq/Declarative/'.$ezhar->id) }}" class="btn btn-link text-dark text-decoration-none w-100 border-bottom">
								<div class="row"> 
									<img src="{{ asset('image/icon/prod.svg') }}" alt="" style="width:100%" class="img-fluid col-2 border-left pl-2 ml-2" />
									<div class="col-9 text-right">
										<div class="row">
											<div class="col-12">
											خود اظهاری برای کشت شتوی  {{ $ezhar->product->title }} در شهرستان {{ $ezhar->city->title }}
											</div>
											<div class="col-12">
												<small>کود اختصاص داده شده: اوره</small>
											</div>
										</div> 

									</div>
								</div>
							</a>

						@endforeach
					@endif
				@endif
            </div>

        
            <div class="col-12 col-md-3 mb-2 p-0">
                <a href="{{ url('koodReq/list') }}" class="btn btn-link text-dark text-decoration-none">
                    <img src="{{ asset('image/icon/Mazrae-15.svg') }}" alt="" style="width:64px;" class="img-fluid border-left pl-2 ml-2" />
                    درخواست های داده شده
                </a>
            </div>

    </div>
	@endif
        
        @if(Auth::user()->authorizeCheck(['broker']))
            <div class="row">
                <div class="col-12 bg-title rounded p-2 font-light font-weight-bold">
                    مدیریت کارگزار
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
        @if(Auth::user()->authorizeCheck(['broker']))
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
