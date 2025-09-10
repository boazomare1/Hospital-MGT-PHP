<?php
session_start();
include ("db/db_connect.php");
$bankname = $_REQUEST["bankname"];
//echo $bankname;
$bankexplode = explode("-",$bankname);
 

//$customersearch = strtoupper($customersearch);

$searchresult = "";
$query2 = "select * from master_bank where bankname = '$bankexplode[0]' and accountnumber = '$bankexplode[1]' and bankstatus ='' order by bankname ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
	$branchname = $res2["branchname"];
	$accountnumber = $res2["accountnumber"];
	$accounttype = $res2["accounttype"];
	
	if ($searchresult == '')
	{
		$searchresult = $branchname .'||'.$accountnumber.'||'.$accounttype;
	}
	else
	{
		$searchresult = $branchname .'||'.$accountnumber.'||'.$accounttype;
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>