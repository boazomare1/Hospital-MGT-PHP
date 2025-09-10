<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_accountname where accountname like '%$coasearch%' and accountssub = '2' and recordstatus <> 'deleted' order by accountname";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$id = $res2["id"];
	$accountname = $res2["accountname"];
	$accountsmain = $res2["accountsmain"];
	
	$query21 = "select * from master_accountsmain where auto_number='$accountsmain'";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res21 = mysqli_fetch_array($exec21);
	$type = $res21['section'];
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$accountname.'||'.$type.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$accountname.'||'.$type.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>