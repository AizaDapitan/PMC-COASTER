@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')

@endsection
@section('content')

  @include('layouts.header')
<!-- Header END -->

<div class="main">
  <div class="container">
      <div class="col-md-12 tab-style-1">
        <form method="POST" action="/admin/blacklist/search" class="mb-5">
          @csrf
          <table width="50%">
            <tr>
              <td><h3>Search:</h3></td>
              <td><input type="text" name="q" class="form-control"></td>
              <td><input class="btn blue" type="submit" value="Go"></td>
            </tr>
          </table>
        </form>
        <br><br>
        <table class="table table-striped table-hover">
          <thead>             
          <tr>
              <th>ID</th>
              <th>Dept</th>
              <th>Name</th>
              <th>Action</th>
          </tr>
        </thead>

        @foreach ($blacklists as $blacklist)
        @if(!is_null($blacklist->employee))
          <tr style="font-size:12px;">
            <td>{{ $blacklist->employee->empId }} </td>
            <td>{{ Ucfirst($blacklist->employee->dept) }} </td>
            <td>{{ $blacklist->employee->name }} </td>
            <td>
              <form style="display: inline" method ="POST" action="/admin/blacklist/{{ $blacklist->id }}">
                @method('DELETE')
                @csrf
                <button class="btn red btn-sm" type="submit">Remove Blacklist</button>
              </form>
            </td>
          </tr>
        @endif
        @endforeach

        </table>  
        
        <div class="pull-right">
          {!! $blacklists->render() !!}
        </div>
      </div>     
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
            jQuery(".gwapo").css('cursor','url(pinakagwapo.PNG),auto');
     jQuery(".gwapo").css('cursor','url(pinakagwapo.PNG),auto');
     $('#topcontrol').hide();    
                 });

    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection

