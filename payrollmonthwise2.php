<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';
$colorloopcount = '';
$month = date('M-Y');
$sno = '';
$docno = $_SESSION['docno'];
$assignmonth1 = $_REQUEST['assignmonth1'];

	function round_calc($value)
	{
		$testval1 = explode(".",$value);
		$whole = $testval1[0];
		$decimal = $testval1[1];
		if($decimal > 0)
		{
			$whole = $whole + 1;
		}
		return $whole; 	 
	}
	
	$query245 = "select employeecode from master_employee group by employeecode order by employeecode";
	$exec245 = mysqli_query($GLOBALS["___mysqli_ston"], $query245) or die ("Error in Query245".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res245 = mysqli_fetch_array($exec245))
	{
		$res2employeecode = $res245['employeecode'];
		$employeesearch = $res2employeecode;
		
		$query912 = "select employeecode from payroll_assign where status <> 'deleted' and employeecode = '$res2employeecode' and componentamount = '0' and monthly = 'Yes'";
		$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die ("Error in Query912".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row912 = mysqli_num_rows($exec912);
		if($row912 > 0) {
		include('autoemployeepayrollcalculation3.php'); 
		}
	}
	
	header("location:payrollmonthwise1.php?frmflag34=frmflag34&&assignmonth1=$assignmonth1");

?>	