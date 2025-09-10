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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="payment_registerreport .xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ''; }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.num {
  mso-number-format:General;
}
.text{
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;
  mso-number-format:"\@";/*force text*/
}
-->
</style>

	<?php
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
	     $searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="9" align="center" class="bodytext3"><strong>PAYMENT REGISTER </strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="9" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="9" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="9" align="left" class="bodytext3"><strong>MONTH OF PAY : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="9" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr >
	
	<td align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<td align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>BR</strong></td>
	<td align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>DPT</strong></td>
	<td align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>NUMBER</strong></td>
	<td align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>BRANCH NAME</strong></td>
	<td align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>ACCOUNT NO</strong></td>
	<td align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>NET PAY</strong></td>
	<td align="left" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query9 = "select * from master_employeeinfo where bankname like '%$searchbank%' and bankname <> '' group by bankname order by employeecode,bankname";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"],$query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res9 = mysqli_fetch_array($exec9))
	{
	$res9bankname = $res9['bankname'];
	?><!--
	<tr>
	<td colspan="9" align = "left" class="bodytext3" bgcolor="#FFFFFF"><strong><?php echo $res9bankname; ?></strong></td>
	</tr>-->
	<?php
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a JOIN master_employee b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' and (b.payrollstatus = 'Active' or b.payrollstatus = 'Prorata') group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' and bankname = '$res9bankname'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$bankbranch = $res6['bankbranch'];
	$bankname = $res6['bankname'];
	$bankcode = $res6['bankcode'];
	$accountnumber = $res6['accountnumber']; 
	$payrollno = $res6['payrollno'];
	$departmentname = $res6['departmentname'];
	
	if($accountnumber != '')
	{  

	$query61 = "select auto_number from master_payrolldepartment where department = '$departmentname'";
	$exec61 = mysqli_query($GLOBALS["___mysqli_ston"],$query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resnum61 = mysqli_num_rows($exec61);
	if($resnum61 > 0){
		$res61 = mysqli_fetch_array($exec61);
		$departmentautono = $res61['auto_number'];
	
	}else{
		$departmentautono = '';
	}


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
	<tr >
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="center" class="bodytext3"><?php echo '1'; ?></td>
	<td align="left" class="bodytext3"><?php echo $departmentautono; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $bankname." - ".$bankbranch; ?></td>
	<td align="left" class="bodytext3"><?php echo $accountnumber; ?></td>
	<?php
	$totaldeduct = 0;
	$totalgrossper = 0;
	$query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"],$query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res12 = mysqli_fetch_array($exec12))
	{
		$ganum = $res12['ganum'];
		$typecode = $res12['typecode'];
		
		$querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$execgg = mysqli_query($GLOBALS["___mysqli_ston"],$querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resgg = mysqli_fetch_array($execgg);
		$res12value = $resgg['res12value'];
		if($typecode == 10){
		$totalgrossper = $totalgrossper + $res12value; }
		else { 
		$totaldeduct = $totaldeduct + $res12value; }
	}
	$nettpay = $totalgrossper - $totaldeduct;
	$totalamount = $totalamount + $nettpay;
	?>
	<td align="right" class="bodytext3"><?php echo number_format($nettpay,0,'.',','); ?></td>
	<td align="right" class="bodytext3">&nbsp;</td>	
	<?php
	}
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="7" bgcolor="#FFFFFF" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#FFFFFF" align="left" class="bodytext3"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
	<td align="left" bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
	</tr>
	</tbody>
	</table> 
	<?php
	}
	?>	
