<?php
session_start();

include ("db/db_connect.php");
 $recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$docno = $_SESSION['docno'];
if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}

										
$query1 = "select * from login_locationdetails where username='$user' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1err".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
$res1location = $res1["locationname"];
$res1locationanum = $res1["locationcode"];
}			

if($action=='surgeon')
{
$booking_code = $_REQUEST['booking_code'];
$surgeon1 = $_REQUEST['surgeon1'];

$posttonewDb="INSERT INTO `theatre_booking_surgeons`(`booking_id`, `surgeon_id`, `locationcode`, `username`, `ipaddress`) VALUES ('$booking_code','$surgeon1','$res1locationanum', '$user','$ipaddress')";
$posttonewDb = mysqli_query($GLOBALS["___mysqli_ston"], $posttonewDb) or die ("Error in posttonewDb".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if($action=='scrubnurse')
{
$booking_code = $_REQUEST['booking_code'];
$scrubnurse1 = $_REQUEST['scrubnurse1'];

$postscrubnurse="INSERT INTO `theatre_panel_scrubnurses`(`booking_id`, `scrubnurse_id`, `locationcode`, `username`) VALUES ('$booking_code','$scrubnurse1','$res1locationanum', '$user')";
$postscrubnurse = mysqli_query($GLOBALS["___mysqli_ston"], $postscrubnurse) or die ("Error in postscrubnurse".mysqli_error($GLOBALS["___mysqli_ston"]));				
}

if($action=='anesthesist')
{
$booking_code = $_REQUEST['booking_code'];
$anesthesist1 = $_REQUEST['anesthesist1'];

$postanesthesist="INSERT INTO `theatre_panel_anesthesist`(`booking_id`, `anesthesist_id`, `locationcode`, `username`) VALUES ('$booking_code','$anesthesist1','$res1locationanum', '$user')";
$postanesthesist = mysqli_query($GLOBALS["___mysqli_ston"], $postanesthesist) or die ("Error in postanesthesist".mysqli_error($GLOBALS["___mysqli_ston"]));				
}

if($action=='circnurse')
{
$booking_code = $_REQUEST['booking_code'];
$circnurse1 = $_REQUEST['circnurse1'];

$postcircnurse="INSERT INTO `theatre_panel_circulating_nurse`(`booking_id`, `circulatingnurse_id`, `locationcode`, `username`) VALUES ('$booking_code','$circnurse1','$res1locationanum', '$user')";
$postcircnurse = mysqli_query($GLOBALS["___mysqli_ston"], $postcircnurse) or die ("Error in postcircnurse".mysqli_error($GLOBALS["___mysqli_ston"]));			
}

if($action=='technician')
{
$booking_code = $_REQUEST['booking_code'];
$technician1 = $_REQUEST['technician1'];

 $posttechnician="INSERT INTO `theatre_panel_technician`(`booking_id`, `technician_id`, `locationcode`, `username`) VALUES ('$booking_code','$technician1','$res1locationanum', '$user')";
$posttechnician = mysqli_query($GLOBALS["___mysqli_ston"], $posttechnician) or die ("Error in posttechnician".mysqli_error($GLOBALS["___mysqli_ston"]));			
}

if($action=='serv')
{
$booking_code = $_REQUEST['booking_code'];
$serv1 = $_REQUEST['serv1'];

$postnewPname="INSERT INTO `theatre_booking_proceduretypes`(`booking_id`, `proceduretype_id`, `locationcode`, `username`, `ipaddress`) VALUES ('$booking_code','$serv1','$res1locationanum', '$user','$ipaddress')";
$postnewPname = mysqli_query($GLOBALS["___mysqli_ston"], $postnewPname) or die ("Error in postnewPname".mysqli_error($GLOBALS["___mysqli_ston"]));			
}



?>
