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

    <div class="container">

        <div class="row">

            <div class="col-md-12">
                
                <div style="width: 550px; display: block; margin: 100px auto 0; background: black; padding: 30px;">
                   
                        <form method="POST" action="/admin/change-password" role="form">
                            @csrf 
                            @method('PATCH')
       
                             @foreach ($errors->all() as $error)
                                <p class="text-warning">{{ $error }}</p>
                             @endforeach 

                             @if(session()->has('error_message')) 

                                <p class="text-warning">{{ session()->get('error_message') }}</p>
                            
                             @endif

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right" 
                                    style="color: #ffffff;">Current Password</label>
      
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                                </div>
                            </div>
      
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right" 
                                    style="color: #ffffff;">New Password</label>
      
                                <div class="col-md-8">
                                    <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                                </div>
                            </div>
      
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right" 
                                    style="color: #ffffff;">New Confirm Password</label>
        
                                <div class="col-md-8">
                                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                                </div>
                            </div>
       
                            <div class="form-group row mb-0 text-center">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                </div>
                            </div>

                        </form>

                        <a href="/admin/booking" class="btn btn-default"> << Back </a>

                    </div>
                </div>
            </div>

        </div>
    
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
