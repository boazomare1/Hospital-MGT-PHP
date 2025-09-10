<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_accountname where accountsmain IN ('1','3') and accountssub in (select auto_number from master_accountssub where parentid = '0') and accountname like '%$coasearch%' and recordstatus <> 'deleted' order by accountname";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$id = $res2["id"];
	$accountname = $res2["accountname"];
	$accountsmain = $res2["accountsmain"];
	$accountssub1=$res2["accountssub"];
	
	$query22 = "select * from master_accountssub where auto_number='$accountssub1'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res22 = mysqli_fetch_array($exec22);
	$type = $res22['accountssub'];
	
	$query21 = "select * from master_accountsmain where auto_number='$accountsmain'";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res21 = mysqli_fetch_array($exec21);
	//$type = $res21['section'];
	
	
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