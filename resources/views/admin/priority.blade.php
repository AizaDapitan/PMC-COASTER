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
                  <li class="active">Priority</li>
              </ol>
              
              <h1>Priority</h1>

          </div>        
        
          <form method="POST" action="{{ route('admin.priority.search') }}" class="mb-5">
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
                </td>
              </tr>
            </table>
          </form>
          <br><br>
          <table class="table table-striped table-hover">
            <thead>             
              <tr>
                  <th>Seq</th>
                  <th>ID</th>
                  <th>Dept</th>
                  <th>Name</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($priorities as $priority)
                @if(!is_null($priority->employee))
                <tr style="font-size:12px;">
                  <td>{{ $loop->iteration }} </td>
                  <td>{{ $priority->employee->empId }} </td>
                  <td>{{ $priority->employee->dept }} </td>
                  <td>{{ $priority->employee->name }} </td>
                  <td>
                    <form style="display: inline" action="{{ route('admin.priority.destroy', $priority['id']) }}" method="POST">
                      @method('DELETE')
                      @csrf
                      @if($edit)
                        <button class="btn red btn-sm" type="submit">Remove Priority</button>
                      @else
                        <button disabled class="btn red btn-sm" type="submit">Remove Priority</button>
                      @endif

                    </form>
                  </td>
                </tr>
                @endif
              @endforeach

            <tbody>
          </table>  
        @if($pagination)
          <div class="pull-right">
            {{ $priorities->links() }}   
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

