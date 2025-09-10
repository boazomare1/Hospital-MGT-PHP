<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');

$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$cashamount1='';
$cashamount='';
$cashamount5='';
$totalopcash='';
$totalipcash='';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
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

</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="opipconsolidatedrevenuereport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP/IP Consolidated Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
	<?php
	$sumpackage=0.00;
	$sumpharmacy=0.00;
	$sumlab=0.00;
	$sumrad=0.00;
	$sumservice=0.00;
	$sumunfinal=0.00;
	$sumtransaction=0.00;
	$refundamount=0.00;
	$sumbed=0.00;
		
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	if ($cbfrmflag1 == 'cbfrmflag1')
	{
		$query2 = "select sum(cashamount) as cashamount1 from master_transactionpaynow where transactiondate between '$ADate1' and '$ADate2'"; 
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
     	$res2cashamount1 = $res2['cashamount1'];
		   
		$query3 = "select sum(cashamount) as cashamount2 from master_transactionexternal where transactiondate between '$ADate1' and '$ADate2'"; 
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$res3cashamount1 = $res3['cashamount2'];
		  
		$query4 = "select sum(cashamount) as cashamount3 from master_billing where billingdatetime between '$ADate1' and '$ADate2'"; 
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$res4cashamount1 = $res4['cashamount3'];
		  
		
		$res5cashamount1 = 0;
	    
		$cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res5cashamount1;

		$totalopcash = $cashamount - $res5cashamount1;
		
		$query12 = "select * from billing_paylater  where billdate between '$ADate1' and '$ADate2' "; 
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res12 = mysqli_fetch_array($exec12))
		{
		$res12patientcode = $res12['patientcode'];
		$res12visitcode = $res12['visitcode'];
		$res12billno = $res12['billno'];
		  
		$query6 = "select sum(transactionamount) as cashamount5 from master_transactionpaylater where patientcode = '$res12patientcode' and visitcode='$res12visitcode' and billnumber ='$res12billno' and  transactiontype='finalize' and transactiondate between '$ADate1' and '$ADate2'"; 
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$res6cashamount1 = $res6['cashamount5'];
		$cashamount5=$cashamount5+$res6cashamount1;
		}
		
	    $query5 = "select sum(totalamount) as totalamount1 from refund_paylater where billdate between '$ADate1' and '$ADate2'"; 
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res5 = mysqli_fetch_array($exec5);
		$res5totalamount1 = 0;
		$refundamount=$refundamount+$res5totalamount1;
		$cashamount5=$cashamount5-$refundamount;
		
		
		$query18 = "select * from ip_bedallocation where paymentstatus = 'completed' and creditapprovalstatus = '' and recorddate between '$ADate1' and '$ADate2' ";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res18 = mysqli_fetch_array($exec18))
		 {
				$res18patientcode = $res18['patientcode'];
				$res18visitcode = $res18['visitcode'];
				
				$query19 = "select * from master_ipvisitentry where visitcode='$res18visitcode' and patientcode='$res18patientcode'";
				$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res19 = mysqli_fetch_array($exec19);
				$res19finalbillno = $res19['finalbillno'];
				
				$query20 = "select * from billing_ip where billno='$res19finalbillno'";
				$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res20 = mysqli_fetch_array($exec20);
				$num20 = mysqli_num_rows($exec20);
				$res20totalamount=$res20['totalamount'];
				$sumtransaction=$sumtransaction+$res20totalamount;
		}	
		
		
		$query8 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = '' and recordstatus = '' and recorddate between '$ADate1' and '$ADate2' group by visitcode ";
		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res8 = mysqli_fetch_array($exec8))
		 {
				$res8patientcode = $res8['patientcode'];
				$res8visitcode = $res8['visitcode'];
				$res8bed= $res8['bed'];

				$query18 = "select * from master_bedcharge where bedanum='$res8bed' and recordstatus =''";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num18 = mysqli_num_rows($exec18);
				$res18 = mysqli_fetch_array($exec18);
				$res18charge = $res18['rate'];
				
				$query9 = "select * from master_ipvisitentry where patientcode = '$res8patientcode' and visitcode = '$res8visitcode' and paymentstatus=''";
				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res9 = mysqli_fetch_array($exec9);
				$package = $res9['package'];
				$packageamount = $res9['packagecharge'];
				$res9admissionfees = $res9['admissionfees'];
				$sumpackage=$sumpackage+$packageamount;
						}			
	            $sumpackage=$sumpackage+$res9admissionfees+$res18charge;
				
				$query10 = "select sum(subtotal) as subtotal3 from pharmacysalesreturn_details where entrydate between '$ADate1' and '$ADate2' ";
				$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res10 = mysqli_fetch_array($exec10);
				$res10subtotal=$res10['subtotal3'];
				$sumpharmacy=$res10subtotal;
				
				$query11 = "select sum(labitemrate) as labitemrate1 from ipconsultation_lab where patientcode='$res8patientcode' and patientvisitcode='$res8visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_num_rows($exec11);
				$res11 = mysqli_fetch_array($exec11);
				$res11labitemrate1= $res11['labitemrate1'];
				$sumlab=$res11labitemrate1;
				
				$query111 = "select sum(amount) as amount2 from billing_ipbedcharges where patientcode='$res8patientcode' and visitcode='$res8visitcode' and recorddate between '$ADate1' and '$ADate2' ";
				$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res111 = mysqli_num_rows($exec111);
				while($res111 = mysqli_fetch_array($exec111)){
				$res111amount2= $res111['amount2'];
				$sumbed=$sumbed+$res111amount2;
				}
				
				$query12 = "select sum(radiologyitemrate) as radiologyitemrate1 from ipconsultation_radiology where consultationdate between '$ADate1' and '$ADate2'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res12 = mysqli_num_rows($exec12);
				$res12 = mysqli_fetch_array($exec12);
				$res12radiologyitemrate1= $res12['radiologyitemrate1'];
				$sumrad=$res12radiologyitemrate1;
				
				$query13 = "select sum(servicesitemrate) as servicesitemrate1 from ipconsultation_services where consultationdate between '$ADate1' and '$ADate2'";
				$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res13 = mysqli_num_rows($exec13);
				$res13= mysqli_fetch_array($exec13);
				$res13servicesitemrate1= $res13['servicesitemrate1'];
				$sumservice=$res13servicesitemrate1;
	 
	            $sumunfinal=$sumpackage+$sumpharmacy+$sumrad+$sumservice+$sumbed+$sumlab;
	 
	?>
            <tr>
              <td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>OP Cash </strong></td>
              <td width="22%" align="right" valign="left"  
                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalopcash,2,'.',','); ?></td>
              <td width="10%" align="left" valign="center" bgcolor="#ecf0f5"  
                 class="style1">&nbsp;</td>
              <td width="23%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>IP Finalized </strong></td>
              <td width="21%" align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($sumtransaction,2,'.',','); ?></td>
            </tr>
            <tr>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">OP Credit </td>
              <td align="right" valign="left"  
                bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($cashamount5,2,'.',','); ?></td>
              <td align="left" valign="center"  
                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><span class="style1">IP Un<strong>finalized </strong> </span></td>
              <td align="right" valign="center"  
                bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($sumunfinal,2,'.',','); ?></td>
            </tr>
			<?php 
			$totalop='';
			$totalip='';
			
			$totalop=$totalopcash + $cashamount5;
			$totalip=$sumtransaction + $sumunfinal;

			?>
            <tr>
              <td  align="right" valign="center" 
                bgcolor="#ffffff" class="style1"><span class="style1">Total </span></td>
              <td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="style1"><?php echo number_format($totalop,2,'.',','); ?></td>
              <td align="left" valign="center"  
                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>
              <td align="right" valign="center"  
                bgcolor="#ffffff" class="style1"><span class="style1">Total </span></td>
              <td align="right" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalip,2,'.',','); ?></strong></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
	 <?php } ?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

