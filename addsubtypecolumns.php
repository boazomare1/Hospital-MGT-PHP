<?php
include ("db/db_connect.php");
$querysubtype = "select * from master_subtype where recordstatus <> 'deleted'";
$execsubtype = mysqli_query($GLOBALS["___mysqli_ston"], $querysubtype) or die("Error in Subtypequery ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($ressubtype = mysqli_fetch_array($execsubtype))
{
	echo "<br>".$query ="ALTER TABLE `master_medicine` ADD `subtype_".$ressubtype['auto_number']."`  DOUBLE(13,2) NOT NULL";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Add subtype rate column ".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>