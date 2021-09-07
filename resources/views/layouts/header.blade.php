<style>
            /* The Modal (background) */
#myModal1 {
  display: none ; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
#content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 45%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
        </style>
    <div class="header">
      <div class="container">
        <a class="site-logo" href="{{ url('/admin/booking') }}">PMC Booking System</a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">

          <ul>

            <li class="{{ Request::is('admin/booking*') ? 'active' : '' }}"><a href="{{ url('/admin/booking') }}">Booking</a></li>
            <li class="{{ Request::is('admin/closing*') ? 'active' : '' }}"><a href="{{ url('/admin/closing') }}">Closing</a></li>

            <!-- <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Employees</a>

                  <ul class="dropdown-menu">
                      <li class ="{{ Request::is('admin/employees') ? 'active' : '' }}"><a href="{{ url('/admin/employees') }}">Employee Listing</a></li>
                      <li class ="{{ Request::is('admin/priority') ? 'active' : '' }}"><a href="{{ url('/admin/priority') }}">Priority</a></li>
                      <li class ="{{ Request::is('admin/blacklist') ? 'active' : '' }}"><a href="{{ url('/admin/blacklist') }}">Blacklist</a></li>
                  </ul>
              </li>     -->


            <li class="dropdown {{ Request::is('admin/employee*') || Request::is('admin/priority*')|| Request::is('admin/blacklist*') ? 'active' : '' }}">
              <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Employees</a>

              <ul class="dropdown-menu">
                <li><a href="{{ url('/admin/employees') }}">Employee Listing</a></li>
                <li><a href="{{ url('/admin/priority') }}">Priority</a></li>
                <li><a href="{{ url('/admin/blacklist') }}">Blacklist</a></li>
              </ul>
            </li>


            <li class="dropdown {{ Request::is('admin/user*') ? 'active' : '' }}">
              <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Maintenance</a>

              <ul class="dropdown-menu">
                <li><a href="{{ url('/admin/users') }}">Users</a></li>
                <li><a href="{{ url('/admin/useraccessrights') }}">User Access Rights</a></li>
              </ul>
            </li>

            <li class="dropdown {{ Request::is('admin/role*') || Request::is('admin/permissions*') ? 'active' : '' }}">
              <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Account Management</a>

              <ul class="dropdown-menu">
                <li><a href="{{ url('/admin/roles') }}">Roles</a></li>
                <li><a href="{{ url('/admin/permissions') }}">Permissions</a></li>
                <li><a href="{{ url('/admin/roleaccessrights') }}">Role Access Rights</a></li>
              </ul>
            </li>

            <li class="{{ Request::is('admin/application*') ? 'active' : '' }}"><a href="{{ route('admin.application.index') }}">Application</a></li>

            <li class="dropdown {{ Request::is('admin/reports*') ? 'active' : '' }}">
              <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">
                Reports
              </a>

              <ul class="dropdown-menu">
                <li><a href="{{ route('admin.reports.audit-logs') }}"> Audit Logs </a></li>
                <li><a href="{{ route('admin.reports.error-logs') }}"> Error Logs </a></li>
                <li class="{{ Request::is('admin/reports/booking-summary') ? 'active' : '' }}"><a href="{{ url('/admin/reports/booking-summary') }}">Booking Summary</a></li>
                <li class="{{ Request::is('admin/reports/booking-history') ? 'active' : '' }}"><a href="{{ url('/admin/reports/booking-history') }}">Booking History</a></li>
                <li class="{{ Request::is('admin/reports/booking-per-employee') ? 'active' : '' }}"><a href="{{ url('/admin/reports/booking-per-employee') }}">Booking per Employee</a></li>
                <li class="{{ Request::is('admin/reports/feedback') ? 'active' : '' }}"><a href="{{ url('/admin/reports/feedback') }}">System Feedback</a></li>
              </ul>
            </li>

            <!-- <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">
                Documentation
              </a>

              <ul class="dropdown-menu">
                <li><a href="{{ asset('files/Final User Guide for End-User - Coaster Booking System.pdf') }}" target="_blank"> User Manual </a></li>

                 <li><a href="https://mlappsvr.philsaga.com:8013/files/Final%20User%20Guide%20for%20Admin%20-%20Coaster%20Booking%20System.pdf" target="_blank"> User Manual </a></li> 
              </ul>
            </li> -->

            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">My Account</a>

              <ul class="dropdown-menu">
                <li><a href="{{ route('auth.change') }}">Change Password</a></li>
                <!-- <li><a href="/admin/change-password">Change Password</a></li> -->
                <li><a href="{{ url('/logout') }}">Logout</a></li>
              </ul>
            </li>

          </ul>
        </div>
        <!-- END NAVIGATION -->

      </div>
      
    <div id="myModal1" class="modal">

