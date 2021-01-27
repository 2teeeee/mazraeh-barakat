<div class="page-sidebar page-sidebar-fixed scroll">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="{{ url('admin/index.html') }}">گرین بن</a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                @if(Auth::user()->image != null)
                <img src="{{ asset('/images/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"/>
                @else
                <i class="glyphicon glyphicon-user fa-3x"></i>
                @endif
            </a>
            <div class="profile">
                <div class="profile-image">
                    @if(Auth::user()->image != null)
                        <img src="{{ asset('/images/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}"/>
                    @else
                        <i class="glyphicon glyphicon-user fa-5x"></i>
                    @endif
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{ Auth::user()->name }}</div>
                    <div class="profile-data-title">{{ Auth::user()->mobile }}</div>
                </div>
                <div class="profile-controls">
                    <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                    <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                </div>
            </div>                                                                        
        </li>
        <li class="xn-title">Navigation</li>

               
        <li>
            <a href="{{ url('user/all') }}"><span class="xn-text">کاربر ها</span> <span class="fa fa-user"></span></a>
        </li> 
        <li>
            <a href="{{ url('bahrebardar/all') }}"><span class="xn-text">بهره بردار ها</span> <span class="fa fa-user"></span></a>
        </li> 
        <li>
            <a href="{{ url('clinic/all') }}"><span class="xn-text">کلینیک ها</span> <span class="fa fa-user"></span></a>
        </li> 
        <li>
            <a href="{{ url('store/all') }}"><span class="xn-text">فروشگاه ها</span> <span class="fa fa-user"></span></a>
        </li> 
        <li>
            <a href="{{ url('dafAfat/all') }}"><span class="xn-text">شرکت دفع آفات</span> <span class="fa fa-user"></span></a>
        </li> 
        <li>
            <a href="{{ url('product/all') }}"><span class="xn-text">محصولات زراعی</span> <span class="fa fa-user"></span></a>
        </li> 
        <li>
            <a href="{{ url('kood/all') }}"><span class="xn-text">کود ها</span> <span class="fa fa-user"></span></a>
        </li> 
<!--        <li>
            <a href="{{ url('page/all') }}"><span class="xn-text">صفحه ها</span> <span class="fa fa-book"></span></a>
        </li>  
        <li>
            <a href="{{ url('faq/all') }}"><span class="xn-text">پرسش های متداول</span> <span class="fa fa-wrench"></span></a>
        </li>  
        <li>
            <a href="{{ url('category/all') }}"><span class="xn-text">گروه محصول ها</span> <span class="fa fa-wrench"></span></a>
        </li>  
        <li>
            <a href="{{ url('product/all') }}"><span class="xn-text">محصول</span> <span class="fa fa-wrench"></span></a>
        </li> 
        <li>
            <a href="{{ url('invoice/all') }}"><span class="xn-text">سفارش ها</span> <span class="fa fa-wrench"></span></a>
        </li> 
        <li>
            <a href="{{ url('ticket/all') }}"><span class="xn-text">تیکت</span> <span class="fa fa-ticket"></span></a>
        </li> 
        <li>
            <a href="{{ url('contact/all') }}"><span class="xn-text">تماس با ما</span> <span class="fa fa-ticket"></span></a>
        </li> 
        <li>
            <a href="{{ url('corporate/all') }}"><span class="xn-text">درخواست همکاری</span> <span class="fa fa-ticket"></span></a>
        </li> -->



        <li class="xn-openable">
            <a href="#"><span class="fa fa-dashboard"></span> <span class="xn-text">تنظیمات</span></a>
            <ul>
                <li><a href="{{ url('setting/1/edit') }}"><span class="xn-text">تنظیمات</span></a></li>
                <li><a href="{{ url('handy/all') }}"><span class="xn-text">گزینه ها</span></a></li>
            </ul>
        </li>    
