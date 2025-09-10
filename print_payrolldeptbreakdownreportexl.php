<?php
require_once('html2pdf/html2pdf.class.php');
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
$colorloopcount = "";

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
			if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
			if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
			if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
			if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
			if (isset($_REQUEST["searchdept"])) { $searchdept = $_REQUEST["searchdept"]; } else { $searchdept = ""; }
		


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="print_payrolldeptbreakdownreportexl.xls"');
header('Cache-Control: max-age=80');

		
?>
<style><!--
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 10px;padding: 2px;}
table{table-layout:fixed;
width:95%;
display:table;
border-collapse:collapse;} -->

</style>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height:150px; }
#footer .page:after { content: counter(page, upper-roman); }
td{{height: 30px;padding: 2px;}
.page { page-break-after:always; }
</style>

				<?php
				
				$totalamount = '0.00';
				if($frmflag1 == 'frmflag1')
				{	
					if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
					if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
					if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
					if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
					if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
					if (isset($_REQUEST["searchdept"])) { $searchdept = $_REQUEST["searchdept"]; } else { $searchdept = ""; }
					//if (isset($_REQUEST["assignmonth"])) { $assignmonth= $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
					
					$assignmonth = $searchmonth.'-'.$searchyear; 
					
					$fullmonth = date('F-Y', strtotime($assignmonth));
					$assignmonthsp = explode('-',$assignmonth);
					$tyear = $assignmonthsp[1];
					
					$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchdept=$searchdept";

				?>	
				<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
				<tbody>
					<tr bgcolor="#FFFFFF">
						<td colspan="4" align="center" class="bodytext3"><strong>&nbsp;</strong></td>
					</tr>
					<tr bgcolor="#ecf0f5">
						<td colspan="4" align="left" class="bodytext3"><strong>Departmental Breardown</strong></td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td colspan="2" align="left" class="bodytext3"  ><strong>&nbsp;</strong></td>
						<td align="left" class="bodytext3" ><strong>EMPLOYER'S PIN : <?php echo $companycode; ?></strong></td>
						
						<td align="right" rowspan="3" class="bodytext3"> &nbsp;</td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
						<td align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
					</tr>
					<tr bgcolor="#FFFFFF">
						<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
						<td align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $assignmonth; ?></strong></td>
					</tr>
					
					<tr bgcolor="#ecf0f5">
						<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
						<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
					</tr>
					<!--
					<tr>
						<td width="25"  align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
						<td width="210" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>ED DESCRIPTION</strong></td>
						<td width="80" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>MTH AMOUNT</strong></td>
						<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEES</strong></td>
						
					</tr>-->
<?php
		
	$query9 = "select departmentname from master_employee where departmentname like '%$searchdept%' group by departmentname order by departmentname ASC";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res9 = mysqli_fetch_array($exec9))
	{
		$departmentname = $res9['departmentname'];
	?>
		<tr>
			<td colspan="4" align = "left" class="bodytext3" bgcolor="#FFFFFF"><strong><?php echo $departmentname; ?></strong></td>
		</tr>
	<?php
	
		$query10 = "select departmentname,departmentunit from master_employeeinfo where departmentname = '$departmentname' group by departmentunit order by departmentunit ASC";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res10 = mysqli_fetch_array($exec10))
		{
			$departmentname10 = $res10['departmentname'];
			$departmentunit = $res10['departmentunit'];
				
			if($departmentunit !=''){
					
	?>
		<tr>
			<td align = "left" class="bodytext3" bgcolor="#FFFFCF">&nbsp;</td>
			<td colspan="3" align = "left" class="bodytext27" bgcolor="#FFFFCF"><strong><?php echo $departmentunit; ?></strong></td>
		</tr>
	<?php
				
/* 				$query11 = "select employeecode,payrollno from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit'  order by departmentunit ASC";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$numrowscnt11 = mysqli_num_rows($exec11);
				while($res11 = mysqli_fetch_array($exec11))
				{
					$employeecode = $res11['employeecode']; */
	?>
				<tr>
					<td colspan="2" align = "left" class="bodytext3" bgcolor="#FFFFFF"> </td>
					<td colspan="2" align = "left" class="bodytext3" bgcolor="#FFFFFF">
					
		<table width="360" border="0" cellspacing="0" cellpadding="2"> 
		<tr>
			<td width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>ED DESCRIPTION</strong></td>
			<td width="180" align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>MTH AMOUNT</strong> &nbsp;</td>
			<td width="120" align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EMPLOYEES</strong> &nbsp;</td>
		</tr>
		<tr>
			<td width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext27" colspan="3" ><strong>EARNINGS</strong></td>
			
		</tr>
		<?php
		$totalearnings = '0.00';
		$totaldeductions = '0.00';
		$nettpay = '0.00';
		$grosspay = '0.00';
		$res3componentamount = '0.00'; 
		$totalnotionalbenefit = '0.00';
		$res5componentamount = '0.00';
		$res51componentamount = '0.00';
		$totaldeduct = '0.00';
		$totalemp = '0';
		$noofemp = '0';
		$totalnumemp = array();
		
		//$query3 = "select * from details_employeepayroll where employeecode = '$employeecode' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted'  order by auto_number";
		$query3 = "select auto_number, componentname from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted' and notional = 'No' order by order_no";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res3 = mysqli_fetch_array($exec3))
		{
			$res3componentanum = $res3['auto_number'];
			
			//$query6 = "select `$res3componentanum` as componentamount from details_employeepayroll where employeecode = '$employeecode' and paymonth = '$assignmonth'";
			
			$query612 = "select `$res3componentanum` as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and `$res3componentanum` <> '0.00'";
			$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die ("Error in Query612".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow = mysqli_num_rows($exec612);
			$totalnumemp[] = $numrow;
			
			$query6 = "select sum(`$res3componentanum`) as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth'";
			
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if($numrow > 0){
			
			$res6 = mysqli_fetch_array($exec6);
			$res6componentname = $res3['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res3['componentname'];
				$res3componentamount = $res6['componentamount'];
				
				$totalearnings = $totalearnings + $res3componentamount;		
				if($res3componentamount != '0')	{
				//$totalemp = $totalemp + 1;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res3componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res3componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow; ?>&nbsp;</td>
        </tr>	
		<?php
				}
			}
			
			}
		}
		?>
		<tr>
			<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		</tr>
		<!--<tr>
			<td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NOTIONAL BENEFITS'; ?></strong></td>
		</tr>-->
		
		<tr>
			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL EARNINGS'; ?></strong></td>
			<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totalearnings,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php rsort($totalnumemp); print_r($totalnumemp[0]);?>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		</tr>
		
		<tr>
			<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TAX CALCULATION'; ?></strong></td>
		</tr>
		
		<?php
		 $query79 = "select auto_number, componentname from master_payrollcomponent where deductearning = 'Yes' and recordstatus <> 'deleted' order by order_no";
		$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die ("Error in Query79".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res79 = mysqli_fetch_array($exec79))
		{
			$res79componentanum = $res79['auto_number'];
			
			$query613 = "select `$res79componentanum` as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted' and `$res79componentanum` <> '0.00'";
			$exec613 = mysqli_query($GLOBALS["___mysqli_ston"], $query613) or die ("Error in Query613".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow1 = mysqli_num_rows($exec613);
			
		$query5 = "select sum(`$res79componentanum`) as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		if($numrow1 > 0){
			
		$res5 = mysqli_fetch_array($exec5);
		$res5componentname = $res79['componentname'];
		if($res5componentname != '')
		{
		$res79componentamount = $res5['componentamount'];
		
		$totaldeduct = $totaldeduct + $res79componentamount;
		if($res79componentamount != '0')
		{
		?>
		<tr>
			<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res5componentname; ?></td>
			<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($res79componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
			<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow1; ?>&nbsp;</td>
		</tr>
		<?php
		}
		}
		}
		}
		$taxablepay = $totalearnings - $totaldeduct;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAXABLE PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxablepay,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="center" valign="middle" nowrap="nowrap" class="bodytext27">&nbsp;&nbsp;</td>
        </tr>
		<?php
		$taxcharged = 0;
		//$query52 = "select `4` as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' UNION ALL select `relief_bf` as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' ";
					
		$query522 = "select `4` as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted' AND `4` <> '0.00' UNION ALL select `relief_bf` as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted'  AND `relief_bf` <> '0.00'  ";
		$exec522 = mysqli_query($GLOBALS["___mysqli_ston"], $query522) or die ("Error in Query522".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numrow52 = mysqli_num_rows($exec522);
		
		
		$query52 = "select sum(`4`) as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted' AND `4` <> '0.00' UNION ALL select sum(`relief_bf`) as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted'  AND `relief_bf` <> '0.00'  ";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		while($res52 = mysqli_fetch_array($exec52))
		{
			$res52componentname = 'PAYE';
			$res52componentamount = $res52['componentamount'];
			$taxcharged = $taxcharged + $res52componentamount;
		}
		if($numrow52 > 0 && $taxcharged > 0){
		if(true)
		{
			$query53 = "select * from master_taxrelief where status <> 'deleted' and tyear = '$tyear'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die ("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$res53amount = $res53['finalamount'];
			
			//$query7 = "select * from insurance_relief where status <> 'deleted' ";
			$query71 = "select * from insurance_relief where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and status <> 'deleted' ";
			$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2 = mysqli_num_rows($exec52);
			
			$res71 = mysqli_fetch_array($exec71);
			$res7employeecode = $res71['employeecode'];
			$res7includepaye = $res71['includepaye'];
			$res7premium = $res71['premium'];
			$res7tax = $res71['taxpercent'];
			if($res7employeecode != '' && $res7includepaye == 'Yes')
			{
				$insurancerelief = $res7premium * ($res7tax / 100);
				$insurancerelief = ceil($insurancerelief);
			}
			else
			{
				$insurancerelief = '0.00';
			}
			
			$taxcharged = $taxcharged + $res53amount + $insurancerelief;
		}
		?>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'GROSS PAYE'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxcharged,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow52; ?>&nbsp;</td>
		  
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res53amount,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow52; ?>&nbsp;</td>
        </tr>
		<?php
		if($insurancerelief != '0.00')
		{
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'INSURANCE RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($insurancerelief,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow2; ?>&nbsp;</td>
        </tr>
		<?php
		}
		}
		?>
        <?php
		$query7 = "select auto_number, componentname from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted' and notional = 'Yes' order by order_no";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res7 = mysqli_fetch_array($exec7))
		{
			$res7componentanum = $res7['auto_number'];
			
			//$query8 = "select `$res7componentanum` as componentamount from details_employeepayroll where paymonth = '$assignmonth'";
			$query812 = "select `$res7componentanum` as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' AND `$res7componentanum` <> '0.00'";
			$exec812 = mysqli_query($GLOBALS["___mysqli_ston"], $query812) or die ("Error in Query812".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow3 = mysqli_num_rows($exec812);
			
			$query8 = "select sum(`$res7componentanum`) as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if($numrow3 > 0){
			
			$res8 = mysqli_fetch_array($exec8);
			$res8componentname = $res7['componentname'];
			if($res8componentname != '')
			{
				$res7componentname = $res7['componentname'];
				$res7componentamount = $res8['componentamount'];
				
				$totalnotionalbenefit = $totalnotionalbenefit + $res7componentamount;
				
				//$totalearnings = $totalearnings - $res7componentamount;	
				if($res7componentamount != '0')
				{		
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res7componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res7componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow3; ?>&nbsp;</td>
        </tr>	
		<?php
				}
			}
			}
		}
		?>
		<tr>
          <td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'DEDUCTIONS'; ?></strong></td>
        </tr>
		<?php
		$deductearningtot = 0;
		$query791 = "select auto_number, componentname, deductearning from master_payrollcomponent where typecode = '20'  and recordstatus <> 'deleted' order by order_no";
		$exec791 = mysqli_query($GLOBALS["___mysqli_ston"], $query791) or die ("Error in Query791".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res791 = mysqli_fetch_array($exec791))
		{
			$res791componentanum = $res791['auto_number'];
			$deductearning = $res791['deductearning'];
			
		$query512 = "select `$res791componentanum` as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted' AND `$res791componentanum` <> '0.00' ";
		$exec512 = mysqli_query($GLOBALS["___mysqli_ston"], $query512) or die ("Error in Query512".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numrow4 = mysqli_num_rows($exec512);
		
		$query51 = "select sum(`$res791componentanum`) as componentamount from details_employeepayroll where employeecode IN (select employeecode from master_employeeinfo where departmentname = '$departmentname10' AND  departmentunit = '$departmentunit') and paymonth = '$assignmonth' and status <> 'deleted'";
		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if($numrow4 > 0){
			
		$res51 = mysqli_fetch_array($exec51);
		
		$res4componentname = $res791['componentname'];
			$res4componentamount = $res51['componentamount'];
			
			$totaldeductions = $totaldeductions + $res4componentamount;
				
			if($res4componentamount != '0')
			{
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res4componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res4componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow4; ?>&nbsp;</td>
        </tr>	
		<?php
			}
		}
		}
		
		$grosspay = $totalearnings - $deductearningtot;
		$nettpay = $grosspay - $totaldeductions - $deductearningtot;
		?>
		<!--<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totaldeductions,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>-->
		<tr>
          <td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<!--<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>SUMMARY</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TOTAL EARNINGS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalearnings,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'GROSS PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($grosspay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr> -->
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
		   <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php print_r($totalnumemp[0]);?>&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NET SALARY'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($nettpay,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
		   <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php print_r($totalnumemp[0]);?>&nbsp;</td>
        </tr>
		<tr>
          <td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
     </table>
					
					
					
					
					
					</td>
				</tr>
	<?php
				//}	//EMPLOYEE WHILE LOOP
				
			}
		}
	}
	
	?>
				</tbody>
				</table> 
				<?php
				}
				?>
