@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')

  <!-- Theme styles START -->
  <link href="google.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('theme/metronic/assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css') }}"/>
  
  <!-- Theme styles END -->

@endsection
@section('content')

  @include('layouts.header')

  <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <form method="post" action="/admin/employees">
      @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Add New Employee</h4>
        </div>
        <div class="modal-body">
           <table>
              <tr >
                <td style="padding-bottom: 10px;">Fullname:</td>
                <td style="padding-bottom: 10px; padding-left: 10px;"><input type="text" class="form-control" name="name" placeholder="First MI. Last" required></td>
              </tr>
              
              <tr>
                <td>Expiration Date:</td>
                 <td style="padding-left: 10px;"><div class="input-group date date-picker margin-bottom-5 col-md-8 pl-3" style="width:60%" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control form-filter" readonly name="expireDate" value="<?php echo date('Y-m-d');?>" required>
                        <span class="input-group-btn">
                        <button class="btn  default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                      </div></td>
              </tr>
           </table>
           

        </div>
        <div class="modal-footer">
          <button type="button" class="btn default" data-dismiss="modal">Close</button>
          <input type="submit" class="btn blue" value="Save">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </form>
  </div>

  <div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">
          <form method="POST" action="/admin/employees/search" class="mb-5">
            @csrf
            <table width="50%">
              <tr>
                <td><h3>Search:</h3></td>
                <td><input type="text" name="q" class="form-control"></td>
                <td><input class="btn blue" type="submit" value="Go">&nbsp;&nbsp;&nbsp;<a class="btn green" data-toggle="modal" href="#basic"> Add New </a></td>
              </tr>
            </table>
          </form>
          <div class="pull-right">
            {!! $employees->previousPageUrl() ? '<a href='. $employees->previousPageUrl().'>Previous Page</a>'  : '' !!}
            {!! $employees->nextPageUrl() ? '&nbsp;&nbsp;<a href='. $employees->nextPageUrl().'>Next Page</a>'  : ''!!}
          </div>

          <table class="table mx-auto">
            <thead>             
              <tr>
                  <th>ID</th>
                  <th>Dept</th>
                  <th>Name</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $emp)
              <tr>
                <td>{{ $emp->empId }}</td>
                <td>{{ ucfirst($emp->dept) }}</td>
                <td>{{ $emp->name }}</td>
                <td style="width: 350px">
                  {{-- Start of Blacklist --}}
                  @if($emp->priorities)
                  <form style="display: inline" method ="POST" action="/admin/priority/{{ $emp->priorities['id'] }}">
                    @method('DELETE')
                    @csrf
                    <button class="btn green btn-sm" type="submit">Remove Priority</button>
                  </form>
                  @else
                    <form style="display: inline" method ="POST" action="/admin/priority">
                      @csrf
                      <input type="hidden" name="id" value="{{ $emp->id }}">
                      <button class="btn green btn-sm" type="submit">Priority</button>
                    </form>
                  @endif

                  {{-- Start of Blacklist --}}
                  @if($emp->blacklists)
                    <form style="display: inline" method ="POST" action="/admin/blacklist/{{ $emp->blacklists['id'] }}">
                      @method('DELETE')
                      @csrf
                      <button class="btn red btn-sm" type="submit">Remove Blacklist</button>
                    </form>
                  @else
                    <form style="display: inline" method ="POST" action="/admin/blacklist">
                      @csrf
                      <input type="hidden" name="id" value="{{ $emp->id }}">
                      <button class="btn red btn-sm" type="submit">Blacklist</button>
                    </form>
                  @endif
                  {{-- End of Blacklist --}}

                  <form style="display: inline" method ="POST" action="/admin/employee/{{ $emp->id }}">
                    @method('PUT')
                    @csrf
                    <button class="btn purple btn-sm" type="submit">Deactivate</button>
                  </form>
                </td> 
              </tr>
            @endforeach
        
            <tbody>  
          </table>  
          <div class="pull-right">
            {{ $employees->links() }}   
          </div>
              
        </div>     
    </div>
  </div>
    
@endsection

@section('pagejs')
<script src="{{ asset('theme/metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

<script src="{{ asset('theme/metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/metronic/assets/admin/pages/scripts/components-pickers.js') }}"></script>
    <script>
        var initPickers = function () {
                //init date pickers
                $('.date-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    autoclose: true,
                    startDate: new Date()
                });
            }
            initPickers();
    </script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
              Metronic.init();
              Layout.init();   
              QuickSidebar.init() // init quick sidebar
              ComponentsPickers.init();
              jQuery(".gwapo").css('cursor','url(pinakagwapo.PNG),auto');
              jQuery(".gwapo").css('cursor','url(pinakagwapo.PNG),auto');
              $('#topcontrol').hide();    
                   });

    </script>
@endsection

