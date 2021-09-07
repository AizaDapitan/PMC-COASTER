@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')

<!-- Theme styles START -->
<link href="google.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/metronic/assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css') }}" />

<!-- Theme styles END -->

@endsection
@section('content')

@include('layouts.header')

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <form id="form" role="form" action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="id" id="id" value="">

                    <label class="control-label" name="activeLabel" id="activeLabel">Status </label>
                    <input type="checkbox" name="active" id="active">

                    <label class="control-label" name="lockLabel" id="lockLabel" style="display: none;">    Lock </label>
                    <input type="checkbox" name="locked" id="locked" style="display: none;">

                    <div class="form-group">
                        <label class="control-label">First Name <span class="required" aria-required="true"> * </span></label>
                        <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name <span class="required" aria-required="true"> * </span></label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email Address <span class="required" aria-required="true"> * </span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Username <span class="required" aria-required="true"> * </span></label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">User Role <span class="required" aria-required="true"> * </span></label>
                        <select required name="role_id" id="role_id" class="form-control">
                            @foreach($roles as $role)
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>

                    </div>

                    <label style="display: none;" class="control-label" name="resetLabel" id="resetLabel">Reset Password</label>
                    <input style="display: none;" type="checkbox" name="reset" id="reset">
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

            <div class="breadcrumbs">                
                <ol class="breadcrumb">
                    <li><a href="{{ url('/admin/booking') }}">Home</a></li>
                    <li class="active">Users</li>
                </ol>

                <h1>Users</h1>
                
            </div>
            @if(session('errorMesssage'))
                <div id="errdiv" class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {!! session('errorMesssage') !!}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <span class="fa fa-check-square-o"></span>
                    {!! session('success') !!}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.search') }}" class="mb-5">
                @csrf
                <table width="50%">
                    <tr>
                        <td>
                            <h3>Search:</h3>
                        </td>
                        <td><input type="text" name="q" class="form-control"></td>
                        <td>
                            @if($search)
                                <input class="btn blue" type="submit" value="Go">
                            @else
                                <input disabled class="btn blue" type="submit" value="Go">
                            @endif
                            @if($create)
                                <a class="btn green" data-toggle="modal" href="#basic" onclick="addUser()"> Add User </a>
                            @else
                                <input disabled class="btn green" value="Add User" type="submit"> 
                            @endif
                        
                        
                        </td>


                    </tr>
                </table>
            </form>
            @if($pagination)
                <div class="pull-right">
                    {!! $users->previousPageUrl() ? '<a href='. $users->previousPageUrl().'>Previous Page</a>' : '' !!}
                    {!! $users->nextPageUrl() ? '&nbsp;&nbsp;<a href='. $users->nextPageUrl().'>Next Page</a>' : ''!!}
                </div>
            @endif
            <table class="table mx-auto">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Lock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ ucfirst($user->firstname) }} {{ ucfirst($user->lastname) }}</td>
                        <td>{{ $user->username }} </td>
                        <td>{{ $user->email }} </td>
                        <td>{{ $user->role }} </td>
                        <td>
                            @if($user->active)
                            <i class="font-blue"> Active</i>
                            @else
                            <i class="font-red"> Inactive</i>
                            @endif
                        </td>
                        <td>
                            @if(!$user->locked)
                            <i class="font-blue"> Unlocked</i>
                            @else
                            <i class="font-red"> Locked</i>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($edit)
                                <button onclick="getUserDetails({!! $user['id'] !!})" class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                                <i class="fa fa-edit"></i> Edit</button>
                            @else
                                <button disabled class="btn btn-sm blue btn-outline filter-submit margin-bottom" data-toggle="modal" data-target="#basic">
                                <i class="fa fa-edit"></i> Edit</button>
                            @endif
                            <!-- <button class="btn btn-sm blue btn-outline filter-submit margin-bottom">
                                <i class="fa fa-eye"></i> View</button> -->
                            <!-- <button class="btn btn-sm green btn-outline filter-cancel">
                                <i class="fa fa-user-check"></i> Activate</button>
                            <button class="btn btn-sm red btn-outline filter-cancel">
                                <i class="fa fa-user-times"></i> Deactivte</button> -->
                        </td>

                    </tr>
                    @endforeach

                <tbody>
            </table>
            <div class="pull-right">
                {{ $users->links() }}
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
        document.getElementById('active').checked = true;
    });

    function addUser() {
        $('#username').val('');
        $('#id').val('');
        $('#role_id').val('');
        $('#firstname').val('');
        $('#lastname').val('');
        $('#email').val('');
        $('#method').val('POST');
        $('#form').attr('action', '{{ route('admin.users.store') }}');
        $('#reset').hide();
        $('#resetLabel').hide();
        $('#locked').hide();
        $('#lockLabel').hide();
    }

    function getUserDetails(id) {
        $.ajax({
            url: '{!! route('admin.users.edit') !!}',
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function(response) {
                // if (response.reset == "1")
                // {                    
                // document.getElementById('reset').checked = true;
                // }
                // else
                // {
                // document.getElementById('reset').checked = false;
                // }                
                if (response.active == "1") {
                    document.getElementById('active').checked = true;
                } else {
                    document.getElementById('active').checked = false;
                }
                if (response.locked == "1") {
                    document.getElementById('locked').checked = true;
                } else {
                    document.getElementById('locked').checked = false;
                }
                $('#username').val(response.username);
                $('#role_id').val(response.role_id);
                $('#firstname').val(response.firstname);
                $('#lastname').val(response.lastname);
                $('#email').val(response.email);
                $('#id').val(id);
                $('#method').val('PUT');
                $('#form').attr('action', '{{ route('admin.users.update') }}');
                $('#reset').show();
                $('#resetLabel').show();
                $('#locked').show();
                $('#lockLabel').show();
            }
        });
    }
</script>
@endsection