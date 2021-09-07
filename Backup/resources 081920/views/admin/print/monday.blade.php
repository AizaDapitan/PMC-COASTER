<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>PMC - Coaster Booking System</title>

</head>
<body onload="window.print();">
<table width="100%">
	<tr>
		<td><font color="blue" size="+1">PHILSAGA MINING CORPORATION</font><br>
Purok 1-A, Bayugan 3, Rosario, Agusan del Sur<br><br></td>
		<td align="right" style="font-size:11px;" valign="top">{{ $today }}</td>
	</tr>
</table>
<table width="100%" style="font-family:Arial;font-size:12px;">
    <tr>
        <td colspan="6" align="center" style="font-size:14px;font-weight:bold;">SHUTTLE BUS MANIFEST <br>Date Prepared: {{ $today }}</td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
      <td colspan="6">
        <table width="100%" style="font-size:14px;">
          <tr>
            <td>Departure from Davao to Mill site </td>
            <td>Date: <u>{{$monSchedString ? $monSchedString->format('Y-m-d') : '' }}</u></td>
            <td>Time: <u>04:00 AM</u></td>
          </tr>
        </table>
      </td>
    </tr>
     <tr><td>&nbsp;</td></tr>
    <tr style="font-weight:bold;color:blue;">
         <td>Seat No.</td>
          <td>ID</td>
          <td>Name</td>
          <td>Password</td>
          <td>Origin</td>
          <td>Signature</td>
    </tr>
    <tr><td>&nbsp;</td></tr>        
        @for ($i = 1; $i <= config('constant.totalNumberOfSeat'); $i++)     
            <tr style='background-color:{{$i % 2 ? "#FCF3CF" : "#ffffff"}}'>
                <td>{{$i}}</td>
                @if(in_array($i, $bookingSeatsMonday)) 
                    <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->employee->empId }}</td>
                    <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->employee->name }}</td>
                    <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->pword }}</td>
                    <td>{{ $bookingsMonday[array_search($i, $bookingSeatsMonday)]->destination }}</td>
                    <td>__________</td>
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
      
      </table>       
    <table style="font-family:Arial;font-size:12px;" width="100%">
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
    <td colspan="2">Prepared by:</td>
      
    <td colspan="2">Approved by:</td>
    </tr>
  <tr>
        <!-- <td colspan="2"><br><br><u>RAQUEL S. MACARAYA</u></td> -->
        <td colspan="2"><br><br><u>PRINCESS MAE E. TANO</u></td>
  
     <!-- <td colspan="2"><br><br><u>ENGR. EVANGELINE S. SALVAÑA</u></td> -->
     <td colspan="2"><br><br><u>CLAIRE A. AMARILLENTO</u></td>
    </tr>
    <tr>
    <td colspan="2">RECORDS PROPERTY CUSTODIAN</td>
      
    <!-- <td colspan="2">ENVIRONMENT GEN. SERVICES MANAGER</td> -->
    <td colspan="2">GSD MANAGER</td>
    
    </tr>
</table>


