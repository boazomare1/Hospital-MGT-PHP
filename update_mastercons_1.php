<?php
session_start();
set_time_limit(0);
ini_set('display_errors',1);
//include ("includes/loginverify.php");
include ("db/db_connect.php");
include 'phpexcel/Classes/PHPExcel/IOFactory.php';
$username='admin';
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');

$selectedlocationcode='LTC-1';
$selectedlocation = 'Premier Hospital';
$date = date('Y-m-d');


$query5 = "select * from master_department where recordstatus = '' and auto_number='24'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res5 = mysqli_fetch_array($exec5))
{
	$department = $res5["auto_number"];


	$consultationtype = 'CONSULTATION FEE';
	$doctorcode = '03-2000-111';
	$doctorname = 'GENERAL OPD DOCTORS';
	$consultationfees = 1000;

	$query51 = "select * from master_paymenttype where auto_number in('2','3','4')";
	$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res51 = mysqli_fetch_array($exec51))
	{
	    $res5anum = $res51["auto_number"];


		$query10 = "select * from master_subtype where maintype = '$res5anum ' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{

		$subtype = $res10["auto_number"];

		$query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department','$doctorcode','$doctorname','$consultationfees','','', 'admin','1','LTC-1','','$res5anum','$subtype')"; 
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		echo	$errmsg = "Success. Updated.";
		}
	}
}
