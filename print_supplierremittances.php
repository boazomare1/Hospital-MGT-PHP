<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$suppliername="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];

	$query3 = "select * from master_location where locationcode = '$locationcode'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	//$companyname = $res2["companyname"];
	$address1 = $res3["address1"];
	$address2 = $res3["address2"];
	//$area = $res2["area"];
	//$city = $res2["city"];
	//$pincode = $res2["pincode"];
	$emailid1 = $res3["email"];
	$phonenumber1 = $res3["phone"];
	$locationcode = $res3["locationcode"];
	//$phonenumber2 = $res2["phonenumber2"];
	//$tinnumber1 = $res2["tinnumber"];
	//$cstnumber1 = $res2["cstnumber"];
	$locationname =  $res3["locationname"];
	$prefix = $res3["prefix"];
	$suffix = $res3["suffix"];

if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $getcanum = ""; }

$totalamount=0;
$query5="select * from master_transactionpharmacy where docno='$docno'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
$entrydate = $res5['transactiondate'];

$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";
$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res51 = mysqli_fetch_array($exec51);
$totalamount = $res51['transactionamount'];
	  
$payableamount = $totalamount;
$paymentmode = $res5['transactionmode'];
$number = $res5['chequenumber'];
$date = $res5['chequedate'];
$bankname = $res5['bankname'];
$suppliername = $res5['suppliername'];
switch ($paymentmode) {
    case "CHEQUE":
        $desp = "CHQNO".$number;
        break;
    case "CASH":
        $desp =  "CASH";
        break;
    case "ONLINE":
        $desp =  "ONLINE";
        break;
    default:
        $desp = "";
}
?>

<style>
.bodyhead{font-weight:bold; font-size:16px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;}
</style>
<page backtop="10mm" backbottom="10mm" backright=1mm backleft="1mm">
<?php include("print_header.php");?>
<table  align="center" border="" width="700" cellpadding="" cellspacing="0">
	<tr><td width="700" class="bodyhead" colspan="4">REMITTANCE ADVICE - Supplier Receivable</td></tr>
    <tr>
        <td  align="left" width="" rowspan="2" valign="center" class="bodytextbold">Received From:</td>
        <td  align="left" width="200" rowspan="2" valign="center" class="bodytext"><?php echo $suppliername; ?></td>
        <td  align="left" width="" valign="center" class="bodytextbold">Received Date:</td>
        <td align="left" width="" valign="center" class="bodytext" ><?php echo $entrydate; ?></td>
    </tr>
    <tr>
        <td class="bodytextbold" valign="center"  align="left">Received No:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo $docno; ?></td>
    </tr>
    <tr>
        <td class="bodytextbold" valign="center"  align="left">Account No:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo $number; ?></td>
        <td class="bodytextbold" valign="center"  align="left">Received Amount:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo number_format($totalamount,2,'.',','); ?></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
</table>
<table width="700" border="1" cellspacing="" cellpadding="2" align="center">
   
    <tr>
        <td width="10%" class="bodytextbold">Date</td>
        <td width="10%" class="bodytextbold">Reference</td>
        <td width="250" class="bodytextbold">Description</td>
        <td width="20%" class="bodytextbold">Original Amt</td>
        <td width="20%" class="bodytextbold">Balance</td>
        <td width="20%" class="bodytextbold">Received</td>
    </tr>
                     <?php 
			   $sno = 0;
			  $totamount = 0;
            $query2 = "select * from master_transactionpharmacy where docno='$docno' and recordstatus='allocated'";
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2 = mysqli_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			 	  $billnumber = $res2['billnumber'];
				 
				  $query23 = "select * from master_transactionpharmacy where billnumber='$billnumber' and transactiontype='PURCHASE'";
				  $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res23 = mysqli_fetch_array($exec23);
				  $billamount = $res23['transactionamount'];
				  $transactiondate = $res2['transactiondate'];
				  $amount = $res2['transactionamount'];
				  $balanceamount = $res2['balanceamount'];
			  $totamount = $totamount + $amount;
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  ?>
<tr>
    <td valign="center" class="bodytext"><?php echo $transactiondate; ?></td>
    <td valign="center" class="bodytext"><?php echo $billnumber; ?></td>
    <td valign="center" class="bodytext"><?php echo $desp.' AMT'.$totalamount;?></td>
    <td valign="center" class="bodytext"><?php echo number_format($billamount,2,'.',','); ?></td>
    <td valign="center" class="bodytext"><?php echo number_format($balanceamount,2,'.',','); ?></td>
    <td valign="center" class="bodytext"><?php echo number_format($amount,2,'.',','); ?></td>
</tr>
                      <?php
			  }
			  //}
			  ?>
</table>

</page>
<!----------------------------------------------------unwanted----------------------------------------->
			   
			
<?php
    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printaccountremit.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

