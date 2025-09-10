<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = strtoupper(trim(strip_tags($_GET['term']))); 
//echo $term;
$a_json = array();
$a_json_row = array();
//$a_json_row["value"] = $term;
//array_push($a_json, $a_json_row);
$query2 = "select auto_number,id,accountname,accountssub from master_accountname where accountsmain  in ('4') and recordstatus <> 'deleted' and accountname LIKE '%".$term."%'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
//$a_json_row["value"] = $exec2;
//array_push($a_json, $a_json_row);

while ($res2 = mysqli_fetch_array($exec2))
{
	$accountname = $res2['accountname'];	  
	$saccountauto = $res2['auto_number'];
	$saccountid = $res2['id'];
	$sub = $res2['accountssub'];
	
	$query = mysqli_query($GLOBALS["___mysqli_ston"], "select accountssub from master_accountssub where auto_number = '$sub'");
	$res = mysqli_fetch_array($query);
	$accsub = $res['accountssub'];
	
	$accountname = preg_replace('/,/', ' ', $accountname); 
	
	$a_json_row["value"] = $accountname;
	$a_json_row["label"] = $accountname.' | '.$accsub;
	$a_json_row["saccountauto"] = $saccountauto;
	$a_json_row["saccountid"] = $saccountid;
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>
