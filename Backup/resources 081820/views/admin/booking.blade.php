@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')
  <style>
    .table > tbody > tr > td {
     vertical-align: middle;
}
  </style>
@endsection
@section('content')

  @include('layouts.header')

<div class="main">
  <div class="container">
      <div class="col-md-12 tab-style-1">
        <ul class="nav nav-tabs center">
          <li class="active"><a href="#tab-1" data-toggle="tab">Saturday</a></li>              
          <li><a href="#tab-2" data-toggle="tab">Monday</a></li>              
        </ul>
        <div class="tab-content">
          <div class="tab-pane row fade in active" id="tab-1">                       
            <div class="col-md-12 col-sm-12">
              <table><tr><td><button type="button" class="btn green" onclick="window.open('/admin/booking/satprint','displayWindow','toolbar=no,scrollbars=yes,width=1000')";><i class="fa fa-print"></i> Print</button></td></tr></table>
               <table class="table">
                <thead>
                  <tr>
                      <th>Seat No.</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Password</th>
                      <th>Destination</th>
                      <th>Dept</th>
                      <th>Cancel</th>
                  </tr>
                </thead>
                <tbody>         
                  @for ($i = 1; $i <= config('constant.totalNumberOfSeat') ; $i++)
                    <tr style='background-color:{{ $i % 2 ? "#FFFFFF" : "#F8F8AC" }}'>
                        <td>
                          {{ $i }}
                        </td>

                        @if(in_array($i, $bookingSeats)) 
                          <td>{{ $bookings[array_search($i, $bookingSeats)]->employee->empId }}</td>
                          <td>{{ $bookings[array_search($i, $bookingSeats)]->employee->name }}</td>
                          <td>{{ $bookings[array_search($i, $bookingSeats)]->pword }}</td>
                          <td>{{ $bookings[array_search($i, $bookingSeats)]->destination }}</td>
                          <td>{{ $bookings[array_search($i, $bookingSeats)]->employee->dept }}</td>
                          <td>
                            <form method ="POST" action="/admin/booking/{{ $bookings[array_search($i, $bookingSeats)]->id }}">
                              @method('DELETE')
                              @csrf
                              <button class="btn red btn-sm" id="show_confirm" type="submit">Cancel Booking</button>
                            </form>
                          </td>
                        @else
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        @endif
                    </tr>
                  @endfor
                  
                </tbody>
               </table>


            </div>
          </div>
          <div class="tab-pane row fade" id="tab-2">
            <div class="col-md-12 col-sm-12">
              <table><tr><td><button type="button" class="btn green" onclick="window.open('/admin/booking/mondayprint','displayWindow','toolbar=no,scrollbars=yes,width=1000')";><i class="fa fa-print"></i> Print</button></td></tr></table>
                 <table class="table">
                <thead>
                  <tr>
                      <th>Seat No.</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Password</th>
                      <th>Origin</th>
                      <th>Dept</th>
                      <th>Cancel</th>
                  </tr>
                </thead>
                <tbody>         
                  @for ($i = 1; $i <= config('constant.totalNumberOfSeat') ; $i++)
                    <tr style='background-color:{{ $i % 2 ? "#FFFFFF" : "#F8F8AC" }}'>
                        <td>
                          {{ $i }}
                        </td>
                        @if(in_array($i, $bookingSeatsMonday)) 
                          <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->employee->empId }}</td>
                          <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->employee->name }}</td>
                          <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->pword }}</td>
                          <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->destination }}</td>
                          <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->employee->dept }}</td>
                          <td>
                            <form method ="POST" action="/admin/booking/{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->id }}">
                              @method('DELETE')
                              @csrf
                              <button class="btn red btn-sm" id="show_confirm" type="submit">Cancel Booking</button>
                            </form>
                          </td>
                        @else
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        @endif
                    </tr>
                  @endfor
                  
                </tbody>
               </table>
            </div>
          </div>                    
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
        function tag_absent(a,b,c){
           $.ajax({
            method: "POST",
            url: "ajax.php?act=tag_absent",
            data: { isAbsent: a, day: b,seat: c }
          })
            .done(function( html ) {
              
            });
        }
    </script>

    <script type="text/javascript">
      $("#show_confirm").click(function(e) {
          if(!confirm("Are you sure you want to Cancel this Booking?")) {
              e.preventDefault();
          }
      });

      $("#show_confirm_monday").click(function(e) {
          if(!confirm("Are you sure you want to Cancel this Booking?")) {
              e.preventDefault();
          }
      });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection

