<?php
//session_start();
include ("db/db_connect.php");

$doctor = $_REQUEST['customer'];
$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";

 $query1 = "SELECT doctorcode,doctorname,resdoc_charge,consultationfees FROM master_doctor WHERE resdoc_charge >0 AND doctorname LIKE '%$doctor%' AND locationcode='".$location."'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$doctorcode = $res1['doctorcode'];
	$doctorname = $res1['doctorname'];
	$resdoc_charge = $res1['resdoc_charge'];
	$consultationfees = $res1['consultationfees'];
	
	
	$doctorcode = addslashes($doctorcode);
	$doctorname = addslashes($doctorname);
	$resdoc_charge = addslashes($resdoc_charge);
	$consultationfees = addslashes($consultationfees);
	
	
	$doctorcode = preg_replace('/,/', ' ', $doctorcode);
	$doctorname = preg_replace('/,/', ' ', $doctorname);
	$resdoc_charge = preg_replace('/,/', ' ', $resdoc_charge);
	$consultationfees = preg_replace('/,/', ' ', $consultationfees);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = ' '.$doctorcode.'#'.$doctorname.'#'.$resdoc_charge.'#'.$consultationfees.' ';
	}
	else
	{
		$stringbuild1 = $stringbuild1.$doctorcode.'#'.$doctorname.'#'.$resdoc_charge.'#'.$consultationfees.' ';
	}
}
echo $stringbuild1;

?>