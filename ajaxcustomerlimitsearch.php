<?php
//session_start();
include ("db/db_connect.php");

$customer = trim($_REQUEST['term']);
$customersplit = explode('|',$customer);
$customersearch='';
//echo count($customersplit);  
//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select customercode,customerfullname,nationalidnumber,mobilenumber,accountname,dateofbirth,area from master_customer where (customercode LIKE '%$customer%' OR customerfullname LIKE '%$customer%') and status <> 'Deleted' and membertype = '0' and billtype = 'PAY LATER' order by auto_number limit 20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['customercode'];
	$res1customerfullname=$res1['customerfullname'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	$res1accountname = $res1['accountname'];
	$res1dateofbirth = $res1['dateofbirth'];
	$res1area = $res1['area'];
	if($res1dateofbirth=='0000-00-00')
	{
		$res1dateofbirth='';
	}
	$query111 = "select accountname from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	
	$res1customercode = addslashes($res1customercode);
	
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);

	$res1customercode = strtoupper($res1customercode);
	
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	
	$res1customercode = trim($res1customercode);
	
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);
	
	/*if ($stringbuild1 == '')
	{
		$stringbuild1 = ' '.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.' ';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.'';
	}*/
	$a_json_row["customercode"] = $res1customercode;
	$a_json_row["accountname"] = $res111accountname;
	$a_json_row["value"] = trim($res1customerfullname);
	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1dateofbirth.'#'.$res1area.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.'#'.$res1customercode.'#'.$res111accountname;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>