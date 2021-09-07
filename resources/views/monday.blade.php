@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')
<script src="{{ asset('js/jquery-1.4.1.min.js') }}" type="text/javascript"></script>
<style type="text/css">
  #holder{ 
    height:300px;   
    width:480px;
   /* background-color:#F5F5F5;*/
    border:1px solid #A4A4A4;
    margin-left:20px;  
  }
  #place {
    position:relative;
    margin:7px;
  }
  #place a{
   font-size:1em;
  }
  #place li
  {
   list-style: none outside none;
   position: absolute;   
  }    
  #place li:hover
  {
   background-color:yellow;      
  } 
  #place .seat{
   background:url("images/available_seat_img.gif") no-repeat scroll 0 0 transparent;
   background-size: 100% 100%;
   height:33px;
   width:33px;
   display:block;  
  }
  #place .stallSeat
  { 
   background-image:url("images/stall.png");         
  }
  #place .selectedSeat
  { 
   background-image:url("images/booked_seat_img.gif");         
  }
  #place .selectingSeat
  { 
   background-image:url("images/selected_seat_img.gif");         
  }         
  #place .row-3, #place .row-4{
   margin-top:10px;
  }
  #seatDescription{
   padding:0px;
  }
  #seatDescription li{
    verticle-align:middle;   
    list-style: none outside none;
    padding-left:35px;
    height:35px;
    float:left;
  }
  .driverd {
    position: relative;   
    height:600px; 
    border:1px solid #A4A4A4;    
  }

  .driverd img {
    position: absolute;
    left: 0;
    bottom: 0;
  }


/* #uloulo{ 
   background-color:black !important;
}*/
@media screen and (max-width: 1000px) {
  #place{ 
    
    top:-300px;
    left:220px;
  }
  #holder{ 
      border:0px solid #A4A4A4;
  }
  #tago{ 
      display:block;
  }
}
</style>

@endsection
@section('content')

