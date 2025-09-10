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
header('Content-Disposition: attachment;filename="Payereport.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }
#footer .page:after { content: counter(page, upper-roman); }

.page { page-break-after:always; }
</style>
<?php //include("a4pdfheader1.php"); ?>	

	<?php
	if($frmflag1 == 'frmflag1')
	{
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>	
	<table width="500" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="36" align="left" class="bodytext3"><strong>PAYE REPORT</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="36" align="left" class="bodytext3"><strong>EMPLOYER'S PIN : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="36" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="36" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchyear.'-'.date('m',strtotime($searchmonth)); ?></strong></td>
	</tr>
	<tr>
    
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Pin of Employee</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Name of Employee</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Residential Status</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Type of Employee</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Basic Salary</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Housing Allowance</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Transport Allowance</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Leave Pay</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Overtime Allowance</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Director's Fee</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Lumpsum Payment if any</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Other Allowance</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Total Cash Pay</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Value of Car Benefit</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Other Non Cash Benefits</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Total Non Cash Pay</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Global Income</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Type of housing</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Rent of House / Market Value</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Computed rent of House</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Rent Recovered from Employee</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Net Value of Housing</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Total Gross Pay</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>30% of Cash Pay</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Actual Contribution</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Permissible Limit</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Mortgage  Interest (Max Ksh 25000 per month)</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Deposit on Home Savings Plan (Max Ksh48000 or Ksh 4000per month)</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Amount of Benefits</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Taxable Pay</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax Payable</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Monthly Personal Relief</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Amount of Insurance Relief</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>PAYE Tax</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>Self Assessed PAYE Tax</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"></td>
	</tr>
	<?php   
	$totalamount = '0.00';$basic_salary = '0.00';$net_salary = '0.00';$gross_salary = 
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename, 1 as basic from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
		$query777 = mysqli_query($GLOBALS["___mysqli_ston"], "select payrollno from master_employeeinfo where employeecode = '$res2employeecode'") or die ("Error in Queryinfo".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res777 = mysqli_fetch_array($query777);
		$payrollno = $res777['payrollno'];
	
	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode, govt_employee from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row778 = mysqli_num_rows($query778);
	$res778 = mysqli_fetch_array($query778);
	if($row778 > 0)
	{
	$govt_employee = $res778['govt_employee'];
	
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
	 ?>
	<tr>

	<td align="left" class="bodytext3"><?php echo preg_replace("/[^a-zA-Z0-9]/", "",$pinno); ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3">Resident</td>

	<td align="left" class="bodytext3"><?php if($govt_employee=='Yes'){echo 'Secondary Employee';} else { echo 'Primary Employee';} ?></td>
	<?php 
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
	 ?>
	<td align="right" class="bodytext3" width="77"><?php
	$basic_salary = $componentamount;
	 echo number_format($componentamount,2,'.',','); ?></td>
	<?php 
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
	 ?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($componentamount,2,'.',','); ?></td>
	<?php 
	}
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
	 ?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($componentamount,2,'.',','); ?></td>
	<?php 
	}?>
    <td align="right" class="bodytext3" width="77">0</td>
    <td align="right" class="bodytext3" width="77">0</td>
    <td align="right" class="bodytext3" width="77">0</td>
    <td align="right" class="bodytext3" width="77">0</td>
    <?php 
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
	 ?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($componentamount,2,'.',','); ?></td>
	<?php 
	}?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($total_cash,2,'.',','); ?></td>
	<td align="right" class="bodytext3" width="77">0</td>
	<td align="right" class="bodytext3" width="77">0</td>
	<td align="right" class="bodytext3" width="77"> </td>
	<td align="right" class="bodytext3" width="77"></td>
	<td align="right" class="bodytext3" width="77"></td>
	<td align="right" class="bodytext3" width="77">0</td>
	<td align="right" class="bodytext3" width="77">Benefit Not Given</td>
	<td align="right" class="bodytext3" width="77"></td>
	<td align="right" class="bodytext3" width="77"></td>
	<td align="right" class="bodytext3" width="77"></td>
	<td align="right" class="bodytext3" width="77"></td>
	<td align="right" class="bodytext3" width="77"><?php 
	$gross_salary = $total_cash;
	echo number_format($total_cash,2,'.',','); ?></td>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($total_cash*0.3,2,'.',','); ?></td>
    <?php 
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
	 ?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($componentamount,2,'.',','); ?></td>
	<?php 
	}?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format(20000,2,'.',','); ?></td> 
	<td align="right" class="bodytext3" width="77">0</td> 
	<td align="right" class="bodytext3" width="77">0</td> 
    <?php 
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '3' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	 ?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($componentamount,2,'.',','); ?></td>
	<?php 
	}?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($total_cash,2,'.',','); ?></td>
    <?php 
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '4' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];

	$query3 = "select relief_bf,tax_relief,insurancerelief from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	 ?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($componentamount+$res3['tax_relief'],2,'.',','); ?></td>
	<?php 
	}?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($res3['tax_relief'],2,'.',','); ?></td> 
	<td align="right" class="bodytext3" width="77"></td> 
	<td align="right" class="bodytext3" width="77"></td> 
	<td align="right" class="bodytext3" width="77"><?php if(($componentamount-$res3['insurancerelief']) > 0){echo number_format($componentamount-$res3['insurancerelief'],2,'.',',');}else{echo 0;} ?></td>
    <td>
    <?php 
	$pinno = preg_replace("/[^a-zA-Z0-9]/", "",$pinno);
	if( strlen($pinno) !== 11 ||is_numeric(substr($pinno, 0, 1)) ||  is_numeric(substr($pinno, -1, 1))){
		echo '<font style="color:red;"> PIN Number is in an invalid format</font>';
	}
	 ?>
    </td>
    
    <?php
	}
	}
	 ?>
	</tr>
	</tbody>
	</table> 
	<?php
	}
	?>
