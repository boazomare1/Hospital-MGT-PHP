<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0';
$pendingamount = '0.00';
$accountname = '';
$amount=0;

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
if (isset($_REQUEST["services"])) { $services = $_REQUEST["services"]; } else { $services = ""; }
if (isset($_REQUEST["servicescode"])) { $servicescode = $_REQUEST["servicescode"]; } else { $servicescode = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
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

<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>
$(document).ready(function(e) {
   
		$('#services').autocomplete({
	
	source:"ajaxwelness_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#servicescode").val(accountid);
			$("#services").val(accountname);
			
			},
    
	}).keyup(function (){
			$("#servicescode").val('');
	});
		
});
</script>
<script language="javascript">

function process()
{
	if($('#servicescode').val() == '')
	{
		alert("Please Select A Package.");
		return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}
</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1800" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top">
	</tr>
	<table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="servicerevenuereport2.php" onSubmit = "return process();">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Service Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Search Service </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <input type="text" name="services" id="services" size="60" value="<?php echo $services; ?>">
					  <input type="hidden" name="servicescode" id="servicescode" value="<?php echo $servicescode; ?>">
					  </td>
                       </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Patientcode </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <input type="text" name="patientcode" id="patientcode" size="60" value="<?php echo $patientcode; ?>">
					  </td>
                       </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Visitcode </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <input type="text" name="visitcode" id="visitcode" size="60" value="<?php echo $visitcode; ?>">
					  </td>
                       </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="slocation" id="slocation">
                      	<?php
						$query01="select locationcode,locationname from master_location where status ='' order by locationname";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select>
                      </td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="type" id="type">
                      	<option value="" selected>ALL</option>
                      	<option value="OP" <?php if($type=='OP'){ echo "selected";} ?>> OP + EXTERNAL </option>
                      	<option value="IP" <?php if($type=='IP'){ echo "selected";} ?>> IP </option>
                      
                      </select>
                      </td>
                      
                    </tr>
                    
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1194" 
            align="left" border="0">
          <tbody>
            
          	
            
			<?php
			$snovisit=0;
			$num1=0;
			$num2=0;
			$num3=0;
			$num6=0;
			$grandtotal = 0;
			$res2itemname = '';
			$proflostot=0;
			$ADate1 = $transactiondatefrom;
			$ADate2 = $transactiondateto;
			
			
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
				$servicescode = $_REQUEST['servicescode'];
				$accarr = array();
				$selsub = "select b.auto_number,a.itemname from master_services as a join master_accountssub as b on (a.ledgerid = b.id) where a.itemcode = '$servicescode'";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $selsub) or die ("Error in selsub".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res21 = mysqli_fetch_array($exec21);
				$ledgeranum = $res21['auto_number'];
				$itemname = $res21['itemname'];
				$query21 = "select id,accountname from master_accountname where accountssub = '$ledgeranum'";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num1 = mysqli_num_rows($exec21);
				$num1 = $num1 + 7;
				?>
				<tr>
				<td colspan="<?= $num1; ?>" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $itemname.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
			 <tr bgcolor="#CCC">
				<td width="50" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Patient Code'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Visit Code'; ?></strong></td>
				<td width="250" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="160" align="right" class="bodytext3"><strong><?php echo 'Service Amount'; ?></strong></td>
				<?php
				
				while($res21 = mysqli_fetch_array($exec21))
				{
					array_push($accarr,$res21['id']);
				?>
				<td width="160" align="right" class="bodytext3"><strong><?php echo $res21['accountname']; ?></strong></td>
				<?php
				}
				?>
                <td width="140" align="right" class="bodytext3"><strong><?php echo 'Profi/Loss'; ?></strong></td>
				</tr>
				<?php
				$colorloopcount = '';
				$orderid1 = '';
				$lid = '';
				$openingbalance = "0.00";
				$sumopeningbalance = "0.00";
				$totalamount2 = '0.00';
				$totalamount12 = '0.00';
				$balance = '0.00';
				$sumbalance = '0.00';
				$openingbalance1=0;
				$ledgertotal=0;
				$totalprofitloss =0;
				$scount=0;
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				$query267 = "select id,accountssub,auto_number from master_accountssub where auto_number = '$ledgeranum'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{
				$id = $res267['id'];
				$ledgeranum = $res267['auto_number'];
				$accountsmain2 = $res267['accountssub'];
				
				$i = 0;
	$querycr1in ='';
		$crresult1 = array();
		if($type =='OP' || $type =='')
		{
		$querycr1in = $querycr1in."SELECT sum(a.`fxamount`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1' and a.servicesitemcode = '$servicescode' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$visitcode%' group by a.patientvisitcode,a.servicesitemcode,a.billnumber
						UNION ALL SELECT sum(a.`servicesitemrate`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.servicesitemcode = '$servicescode' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$visitcode%' group by a.patientvisitcode,a.servicesitemcode,a.billnumber
						UNION ALL SELECT sum(a.`fxamount`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1' and a.servicesitemcode = '$servicescode' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$visitcode%' group by a.patientvisitcode,a.servicesitemcode,a.billnumber";
		}
		if($type =='IP' || $type =='')
		{		
				if($querycr1in != '')
				{
							$querycr1in = $querycr1in ." UNION ALL  ";
				}
						$querycr1in = $querycr1in."SELECT sum(a.`servicesitemrateuhx`) as income,billdate as td2,patientcode as td3,patientvisitcode as td4,servicesitemname as td5,billnumber as td6 FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1' and a.servicesitemcode = '$servicescode' and a.patientcode like '%$patientcode%' and a.patientvisitcode like '%$visitcode%' group by a.patientvisitcode,a.servicesitemcode,a.billnumber"; 
		}				
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
			$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							//echo "if";
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							//echo "else";
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						$scount=$scount+1;
						if($scount==1)
						{
						$ledgertotal = $ledgertotal + $rescr1['income']+$openingbalance1;
						}
						else
						{
							$ledgertotal = $ledgertotal + $rescr1['income'];
						}
						$serviceitemamount = 0;
						$profitloss=0;
		?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td2']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td3']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td4']; ?></td>
                        <td align="left" class="bodytext3"><?php echo $rescr1['td5']; ?></td>
                        <td align="right" class="bodytext3"><?php echo number_format($rescr1['income'],2); ?></td>
						<?php  foreach($accarr as $accid) {
							
							$i = 0;
							$crresult1 = array();
							$querycr11in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and a.wellnessitem = '1' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and a.wellnessitem = '1' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'
						UNION ALL SELECT SUM(a.`servicesitemrateuhx`) as income FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$accid' and a.wellnessitem = '1' and patientcode like '".$rescr1['td3']."' and patientvisitcode like '".$rescr1['td4']."' and billnumber like '".$rescr1['td6']."'"; 
						$execcr11 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr11in) or die ("Error in querycr11in".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr11 = mysqli_fetch_array($execcr11))
						{
							$i = $i+1;
							$crresult1[$i] = $rescr11['income'];
						}
							$rescr11income=array_sum($crresult1);
						$serviceitemamount = $serviceitemamount + $rescr11income;
						?>
						<td align="right" class="bodytext3"><?php echo number_format(abs($rescr11income),2); ?></td>
						<?php } 
						$profitloss = $rescr1['income']-$serviceitemamount;
						
		$totalprofitloss = $totalprofitloss+$profitloss;
						?>
                        <td align="right" class="bodytext3"><?= number_format($profitloss,2);?></td>
                        </tr>
						<?php
		}
				
				$balance = array_sum($crresult1); 
				$journal=0;
			
				//$balance=$balance+$totalamount3;
									
					$sumbalance = $sumbalance + $balance + $journal;
					
					?>
					<tr bgcolor="#CCC">
					<td colspan="5" align="left" class="bodytext3"><strong>Total: </strong></td>
					<td align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2,'.',','); ?></strong></td>
					<?php  foreach($accarr as $accid) {?>
					<td align="right" class="bodytext3"><strong></strong></td>
					<?php }?>
					<td align="right" class="bodytext3"><strong><?php echo number_format($totalprofitloss,2,'.',','); ?></strong></td>
					</tr>
					<?php }?>
              <td width="75"  align="left" valign="center" bgcolor="" class="bodytext31">
              <a href="xl_servicesrevenuereport2.php?type=<?php echo $type; ?>&&slocation=<?= $slocation; ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?= $transactiondatefrom ?>&&ADate2=<?= $transactiondateto ?>&&services=<?php echo $services; ?>&&servicescode=<?php echo $servicescode; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" target="_blank"> <img src="images/excel-xls-icon.png" width="30" height="30" /> </a>
              </td> 
			  <?php
			  }
			  ?>
	
          </tbody>
        </table></td>
		
      </tr>
    </table>
</table>
 
<?php include ("includes/footer1.php"); ?>
</body>
</html>

