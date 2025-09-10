<?php
include ("db/db_connect.php");


if (isset($_REQUEST["id"])) { $id = $_REQUEST["id"]; } else { $id = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
if (isset($_REQUEST["registrationdate"])) { $registrationdate = $_REQUEST["registrationdate"]; } else { $registrationdate = ""; }

//$query2 = "select * from member_insurance where membernumber='$id' and locationcode='$locationcode' and enddate>='$registrationdate'";
$query2 = "select locationcode,enddate,locationname from member_insurance where membernumber='$id'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$rowcount3 = mysqli_num_rows($exec2);

$res2 = mysqli_fetch_array($exec2);

$res2locationcode= $res2['locationcode'];

$res2enddate = $res2['enddate'];

$res2locationname= $res2['locationname'];

$query1 = "select locationname from master_location where locationcode='$locationcode'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];


if($rowcount3>0)
{
	if($res2locationcode!=$locationcode)
	{
		echo "This Memeber is not Eligible for ".$res1location;
	}
	else if($res2enddate<$registrationdate)
	{
		echo "Memeber validity is Expired";
	}
}

?>