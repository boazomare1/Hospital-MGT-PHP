<?php
include ("db/db_connect.php");
$theatre = $_REQUEST['theatre'];
$date = $_REQUEST['date'];
$patientcode = $_REQUEST['pcode'];
$t = $_REQUEST['time'];

$time = '+'.$t.' minutes';
//echo $time;

$from_date = date('Y-m-d H:i:s', strtotime($date));
// Output
$to_date = date('Y-m-d H:i:s', strtotime($time, strtotime($date)));


//$query_s = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and surgerydatetime between '$date' and '$to_date'AND patientcode != '$patientcode' GROUP BY approvalstatus LIMIT 1";
//$query_s = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and surgerydatetime between '$from_date' and '$to_date' AND patientcode != '$patientcode' GROUP BY approvalstatus LIMIT 1";
//$query_s = "SELECT * FROM master_theatre_booking WHERE theatrecode ='$theatre' AND approvalstatus = 'Pending' and ('$from_date' between surgerydatetime and estimated_endtime) or ('$to_date' between surgerydatetime and  estimated_endtime) and patientcode != '$patientcode' GROUP BY approvalstatus LIMIT 1";
$query_s = "SELECT * FROM master_theatre_booking WHERE ('$from_date' between surgerydatetime and estimated_endtime and theatrecode ='$theatre' AND approvalstatus = 'Pending') or ('$to_date' between surgerydatetime and  estimated_endtime and theatrecode ='$theatre' AND approvalstatus = 'Pending') and patientcode != '$patientcode' GROUP BY approvalstatus LIMIT 1";
//echo $query_s;
$exec_s = mysqli_query($GLOBALS["___mysqli_ston"], $query_s) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res_s = mysqli_fetch_assoc($exec_s))
{  
	$id = $res_s['approvalstatus'];
	echo $id;
}
?>
