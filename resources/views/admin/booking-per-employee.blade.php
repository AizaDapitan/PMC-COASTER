@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')


@endsection
@section('content')

  @include('layouts.header')

  <div class="main">
    <div class="container">
     
      <br><br>
   
      
      <div class="row margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12 col-sm-12">           
          <div class="content-page">
               <h1>Booking per Employee</h1>
          </div>
        </div>
        <!-- END CONTENT -->
      </div>
      <!-- END SIDEBAR & CONTENT -->
    </div>
  </div>
  
@endsection

@section('pagejs')
    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="{{ asset('theme/metronic/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->

    <script src="{{ asset('theme/metronic/assets/frontend/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();  
            jQuery(".gwapo").css('cursor','url(pinakagwapo.PNG),auto');
            jQuery(".gwapo").css('cursor','url(pinakagwapo.PNG),auto');
            $('#topcontrol').hide();    
        });
        function tag_absent(a,b,c){
           $.ajax({
            method: "POST",
            url: "ajax.php?act=tag_absent",
            data: { isAbsent: a, day: b,seat: c }
          })
            .done(function( html ) {
              
            });
        }
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection

