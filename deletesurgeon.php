<?php

include ("db/db_connect.php");







	if($_POST['id'])
{

//$query3 = "DELETE FROM master_theatre_booking WHERE auto_number = '$delanum' ";
	$id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
	echo $id;

	$query3 = "DELETE FROM theatre_booking_surgeons WHERE auto_number='$id'";

	/*echo $query3;

	exit;*/
	//$query4 = "DELETE FROM master_theatre_equipments WHERE theatrebookingcode = '$delanum' ";
    
	//echo $query3;

	//exit;

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}

?>