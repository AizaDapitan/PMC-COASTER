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

    <!-- BEGIN BREADCRUMBS -->
    <div class="breadcrumbs">
    <h1>USER ACTIONS REPORT</h1>
        <ol class="breadcrumb">
            <li>
                 <li><a href="{{ url('/admin/booking') }}">Home</a></li>
            </li>
            <li class="active">User Actions Report</li>
        </ol>
    </div>
    <!-- END BREADCRUMBS -->
    <!-- BEGIN SIDEBAR CONTENT LAYOUT -->
    <div class="page-content-container">
        <div class="page-content-row">                            
            <div class="page-content-col">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <i class="fa fa-user font-dark"></i>
                                    <span class="caption-subject bold uppercase">Records</span>
                                </div>
                                <div class="tools"> </div>
                            </div>
                            <form action="" method="get">
                            <div class="actions">
                            <div class="form-group form-inline" style="display:inline;margin-right:10px">
                            <label class="control-label">Date From</label>

                                                
                            <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                            <input type="date" name="dateFrom" id="dateFrom" class="form-control">
                            <!-- <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span> -->
                            </div > 
                            <label class="control-label">Date To</label>
            
                            <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                <input type="date" name="dateTo" id="dateTo" class="form-control">
                                <!-- <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span> -->
                            </div>  
                                <label class="control-label" style="margin-right:5px">User Name</label>
                                <select required name="userid" id="userid" class="form-control select2">
                                    <option value="0">-- Select All -- </option>
                                    @foreach($users as $user)
                                    <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                                <input type="submit" name="filter_submit" class="btn btn-success" value="Filter" />  
                                <!-- <button type="button" class="btn green" onclick="window.open('/admin/booking/mondayprint','displayWindow','toolbar=no,scrollbars=yes,width=1000')";><i class="fa fa-print"></i> Print</button> -->

                            </div>
                            
                            </form>
                            
                           <br>
                            <table  class="table table-striped table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Model</th>
                                        <th style="width: 7%">Action</th>
                                        <th style="width: 8%">User</th>
                                        <th style="width: 10%">Date</th>
                                        <th>Old Values</th>
                                        <th>New Values</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach($audits as $audit)
                                        <tr>
                                            <td style="width: 10%">{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                                            <td style="width: 7%">{{ $audit->event }}</td>
                                            @if($audit->user)
                                                <td style="width: 8%">{{ $audit->user->name }}</td>
                                            @else
                                                <td style="width: 8%">No User Name</td>
                                            @endif

                                            <td style="width: 10%">{{ $audit->created_at }}</td>
                                            <td>
                                                @foreach($audit->old_values as $attribute => $value)
                                                    <b>{{ $attribute }}</b></br>
                                                        {{ $value }}
                                                @endforeach
                                                <!-- <table class="table">
                                                    @foreach($audit->old_values as $attribute => $value)
                                                    <tr>
                                                        <td><b>{{ $attribute }}</b></td>
                                                        <td>{{ $value }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table> -->
                                            </td>
                                            <td>
                                            @foreach($audit->new_values as $attribute => $value)
                                                    <b>{{ $attribute }}</b></br>
                                                        {{ $value }}
                                                @endforeach
                                                <!-- <table class="table">
                                                    @foreach($audit->new_values as $attribute => $value)
                                                    <tr>
                                                        <td><b>{{ $attribute }}</b></td>
                                                        <td>{{ $value }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table> -->
                                            </td>
                                        </tr>   
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->                                                                                
                    </div>
                </div>                                                                
                <!-- END PAGE BASE CONTENT -->
            </div>
        </div>
    </div>
    <!-- END SIDEBAR CONTENT LAYOUT -->
@stop
@section('pagejs')
<script type="text/javascript">
    function getReportDetails() {
        const dateFrom = urlParams.get('dateFrom')
        const dateTo = urlParams.get('dateTo')
        var userid = urlParams.get('userid')
        if(userid == null){
            userid = 0
        }
        $('#dateFrom').val(dateFrom);
        $('#dateTo').val(dateTo);
        $('#userid').val(userid);
       
    }
    $(function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const dateFrom = urlParams.get('dateFrom')
        const dateTo = urlParams.get('dateTo')
        var userid = urlParams.get('userid')
        if(userid == null){
            userid = 0
        }
        $('#dateFrom').val(dateFrom);
        $('#dateTo').val(dateTo);
        $('#userid').val(userid);

    // let dateInterval = getQueryParameter('dateFrom','dateTo','userid');
            
        });
    function getQueryParameter(datefrom,dateto,userid) {
        


            // const url = window.location.href;
            // name = name.replace(/[\[\]]/g, "\\$&");
            // const regex = new RegExp("[?&]" + datefrom + "(=([^&#]*)|&|#|$)"),
            //     results = regex.exec(url);
            
            // var dateFrom = decodeURIComponent(results[0].replace(/\+/g, " "));
            // var dateTo = decodeURIComponent(results[1].replace(/\+/g, " "));
            // var userid = decodeURIComponent(results[2].replace(/\+/g, " "));
            // alert(dateFrom);
            // alert(dateTo);
            // alert(userid);
            // // alert(decodeURIComponent(results[1].replace(/\+/g, " ")));
            // if (!results) return null;
            // if (!results[2]) return '';
            // return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

</script>
@stop 