<!-- Modal content -->
<div class="modal-content" id="content">
  <span class="close" id="close">&times;</span>
  <p style="font-size: 18px; font-weight:bold;">In exactly 1 hour the system will undergo maitenance! Please save your work!</p>
</div>
</div>
    </div>
    <div>
      @if($reason)
      <div class="alert alert-danger alert-dismissable">
        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> -->
        <span class="fa fa-exclamation"></span>
        <label aria-labelledby="notifications" id="notifications">{{ $reason }} </label>
        <label aria-labelledby="countdown" id="countdown" style="float:right; font-weight:bold">Time Remaining : </label>
        <label aria-labelledby="datetime" id="datetime" style="display:block">Shutdown Date : {{ $scheduledate }} {{ $scheduletime}} </label>
      </div>
      @else
      <label aria-labelledby="countdown" id="countdown" style="display:none; font-weight:bold">Time Remaining : </label>
      @endif
    </div>


      <script type="text/javascript">
        var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var shown = 0;

        var modal = document.getElementById("myModal1");

        var span = document.getElementById("close");
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }

        // // When the user clicks anywhere outside of the modal, close it
        // window.onclick = function(event) {
        //   if (event.target == modal) {
        //     modal.style.display = "none";
        //   }
        // }

        function GetClock() {
          var d = new Date();
          var nday = d.getDay(),
            nmonth = d.getMonth(),
            ndate = d.getDate(),
            nyear = d.getFullYear();
          var nhour = d.getHours(),
            nmin = d.getMinutes(),
            nsec = d.getSeconds(),
            ap;
          var ohour = nhour + 1;
          if (nhour == 0) {
            ap = " AM";
            nhour = 12;
          } else if (nhour < 12) {
            ap = " AM";
          } else if (nhour == 12) {
            ap = " PM";
          } else if (nhour > 12) {
            ap = " PM";
            nhour -= 12;
          }

          if (nmin <= 9) nmin = "0" + nmin;
          if (nsec <= 9) nsec = "0" + nsec;

          var clocktext = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " " + nhour + ":" + nmin + ":" + nsec + ap + "";
          // document.getElementById('clockbox').innerHTML = clocktext;
          var schedule = {!! json_encode($scheduledate) !!} + ' ' + {!! json_encode($scheduletime) !!};
          // dt = dt.replace(':00.0000000','');
          var mnth = nmonth + 1;
          var dte = ndate;
          if (mnth <= 9) mnth = "0" + mnth;
          if (dte <= 9) dte = "0" + dte;
          var curDateless1hour = nyear + '-' + mnth + '-' + dte + ' ' + ohour + ":" + nmin;
          var curDate = nyear + '-' + mnth + '-' + dte + ' ' + (ohour - 1) + ":" + nmin;
          // console.log(dt);
          // console.log(dd2);
          if (schedule == curDateless1hour && shown == 0) {
            shown = 1;
            //    alert("In exactly 1 hour the system will undergo maitenance! Please save your work.");

            modal.style.display = "block";
            return false;
          }
          if (schedule == curDate) {
            $.ajax({
              url: '{!! route('admin.application.systemDown') !!}',
              type: 'GET',
              async: false,
              success: function(response) {}
            });
          }
          if (schedule > curDate) {
            var TimeDiff = timeDiffCalc(new Date(schedule), new Date());
          } else {
            TimeDiff = "Maintenance is in progress!";
          }

          document.getElementById('countdown').innerHTML = "Time Remaining : " + TimeDiff;
        }
        GetClock();
        setInterval(GetClock, 1000);

        function timeDiffCalc(dateFuture, dateNow) {
          // console.log(dateNow);
          let diffInMilliSeconds = Math.abs(dateFuture - dateNow) / 1000;
          // calculate days
          const days = Math.floor(diffInMilliSeconds / 86400);
          diffInMilliSeconds -= days * 86400;

          // calculate hours
          const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
          diffInMilliSeconds -= hours * 3600;

          // calculate minutes
          const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
          diffInMilliSeconds -= minutes * 60;

          // calculate minutes
          const seconds = Math.floor(diffInMilliSeconds);
          diffInMilliSeconds -= seconds;
          // if(seconds > 0){

          let difference = '';
          if (days > 0) {
            difference += (days === 1) ? `${days} day, ` : `${days} days, `;
          }

          difference += (hours === 0 || hours === 1) ? `${hours} hour, ` : `${hours} hours, `;

          difference += (minutes === 0 || hours === 1) ? `${minutes} minute, ` : `${minutes} minutes, `;

          difference += (seconds === 0 || seconds === 1) ? `${seconds} seconds` : `${seconds} seconds`;

          return difference;
          // }
        }
      </script>