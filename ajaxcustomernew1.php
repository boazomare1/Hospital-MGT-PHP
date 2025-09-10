<?php
//session_start();
include ("db/db_connect.php");

$customer = $_REQUEST['customer'];
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";

 $query1 = "select * from master_customer where customerfullname like '%$customer%' or customercode like '%$customer%' or nationalidnumber like '%$customer%' and status <> 'Deleted'  order by customerfullname LIMIT 10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['customercode'];
	$res1customername = $res1['customername'];
	$res1customermiddlename = $res1['customermiddlename'];
	$res1customerlastname = $res1['customerlastname'];
	$res1customerfullname=$res1['customerfullname'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	$res1accountname = $res1['accountname'];
	
	$query111 = "select * from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	
	$res1customercode = addslashes($res1customercode);
	$res1customername = addslashes($res1customername);
	$res1customermiddlename = addslashes($res1customermiddlename);
	$res1customerlastname = addslashes($res1customerlastname);
	$res1customerfullname=addslashes($res1customerfullname);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);

	$res1customercode = strtoupper($res1customercode);
	$res1customername = strtoupper($res1customername);
	$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1customerfullname=strtoupper($res1customerfullname);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	
	$res1customercode = trim($res1customercode);
	$res1customername = trim($res1customername);
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customername = preg_replace('/,/', ' ', $res1customername);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = ' '.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.' ';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.'';
	}
}
echo $stringbuild1;

?>