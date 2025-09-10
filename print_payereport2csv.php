<?php
ob_start();
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

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
ini_set('auto_detect_line_endings',TRUE);
$filename="P10-".$searchmonth."-".$searchyear.".csv";
$list = array();
//echo('<a href="'.$filename.'">'.$filename.'</a><br/>');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['employername'];

?>

	<?php
	if($frmflag1 == 'frmflag1')
	{
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
	 
	$totalamount = '0.00';
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename, 1 as basic from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
		$query777 = mysqli_query($GLOBALS["___mysqli_ston"], "select payrollno from master_employeeinfo where employeecode = '$res2employeecode'") or die ("Error in Queryinfo".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res777 = mysqli_fetch_array($query777);
		$payrollno = $res777['payrollno'];
	
	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode,govt_employee from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row778 = mysqli_num_rows($query778);
	if($row778 > 0)
	{
	$govt_employee = $row778['govt_employee'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$pinno = $res6['pinno'];
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#CBDBFA"';
	}
	else
	{
		$colorcode = 'bgcolor="#ecf0f5"';
	}
	
	
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '1' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	} 

	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '15' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount += $res3['componentamount'];
	} 
	
	if($componentamount < 1){continue;}
	
	$data =  $pinno.',';
	$data.= $res2employeename.',';
	$data.= 'Resident,';
	if($govt_employee=='Yes'){$emp_typ = 'Secondary Employee';} else { $emp_typ = 'Primary Employee';}
	$data.= $emp_typ.',';
	$total_cash =0;
	$total_cash =0;
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '1' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	$total_cash +=$componentamount;
	$totalamount = $totalamount + $componentamount;
	}
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '15' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount += $res3['componentamount'];
	$total_cash =$componentamount;
	$totalamount = $totalamount + $componentamount;
	}
	$data.= $componentamount.',';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '8' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	$total_cash +=$componentamount;
	$totalamount = $totalamount + $componentamount;
	}
	$data.= $componentamount.',';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '22' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	$total_cash +=$componentamount;
	$totalamount = $totalamount + $componentamount;
	}
	$data.= $componentamount.',';
	$data.='0,0,0,0,';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '16' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	$total_cash +=$componentamount;
	$totalamount = $totalamount + $componentamount;
	}
	$data.= $componentamount.',';
	//$data.= $total_cash.',';
	$data.=',0,0,,0,';
	$data.='Benefit Not Given,';
	$data.=',,,,,,';
	//$data.= $total_cash.',';
	//$data.= $total_cash*0.3.',';
	
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '3' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	$total_cash -=$componentamount;
	$totalamount = $totalamount + $componentamount;
	}
	$data.= $componentamount.',';
	$data.= ',0,0,';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '3' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	}
	//$data.= $componentamount.',';
	//$data.= $total_cash.',';
	$data.= ',,,';
	
	$query3 = "select `4` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];

	$query3 = "select relief_bf,tax_relief,insurancerelief from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$tax_relief = $res3['tax_relief'];
	$insurancerelief = $res3['insurancerelief'];
	
	//$data.= $componentamount+$tax_relief.','.$tax_relief.','.$insurancerelief.',0,';
	$data.= $tax_relief.','.$insurancerelief.',,';
	$data.= $componentamount-$insurancerelief.',';
	array_push($list, $data);
	}
	}
}
ob_end_clean();

$file = fopen($filename,"w+");

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Pragma: no-cache');
header('Expires: 0');
$fp = fopen('php://output', 'w');
ini_set('auto_detect_line_endings',TRUE);
$list=preg_replace('/(\r\n|\r|\n)/s',"\n",$list);
foreach ( $list as $line ) {
$val = explode(",", $line);
fputcsv($fp, $val);
}
$lines = file($filename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
$num_rows = count($lines);
foreach ($lines as $line) {
    $csv = str_getcsv($line);
     if (count(array_filter($csv)) == 0) {
        $num_rows--;
    }
}
fclose($fp);

exit();
?>

