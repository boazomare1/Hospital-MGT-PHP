<?php
session_start();
include ("db/db_connect.php");

 $process=$_REQUEST['term'];
$username = $_SESSION["username"];

//$docno = $_SESSION['docno'];
//$query = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
//$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
//$res = mysql_fetch_array($exec);
//	
//	 $locationname  = $res["locationname"];
//	 $locationcode = $res["locationcode"];


$a_json = array();
$a_json_row = array();
 $query1 = "select doctorcode,doctorname,consultationfees from master_doctor where doctorname like '%$process%'  order by doctorname limit 0,10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$doctorcode = $res1['doctorcode'];
	$doctorname = $res1['doctorname'];
	$consultationfees = $res1['consultationfees'];
	
	$a_json_row["doctorcode"] = trim($doctorcode);
	$a_json_row["consultationfees"] = trim($consultationfees);
	$a_json_row["value"] = trim($doctorname);
	$a_json_row["label"] = trim($doctorname);
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>