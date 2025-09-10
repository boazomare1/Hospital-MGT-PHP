<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
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
$assignmonthsp = explode('-',$assignmonth);
$tyear = $assignmonthsp[1];

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$companycode = $res1['companycode'];
$companyname = $res1['companyname'];
$companyanum = $res1['auto_number'];
$employername = $res1['employername'];
?>
<style>
body {
    font-family: 'Arial'; font-size:11px ;	 
}
#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }
#footer .page:after { content: counter(page, upper-roman); }
.page { page-break-after:always; }

</style>

<page pagegroup="new" backtop="8mm" backbottom="7mm" backleft="2mm" backright="3mm">

<?php include('a4pdfheader.php'); ?>
    
	
	<?php
	$totalearnings = '0.00';
	$totaldeductions = '0.00';
	$nettpay = '0.00';
	$grosspay = '0.00';
	$totalnotionalbenefit = '0.00';
	$res5componentamount = '0.00';
	$res51componentamount = '0.00';

	$employeesplit = explode('||',$employeecode);
	$employeelength = count($employeesplit);
	for($i=0;$i<$employeelength;$i++)
	{
		$individual = $employeesplit[$i];

	?>
	<table width="360" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
	<td align="left" valign="top" nowrap="nowrap">
	
	<table width="360" border="0" cellspacing="0" cellpadding="2"> 
        <tr>
		  <td width="90" rowspan="6" align="left" valign="top" nowrap="nowrap" class="bodytext27"><img src="logofiles/<?php echo $companyanum; ?>.jpg" height="60" width="140" /></td>
          <td width="250" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo $employername; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>PAY SLIP : <?php echo $fullmonth; ?></strong></td>
        </tr>
		<?php
		$query2 = "select * from master_employee where employeecode = '$employeesplit[$i]'  ";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$employeename = $res2['employeename'];
		$res2employeecode = $res2['employeecode'];
		
		$query3 = "select * from master_employeeinfo where employeecode = '$employeesplit[$i]' ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$pinno = $res3['pinno'];
		$nssfno = $res3['nssf'];
		$nhifno = $res3['nhif'];
		$payrollno = $res3['payrollno'];
		$bankname = $res3['bankname'];
		$bankbranch = $res3['bankbranch'];
		$accountnumber = $res3['accountnumber'];
		$bankcode = $res3['bankcode'];
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Name : <?php echo $employeename; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Payroll No : <?php echo $payrollno.' ('.$res2employeecode.')'; ?></strong></td>
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
		<table width="360" border="0" cellspacing="0" cellpadding="2"> 
        <tr>
          <td width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EARNINGS</strong></td>
		  <td width="180" align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>AMOUNT</strong>&nbsp;&nbsp;</td>
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

		//$query3 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted'  order by auto_number";
		$query3 = "select auto_number, componentname from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted' and notional = 'No' order by order_no";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res3 = mysqli_fetch_array($exec3))
		{
			$res3componentanum = $res3['auto_number'];
			
			$query6 = "select `$res3componentanum` as componentamount from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6componentname = $res3['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res3['componentname'];
				$res3componentamount = $res6['componentamount'];
				
				$totalearnings = $totalearnings + $res3componentamount;		
				if($res3componentamount != '0')	{
					
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res3componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res3componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
			    }
		}
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<!--<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NOTIONAL BENEFITS'; ?></strong></td>
        </tr>-->
		
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
		//$query79 = "select * from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted'  order by auto_number";
		$query79 = "select auto_number, componentname from master_payrollcomponent where deductearning = 'Yes' and recordstatus <> 'deleted' order by order_no";
		$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die ("Error in Query79".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res79 = mysqli_fetch_array($exec79))
		{
			$res79componentanum = $res79['auto_number'];
		if($totalearnings == '0'){continue;}
	
		$query5 = "select `$res79componentanum` as componentamount from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
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
        </tr>
		<?php
		}
		}
		}
		$taxablepay = $totalearnings - $totaldeduct;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAXABLE PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxablepay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$taxcharged = 0;
		$query52 = "select `4` as componentamount from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted' 
					UNION ALL select `relief_bf` as componentamount from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted' ";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res52 = mysqli_fetch_array($exec52))
		{
			if($totalearnings == '0'){continue;}
			$res52componentname = 'PAYE';
			$res52componentamount = $res52['componentamount'];
			$taxcharged = $taxcharged + $res52componentamount;
		}
		if(true)
		{
			if($totalearnings == '0'){continue;}

			$res53amount = 0;
			$query52r = "select (`tax_relief`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' and tax_relief > '0' and employeecode = '$employeesplit[$i]'";
			$exec52r = mysqli_query($GLOBALS["___mysqli_ston"], $query52r) or die ("Error in Query52r".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow52r = mysqli_num_rows($exec52r);
			while($res52r = mysqli_fetch_array($exec52r))
			{
				$res52componentname = 'RELIEF';
				$res52componentamount = $res52r['componentamount'];
				$res53amount = $res53amount + $res52componentamount;
			}
			
			$query7 = "select * from insurance_relief where employeecode = '$employeesplit[$i]' and status <> 'deleted' ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7employeecode = $res7['employeecode'];
			$res7includepaye = $res7['includepaye'];
			$res7premium = $res7['premium'];
			$res7tax = $res7['taxpercent'];
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
        </tr>
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
        
		$query7 = "select auto_number, componentname from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted' and notional = 'Yes' order by order_no";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"],$query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res7 = mysqli_fetch_array($exec7))
		{
			if($totalearnings == '0'){continue;}
			$res7componentanum = $res7['auto_number'];
			
			$query8 = "select `$res7componentanum` as componentamount from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
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
        </tr>	
		<?php
				}
		}
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'DEDUCTIONS'; ?></strong></td>
        </tr>
		<?php
		$deductearningtot = 0;
		$query791 = "select auto_number, componentname, deductearning from master_payrollcomponent where typecode = '20'  and recordstatus <> 'deleted' order by order_no";
		$exec791 = mysqli_query($GLOBALS["___mysqli_ston"], $query791) or die ("Error in Query791".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res791 = mysqli_fetch_array($exec791))
		{
			$res791componentanum = $res791['auto_number'];
			$deductearning = $res791['deductearning'];
		if($totalearnings == '0'){continue;}
			
		$query51 = "select `$res791componentanum` as componentamount from details_employeepayroll where employeecode = '$employeesplit[$i]' and paymonth = '$assignmonth' and status <> 'deleted'";
		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res51 = mysqli_fetch_array($exec51);
		$res51componentname = $res51['componentname'];
		
			$res4componentname = $res791['componentname'];
			$res4componentamount = $res51['componentamount'];
			
			$totaldeductions = $totaldeductions + $res4componentamount;
				
			if($res4componentamount != '0')
			{
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res4componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res4componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
			}
		}
		
		$query80 = "select sum(installmentamount) as loanamount, loanname from loan_assign where status <> 'deleted' and paymonth = '$assignmonth' and employeecode = '$employeesplit[$i]'";
		$exec80 = mysqli_query($GLOBALS["___mysqli_ston"], $query80) or die ("Error in Query80".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res80 = mysqli_fetch_array($exec80);
		$loanamount = $res80['loanamount'];	
		$loanname = $res80['loanname'];
		if($loanamount != '0.00')
		{
			if($totalearnings == '0'){continue;}
			$totaldeductions = $totaldeductions + $loanamount;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $loanname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($loanamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		
		$grosspay = $totalearnings - $deductearningtot;
		$nettpay = $grosspay - $totaldeductions - $deductearningtot;
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
          <td align="left" valign="middle" colspan="2" nowrap="nowrap" class="bodytext27"><strong> BANK : <?php echo $bankname; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" colspan="2"nowrap="nowrap" class="bodytext27"><strong> BANK BRANCH : <?php echo $bankbranch; ?></strong></td>
        </tr>		
        <tr>
          <td align="left" valign="middle" colspan="2" nowrap="nowrap" class="bodytext27"><strong> ACCOUNT NUMBER : <?php echo $accountnumber; ?></strong></td>
        </tr>
        <tr>
          <td align="left" valign="middle" colspan="2" nowrap="nowrap" class="bodytext27"><strong> BANK CODE : <?php echo $bankcode; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>RECEIVED BY : </strong></td>
		  <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>____________________</strong></td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>DATE RECEIVED : </strong></td>
		  <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>____________________</strong></td>
        </tr>
        <tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		
     </table>
	</td>  
	</tr>
	</table>  
	<?php
	}
	?>
 </page>
	 
	 <?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
         $html2pdf = new HTML2PDF('P', array(250,110),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Payslip.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
