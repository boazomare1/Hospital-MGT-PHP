<?php

session_start();

//error_reporting(0);

if (!isset($_SESSION["username"])) header("location:index.php");

include "db/db_connect.php";



	 

$patientcode = $_GET['patientcode'];

	 $query10 = "select customercode,customerfullname,nationalidnumber,mobilenumber,accountname,dateofbirth,area from master_customer where customercode ='$patientcode'  and status <> 'Deleted'  order by auto_number limit 20";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$execnumrow = mysqli_num_rows($exec10);
	$res10 = mysqli_fetch_array($exec10);

		
	$res10customercode = $res10['customercode'];

	$res10customerfullname=$res10['customerfullname'];

	$res10nationalidnumber = $res10['nationalidnumber'];

	$res10mobilenumber = $res10['mobilenumber'];

	$res10accountname = $res10['accountname'];

	$res10dateofbirth = $res10['dateofbirth'];

	$res10area = $res10['area'];

	if($res10dateofbirth=='0000-00-00')

	{

		$res1dateofbirth='';

	}
	$query111 = "select accountname from master_accountname where auto_number = '$res10accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];	

	$res1customercode = addslashes($res10customercode);
	$res1nationalidnumber = addslashes($res10nationalidnumber);
	$res1mobilenumber = addslashes($res10mobilenumber);
	$res1customercode = strtoupper($res1customercode);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	$res1customercode = trim($res1customercode);
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	//$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);	
	
	echo $res1customercode."^".$res111accountname;



?>

