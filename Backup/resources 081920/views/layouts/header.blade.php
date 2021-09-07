    <div class="header">
      <div class="container">
        <a class="site-logo" href="{{ url('/admin/booking') }}">PMC Booking System</a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">

          <ul>
              <li class ="{{ Request::is('admin/booking') ? 'active' : '' }}"><a href="{{ url('/admin/booking') }}">Booking</a></li>
              <li class ="{{ Request::is('admin/closing') ? 'active' : '' }}"><a href="{{ url('/admin/closing') }}">Closing</a></li>
              <li class ="{{ Request::is('admin/employees') ? 'active' : '' }}"><a href="{{ url('/admin/employees') }}">Employees</a></li>
              <li class ="{{ Request::is('admin/priority') ? 'active' : '' }}"><a href="{{ url('/admin/priority') }}">Priority</a></li>
              <li class ="{{ Request::is('admin/blacklist') ? 'active' : '' }}"><a href="{{ url('/admin/blacklist') }}">Blacklist</a></li>

              <li class="dropdown {{ Request::is('admin/reports*') ? 'active' : '' }}">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">
                  Reports
                </a>

                <ul class="dropdown-menu">
                  <li class="{{ Request::is('admin/reports/booking-summary') ? 'active' : '' }}"><a href="{{ url('/admin/reports/booking-summary') }}">Booking Summary</a></li>
                  <li class="{{ Request::is('admin/reports/booking-history') ? 'active' : '' }}"><a href="{{ url('/admin/reports/booking-history') }}">Booking History</a></li>
                  <li class="{{ Request::is('admin/reports/booking-per-employee') ? 'active' : '' }}"><a href="{{ url('/admin/reports/booking-per-employee') }}">Booking per Employee</a></li>
                  <li class="{{ Request::is('admin/reports/feedback') ? 'active' : '' }}"><a href="{{ url('/admin/reports/feedback') }}">System Feedback</a></li>
                </ul>
              </li>
            <li><a href="/admin/change-password"> Change Password </a></li>
            <li><a href="{{ url('/logout') }}">Logout</a></li>
          </ul>
        </div>
        <!-- END NAVIGATION -->
      </div>
    </div>
  