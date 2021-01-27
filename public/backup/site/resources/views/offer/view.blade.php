@extends('layouts.main')

@section('content')



<div class="container-fluid mt-2">
    <div class="row mb-2">
        <div class="col-12 mb-2">
            <div class="card shadow-success mb-2">
                <div class="card-header">
                    <h5>
                    پارک: یه حال باحال! اوج هیجان با لوکس‌ترین و بزرگ‌ترین پارک آبی سرپوشیده خاورمیانه تا ۲۰% تخفیف</h5>
                </div>
                <div class="card-body row">
                    <div class="col-md-8">
                               
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('upload/offer/17_45_10_1_1_2.jpg') }}" class="d-block w-100 rounded" alt="یبلات">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('upload/offer/20_33_11_1_1_2.jpg') }}" class="d-block w-100 rounded" alt="بلبیس">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('upload/offer/2_688_68_1_1_2.jpg') }}" class="d-block w-100 rounded" alt="بلبیس">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 float-right">
                        <div class="row">
                            <div class="col-8 mt-3">
                                <div class="row">
                                    <span class="pl-2">قیمت واقعی: </span> <del class="text-danger"> <h5>20000 تومان</h5></del> 
                                </div>
                                <div class="row">
                                    <span class="py-1 pl-2">قیمت پرداختی: </span> <span class="font-weight-bold"> <h3>12000 تومان</h3></span>
                                </div>
                            </div>
                            <div class="col-4 p-0">
                                <span class="bg-danger border border-danger text-white rounded-circle py-3 px-1 ml-1 float-left text-center cube-85">
                                    <span>تخفیف</span>
                                    <h3>30%</h3>
                                </span>
                            </div>
                            <div class="col-md-12 mt-2 pt-3 pb-2 border-top border-gray">
                                
                                <h6 class="">زمان باقی مانده:</h6>
                                <div class="clock timer-offer"></div>

                            </div>
                            <div class="col-md-12 mt-2 pt-3 border-top border-grey">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <i class="fas fa-shopping-bag fa-2x w-100"></i>
                                        <span class="w-100 float-right">تعداد خرید</span>
                                        <strong class="w-100 float-right text-success">30</strong>
                                    </div>
                                    <div class="col-4 text-center">
                                        <i class="fas fa-star fa-2x w-100"></i>
                                        <span class="w-100 float-right">امتیاز</span>
                                        <strong class="w-100 float-right text-info">8/10</strong>
                                    </div>
                                    <div class="col-4 text-center">
                                        <i class="fas fa-list-alt fa-2x w-100"></i>
                                        <span class="w-100 float-right">دسته</span>
                                        <strong class="w-100 float-right text-danger">تفریحی و ورزشی</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5 p-0">
                                <a href="#basket" class="col-md-12 p-2 text-center btn btn-success">
                                    <i class="fas fa-shopping-cart"></i> 
                                    <span class="my-2 pr-2">الان بخرید...</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-danger">
                    <i class="fas fa-star"></i>
                    <strong>ویژگی های تخفیف ارائه شده</strong>
                </div>
                <div class="card-body text-justify">
                    
                    <p><span>مجموعه اپارک ویژه سانس آزاد&nbsp; <strong>شنبه تا
