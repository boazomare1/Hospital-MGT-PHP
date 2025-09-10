<?php
//session_start();
include ("db/db_connect.php");

$customer = $_REQUEST['customer'];
$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";

 /*$query1 = "SELECT * FROM `master_visitentry` WHERE visitcode not in (SELECT visitcode from billing_paylater) and consultationdate >= curdate()-1 and visitcode like '$customer%'  ORDER BY patientfullname  ";*/
 $query1 = "SELECT * FROM `master_visitentry` WHERE visitcode not in (SELECT visitcode from billing_paylater) and consultationdate >= curdate()-1 and patientfullname like '$customer%'  ORDER BY patientfullname  ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['patientcode'];
	$res1customervisitcode = $res1['visitcode'];
	
	$res1customername = $res1['patientfirstname'];
	$res1customermiddlename = $res1['patientmiddlename'];
	$res1customerlastname = $res1['patientlastname'];
	$res1customerfullname=$res1['patientfullname'];
	//$res1nationalidnumber = $res1['nationalidnumber'];
	//$res1mobilenumber = $res1['mobilenumber'];
	$res111accountname = $res1['accountfullname'];
	
	/*$query111 = "select * from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
	$res111 = mysql_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	*/
	$res1customercode = addslashes($res1customercode);
	
	$res1customervisitcode = addslashes($res1customervisitcode);
	
	$res1customername = addslashes($res1customername);
	$res1customermiddlename = addslashes($res1customermiddlename);
	$res1customerlastname = addslashes($res1customerlastname);
	$res1customerfullname=addslashes($res1customerfullname);
	//$res1nationalidnumber = addslashes($res1nationalidnumber);
	//$res1mobilenumber = addslashes($res1mobilenumber);

	$res1customercode = strtoupper($res1customercode);
	
	$res1customervisitcode = strtoupper($res1customervisitcode);
	
	$res1customername = strtoupper($res1customername);
	$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1customerfullname=strtoupper($res1customerfullname);
	//$res1nationalidnumber = strtoupper($res1nationalidnumber);
	//$res1mobilenumber = strtoupper($res1mobilenumber);
	
	$res1customercode = trim($res1customercode);
	
	$res1customervisitcode = trim($res1customervisitcode);
	
	$res1customername = trim($res1customername);
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	
	$res1customervisitcode = preg_replace('/,/', ' ', $res1customervisitcode);
	
	$res1customername = preg_replace('/,/', ' ', $res1customername);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = ' '.$res1customerfullname.'#'.$res1customercode.'#'.$res1customervisitcode.'#'.$res111accountname.' ';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customerfullname.'#'.$res1customercode.'#'.$res1customervisitcode.'#'.$res111accountname.'';
	}
}
echo $stringbuild1;

?>