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
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
if (isset($_REQUEST["searchdept"])) { $searchdept = $_REQUEST["searchdept"]; } else { $searchdept = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "";
}
else if ($st == 'failed')
{
		$errmsg = "";
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<!--<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script> -->
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

function process1backkeypress1() 
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
}

</script>

<script language="javascript">

function captureEscapeKey1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		//alert ("Escape Key Press.");
		//event.keyCode=0; 
		//return event.keyCode 
		//return false;
	}
}

</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{

}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
	</tr>
	
	<tr>
		<td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
	</tr>
	
	<tr>
		<td colspan="10" bgcolor="#ecf0f5"> <?php include ("includes/menu1.php"); //include ("includes/menu2.php"); ?> </td>
	</tr>
	
	<tr>
		<td height="25" colspan="10">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="1%" align="left" valign="top">&nbsp;</td>
		<td  valign="top">
			<form name="form1" id="form1" method="post" action="payrollsummaryreport.php" onSubmit="return from1submit1()">
				<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
				<tbody>
					
					<tr bgcolor="#999999">
						<td colspan="30" align="left" class="bodytext3"><strong>Search Report</strong></td>
					</tr>
					
					<!--
					<tr>
						<td width="95" align="left" class="bodytext3">Search Employee</td>
						<td colspan="4" align="left" class="bodytext3">
						<input type="hidden" name="autobuildemployee" id="autobuildemployee">
						<input type="hidden" name="searchemployeecode" id="searchemployeecode">
						<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
					</tr>
					
					<tr>
						<td width="95" align="left" class="bodytext3">Select Department</td>
						<td colspan="4" align="left" class="bodytext3">
							<select name="searchdept" id="searchdept" style="border:solid 1px #001E6A;">
								<?php if($searchdept != '') { ?>
									<option value="<?php echo $searchdept; ?>"><?php echo $searchdept; ?></option>
								<?php } ?>
									<option value="">ALL</option>
								<?php
									$query5 = "select department from master_payrolldepartment where recordstatus <> 'deleted' group by department order by department";
									$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($res5 = mysqli_fetch_array($exec5))
									{
										$departmentname = $res5['department'];
								?>
									<option value="<?php echo $departmentname; ?>"><?php echo $departmentname; ?></option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>-->
					
					<tr>
						<td align="left" class="bodytext3">Search Month</td>
						<td width="63" align="left" class="bodytext3">
							<select name="searchmonth" id="searchmonth">
								<?php if($searchmonth != '') { ?>
									<option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>
								<?php } ?>
								<?php
								$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
								$monthcount = count($arraymonth);
								for($i=0;$i<$monthcount;$i++)
								{
								?>
									<option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
								<?php
								}
								?>
							</select>
						</td>
						<td width="74" align="left" class="bodytext3">Search Year</td>
						<td width="56" align="left" class="bodytext3">
							<select name="searchyear" id="searchyear">
								<?php if($searchyear != '') { ?>
									<option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
								<?php } ?>
								<?php
								for($j=2010;$j<=date('Y');$j++)
								{
								?>
									<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
								<?php
								}
								?>
							</select>
						</td>
						<td width="560" align="left" class="bodytext3">
							<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
							<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;">
						</td>
						
					</tr>
					
					<tr>
						<td align="left" colspan="5">&nbsp;</td>
					</tr>
				</tbody>
				</table>
			</form>
		</td>
	</tr>
	
	<tr>
		<td width="1%" align="left" valign="top">&nbsp;</td>
		<td  valign="top">
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
					$searchmonthyear = $searchmonth.'-'.$searchyear; 
					$assignmonth = $searchmonth.'-'.$searchyear; 
					
					$fullmonth = date('F-Y', strtotime($assignmonth));
					$assignmonthsp = explode('-',$assignmonth);
					$tyear = $assignmonthsp[1];
					
					$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchdept=$searchdept";

				?>	
	<table width="600" border="0" align="left" cellpadding="0" cellspacing="2" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
		<tbody>
			<tr bgcolor="#ecf0f5">
				<td colspan="4" align="left" class="bodytext3"><strong>Payroll Summary</strong></td>
			</tr>
			
			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
				<td align="left" class="bodytext3"><strong>EMPLOYER'S PIN : <?php echo $companycode; ?></strong></td>
				<td align="right" rowspan="3" class="bodytext3">
					<a target="_blank" href="print_payrollsummaryreportpdf.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" width="40" height="40"></a>&nbsp;
					<a target="_blank" href="print_payrollsummaryreportexl.php?<?php echo $url; ?>" ><img src="images/excel-xls-icon.png" height="40" width="40"></a>&nbsp;
				</td>
			</tr>
				
			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
				<td align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
			</tr>
					
			<tr bgcolor="#FFFFFF">
				<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
				<td align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
			</tr>
				
			<tr bgcolor="#ecf0f5">
				<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
				<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			</tr>
			
			<tr>
				<td colspan="2" align = "left" class="bodytext3" bgcolor="#FFFFFF"> </td>
				<td colspan="2" align = "left" class="bodytext3" bgcolor="#FFFFFF">
				
					<table width="360" border="0" cellspacing="0" cellpadding="2" align="center" > 
						<tr>
							<td width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong>ED DESCRIPTION</strong></td>
							<td width="180" align="right" valign="middle" nowrap="nowrap" class="bodytext3"><strong>MTH AMOUNT</strong> &nbsp;</td>
							<td width="120" align="right" valign="middle" nowrap="nowrap" class="bodytext3"><strong>EMPLOYEES</strong> &nbsp;</td>
						</tr>
						
						<tr>
							<td colspan="3" width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong>EARNINGS</strong></td>
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
							
							$query116 = "select `$res3componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res3componentanum` <> '0.00' and status <> 'deleted'";
							$exec116 = mysqli_query($GLOBALS["___mysqli_ston"], $query116) or die ("Error in query116".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numrow = mysqli_num_rows($exec116);
							$totalnumemp[] = $numrow;
							
							$query6 = "select sum(`$res3componentanum`) as componentamount, count(`employeecode`) as numrows  from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
							$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
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
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $res3componentname; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($res3componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow; ?>&nbsp;</td>
							</tr>
						<?php
								}
							}
						}
						?>
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong>&nbsp;</strong></td>
							</tr>
							
							<!--<tr>
								<td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo 'NOTIONAL BENEFITS'; ?></strong></td>
							</tr>-->

							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo 'TOTAL EARNINGS'; ?></strong></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo number_format($totalearnings,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php rsort($totalnumemp); print_r($totalnumemp[0]);?>&nbsp;</td>
							</tr>
							
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong>&nbsp;</strong></td>
							</tr>
							
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo 'TAX CALCULATION'; ?></strong></td>
							</tr>
							
					<?php
					$query79 = "select auto_number, componentname from master_payrollcomponent where deductearning = 'Yes' and recordstatus <> 'deleted' order by order_no";
					$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die ("Error in Query79".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res79 = mysqli_fetch_array($exec79))
					{
						$res79componentanum = $res79['auto_number'];
						
					//$query5 = "select `$res79componentanum` as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
					
					$query117 = "select `$res79componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res79componentanum` <> '0.00' and status <> 'deleted'";
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
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $res5componentname; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo '- '.number_format($res79componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow1; ?>&nbsp;</td>
							</tr>
					<?php
							}
						}
					
					}
							$taxablepay = $totalearnings - $totaldeduct;
					?>
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo 'TAXABLE PAY'; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($taxablepay,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="center" valign="middle" nowrap="nowrap" class="bodytext3">&nbsp;&nbsp;</td>
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
							
							$query117 = "select `$res7componentanum` as componentamount, `employeecode` from details_employeepayroll where paymonth = '$assignmonth' AND `$res7componentanum` <> '0.00' and status <> 'deleted'";
							$exec117 = mysqli_query($GLOBALS["___mysqli_ston"], $query117) or die ("Error in query117".mysqli_error($GLOBALS["___mysqli_ston"]));
							$numrow3 = mysqli_num_rows($exec117);
							
							$query8 = "select sum(`$res7componentanum`) as componentamount from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'";
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
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $res7componentname; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($res7componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow3; ?>&nbsp;</td>
							</tr>
						<?php
								}
							}
						
						}
						?>
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong>&nbsp;</strong></td>
							</tr>
							
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo 'DEDUCTIONS'; ?></strong></td>
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
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $res4componentname; ?></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($res4componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $numrow4; ?>&nbsp;</td>
							</tr>
						<?php
								}
							
						}
						
						$grosspay = $totalearnings - $deductearningtot;
						$nettpay = $grosspay - $totaldeductions - $deductearningtot;
						?>
							<tr>
								<td colspan="3" align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong>&nbsp;</strong></td>
							</tr>
								
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo '- '.number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php print_r($totalnumemp[0]); ?>&nbsp;</td>
							</tr>
							
							<tr>
								<td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo 'NET PAY'; ?></strong></td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php echo number_format($nettpay,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
								<td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><strong><?php print_r($totalnumemp[0]); ?></strong>&nbsp;</td>
							</tr>
								
								
					</table>
					
				</td>
			</tr>
				
			
		</tbody>
	</table>
				<?php
				}
				?>
		</td>
	</tr>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