پنجشنبه&nbsp;</strong>برای افراد <strong>بالای ۱۱۰ سانتی متر
قد</strong>، تنها با پرداخت ۶۸۰۰۰ تومان اما به ارزش ۸۵۰۰۰ تومان
(۲۰% تخفیف)</span></p><p><span>مجموعه اپارک ویژه سانس آزاد&nbsp;</span>
<strong>جمعه&nbsp;</strong> <span>برای افراد</span> <strong>بالای
۱۱۰ سانتی متر قد</strong><span>، تنها با پرداخت ۸۴۹۰۰ تومان اما به
ارزش ۱۰۰۰۰۰ تومان (۱۵% تخفیف)</span></p><p><span>مجموعه اپارک ویژه سانس آزاد&nbsp;&nbsp;<strong>شنبه تا
پنجشنبه&nbsp;</strong>برای افراد<strong>&nbsp;پایین ۱۱۰ سانتی متر
قد</strong>، تنها با پرداخت 39900 تومان اما به ارزش 50000 تومان
(۲۰% تخفیف)</span></p><p><span>مجموعه اپارک ویژه سانس
آزاد&nbsp;&nbsp;<strong>جمعه&nbsp;</strong>&nbsp;برای
افراد&nbsp;<strong>پایین ۱۱۰ سانتی متر قد</strong>، تنها با پرداخت
55250 تومان اما به ارزش 65000 تومان (۱۵% تخفیف)</span></p><p><span>برای انتخاب روی گزینه</span> <em>خرید</em> <span>کلیک
کنید.</span></p>
<em><span>برای مشاهده ساعات سرویس دهی روی تقویم کاری اپارک کلیک
کنید.</span></em><ol><li><strong>کارت‌خوان: دارد</strong></li></ol><ol><li><strong>بوفه: دارد</strong></li></ol><ol><li><strong>رختکن: دارد</strong></li></ol><ol><li><strong>جای پارک آسان: دارد</strong></li></ol><ol><li><strong>سیستم تهویه: دارد</strong></li></ol><ul><li><strong>مخاطب : </strong>بانوان و آقایان</li></ul><ul><li><strong>مدت زمان : </strong>سانس آزاد</li></ul><ul><li><strong>امکانات استخر:</strong>&nbsp;استخر موج، جکوزی، سرسره پیچشی، سرسره تونلی، سرسره سقوط آزاد، سرسره لوپ، رودخانه خروشان، سرسره کودکان و منطقه بازی</li><li><strong>ظرفیت پذیرش در روز:</strong> ۳۰۰۰ نفر</li></ul>

                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-danger">
                    <i class="fas fa-info-circle"></i>
                    <strong>شرایط استفاده از تخفیف</strong>
                </div>
                <div class="card-body text-justify">
                    
                    <ul class="list"><li><em><span>امکان کنسل کردن سفارش نیست. لطفا در هنگام خرید شرایط
استفاده و روزهای سرویس دهی را با دقت مطالعه کنید</span></em></li><li><span>استفاده از برخی سرسره‌ها برای کودکان ممنوع است. تشخیص این
امر با اپراتور سرسره‌ها است.</span></li><li><span>نیاز به هماهنگی نیست</span></li>
                    
<div class="deal-vendor-info-row clear"><div class="row-icon">
<span class="icon-event"></span></div><div class="row-text">
<span class="row-text-caption">زمان استفاده:</span>
<span class="row-text-value">از <em class="number-font">1397/10/6</em> تا <em class="number-font">1397/10/30</em></span></div></div><div class="deal-vendor-info-row clear"><div class="row-icon">
<span class="icon-clock"></span></div><div class="row-text">
<span class="row-text-caption">ساعت پاسخگویی و سرویس دهی:</span>
<span class="row-text-value">پاسخگویی همه روزه از ساعت 8 الی 22</span></div></div><div class="deal-vendor-info-row clear"><div class="row-icon">
<span class="icon-calendar"></span></div><div class="row-text">
<span class="row-text-caption">روزهای سرویس‌دهی:</span>
<span class="row-text-value">همه روزه</span></div></div>
                    
                    </ul>
                    
                </div>
            </div>
            
            <div class="card shadow-sm mt-3">
                <div class="card-header text-danger">
                    <i class="fas fa-map-marked-alt"></i>
                    <strong>موقعیت محل ارائه تخفیف</strong>
                </div>
                <div class="card-body">
                    
                    <div class="deal-vendor-info">
                        
                        
                        <div class="deal-vendor-info-row clear"><div class="row-icon">
