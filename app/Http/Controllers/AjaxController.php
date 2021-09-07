<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Schedule;
use App\Employee;
use App\Booking;

class AjaxController extends Controller
{
    public function getIndex(Request $request)
    {
        // dd($request->act);
        if ($request->act == 'selectseat') {
            $data = '';
            $data .= '
        <form method="post" name="frmsat" id="frmsat" onsubmit="return validateForm();">
        <input name="_token" value="' . csrf_token() . '" type="hidden">
        <div class="portlet red-intense box">
            <div class="portlet-title">			
                <div class="caption" id="namehere">
                    <input type="hidden" name="empnamed" id="empnamed" value="">
                    <input type="hidden" name="def_add" id="def_add" value="">
                    <i class="fa fa-tachometer"></i>Booking Details
                </div>
                <div class="tools">				
                    <a href="javascript:;" class="remove">
                    </a>
                </div>
            </div>
            <div class="portlet-body">
            
                    <input type="hidden" name="sitd" id="sitd" value="' . $request->sitno . '">
                    
                <table width="100%">
                    <tr>
                        <td><h3>Seat no: ' . $request->sitno . '</h3></td>
                        <td>					
                            <input type="text" name="employeed" id="employeed" class="form-control" placeholder="ID number (eg. A9999)" onkeyup="if($(this).val().length > 3){showname($(this).val());};" onchange="if($(this).val().length > 3){showname($(this).val());};">						
                        </td>					
                        <td>
                            <select class="form-control" name="destinationd" id="destinationd" onchange="">
                                <option value="" selected="selected"> - Destination -</option>
                                <option value="Bunawan">Bunawan</option>
                                <option value="Trento">Trento</option>
                                <option value="Monkayo">Monkayo</option>
                                <option value="Montevista">Montevista</option>
                                <option value="Nabunturan">Nabunturan</option>
                                <option value="Mawab">Mawab</option>
                                <option value="Tagum">Tagum</option>
                                <option value="Carmen">Carmen</option>
                                <option value="Panabo">Panabo</option>
                                <option value="Davao">Davao</option>
                            </select>
                        </td>
                        <td><input type="submit" class="btn red pull-right" value="Submit"></td>
                    </tr>				
                </table>				
            
            
            </div>
        </div>
        </form>
        <script>
                function validateForm() {			
                    var x = document.forms["frmsat"]["employeed"].value;
                    var d = document.forms["frmsat"]["destinationd"].value;
                    var ne = document.forms["frmsat"]["empnamed"].value;			
                    var j=0;
                    if (x == null || x == "") {
                        alert("Please enter your employee ID!");
                        return false;
                        j=1;
                    }
                    if (d == null || d == "") {
                        alert("Please select your destination!");
                        return false;
                        j=1;
                    }
                    if (ne == null || ne == "") {
                        alert("No Employee Record Found! Please contact GSD office.");
                        return false;
                        j=1;
                    }
                    if(j==0){
                        showconfirmation(document.forms["frmsat"]["employeed"].value,document.forms["frmsat"]["destinationd"].value,document.forms["frmsat"]["sitd"].value,document.forms["frmsat"]["empnamed"].value,document.forms["frmsat"]["def_add"].value,document.forms["frmsat"]["_token"].value);
                         return false;
                    }
                }
            </script>
        ';
            return $data;
        } elseif ($request->act == 'searchbooking' || $request->act == 'searchbookingMon') {
            $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
            $satSchedString = new Carbon($satSched->travel_date);
            $satFormat = $satSchedString->format('Y-m-d');

            $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
            $monSchedString = new Carbon($monSched->travel_date);
            $monFormat = $monSchedString->format('Y-m-d');

            if ($request->act == 'searchbookingMon') {
                $bookings = Booking::where('pword', $request->pword)->where('sched', $monFormat)->first();
                $travelDayFormat = $monSchedString->format('Y-m-d');
            } else {
                $bookings = Booking::where('pword', $request->pword)->where('sched', $satFormat)->first();
                $travelDayFormat = $satSchedString->format('Y-m-d');
            }


            if (!$bookings) {
                return "No Record Found for this password.<br> You may contact GSD to ask for your password";
            } else {
                $data = '';
                $data .= '
                    <br>Seat no: ' . $bookings->seatNumber . '(' . $bookings->employee->empId . ')
                    <br><br>
                    <form method ="POST" action="' . env('APP_URL') . '/booking/' . $bookings->pword . '">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="travelDayFormat" type="hidden" value="' . $travelDayFormat . '">
                        <input name="_token" value="' . csrf_token() . '" type="hidden">
                        <button class="btn red btn-sm" id="show_confirm" type="submit">Cancel Booking</button>
                    </form>

                    <script type="text/javascript">
                        $("#show_confirm").click(function(e) {
                            if(!confirm("Are you sure you want to Cancel this Booking?")) {
                                e.preventDefault();
                            }
                            window.parent.location = "' . url('/') . '";
                        });
                    </script>
                ';
                return $data;
            }
        } elseif ($request->act == 'getname') {
            $emp = Employee::where('empId', $request->empId)->where('isNotActive', '=', '0')->first();
            if (!$emp) {
                return "No Record Found for this ID<input type='hidden' name='empnamed' id='empnamed' value=''><input type='hidden' name='def_add' id='def_add' value=''>";
            } else {
                return "<strong style='color:black;'>" . strtoupper($emp->empId) . " - " . $emp->name . "</strong><input type='hidden' name='empnamed' id='empnamed' value='" . $emp->name  . "'><input type='hidden' name='def_add' id='def_add' value='" . $emp->address1  . "'>";
            }
        }
    }
}
