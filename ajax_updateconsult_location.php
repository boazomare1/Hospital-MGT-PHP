<?php
session_start();

if (!isset($_SESSION["username"])) header("location:index.php");

include "db/db_connect.php";

$username = $_SESSION['username'];
$docno1 = $_SESSION['docno'];
$split_st='';
$visitcode1='';
if (isset($_REQUEST["from_location"])) { $from_location = $_REQUEST["from_location"]; } else { $from_location = ""; }
if (isset($_REQUEST["to_location"])) { $to_location = $_REQUEST["to_location"]; } else { $to_location = ""; }

$query281 = "select * from locationwise_consultation_fees where  locationcode='$from_location'";
$exec281 = mysqli_query($GLOBALS["___mysqli_ston"], $query281) or die ("Error in Query281".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while ($res281 = mysqli_fetch_array($exec281))
{
$consultation_id = $res281["consultation_id"];
$deptget = $res281["department"];
$doctorcode = $res281["doctorcode"];
$doctorname = $res281["doctorname"];
$locrateget = $res281["consultationfees"];
$subtype = $res281["subtype"];
$paymenttype = $res281["maintype"];
$review = $res281["review"];
 $query155 = "insert into  locationwise_consultation_fees (consultation_id, department, doctorcode,doctorname, locationcode, consultationfees,review,subtype,maintype) values ('$consultation_id', '$deptget', '$doctorcode','$doctorname', '$to_location', '$locrateget','$review','$subtype','$paymenttype')";
	$exec155 = mysqli_query($GLOBALS["___mysqli_ston"], $query155) or die ("Error in Query155".mysqli_error($GLOBALS["___mysqli_ston"]));
}

?>

