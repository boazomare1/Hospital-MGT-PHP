<?php
//include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$total = '0.00';
$snocount = "";
$colorloopcount="";
$range = "";
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

 header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Delivery_report.xls"');
header('Cache-Control: max-age=80');  
$reportformat = "";
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1  = $_REQUEST["cbfrmflag1"];} else { $cbfrmflag1  = "cbfrmflag1"; }
if (isset($_REQUEST["ADate1"])) { $ADate1  = $_REQUEST["ADate1"];} else { $fromdate  = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["account"])) { $searchsuppliername = $_REQUEST["account"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchaccountcode"])) { $searchaccountcode  = $_REQUEST["searchaccountcode"]; } else { $searchaccountcode  = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode1  = $_REQUEST["locationcode"]; } else { $locationcode1  = ""; }
$labresult_count=0;
$labreq_count=0;
$sno=0;
$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
$ledgername = '';
$res_acc = mysqli_fetch_array($exec_acc);
$accountcode1 = $res_acc['ledger_id'];
$accountname1 = trim($res_acc['ledger_name']);
?>

<table  border="1" cellspacing="0" cellpadding="2">
<tr>
<td>
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
			<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No </strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient </strong></div></td>
			<td width="" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Scheme</strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date </strong></div></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Amount</strong></div></td>
			</tr>
			<?php 
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if($searchaccountcode!=''){
				$schemetype="and b.scheme_id='$searchaccountcode'";
			}else{
				$schemetype="and b.scheme_id like '%%'";
			}
			if($searchsuppliername!='')
			$query25 = "select auto_number,subtype from master_subtype where  subtype = '$searchsuppliername'";
			else
			$query25 = "select auto_number,subtype from master_subtype ";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25 = mysqli_fetch_array($exec25)) {
			$searchsubtypeanum1 = $res25['auto_number'];
			$searchsubtype = $res25['subtype'];
			$query21 = "select auto_number,accountname,id,paymenttype,subtype from master_accountname where  subtype = '$searchsubtypeanum1' order by subtype desc";
			// and recordstatus <> 'DELETED' 
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res21['accountname']);
			$accno =$res21['auto_number'];
			$legid =$res21['id'];
			$query22 = "select accountname from billing_paylater where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and  billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted') group by accountnameano";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res22['accountname']);
			$query23 = "select accountname from billing_ip where locationcode='$locationcode1' and  accountnameano = '$accno' and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and  billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountname!='$accountname1') group by accountnameano"; 
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$res23accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res23['accountname']);
			if($res21accountname==$accountname1){
			$res25accountname=$accountname1;
			}else
			$res25accountname='';
			$query24 = "select accountname from billing_ipcreditapprovedtransaction where locationcode='$locationcode1' and  accountnameano = '$accno' and  billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountnameid = '$legid' ) and completed <> 'completed' and billdate between '$ADate1' and '$ADate2' group by accountnameano"; 
			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24);
			$res24accountname =mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $res24['accountname']);
			if( $res22accountname != '' || $res23accountname != '' || $res24accountname != '' || $res25accountname!='')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<th colspan="8"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></th>
			</tr>
			<?php
			$query2 = "select a.* from billing_paylater as a join master_visitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1' and  a.accountnameano = '$accno' and a.completed <> 'completed' and a.billdate between '$ADate1' and '$ADate2'  and  a.billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted') $schemetype group by a.billno order by a.accountname, a.billdate desc"; 
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2num = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$auto_numbernew = $res2['auto_number'];
			$res2accountname = $res2['accountname'];
			$res2accountnameano = $res2['accountnameano'];
			$res2accountnameid = $res2['accountnameid'];
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['visitcode'];
			$res2billno = $res2['billno'];
			$res2totalamount = $res2['totalamount'];
			$res2billdate = $res2['billdate'];
			$res2patientname = $res2['patientname'];
			$res3subtype = $res2['subtype'];
			$query3 = "select scheme_id,subtype from master_visitentry where visitcode = '$res2visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];	
			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];
			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];
			$slade_status = $res2['slade_status'];
			$slade_claim_id = $res2['slade_claim_id'];
			$claim_file = $res2['upload_claim'];
			$invoice_file = $res2['upload_invoice'];
			$total = $total + $res2totalamount;
			$snocount = $snocount + 1;
			
			?>
		
			<tr>		
			<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?> </div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res2billno; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res2billdate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res2totalamount,2,'.',',');  ?></div></td>
			</tr>
			<?php
			}
			if($legid==$accountcode1){
			$query3 = "select a.* from billing_ipnhif as a join master_ipvisitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1' and  a.completed <> 'completed' and a.recorddate between '$ADate1' and '$ADate2'  and  a.docno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountname='$accountname1' and isnhif='1') $schemetype order by a.recorddate desc"; 
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
			$res3accountname = $accountname1;
			$accountcode = $res3['accountcode'];
			$res3patientcode = $res3['patientcode'];
			$res3visitcode = $res3['visitcode'];
			$res3billno = $res3['docno'];
			$res3totalamount = $res3['finamount'];
			$res3billdate = $res3['recorddate'];
			$res3patientname = $res3['patientname'];
			$sqlmain="select subtype from master_transactionpaylater where billnumber='$res3billno' and accountname='$res3accountname'";
			$execs3 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmain) or die ("Error in sqlmain".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress3 = mysqli_fetch_array($execs3);
			$res3subtype = $ress3['subtype'];
			$query3 = "select scheme_id,subtype from master_ipvisitentry where visitcode = '$res3visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];	
			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];
			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];
			$total = $total + $res3totalamount;
			$snocount = $snocount + 1;
			
			?>
			<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res3billno; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res3billdate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
			</tr>
			<?php
			}
			}
			//// ip
			$query31 = "select a.* from billing_ip as a join master_ipvisitentry as b on a.visitcode=b.visitcode  where a.locationcode='$locationcode1' and  a.accountnameano = '$accno' and a.completed <> 'completed' and a.billdate between '$ADate1' and '$ADate2'  and  a.billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and isnhif='0') $schemetype group by a.billno order by a.accountname, a.billdate desc"; 
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec31))
			{
			$res3accountname = $res3['accountname'];
			$res3patientcode = $res3['patientcode'];
			$res3visitcode = $res3['visitcode'];
			$res3billno = $res3['billno'];
			$res3totalamount = $res3['totalamount'];
			$res3billdate = $res3['billdate'];
			$res3patientname = $res3['patientname'];
			$res3subtype = $res3['subtype'];
			$auto_numbernew = $res3['auto_number'];
			$slade_status = $res3['slade_status'];
			$slade_claim_id = $res3['slade_claim_id'];
			$claim_file = $res3['upload_claim'];
			$invoice_file = $res3['upload_invoice'];
			$query3 = "select scheme_id,subtype from master_ipvisitentry where visitcode = '$res3visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];	
			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];
			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];
			$total = $total + $res3totalamount;
			$snocount = $snocount + 1;
			
			?>
			<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res3billno; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res3billdate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
			</tr>
			<?php
			}
			$query32 = "select a.* from billing_ipcreditapprovedtransaction as a join master_ipvisitentry as b on a.visitcode=b.visitcode where a.locationcode='$locationcode1'  and a.completed <> 'completed' and a.billdate between '$ADate1' and '$ADate2' and a.accountnameano = '$accno' and  a.billno NOT IN (SELECT  billno FROM print_deliverysubtype where status != 'deleted' and accountnameid = '$legid') $schemetype group by a.billno order by a.accountname, a.billdate desc"; 
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec32))
			{
			$res3accountname = $res3['accountname'];
			$res3patientcode = $res3['patientcode'];
			$res3visitcode = $res3['visitcode'];
			$res3billno = $res3['billno'];
			$res3totalamount = $res3['totalamount'];
			$res3billdate = $res3['billdate'];
			$res3patientname = $res3['patientname'];
			$res3subtype = $res3['subtype'];
			$query3 = "select scheme_id,subtype from master_ipvisitentry where visitcode = '$res3visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$scheme_id = $res3['scheme_id'];	
			$subtype = $res3['subtype'];
			$query4 = "select subtype from master_subtype where  auto_number = '$subtype'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4subtype = $res4['subtype'];
			$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";
			$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_sc = mysqli_fetch_array($exec_sc);
			$scheme_name = $res_sc['scheme_name'];
			$total = $total + $res3totalamount;
			$snocount = $snocount + 1;	
			?>
			<tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res3patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res3billno; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res4subtype; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $scheme_name; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $res3billdate; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
			</tr>
			<?php
			}
			}
			}
			}
			}
			?>
		</tbody>
    </table>
</td>
</tr>
</table>