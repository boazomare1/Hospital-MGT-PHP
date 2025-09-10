<?php

include ("db/db_connect.php");

$reason=$_REQUEST['reason'] ;
$selectedReason=$_REQUEST['selectedReason'] ;
$bookingreason_code=$_REQUEST['bookingreason_code'] ;
	if($reason<>''){
	$query3 = "INSERT INTO `theatre_panel_late reason` (`booking_id`,`late_reason`,`selectreason`) VALUES('$bookingreason_code', '$reason','$selectedReason')";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	}
?>