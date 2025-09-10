<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }

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
	$res80employeecode = $res80['employeecode'];
	$res80loanname = $res80['loanname'];
	$loaninterest = $res80['interest'];
	$fringebenefit = $res80['fringebenefit'];
	$nonofinstallments = $res80['installments'];
	$installmentamount = $res80['installmentamount'];
	$interestapplicable = $res80['interestapplicable'];
	$holdstatus = $res80['holdstatus'];
	
	$totalloanamount = "";
	$query81 = "select * from loan_assign where status <> 'deleted' and employeecode = '$res80employeecode' and loanname = '$res80loanname'";
	$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res81 = mysqli_fetch_array($exec81))
	{	
		$loanname = $res81['loanname'];
		$loanamount = $res81['amount'];
		$totalloanamount = $totalloanamount + $loanamount;
	}
	//echo $totalloanamount;
	$totalmonthpaid = "";
	$installmentspaid = "";
	$query82 = "select * from details_loanpay where status <> 'deleted' and employeecode = '$res80employeecode' and loanname = '$res80loanname' and paymonth <> '$assignmonth'";
	$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die ("Error in Query82".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res82 = mysqli_fetch_array($exec82))
	{	
		$monthamount = $res82['monthamount'];
		if($monthamount != 0.00)
		{
			$installmentspaid = $installmentspaid + 1;
		}	
		$totalmonthpaid = $totalmonthpaid + $monthamount;
	}	
	//echo $totalmonthpaid;
	$totalafterinstallment = $totalloanamount - $totalmonthpaid;
	
	if($loaninterest < $fringebenefit)
	{
		$fringepercent = $fringebenefit - $loaninterest;
		$fringeamount = $totalafterinstallment * ($fringepercent / 100);
		$fringeamount = $fringeamount / 12;
	}
	else
	{
		$fringeamount = "0.00";
	}
	$installmentspaid;
	$remaininstallments = $nonofinstallments - $installmentspaid;
	$interesttotal = $totalafterinstallment * ($loaninterest / 100);
	$principleinterest = $totalafterinstallment + $interesttotal;
	$amountthismonth = $totalafterinstallment / $remaininstallments;
	$interestthismonth = $interesttotal / 12;
	$thismonthpay = $amountthismonth + $interestthismonth;
	
	//echo '<br> principle - '.$totalafterinstallment;
	//echo '<br> amount - '.$amountthismonth;
	//echo '<br> interest - '.$interestthismonth;
	//echo '<br> total - '.$thismonthpay;
	//echo '<br> fringeamount - '.$fringeamount;
	
	if($loanbuild == "")
	{
		$loanbuild = ''.$employeesearch.'||'.$loanname.'||'.number_format($totalloanamount,2,'.','').'||'.number_format($totalafterinstallment,2,'.','').'||'.$loaninterest.'||'.$nonofinstallments.'||'.$interestapplicable.'||'.$fringebenefit.'||'.number_format($amountthismonth,2,'.','').'||'.number_format($interestthismonth,2,'.','').'||'.number_format($thismonthpay,2,'.','').'||'.number_format($fringeamount,2,'.','').'||'.$holdstatus.'';
	}	
	else
	{
		$loanbuild = $loanbuild.'||^||'.$employeesearch.'||'.$loanname.'||'.number_format($totalloanamount,2,'.','').'||'.number_format($totalafterinstallment,2,'.','').'||'.$loaninterest.'||'.$nonofinstallments.'||'.$interestapplicable.'||'.$fringebenefit.'||'.number_format($amountthismonth,2,'.','').'||'.number_format($interestthismonth,2,'.','').'||'.number_format($thismonthpay,2,'.','').'||'.number_format($fringeamount,2,'.','').'||'.$holdstatus.'';
	}
}	
	
if ($loanbuild != '')
{
	echo $loanbuild;
}

?>