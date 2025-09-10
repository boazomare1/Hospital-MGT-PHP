<?php
include ("includes/loginverify.php");
include ("db/db_connect.php");
?>
<?php
function doTask($fromDate12)
 {
$snocount = "";
$range = "";
$tot1 = "00";
$tot2 = "00";
$awt = "0.00";

$query2 = "select * from master_visitentry where consultationdate ='$fromDate12' order by consultationdate ";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2patientfullname = $res2['patientfirstname'];
		  $res2consultationdate = $res2['consultationdate'];
		  $res2visitcode = $res2['visitcode'];
		  $res2consultationtime = $res2['consultationtime'];
		  $res2accountfullname = $res2['accountfullname'];
		  $res2patientcode = $res2['patientcode'];
		  if($res2consultationtime == '')
		  {
		  $res2consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res2consultationtime = $res2['consultationtime'];
		  }
		  $res2consultationtime1 = strtotime($res2consultationtime);
		  
		  $query3 = "select * from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billingdatetime  ='$fromDate12'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3billnumber = $res3['billnumber'];
		  $res3consultationtime = $res3['consultationtime'];
		  if($res3consultationtime == '')
		  {
		  $res3consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res3consultationtime = $res3['consultationtime'];
		  }
		  $res3consultationtime1 = strtotime($res3consultationtime);
		  
		  $query4 = "select * from master_triage where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and registrationdate ='$fromDate12'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in quey4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4consultationtime = $res4['consultationtime'];
		  if($res4consultationtime == '')
		  {
		  $res4consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res4consultationtime = $res4['consultationtime'];
		  }
		  $res4consultationtime1 = strtotime($res4consultationtime);
		  
		  $query5 = "select * from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate  ='$fromDate12'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  $res5entrytime = $res5['entrytime'];
		  if($res5entrytime == '')
		  {
		  $res5entrytime = "00:00:00";
		  }
		  else
		  {
		  $res5entrytime = $res5['entrytime'];
		  }
		  $res5entrytime1 = strtotime($res5entrytime);
		  
		  $query6 = "select * from process_service where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate ='$fromDate12'";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
		  $res6recordtime = $res6['recordtime'];
		  if($res6recordtime == '')
		  {
		  $res6recordtime = "00:00:00";
		  }
		  else
		  {
		  $res6recordtime = $res6['recordtime'];
		  }
		  $res6recordtime1 = strtotime($res6recordtime);
		  
		  $query7 = "select * from resultentry_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate  ='$fromDate12'";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res7 = mysqli_fetch_array($exec7);
		  $res7recordtime = $res7['recordtime'];
		  if($res7recordtime=='')
		  {
		  $res7recordtime = "00:00:00";
		  }
		  else
		  {
		  $res7recordtime = $res7['recordtime'];
		  }
		  $res7recordtime1 = strtotime($res7recordtime);
		  
		  $query8 = "select * from samplecollection_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate ='$fromDate12'";
		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res8 = mysqli_fetch_array($exec8);
		  $res8recordtime = $res8['recordtime'];
		  //echo $splittedstring=explode(":",$res8recordtime,2);
          if ($res8recordtime == '')
		  {
		  $res8recordtime = "00:00:00";
		  }
		  else
		  {
		  $res8recordtime = $res8['recordtime'];
		  }
		  $res8recordtime1 = strtotime($res8recordtime);
		  
		  $query9 = "select * from master_consultation where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and recorddate  ='$fromDate12'";
		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res9 = mysqli_fetch_array($exec9);
		  $res9consultationtime = $res9['consultationtime'];
		  //echo $splittedstring=explode(":",$res8recordtime,2);
          if ($res9consultationtime == '')
		  {
		  $res9consultationtime = "00:00:00";
		  }
		  else
		  {
		  $res9consultationtime = $res9['consultationtime'];
		  }
		  $res9consultationtime1 = strtotime($res9consultationtime);
		  
		   $highest_time = max($res9consultationtime, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);
		   //$lowest_time = min($res2consultationtime1,$res3consultationtime1, $res4consultationtime1, $res5entrytime1, $res6recordtime1, $res7recordtime1 , $res8recordtime1);
		  
		  $highest_time1 = date("H:i:s", $highest_time); 
		  $lowest_time1 = date("H:i:s", $res2consultationtime1);
		 //echo $t = date("H:i",120);
		 //$tot =  $highest_time1 - $lowest_time1;
		 $exe = explode(":",$highest_time1);
		 $exe1 = explode(":",$lowest_time1);
		 $exe2 = $exe[0] - $exe1[0];
		 $exe3 = $exe[1] - $exe1[1];
		 $exe4 = $exe[2] - $exe1[2];
		 $length = strlen($exe2);
		 $length1 = strlen($exe3);
		 
		 
		 if($length == '1')
		 {
		  $exe2 = '0'. $exe2;
		 }
		 
		 if($length1 == '1')
		 {
		 $exe3 = '0'.$exe3;
		 }
		 
		 if($exe2 < 0)
		 {
		 $exe2 = '00';
		 }
		 
		 if($exe3 < 0)
		 {
		 $exe3 = '00';
		 }
		 
		 $tot1 = $tot1 + $exe2;
		 $tot2 = $tot2 + $exe3;
		 
		 $length2 = strlen($tot1);
		 $length3 = strlen($tot2);
		 
		 if($length2 == '1')
		 {
		 $tot1 = '0'. $tot1;
		 }
		 
		 if($length3 == '1')
		 {
		 $tot2 = '0'. $tot2;
		 }
		 
		 $exe5 = $exe2 * 3600;
		 $exe6 = $exe3 * 60;
		 $exe7 = $exe5 + $exe6;
		 
		  $snocount = $snocount + 1;		
	       $exe8 = $exe7 / $snocount;
	       }
		   
		$awt = $tot2/$snocount;
		if($awt=='') { $awt=0; }
		return $awt;	
}
?>