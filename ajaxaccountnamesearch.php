<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();

$query2 = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountname like '%$term%' and recordstatus='ACTIVE'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))
{
	$accountname = $res2['accountname'];	  
	$saccountauto = $res2['auto_number'];
	$saccountid = $res2['id'];
	$sub = $res2['accountssub'];
	$accountsmain = $res2['accountsmain'];
	
	$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select accountsmain from master_accountsmain where auto_number = '$accountsmain'");
	$res1 = mysqli_fetch_array($query1);
	$accmain = $res1['accountsmain'];
	
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select accountssub from master_accountssub where auto_number = '$sub'");
	$res = mysqli_fetch_array($query);
	$accsub = $res['accountssub'];
	
	$accountname = preg_replace('/,/', ' ', $accountname); 
	
	$a_json_row["value"] = $accountname;
	$a_json_row["label"] = $saccountid.' | '.$accountname.' | '.$accmain.' | '.$accsub;
	$a_json_row["saccountauto"] = $saccountauto;
	$a_json_row["saccountid"] = $saccountid;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>