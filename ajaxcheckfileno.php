<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$fileno1 = trim($_REQUEST["fileno"]);
$location = trim($_REQUEST["location"]);
$consultationdate = date('Y-m-d');
$numrows=0;
$parts = explode("-", $fileno1);
$fileno = $parts[0];


if(strpos($fileno1, '-') !== false && is_numeric($fileno)) {
	
	$query5 = "select * from filenumber where filenumber = '$fileno1' ";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numrows = mysqli_num_rows($exec5);  
	if($numrows==0){
	$query51 = "select * from filenumber where locationcode='$location' order by auto_number asc limit 0,1 ";
	$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"])); 
	$res51 = mysqli_fetch_array($exec51);
	$res1filenumber1= $res51["filenumber"];
	$parts1 = explode("-", $res1filenumber1);
	$res1filenumber = $parts1[0];
	if(is_numeric($res1filenumber)){	
	if($res1filenumber==''){
	$res1filenumber='100';	
	}
	} else {
	$res1filenumber='100';	
	}
	
	if($res1filenumber <= $fileno){
	 $numrows=1;	
	}
	}
	
} else {
	$query5 = "select * from filenumber where filenumber = '$fileno1' ";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numrows = mysqli_num_rows($exec5);  
}

	
	$searchresult = ''.$numrows.'';
	
if ($searchresult != '')
{
	echo $searchresult;
}
?>