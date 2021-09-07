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
  <!-- <link href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css" rel="stylesheet"> -->

  <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  @yield('pagecss')
  <style>
    .nav-tabs>li {
      float: none;
      display: inline-block;
      zoom: 1;
    }

    .nav-tabs {
      text-align: center;
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


  <!-- DataTable -->
  <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script> -->

  <!-- <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js" type="text/javascript"></script> -->


  <script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
  <script src="{{ url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
  <!-- <script src="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script> -->
  <!-- END PAGE LEVEL PLUGINS --> 
  <script src="{{ url('assets/global/scripts/table-datatables-buttons.js') }}" type="text/javascript"></script>

  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  @yield('pagejs')
  <script>
    // $(document).ready(function() {
    //     $('#tableID').DataTable({
    //         dom: "Blfrtip",
    //         buttons: [
    //             {
    //                 text: 'csv',
    //                 extend: 'csvHtml5',
    //                 exportOptions: {
    //                     columns: ':visible:not(.not-export-col)'
    //                 }
    //             },
    //             {
    //                 text: 'excel',
    //                 extend: 'excelHtml5',
    //                 exportOptions: {
    //                     columns: ':visible:not(.not-export-col)'
    //                 }
    //             },
    //             {
    //                 text: 'pdf',
    //                 extend: 'pdfHtml5',
    //                 exportOptions: {
    //                     columns: ':visible:not(.not-export-col)'
    //                 }
    //             },
    //             {
    //                 text: 'print',
    //                 extend: 'print',
    //                 exportOptions: {
    //                     columns: ':visible:not(.not-export-col)'
    //                 }
    //             },

    //         ],
    //         columnDefs: [{
    //             orderable: true,
    //             targets: -1
    //         }] 
    //     });
    // });
    // $(document).ready(function() {
    //   $('#tableID').DataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //       'copy', 'csv', 'excel', 'pdf', 'print'
    //     ]
    //   });
    // });
  </script>
</body>
<!-- END BODY -->

</html>