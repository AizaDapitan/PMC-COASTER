<!DOCTYPE html>
<html lang="en">
<!-- Head BEGIN -->
<head>
    <meta charset="utf-8">
    <title>Booking System</title>
  
    {{-- <link rel="shortcut icon" href="favicon.ico"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Global styles START -->          
    <link href="{{ asset('theme/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Global styles END --> 
     
    <!-- Page level plugin styles START -->
    <link href="{{ asset('theme/metronic/assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet">
    <!-- Page level plugin styles END -->
  
    <!-- Theme styles START -->
    <link href="{{ asset('theme/metronic/assets/global/css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/metronic/assets/frontend/layout/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/metronic/assets/frontend/layout/css/style-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/metronic/assets/frontend/layout/css/themes/red.css') }}" rel="stylesheet" id="style-color">
    <link href="{{ asset('theme/metronic/assets/frontend/layout/css/custom.css') }}" rel="stylesheet">

    @yield('pagecss')
    <style>
      .nav-tabs > li {
      float:none;
      display:inline-block;
      zoom:1;
      }
  
      .nav-tabs {
          text-align:center;
      }
      .footer {
          position: fixed;
          height: 50px;
          bottom: 0;
          width: 100%;
      }
    </style>
  </head>
  <!-- Head END -->
  
  <!-- Body BEGIN -->
  <body class="@yield('pageBodyClass')">
      
    
    @if(!Request::is('login') && !Request::is('monday') && !Request::is('saturday'))
        @include('layouts.pre-header')
    @endif

    @yield('content')

    @if(!Request::is('login') && !Request::is('monday') && !Request::is('saturday'))
        @include('layouts.footer')
    @endif
  
      <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
      <script src="{{ asset('theme/metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('theme/metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('theme/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>      
      <script src="{{ asset('theme/metronic/assets/frontend/layout/scripts/back-to-top.js') }}" type="text/javascript"></script>
      <!-- END CORE PLUGINS -->
  
      <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      </script>
      @yield('pagejs')
  </body>
  <!-- END BODY -->
</html>