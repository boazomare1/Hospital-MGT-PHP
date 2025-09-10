<?php
session_start();
include ("db/db_connect.php");
$referalsearch = $_REQUEST["referalsearch"];
$locationcode=$_REQUEST['locationcode'];
$subtype=isset($_REQUEST['subtype'])?$_REQUEST['subtype']:'1';
//$medicinesearch = strtoupper($medicinesearch);
$searchresult7 = "";
$query7 = "select * from master_doctor where doctorcode = '$referalsearch' AND locationcode = '".$locationcode."' order by doctorname";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res7 = mysqli_fetch_array($exec7))
{
	$itemcode7 = $res7["doctorcode"];
	$itemname7 = $res7["doctorname"];
    $itemname7 = strtoupper($itemname7);
    $rateperunit7 = $res7["consultationfees"];
	$query71 = "select fxrate from master_subtype where auto_number = '$subtype'";
$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));
$res71 = mysqli_fetch_array($exec71);
$fxrate = $res71['fxrate'];
	$rateperunit7 = round($rateperunit7/$fxrate);

	// Get doctor available weekdays
	$query_weeks = "select weekday_id from doctor_weekdays where doctor_code = '$referalsearch'";
	$exec_weeks = mysqli_query($GLOBALS["___mysqli_ston"], $query_weeks) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));
	$week_numrows = mysqli_num_rows($exec_weeks);
	$weekdayids_str = "";
	if($week_numrows)
	{
		while ($res_weeks = mysqli_fetch_array($exec_weeks))
		{
			$weekdays_id_arr[] = $res_weeks['weekday_id'];
		}
		$weekdayids_str = implode("_",$weekdays_id_arr);
	}

	if ($searchresult7 == '')
	{
	    $searchresult7 = ''.$itemcode7.'||'.$itemname7.'||'.$rateperunit7.'||'.$weekdayids_str.'||';
	}
	else
	{
		$searchresult7 = $searchresult.'||^||'.$itemcode7.'||'.$itemname7.'||'.$rateperunit7.'||'.$weekdayids_str.'||';
	}
	
}
if ($searchresult7 != '')
{
 echo $searchresult7;
}
?>