<?php
$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '';
$databasenameemr = 'poplar_live';
  
//Folder Name Change Only Necessary
$appfoldername = 'presto';

$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $databasenameemr) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));

//echo $_SERVER['REQUEST_URI'] ; //To get full url. 
$currentworkingdomain = $_SERVER['SERVER_NAME']; //To get only server name.
$currentworkingdomain = 'http://'.$currentworkingdomain;

$applocation1 = $currentworkingdomain.'/'.$appfoldername; //Used inside excel export options on reports module.
$databasenameemr = $databasenameemr; //Used inside autoitemsearch2.php / autoitemsearch2purchase.php

date_default_timezone_set('Africa/Nairobi'); 


?>
