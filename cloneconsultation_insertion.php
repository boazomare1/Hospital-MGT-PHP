<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');   

$recorddate= date('Y-m-d'); 

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

if (isset($_REQUEST["main_location"])) { $main_location = $_REQUEST["main_location"]; } else { $main_location = ""; }

if (isset($_REQUEST["update_location"])) { $update_location = $_REQUEST["update_location"]; } else { $update_location = ""; }


	 $query1s2 = "select auto_number from master_consultationtype where locationcode='$update_location'";
	$exec1s2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s2) or die ("Error in query1s2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1s2 = mysqli_num_rows($exec1s2);
	
	if($num1s2<=0)
	{	
	
	 $query181 = "select * from master_consultationtype where  locationcode='$main_location'";
	$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	while ($res181 = mysqli_fetch_array($exec181))
	{
	$condefault='';
	$cons_name=$res181['consultationtype'];
	$deptget=$res181['department'];
	$doctorcode=$res181['doctorcode'];
	$doctorname=$res181['doctorname'];
	$consultationfees=$res181['consultationfees'];
	$paymenttype=$res181['paymenttype'];
	$subtype=$res181['subtype'];
	$condefault=$res181['condefault'];
		
	$query1 = "insert into master_consultationtype (consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$cons_name', '$deptget','$doctorcode','$doctorname','$consultationfees','$ipaddress','$recorddate', '$username','$update_location','$update_location','$condefault','$paymenttype','$subtype')"; 
	
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query1s = "select * from locationwise_consultation_fees where  locationcode='$main_location'";
	$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1s = mysqli_fetch_array($exec1s);
	while ($res1s = mysqli_fetch_array($exec1s))
	{
	$review='';
	$consultation_id=$res1s['consultation_id'];
	$deptget=$res1s['department'];
	$doctorcode=$res1s['doctorcode'];
	$doctorname=$res1s['doctorname'];
	$locrateget=$res1s['consultationfees'];
	$paymenttype=$res1s['maintype'];
	$subtype=$res1s['subtype'];
	$review=$res181['review'];
	
	
	$query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review,subtype,maintype) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$update_location', '$locrateget','$review','$subtype','$paymenttype')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	
	}
		



?>

