<?php
session_start();
include ("db/db_connect.php");
$referalsearch = $_REQUEST["referalsearch"];
$patienttype = $_REQUEST["patienttype"];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult7 = "";
$query7 = "select * from master_surgery where auto_number = '$referalsearch' order by surgery";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res7 = mysqli_fetch_array($exec7))
{
	
	$surgery = $res7["surgery"];
    $surgery = strtoupper($surgery);
    if($patienttype == 'INSURANCE')
	{
    $rateperunit7 = $res7["rate2"];
	}
	else if($patienttype == 'MICRO INSURANCE')
	{
	 $rateperunit7 = $res7["rate3"];
	}
	else
	{
	$rateperunit7 = $res7["rate"];
	}
	
	if ($searchresult7 == '')
	{
	    $searchresult7 = ''.$surgery.'||'.$rateperunit7.'||';
	}
	else
	{
		$searchresult7 = $searchresult.'||^||'.$surgery.'||'.$rateperunit7.'||';
	}
	
}
if ($searchresult7 != '')
{
 echo $searchresult7;
}
?>