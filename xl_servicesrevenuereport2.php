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
$total = '0.00';
$accountname = '';
$amount = 0;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="servicesrevenuereport2.xls"');

('Cache-Control: max-age=80');


if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }	
if (isset($_REQUEST["services"])) { $services = $_REQUEST["services"]; } else { $services = ""; }	
if (isset($_REQUEST["servicescode"])) { $servicescode = $_REQUEST["servicescode"]; } else { $servicescode = ""; }	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }		
			
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

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

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>

<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666" cellspacing="0" cellpadding="4" width="90%" 
            align="left" border="1">
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
			 <tr bgcolor="#FFF">
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
							$colorcode = 'bgcolor="#FFF"';
						}
						else
						{
							//echo "else";
							$colorcode = 'bgcolor="#FFF"';
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
					<tr bgcolor="#FFF">
					<td colspan="5" align="left" class="bodytext3"><strong>Total: </strong></td>
					<td align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2,'.',','); ?></strong></td>
					<?php  foreach($accarr as $accid) {?>
					<td align="right" class="bodytext3"><strong></strong></td>
					<?php }?>
					<td align="right" class="bodytext3"><strong><?php echo number_format($totalprofitloss,2,'.',','); ?></strong></td>
					</tr>
					<?php }?>
             
			  <?php
			  }
			  ?>
          </tbody>
</table>
</body>
</html>

