<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_labresultvalues where value like '%$coasearch%' and status <> 'deleted' order by value";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$id = $res2["auto_number"];
	$value = $res2["value"];
	$type = '';
	
		
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$value.'||'.$type.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$value.'||'.$type.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>