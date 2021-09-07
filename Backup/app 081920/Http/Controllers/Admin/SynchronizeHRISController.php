<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Employee;


class SynchronizeHRISController extends Controller
{   

    public function synchronize_davao()
    {        
        $connectionInfodavao = array( "Database"=>"PMC-DAVAO", "UID"=>"sa", "PWD"=>"@Temp123!" );   
        $davao = sqlsrv_connect( "172.16.10.42\PHILSAGA_DB", $connectionInfodavao); 

        $duplicates=array('PMC-A2768','PMC-A2769','PMC-A2770','PMC-A2771','PMC-A2773','PMC-A2774');
              
        $dq=sqlsrv_query($davao,"select * from viewhrempmaster where active=1 and empid not in ('PMC-A2769','PMC-A2770')");

        while( $d=sqlsrv_fetch_array($dq) ) {

            $q=sqlsrv_query($davao,"select * from hrdepartment WHERE DeptID = '".$d['DeptID']."' ");
            
            while($r=sqlsrv_fetch_array($q)){
                
                $ppp = Employee::where('empId', $d['EmpID'])->first();
             
                if($ppp ){
                    if (!in_array($d['EmpID'], $duplicates)){
                        $ppp->update([
                            'empId'     => $d['EmpID'] ,
                            'name'      => mb_convert_encoding( $d['FullName'] , 'UTF-8', 'ISO-8859-1') ,
                            'dept'      => $r['DeptDesc'],
                        ]);
                    }

                } else {
                    if($r['empid']) {
                        Employee::create([
                            'empId'     => $d['EmpID'] ,
                            'name'      => mb_convert_encoding( $d['FullName'], 'UTF-8', 'ISO-8859-1'),
                            'dept'      => $r['deptdesc'],
                            'location'  => 'davao'
                        ]);
                    } else {
                        \Log::info(json_encode($q));
                    }

                }

            }
   
        }

        return back();
    }


    public function synchronize_agusan() {

        $connectionInfoagusan = array( "Database"=>"PMC-AGUSAN-NEW", "UID"=>"sa", "PWD"=>"@Temp123!" );   
        $agusan = sqlsrv_connect( "172.16.20.42\AGUSAN_DB", $connectionInfoagusan);

        $dq=sqlsrv_query($agusan,"select * from viewhrempmaster where active=1");

        while($d=sqlsrv_fetch_array($dq)){

            $q=sqlsrv_query($agusan,"select * from hrdepartment WHERE DeptID = '".$d['DeptID']."' ");

            while($r=sqlsrv_fetch_array($q)){

                $ppp = Employee::where('empId', $d['EmpID'])->first();

                if($ppp){

                    $ppp->update([
                        'empId'     => $d['EmpID'] ,
                        'name'      => mb_convert_encoding( $d['FullName'] , 'UTF-8', 'ISO-8859-1') ,
                        'dept'      => $r['DeptDesc'],
                    ]);     

                } else {

                    if($d['EmpID']) {
                        Employee::create([
                            'empId'     => $d['EmpID'] ,
                            'name'      => mb_convert_encoding( $d['FullName'], 'UTF-8', 'ISO-8859-1'),
                            'dept'      => $r['DeptDesc'],
                            'location'  => 'agusan'
                        ]);
                    } else {
                        \Log::info(json_encode($q));
                    }

                }

            }
        }

        return back();
    }

}