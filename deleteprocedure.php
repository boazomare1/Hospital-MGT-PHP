<?php

include ("db/db_connect.php");







	if($_POST['id'])
{

//$query3 = "DELETE FROM master_theatre_booking WHERE auto_number = '$delanum' ";
	$id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
	echo $id;

	$query4 = "DELETE FROM theatre_booking_proceduretypes WHERE auto_number='$id'";

	/*echo $query3;

	exit;*/
	//$query4 = "DELETE FROM master_theatre_equipments WHERE theatrebookingcode = '$delanum' ";
    
	//echo $query3;

	//exit;

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
}

?>