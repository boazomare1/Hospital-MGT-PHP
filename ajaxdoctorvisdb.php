<?php

//session_start();

include ("db/db_connect.php");



$consultingdoctor = $_REQUEST['consultingdoctor'];

$location = $_REQUEST['location'];
$department = $_REQUEST['department'];
$subtype = $_REQUEST['subtype'];

//echo $customer;
// and department = '$department'
$stringbuild1 = "";
$sqldoc="select doctorcode,doctorname from master_doctor where doctorname like'%".$consultingdoctor."%' and status = '' ";
	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $sqldoc) or die ("Error in sqldoc".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res13 = mysqli_fetch_array($exec13))

{

	$res1customercode = $res13['doctorcode'];
	$res1customername = $res13['doctorname'];

	

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

		$stringbuild1 = $res1customername.'#'.$res1customercode;

	}

	else

	{

		$stringbuild1 = $stringbuild1.','.$res1customername.'#'.$res1customercode;

		

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