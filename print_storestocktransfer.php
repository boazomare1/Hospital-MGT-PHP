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

$query2 = "SELECT * FROM master_stock_transfer WHERE docno = '$docno' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
	$fromstore = $res2['fromstore'];
	$tostore = $res2['tostore'];
	$date = $res2['entrydate'];
$query4 = "SELECT * FROM master_store WHERE storecode='$fromstore'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
	$fromstore = $res4['store'];
	$fromloc = $res4['locationname'];
	
$query5 = "SELECT * FROM master_store WHERE storecode='$tostore'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
	$tostore = $res5['store'];
	$toloc = $res5['locationname'];

?>

<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;}
</style>
<page backtop="10mm" backbottom="10mm" backright=1mm backleft="1mm">
<table align="center">
	<tr>
   	  <td class="logo">Avenue Hospital - <?php echo $locationname;?></td>
      <td class="logo">Tel: <?php echo $phonenumber1;?></td>
	</tr>
</table>
<table  align="center" border="" width="500" cellpadding="" cellspacing="0">
	<tr><td width="650" class="bodyhead" colspan="4">STOCK TRANSFER</td></tr>
    <tr>
      <td  align="left" width="" valign="center" class="bodytextbold">From Location:</td>
      <td  align="left" width="200" valign="center" class="bodytext"><?php echo $fromloc.'('.$fromstore.')'; ?></td>
        <td  align="left" width="" valign="center" class="bodytextbold">Issue No:</td>
        <td align="left" width="" valign="center" class="bodytext" ><?php echo $docno; ?></td>
    </tr>
    <tr>
        <td class="bodytextbold" valign="center"  align="left">To Location:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo $toloc.'('.$tostore.')'; ?></td>
        <td class="bodytextbold" valign="center"  align="left">Issue Date:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo date('d/m/Y',strtotime($date)); ?></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
</table>

<table width="750" border="" cellspacing="" cellpadding="2" align="center">
   
    <tr>
        <td width="10%" class="bodytextbold border">S.No.</td>
        <td width="350" class="bodytextbold border">Medicine Name</td>
        <td width="10%" class="bodytextbold border">Batch No</td>
        <td width="20%" class="bodytextbold border">Qty</td>
        <td width="20%" class="bodytextbold border">Rate</td>
        <td width="20%" class="bodytextbold border">Amount</td>
    </tr>
<?php 
	$sno = 0;
	$totalamount = 0;
	$totalqty = 0;
	$query2 = "SELECT * FROM master_stock_transfer WHERE docno = '$docno' "; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2)){
	$fromstore = $res2['fromstore'];
	$tostore = $res2['tostore'];
	$date = $res2['entrydate'];
	$catagoryname = $res2['categoryname'];
	$itemcode = $res2['itemcode'];
	$itemname = $res2['itemname'];
	$transqty = $res2['transferquantity'];
	$batch = $res2['batch'];
	$rate = $res2['rate'];
	$amount = $res2['amount'];
	$tolocatinocode = $res2['tolocationcode'];
	$tolocationname = $res2['tolocationname'];
	$sno = $sno+1;
	$totalamount = $totalamount + $amount;
	$totalqty = $totalqty + $transqty;
?>        
    <tr>
        <td valign="center" class="bodytext"><?php echo $sno; ?></td>
        <td valign="center" align="left" class="bodytext"><?php echo $itemname; ?></td>
        <td valign="center" class="bodytext"><?php echo $batch;?></td>
        <td valign="center" class="bodytext"><?php echo number_format($transqty,2,'.',','); ?></td>
        <td valign="center" class="bodytext"><?php echo number_format($rate,2,'.',','); ?></td>
        <td valign="center" align="right" class="bodytext"><?php echo number_format($amount,2,'.',','); ?></td>
    </tr>
<?php
	}
?>   
	<tr>
    	<td colspan="3" class="bodytextbold" align="right">Total:</td>
        <td class="bodytext"><?php echo number_format($totalqty,2,'.',',');?></td>
        <td>&nbsp;</td>
        <td align="right" class="bodytext"><?php echo number_format($totalamount,2,'.',',');?></td>
    </tr>         
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

