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
    <form id="form" role="form" action="{{ route('admin.roles.store') }}" method="POST">
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
                      <label class="control-label">Name <span class="required" aria-required="true"> * </span></label>
                      <input type="text" class="form-control" id="role" name="role" placeholder="Role" maxlength="50" required>
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
                  <li class="active">Role</li>
              </ol>

              <h1>Role</h1>
          </div>

          <form method="POST" action="{{ route('admin.roles.search') }}" class="mb-5">
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
                      <a class="btn green" data-toggle="modal" href="#basic" onclick="addRole()"> Create a Role </a>
                    @else
                      <input disabled class="btn green"  type="submit" value="Create a Role">
                    @endif
                  </td>
                
              </tr>
            </table>
          </form>
          @if($pagination)
            <div class="pull-right">
              {!! $roles->previousPageUrl() ? '<a href='. $roles->previousPageUrl().'>Previous Page</a>'  : '' !!}
              {!! $roles->nextPageUrl() ? '&nbsp;&nbsp;<a href='. $roles->nextPageUrl().'>Next Page</a>'  : ''!!}
            </div>
          @endif

          <table class="table mx-auto">
            <thead>             
              <tr>
                  <th>Name</th>
                  <th>Descrtiption</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($roles as $role)
              <tr>                              
                <td>{{ strtoupper($role->name) }}</td>
                <td>{{ ($role->description) }}</td>                
                <td> 
                    @if($role->active)
                    <i class="font-blue"> Active</i>
                    @else
                    <i class="font-red"> Inactive</i>
                    @endif
                </td>
                
                <td class="text-center">              
                  @if($edit)      
                    <button onclick="getRoleDetails({!! $role['id'] !!})" class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                    <i class="fa fa-edit"></i> Edit</button>
                  @else
                    <button disabled class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                    <i class="fa fa-edit"></i> Edit</button>
                  @endif
                </td>                

              </tr>
            @endforeach
        
            <tbody>  
          </table>  
          <div class="pull-right">
            {{ $roles->links() }}   
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
		$(document).ready(function(){                
        document.getElementById('active').checked = true;               
      });

      function addRole() {
                        
        $("#titleLabel").text(" Create a Role");                        
        $('#id').val('');
        $('#role').val('');
        $('#description').val('');
        $('#method').val('POST');
        $('#form').attr('action', '{{ route('admin.roles.store') }}');
    }

		function getRoleDetails(id) {
			$.ajax({
                url: '{!! route('admin.roles.edit') !!}',
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

                    $("#titleLabel").text(" Update a Role");
                    $('#role').val(response.name);
                    $('#id').val(id);
                    $('#description').val(response.description);                    
                    $('#method').val('PUT');
                    $('#form').attr('action', '{{ route('admin.roles.update') }}');
                    $('#submit').html('<span class="glyphicon glyphicon-edit"></span> Update');
                }
            });
		}
	</script>
@endsection
