<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['pinnumber'];
$companyname = $_SESSION['employername'];
$currentdate = date("Y-m-d");
$colorloopcount = "";

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

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

	<page pagegroup="new" backtop="8mm" backbottom="16mm" backleft="2mm" backright="3mm">
<?php 
include("print_header.php");
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
					$searchmonthyear = $searchmonth.'-'.$searchyear; 
					$assignmonth = $searchmonth.'-'.$searchyear; 
					
					$fullmonth = date('F-Y', strtotime($assignmonth));
					$assignmonthsp = explode('-',$assignmonth);
					$tyear = $assignmonthsp[1];
					
					$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchdept=$searchdept";

				?>	
	<table width="600" border="0" align="center" cellpadding="0" cellspacing="2" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
		<thead>
			<tr >
				<td colspan="2" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td colspan="2" align="center" class="bodytext3" ><strong>Payroll Summary</strong></td>
			</tr>
			<tr >
				<td colspan="2" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td align="left" class="bodytext3" ><strong>ORAGANISATION : <?php echo $companyname; ?></strong></td>
				<td align="right" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td colspan="2" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
			<tr >
				<td align="left" class="bodytext3" ><strong>PER :  <?php echo $searchmonthyear; ?></strong></td>
				<td align="right" class="bodytext3" ><strong>REPORT DATE : <?php echo date('d/m/Y'); ?> </strong></td>
			</tr>
				
			<tr >
				<td colspan="2" align="center" class="bodytext3" ><strong>&nbsp;</strong></td>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td colspan="2" align="right" class="bodytext3" >
				
					<table width="360" border="0" cellspacing="0" cellpadding="2"> 
						<thead>
						<tr>
							<td width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>ED DESCRIPTION</strong></td>
							<td width="180" align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>MTH AMOUNT</strong> &nbsp;</td>
							<td width="100" align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EMPLOYEES</strong> &nbsp;</td>
						</tr>
						</thead>
						
						<tbody>
						<tr>
							<td colspan="3" width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EARNINGS</strong></td>
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
							
							$query6 = "select sum(`$res3componentanum`) as componentamount, count(`employeecode`) as numrows  from details_employeepayroll where paymonth = '$assignmonth'";
							$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$query116 = "select `$res3componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res3componentanum` <> '0.00' ";
							$exec116 = mysqli_query($GLOBALS["___mysqli_ston"], $query116) or die ("Error in query116".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numrow = mysqli_num_rows($exec116);
							$totalnumemp[] = $numrow;
							$res6 = mysqli_fetch_array($exec6);
							
							$res6componentname = $res3['componentname'];
							if($res6componentname != '')
							{
								$res3componentname = $res3['componentname'];
								$res3componentamount = $res6['componentamount'];
								//$numrow = $res6['numrows'];
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
						
					//$query5 = "select `$res79componentanum` as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
					
					$query117 = "select `$res79componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res79componentanum` <> '0.00' ";
					$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in query117".mysqli_error($GLOBALS["___mysqli_ston"]));
					$numrow1 = mysqli_num_rows($exec117);
					
					
					$query5 = "select sum(`$res79componentanum`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
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
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow1; ?>&nbsp;</td>
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
								<td align="center" valign="middle" nowrap="nowrap" class="bodytext27">&nbsp;&nbsp;</td>
							</tr>
						<?php
						$taxcharged = 0;
						
						$query52 = "select (`4`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
						$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numrow52 = mysqli_num_rows($exec52);
						
						while($res52 = mysqli_fetch_array($exec52))
						{
							$res52componentname = 'PAYE';
							$res52componentamount = $res52['componentamount'];
							$taxcharged = $taxcharged + $res52componentamount;
						}
						$query52t = "select (`relief_bf`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' ";
						$exec52t = mysqli_query($GLOBALS["___mysqli_ston"], $query52t) or die ("Error in Query52t".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numrow52t = mysqli_num_rows($exec52t);
						
						while($res52t = mysqli_fetch_array($exec52t))
						{
							$res52componentname = 'PAYE';
							$res52componentamount = $res52t['componentamount'];
							$taxcharged = $taxcharged + $res52componentamount;
						}
						$res53amount = 0;
						$query52r = "select (`tax_relief`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' and tax_relief > '0'";
						$exec52r = mysqli_query($GLOBALS["___mysqli_ston"], $query52r) or die ("Error in Query52r".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numrow52r = mysqli_num_rows($exec52r);
						
						while($res52r = mysqli_fetch_array($exec52r))
						{
							$res52componentname = 'RELIEF';
							$res52componentamount = $res52r['componentamount'];
							$res53amount = $res53amount + $res52componentamount;
						}
						$insurancerelief = 0;
						$query52i = "select (`insurancerelief`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' and insurancerelief > '0'";
						$exec52i = mysqli_query($GLOBALS["___mysqli_ston"], $query52i) or die ("Error in Query52i".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numrow52i = mysqli_num_rows($exec52i);
						
						while($res52i = mysqli_fetch_array($exec52i))
						{
							$res52componentname = 'insurancerelief';
							$res52componentamount = $res52i['componentamount'];
							$insurancerelief = $insurancerelief + $res52componentamount;
						}
						if($numrow52 > 0 && $taxcharged > 0){
						if(true)
						{							
							$taxcharged = $taxcharged + $res53amount + $insurancerelief;							
						}
						?>
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo 'GROSS PAYE'; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($taxcharged,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow52; ?>&nbsp;</td>
							</tr>
							
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo 'TAX RELIEF'; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($res53amount,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow52r; ?>&nbsp;</td>
							</tr>
							
							<?php
							if($insurancerelief != '0.00')
							{
							?>
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo 'INSURANCE RELIEF'; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($insurancerelief,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow52i; ?>&nbsp;</td>
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
							
							$query117 = "select `$res7componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res7componentanum` <> '0.00' ";
							$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in query117".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numrow3 = mysqli_num_rows($exec117);
							
							$query8 = "select sum(`$res7componentanum`) as componentamount from details_employeepayroll where paymonth = '$assignmonth'";
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
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $numrow3; ?>&nbsp;</td>
							</tr>
						<?php
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
							
							$query118 = "select `$res791componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res791componentanum` <> '0.00' and status <> 'deleted'";
							$exec118 = mysqli_query($GLOBALS["___mysqli_ston"], $query118) or die ("Error in query118".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numrow4 = mysqli_num_rows($exec118);
							
							$query51 = "select sum(`$res791componentanum`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
							$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
								
							$res51 = mysqli_fetch_array($exec51);
							
							$res4componentname = $res791['componentname'];
								$res4componentamount = $res51['componentamount'];
								//$numrow4 = $res51['numrows4'];
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
						
						$grosspay = $totalearnings - $deductearningtot;
						$nettpay = $grosspay - $totaldeductions - $deductearningtot;
						?>
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
							</tr>
								
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php print_r($totalnumemp[0]); ?>&nbsp;</td>
							</tr>
							
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NET PAY'; ?></strong></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($nettpay,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php print_r($totalnumemp[0]); ?></strong>&nbsp;</td>
							</tr>
								
						</tbody>
					</table>
					
				
				</td>
			</tr>
				
			
		</tbody>
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
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('payrollsummaryreport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