<span class="icon-tel"></span></div><div class="row-text">
<span class="row-text-caption">شماره تلفن
پارک آبی اُپارک:
</span>
<span class="row-text-value number-font">49264</span></div></div><div class="deal-vendor-info-row clear"><div class="row-icon">
<span class="icon-location"></span></div><div class="row-text">
<span class="row-text-caption">آدرس:</span>
<span class="row-text-value">تهران، به سمت کرج، بعد از بزرگراه آزادگان، بلوار کوهک (شهید پوری)
انتهای خیابان شمیم</span></div></div></div>
                    
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3468.4118860992494!2d52.51540712916664!3d29.620778219521593!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1547211299188" height="300" class="pt-3" frameborder="0" style="border:0;width:100%;" allowfullscreen></iframe>
                    
                </div>
            </div>
            
        </div>
        <div class="col-md-6 mt-2">
            <div class="card shadow-sm">
                <div class="card-header text-danger">
                    <strong>نظرات کاربرها</strong>
                </div>
                <div class="card-body">
                    
                </div>
            </div>
            
        </div>
        <div class="col-md-6 mt-2">
            <div class="card shadow-sm">
                <div class="card-header text-danger">
                    <strong>سایر تخفیف ها</strong>
                </div>
                <div class="card-body">
                    
                <div class="row box-card">

                    <div class="col-12 col-sm-6 col-md-12 col-lg-6 my-3 link-card">
                        <a href="{{ url('/offer') }}" class="text-dark text-decoration-none" >
                            <div class="card card-h shadow-success">
                                <img src="{{ asset('upload/offer/p3.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body overflow-auto">
                                    <h6 class="card-title">خوراک های باغ رستوران شاندیز</h6>
                                    <p class="card-text">خوراک های باغ رستوران شاندیز برج vip با ۳۰% تخفیف و پرداخت از ۱۶۸۰۰ تومان</p>
                                </div>
                                <div class="card-footer py-2 px-1">
                                    <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                        20%
                                    </span>
                                    <span class="border border-info rounded p-2 float-right">
                                        <i class="fas fa-shopping-basket"></i>
                                        110 خرید
                                    </span>
                                    <div class="col-5 float-left text-center p-0">
                                        <del class="text-danger">24000 تومان</del> 
                                        <br/>
                                        <span class="font-weight-bold">16800 تومان</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-12 col-lg-6 my-3 link-card">
                        <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                            <div class="card card-h shadow-success">
                                <img src="{{ asset('upload/offer/p10.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body overflow-auto">
                                    <h6 class="card-title">ماساژ میکس (ریلکسی، سوئدی، درمانی) </h6>
                                    <p class="card-text">ماساژ میکس (ریلکسی، سوئدی، درمانی) ویژه بانوان و آقایان در مرکز ماساژ مسیر سبز بهشت</p>
                                </div>
                                <div class="card-footer py-2 px-1">
                                    <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                        55%
                                    </span>
                                    <span class="border border-info rounded p-2 float-right">
                                        <i class="fas fa-shopping-basket"></i>
                                        143 خرید
                                    </span>
                                    <div class="col-5 float-left text-center p-0">
                                        <del class="text-danger">100000 تومان</del> 
                                        <br/>
                                        <span class="font-weight-bold">45000 تومان</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-12 col-lg-6 my-3 link-card">
                        <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                            <div class="card card-h shadow-success">
                                <img src="{{ asset('upload/offer/p13.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body overflow-auto">
                                    <h6 class="card-title">ماساژ پا درمانی با روغن گیاهی</h6>
                                    <p class="card-text">ماساژ پا درمانی با روغن گیاهی و ویبره آب گرم و حباب در مرکز ماساژ مسیر سبز بهشت</p>
                                </div>
                                <div class="card-footer py-2 px-1">
                                    <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                        50%
                                    </span>
                                    <span class="border border-info rounded p-2 float-right">
                                        <i class="fas fa-shopping-basket"></i>
                                        103 خرید
                                    </span>
                                    <div class="col-5 float-left text-center p-0">
                                        <del class="text-danger">100000 تومان</del> 
                                        <br/>
                                        <span class="font-weight-bold">50000 تومان</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-12 col-lg-6 my-3 link-card">
                        <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                            <div class="card card-h shadow-success">
                                <img src="{{ asset('upload/offer/p18.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body overflow-auto">
                                    <h6 class="card-title">نظم دهنده لوازم آرایشی پلاستیکی</h6>
                                    <p class="card-text">نظم دهنده لوازم آرایشی پلاستیکی با ۲۷% تخفیف و پرداخت ۱۴۵۰۰ تومان به جای ۲۰۰۰۰ تومان</p>
                                </div>
                                <div class="card-footer py-2 px-1">
                                    <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                        27%
                                    </span>
                                    <span class="border border-info rounded p-2 float-right">
                                        <i class="fas fa-shopping-basket"></i>
                                        143 خرید
                                    </span>
                                    <div class="col-5 float-left text-center p-0">
                                        <del class="text-danger">20000 تومان</del> 
                                        <br/>
                                        <span class="font-weight-bold">14500 تومان</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                </div>
            </div>
            
        </div>
        <div class="col-12 mt-2">
            <div class="border border-grey-light p-2 rounded">
                <h6>
                    برچسب های مرتبط
                </h6>
                <a href="#" class="badge badge-primary">Secondary</a>
                <a href="#" class="badge badge-primary">Secondary</a>
                <a href="#" class="badge badge-primary">Secondary</a>
                <a href="#" class="badge badge-primary">Secondary</a>
                <a href="#" class="badge badge-primary">Secondary</a>
            </div>
            
        </div>
    </div>
    
</div>

    



@endsection


@section('script')
<script type="text/javascript">
        var clock;

        $(document).ready(function() {
                var clock;

                clock = $('.clock').FlipClock({
                clockFace: 'DailyCounter',
                autoStart: false,
                callbacks: {
                        stop: function() {
                            location.reload();
                        }
                }
            });

            clock.setTime(1200);
            clock.setCountdown(true);
            clock.start();

        });
</script>
@endsection