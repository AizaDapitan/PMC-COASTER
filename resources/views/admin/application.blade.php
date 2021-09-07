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
    <form id="form" role="form" action="{{ route('admin.application.store') }}" method="POST">
      @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>          
        </div>
        <div class="modal-body">
            <div class="modal-header">
                <h4 class="modal-title" id="titleLabel" name="titleLabel"></h4>
            </div>          

           <input type="hidden" name="_method" id="method" value="POST">
           <input type="hidden" name="id" id="id" value="">     

           <div class="modal-body">
              <div class="form-body">

                  <div class="form-group">
                        <label class="control-label">Date</label><i class="font-red"> *</i>
                        <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                            <input required type="date" name="scheduled_date" id="scheduled_date" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>                                             
                  </div>              

                  <div class="form-group">
                      <label class="control-label">Time</label><i class="font-red"> *</i>
                      <input required type="time" name="scheduled_time" class="form-control" id="scheduled_time">
                  </div>

                  <div class="form-group last">
                      <label class="control-label">Reason</label><i class="font-red"> *</i>
                      <textarea required type="text" placeholder="Reason" name="reason" id="reason" class="form-control"></textarea>
                  </div>
              </div>
           </div>
           <div class="modal-footer">
              <button type="button" class="btn default" data-dismiss="modal">Close</button>
              <input type="submit" class="btn blue" value="Save">
           </div>           
          
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
                  <li class="active">Scheduled Shutdown List</li>
              </ol>

              <h1>Scheduled Shutdown List</h1>
          </div>
          @if(session('down'))
                <div id="errdiv" class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <span class="fa fa-exclamation"></span>                
                    {!! session('down') !!}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <span class="fa fa-check-square-o"></span>
                    {!! session('success') !!}
                </div>
            @endif
          <form method="POST" action="{{ route('admin.application.search') }}" class="mb-5">
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
                      <a class="btn green" data-toggle="modal" href="#basic" onclick="addSchedule()"> Create a Scheduled Shutdown </a>
                    @else
                      <input disabled class="btn green"  type="submit" value="Create a Scheduled Shutdown">
                    @endif
                  </td>
              </tr>
            </table>
          </form>

          <div class="table-toolbar">
              <div class="row">
                  <div class="col-md-12" style="direction:rtl;">
                      <div class="btn-group">
                          <a onclick="return confirm('Are you sure you want to run reindexing?')" href="{{ route('admin.application.create_indexing') }}" class="btn sbold green"> Reindex Application Database</a>                                                    
                      </div>
                      <div class="btn-group">
                          <a onclick="return confirm('Are you sure you want to start application?')" href="{{ route('admin.application.systemUp') }}" class="btn sbold blue"> Start</a>                                                    
                      </div>
                      <div class="btn-group">
                          <a onclick="return confirm('Are you sure you want to stop application?')" href="{{ route('admin.application.systemDown') }}" class="btn sbold red"> Stop</a>                                                    
                      </div>
                  </div>
              </div>
          </div>          

          <br>
          <table style="58%"  class="table table-striped table-hover" id="sample_1">
            <thead>             
              <tr>
                    <th>Scheduled Date</th>
                    <th>Scheduled Time</th>
                    <th>Reason</th>
                    <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($applications as $application)
              <tr>                              
                <td>{{$application['scheduled_date']}}</td>
                <td>{{$application['scheduled_time']}}</td>
                <td>{{$application['reason']}}</td>
                <td class="text-center">
                    @if($edit)
                        <a onclick="getApplicationDetails({!! $application['id'] !!})" data-toggle="modal" data-target="#basic"  class="btn btn-sm blue btn-outline filter-submit margin-bottom"><i class="fa fa-edit"></i> Edit</a>
                    @else
                        <a class="btn btn-circle grey"><i class="fa fa-edit"></i> Edit</a>
                    @endif
                    @if($edit)
                    <a data-toggle="modal"  class="btn btn-sm red btn-outline filter-submit margin-bottom" href="#remove{{ $application['id' ]}}"><span class="fa fa-trash-o"></span> Remove</a>
                    @else
                    <a class="btn btn-circle grey"><span class="fa fa-trash-o"></span> Remove</a>
                    @endif
                </td>               

              </tr>
            @endforeach
        
            <tbody>  
          </table>  
              
        </div>     
    </div>
  </div>

@foreach($applications as $application)
<div class="modal fade" id="remove{{ $application['id'] }}" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.application.destroy', $application['id']) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><b>Confirmation</b></h4>
                </div>
                <div class="modal-body"> Are you sure you want to <b>Remove</b> this schedule? </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" name="remove" class="btn btn-circle red"><span class="fa fa-trash"></span> Remove</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
    
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
		$(document).ready(function(){                
                    
      });

      function addSchedule() {
                        
        $("#titleLabel").text(" Create a Scheduled Shutdown");                        
        $('#id').val('');
        $('#scheduled_date').val('');
        $('#scheduled_time').val('');
        $('#reason').val('');

        $('#method').val('POST');
        $('#form').attr('action', '{{ route('admin.application.store') }}');
    }

		function getApplicationDetails(id) {
			$.ajax({
                url: '{!! route('admin.application.edit') !!}',
                type: 'POST',
                async: false,
                dataType: 'json',
                data:{
                    _token: '{!! csrf_token() !!}',
                    id: id
                },
                success: function(response){
                    $('#cancel').show();

                    $("#titleLabel").text(" Update a Scheduled Shutdown");
            
                    $('#scheduled_date').val(response.scheduled_date);
                    $('#scheduled_time').val(response.scheduled_time.replace(':00.0000000',''));                
                    $('#reason').val(response.reason);
                                    
                    $('#id').val(id);                
                    $('#method').val('PUT');
                    $('#form').attr('action', '{{ route('admin.application.update') }}');
                    $('#submit').html('<span class="glyphicon glyphicon-edit"></span> Update');
                }
            });
		}

        function systemDown(id) {
        $.ajax({
            url: '{!! route('admin.application.systemDown') !!}',
            type: 'POST',
            async: false,
            success: function(response) {
               
            }
        });
    }
            
	</script>

@endsection