<div class="main">
@if($displayMain)
  <div class="container" id="maincontent" style="width: 1440px!important;">
    <ul class="blog-info">
      <li><i class="fa fa-user"></i> Michael Estor</li>
      <li><i class="fa fa-calendar"></i> {{ $monSchedString->toFormattedDateString() }} ({{ $monSched->travel_day }})</li>
      <li><i class="fa fa-history"></i> 04:00 AM</li>
      <li><i class="fa fa-tags"></i> Davao To Agusan</li>
      <li> &nbsp;</li>
      <li> &nbsp;</li>
      <li> <h3>Legend:</h3></li>
      <li> <img src="images/available_seat_img.gif"> Available</li>
      <li> <img src="images/booked_seat_img.gif"> Booked</li>
      <li> <img src="images/stall.png"> Stool</li>
    </ul><br>
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
    <br>
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
      <!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">           
        <div class="content-page">
          <div class="row margin-bottom-30">
            <!-- BEGIN INFO BLOCK -->   
            <div class="col-md-2" id="uloulo">
              <img src="images/ulo2.png" height="200%">
            </div>            
            <div class="col-md-5">        
             
              <form id="form1" runat="server">                           
                <div id="holder">
                  <div class="col-md-10 col-sm-10">
                    <ul style="z-index:1000;" id="place">
                      @php
                        $row = 0;
                        $col = 0;
                        $top = 0;
                        $left = -55;
                        $stallSeat= [3,8,13,18,28,23,33,38];
                      @endphp
                      @foreach ($seatArray as $arr) 
                          @if($col >= 8)
                            @php
                              $col = 0;
                              $row++;
                              $top=$top+55;
                              $left = -55;
                            @endphp
                          @endif
                          @php
                            $col++;
                            $left= $left + 55;
                          @endphp
                      <li class="{{ in_array($arr, $reservedSeats) ? 'selectedSeat' : '' }} {{ in_array($arr, $stallSeat) ? 'stallSeat' : '' }} seat row-{{ $row }} col-{{ $col }}  jt{{$arr}}" data="{{$arr}}" style="top:{{$top}}px;left:{{$left}}px"><a title="{{$arr}}">{{$arr}}</a></li>   
                      @endforeach     
                    </ul>
                  </div>
                </div>
          
              </form>
              <script type="text/javascript">
                $(function() {
                  var settings = {
                    rows: 5,
                    cols: 8,
                    rowCssPrefix: 'row-',
                    colCssPrefix: 'col-',
                    seatWidth: 55,
                    seatHeight: 55,
                    seatCss: 'seat',
                    selectedSeatCss: 'selectedSeat',
                    selectingSeatCss: 'selectingSeat'
                  };

                  var init = function(reservedSeat) {
                    var str = [],
                      seatNo, className;
                  };

                  //case I: Show from starting
                  //init();

                  //Case II: If already booked
                  var bookedSeats = [5, 10, 25, 50];
                  init(bookedSeats);

                  // Onselecting a seat
                  $('.' + settings.seatCss).click(function() {
                    if ($(this).hasClass(settings.selectedSeatCss)) {
                      alert('This seat is already reserved');
                    } else {
                      // Clear Other Selected
                      
                      var str = [],
                        item;
                      $.each($('#place li.' + settings.selectingSeatCss + ' a'), function(index, value) {
                        item = $(this).attr('title');
                        $('.jt' + item).toggleClass(settings.selectingSeatCss);
                      });
                      // End Clear
                      $(this).toggleClass(settings.selectingSeatCss);
                      
                      // Start calling form
                      $.ajax({
                          method: "GET",
                          url: "{{ env('APP_URL')}}/ajax?act=selectseat",
                          data: {
                            sitno: $(this).attr('data'),
                          }
                        })
                        .done(function(html) {
                          $("#formdiv").html(html);
                          $("#employee").focus();
                          window.parent.$("body").animate({
                            scrollTop: $("#formdiv").offset().top
                          }, 'slow');
                        });
                      // End form

                    }
                  });

                  $('#btnShow').click(function() {
                    var str = [];
                    $.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.' + settings.selectingSeatCss + ' a'), function(index, value) {
                      str.push($(this).attr('title'));
                    });
                    alert(str.join(','));
                  })

                  $('#btnShowNew').click(function() {
                    var str = [],
                      item;
                    $.each($('#place li.' + settings.selectingSeatCss + ' a'), function(index, value) {
                      item = $(this).attr('title');
                      str.push(item);
                    });
                    alert(str.join(','));
                  })
                });
              </script>
       
            </div>
            <!-- END INFO BLOCK -->   

            <!-- BEGIN CAROUSEL -->            
            <div class="col-md-5" > 

              <div class="note note-info">
              <table style="margin-left:10px;font-size:16px;color:#D35400;">                    
                <tr>
                    <td>&nbsp;</td>
                    <td>Available:</td>
                    <td>{{ config('constant.totalNumberOfSeat') - $bookingCount}} Seats</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Reserved:</td>
                    <td>{{ $bookingCount }} Seats</td>
                </tr>                    
                 </table>
              </div>
              <div class="note note-success">
                <table style="margin-left:10px;font-size:14px;">
                  <tr>
                    <td style="font-size:16px;color:#D35400;font-weight:bold;">Inquire Booking:</td>
                  </tr>
                  <tr>
                    <td colspan="2"><input type="text" name="cpword" id="cpword" class="form-control" placeholder="Enter Password"></td>
                    <td><a href="#" class="btn green" onclick="searchbooking($('#cpword').val());">Go</a></td>
                  </tr>
                  <tr>
                    <td id="searchresult" colspan="3" style="color:blue;"></td>
                  </tr>
                </table>
              </div>                  
            </div>
            <!-- END CAROUSEL -->
          </div>  
                  
          <div class="col-md-12">
            <div id="formdiv" class=" padding-top-10">
              <div>
              </div>
            </div>
          </div>
      <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
  </div>
@else
  <div class="container" id="countodowndiv">
    <div class="row margin-bottom-40">
      <!-- BEGIN CONTENT -->
      <div class="col-md-12 col-sm-12">
        <div class="content-page page-500">
          <div class="number">
              Service Unavailable
          </div>              
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <div class="text-center">


            <h3>System currently waiting for closing of previous cutoff.</h3>
          

        </div>
      </div>
      <!-- END CONTENT -->
    </div>
  </div>
@endif
</div>

@endsection

