@extends('layouts.admin')

@section('title', 'پنل مدیریت')

@section('content')
<!--
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                Add class <code>.page-mode-rtl .page-content-rtl</code> to <code>.page-container</code> to set right direction for navigation and RTL content mode. And of course use structure described below.
            </div>                            
        </div>
    </div>                
    -->
    <!-- START WIDGETS -->   
    <div class="row">
        <div class="col-md-3">
            
            <!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel">
                <div class="owl-carousel" id="owl-example">
                    <div>                                    
                        <div class="widget-title">Total Visitors</div>                                                                        
                        <div class="widget-subtitle">27/08/2015 15:23</div>
                        <div class="widget-int">3,548</div>
                    </div>
                    <div>                                    
                        <div class="widget-title">Returned</div>
                        <div class="widget-subtitle">Visitors</div>
                        <div class="widget-int">1,695</div>
                    </div>
                    <div>                                    
                        <div class="widget-title">New</div>
                        <div class="widget-subtitle">Visitors</div>
                        <div class="widget-int">1,977</div>
                    </div>
                </div>                            
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>                             
            </div>         
            <!-- END WIDGET SLIDER -->
            
        </div>
        <div class="col-md-3">
            
            <!-- START WIDGET MESSAGES -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-messages.html';">
                <div class="widget-item-right">
                    <span class="fa fa-envelope"></span>
                </div>                             
                <div class="widget-data-left">
                    <div class="widget-int num-count">48</div>
                    <div class="widget-title">New messages</div>
                    <div class="widget-subtitle">In your mailbox</div>
                </div>      
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-left widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>
            </div>                            
            <!-- END WIDGET MESSAGES -->
            
        </div>
        <div class="col-md-3">
            
            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon" onclick="location.href='pages-address-book.html';">
                <div class="widget-item-right">
                    <span class="fa fa-user"></span>
                </div>
                <div class="widget-data-left">
                    <div class="widget-int num-count">375</div>
                    <div class="widget-title">Registred users</div>
                    <div class="widget-subtitle">On your website</div>
                </div>
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-left widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>                            
            </div>                            
            <!-- END WIDGET REGISTRED -->
            
        </div>
        <div class="col-md-3">
            
            <!-- START WIDGET CLOCK -->
            <div class="widget widget-danger widget-padding-sm">
                <div class="widget-big-int plugin-clock">00:00</div>                            
                <div class="widget-subtitle plugin-date">Loading...</div>
                <div class="widget-controls">                                
                    <a href="#" class="widget-control-left widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                </div>                            
                <div class="widget-buttons widget-c3">
                    <div class="col">
                        <a href="#"><span class="fa fa-clock-o"></span></a>
                    </div>
                    <div class="col">
                        <a href="#"><span class="fa fa-bell"></span></a>
                    </div>
                    <div class="col">
                        <a href="#"><span class="fa fa-calendar"></span></a>
                    </div>
                </div>                            
            </div>                        
            <!-- END WIDGET CLOCK -->
            
        </div>
    </div>
    <!-- END WIDGETS -->
    
    
    
