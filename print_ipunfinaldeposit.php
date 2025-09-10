<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ipunfinaldeposit.xls"');
header('Cache-Control: max-age=80');

//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
	
$locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
       
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>



<body>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="7" bgcolor="#ecf0f5" class="bodytext31">
             
				  </td>  
            </tr>
           <tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				
				
                <td width="153" align="right" class="bodytext3"><strong><?php echo 'Amount'; ?></strong></td>
				</tr>
				<?php
					$totalamount=0;
					$openingbalance1=0;
					$group='21';
	$ledgerid='08-9301-NHL';
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					
					$id = $res267['id'];
				
						if($id != '')
					{		
						/* */			 
						$depositref = 0;
						
						$querydr1dp = "SELECT sum(amount) as depositref FROM `deposit_refund` WHERE `recorddate` < '$ADate1' 
									   UNION ALL SELECT sum(deposit) as depositref FROM `billing_ip` WHERE `billdate` < '$ADate1' 
									   UNION ALL SELECT sum(debitamount) as depositref FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1dp) or die ("Error in querydr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						
						 $depositref += $resdr1['depositref'];
						// $ledgertotal = $ledgertotal - $depositref;
						}		
					
						$deposit = 0;
						
						$querycr1dp = "SELECT sum(transactionamount) as deposit FROM `master_transactionadvancedeposit` WHERE `transactiondate` < '$ADate1' 
									   UNION ALL SELECT sum(transactionamount) as deposit FROM `master_transactionipdeposit` WHERE `transactiondate` < '$ADate1'  AND `transactionmodule` = 'PAYMENT'
									   UNION ALL SELECT sum(creditamount) as deposit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";
						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1dp) or die ("Error in querycr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescr1 = mysqli_fetch_array($execcr1))
						{
						 $deposit += $rescr1['deposit'];
						// $ledgertotal = $ledgertotal + $deposit;
						}
						
					$totalamount +=$deposit-$depositref;	
					}
						
					}
					
				$openingbalance1 =$totalamount;
				$deposit=0;
				$depositref=0;
				$openingbalance1=0;
				?>
					  <!--<tr>
                    <td colspan="3" align="left" class="bodytext3">Opening Balance</td>
                    <td colspan="6" align="right" class="bodytext3"><?php echo number_format($openingbalance1,2);?></td>
                    </tr>-->
					<?php
						
					$scount=0;
				$ledgertotal = 0;
					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					
						if($id != '')
					{		
						/* */			 
						$i = 0;
						$drresult = array();
						$querydr1dp = "SELECT deposit, code, name, docno, date FROM (SELECT (-1*`amount`) as deposit, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `deposit_refund` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*ABS(`deposit`)) as deposit, patientcode as code, patientname as name, billno as docno, billdate as date FROM `billing_ip` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT (-1*`debitamount`) as deposit, ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									   
									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									   UNION ALL SELECT `creditamount` as deposit,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as de order by de.date";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1dp) or die ("Error in querydr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						 $depositref = $resdr1['deposit'];
						 $code = $resdr1['code'];
						 $name = $resdr1['name'];
						 $docno = $resdr1['docno'];
						 $date = $resdr1['date'];
						 $scount=$scount+1;
						 if($scount==1)
						 {
						 $ledgertotal = $ledgertotal + $depositref+$openingbalance1;
						 }
						 else
						 {
							 $ledgertotal = $ledgertotal + $depositref;
						 }
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
						?>
						<tr <?php echo $colorcode; ?>>
                        <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td align="left" class="bodytext3"><?php echo $date; ?></td>
                        <td align="left" class="bodytext3"><?php echo $docno; ?></td>
                        <td align="left" class="bodytext3"><?php echo $code; ?></td>
                       
						<?php if($depositref < 0) { ?>
                        <td align="right" class="bodytext3"><?php echo '-'.number_format(abs($depositref),2); ?></td>
                        
						<?php } else { ?>
					
						<td align="right" class="bodytext3"><?php echo number_format($depositref,2); ?></td>
						<?php } ?>
                       
                        </tr>
                        <?php
						}		
										
					}
					else
					{
						$balance = 0;
					}	
					}
					?>
				<tr bgcolor="#ecf0f5">
				    <td colspan="5" align="right" class="bodytext3"><strong><?php echo number_format($ledgertotal,2); ?></strong></td>
				</tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>