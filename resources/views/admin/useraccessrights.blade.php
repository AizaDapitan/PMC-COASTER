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

  <div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">

            <div class="breadcrumbs">              
                
                <ol class="breadcrumb">
                    <li><a href="{{ url('/admin/booking') }}">Home</a></li>                  
                    <li class="active">User Access Rights</li>
                </ol>

                <h1>User Access Rights</h1>
            </div>

            <div class="page-content-container">
                <div class="row">
                    <div class="col-lg-12">

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
                        <div class="portlet light portlet-fit portlet-datatable bordered">

                            <form id="form" action="{{ route('admin.useraccessrights.store') }}" method="POST">

                                <input type="hidden" id="create" name="create" value="{{ $create }}">
                                <input type="hidden" name="users_permissions" id="users_permissions" value="">
                                @csrf

                                <div class="portlet-title">
                                    
                                    <div class="actions">
                                        <div class="form-group form-inline" style="display:inline;margin-right:10px">
                                            <label class="control-label" style="margin-right:20px">User Name </label>
                                            
                                            <select required name="userid" id="userid" class="form-control select2">
                                                @foreach($users as $user)
                                                <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        @if($create)
                                            <button type="submit" class="btn blue" id="saveUserPermission">
                                                <i class="fa fa-save"></i>&nbsp; Save Changes
                                            </button>
                                        @else
                                            <button disabled type="submit" class="btn blue" id="saveUserPermission">
                                                <i class="fa fa-save"></i>&nbsp; Save Changes
                                            </button>
                                        @endif
                                    </div>
                                </div>                     
                                
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover" style="width:100%;">
                                            <thead class="thead-light">
                                                <tr class="green">
                                                    <th>Permission List</th>
                                                    <th>View</th>
                                                    <th>Create</th>
                                                    <th>Update</th>
                                                    <th>Pagination</th>
                                                    <th>Print</th>
                                                    <th>Search</th>
                                                    <th>Upload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($modules as $module)
                                                <tr>
                                                    <td width="50%">
                                                        <div class="caption custom-padding">
                                                            <span class="caption-subject font-green bold uppercase">{{ strtoupper($module['description'])}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_view" data-module="{{$module['id']}}_view" onclick="checkPermission(this.id)" id="{{$module['id']}}_view">
                                                            <label for="{{$module['id']}}_view">
                                                                <span></span>
                                                                <span span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_create" data-module="{{$module['id']}}_create" onclick="checkPermission(this.id)" id="{{$module['id']}}_create">
                                                            <label for="{{$module['id']}}_create">
                                                                <span></span>
                                                                <span span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_edit" data-module="{{$module['id']}}_edit" id="{{$module['id']}}_edit" onclick="checkPermission(this.id)">
                                                            <label for="{{$module['id']}}_edit">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_pagination" data-module="{{$module['id']}}_pagination" id="{{$module['id']}}_pagination" onclick="checkPermission(this.id)">
                                                            <label for="{{$module['id']}}_pagination">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_print" data-module="{{$module['id']}}_print" id="{{$module['id']}}_print" onclick="checkPermission(this.id)">
                                                            <label for="{{$module['id']}}_print">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_search" data-module="{{$module['id']}}_search" id="{{$module['id']}}_search" onclick="checkPermission(this.id)">
                                                            <label for="{{$module['id']}}_search">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td><td>
                                                        <div class="md-checkbox custom-padding">
                                                            <input type="checkbox" class="md-check" data-role="{{$module['id']}}_upload" data-module="{{$module['id']}}_upload" id="{{$module['id']}}_upload" onclick="checkPermission(this.id)">
                                                            <label for="{{$module['id']}}_upload">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @foreach($permissions as $permission)
                                                @if(strtoupper($permission['module_type']) == strtoupper($module['description']) )
                                                <tr>
                                                    <td>
                                                        {{ strtoupper($permission['description']) }}
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_view" data-module="{{$permission['id']}}_{{$module['id']}}_view" id="{{$permission['id']}}_{{$module['id']}}_view" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_view">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_create" data-module="{{$permission['id']}}_{{$module['id']}}_create" id="{{$permission['id']}}_{{$module['id']}}_create" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_create">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_edit" data-module="{{$permission['id']}}_{{$module['id']}}_edit" id="{{$permission['id']}}_{{$module['id']}}_edit" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_edit">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_pagination" data-module="{{$permission['id']}}_{{$module['id']}}_pagination" id="{{$permission['id']}}_{{$module['id']}}_pagination" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_pagination">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_print" data-module="{{$permission['id']}}_{{$module['id']}}_print" id="{{$permission['id']}}_{{$module['id']}}_print" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_print">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_search" data-module="{{$permission['id']}}_{{$module['id']}}_search" id="{{$permission['id']}}_{{$module['id']}}_search" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_search">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="md-checkbox">
                                                            <input type="checkbox" class="md-check" data-role="{{$permission['id']}}_{{$module['id']}}_upload" data-module="{{$permission['id']}}_{{$module['id']}}_upload" id="{{$permission['id']}}_{{$module['id']}}_upload" onchange="storeID(this.id)">
                                                            <label for="{{$permission['id']}}_{{$module['id']}}_upload">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>

                            </form>
                        </div>

                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>
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
        $(document).ready(function() {
            getUsersPermissions($("#userid").val());
            $("#userid").on('change', function() {
                getUsersPermissions($("#userid").val());

            })
        });

        function getUsersPermissions(userid) {
            document.querySelectorAll('input[type=checkbox]').forEach(el => el.checked = false)
            $("#users_permissions").val("");
            $.ajax({
                url: '{!! route('admin.useraccessrights.store') !!}',
                type: 'get',
                
                data: {
                    userid: userid
                },
                success: function(data) {
                    $.each(data, function(index, element) {
                        var chkid = "";
                        chkid = (element.permission_id + "_" + element.module_id + "_" + element.action)
                        if (chkid != "") {
                            document.getElementById(element.module_id + "_" + element.action).checked = true;
                            document.getElementById(chkid).checked = true;

                            storeID(chkid);
                        }
                    });
                }
            });
        }

        function checkPermission(id) {
            var checkboxes = document.getElementsByTagName("input");
            const cb = document.getElementById(id);
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == "checkbox") {
                    if (checkboxes[i].id.includes(id)) {
                        document.getElementById(checkboxes[i].id).checked = cb.checked;
                        storeID(checkboxes[i].id);
                    }
                }
            }
        }

        function storeID(id) {
            var users_permissions = $("#users_permissions").val();
            
            if (document.getElementById(id).checked) {
                if (users_permissions != "") {

                    users_permissions = users_permissions + ',' + id;
                } else {

                    users_permissions = id;
                }
            } else {
            if((id.match(/_/g) || []).length == 2)
            {
                    if (users_permissions.includes("," + id)) {
                        users_permissions = users_permissions.replace("," + id, "");
                        console.log(users_permissions);
                    } else if (users_permissions.includes(id + ",")) {
                        users_permissions = users_permissions.replace(id + ",", "");
                        
                        console.log(users_permissions);
                    } else {
                        users_permissions = users_permissions.replace(id, "");
                    }
                }
            }
            $("#users_permissions").val(users_permissions);
        }
	</script>
@endsection
