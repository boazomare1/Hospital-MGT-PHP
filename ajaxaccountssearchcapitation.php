<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select id,auto_number,accountname,expirydate,accountssub from master_accountname where (accountssub IN ('46','50','51','52') or accountsmain IN ('1','4')) and accountname like '%$term%' and recordstatus <> 'Deleted'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{  
	$id = $res1['id'];
	$auto_number=$res1['auto_number'];
	$accountname = $res1['accountname'];
	
	$querys = "select accountssub from master_accountssub where auto_number = '".$res1['accountssub']."'";
	$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $querys) or die ("Error in Querys".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1s = mysqli_fetch_array($exec1s);
	$accountssub = $res1s['accountssub'];
	
	$id = addslashes($id);
	
	$auto_number = addslashes($auto_number);

	$accountname = strtoupper($accountname);
	
	$id = preg_replace('/,/', ' ', $id);
	$accountname = preg_replace('/,/', ' ', $accountname);
	
	$a_json_row["id"] = $id;
	$a_json_row["auto_number"] = $auto_number;
	$a_json_row["accountname"] = $accountname;
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($id).'#'.$accountname.' || '.$accountssub;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>