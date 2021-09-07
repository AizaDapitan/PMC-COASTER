@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')

@endsection
@section('content')

  @include('layouts.header')

  <div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">
          <form method="POST" action="/admin/priority/search" class="mb-5">
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
                  <th>Seq</th>
                  <th>ID</th>
                  <th>Dept</th>
                  <th>Name</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($priorities as $priority)
                <tr style="font-size:12px;">
                  
                  <td>{{ $loop->iteration }} </td>
                  <td>{{ $priority->employee->empId }} </td>
                  <td>{{ $priority->employee->dept }} </td>
                  <td>{{ $priority->employee->name }} </td>
                  <td>
                    <form style="display: inline" method ="POST" action="/admin/priority/{{ $priority->id }}">
                      @method('DELETE')
                      @csrf
                      <button class="btn red btn-sm" type="submit">Remove Priority</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            <tbody>
          </table>  
          <div class="pull-right">
            {{ $priorities->links() }}   
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

