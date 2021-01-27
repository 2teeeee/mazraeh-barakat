<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>@yield('title')</title>             
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('admin/css/theme-default.css') }}"/>
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/admin.css') }}"/>
        <link href="{{ asset('main/datepicker/persiandatepicker.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->         
        
        <link rel="stylesheet" href="{{ asset('css/persianDatepicker.css') }}" />
        <script src="{{ asset('js/persianDatepicker.js') }}"></script>
        
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-mode-rtl page-content-rtl">
            
            <!-- START PAGE SIDEBAR -->
            @include('layouts.admin.sidebar')
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
               <!-- START X-NAVIGATION VERTICAL -->
                    @include('layouts.admin.navigationv')
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                    @include('layouts.admin.breadcrumb')
                <!-- END BREADCRUMB -->                      
                
                <div class="page-title">     
                <!--               
                    <h2>Layout RTL <span class="fa fa-arrow-circle-o-right"></span></h2>
                -->
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
            
                    <!-- START BUTTON -->
                        @include('layouts.admin.button')
                    <!-- END BUTTON -->    

                    @yield('content')        
                                        
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="" preload="auto"></audio>
        <audio id="audio-fail" src="" preload="auto"></audio>
        <!-- END PRELOADS -->                
        

        <!-- START SCRIPTS -->
            @include('layouts.admin.scripts')
        <!-- END SCRIPTS -->         
        @yield('script') 
            
    </body>
</html>






