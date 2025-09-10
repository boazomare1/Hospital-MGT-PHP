<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];

if (isset($_REQUEST["settingsvalue"])) { $settingsvalue = $_REQUEST["settingsvalue"]; } else { $settingsvalue = ""; }
//$settingsvalue = $_POST['settingsvalue'];

if (isset($_REQUEST["settingsvalue1"])) { $settingsvalue1 = $_REQUEST["settingsvalue1"]; } else { $settingsvalue1 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue2"])) { $settingsvalue2 = $_REQUEST["settingsvalue2"]; } else { $settingsvalue2 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue3"])) { $settingsvalue3 = $_REQUEST["settingsvalue3"]; } else { $settingsvalue3 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue4"])) { $settingsvalue4 = $_REQUEST["settingsvalue4"]; } else { $settingsvalue4 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue5"])) { $settingsvalue5 = $_REQUEST["settingsvalue5"]; } else { $settingsvalue5 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue6"])) { $settingsvalue6 = $_REQUEST["settingsvalue6"]; } else { $settingsvalue6 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue7"])) { $settingsvalue7 = $_REQUEST["settingsvalue7"]; } else { $settingsvalue7 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue8"])) { $settingsvalue8 = $_REQUEST["settingsvalue8"]; } else { $settingsvalue8 = ""; }
//$settingsvalue = $_POST['settingsvalue'];
if (isset($_REQUEST["settingsvalue9"])) { $settingsvalue9 = $_REQUEST["settingsvalue9"]; } else { $settingsvalue9 = ""; }
//$settingsvalue9 = $_POST['settingsvalue9'];

if (isset($_REQUEST["financialyearsettings1"])) { $financialyearsettings1 = $_REQUEST["financialyearsettings1"]; } else { $financialyearsettings1 = ""; }
//$financialyearsettings1 = $_REQUEST['financialyearsettings1'];
if ($financialyearsettings1 == 'financialyearsettings1')
{
	$query2 = "update master_settings set settingsvalue = '$settingsvalue', ipaddress = '$ipaddress', username = '$username' 
	where modulename = 'SETTINGS' and settingsname = 'CURRENT_FINANCIAL_YEAR' 
	and companyanum = '$companyanum' and companycode = '$companycode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$_SESSION['financialyear'] = $settingsvalue;
	header ("location:settingsmaster1.php?errno=1&&errmodule=financialyearsettings1");
	//header ("location:logout1.php");
}

if (isset($_REQUEST["defaultcountrysettings1"])) { $defaultcountrysettings1 = $_REQUEST["defaultcountrysettings1"]; } else { $defaultcountrysettings1 = ""; }
//$financialyearsettings1 = $_REQUEST['financialyearsettings1'];
if ($defaultcountrysettings1 == 'defaultcountrysettings1')
{
	$query2 = "update master_settings set settingsvalue = '$settingsvalue', ipaddress = '$ipaddress', username = '$username' 
	where modulename = 'SETTINGS' and settingsname = 'DEFAULT_COUNTRY_SETTING' 
	and companyanum = '$companyanum' and companycode = '$companycode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	header ("location:settingsmaster1.php?errno=1&&errmodule=defaultcountrysettings1");
	//header ("location:logout1.php");
}


?>