<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_subtype where subtype like '%$coasearch%' and maintype = '3' and recordstatus <> 'deleted' order by subtype";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$id = $res2["auto_number"];
	$accountname = $res2["subtype"];
	$accountsmain = $res2["maintype"];
	
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$accountname.'||'.$accountsmain.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$accountname.'||'.$accountsmain.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>