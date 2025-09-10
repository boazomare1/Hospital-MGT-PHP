<?php
//session_start();
include ("db/db_connect.php");

 $process=$_REQUEST['process'];

if($process=='scheme')
{
$scheme = trim($_REQUEST['term']);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;

$a_json = array();
$a_json_row = array();
$query1 = "select * from master_accountname where accountname like '%$scheme%' and accountssub='46' and recordstatus <> 'deleted' limit 0,10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$accountname = $res1['accountname'];
	$accountauto=$res1['auto_number'];	
	
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname);
	
	$a_json_row["accountauto"] = trim($accountauto);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
}
/*if($process=='patient')
{
$patient = trim($_REQUEST['term']);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;

$a_json = array();
$a_json_row = array();
$query1 = "select * from master_customer where customername like '%$patient%' limit 0,10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$customerfullname = $res1['customerfullname'];
	$customercode=$res1['customercode'];
		
	
	$a_json_row["value"] = trim($customerfullname);
	$a_json_row["label"] = trim($customerfullname);

	$a_json_row["customercode"] = trim($customercode);
	
	
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
}*/
?>