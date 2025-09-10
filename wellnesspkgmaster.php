<?php
include ("db/db_connect.php");
$updatedatetime = date('Y-m-d H:i:s');
$st = 0;
$qrycheckhc = "select * from master_services where status <> 'deleted'";
$execcheckhc = mysqli_query($GLOBALS["___mysqli_ston"], $qrycheckhc) or die("Error in Qrycheckhc ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($rescheckhc = mysqli_fetch_array($execcheckhc))
{
	$serid = $rescheckhc['itemcode'];
	echo "<br>".$services = $rescheckhc['itemname'];

}
echo $st;
?>