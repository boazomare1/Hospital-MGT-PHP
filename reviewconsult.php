<?php
session_start();
set_time_limit(0);
ini_set('display_errors',1);
//include ("includes/loginverify.php");
include ("db/db_connect.php");
$username='admin';
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');

$selectedlocationcode='LTC-1';
$selectedlocation = 'Premier Hospital';
$date = date('Y-m-d');



$consultationtype = 'REVIEW ONLY';
//$department = '25';
$doctorcode = '03-2000-111';
$doctorname = 'GENERAL OPD DOCTOR';
$consultationfees = 0;

$query50 = "select * from master_department where recordstatus = '' ";
$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res50 = mysqli_fetch_array($exec50))
{
    $department = $res50["auto_number"];


	$query5 = "select * from master_paymenttype where auto_number!='1' and recordstatus = '' order by paymenttype";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res5 = mysqli_fetch_array($exec5))
	{
		$maintype = $res5["auto_number"];
		//$res5paymenttype = $res5["paymenttype"];


		$query10 = "select * from master_subtype where maintype = '$maintype' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{

			$subtype = $res10["auto_number"];

			$query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department','$doctorcode','$doctorname','$consultationfees','','', 'admin','1','LTC-1','','$maintype','$subtype')"; 
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo $errmsg = "Success. Updated.";
		}
	}

}
 
		

?>