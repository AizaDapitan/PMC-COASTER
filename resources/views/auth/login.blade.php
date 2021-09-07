@extends('main')
@section('pageBodyClass', 'login')
@section('pagecss')
    <link href="{{ asset('theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('theme/metronic/assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{ asset('theme/metronic/assets/global/plugins/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('theme/metronic/assets/admin/pages/css/login-soft.css') }}" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('theme/metronic/assets/global/css/components.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('theme/metronic/assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('theme/metronic/assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
	<link id="style_color" href="{{ asset('theme/metronic/assets/admin/layout/css/themes/default.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('theme/metronic/assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
@endsection
@section('content')
    
<div class="logo">
    <h2 style="color:yellow;text-decoration:underline;">
        PMC - Coaster Booking and Reservation System
    </h2>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <h3 class="form-title">Login using your account</h3>
        
        <!-- @error('username')
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span>
                    {{ $message }}</span>
            </div>
        @enderror -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            
        
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label for="username" class="control-label visible-ie8 visible-ie9">{{ __('Domain Name') }}</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" id="username" autocomplete="off" placeholder="Domain Account" name="username" value="{{ old('username') }}" required autofocus/>
            </div>
            
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required/>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-actions">
            <label class="checkbox">
            <input type="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/> {{ __('Remember Me') }} </label>
            <button type="submit" class="btn blue pull-right">
                {{ __('Login') }} <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
        
    </form>
    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		{{ date('Y') }} &copy; PMC IT-Dept.
	</div>
	<!-- END COPYRIGHT -->
</div>     
    
@endsection

@section('pagejs')

	<!-- BEGIN CORE PLUGINS -->


	<script src="{{ asset('theme/metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js ') }}" type="text/javascript"></script>
	<script src="{{ asset('theme/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js ') }}" type="text/javascript"></script>
	<script src="{{ asset('theme/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js ') }}" type="text/javascript"></script>
	<script src="{{ asset('theme/metronic/assets/global/plugins/jquery.blockui.min.js ') }}" type="text/javascript"></script>
	<script src="{{ asset('theme/metronic/assets/global/plugins/jquery.cokie.min.js ') }}" type="text/javascript"></script>
	<script src="{{ asset('theme/metronic/assets/global/plugins/uniform/jquery.uniform.min.js ') }}" type="text/javascript"></script>
	<script src="{{ asset('theme/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js ') }}" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('theme/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('theme/metronic/assets/global/plugins/select2/select2.min.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('theme/metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/metronic/assets/admin/pages/scripts/login-soft.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
            jQuery(document).ready(function() {     
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init() // init quick sidebar
                Login.init();

                // init background slide images
                $.backstretch([
                    "theme/metronic/assets/admin/pages/media/bg/6.jpg",
					"theme/metronic/assets/admin/pages/media/bg/5.jpg",
					"theme/metronic/assets/admin/pages/media/bg/3.jpg",
					"theme/metronic/assets/admin/pages/media/bg/4.jpg"
                    ], {
                    fade: 1000,
                    duration: 8000
                    }
                );
            });
        </script>
    <!-- END JAVASCRIPTS -->
@endsection
