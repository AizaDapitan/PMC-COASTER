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
      
    <form id="form" role="form" action="{{ route('admin.employees.store') }}" method="POST">

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
          <button type="submit" class="btn blue" id="saveEmployeeListing">
              <i class="fa fa-save"></i>&nbsp; Save Changes
          </button>          

          <!-- <input type="submit" class="btn blue" value="Save"> -->
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

          <div class="breadcrumbs">              
              <ol class="breadcrumb">
                  <li><a href="{{ url('/admin/booking') }}">Home</a></li>
                  <li class="active">Employee Listing</li>
              </ol>

              <h1>Employee Listing</h1>
              
          </div>        

          @if (count($errors) > 0)
          <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
              <ul class="nav">
                  @foreach ($errors->all() as $error)
                  <li><span class="fa fa-exclamation"></span>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif

          @if(session('success'))
          <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
              <span class="fa fa-check-square-o"></span>
              {!! session('success') !!}
          </div>
          @endif
          @if(session('failed'))
          <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
              <span class="a fa-exclamation"></span>
              {!! session('failed') !!}
          </div>
          @endif          

          <form method="POST" action="{{ route('admin.employees.search') }}" class="mb-5">

            @csrf
            <table width="50%">
              <tr>
                <td><h3>Search:</h3></td>
                <td><input type="text" name="q" class="form-control"></td>
                <td>
                  @if($search)
                    <input class="btn blue" type="submit" value="Go">
                  @else
                    <input disabled class="btn blue" type="submit" value="Go">
                  @endif
                  @if($create)
                    <a class="btn green" data-toggle="modal" href="#basic" onclick="addEmployee()"> Add New </a>
                  @else
                    <input disabled class="btn green" type="submit" value="Add New">
                  @endif
                  </td>
              </tr>
            </table>
          </form>
          @if($pagination)
          <div class="pull-right">
            {!! $employees->previousPageUrl() ? '<a href='. $employees->previousPageUrl().'>Previous Page</a>'  : '' !!}
            {!! $employees->nextPageUrl() ? '&nbsp;&nbsp;<a href='. $employees->nextPageUrl().'>Next Page</a>'  : ''!!}
          </div>
          @endif          

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
                <!-- @if($edit) -->
                  {{-- Start of Priorities --}}
                  @if($emp->priorities)
                  <form style="display: inline" method ="POST"  action="{{ route('admin.employees.destroy_priorities', $emp->priorities['id']) }}">
                   @method('DELETE')
                      @csrf
                      <button class="btn green btn-sm" type="submit">Remove Priority</button>
                    </form>
                  @else
                    <form style="display: inline" action="{{ route('admin.employees.priorities', $emp['empId']) }}" method="POST">
                      @method('PUT')
                      @csrf
                      <input type="hidden" name="id" value="{{ $emp->empId }}">
                      <button class="btn green btn-sm" type="submit">Priority</button>
                    </form>
                  @endif
                  {{-- End of Priorities --}}
                  {{-- Start of Blacklist --}}
                  @if($emp->blacklists)
                    <!-- <form style="display: inline" method ="POST" action="/admin/blacklist/{{ $emp->blacklists['id'] }}"> -->
                    <form style="display: inline" method ="POST"  action="{{ route('admin.employees.destroy_blacklists', $emp->blacklists['id']) }}">
                      @method('DELETE')
                      @csrf
                      <button class="btn red btn-sm" type="submit">Remove Blacklist</button>
                    </form>
                  @else
                    <form style="display: inline" action="{{ route('admin.employees.blacklists', $emp['empId']) }}" method="POST">
                      @method('PUT')
                      @csrf
                      <input type="hidden" name="id" value="{{ $emp->empId }}">
                      <button class="btn red btn-sm" type="submit">Blacklist</button>
                    </form>
                  @endif
                  {{-- End of Blacklist --}}
                  @if($emp->isNotActive)
                  <form style="display: inline" action="{{ route('admin.employees.activate', $emp['empId']) }}" method="POST">
                      @method('PUT')
                      @csrf
                      <button class="btn purple btn-sm" type="submit">Activate</button>
                    </form>
                  @else
                    <!-- <form style="display: inline" method ="POST" action="/admin/employees/{{ $emp->empId }}/activate"> -->
                  <form style="display: inline" action="{{ route('admin.employees.deactivate', $emp['empId']) }}" method="POST">
                      @method('PUT')
                      @csrf
                      <button class="btn purple btn-sm" type="submit">Deactivate</button>
                    </form>
                  @endif

                  
                <!-- @endif -->
                </td> 
              </tr>
            @endforeach
        
            <tbody>  
          </table>  
          @if($pagination)
          <div class="pull-right">
            {{ $employees->links() }}   
          </div>
          @endif
              
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

@if( session()->has('booking'))
<script type="text/javascript">
    var empId = "{!! session()->get('booking') !!}";
    {{ session()->forget('booking') }}
    if(confirm('Deactivating this employee would also delete his/her existing booking, would you like to proceed?')) {
        jQuery.ajax({
          method: "PUT",
          data: {
            id: empId ,
            deleteBooking: true
          },
          url: "{{ env('APP_URL')}}/admin/employees/'+empId+'/deactivate",
        }).done(function(data){
            console.log(data);
        });
    }
</script>
@endif

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

        function addEmployee() {
          
          $('#id').val('');
          $('#name').val('');
          $('#method').val('POST');
          $('#form').attr('action', '{{ route('admin.employees.store') }}');
      }

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

