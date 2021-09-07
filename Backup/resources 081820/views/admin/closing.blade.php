@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')


@endsection
@section('content')

  @include('layouts.header')

    <div class="main">
        <div class="container">
            <div class="col-md-12">

            @if($dayToday == 'Monday')
                <form style="display: inline" method ="POST" action="/admin/closing">
                    @csrf
                    <button class="btn green" type="submit">Close {{ $satSched ? $satSched->travel_date : '' }} and {{ $monSched ? $monSched->travel_date : '' }} Cutoff</button>
                </form>
            @endif

            <table class="table">
                <thead>
                    <tr>
                    <th>Seq</th>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scheds as $sched)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sched->travel_date }}</td>
                        <td>{{ $sched->travel_day    }}</td>
                        <td>{{ $sched->isClosed ? 'Closed' : 'Open' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>     
        </div>
    </div>
    
@endsection

@section('pagejs')
    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="metronic/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->

    <script src="metronic/assets/frontend/layout/scripts/layout.js" type="text/javascript"></script>
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

