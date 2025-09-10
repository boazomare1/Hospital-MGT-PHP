<?php
//session_start();
include ("db/db_connect.php");

$consultingdoctor = $_REQUEST['consultingdoctor'];
$location = $_REQUEST['location'];
$subtype = $_REQUEST['subtype'];
//echo $customer;
$stringbuild1 = "";

$query47="select subtype,fxrate,currency from master_subtype where auto_number='$subtype'";
$exec47=mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res47=mysqli_fetch_array($exec47);
$fxrate = $res47['fxrate'];
$currency = $res47['currency'];

$query1 = "select * from master_doctor where doctorcode = '$consultingdoctor' and locationcode = '$location' and status <> 'Deleted' order by doctorname LIMIT 10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['doctorcode'];
	$res1customername = $res1['doctorname'];
	$res1consultationfees = $res1['consultationfees'];
	$hospitalfees = $res1['hospitalfees'];
	$doctorfees = $res1['doctorfees'];
	
	$res1consultationfees = number_format($res1consultationfees/$fxrate,2,'.','');
	
	$res1customercode = addslashes($res1customercode);
	$res1customername = addslashes($res1customername);
	
	$res1customercode = strtoupper($res1customercode);
	$res1customername = strtoupper($res1customername);
	
	$res1customercode = trim($res1customercode);
	$res1customername = trim($res1customername);
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customername = preg_replace('/,/', ' ', $res1customername);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res1customername.'#'.$res1customercode.'#'.$res1consultationfees.'#'.$hospitalfees.'#'.$doctorfees.'';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customername.'#'.$res1customercode.'#'.$res1consultationfees.'#'.$hospitalfees.'#'.$doctorfees.'';
		
	}
}
if($stringbuild1 != '')
{
echo $stringbuild1;
}
else
{
echo $stringbuild1 = 'OP DOCTOR'.'#'.'08-8000'.'#'.'';
}

?>