<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$colorloopcount = '';

header("Content-Type: application/csv");
header("Content-Disposition: attachment;Filename=cars-models.csv");

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = date('Y'); }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

?>

	<?php
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
	     $searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>
	<?php
	$totalamount = '0.00';
	$query2 = "select * from payroll_assign where employeename like '%$searchemployee%' and status <> 'deleted' group by employeename";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$bankbranch = $res6['bankbranch'];
	$accountnumber = $res6['accountnumber'];
	$bankcode1 = $res6['bankcode'];
	if($bankcode1 == '') { $bankcode1 = '-'; } else { $bankcode1 = $bankcode1; }
	$explodebank = explode('-',$bankcode1);
	$bankcode = $explodebank[0];
	$branchcode = $explodebank[1];
	
	if($accountnumber != '')
	{ 

	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	} 
	?>
	<?php echo $bankcode.','; ?>
	<?php echo $branchcode.','; ?>
	<?php echo $accountnumber.','; ?>
	<?php echo $res2employeename.','; ?>
	<?php
	$totalbenefit = '';
	$query3 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentname = 'NETTPAY' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];
	$componentanum = $res3['componentanum'];
	$componentname = $res3['componentname'];
	$componentamount = $res3['componentamount'];
	
	$query912 = "select * from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec912 = mysql_query($query912) or die ("Error in Query912".mysql_error());
	while($res912 = mysql_fetch_array($exec912))
	{
	$benefitanum = $res912['auto_number'];
	$query911 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '$benefitanum' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec911 = mysql_query($query911) or die ("Error in Query911".mysql_error());
	$res911 = mysql_fetch_array($exec911);
	$res911benefits = $res911['componentamount'];
	$totalbenefit = $totalbenefit + $res911benefits;
	}
	
	$nettpay = $componentamount - $totalbenefit;
	$totalamount = $totalamount + $nettpay;
	?>
	<?php echo number_format($nettpay,0,'.','').','; ?>
	<?php echo $searchmonth.' '.$searchyear.','."\n"; ?>
	<?php
	}
	}
	?>
	<?php
	}
	?>	
