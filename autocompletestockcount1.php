<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$itemcode=$_REQUEST['itemcode'];
$itemcode = trim($itemcode);
$currentstock = "";

include ('autocompletestockcount1include1.php');


if ($res1itemname != '')
{
	if ($currentstock != '')
	{
		//echo $customercode.'||'.$customername.'||'.$address.'||'.$location.'||'.$city.'||'.$state.'||'.$pincode.'||'.$title1.'||'.$contactperson1.'||'.$designation1.'||'.$department1.'||'.$res2anum.'||'.$tinnumber.'||'.$cstnumber;
		echo $currentstock.'||'.$res1itemcode.'||'.$res1itemname;
	}
	else
	{
		echo '0'.'||'.$res1itemcode.'||'.$res1itemname;
	}
}


?>