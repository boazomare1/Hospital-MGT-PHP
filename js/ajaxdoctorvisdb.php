<?php

//session_start();

include ("db/db_connect.php");



$consultingdoctor = $_REQUEST['consultingdoctor'];

$location = $_REQUEST['location'];
$department = $_REQUEST['department'];
$subtype = $_REQUEST['subtype'];

//echo $customer;

$stringbuild1 = "";

// consultationtype, department,doctorcode,doctorname,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype


$query1 = "select * from master_consultationtype where doctorname like '%$consultingdoctor%' and locationcode = '$location' and subtype='$subtype' and recordstatus <> 'Deleted' and department='$department' group by doctorcode order by doctorname ";
// if($consultingdoctor==''){
// 	$query1 = "select * from master_consultationtype where locationcode = '$location' and subtype='$subtype' and recordstatus <> 'Deleted' and department='$department' group by doctorcode order by doctorname ";
// }
// $query1 = "select * from master_doctor where doctorname like '%$consultingdoctor%' and locationcode = '$location' and status <> 'Deleted' and department='$department' order by doctorname ";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	$res1customercode = $res1['doctorcode'];

	$res1customername = $res1['doctorname'];

	$res1consultationfees = $res1['consultationfees'];

	

	$res1customercode = addslashes($res1customercode);

	$res1customername = addslashes($res1customername);

	

	$res1customercode = strtoupper($res1customercode);

	$res1customername = strtoupper($res1customername);

	

	$res1customercode = trim($res1customercode);

	$res1customername = trim($res1customername);

	

	$res1customercode = preg_replace('/,/', ' ', $res1customercode);

	$res1customername = preg_replace('/,/', ' ', $res1customername);

	

	if ($stringbuild1 == '')

	{

		$stringbuild1 = $res1customername.'#'.$res1customercode.'#'.$res1consultationfees.'';

	}

	else

	{

		$stringbuild1 = $stringbuild1.','.$res1customername.'#'.$res1customercode.'#'.$res1consultationfees.'';

		

	}

}

if($stringbuild1 != '')

{

echo $stringbuild1;

}

else

{

//echo $stringbuild1 = 'OP DOCTOR'.'#'.'08-8000'.'#'.'';

}



?>