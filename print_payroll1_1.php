<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");

$colorloopcount = '';
$sno = '';
$pagebreak = '';
$totalearnings = '0.00';
$totaldeductions = '0.00';
$nettpay = '0.00';
$grosspay = '0.00';
$totalnotionalbenefit = '0.00';

ob_start();

if (isset($_REQUEST["employeecode"])) { $employeecode = $_REQUEST["employeecode"]; } else { $employeecode = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth= $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
$fullmonth = date('F-Y', strtotime($assignmonth));


$query1 = "select * from master_company";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$companycode = $res1['companycode'];
$companyname = $res1['companyname'];
$companyanum = $res1['auto_number'];

?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }
#footer .page:after { content: counter(page, upper-roman); }
.page { page-break-after:always; }

</style>
<?php include('a4pdfheader.php'); ?>
    
	
	<?php
	$totalearnings = '0.00';
	$totaldeductions = '0.00';
	$nettpay = '0.00';
	$grosspay = '0.00';
	$totalnotionalbenefit = '0.00';

	$employeesplit = explode('||',$employeecode);
	$employeelength = count($employeesplit);
	for($i=0;$i<$employeelength;$i++)
	{
		$individual = $employeesplit[$i];

	?>
	<table class="page" id="pagebreak" width="542" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
	<td align="left" valign="top" nowrap="nowrap">
	
	<table width="260" border="0" cellspacing="0" cellpadding="2"> 
        <tr>
		  <td rowspan="6" align="left" valign="top" nowrap="nowrap" class="bodytext27"><img src="logofiles/<?php echo $companyanum; ?>.jpg" height="60" width="50" /></td>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo $companyname; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>PAY SLIP : <?php echo $fullmonth; ?></strong></td>
        </tr>
		<?php
		$query2 = "select * from master_employee where employeecode = '$employeesplit[$i]'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$employeename = $res2['employeename'];
		$res2employeecode = $res2['employeecode'];
		
		$query3 = "select * from master_employeeinfo where employeecode = '$employeesplit[$i]'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$pinno = $res3['pinno'];
		$nssfno = $res3['nssf'];
		$nhifno = $res3['nhif'];
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Name : <?php echo $employeename; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Payroll No : <?php echo $res2employeecode; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Pin No : <?php echo $pinno; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> NSSF : <?php echo $nssfno.' , '.'NHIF : '.$nhifno; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		</table>
		<table width="260" border="0" cellspacing="0" cellpadding="2"> 
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EARNINGS</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>AMOUNT</strong>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$totalearnings = '0.00';
		$totaldeductions = '0.00';
		$nettpay = '0.00';
		$grosspay = '0.00';
		$totalnotionalbenefit = '0.00';
		$res5componentamount = '0.00';
		$res51componentamount = '0.00';
		$totaldeduct = '0.00';

		$query3 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res3 = mysqli_fetch_array($exec3))
		{
			$res3componentanum = $res3['componentanum'];
			
			$query6 = "select * from master_payrollcomponent where auto_number = '$res3componentanum' and recordstatus <> 'deleted' and notional = 'No'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6componentname = $res6['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res3['componentname'];
				$res3componentrate = $res3['componentrate'];
				$res3componentunit = $res3['componentunit'];
				$res3componentamount = $res3['componentamount'];
				
				$totalearnings = $totalearnings + $res3componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res3componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res3componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<!--<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NOTIONAL BENEFITS'; ?></strong></td>
        </tr>-->
		<?php
		$query7 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res7 = mysqli_fetch_array($exec7))
		{
			$res7componentanum = $res7['componentanum'];
			
			$query8 = "select * from master_payrollcomponent where auto_number = '$res7componentanum' and recordstatus <> 'deleted' and notional = 'Yes'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8componentname = $res8['componentname'];
			if($res8componentname != '')
			{
				$res7componentname = $res7['componentname'];
				$res7componentrate = $res7['componentrate'];
				$res7componentunit = $res7['componentunit'];
				$res7componentamount = $res7['componentamount'];
				
				$totalnotionalbenefit = $totalnotionalbenefit + $res7componentamount;
				
				$totalearnings = $totalearnings + $res7componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res7componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res7componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		}
		?>
		<?php
		$query81 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and componentanum = '0' and typecode = '10' and status <> 'deleted'";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res81 = mysqli_fetch_array($exec81);
		$res81componentname = $res81['componentname'];
		if($res81componentname != '')
		{
			$res81componentname = $res81['componentname'];
			$res81componentrate = $res81['componentrate'];
			$res81componentunit = $res81['componentunit'];
			$res81componentamount = $res81['componentamount'];
			
			$totalnotionalbenefit = $totalnotionalbenefit + $res81componentamount;
			
			$totalearnings = $totalearnings + $res81componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res81componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res81componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL EARNINGS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totalearnings,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TAX CALCULATION'; ?></strong></td>
        </tr>
		<?php
		$query79 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted' order by auto_number";
		$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die ("Error in Query79".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res79 = mysqli_fetch_array($exec79))
		{
			$res79componentanum = $res79['componentanum'];
			
		$query5 = "select * from master_payrollcomponent where auto_number = '$res79componentanum' and deductearning = 'Yes' and recordstatus <> 'deleted'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res5 = mysqli_fetch_array($exec5);
		$res5componentname = $res5['componentname'];
		if($res5componentname != '')
		{
		$res79componentrate = $res79['componentrate'];
		$res79componentunit = $res79['componentunit'];
		$res79componentamount = $res79['componentamount'];
		
		$totaldeduct = $totaldeduct + $res79componentamount;
		
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res5componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($res79componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		}
		$taxablepay = $totalearnings - $totaldeduct;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAXABLE PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxablepay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$query52 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and componentanum = '8' and status <> 'deleted'";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res52 = mysqli_fetch_array($exec52);
		$res52componentname = $res52['componentname'];
		$res52componentrate = $res52['componentrate'];
		$res52componentunit = $res52['componentunit'];
		$res52componentamount = $res52['componentamount'];
		if($res52componentname != '')
		{
			$query53 = "select * from master_taxrelief where status <> 'deleted'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die ("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$res53amount = $res53['finalamount'];
			
			$query7 = "select * from insurance_relief where employeecode = '$employeesplit[$i]' and status <> 'deleted'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7employeecode = $res7['employeecode'];
			$res7includepaye = $res7['includepaye'];
			$res7premium = $res7['premium'];
			$res7tax = $res7['taxpercent'];
			if($res7employeecode != '' && $res7includepaye == 'Yes')
			{
				$insurancerelief = $res7premium * ($res7tax / 100);
			}
			else
			{
				$insurancerelief = '0.00';
			}
			
			$taxcharged = $res53amount + $res52componentamount + $insurancerelief;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX CHARGED'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxcharged,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res53amount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		if($insurancerelief != '0.00')
		{
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'INSURANCE RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($insurancerelief,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'DEDUCTIONS'; ?></strong></td>
        </tr>
		<?php
		$query4 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '20' and status <> 'deleted' order by auto_number";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res4 = mysqli_fetch_array($exec4))
		{
			$res4componentanum = $res4['componentanum'];
			$res4componentname = $res4['componentname'];
			$res4componentrate = $res4['componentrate'];
			$res4componentunit = $res4['componentunit'];
			$res4componentamount = $res4['componentamount'];
			
			$totaldeductions = $totaldeductions + $res4componentamount;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res4componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res4componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		
		$grosspay = $totalearnings - $totalnotionalbenefit;
		$nettpay = $grosspay - $totaldeductions;
		?>
		<!--<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totaldeductions,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>-->
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>SUMMARY</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TOTAL EARNINGS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalearnings,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'NOTIONAL BENEFITS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totalnotionalbenefit,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'GROSS PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($grosspay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'DEDUCTIONS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NET SALARY'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($nettpay,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>RECEIVED BY :</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>LOAN DETAILS</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<?php
		$query55 = "select sum(amount) as totalloan, loanname from loan_assign where employeecode = '$employeesplit[$i]' and status <> 'deleted'";
		$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res55 = mysqli_fetch_array($exec55);
		$loanname = $res55['loanname'];
		$totalloan = $res55['totalloan'];
		if($loanname == '')
		{
			$loanname = '';
			$totalloan = '0.00';
		}	
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Loan Amount :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalloan,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		$query56 = "select sum(monthamount) as totalloanpaid from details_loanpay where employeecode = '$employeesplit[$i]' and loanname = '$loanname' and status <> 'deleted'";
		$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die ("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res56 = mysqli_fetch_array($exec56);
		$totalloanpaid = $res56['totalloanpaid'];
		if($totalloanpaid == '')
		{
			$totalloanpaid = '0.00';
		}
		$balance = $totalloan - $totalloanpaid;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Loan Paid :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalloanpaid,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Balance :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($balance,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		
     </table>
	</td>  
	<?php
	//$i++;
	?>
	<td align="left" valign="top" nowrap="nowrap">
	<?php
	$query2 = "select * from master_employee where employeecode = '$employeesplit[$i]'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$employeename = $res2['employeename'];
	if($employeename != '')
	{
	?>
	<table width="260" border="0" cellspacing="0" cellpadding="2"> 
        <tr>
		 <td rowspan="6" align="left" valign="top" nowrap="nowrap" class="bodytext27"><img src="logofiles/<?php echo $companyanum; ?>.jpg" height="60" width="50" /></td>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo $companyname; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>PAY SLIP : <?php echo $fullmonth; ?></strong></td>
        </tr>
		<?php
		$query2 = "select * from master_employee where employeecode = '$employeesplit[$i]'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$employeename = $res2['employeename'];
		$res2employeecode = $res2['employeecode'];
		
		$query3 = "select * from master_employeeinfo where employeecode = '$employeesplit[$i]'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$pinno = $res3['pinno'];
		$nssfno = $res3['nssf'];
		$nhifno = $res3['nhif'];
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Name : <?php echo $employeename; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Payroll No : <?php echo $res2employeecode; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Pin No : <?php echo $pinno; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> NSSF : <?php echo $nssfno.' , '.'NHIF : '.$nhifno; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		</table>
		<table width="260" border="0" cellspacing="0" cellpadding="2"> 
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EARNINGS</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>AMOUNT</strong>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$totalearnings = '0.00';
		$totaldeductions = '0.00';
		$nettpay = '0.00';
		$grosspay = '0.00';
		$totalnotionalbenefit = '0.00';
		$res5componentamount = '0.00';
		$res51componentamount = '0.00';
		$totaldeduct = '0.00';

		$query3 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res3 = mysqli_fetch_array($exec3))
		{
			$res3componentanum = $res3['componentanum'];
			
			$query6 = "select * from master_payrollcomponent where auto_number = '$res3componentanum' and recordstatus <> 'deleted' and notional = 'No'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6componentname = $res6['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res3['componentname'];
				$res3componentrate = $res3['componentrate'];
				$res3componentunit = $res3['componentunit'];
				$res3componentamount = $res3['componentamount'];
				
				$totalearnings = $totalearnings + $res3componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res3componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res3componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<!--<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NOTIONAL BENEFITS'; ?></strong></td>
        </tr>-->
		<?php
		$query7 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res7 = mysqli_fetch_array($exec7))
		{
			$res7componentanum = $res7['componentanum'];
			
			$query8 = "select * from master_payrollcomponent where auto_number = '$res7componentanum' and recordstatus <> 'deleted' and notional = 'Yes'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8componentname = $res8['componentname'];
			if($res8componentname != '')
			{
				$res7componentname = $res7['componentname'];
				$res7componentrate = $res7['componentrate'];
				$res7componentunit = $res7['componentunit'];
				$res7componentamount = $res7['componentamount'];
				
				$totalnotionalbenefit = $totalnotionalbenefit + $res7componentamount;
				
				$totalearnings = $totalearnings + $res7componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res7componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res7componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		}
		?>
		<?php
		$query81 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and componentanum = '0' and typecode = '10' and status <> 'deleted'";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res81 = mysqli_fetch_array($exec81);
		$res81componentname = $res81['componentname'];
		if($res81componentname != '')
		{
			$res81componentname = $res81['componentname'];
			$res81componentrate = $res81['componentrate'];
			$res81componentunit = $res81['componentunit'];
			$res81componentamount = $res81['componentamount'];
			
			$totalnotionalbenefit = $totalnotionalbenefit + $res81componentamount;
			
			$totalearnings = $totalearnings + $res81componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res81componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res81componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL EARNINGS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totalearnings,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TAX CALCULATION'; ?></strong></td>
        </tr>
		<?php
		$query79 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted' order by auto_number";
		$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die ("Error in Query79".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res79 = mysqli_fetch_array($exec79))
		{
			$res79componentanum = $res79['componentanum'];
			
		$query5 = "select * from master_payrollcomponent where auto_number = '$res79componentanum' and deductearning = 'Yes' and recordstatus <> 'deleted'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res5 = mysqli_fetch_array($exec5);
		$res5componentname = $res5['componentname'];
		if($res5componentname != '')
		{
		$res79componentrate = $res79['componentrate'];
		$res79componentunit = $res79['componentunit'];
		$res79componentamount = $res79['componentamount'];
		
		$totaldeduct = $totaldeduct + $res79componentamount;
		
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res5componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($res79componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		}
		$taxablepay = $totalearnings - $totaldeduct;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAXABLE PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxablepay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$query52 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and componentanum = '8' and status <> 'deleted'";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res52 = mysqli_fetch_array($exec52);
		$res52componentname = $res52['componentname'];
		$res52componentrate = $res52['componentrate'];
		$res52componentunit = $res52['componentunit'];
		$res52componentamount = $res52['componentamount'];
		if($res52componentname != '')
		{
			$query53 = "select * from master_taxrelief where status <> 'deleted'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die ("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$res53amount = $res53['finalamount'];
			
			$query7 = "select * from insurance_relief where employeecode = '$employeesplit[$i]' and status <> 'deleted'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7employeecode = $res7['employeecode'];
			$res7includepaye = $res7['includepaye'];
			$res7premium = $res7['premium'];
			$res7tax = $res7['taxpercent'];
			if($res7employeecode != '' && $res7includepaye == 'Yes')
			{
				$insurancerelief = $res7premium * ($res7tax / 100);
			}
			else
			{
				$insurancerelief = '0.00';
			}
			
			$taxcharged = $res53amount + $res52componentamount + $insurancerelief;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX CHARGED'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxcharged,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res53amount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		if($insurancerelief != '0.00')
		{
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'INSURANCE RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($insurancerelief,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'DEDUCTIONS'; ?></strong></td>
        </tr>
		<?php
		$query4 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '20' and status <> 'deleted' order by auto_number";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res4 = mysqli_fetch_array($exec4))
		{
			$res4componentanum = $res4['componentanum'];
			$res4componentname = $res4['componentname'];
			$res4componentrate = $res4['componentrate'];
			$res4componentunit = $res4['componentunit'];
			$res4componentamount = $res4['componentamount'];
			
			$totaldeductions = $totaldeductions + $res4componentamount;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res4componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res4componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		
		$grosspay = $totalearnings - $totalnotionalbenefit;
		$nettpay = $grosspay - $totaldeductions;
		?>
		<!--<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totaldeductions,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>-->
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>SUMMARY</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TOTAL EARNINGS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalearnings,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'NOTIONAL BENEFITS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totalnotionalbenefit,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'GROSS PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($grosspay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'DEDUCTIONS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NET SALARY'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($nettpay,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>RECEIVED BY :</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>LOAN DETAILS</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<?php
		$query55 = "select sum(amount) as totalloan, loanname from loan_assign where employeecode = '$employeesplit[$i]' and status <> 'deleted'";
		$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query55".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res55 = mysqli_fetch_array($exec55);
		$loanname = $res55['loanname'];
		$totalloan = $res55['totalloan'];
		if($loanname == '')
		{
			$loanname = '';
			$totalloan = '0.00';
		}	
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Loan Amount :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalloan,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		$query56 = "select sum(monthamount) as totalloanpaid from details_loanpay where employeecode = '$employeesplit[$i]' and loanname = '$loanname' and status <> 'deleted'";
		$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die ("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res56 = mysqli_fetch_array($exec56);
		$totalloanpaid = $res56['totalloanpaid'];
		if($totalloanpaid == '')
		{
			$totalloanpaid = '0.00';
		}
		$balance = $totalloan - $totalloanpaid;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Loan Paid :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalloanpaid,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Balance :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($balance,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		
     </table>
	 <?php
	 }
	 ?>
	</td>  
	</tr>
	</table>  
	<?php
	}
	?>
	 
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Payslip.pdf", array("Attachment" => 1)); 
?>