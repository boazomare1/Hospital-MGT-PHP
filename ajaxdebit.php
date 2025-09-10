<?php
session_start();
include ("db/db_connect.php");

 $process=$_REQUEST['term'];
 
 $username = $_SESSION['username'];
 $docno = $_SESSION['docno'];
 
 $queryloc = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						$res1location = $res1["locationname"];
					 	 $res1locationanum = $res1["locationcode"];
 
 

$a_json = array();
$a_json_row = array();


    $query1 = "select locationcode,patientcode,visitcode,patientfullname from master_visitentry where paymentstatus='completed' and billtype = 'PAY LATER' and recordstatus <> 'Deleted' and locationcode='$res1locationanum' and (patientfullname like '%$process%' or visitcode like '%$process%' )  order by auto_number desc limit 0,10";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 $num1=mysqli_num_rows($exec1);

while ($res1 = mysqli_fetch_array($exec1))
{
	$patientcode = $res1['patientcode'];
	$visitcode = $res1['visitcode'];
 	$patientfullname = $res1['patientfullname'];

	
	
	
	$a_json_row["patientcode"] = trim($patientcode);
	$a_json_row["value"] = trim($patientfullname);
	$a_json_row["label"] = trim($patientfullname)."#".$visitcode;
	
	
	array_push($a_json, $a_json_row);
}
$query2 = "select patientcode,visitcode,patientfullname from master_ipvisitentry where paymentstatus='completed' and(patientfullname like '%$process%' or visitcode like '%$process%' )and billtype = 'PAY LATER' and recordstatus <> 'Deleted' and locationcode='$res1locationanum' order by patientfullname limit 0,10";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$num2=mysqli_num_rows($exec2);

while ($res2 = mysqli_fetch_array($exec2))
{
	$patientcode = $res2['patientcode'];
	$visitcode = $res2['visitcode'];
	$patientfullname = $res2['patientfullname'];
	
	
	
	$a_json_row["patientcode"] = trim($patientcode);
	$a_json_row["value"] = trim($patientfullname);
	$a_json_row["label"] = trim($patientfullname)."#".$visitcode;
	
	
	array_push($a_json, $a_json_row);
}


echo json_encode($a_json);


?>