<!--
        <li class="xn-openable">
            <a href="#"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboards</span></a>
            <ul>
                <li><a href="index.html"><span class="xn-text">Dashboard 1</span></a></li>
                <li><a href="dashboard.html"><span class="xn-text">Dashboard 2</span></a><div class="informer informer-danger">New!</div></li>
                <li><a href="dashboard-dark.html"><span class="xn-text">Dashboard 3</span></a><div class="informer informer-danger">New!</div></li>
            </ul>
        </li>                   
        <li class="xn-openable">
            <a href="#"><span class="xn-text">Pages</span> <span class="fa fa-files-o"></span></a>
            <ul>
                <li><a href="pages-gallery.html">Gallery <span class="fa fa-image"></span></a></li>
                <li><a href="pages-invoice.html">Invoice <span class="fa fa-dollar"></span></a></li>
                <li><a href="pages-edit-profile.html">Edit Profile <span class="fa fa-wrench"></span></a></li>
                <li><a href="pages-profile.html">Profile <span class="fa fa-user"></span></a></li>
                <li><a href="pages-address-book.html">Address Book <span class="fa fa-users"></span></a></li>
                <li class="xn-openable">
                    <a href="#">Timeline <span class="fa fa-clock-o"></span></a>
                    <ul>
                        <li><a href="pages-timeline.html">Default <span class="fa fa-align-center"></span></a></li>
                        <li><a href="pages-timeline-simple.html">Full Width <span class="fa fa-align-justify"></span></a></li>
                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#">Mailbox <span class="fa fa-envelope"></span></a>
                    <ul>
                        <li><a href="pages-mailbox-inbox.html">Inbox <span class="fa fa-inbox"></span></a></li>
                        <li><a href="pages-mailbox-message.html">Message <span class="fa fa-file-text"></span></a></li>
                        <li><a href="pages-mailbox-compose.html">Compose <span class="fa fa-pencil"></span></a></li>
                    </ul>
                </li>
                <li><a href="pages-messages.html">Messages <span class="fa fa-comments"></span></a></li>
                <li><a href="pages-calendar.html">Calendar <span class="fa fa-calendar"></span></a></li>
                <li><a href="pages-tasks.html">Tasks <span class="fa fa-edit"></span></a></li>
                <li><a href="pages-content-table.html">Content Table <span class="fa fa-columns"></span></a></li>
                <li><a href="pages-faq.html">FAQ <span class="fa fa-question-circle"></span></a></li>
                <li><a href="pages-search.html">Search <span class="fa fa-search"></span></a></li>
                <li class="xn-openable">
                    <a href="#">Blog <span class="fa fa-file"></span></a>                                
                    <ul>                                    
                        <li><a href="pages-blog-list.html">List of Posts <span class="fa fa-copy"></span></a></li>
                        <li><a href="pages-blog-post.html">Single Post <span class="fa fa-file-o"></span></a></li>
                    </ul>
                </li>
                <li><a href="pages-lock-screen.html">Lock Screen <span class="fa fa-lock"></span></a></li>
                <li class="xn-openable">
                    <a href="#">Login <span class="fa fa-sign-in"></span></a>
                    <ul>                                                                        
                        <li><a href="pages-login.html">Login v1</a></li>
                        <li><a href="pages-login-v2.html">Login v2</a></li>
                        <li><a href="pages-login-inside.html">Login v2 Inside</a></li>
                        <li><a href="pages-login-website.html">Website Login</a></li>
                        <li><a href="pages-login-website-light.html"> Website Login Light</a></li>
                    </ul>
                </li>    
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-plus"></span> Registration</a>
                    <ul>                                                                        
                        <li><a href="pages-registration.html">Default</a></li>
                        <li><a href="pages-registration-login.html">With Login</a></li>                                    
                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#">Error Pages <span class="fa fa-warning"></span></a>
                    <ul>                                    
                        <li><a href="pages-error-404.html">Error 404 Sample 1</a></li>
                        <li><a href="pages-error-404-2.html">Error 404 Sample 2</a></li>
                        <li><a href="pages-error-500.html"> Error 500</a></li>
                    </ul>
                </li>                            
            </ul>
        </li>
        <li class="xn-openable active">
            <a href="#"><span class="xn-text">Layouts</span> <span class="fa fa-file-text-o"></span></a>
            <ul>
                <li><a href="layout-boxed.html">Boxed</a></li>
                <li><a href="layout-nav-toggled.html">Navigation Toggled</a></li>
                <li><a href="layout-nav-toggled-hover.html">Nav Toggled (Hover)</a></li>
                <li><a href="layout-nav-toggled-item-hover.html">Nav Toggled (Item Hover)</a></li>
                <li><a href="layout-nav-top.html">Navigation Top</a></li>
                <li><a href="layout-nav-right.html">Navigation Right</a></li>
                <li><a href="layout-nav-top-fixed.html">Top Navigation Fixed</a></li>
                <li><a href="layout-nav-custom.html">Custom Navigation</a></li>
                <li><a href="layout-nav-top-custom.html">Custom Top Navigation</a></li>
                <li><a href="layout-frame-left.html">Frame Left Column</a></li>
                <li><a href="layout-frame-right.html">Frame Right Column</a></li>
                <li><a href="layout-search-left.html">Search Left Side</a></li>
                <li><a href="layout-page-sidebar.html">Page Sidebar</a></li>
                <li><a href="layout-page-loading.html">Page Loading</a></li>                            
                <li class="active"><a href="layout-rtl.html">Layout RTL</a></li>
                <li><a href="layout-tabbed.html">Page Tabbed</a></li>
                <li><a href="layout-custom-header.html">Custom Header</a></li>
                <li><a href="layout-adaptive-panels.html">Adaptive Panels</a></li>                            
                <li><a href="blank.html">Blank Page</a></li>
            </ul>
        </li>
        <li class="xn-title">Components</li>
        <li class="xn-openable">
            <a href="#"><span class="xn-text">UI Kits</span> <span class="fa fa-cogs"></span></a>                        
            <ul>
                <li><a href="ui-widgets.html">Widgets <span class="fa fa-heart"></span></a></li>                            
                <li><a href="ui-elements.html">Elements <span class="fa fa-cogs"></span></a></li>
                <li><a href="ui-buttons.html">Buttons <span class="fa fa-square-o"></span></a></li>                            
                <li><a href="ui-panels.html">Panels <span class="fa fa-pencil-square-o"></span></a></li>
                <li><a href="ui-icons.html">Icons <span class="fa fa-magic"></span></a><div class="informer informer-warning">+679</div></li>
                <li><a href="ui-typography.html">Typography <span class="fa fa-pencil"></span></a></li>
                <li><a href="ui-portlet.html">Portlet <span class="fa fa-th"></span></a></li>
                <li><a href="ui-sliders.html">Sliders <span class="fa fa-arrows-h"></span></a></li>
                <li><a href="ui-alerts-popups.html">Alerts & Popups <span class="fa fa-warning"></span></a></li>                            
                <li><a href="ui-lists.html">Lists <span class="fa fa-list-ul"></span></a></li>
                <li><a href="ui-tour.html">Tour <span class="fa fa-random"></span></a></li>
                <li><a href="ui-nestable.html">Nestable List <span class="fa fa-sitemap"></span></a></li>
                <li><a href="ui-autocomplete.html">Autocomplete <span class="fa fa-search-plus"></span></a></li>
                <li><a href="ui-slide-menu.html">Slide Menu</a> <span class="fa fa-angle-right"></span></li>                            
            </ul>
        </li>                    
        <li class="xn-openable">
            <a href="#"><span class="xn-text">Forms</span> <span class="fa fa-pencil"></span></a>
            <ul>
                <li class="xn-openable">
                    <a href="form-layouts-two-column.html">Form Layouts <span class="fa fa-tasks"></span></a>
                    <ul>
                        <li><a href="form-layouts-one-column.html">One Column <span class="fa fa-align-justify"></span></a></li>
                        <li><a href="form-layouts-two-column.html">Two Column <span class="fa fa-th-large"></span></a></li>
                        <li><a href="form-layouts-tabbed.html">Tabbed <span class="fa fa-table"></span></a></li>
                        <li><a href="form-layouts-separated.html">Separated Rows <span class="fa fa-th-list"></span></a></li>
                    </ul> 
                </li>
                <li><a href="form-elements.html">Elements <span class="fa fa-file-text-o"></span></a></li>
                <li><a href="form-validation.html">Validation <span class="fa fa-list-alt"></span></a></li>
                <li><a href="form-wizards.html">Wizards <span class="fa fa-arrow-right"></span></a></li>
                <li><a href="form-editors.html">WYSIWYG Editors <span class="fa fa-text-width"></span></a></li>
                <li><a href="form-file-handling.html">File Handling <span class="fa fa-floppy-o"></span></a></li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="tables.html"><span class="xn-text">Tables</span> <span class="fa fa-table"></span></a>
            <ul>                            
                <li><a href="table-basic.html">Basic <span class="fa fa-align-justify"></span></a></li>
                <li><a href="table-datatables.html">Data Tables <span class="fa fa-sort-alpha-desc"></span></a></li>
                <li><a href="table-export.html">Export Tables <span class="fa fa-download"></span></a></li>                            
            </ul>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="xn-text">Charts</span> <span class="fa fa-bar-chart-o"></span> </a>
            <ul>
                <li><a href="charts-morris.html">Morris</a></li>
                <li><a href="charts-nvd3.html">NVD3</a></li>
                <li><a href="charts-rickshaw.html">Rickshaw</a></li>
                <li><a href="charts-other.html">Other</a></li>
            </ul>
        </li>                  
        <li>
            <a href="maps.html"><span class="xn-text">Maps</span> <span class="fa fa-map-marker"></span></a>
        </li>                    
        <li class="xn-openable">
            <a href="#"><span class="xn-text">Navigation Levels</span> <span class="fa fa-sitemap"></span></a>
            <ul>                            
                <li class="xn-openable">
                    <a href="#">Second Level</a>
                    <ul>
                        <li class="xn-openable">
                            <a href="#">Third Level</a>
                            <ul>
                                <li class="xn-openable">
                                    <a href="#">Fourth Level</a>
                                    <ul>
                                        <li><a href="#">Fifth Level</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>                            
            </ul>
        </li>
        -->
    </ul>
    <!-- END X-NAVIGATION -->
</div>