<!--    <div class="row">
        <div class="col-md-4">
             START PANEL WITH STATIC CONTROLS 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Panel with static controls</h3>
                    <ul class="panel-controls">
                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                            
                            <ul class="dropdown-menu">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span> Refresh</a></li>
                            </ul>                                        
                        </li>
                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <p>Controls always available.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque mauris elit, faucibus non metus ac, blandit tempor tortor. Sed placerat ante nunc, sit amet aliquam urna porttitor vitae. Ut efficitur tortor ac leo malesuada rutrum et sed ligula. Aenean lorem libero, aliquam eu tortor non, semper bibendum nunc. Curabitur vel lectus at leo vehicula laoreet. Duis consectetur nibh et metus varius, eget vestibulum mi pharetra. </p>
                </div>      
                <div class="panel-footer">
                    <button class="btn btn-primary pull-right">Button</button>
                </div>                            
            </div>
             END PANEL WITH STATIC CONTROLS 
        </div>
        <div class="col-md-4">

             CONTACTS WITH CONTROLS 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Contacts With Controls</h3>         
                </div>
                <div class="panel-body list-group list-group-contacts">                                
                    <a href="#" class="list-group-item">                
                        <div class="list-group-status status-online"></div>
                        <img src="assets/images/users/user3.jpg" class="pull-right" alt="Nadia Ali">
                        <span class="contacts-title">Nadia Ali</span>
                        <p>Singer-Songwriter</p>                                    
                        <div class="list-group-controls">
                            <button class="btn btn-primary btn-rounded"><span class="fa fa-pencil"></span></button>
                        </div>                                    
                    </a>                                                                
                    <a href="#" class="list-group-item">                   
                        <div class="list-group-status status-away"></div>
                        <img src="assets/images/users/user.jpg" class="pull-right" alt="Dmitry Ivaniuk">
                        <span class="contacts-title">Dmitry Ivaniuk</span>
                        <p>Web Developer/Designer</p>                                    
                        <div class="list-group-controls">
                            <button class="btn btn-primary btn-rounded"><span class="fa fa-pencil"></span></button>
                        </div>                                    
                    </a>
                    <a href="#" class="list-group-item">                   
                        <div class="list-group-status status-offline"></div>
                        <img src="assets/images/users/user2.jpg" class="pull-right" alt="John Doe">
                        <span class="contacts-title">John Doe</span>
                        <p>UI/UX Designer</p>                     
                        <div class="list-group-controls">
                            <button class="btn btn-primary btn-rounded"><span class="fa fa-pencil"></span></button>
                        </div>
                    </a>                                
                </div>
            </div>
             END CONTACTS WITH CONTROLS 

        </div>
        <div class="col-md-4">
            
             START TAGS LIST 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tags List</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-tags">
                        <li><a href="#"><span class="fa fa-tag"></span> amet</a></li>
                        <li><a href="#"><span class="fa fa-tag"></span> rutrum</a></li>
                        <li><a href="#"><span class="fa fa-tag"></span> nunc</a></li>
                        <li><a href="#"><span class="fa fa-tag"></span> tempor</a></li>
                        <li><a href="#"><span class="fa fa-tag"></span> eros</a></li>
                        <li><a href="#"><span class="fa fa-tag"></span> suspendisse</a></li>
                        <li><a href="#"><span class="fa fa-tag"></span> dolor</a></li>
                    </ul>
                </div>
            </div>
             END TAGS LIST 
            
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">

            <h4>Default Messages</h4>                               
            <div class="messages">
                <div class="item item-visible">
                    <div class="text">
                        <div class="heading">
                            <a href="#">John Doe</a>
                            <span class="date">08:33</span>
                        </div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed facilisis suscipit eros vitae iaculis.
                    </div>
                </div>
                <div class="item item-visible">
                    <div class="text">
                        <div class="heading">
                            <a href="#">Dmitry Ivaniuk</a>
                            <span class="date">08:27</span>
                        </div>                                    
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed facilisis suscipit eros vitae iaculis.
                    </div>
                </div>
            </div>                        

        </div>
        <div class="col-md-6">

            <h4>Incoming Messages</h4>                               
            <div class="messages messages-img">
                <div class="item in item-visible">
                    <div class="image">
                        <img src="assets/images/users/user2.jpg" alt="John Doe">
                    </div>
                    <div class="text">
                        <div class="heading">
                            <a href="#">John Doe</a>
                            <span class="date">08:33</span>
                        </div>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed facilisis suscipit eros vitae iaculis.
                    </div>
                </div>
                <div class="item item-visible">
                    <div class="image">
                        <img src="assets/images/users/user.jpg" alt="Dmitry Ivaniuk">
                    </div>                                
                    <div class="text">
                        <div class="heading">
                            <a href="#">Dmitry Ivaniuk</a>
                            <span class="date">08:27</span>
                        </div>                                    
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed facilisis suscipit eros vitae iaculis.
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            
            <form class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Form</strong> Layout</h3>
                    <ul class="panel-controls">
                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <p>This is non libero bibendum, scelerisque arcu id, placerat nunc. Integer ullamcorper rutrum dui eget porta. Fusce enim dui, pulvinar a augue nec, dapibus hendrerit mauris. Praesent efficitur, elit non convallis faucibus, enim sapien suscipit mi, sit amet fringilla felis arcu id sem. Phasellus semper felis in odio convallis, et venenatis nisl posuere. Morbi non aliquet magna, a consectetur risus. Vivamus quis tellus eros. Nulla sagittis nisi sit amet orci consectetur laoreet. Vivamus volutpat erat ac vulputate laoreet. Phasellus eu ipsum massa.</p>
                </div>
                <div class="panel-body">                                                                        
                    
                    <div class="form-group">        
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-xs-12">                                            
                            <div class="input-group">                                                
                                <input type="text" class="form-control"/>
                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            </div>                                            
                            <span class="help-block">This is sample of text field</span>
                        </div>
                        <label class="col-md-3 col-xs-12 control-label">Text Field</label>
                    </div>
                    
                    <div class="form-group">                                                                                
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-xs-12">
                            <div class="input-group">                                                
                                <input type="password" class="form-control"/>
                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                            </div>            
                            <span class="help-block">Password field sample</span>
                        </div>
                        <label class="col-md-3 col-xs-12 control-label">Password</label>
                    </div>
                                                       
                    <div class="form-group">        
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-xs-12">                                            
                            <textarea class="form-control" rows="5"></textarea>
                            <span class="help-block">Default textarea field</span>
                        </div>
                        <label class="col-md-3 col-xs-12 control-label">Textarea</label>
                    </div>
                                                        
                </div>
                <div class="panel-footer">
                    <button class="btn btn-default pull-right">Clear Form</button>                                    
                    <button class="btn btn-primary pull-left">Submit</button>
                </div>
            </div>
            </form>
            
        </div>
    </div>
    
    <div class="row">
        
        <div class="col-md-6">
             START BASIC TABLE SAMPLE 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Basic example</h3>
                </div>
                <div class="panel-body">
                    <p>Add <code>.table</code> to table to get default table</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             END BASIC TABLE SAMPLE 
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">List Group</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group border-bottom">                                        
                        <li class="list-group-item">Mauris placerat justo ut augue<span class="badge badge-danger">8</span></li>
                        <li class="list-group-item">Donec ac venenatis elit<span class="badge badge-info">7</span></li>
                        <li class="list-group-item">Maecenas mauris diam<span class="badge badge-success">25</span></li>
                        <li class="list-group-item">Curabitur porttitor massa justo<span class="badge badge-warning">58</span></li>
                    </ul>                                
                </div>
            </div>                            
        </div>
    </div>-->
@stop