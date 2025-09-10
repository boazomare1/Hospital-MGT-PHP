<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companycode = $_SESSION['companycode'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";
$nettotalbenefit = '0.00';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Payrollreport.xls"');
header('Cache-Control: max-age=80');

$month = date('M-Y');

ob_start();

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }


?>
<style type="text/css">
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;
}
</style>
	
	<?php
	if ($frmflag1 == 'frmflag1')
	{
		
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		$searchmonthyear = $searchmonth.'-'.$searchyear;
		$assignmonth = $searchmonthyear;
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee";
	?>
	<table border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>PAYROLL REPORT</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr>
	<td width="26" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="101" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="99" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="99" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>DEPARTMENT</strong></td>
	<?php
	$totalamount = '0.00';
	$query1 = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, order_no";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	
	$datatotal[$componentanum] = array();
	$totnhif10 = 0;
	$totloan = 0;
	$totgross = 0;
	$totdeduct = 0;
	$totnett = 0;
	$totnettpay = 0;
	$totinsurance = 0;
	$res15amount = 0;
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="184"><strong><?php echo $componentname; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>GROSS PAY</strong></td>
	<?php
	$query1d = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, order_no";
	$exec1d = mysqli_query($GLOBALS["___mysqli_ston"], $query1d) or die ("Error in Query1d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1d = mysqli_fetch_array($exec1d))
	{
	$componentanum = $res1d['auto_number'];
	$componentname = $res1d['componentname'];
	
	$datatotal[$componentanum] = array();
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="184"><strong><?php echo $componentname; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="184"><strong><?php echo 'LOAN DEDUCTION'; ?></strong></td>
    <td align="center" bgcolor="#FFFFFF" class="bodytext3" width="184"><strong><?php echo 'INSURANCE RELIEF'; ?></strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>DEDUCTIONS</strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>NETT PAY</strong></td>
	</tr>
<?php
	$totalamount = '0.00'; $old_bankname = '';$bankname = '';
	
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename, b.bankname, b.accountnumber,  a.departmentname as departmentname from master_employee AS a JOIN master_employeeinfo AS b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and a.employeecode <> '' group by a.employeecode order by b.bankname, cast(b.payrollno as unsigned) asc";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
		
		$searchemployeename = $res2['employeename'];
		$departmentname = $res2['departmentname'];
		$res2employeecode = $res2['employeecode'];
		$res2employeename = $res2['employeename'];
		$bankname = $res2['bankname'];
		$accountnumber = $res2['accountnumber'];
		
		$query777 = mysqli_query($GLOBALS["___mysqli_ston"], "select payrollno from master_employeeinfo where employeecode = '$res2employeecode'") or die ("Error in Queryinfo".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res777 = mysqli_fetch_array($query777);
		$payrollno = $res777['payrollno'];
		
		$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$assignmonth' and `1` <>'0.00'") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row778 = mysqli_num_rows($query778);
		if($row778 > 0)
		{
		$totalpercentcalc = '0.00';
		$sumoftotalearningsfinal = '0.00';
		$sumoftotalearnings = '0.00';
		$totgrossamount = '0.00';
		$totdeductamount = '0.00';
		$totdeductamount1 = '0.00';
		$componentvalue = 0;
		
		$query777 = "select employeecode from payroll_assign where employeecode = '$res2employeecode'";
		$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die ("Error in Query777".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res777 = mysqli_fetch_array($exec777);
		$res777employeecode = $res777['employeecode'];
		
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
	
	if($colorloopcount == 1 || $old_bankname != $bankname){
		?>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>BANK : <?php echo $bankname; ?></strong></td>
	</tr>			
	<?php }
	$old_bankname = $bankname;	  
	?>
	<tr>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $departmentname; ?></td>
	<?php
	$totdeductearning = 0;
	$query3 = "select auto_number,componentname,amounttype,typecode,monthly,formula,deductearning,notional from master_payrollcomponent where recordstatus <> 'deleted' and typecode IN ('10','20') order by typecode, order_no";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
		$componentanum = $res3['auto_number'];
		$employeesearch = $res2employeecode;
		$componentname = $res3['componentname'];
		$amounttype = $res3['amounttype'];
		$typecode = $res3['typecode'];
		$monthly = $res3['monthly'];
		$deductearning = $res3['deductearning'];
		$notional = $res3['notional'];
		
		if($employeesearch != '')
		{	
			$query4 = "select payrollstatus from master_employee where employeecode = '$employeesearch'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$payrollstatus = $res4['payrollstatus'];
			//if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
			if(true)
			{
				$query5 = "select `$componentanum` as componentvalue, auto_number from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
					$componentvalue = $res5['componentvalue'];
					if($componentanum == '3')
					{
						$res15amount = $componentvalue;
					}
				}
			}
		}	
		
		
		if($typecode == '10' && $notional != 'Yes')
		{
			array_push($datatotal[$componentanum],$componentvalue);
			$totgrossamount = $totgrossamount + $componentvalue;
		}
		else if($typecode == '20' && $deductearning == 'Yes')
		{
			//$totgrossamount = $totgrossamount - $componentvalue;
		}
		
		if($typecode == '10')
		{
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentvalue > 0) { echo number_format($componentvalue,2,'.',','); } ?></td>	
	<?php
		}	
	}
	?>
	<td align="right" class="bodytext3"><?php if($totgrossamount > 0) { echo number_format($totgrossamount,2,'.',','); } ?></td>	
	<?php
	$query3d = "select auto_number,componentname,amounttype,typecode,monthly,formula,deductearning from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, order_no";
	$exec3d = mysqli_query($GLOBALS["___mysqli_ston"], $query3d) or die ("Error in Query3d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3d = mysqli_fetch_array($exec3d))
	{
		$componentanum = $res3d['auto_number'];
		$employeesearch = $res2employeecode;
		$componentname = $res3d['componentname'];
		$amounttype = $res3d['amounttype'];
		$typecode = $res3d['typecode'];
		$monthly = $res3d['monthly'];
		$deductearning = $res3d['deductearning'];
		
		if($employeesearch != '')
		{	
			$query4 = "select payrollstatus from master_employee where employeecode = '$employeesearch'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$payrollstatus = $res4['payrollstatus'];
			//if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
			if(true)
			{
				$query5 = "select `$componentanum` as componentvalue, auto_number from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
					$componentvalue = $res5['componentvalue'];
					if($componentanum == '3')
					{
						$res15amount = $componentvalue;
					}
				}
			}
		}	
		
		array_push($datatotal[$componentanum],$componentvalue);
		
		if($typecode == '10')
		{
			$totgrossamount = $totgrossamount + $componentvalue;
		}
		else if($typecode == '20')
		{
			$totdeductamount = $totdeductamount + $componentvalue;
		}
		if($deductearning == 'Yes')
		{
			//$totdeductamount = $totdeductamount - (2*$componentvalue);
		}
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentvalue > 0) { echo number_format($componentvalue,2,'.',','); } ?></td>	
	<?php
	}	
	?>
	<?php
	$loanamount = 0;
	$res15amount = 0;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$assignmonth' and employeecode = '$employeesearch'";
	$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res80 = mysqli_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	
	$query86 = "select sum(insurancerelief) as insurancerelief from details_employeepayroll where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
	$exec86 = mysqli_query($GLOBALS["___mysqli_ston"], $query86) or die ("Error in Query86".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res86 = mysqli_fetch_array($exec86);
	$insurancerelief = $res86['insurancerelief'];	
	
	$totdeductamount = $totdeductamount + $loanamount + $res15amount;
	$totnettpay = $totgrossamount - $totdeductamount; 
	
	$totnhif10 += $res15amount;
	$totloan += $loanamount;
	$totgross += $totgrossamount;
	$totdeduct += $totdeductamount;
	$totnett += $totnettpay;
	$totinsurance += $insurancerelief;
	?>
	<td align="right" class="bodytext3"><?php if($loanamount > 0) { echo number_format($loanamount,2,'.',','); } ?></td>	
    <td align="right" class="bodytext3"><?php if($insurancerelief > 0) { echo number_format($insurancerelief,2,'.',','); } ?></td>	
	<td align="right" class="bodytext3"><?php if($totdeductamount > 0) { echo number_format($totdeductamount,2,'.',','); } ?></td>	
	<td align="right" class="bodytext3"><?php if($totnettpay > 0) { echo number_format($totnettpay,2,'.',','); } ?></td>
	</tr>	
	<?php
	}
	}
	?>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="right" class="bodytext3"><strong>Total :</strong></td>
	<?php
	$query1 = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, order_no";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$i = $res1['auto_number'];	  	
	?>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if(array_sum($datatotal[$i]) > 0) { echo number_format(array_sum($datatotal[$i]),3); } ?></strong></td>
	<?php
	}
	?>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if($totgross > 0) { echo number_format($totgross,3); } ?></strong></td>
	<?php
	$query4d = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, order_no";
	$exec4d = mysqli_query($GLOBALS["___mysqli_ston"], $query4d) or die ("Error in Query4d".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res4d = mysqli_fetch_array($exec4d))
	{
	$j = $res4d['auto_number'];		
	?>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if(array_sum($datatotal[$j]) > 0) { echo number_format(array_sum($datatotal[$j]),3); } ?></strong></td>
	<?php
	}
	?>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if($totloan > 0) { echo number_format($totloan,3); } ?></strong></td>
    <td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if($totinsurance > 0) { echo number_format($totinsurance,3); } ?></strong></td>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if($totdeduct > 0) { echo number_format($totdeduct,3); } ?></strong></td>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3"><strong><?php if($totnett > 0) { echo number_format($totnett,3); } ?></strong></td>
	</tr>
	</tbody>
	</table> 
	<?php
	}
	?>