@section('pagejs')
    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="{{ asset('theme/metronic/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script><!-- pop up -->
    <script src="{{ asset('theme/metronic/assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('theme/metronic/assets/frontend/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/countdown.js') }}" type="text/javascript"></script>
    
    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      jQuery(document).ready(function() {
        Layout.init();
        $('#topcontrol').hide();
        $("#cpword").keyup(function(e) {
          if (e.keyCode == 13) {
            searchbooking($('#cpword').val());
          }
        });
  
        jQuery(".gwapo").css('cursor', 'url(pinakagwapo.PNG),auto');
        jQuery(".gwapo").css('cursor', 'url(pinakagwapo.PNG),auto');
  
  
      });
  
      function showname(ab) {
        var a = 'EMPID-' + ab;
        $.ajax({
            method: "GET",
            url: "{{ env('APP_URL')}}/ajax?act=getname",
            data: {
              empId: a
            }
          })
          .done(function(html) {
            $("#namehere").html(html);
  
          });
      }
  
      function searchbooking(a) {
        $.ajax({
            method: "GET",
            url: "{{ env('APP_URL')}}/ajax?act=searchbookingMon",
            data: {
              pword: a
            }
          })
          .done(function(html) {
            $("#searchresult").html(html);
          });
      }
  
      function showconfirmation(ax, b, c, d, e, f) {
        var x = '10';
        var a = 'EMPID-' + ax;
        var adx = e.length;
        if (adx >= 1) {
          bootbox.dialog({
            title: "Confirm Details",
            message: '<div class="row">  ' +
              '<div class="col-md-12"> ' +
              // '<form class="form-horizontal" id="frmsatfinal" method="post" action="/monday"> ' +
              '<form class="form-horizontal" id="frmsatfinal" method="post" action="'+ document.URL +'"> ' +
              '<input name="_token" value="' + f + '" type="hidden"> ' +
              ' <div class="form-body"> <input type="hidden" name="destination" value="' + b + '"> <input type="hidden" name="sit" value="' + c + '">  <input type="hidden" name="employee" value="' + a + '"> ' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Seat No:</label>' +
              '     <div class="col-md-9">' +
              '       <p class="form-control-static" style="font-size:30px !important;">' +
              '          ' + c +
              '       </p>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Name:</label>' +
              '     <div class="col-md-9">' +
              '       <p class="form-control-static">' +
              '         ' + d + ' (' + a.toUpperCase() + ')' +
              '       </p>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Destination:</label>' +
              '     <div class="col-md-9">' +
              '       <p class="form-control-static">' +
              '          ' + b +
              '       </p>' +
              '     </div>' +
              '   </div>' +
              ' </div>  ' +
              '</form> </div>  </div>',
            buttons: {
              success: {
                label: "Submit Booking",
                className: "btn-success",
                callback: function() {
                  $("#frmsatfinal").submit();
  
                }
              }
            }
          });
        } else {
          bootbox.dialog({
            title: "Confirm Details",
            message: '<div class="row">  ' +
              '<div class="col-md-12"> ' +
              // '<form class="form-horizontal" id="frmsatfinal" method="post" action="/monday"> ' +
              '<form class="form-horizontal" id="frmsatfinal" method="post" action="'+ document.URL +'"> ' +
                '<input name="_token" value="' + f + '" type="hidden"> ' +
              ' <div class="form-body"> <input type="hidden" name="destination" value="' + b + '"> <input type="hidden" name="sit" value="' + c + '">  <input type="hidden" name="employee" value="' + a + '"> ' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Seat No:</label>' +
              '     <div class="col-md-9">' +
              '       <p class="form-control-static" style="font-size:30px !important;">' +
              '          ' + c +
              '       </p>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Name:</label>' +
              '     <div class="col-md-9">' +
              '       <p class="form-control-static">' +
              '          ' + d + ' (' + a.toUpperCase() + ')' +
              '       </p>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Destination:</label>' +
              '     <div class="col-md-9">' +
              '       <p class="form-control-static">' +
              '          ' + b +
              '       </p>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Address</label>' +
              '     <div class="col-md-9">' +
              '       <input type="text" class="form-control" placeholder="Enter Address" name="address1" id="address1">' +
              '       <span class="help-block">' +
              '       House#, Street, Brgy.  </span>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group">' +
              '     <label class="col-md-3 control-label">Town or City</label>' +
              '     <div class="col-md-9">' +
              '       <select class="form-control" id="address2" name="address2">' +
              '         <option value="Bunawan">Bunawan</option>' +
              '         <option value="Trento">Trento</option>' +
              '         <option value="Monkayo">Monkayo</option>' +
              '         <option value="Montevista">Montevista</option>' +
              '         <option value="Nabunturan">Nabunturan</option>' +
              '         <option value="Mawab">Mawab</option>' +
              '         <option value="Tagum">Tagum</option>' +
              '         <option value="Carmen">Carmen</option>' +
              '         <option value="Panabo">Panabo</option>' +
              '         <option value="Davao" selected="selected">Davao</option>' +
              '         <option value="Other">Other</option>' +
              '       </select>' +
              '     </div>' +
              '   </div>' +
              '   <div class="form-group" id="othertown">' +
              '     <label class="col-md-3 control-label">Or Input Town:</label>' +
              '     <div class="col-md-9">' +
              '       <input type="text" class="form-control" name="address2m" placeholder="Enter Town or City">' +
              '     </div>' +
              '   </div>' +
              ' </div>  ' +
              '</form> </div>  </div>',
            buttons: {
              success: {
                label: "Submit Booking",
                className: "btn-success",
                callback: function() {
                  $("#frmsatfinal").submit();
  
                }
              }
            }
          });
        }
      }
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
@endsection

