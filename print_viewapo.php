<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$currenttime = date("H:i:s");
$docno = $_SESSION['docno'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];

//header location
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
ob_start();
include("print_header.php");
?>

<?php
if(isset($_REQUEST['billnumber']))
{
$pono = $_REQUEST['billnumber'];
$query55 = "select * from purchaseorder_details where billnumber='$pono'";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$suppliername = $res55['suppliername'];
$suppliercode = $res55['suppliercode'];
$remarks = $res55['remarks'];
$locationcode = $res55['locationcode'];
$locationname = $res55['locationname'];

$query66 = "select * from master_accountname where id='$suppliercode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$addressname = $res66['address'];
//$faxnumber = $res66['faxnumber'];
$address = $addressname;
$tele = $res66['contact'];

}
?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
</style>

<?php 
$query34="select * from purchase_indent where approvalstatus='approved' and pogeneration=''";
		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($exec34);
			
?>
<table width="700" border="" align="center">
	<tr><td  width="700" class="bodyhead" colspan="5">PURCHASE ORDER</td></tr>
	<tr>
    	<td class="bodytextbold">Supplier:</td>
        <td class="bodytext"><?php echo $suppliername; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Location:</td>
        <td class="bodytext"><?php echo $locationname; ?></td>
	</tr>
    <tr>
    	<td class="bodytextbold">Tel No:</td>
        <td class="bodytext"><?php echo $tele; ?></td>
        <td>&nbsp;</td>
        <td class="bodytextbold">LPO No:</td>
        <td class="bodytext"><?php echo $pono; ?></td>
	</tr>
    <tr>
    	<td class="bodytextbold">Address:</td>
        <td class="bodytext"><?php echo $address; ?></td>
        <td class="bodytextbold">&nbsp;</td>
        <td class="bodytextbold">Date:</td>
        <td class="bodytext"><?php echo date('j/n/Y',strtotime($currentdate)); ?></td>
	</tr>
    
</table>
<table border="1" width="700" align="center">
	<tr>
    	<td width="200" align="center" class="bodytextbold">ITEM DESCRIPTION</td>
		<td width="" align="center" class="bodytextbold">ORDER QTY</td>
        <td width="" align="center" class="bodytextbold">PACK SIZE</td>
        <td width="200" align="center" class="bodytextbold">REMARKS</td>
    </tr>
<?php
	$colorloopcount = '';
	$sno = '';
	$query34="select * from purchaseorder_details where billnumber='$pono' and recordstatus='autogenerated' and itemstatus != 'deleted' group by itemname";
	$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num34 = mysqli_num_rows($exec34);
	while($res34=mysqli_fetch_array($exec34))
		{
		$totalquantity =0;
		$amount = 0;
		$itemname=$res34['itemname'];
		$itemcode=$res34['itemcode'];
		$packsize = $res34['packsize'];
		$remarks = $res34['remarks'];
		$query35="select * from purchaseorder_details where billnumber='$pono' and recordstatus='autogenerated' and itemname='$itemname' and itemstatus != 'deleted'";
		$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res35=mysqli_fetch_array($exec35))
		{
		$packagequantity=$res35['packagequantity'];
		$amt = $res35['totalamount'];
		$amount = $amount + $amt;
		$totalquantity=$totalquantity+$packagequantity;
		}
		$query77 = "select * from master_medicine where itemcode='$itemcode'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		//$rate = $res77['rateperunit'];
		$rate = $res77['purchaseprice'];
		
		$amount=number_format($amount,2,'.','');
	?>
		<tr>
			<td class="bodytext"><?php echo $itemname; ?></td>
			<td align="right" class="bodytext"><?php echo $totalquantity; ?></td>
			<td align="right" class="bodytext"><?php echo $packsize;?></td>
			<td align="left" class="bodytext"><?php echo $remarks?></td>
		</tr>
<?php 
		}
	?>
</table>
<table align="center">
	<tr>
    	<td colspan="2" width="700">&nbsp;</td>
    </tr>
    <tr>
    	<td class="bodytextbold" align="left">Prepared By</td>
        <td class="bodytextbold" align="right">Authorized by</td>
    </tr>
    <tr>
    	<td colspan="2" align="center">This purchase order is valid for 24 hours</td>
    </tr>
</table>
			
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
        $html2pdf->Output('printviewapo.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

