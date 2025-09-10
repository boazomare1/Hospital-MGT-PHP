<?php
 
include ("db/db_connect.php");
 
$doc_code = $_REQUEST['docid'];
$appt_value = $_REQUEST['max_appt_value'];
 
 $query2 = "UPDATE `master_doctor` SET `max_appt`='$appt_value' where `doctorcode`='$doc_code' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
// $res2 = mysql_fetch_array($exec2);
// $maxappt = $res2['max_appt'];
// $docname = $res2['doctorname'];

// echo $total_remaining =  $maxappt;
?>