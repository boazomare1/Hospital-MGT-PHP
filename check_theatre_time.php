<?php
include ("db/db_connect.php");
$theatre = $_REQUEST['theatre'];
$date = $_REQUEST['date'];
$patientcode = $_REQUEST['pcode'];
$t = $_REQUEST['time'];

$time = '+'.$t.' minutes';
//echo $time.'<br>';

$from_date = date('Y-m-d H:i:s', strtotime($date));
// Output
$to_date = date('Y-m-d H:i:s', strtotime($time, strtotime($date)));


//$query_s = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and surgerydatetime between '$date' and '$to_date'AND patientcode != '$patientcode' GROUP BY approvalstatus LIMIT 1";
//$query_s = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and (surgerydatetime between '$from_date' and '$to_date') OR (estimated_endtime between '$from_date' and '$to_date')  GROUP BY approvalstatus LIMIT 1";
//$query_s = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and ('$from_date' between surgerydatetime and estimated_endtime) or ('$to_date' between surgerydatetime and  estimated_endtime)  GROUP BY approvalstatus LIMIT 1";
  $query_s = "SELECT * FROM master_theatre_booking WHERE ('$from_date' between surgerydatetime and estimated_endtime and theatrecode ='$theatre' AND approvalstatus = 'Pending') or ('$to_date' between surgerydatetime and  estimated_endtime and theatrecode ='$theatre' AND approvalstatus = 'Pending')  GROUP BY approvalstatus LIMIT 1";
//echo $query_s;
$exec_s = mysqli_query($GLOBALS["___mysqli_ston"], $query_s) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
$check_rows = mysqli_num_rows($exec_s);
while ($res_s = mysqli_fetch_assoc($exec_s))
{   
 $id = $res_s['approvalstatus'];

   /* 
	$sug_date_time = date('Y-m-d H:i:s', strtotime($res_s['surgerydatetime']));
	$est_time = $res_s['estimatedtime'];
    
    $t = '+'.$est_time.' minutes';
	$nw_dat_time = date('Y-m-d H:i:s', strtotime($t, strtotime($sug_date_time)));
	// perform time checks here
	$query_ss = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and surgerydatetime >= '$sug_date_time' and surgerydatetime <='$nw_dat_time'  GROUP BY approvalstatus LIMIT 1";
	//echo $query_ss;
    $exec_ss = mysql_query($query_ss) or die ("Error in Query_ss".mysql_error());
    while ($res_ss = mysql_fetch_assoc($exec_ss)){
	    $id = $res_ss['approvalstatus'];
	    echo $id;
    }*/
}
echo $check_rows;
?>
