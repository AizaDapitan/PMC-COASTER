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
              
            $q=sqlsrv_query($davao,"select e.empid,e.fullname,d.deptdesc From viewhrempmaster e left join hrdepartment d on d.deptid=e.deptid where  empid not in ('PMC-A2769','PMC-A2770')");

            while( $r=sqlsrv_fetch_array($q) ) {

                $ppp = Employee::where('empid', $r['empid'])->first();
             
                if($ppp ){

                    if (!in_array($r['empid'], $duplicates)){
                        $ppp->update([
                            'empId'     => $r['empid'] ,
                            'name'      => mb_convert_encoding( $r['fullname'] , 'UTF-8', 'ISO-8859-1') ,
                            'dept'      => $r['deptdesc'],
                        ]);
                    }

                } else {
                    if($r['empid']) {
                        Employee::create([
                            'empId'     => $r['empid'] ,
                            'name'      => mb_convert_encoding( $r['fullname'], 'UTF-8', 'ISO-8859-1'),
                            'dept'      => $r['deptdesc'],
                            'location'  => 'davao'
                        ]);
                    } else {
                        dd($r);
                        \Log::info(json_encode($q));
                    }

                }
       
            }

        return back();
    }


    public function synchronize_agusan() {

        $connectionInfoagusan = array( "Database"=>"PMC-AGUSAN-NEW", "UID"=>"sa", "PWD"=>"@Temp123!" );   
        $agusan = sqlsrv_connect( "172.16.20.42\AGUSAN_DB", $connectionInfoagusan);
        $dq=sqlsrv_query($agusan,"select distinct deptid from viewhrempmaster where active=1");

        while($d=sqlsrv_fetch_array($dq)){
            
            $q=sqlsrv_query($agusan,"select e.empid,e.fullname,d.deptdesc From viewhrempmaster e left join hrdepartment d on d.deptid=e.deptid where e.active=1 and e.deptid='".$d['deptid']."' ORDER BY e.empid");
            
            while($r=sqlsrv_fetch_array($q)){

                $ppp = Employee::where('empid', $r['empid'])->first();
             
                if($ppp ){

                    $ppp->update([
                        'empId'     => $r['empid'] ,
                        'name'      => mb_convert_encoding( $r['fullname'] , 'UTF-8', 'ISO-8859-1') ,
                        'dept'      => $r['deptdesc'],
                    ]);     

                } else {
                    if($r['empid']) {
                        Employee::create([
                            'empId'     => $r['empid'] ,
                            'name'      => mb_convert_encoding( $r['fullname'], 'UTF-8', 'ISO-8859-1'),
                            'dept'      => $r['deptdesc'],
                            'location'  => 'davao'
                        ]);
                    } else {
                        dd($r);
                        \Log::info(json_encode($q));
                    }

                }

            }
        }

        return back();
    }

}