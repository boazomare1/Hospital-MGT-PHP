<?php 
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}



if($action == 'deleteippackcondoct')
{
		$id = $_REQUEST['id'];
		
		$pkgt=mysqli_query($GLOBALS["___mysqli_ston"], "delete from package_processing where id='$id' ");
		
		$pkgex=mysqli_query($GLOBALS["___mysqli_ston"], "delete from package_execution where processing_id='$id' ");
		
		
}

?>