<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$_SESSION["patientcode"] = $patientcode;
$_SESSION["visitcode"] = $visitcode;

include_once 'open-flash-chart-1.9.5/php-ofc-library/open_flash_chart_object.php';
open_flash_chart_object( 700, 350, 'http://'. $_SERVER['SERVER_NAME'] .'/neema/vitalinput_line.php', false );
?>