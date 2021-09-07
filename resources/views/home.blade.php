@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')


@endsection
@section('content')

<div class="main">
    <div class="container-full">
      <br><br>
        <!-- BEGIN CONTENT -->
        <div class="col-md-12 col-sm-12">           
          <div class="content-page">
            <div class="row mix-block margin-bottom-40">
                <div class="col-md-12 tab-style-1">
                  <ul class="nav nav-tabs center">
                    <li class="active"><a href="#tab-1" data-toggle="tab">Saturday ({{ $satSchedString->toFormattedDateString() }})</a></li>
                    <li><a href="#tab-2" data-toggle="tab">Monday ({{ $monSchedString->toFormattedDateString() }})</a></li>
                    <li><a href="#tab-3" data-toggle="tab">Feedback Form</a></li>
                  </ul>
                    @if(session('errorMesssage'))
                      <div id="errdiv" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {!! session('errorMesssage') !!}
                      </div>
                    @endif
                    @if(session('successMesssage'))
                      <div id="errdiv" class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {!! session('successMesssage') !!}
                      </div>
                    @endif
                  <div class="tab-content">
                    <div class="tab-pane row fade in active" id="tab-1">                       
                      <div class="col-md-12 col-sm-12">
                          <iframe src="{{ url('/saturday') }}" frameborder="0" width="100%" height="650" scrolling="no"></iframe>
                      </div>
                    </div>
                    <div class="tab-pane row fade" id="tab-2">
                     <div class="col-md-12 col-sm-12">
                      <iframe src="{{ url('/monday') }}" frameborder="0" width="100%" height="650" scrolling="no"></iframe>
                      </div>
                    </div> 
                     <div class="tab-pane row fade" id="tab-3">
                      <div class="col-md-12 col-sm-12">
                        <div class="container">
                          <!-- <form action="/feedback" method="POST"> -->
                          <form id="form" role="form" action="{{ route('admin.feedback.store') }}" method="POST">
                            @csrf
                            <div class="form-group">                            
                              <label class="control-label">We would like to hear your feedback, inquiries and comments. <span class="required" aria-required="true"> * </span></label>
                              <textarea class="form-control" rows="6" name="message" required></textarea>
                            </div>
                            <div class="form-group">
                              <label class="control-label">ID # <span class="required" aria-required="true"> * </span></label>
                              <input type="text" class="form-control" placeholder="Enter your Employee ID" name="empid" required> 
                              <p class="help-block">
                                 Enter your employee ID so we could contact you about your inquiries.
                              </p>                             
                            </div>
                            <div class="form-group">
                              <input type="submit" value="Submit" class="btn blue">                                                         
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>

            </div>
          </div>
        </div>
        <!-- END CONTENT -->
    </div>
  </div>

@endsection

@section('pagejs')
    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="{{ asset('theme/metronic/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->

    <script src="{{ asset('theme/metronic/assets/frontend/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();  
              jQuery(".gwapo").css('cursor','url(images/gwapo.PNG),auto');
       jQuery(".gwapo").css('cursor','url(images/gwapo.PNG),auto');     
       $('#topcontrol').hide();
                   });

    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection

