<?php
$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '';
$databasename = 'poplawr_live';
  

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
//Folder Name Change Only Necessary

$appfoldername = 'medbot';
$issubdomain=1;


$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston"]));

mysqli_select_db($GLOBALS["___mysqli_ston"], $databasename) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));



if($issubdomain==1){

$currentworkingdomain = 'http://www.kenique.biz';
$applocation1 = $currentworkingdomain.'/'.$appfoldername; //Used inside excel export options on reports module.

}else{

//echo $_SERVER['REQUEST_URI'] ; //To get full url. 

$currentworkingdomain = $_SERVER['SERVER_NAME']; //To get only server name.

$currentworkingdomain = 'http://'.$currentworkingdomain;

$applocation1 = $currentworkingdomain.'/'.$appfoldername; //Used inside excel export options on reports module.



}



$databasename = $databasename; //Used inside autoitemsearch2.php / autoitemsearch2purchase.php



date_default_timezone_set('Africa/Nairobi');

$startTime = microtime(true);
?>