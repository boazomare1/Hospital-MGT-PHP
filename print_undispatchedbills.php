<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="undispatchedbills-list.xls"');
header('Cache-Control: max-age=80');


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;
?>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
  
    <td  valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
	  <tr><td  colspan="4" valign="middle"  ></td></tr>
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
				if($location=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$location'";
				}	
				
				$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
				$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
				$ledgername = '';
				$res_acc = mysqli_fetch_array($exec_acc);

				$accountcode1 = $res_acc['ledger_id'];
				$accountname1 = trim($res_acc['ledger_name']);

				$query24 = "select * from (select billno as billno,billdate as billdate,patientname as patientname,patientcode as patientcode,subtype as subtype,accountname as accountname,totalamount as amount,accountnameid	as	accountid from billing_paylater where  completed!= 'completed' and billdate between '$ADate1' and '$ADate2' and accountnameano!='603' and $pass_location group by billno
				Union all
				select docno as billno,recorddate as billdate,patientname as patientname,patientcode as patientcode,'' as subtype,'$accountname1' as accountname,finamount as amount,accountcode	as	accountid from billing_ipnhif where   completed != 'completed' and recorddate between '$ADate1' and '$ADate2'	and	finamount>0 and $pass_location
				Union all
				select billno as billno,billdate as billdate,patientname as patientname,patientcode as patientcode,subtype as subtype,accountname as accountname,totalamount as amount,accountnameid	as	accountid from billing_ip where  completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and accountnameano!='603' and $pass_location
				union all
				select billno as billno,billdate as billdate,patientname as patientname,patientcode as patientcode,subtype as subtype,accountname as accountname,totalamount as amount,accountnameid	as	accountid from billing_ipcreditapprovedtransaction where  completed <> 'completed' and billdate between '$ADate1' and '$ADate2' and accountnameano!='603' and $pass_location group by billno ) as a order by a.billdate
";
			?>

			<tr>
               <td colspan="4" >
			     <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
						 bordercolor="#666666" cellspacing="0" cellpadding="4" width="1032" 
						 align="left" border="1">
                        <tr><td  colspan="8" valign="middle"  ><strong>Undispatched Bills From <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td></tr>
						 <tr>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" width="5%"><strong>Sno</strong></td>
						  <!--<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="5%"><strong>Batch</strong></td>-->
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="12%"><strong>Bill No</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Bill Date</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Patient Name</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Patient Code</strong></td>
						 <!-- <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Visit Code</strong></td>-->
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Subtype</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Account</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="10%"><strong>Bill Amt.</strong></td>
						 <!-- <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="15%"><strong>Delivery By</strong></td>
						  <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  width="25%"><strong>Delivery Date</strong></td>>-->
						</tr>
                        
						<?php
						$colorloopcount = 0;
						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		                while($res24 = mysqli_fetch_array($exec24)) {

						//$accountnameid=$res24['accountnameid'];
		                //$isnhif=$res24['isnhif'];
						$billno=$res24['billno'];
						$accountname=$res24['accountname'];
						$accountid=$res24['accountid'];
						$checksql="select *	from completed_billingpaylater where billno='$billno' and accountnameid='$accountid'";
						$execs3d = mysqli_query($GLOBALS["___mysqli_ston"], $checksql) or die ("Error in checksql".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2num = mysqli_num_rows($execs3d);	
						if($res2num>0){
							continue;
							}
						$subtype=$res24['subtype'];
                        if($subtype==''){
						$sqlmain="select subtype from master_transactionpaylater where billnumber='$billno' and accountname='$accountname'";
					    $execs3 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlmain) or die ("Error in sqlmain".mysqli_error($GLOBALS["___mysqli_ston"]));
					    $ress3 = mysqli_fetch_array($execs3);
					    $subtype = $ress3['subtype'];
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
						<tr >
			            <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['printno']; ?></td>-->
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billno']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['billdate']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientname']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['patientcode']; ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['visitcode']; ?></td>-->
						<td class="bodytext31" valign="center"  align="left"><?php echo $subtype; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php echo $res24['accountname']; ?></td>
						<td class="bodytext31" valign="center"  align="right"><?php echo number_format($res24['amount'],2,'.',','); ?></td>
						<!--<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['username']; ?></td>
						<td class="bodytext31" valign="center"  align="left"><?php //echo $res24['updatedatetime']; ?></td>-->

                       </tr>
					   <?php } ?>


                 </table>
			   
			   </td>
			</tr>

			<?php } ?>
        
      <tr>
        <td>&nbsp;</td>
      </tr>
       
	  
    </table>
	</td>
	</tr>
</table>

