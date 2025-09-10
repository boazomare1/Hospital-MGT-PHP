<?php
include_once("db/db_connect.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');

$txt="";
if(isset($_REQUEST["id"]) && $_REQUEST["id"]!='' && isset($_REQUEST["status"]) && $_REQUEST["status"]!='')
{
     if($_REQUEST["status"]==1)
		 $updatestatus=0;
	 else
		 $updatestatus=1;

	 if(isset($_REQUEST["user"]))
		 $user=$_REQUEST["user"];
	 else
         $user='';

	 $query1 = "update master_store set is_freeze='".$updatestatus."' where auto_number='".$_REQUEST["id"]."'";
	 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

	 $query1 = "INSERT into audit_store_freeze (store, user,datetime, freeze_status) 
		values ('".$_REQUEST["id"]."', '$user', '$updatedatetime','$updatestatus')";
	 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);
     
	 if($updatestatus==1)
	     $txt="disabled"; 
	 else
		 $txt="enabled";

}
else
  $txt="Invalid";

echo $txt;

?>