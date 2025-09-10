<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }

$searchresult = "";
$totalloanamount = "";
$loanbuild = "";
$totalmonthpaid = "";
$totalafterinstallment = "";

//include("autoemployeepayrollcalculation1.php");


	
$loanbuild = "";
$query80 = "select * from loan_assign where status <> 'deleted' and employeecode = '$employeesearch'";
$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res80 = mysqli_fetch_array($exec80))
{
	$employeecode = $res80['employeecode'];
	$loanname = $res80['loanname'];
	$interest = $res80['interest'];
	$fringebenefit = $res80['fringebenefit'];
	$installments = $res80['installments'];
	$installmentamount = $res80['installmentamount'];
	$interestapplicable = $res80['interestapplicable'];
	$amount = $res80['amount'];
	$monthinterest = $res80['monthinterest'];
	$monthamount = $res80['monthamount'];
	$fringerate = $res80['fringerate'];
	
	
	if($loanbuild == "")
	{
		$loanbuild = ''.$employeecode.'||'.$loanname.'||'.$installments.'||'.$interestapplicable.'||'.$interest.'||'.$fringebenefit.'||'.$amount.'||'.$monthinterest.'||'.$monthamount.'||'.$installmentamount.'||'.$fringerate.'';
	}	
	else
	{
		$loanbuild = $loanbuild.'||^||'.$employeecode.'||'.$loanname.'||'.$installments.'||'.$interestapplicable.'||'.$interest.'||'.$fringebenefit.'||'.$amount.'||'.$monthinterest.'||'.$monthamount.'||'.$installmentamount.'||'.$fringerate.'';
	}
}	
	
if ($loanbuild != '')
{
	echo $loanbuild;
}

?>