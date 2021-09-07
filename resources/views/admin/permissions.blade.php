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
    <form id="form" role="form" action="{{ route('admin.permissions.store') }}" method="POST">
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
                      <label class="control-label">Status</label>
                      <input type="checkbox" name="active" id="active">
                  </div>              

                  <div class="form-group">                      
                      <label class="control-label">Module <span class="required" aria-required="true"> * </span></label>
                        <select required name="module_type" id="module_type" class="form-control"> 
                            @foreach($modules as $module)
                                <option value="{{ $module['description'] }}">{{ $module['description'] }}</option>
                            @endforeach
                        </select>
                  </div>

                  <div class="form-group last">
                      <label class="control-label">Description <span class="required" aria-required="true"> * </span></label>
                      <input type="text" class="form-control" id="description" name="description" placeholder="Description" required>
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
                  <li class="active">Permission</li>
              </ol>

              <h1>Permission</h1>
          </div>

          <form method="POST" action="{{ route('admin.permissions.search') }}" class="mb-5">
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
                    <a class="btn green" data-toggle="modal" href="#basic" onclick="addPermission()"> Create a Permission </a>
                  @else
                    <input disabled class="btn green" type="submit" value="Create a Permission" >
                  @endif
                
                </td>
                
              </tr>
            </table>
          </form>
          <div class="pull-right">
            {!! $permissions->previousPageUrl() ? '<a href='. $permissions->previousPageUrl().'>Previous Page</a>'  : '' !!}
            {!! $permissions->nextPageUrl() ? '&nbsp;&nbsp;<a href='. $permissions->nextPageUrl().'>Next Page</a>'  : ''!!}
          </div>

          <table class="table mx-auto">
            <thead>             
              <tr>
                  <th>Module</th>
                  <th>Descrtiption</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permissions as $permission)
              <tr>                              
                <td>{{ strtoupper($permission['module_type']) }}</td>
                <td>{{ ($permission->description) }}</td>                
                <td> 
                    @if($permission->active)
                    <i class="font-blue"> Active</i>
                    @else
                    <i class="font-red"> Inactive</i>
                    @endif
                </td>
                
                <td class="text-center">  
                  @if($edit)                  
                    <button onclick="getPermissionDetails({!! $permission['id'] !!})" class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                    <i class="fa fa-edit"></i> Edit</button>
                  @else
                    <button disabled class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                    <i class="fa fa-edit"></i> Edit</button>
                  @endif

                  <!-- <button href="#remove{{ $permission['id' ]}}" class="btn btn-sm red btn-outline filter-submit margin-bottom" data-toggle="modal">
                  <i class="fa fa-edit"></i> Remove</button> -->

                </td>                

              </tr>
            @endforeach
        
            <tbody>  
          </table>  
          <div class="pull-right">
            {{ $permissions->links() }}   
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


    @foreach($permissions as $permission)
    <div class="modal fade" id="remove{{ $permission['id'] }}" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">

                <form action="{{ route('admin.permissions.destroy', $permission['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title"><b>Confirmation</b></h4>
                        </div>
                        <div class="modal-body"> 
                            
                        </br>
                        Are you sure you want to <b>Remove</b> this Permission? </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="submit" name="remove" class="btn btn-circle red"><span class="fa fa-trash"></span> Remove</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

	<script>
		$(document).ready(function(){
            document.getElementById('active').checked = true;
      });

      function addPermission() {

        $("#titleLabel").text(" Create a Permission");
        $('#id').val('');
        $('#module_type').val('');
        $('#description').val('');
        $('#method').val('POST');
        $('#form').attr('action', '{{ route('admin.permissions.store') }}');
    }

		function getPermissionDetails(id) {
			$.ajax({
                url: '{!! route('admin.permissions.edit') !!}',
                type: 'POST',
                async: false,
                dataType: 'json',
                data:{
                    _token: '{!! csrf_token() !!}',
                    id: id
                },
                success: function(response){
                    $('#cancel').show();
                    if (response.active == "1"){
                        
                    document.getElementById('active').checked = true;
                    }
                    else
                    {
                    document.getElementById('active').checked = false;
                    }

                    $("#titleLabel").text(" Update a Permission");
                    $('#module_type').val(response.module_type);
                    $('#id').val(id);
                    $('#description').val(response.description);                    
                    $('#method').val('PUT');
                    $('#form').attr('action', '{{ route('admin.permissions.update') }}');
                    $('#submit').html('<span class="glyphicon glyphicon-edit"></span> Update');
                }
            });
		}
	</script>
@endsection
