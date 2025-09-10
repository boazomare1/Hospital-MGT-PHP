<?php
 
include ("db/db_connect.php");
 
$doc_code = $_REQUEST['docid'];
 
 $query2 = "SELECT max_appt, doctorname, department FROM `master_doctor` WHERE `doctorcode`='$doc_code' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$maxappt = $res2['max_appt'];
$docname = $res2['doctorname'];
$departmentanum = $res2['department'];


$query5 = "select auto_number,department from master_department where recordstatus = '' and auto_number='$departmentanum' ";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$departmentid = $res5["auto_number"];
				$departmentname = $res5["department"];
			}

echo $total_remaining =  $maxappt.'||'.$departmentid.'||'.$departmentname;
?>