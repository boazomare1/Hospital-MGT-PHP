<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$totalcredit = "0.00";
$overalldebit= "0.00";
$overallcredit= "0.00";
$overallbalance= "0.00";

//This include updatation takes too long to load for hunge items database.
// for Excel Export
if (isset($_REQUEST["account"])) { $account = $_REQUEST["account"]; } else { $account = ""; }
if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }
$account = trim($account);
$subtype = trim($subtype);
?></head>
<style type="text/css">
<!--
.bodytext31 {FONT-SIZE: 12px; 
}       
.bodytext315 {FONT-SIZE: 11px; 
}
-->
</style>

<body>
<table cellspacing="0" cellpadding="4" width="758" align="left" border="0">
  <tr>
    <td colspan="13" align="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" 
	class="bodytext31">
			<?php
			$query1 = "select * from master_company where auto_number = '$companyanum'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1companyname = $res1['companyname'];
			$res1address1 = $res1['address1'];
			$res1area = $res1['area'];
			$res1city = $res1['city'];
			$res1state = $res1['state'];
			$res1emailid1= $res1['emailid1'];
			$res1country = $res1['country'];
			$res1pincode = $res1['pincode'];
			$res1phonenumber1 = $res1['phonenumber1'];

			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
        <img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
        <?php
			}
			?>    </td>
    <td align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    
    <td colspan="9" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32"><?php
	echo '<strong class="bodytext33">'.$res1companyname.'</strong>';
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($res1phonenumber1 != '')
	 {
	echo '<br><strong class="bodytext34">PHONE : '.$res1phonenumber1.'</strong>';
	 }
	echo '<br><strong class="bodytext35">E-Mail : '.$res1emailid1.'</strong>'; 
	?></td>
  </tr>
  <tr>
    <td colspan="13" align="center" bgcolor="#ffffff" class="bodytext311">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="13" align="center" bgcolor="#ffffff" class="bodytext311"><strong>STATEMENT</strong></td>
  </tr>
  <tr>
    <td colspan="13"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>A/C Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $account; ?></strong></td>
    <td colspan="4" align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Date: <?php echo date('M-d-Y',strtotime($transactiondateto)); ?></strong></td>
  </tr>
  <?php if($subtype != '') { ?> 
  <tr>
    <td colspan="13"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>A/C Subtype: <?php echo $subtype; ?></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="13"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="13"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Billing Month:&nbsp;&nbsp;</strong><strong><?php echo date('M',strtotime($ADate1)); ?>-<?php echo date('M',strtotime($ADate2)); ?> <?php echo date('Y',strtotime($ADate1)); ?></strong></td>
  </tr>
  <tr>
    <td colspan="13"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td width="25"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
    <td width="46" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="51" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill No </strong></td>
    <td width="78" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg No </strong></td>
    <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code </strong></td>
    <td width="193" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name </strong></td>
    <td width="8" align="left" valign="center"  
    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No</strong></div></td>
    <td width="193" align="left" valign="center"  
    bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname</strong></div></td>
    <td width="74" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
    <td width="66" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>
    <td width="80" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Balance</strong></td>
  </tr>
  <?php
			if(($account != '')&&($subtype != ''))
			{
        $query21 = "select * from master_transactionpaylater where subtype = '$subtype' and accountname = '$account' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
			}
			else if(($account == '')&&($subtype != ''))
			{
        $query21 = "select * from master_transactionpaylater where subtype = '$subtype' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
			}
			else if(($account != '')&&($subtype == ''))
			{
        $query21 = "select * from master_transactionpaylater where accountname = '$account' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
			} else {
        $query21 = "select * from master_transactionpaylater where transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' and locationcode = '$locationcode1' order by transactiondate ";
      }	  
 			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			$res1subtype = $res21['subtype'];
			$res1transactiondate  = $res21['transactiondate'];
			$res1billnumber  = $res21['billnumber'];
			$res1patientcode = $res21['patientcode'];
			$res1patientname = $res21['patientname'];
			$res1visitcode = $res21['visitcode'];
			
			$query_c = mysqli_query($GLOBALS["___mysqli_ston"], "select memberno from master_customer where customercode = '$res1patientcode' and locationcode = '$locationcode1'") or die ("Error in Query_c".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_c = mysqli_fetch_array($query_c);
			$memberno = $res_c['memberno'];
		  
		  $query2 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode' and billnumber = '$res1billnumber'  and transactiontype = 'finalize' and locationcode = '$locationcode1'";
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res2 = mysqli_fetch_array($exec2);
		  $res2transactionamount = $res2['transactionamount'];
		  $overalldebit=$overalldebit + $res2transactionamount;
		  
		  $query3 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and locationcode = '$locationcode1'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3transactionamount = $res3['transactionamount'];
		  // $res3transactionamount = 0;
		  
		  $query4 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and locationcode = '$locationcode1'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4transactionamount = $res4['transactionamount'];
		  // $res4transactionamount = 0;
		  
		  $query5 = "select sum(a.transactionamount) as transactionamount from master_transactionpaylater as a JOIN master_transactionpaylater as b ON (a.`visitcode` = b.`visitcode`) where b.`transactiontype` = 'finalize' and b.locationcode = '$locationcode1' and a.accountname = '$res21accountname' and a.patientcode = '$res1patientcode' and a.visitcode = '$res1visitcode'  and a.transactiontype = 'pharmacycredit' and a.recordstatus <> 'deallocated' and a.`auto_number` > b.`auto_number`";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res5 = mysqli_fetch_array($exec5);
		  $res5transactionamount = $res5['transactionamount'];
		  // $res5transactionamount = 0;
          $totalcredit=  $res3transactionamount + $res4transactionamount + $res5transactionamount;
		  $overallcredit = $overallcredit  + $totalcredit;
		  $invoicevalue = $res2transactionamount - ($res3transactionamount + $res4transactionamount + $res5transactionamount);
          $overallbalance = $overallbalance + $invoicevalue;
		  if($invoicevalue != 0)
		  {
			?>
  <tr>
    <td class="bodytext31" valign="center"  align="left"><?php echo $snocount=$snocount + 1; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo date('m/d/Y',strtotime($res1transactiondate)); ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $res1billnumber; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientcode; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php echo $res1visitcode; ?></td>
    <td width="203" align="left" valign="center" class="bodytext31"><?php echo $res1patientname; ?></td>
    <td class="bodytext31" valign="middle" align="left"><?php echo $memberno; ?></td>
    <td width="223" class="bodytext31" valign="middle" align="left"><?php echo $res21accountname; ?></td>
    <td class="bodytext31" valign="center"  align="right" ><?php echo number_format($res2transactionamount,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right" ><?php echo number_format($totalcredit,2,'.',','); ?></td>
    <td class="bodytext31" valign="center"  align="right" ><?php echo number_format($invoicevalue,2,'.',','); ?></td>
  </tr>
  <?php
		} }
		?>	
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>       
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>       
    <td  align="right" valign="center" 
            class="bodytext31"><strong>Total</strong></td>
    <td class="bodytext31" valign="center"  align="right" 
           ><strong><?php echo number_format($overalldebit,2,'.',','); ?></strong></td>
    <td class="bodytext31" valign="center"  align="right" 
           ><strong><?php echo number_format($overallcredit,2,'.',','); ?></strong></td>
    <td class="bodytext31" valign="center"  align="right"  
           ><strong><?php echo number_format($overallbalance,2,'.',','); ?></strong></td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>       
    <td  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>       
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td colspan="3"  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td colspan="3"  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td colspan="3"  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td colspan="3"  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td colspan="3"  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" 
           >&nbsp;</td>
    <td colspan="3"  align="right" valign="center" 
            class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right" 
           >&nbsp;</td>
    <td class="bodytext31" valign="center"  align="right"  
           >&nbsp;</td>
  </tr>
</table>
	<page_footer>
<table>
<tr>
	<td class="bodytext315"><strong>THANK YOU FOR YOUR CONTINUED SUPPORT </strong></td>
</tr>
<tr>
  <td class="bodytext315">&nbsp;</td>
</tr>
<tr>
	<td class="bodytext315">Payments should be made by <strong>cash or cheque to <?php echo ucwords(strtolower($res1companyname)); ?></strong>.</td>
</tr>
<tr>
  <td class="bodytext315">&nbsp;</td>
</tr>
<tr>
	<td class="bodytext315">All overdue accounts, as per agreement should be settled as soon as possible to avoid any inconveniences.</td>
</tr>
</table>
</page_footer>
<?php

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('MonthlyInvoiceReport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    } 
?>
