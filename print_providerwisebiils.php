<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Provider Wise Bills.xls"');
header('Cache-Control: max-age=80');
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$exchange_rate=1;
if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"];}else{$cbfrmflag1 = "";}
if(isset($_REQUEST["suppliername"])){ $searchsuppliername = $_REQUEST["suppliername"];}else{$searchsuppliername = "";}
if(isset($_REQUEST["searchsuppliercode"])){ $searchsuppliercode = $_REQUEST["searchsuppliercode"];}else{$searchsuppliercode = "";}
if(isset($_REQUEST["searchsupplieranum"])){ $searchsupplieranum = $_REQUEST["searchsupplieranum"];}else{$searchsupplieranum = "";}
if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}
if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}
?>
<style type="text/css">
<!--
.bodytext3 {
}
.bodytext31 {
}
.bodytext311 {
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
<table cellspacing="3" cellpadding="0" align="left" border="0" style="border-collapse:collapse;" width="100%">
	<tbody>
		<tr>
			<td colspan="10"><br></td>
		</tr>
		<tr>
			<td class="bodytext31" valign="middle" align="left" colspan="10"><strong><?php echo strtoupper($res1locationname); ?></strong></td>
		</tr>
		<tr>
			<td class="bodytext31" colspan="10" valign="middle"  align="left" ><strong>Provider Wise Report<?php echo date("d/m/Y", strtotime($ADate1)); ?> TO <?php echo date("d/m/Y", strtotime($ADate2)); ?> </strong></td>  
		</tr>
		<tr>
			<td colspan="10"><br></td>
		</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="0" cellpadding="0" align="left" border="1">
		<tr>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>No</strong></td>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Date</strong></td>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Patient Name </strong></td>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Reg.No</strong></td>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Visit No</strong></td>
		  <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Provider</strong></td>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Scheme</strong></td>
		  <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Member No</strong></td>
		  <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Claim No.</strong></td>
		  <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Bill numbe</strong></td>
          <td align="center" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>Amount</strong></td>
        </tr>

	<?php
		$queryunion="SELECT groupdate,patientcode,patientname,visitcode,billnumber,particulars,subtype,subtypeano,accountname,fxamount,auto_number,transactiontype from(select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum' and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <>'0' and billnumber not like 'AOP%'
		
		union all select transactiondate as groupdate, patientcode,'opening balance' as patientname, visitcode, billnumber, particulars, subtype, subtypeano, accountname, transactionamount as fxamount, auto_number, transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'  and accountnameid='$searchsuppliercode' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%'
		
		union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

		union all select transactiondate as groupdate,patientcode,patientname,visitcode,billnumber,particulars,transactionmode,subtypeano,accountname,fxamount, docno as auto_number,transactiontype from master_transactionpaylater where accountnameano='$searchsupplieranum'   and accountnameid='$searchsuppliercode'  and transactiontype = 'paylaterdebit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'

		union all select b.transactiondate as groupdate,b.patientcode as patientcode,b.patientname as patientname,b.visitcode as visitcode,b.billnumber as billnumber,b.particulars as particulars,b.transactionmode as transactionmode,b.subtypeano as subtypeano,b.accountname as accountname,b.fxamount as fxamount,b.docno as docno,b.transactiontype as transactiontype FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$searchsuppliercode' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'

		union all select transactiondate as groupdate, patientcode, patientname, visitcode, billnumber, particulars, transactionmode, subtypeano, chequenumber, fxamount, docno, transactiontype from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')


		union all select entrydate as groupdate,'' as patientcode,'' as patientname,'' as visitcode,docno as billnumber,narration as particulars, selecttype as transactionmode, selecttype as subtypeano, '' as chequenumber, transactionamount as fxamount, auto_number, vouchertype as transactiontype FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as t order by groupdate asc";
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryunion) or die ("Error in queryunion".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 	$resamount=0;
			$res2transactionamount=0;
			$transactiontype = $res2['transactiontype'];
			$vit_code = $res2['visitcode'];
	
			
			$query3 = "select memberno,accountfullname from master_visitentry where visitcode = '$vit_code'
			UNION ALL select memberno,accountfullname from master_ipvisitentry where visitcode = '$vit_code'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$memberno = $res3['memberno'];
			$schemefromvisit=$res3['accountfullname'];
			
			$query31 = "select preauthcode from billing_ip where visitcode = '$vit_code'
			UNION ALL select preauthcode from billing_paylater where visitcode = '$vit_code'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$preauthcode = $res31['preauthcode'];
			
			
			
			if($transactiontype=='finalize')
			{
			$res2transactiondate = $res2['groupdate'];
			$res2patientname = $res2['patientname'];
			$res2visitcode = $res2['visitcode'];
			$res2billnumber = $res2['billnumber'];
			$res2patientcode = $res2['patientcode'];
			$particulars = $res2['particulars'];
			if($res2patientname==''){
			$res2patientname = $particulars;
			}
			$anum = $res2['auto_number'];

			
			$res2transactionamount = $res2['fxamount']/$exchange_rate;
			$snocount = $snocount + 1;
			$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
			$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmrdno1 = mysqli_fetch_array($execmrdno1);
			$res1mrdno = $resmrdno1['mrdno'];
			$res2mrdno='';
			
			$totalpayment = 0;
				
			$res2transactionamount = $res2transactionamount - $totalpayment;
			
			if($res2transactionamount != '0')
			{
			$t1 = strtotime($ADate2);
			$t2 = strtotime($res2transactiondate);
			$days_between = ceil(abs($t1 - $t2) / 86400);
			$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
			$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmrdno1 = mysqli_fetch_array($execmrdno1);
			$res1mrdno = $resmrdno1['mrdno'];
			$total = $total + $res2transactionamount;
					
						
		 			
			//echo $cashamount;
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
           <tr >
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>   
           </tr>
		   
			<?php 
			$res2transactionamount=0;
			$resamount=0;
			} 
			$res2transactionamount=0;
			$resamount=0;
			} 
			if($transactiontype=='JOURNAL')
			{
				$totalpayment = 0;
				$res2transactiondate = $res2['groupdate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				if($res2patientname==''){
				$res2patientname = $particulars;
				}
				$anum = $res2['auto_number'];

				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				if($res2['subtypeano'] == 'Cr')
				{
				$query7="SELECT  -1*`creditamount` as fxamount FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Cr' and auto_number  = '".$res2['auto_number']."'";
				}
				else
				{
				$query7="SELECT  `debitamount` as fxamount  FROM `master_journalentries` WHERE `ledgerid` = '$searchsuppliercode' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and docno = '$res2billnumber' and selecttype = 'Dr' and auto_number  = '".$res2['auto_number']."'";
				}
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res7 = mysqli_fetch_array($exec7);
				$res2transactionamount = $res7['fxamount']/$exchange_rate;				
				$res2transactionamount = $res2transactionamount - $totalpayment;
				
				if($res2transactionamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					$total = $total + $res2transactionamount;
					
						
			//echo $cashamount;
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
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2transactiondate; ?></div></td> 
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2billnumber; ?></div></td>   
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
			</tr>
			<?php
						
			$res2transactionamount=0;
			$resamount=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			}
			
			if($transactiontype=='paylaterdebit')
			{
    
        $respaylatercreditpayment=0;
        $res6transactiondate = $res2['groupdate'];
        $res6patientname = $res2['patientname'];
        $res6patientcode = $res2['patientcode'];
        $res6visitcode = $res2['visitcode'];
        $res6billnumber = $res2['billnumber'];
        $res6transactionmode = $res2['subtype'];
        $res6docno = $res2['auto_number'];
        $particulars = $res2['particulars'];
        $ref_no = $res2['accountname'];


        $querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
        $execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resmrdno1 = mysqli_fetch_array($execmrdno1);
        $res1mrdno = $resmrdno1['mrdno'];
        $res2mrdno='';
        
        $res6transactionamount = $res2['fxamount']/$exchange_rate;
            
        $t1 = strtotime($ADate2);
        $t2 = strtotime($res6transactiondate);
        $days_between = ceil(abs($t1 - $t2) / 86400);
        
			  $totalpaylatercreditpayment = 0;
			  $query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
              $exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $num57 = mysqli_num_rows($exec57);             
              if($num57 != 0)
              {
                $lab = "Lab";
              }
              else
              {
                $lab = "";
              }
              
			  $query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
              $exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $num58 = mysqli_num_rows($exec58);             
              if($num58 != 0)
              {
                $rad = "Rad";
              }
              else
              {
                $rad = "";
              }
              
			  $query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
              $exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $num59 = mysqli_num_rows($exec59);             
              if($num59 != 0)
              {
                $ser = "Services";
              }
              else
              {
                $ser = "";
              }
			$res6transactionamount = $res6transactionamount + $totalpaylatercreditpayment;
			
			if($res6transactionamount != 0)
			{
			$snocount = $snocount + 1;

			  $total = $total + $res6transactionamount;
		
			  
			
				  
				  //$snocount = $snocount + 1;
				  
			//echo $cashamount;
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
			<tr >
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientname; ?></div></td>    
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientcode; ?></div></td>  
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6visitcode; ?></div></td> 
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>	
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6docno; ?></div></td>
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
			</tr>
			<?php
			$res6transactionamount=0;
			$respaylatercreditpayment=0;
			
			}
			}
				
			if($transactiontype=='paylatercredit')
			{

			$respaylatercreditpayment=0;
			$res6transactiondate = $res2['groupdate'];
			$res6patientname = $res2['patientname'];
			$res6patientcode = $res2['patientcode'];
			$res6visitcode = $res2['visitcode'];
			$res6billnumber = $res2['billnumber'];
			$res6transactionmode = $res2['subtype'];
			$res6docno = $res2['auto_number'];
			$particulars = $res2['particulars'];

			$res6docno1 = explode("-", $res6docno);
			$res6docno2 = $res6docno1[0];
			if($res6docno2=='CRN'){
			$display_head='Credit Notes';
			}else{
			$display_head='Cr.Note :';
			}
				
			$res6transactionamount = $res2['fxamount']/$exchange_rate;


			$querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
			$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resmrdno1 = mysqli_fetch_array($execmrdno1);
			$res1mrdno = $resmrdno1['mrdno'];
			$res2mrdno='';
						
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
				$exec57 = mysqli_query($GLOBALS["___mysqli_ston"], $query57) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num57 = mysqli_num_rows($exec57);							
				if($num57 != 0)
				{
					$lab = "Lab";
				}
				else
				{
					$lab = "";
				}
							
				$query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
				$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num58 = mysqli_num_rows($exec58);							
				if($num58 != 0)
				{
					$rad = "Rad";
				}
				else
				{
					$rad = "";
				}
							
				$query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
				$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num59 = mysqli_num_rows($exec59);							
				if($num59 != 0)
				{
					$ser = "Services";
				}
				else
				{
					$ser = "";
				}
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
				$snocount = $snocount + 1;
				$total = $total + $res6transactionamount;
							
				//echo $cashamount;
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
				<tr >
					<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientname; ?> </div></td>		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientcode; ?></div></td>	
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>	
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6docno; ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				</tr>
				<?php
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				
				}
			}
			
			if($transactiontype=='pharmacycredit')
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res2['groupdate'];
				$res6patientname = $res2['patientname'];
				$res6patientcode = $res2['patientcode'];
				$res6visitcode = $res2['visitcode'];
				$res6billnumber = $res2['billnumber'];
				$res6transactionmode = $res2['subtype'];
				$res6docno = $res2['auto_number'];
				$particulars = $res2['particulars'];
				//$docno  = $res2['docno'];

        
				$querymrdno1 = "select mrdno from master_customer where customercode='$res6patientcode'";
				$execmrdno1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymrdno1) or die ("Error in Querymrdno1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resmrdno1 = mysqli_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				
				$res6transactionamount = $res2['fxamount']/$exchange_rate;
								
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				
				$res6transactionamount = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($res6transactionamount != 0)
				{
				$snocount = $snocount + 1;


				$total = $total + $res6transactionamount;
						
					
							
				//$snocount = $snocount + 1;
							
				//echo $cashamount;
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
				<tr >
					<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
					<td width="6%"class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
					<td width="32%"class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientname; ?> </div></td> 
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res6docno; ?></div></td>
					<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				</tr>
				<?php
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				}
				}
			
			if($transactiontype=='PAYMENT')
			{
			$billnum=$res2['billnumber'];
			$squery="select billnumber from master_transactionpaylater where accountnameano = '$searchsupplieranum'  and accountnameid='$searchsuppliercode'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit') and billnumber='$billnum'";
			$exequery=mysqli_query($GLOBALS["___mysqli_ston"], $squery);
			$numquery=mysqli_num_rows($exequery);
			if($numquery>0)
			
			{
				$resonaccountpayment=0;
				$res3transactiondate = $res2['groupdate'];
				$res3patientname = $res2['patientname'];
				$res3patientcode = $res2['patientcode'];
				$res3visitcode = $res2['visitcode'];
				$res3billnumber = $res2['billnumber'];
				$res3docno = $res2['auto_number'];
				$res3transactionmode = $res2['subtype'];
				$res3transactionnumber = $res2['accountname'];
				$particulars = $res2['particulars'];
				if($res3patientname=='')
				{
					$res3patientname='On Account';
				}
				
			 	$res3transactionamount = $res2['fxamount']/$exchange_rate;
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res3transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);

				$totalonaccountpayment = 0;
			 	 $snocount = $snocount + 1;

			 	 $res3transactionamount = $res3transactionamount - $totalonaccountpayment;
				if($snocount == 1)
				{
					$total = $openingbalance - $res3transactionamount;

				}
				else
				{
					$total = $total - $res3transactionamount;

				}
				if($res3transactionamount != 0)
				{
								
				
				//$snocount = $snocount + 1;
			
				//echo $cashamount;
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
			<tr >
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientname; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2['subtype']; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $schemefromvisit; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $memberno; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $preauthcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3docno; ?></div></td>
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format(abs($res3transactionamount),2,'.',','); ?></div></td>
			</tr>
			<?php
			}
			}
			}
			
			?>
	<?php } ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Total</strong></td>
			<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
			
			</tr>
	
</table>