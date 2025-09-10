<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
if (isset($_REQUEST["grosspay"])) { $grosspay = $_REQUEST["grosspay"]; } else { $grosspay = ""; }
if (isset($_REQUEST["deductions"])) { $deductions = $_REQUEST["deductions"]; } else { $deductions = ""; }
if (isset($_REQUEST["nettpay"])) { $nettpay = $_REQUEST["nettpay"]; } else { $nettpay = ""; }
//echo $grosspay;
$grosspay = str_replace(',','',$grosspay);
$deductions = str_replace(',','',$deductions);
$nettpay = str_replace(',','',$nettpay);

//include("autoemployeepayrollcalculation1.php");

$query74 = "select * from master_employee where employeecode = '$employeesearch'";
$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die ("Error in Query74".mysqli_error($GLOBALS["___mysqli_ston"]));
$res74 = mysqli_fetch_array($exec74);
$employeecode = $res74['employeecode'];
$employeename = $res74['employeename'];

$searchresult = "";
$loanbuild = "";
$totaldeductions = "0.00";
$finalnettpay = "0.00";
$totalloan = "0.00";

$searchresult = "";
$totalloanamount = "";
$loanbuild = "";
$totalmonthpaid = "";
$totalafterinstallment = "";

//include("autoemployeepayrollcalculation1.php");


	
$loanbuild = "";
$query80 = "select * from loan_assign where status <> 'deleted' and employeecode = '$employeesearch' group by loanname";
$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res80 = mysqli_fetch_array($exec80))
{
	$res80employeecode = $res80['employeecode'];
	$res80employeename = $res80['employeename'];
	$res80loanname = $res80['loanname'];
	$loaninterest = $res80['interest'];
	$fringebenefit = $res80['fringebenefit'];
	$nonofinstallments = $res80['installments'];
	$installmentamount = $res80['installmentamount'];
	$interestapplicable = $res80['interestapplicable'];
	$res80loanname = $res80['loanname'];
	$res80loanamount = $res80['amount'];
	
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
	
	$query11 = "select * from loan_assign where employeecode = '$employeesearch' and loanname = '$res80loanname' and amount = '$res80loanamount'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$holdstatus = $res11['holdstatus'];
	if($holdstatus == 'Yes')
	{
		$thismonthpay = $interestthismonth;	
		$amountthismonth = '0.00';
	}
	else
	{
		$thismonthpay = $thismonthpay;
		$amountthismonth = $amountthismonth;
	}
	
	$query6 = "select * from details_loanpay where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6employeecode = $res6['employeecode'];
	if($res6employeecode == '')
	{				
		$query3 = "insert into details_loanpay(employeecode, employeename, loanname, installments, interestapplicable, interest, fringebenefit, amount, amountremain, monthamount, monthinterest, installmentamount, fringerate, paymonth, username, ipaddress, updatedatetime)
		values('$employeesearch', '$res80employeename', '$loanname', '$nonofinstallments', '$interestapplicable', '$loaninterest', '$fringebenefit', '$totalloanamount', '$totalafterinstallment', '$amountthismonth', '$interestthismonth', '$thismonthpay', '$fringeamount', '$assignmonth', '$username', '$ipaddress', '$updatedatetime')";
		//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	}
	else
	{
		$query4 = "update details_loanpay set installmentamount = '$thismonthpay', monthamount = '$amountthismonth', monthinterest = '$interestthismonth', fringerate = '$fringeamount', updatedatetime = '$updatedatetime' where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted' and loanname = '$loanname'";
		//$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	}
	
}	

$query90 = "select * from details_loanpay where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
$exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res90 = mysqli_fetch_array($exec90))
{
	$loanname = $res90['loanname'];
	$monthamount = $res90['monthamount'];
	$monthinterest = $res90['monthinterest'];
	$installmentamount = $res90['installmentamount'];
	$fringerate = $res90['fringerate'];
	
	$totalloan = $totalloan + $installmentamount;
	
	$totaldeductions = $deductions + $totalloan;
	$totaldeductions = number_format($totaldeductions,2,'.','');
	$finalnettpay = $grosspay - $totaldeductions;
	$finalnettpay = number_format($finalnettpay,2,'.','');
	$grosspay = number_format($grosspay,2,'.','');
	$typecodebgcolor = "#FF0000";
	$type = 'D';
	
	if($loanbuild == "" && $fringerate != '0.00')
	{	
		$loanbuild = ''.$employeecode.'||'.$employeename.'||'.$loanname.'||'.number_format($monthamount,2,'.',',').'||'.$monthinterest.'||'.number_format($installmentamount,2,'.',',').'||'.'0'.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($grosspay,2,'.',',').'||'.number_format($totaldeductions,2,'.',',').'||'.number_format($finalnettpay,2,'.',',').'||^||'.$employeecode.'||'.$employeename.'||'.'FRINGE RATE'.'||'.number_format('0.00',2,'.',',').'||'.'0.00'.'||'.number_format($fringerate,2,'.',',').'||'.'0'.'||'.'#00FF00'.'||'.'E'.'||'.number_format($grosspay,2,'.',',').'||'.number_format($totaldeductions,2,'.',',').'||'.number_format($finalnettpay,2,'.',',').'';
	}
	else if($loanbuild == "" && $fringerate == '0.00')
	{	
		$loanbuild = ''.$employeecode.'||'.$employeename.'||'.$loanname.'||'.number_format($monthamount,2,'.',',').'||'.$monthinterest.'||'.number_format($installmentamount,2,'.',',').'||'.'0'.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($grosspay,2,'.',',').'||'.number_format($totaldeductions,2,'.',',').'||'.number_format($finalnettpay,2,'.',',').'';
	}
	else
	{
		$loanbuild = $loanbuild.'||^||'.$employeecode.'||'.$employeename.'||'.$loanname.'||'.number_format($monthamount,2,'.',',').'||'.$monthinterest.'||'.number_format($installmentamount,2,'.',',').'||'.'0'.'||'.$typecodebgcolor.'||'.$type.'||'.number_format($grosspay,2,'.',',').'||'.number_format($totaldeductions,2,'.',',').'||'.number_format($finalnettpay,2,'.',',').'';
	}
}	
	
if ($loanbuild != '')
{
	echo $loanbuild;
}

?>
