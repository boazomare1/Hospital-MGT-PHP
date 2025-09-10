<?php
session_start();

include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
//$financialyear = $_SESSION["financialyear"];

$registrationdate = date("Y-m-d");

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
 if (isset($_REQUEST["billtype"])) { $patientbilltype = $_REQUEST["billtype"]; } else { $patientbilltype = ""; }
 
//echo $patientbilltype;
//$billnumber=$_REQUEST["billnumber"];
if($patientbilltype == 'PAY NOW')
{

/*$query2 = "select * from master_visitentry where recordstatus = '' and patientcode = '$patientcode' and consultationdate = '$registrationdate'";
*/

$query2 = "select * from master_ipvisitentry where recordstatus = '' and patientcode = '$patientcode' and consultationdate = '$registrationdate' and finalbillno <> ''";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);

if ($res2 == 0)
{
	$patientcodestatus = 'NOT IN RECORD';
}
else
{
	$patientcodestatus = 'ID FOUND';
}
}
else
{


$query2 = "select * from master_ipvisitentry where recordstatus = '' and patientcode = '$patientcode' and consultationdate = '$registrationdate' and finalbillno <> ''";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);

if ($res2 == 0)
{
	$patientcodestatus = 'NOT IN RECORD';
}
else
{
	$patientcodestatus = 'ID FOUND';
}
/*
$query21 = "select * from master_visitentry where recordstatus = '' and patientcode = '$patientcode' and consultationdate = '$registrationdate' order by auto_number desc limit 0,1";

$exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
$res21 = mysql_fetch_array($exec21);
$oldvisitcode = $res21['visitcode'];

if($oldvisitcode != '')
{
$query22 = "select * from billing_paylater where visitcode='$oldvisitcode'";
$exec22 = mysql_query($query22) or die(mysql_error());
$res22 = mysql_num_rows($exec22);
if ($res22 == 0)
{
	$patientcodestatus = 'ID FOUND';
	
}
else
{
	$patientcodestatus = 'NOT IN RECORD';
}

}
else
{
$patientcodestatus = 'NOT IN RECORD';
}
*/
}


echo $patientcodestatus;

?>
