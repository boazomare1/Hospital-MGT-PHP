<?php
/*
Copyright (c) 2011 http://ramui.com. All right reserved.
This product is protected by copyright and distributed under licenses restricting copying, distribution. Permission is granted to the public to download and use this script provided that this Notice and any statement of authorship are reproduced in every page on all copies of the script.
*/

//On the backup zipped file, this omits the backup destination folder. To avoid, folder not found error, below code is needed.
if (is_dir('zbackupsoftwarefiles')) 
{
	//code to use if directory
	//echo 'Dir Found.';
	//echo 'No Action Taken';
}
else
{
	//echo 'Dir Not Found';
	mkdir("zbackupsoftwarefiles");
	//echo 'Dir Created';
}

//To call database backupcode to include DB backup process.
include ("backupdatabasecode1.php");

//include "recurseZip.php";
include "backupsoftwarecodeinclude1.php";

//Source file or directory to be compressed.
//$src='source/foldername';
$src='../'.$appfoldername;

//Destination folder where we create Zip file.
$dst='zbackupsoftwarefiles';

$z=new recurseZip();
//echo $z->compress($src,$dst);
$z->compress($src,$dst);

$backuptime = date('YMd_His');
$backupsoftwarefiletime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$backupsoftwarefilename = 'SW_Backup_'.$backuptime.'.zip';
$backupsoftwarefiletime =  $backupsoftwarefiletime;

$query1db = "insert into master_backupsoftware (backupfilename, backupfiledate, username, ipaddress) 
values ('$backupsoftwarefilename', '$backupsoftwarefiletime', '$username', '$ipaddress')";
$exec1db = mysqli_query($GLOBALS["___mysqli_ston"], $query1db) or die ("Error in Query1db".mysqli_error($GLOBALS["___mysqli_ston"]));

//To rename the created zipped file.
rename('zbackupsoftwarefiles/'.$appfoldername.'.zip', 'zbackupsoftwarefiles/'.$backupsoftwarefilename);


?>