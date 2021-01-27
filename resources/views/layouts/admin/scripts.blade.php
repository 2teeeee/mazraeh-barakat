<!-- START PLUGINS -->
<script type="text/javascript" src="{{ asset('admin/js/plugins/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/jquery/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/bootstrap/bootstrap.min.js') }}"></script>        
<!-- END PLUGINS -->

<!-- THIS PAGE PLUGINS -->
<script type='text/javascript' src="{{ asset('admin/js/plugins/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
       
        <script type="text/javascript" src="{{ asset('admin/js/plugins/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/owl/owl.carousel.min.js') }}"></script>
<!-- END PAGE PLUGINS -->        

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{ asset('admin/js/plugins.js') }}"></script>        
<script type="text/javascript" src="{{ asset('admin/js/actions.js') }}"></script>        
<!-- END TEMPLATE -->
<script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>



<script src="{{ asset('main/datepicker/persiandate.js') }}" type="text/javascript"></script>
<script src="{{ asset('main/datepicker/persiandatepicker.js') }}" type="text/javascript"></script>
    
<script>
    $('.date').persianDatepicker({
         format: 'YYYY/MM/DD',
         initialValue: false
    });    
</script>