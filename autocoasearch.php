<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";
$searchresultsub = "";

$query2 = "select * from master_accountname where accountname like '%$coasearch%' and recordstatus <> 'deleted' order by accountname";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$id = $res2["id"];
	$accountname = $res2["accountname"];
	$accountsmain = $res2["accountsmain"];
	$accountssub = $res2["accountssub"];
	
	$query21 = "select * from master_accountsmain where auto_number='$accountsmain'";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res21 = mysqli_fetch_array($exec21);
	$type = $res21['section'];
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$accountname.'||'.$type.'||'.$accountssub.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$accountname.'||'.$type.'||'.$accountssub.'';
	}
	
}

$query25 = "select * from master_accountssub where accountssub like '%$coasearch%' and recordstatus <> 'deleted' order by accountssub";
$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res25 = mysqli_fetch_array($exec25))
{
	$id2 = $res25["id"];
	$accountssub = $res25["accountssub"];
	$accountsmain2 = $res25["accountsmain"];
	$group = $res25['auto_number'];
	
	$query26 = "select * from master_accountsmain where auto_number='$accountsmain2'";
	$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res26 = mysqli_fetch_array($exec26);
	$type2 = $res26['section'];
	
	
	if ($searchresultsub == '')
	{
		$searchresultsub = ''.$id2.'||'.$accountssub.'||'.$type2.'||'.$group.'';
	}
	else
	{
		$searchresultsub = $searchresultsub.'||^||'.$id2.'||'.$accountssub.'||'.$type2.'||'.$group.'';
	}
	
}

if ($searchresult != '' && $searchresultsub != '')
{
	echo $searchresult.'||^||'.$searchresultsub;
}
else if($searchresult != '' && $searchresultsub == '')
{
	echo $searchresult;	
}
else if($searchresult == '' && $searchresultsub != '')
{
	echo $searchresultsub;	
}

?>