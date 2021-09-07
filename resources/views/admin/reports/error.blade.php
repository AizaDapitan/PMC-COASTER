@extends('main')
@section('pageBodyClass', 'corporate')
@section('pagecss')


<!-- Theme styles START -->
<link href="google.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/metronic/assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('theme/metronic/assets/global/plugins/bootstrap-datetimepicker/css/datetimepicker.css') }}" />

<!-- Theme styles END -->
@endsection
@section('content')

@include('layouts.header')


<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="main">
    <div class="container">
        <div class="col-md-12 tab-style-1">
            <!-- BEGIN BREADCRUMBS -->
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/admin/booking') }}">Home</a></li>
                    <li class="active">Error Logs Report</li>
                </ol>

                <h1>ERROR LOGS REPORT</h1>
            </div>
            <!-- END BREADCRUMBS -->
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
                                    </div>
                                    <label class="control-label">Date To</label>

                                    <div class="input-group input-medium date date-picker" data-date="{{ today() }}" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                        <input type="date" name="dateTo" id="dateTo" class="form-control">
                                        <!-- <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span> -->
                                    </div>
                                    <input type="submit" name="filter_submit" class="btn btn-success" value="Filter" />
                                </div>
                        </form>
                        <div class="pull-right">
                            {!! $errors->previousPageUrl() ? '<a href='. $errors->previousPageUrl().'>Previous Page</a>' : '' !!}
                            {!! $errors->nextPageUrl() ? '&nbsp;&nbsp;<a href='. $errors->nextPageUrl().'>Next Page</a>' : ''!!}
                        </div>
                        <div class="portlet-body">
                            <br>
                            <table class="table table-striped table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 20%">Message</th>
                                        <th style="width: 8%">Level</th>
                                        <th style="width: 8%">Level Name</th>
                                        <th style="width: 10%">DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($errors as $error)
                                    <tr>
                                        <td style="width: 10%">{{ $error->id }}</td>
                                        <td style="width: 20%">{{ $error->message }}</td>
                                        <td style="width: 8%">{{ $error->level }}</td>
                                        <td style="width: 10%">{{ $error->level_name  }}</td>
                                        <td style="width: 10%">{{ $error->datetime  }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="pull-right">
                                {{ $errors->links() }}
                            </div>
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
    $(function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const dateFrom = urlParams.get('dateFrom')
        const dateTo = urlParams.get('dateTo')
        $('#dateFrom').val(dateFrom);
        $('#dateTo').val(dateTo);
    });
</script>
@stop