<?php
 
include ("db/db_connect.php");
 
$doc_code = $_REQUEST['docid'];
$app_date = $_REQUEST['app_date'];
 
 $query2 = "SELECT max_appt, doctorname FROM `master_doctor` WHERE `doctorcode`='$doc_code' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$maxappt = $res2['max_appt'];
$docname = $res2['doctorname'];

$query1 = "SELECT count(auto_number) as count_appt FROM `appointmentschedule_entry` WHERE `consultingdoctor`='$docname' and appointmentdate='$app_date' ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$count_appt = $res1['count_appt'];

echo $total_remaining =  $maxappt - $count_appt;
?>