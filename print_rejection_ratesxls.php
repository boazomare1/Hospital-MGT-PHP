<?php



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["locationcode1"])) { $locationcode1 = $_REQUEST["locationcode1"]; } else { $locationcode1 = ""; }

if (isset($_REQUEST["source"])) { $source = $_REQUEST["source"]; } else { $source = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="RejectionRates['.$ADate1.' - '.$ADate2.'].xls"');

header('Cache-Control: max-age=80');



session_start();

include ("db/db_connect.php");

error_reporting(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$total_inv = 0;
$total_rej_amt = 0;
$total_rej_rate = 0;
$total_disc_amt = 0;
$total_disc_rate = 0;


if($source=='Summary') { ?>


<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" align="left" border="1">

<tbody>
<tr>
<td colspan="6" align="center" valign="center" class="bodytext31"><div align="center"><strong>Rejection Rates Report (<?=$ADate1;?> To <?=$ADate2;?>)</strong></div></td>
</tr>

<tr>

<td width="5%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>SNO.</strong></div></td>
<td width="25%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>ACCOUNTNAME</strong></div></td>
<td width="20%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Invoice Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Rate</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc. Rate</strong></div></td>
</tr>





<?php

$revenue = $totalrevenue = 0.00;
$oprevenue = $optotalrevenue = 0.00;
$doc_share_amount = $total_doc_share_amount = 0.00;

$acountname = '';

if($locationcode1=='All')
	{
	$pass_location = "locationcode !=''";
	}
	else
	{
	$pass_location = "locationcode ='$locationcode1'";
	}

  if($searchsuppliercode!='')
				{
				$query1 = "SELECT id,accountname  from master_accountname where id='$searchsuppliercode'";
				}
				else
				{
				
				$query1 = "SELECT id,accountname  from master_accountname where id!='02-4500-1'";
				}

   $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

   while($res1 = mysqli_fetch_array($exec1)){

	  $id = $res1['id'];
	  $accountname = $res1['accountname'];
	  $rejection_amount=0;
	  $discount_amount=0;
	  $initial_amount=0;
	  $rej_rate=0;
	  $disc_rate=0;
	  
	  $query3 = "select sum(a.decline) as rejection_amount,sum(a.discount) as discount_amount,sum(b.transactionamount) as initial_amount from master_transactionpaylater as a JOIN master_transactionpaylater as b on (a.billnumber=b.billnumber)  where  a.bill_date between '$ADate1' and '$ADate2' and a.transactiontype = 'PAYMENT' and a.paylaterdocno='' and a.docno!='' and a.recordstatus='allocated' and a.accountcode='$id' and a.$pass_location and b.docno='' and b.accountcode='$id' group by a.accountcode ";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$rejection_amount = $res3['rejection_amount'];
	$discount_amount = $res3['discount_amount'];
	$initial_amount = $res3['initial_amount'];
	if($rejection_amount>0)
	{
		$rej_rate = ($rejection_amount / $initial_amount) * 100;
	}
	if($discount_amount>0)
	{
		$disc_rate = ($discount_amount / $initial_amount) * 100;
	}

if($initial_amount>0)
	{
		$total_inv += $initial_amount;
		$total_rej_amt += $rejection_amount;
		$total_rej_rate += $rej_rate;
		$total_disc_amt += $discount_amount;
		$total_disc_rate += $disc_rate;

	  $snocount = $snocount + 1;


  ?>

	<tr>
	  <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
	  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
	  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($initial_amount,2); ?></td>
	  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rejection_amount,2); ?></td>
	  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rej_rate,2).'%'; ?></td>
	  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discount_amount,2); ?></td>
	  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($disc_rate,2).'%'; ?></td>
  </tr>
<?php } }?>
<tr>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="2"><strong>TOTAL REVENUE</strong></td>
 <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_inv,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_amt,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_rate,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_amt,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_rate,2); ?></strong></td>
</tr>

</tbody>

</table>

<?php }  else { ?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" align="left" border="1">

<tbody>
<tr>
<td colspan="6" align="center" valign="center" class="bodytext31"><div align="center"><strong>Rejection Rates Report (<?=$ADate1;?> To <?=$ADate2;?>)</strong></div></td>
</tr>

<tr>

<td width="5%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>SNO.</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>ACCOUNTNAME</strong></div></td>
<td width="25%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Invoice Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Rate</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc. Rate</strong></div></td>
</tr>





<?php

$revenue = $totalrevenue = 0.00;
$oprevenue = $optotalrevenue = 0.00;
$doc_share_amount = $total_doc_share_amount = 0.00;

$acountname = '';

if($locationcode1=='All')
	{
	$pass_location = "locationcode !=''";
	}
	else
	{
	$pass_location = "locationcode ='$locationcode1'";
	}

if($searchsuppliercode!='')
				{
				$query1 = "SELECT id,accountname  from master_accountname where id='$searchsuppliercode'";
				}
				else
				{
				
				$query1 = "SELECT id,accountname  from master_accountname where id!='02-4500-1'";
				}

   $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

   while($res1 = mysqli_fetch_array($exec1)){

	  $id = $res1['id'];
	  $accountname = $res1['accountname'];
	  $rejection_amount=0;
	  $discount_amount=0;
	  $initial_amount=0;
	  $rej_rate=0;
	  $disc_rate=0;
	  
	   $rejection_amount=0.00;
				  $discount_amount=0.00;
				  $initial_amount=0.00;
				  $rej_rate=0.00;
				  $disc_rate=0.00;
				
			   $query3 = "select (a.decline) as rejection_amount,(a.discount) as discount_amount,(b.transactionamount) as initial_amount,a.patientname,a.billnumber from master_transactionpaylater as a JOIN master_transactionpaylater as b on (a.billnumber=b.billnumber)  where  a.bill_date between '$ADate1' and '$ADate2' and a.transactiontype = 'PAYMENT' and a.paylaterdocno='' and a.docno!='' and a.recordstatus='allocated' and a.accountcode='$id' and a.$pass_location and b.docno='' and b.accountcode='$id'  ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res3 = mysqli_fetch_array($exec3)){
				$rejection_amount=0.00;
				$discount_amount=0.00;
				$initial_amount=0.00;
				$rej_rate=0.00;
				$disc_rate=0.00;
				$rejection_amount = $res3['rejection_amount'];
				$discount_amount = $res3['discount_amount'];
				$patientname = $res3['patientname'];
				$billnumber = $res3['billnumber'];
				if($rejection_amount=='')
				{
					$rejection_amount=0.00;
				}
				if($discount_amount=='')
				{
					$discount_amount=0.00;
				}
				$initial_amount = $res3['initial_amount'];
				if($rejection_amount>0)
				{
					$rej_rate = ($rejection_amount / $initial_amount) * 100;
				}
				if($discount_amount>0)
				{
				$disc_rate = ($discount_amount / $initial_amount) * 100;
				}

if($initial_amount>0)
	{
		$total_inv += $initial_amount;
		$total_rej_amt += $rejection_amount;
		$total_rej_rate += $rej_rate;
		$total_disc_amt += $discount_amount;
		$total_disc_rate += $disc_rate;

	  $snocount = $snocount + 1;


  ?>

	<tr>
	  <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
                  
                  <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($initial_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rejection_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rej_rate,2).'%'; ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discount_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($disc_rate,2).'%'; ?></td>

              </tr>
<?php } } }?>
<tr>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="4"><strong>TOTAL REVENUE</strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_inv,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_amt,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_rate,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_amt,2); ?></strong></td>
<td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_rate,2); ?></strong></td>
</tr>

</tbody>

</table>

<?php } ?>