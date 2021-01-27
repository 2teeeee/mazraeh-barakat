@extends('layouts.main')

@section('content')



<div class="container-fluid mt-2">
    <div class="row mb-2">
        <div class="col-12 mb-2">
            <div class="card shadow-success mb-2">
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
                    <div class="col-md-4 float-right">
                        <div class="row card-header mb-2 rounded-top">
                            <h5>اُپارک: یه حال باحال!</h5>
                        </div>
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
                            <div class="col-md-12 mt-2 p-0">
                                <a href="{{ url('/offer') }}" class="col-md-12 p-2 text-center btn btn-success">
                                    <i class="fas fa-eye"></i> 
                                    <span class="my-2 pr-2">مشاهده جزئیات...</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
    </div>
    
    <div class="row mb-2 box-card">
        <div class="col-12">
            <div class="py-2 border-info border-bottom border-2 text-right">
                <span class="font-weight-bold">تخفیف های ویژه دسته</span>
                <a href="#" class="badge badge-info float-left p-2">بیشتر ببینید...</a>
            </div>
            <div class="row">
                
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class="text-dark text-decoration-none" >
                        <div class="card card-h shadow-info">
                            <img src="{{ asset('upload/offer/p1.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">باغ رستوران مهرآفرین</h6>
                                <p class="card-text">سفارش از منوی غذاهای ایرانی، فرنگی، دریایی و ...</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                    40%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    3 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">20000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">12000 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                        <div class="card card-h shadow-info">
                            <img src="{{ asset('upload/offer/p2.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">سینی های ویژه باغ رستوران شاندیز</h6>
                                <p class="card-text">سینی های ویژه ناهار و شام باغ رستوران شاندیز برج vip با ۳۰% تخفیف و پرداخت از ۶۲۳۰۰ تومان</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                    30%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    123 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">89000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">62300 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                        <div class="card card-h shadow-info">
                            <img src="{{ asset('upload/offer/p5.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">اسپند دود کن پرتابل مدل فندک</h6>
                                <p class="card-text">اسپند دود کن پرتابل مدل فندک با ۳۰% تخفیف و پرداخت ۱۷۵۰۰ تومان به جای ۲۵۰۰۰ تومان</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                    30%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    3 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">25000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">17500 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                        <div class="card card-h shadow-info">
                            <img src="{{ asset('upload/offer/p8.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">ترازوی آشپزخانه دیجیتال</h6>
                                <p class="card-text">ترازوی آشپزخانه دیجیتال مدل SF۴۰۰ ده کیلویی با ۳۳% تخفیف</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                    33%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    12 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">70000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">46500 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
              </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <img src="{{ asset('upload/banner/b2.jpg') }}" class="img-banner" />
        </div>
    </div>
    <div class="row mb-2 box-card">
        <div class="col-12">
            <div class="py-2 border-success border-bottom border-2 text-right">
                <span class="font-weight-bold">تخفیف های دسته</span>
            </div>
            <div class="row">
                
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
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
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
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
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
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
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
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
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class="text-dark text-decoration-none" >
                        <div class="card card-h shadow-danger">
                            <img src="{{ asset('upload/offer/p14.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">آموزش عمومی شنا در استخر پیام مخابرات</h6>
                                <p class="card-text">آموزش عمومی شنا در استخر پیام مخابرات همراه با ۲۵% تخفیف و پرداخت ۱۵۰۰۰۰ تومان به جای ۲۰۰۰۰۰ تومان</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                25%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    8 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">200000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">150000 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                        <div class="card card-h shadow-danger">
                            <img src="{{ asset('upload/offer/p4.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">نظم دهنده و نگهدارنده کفش</h6>
                                <p class="card-text">نظم دهنده و نگهدارنده کفش با ۲۹% تخفیف و پرداخت ۸۵۰۰ تومان به جای ۱۲۰۰۰ تومان</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                    29%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    123 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">12000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">8500 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3 my-3 link-card">
                    <a href="{{ url('/offer') }}" class=" text-dark text-decoration-none">
                        <div class="card card-h shadow-danger">
                            <img src="{{ asset('upload/offer/p7.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body overflow-auto">
                                <h6 class="card-title">آویز نگهدارنده شال و روسری مخملی</h6>
                                <p class="card-text">آویز نگهدارنده شال و روسری مخملی با ۳۰% تخفیف و پرداخت ۱۰۵۰۰ تومان به جای ۱۵۰۰۰ تومان</p>
                            </div>
                            <div class="card-footer py-2 px-1">
                                <span class="bg-danger border border-danger text-white rounded p-2 ml-1 float-right">
                                    30%
                                </span>
                                <span class="border border-info rounded p-2 float-right">
                                    <i class="fas fa-shopping-basket"></i>
                                    3 خرید
                                </span>
                                <div class="col-5 float-left text-center p-0">
                                    <del class="text-danger">15000 تومان</del> 
                                    <br/>
                                    <span class="font-weight-bold">10500 تومان</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
              </div>
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-12">
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