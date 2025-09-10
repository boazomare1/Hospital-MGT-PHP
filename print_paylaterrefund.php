<?php
ob_start();
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';
$docno = $_SESSION['docno'];

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
	
include("print_header_pdf3.php");
 //get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
  	$locationcode=$location;
}

//location get end here
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
$billnumber = $_REQUEST["billno"];
}
	
$query4 = "SELECT * FROM refund_paylater WHERE patientcode = '$patientcode' AND visitcode = '$visitcode' AND billno = '$billnumber'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$patientname = $res4['patientname']; 
$billnumbercode = $res4['billno']; 
$patientcode = $res4['patientcode'];
$dateonly = $res4['billdate']; 
$visitcode = $res4['visitcode'];
$patientaccount1 = $res4['accountname'];
$totalamount = $res4['finamount'];
$finalizationbillno = $res4['finalizationbillno'];

?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
</style>
<table align="center">
	<tr>
    	<td class="bodyhead" colspan="5">CREDIT NOTE</td>
    </tr>
    <tr>
    	<td class="bodytextbold">Name:</td>
        <td class="bodytext"><?php echo $patientname; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Bill No:</td>
        <td class="bodytext"><?php echo $billnumbercode; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Reg. No:</td>
        <td class="bodytext"><?php echo $patientcode; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Bill Date:</td>
        <td class="bodytext"><?php echo $dateonly; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Visit No:</td>
        <td class="bodytext"><?php echo $visitcode; ?></td>
        <td class="bodytext">&nbsp;</td>
          <td class="bodytextbold">Ref No:</td>
        <td class="bodytext"><?php echo $finalizationbillno; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Account:</td>
        <td class="bodytext"><?php echo $patientaccount1; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytext"></td>
    </tr>
	<tr>
    	<td width="700" colspan="5">&nbsp;</td>
    </tr>
</table>
<table align="center" border="border-collapse">
	<tr>
    	<td class="bodytextbold" width="100" align="center">S.No</td>
        <td class="bodytextbold" width="450" align="center">Item Name</td>
        <td class="bodytextbold" width="100" align="center">Amount</td>
    </tr>
<?php
	$sno = '';
	$totalcon=0;
	$query41 = "SELECT consultation FROM refund_paylaterconsultation WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in query41".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num41 = mysqli_num_rows($exec41);
	while($res41 = mysqli_fetch_array($exec41)){
	$consult = $res41['consultation'];
	$totalcon=$totalcon+$consult;
//	$sno = $sno + 1;
	if($num41>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo 'OP Consultation';?></td>
        <td class="bodytext" align="right"><?php echo number_format($consult,2,'.',',');?></td>
    </tr>
<?php
	}
	//$sno = '';
	$totallabtotal=0;
	$query5 = "SELECT labitemname,labitemrate FROM refund_paylaterlab WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber' and labitemcode<>''";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num5 = mysqli_num_rows($exec5);
	while($res5 = mysqli_fetch_array($exec5)){
	$item = $res5['labitemname'];
	$amount = $res5['labitemrate'];
	$totallabtotal=$totallabtotal+$amount;
//	$sno = $sno + 1;
	if($num5>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
	$totalradtotal=0;
	$query6 = "SELECT radiologyitemname,radiologyitemrate FROM refund_paylaterradiology WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num6 = mysqli_num_rows($exec6);
	while($res6 = mysqli_fetch_array($exec6)){
	$item = $res6['radiologyitemname'];
	$amount = $res6['radiologyitemrate'];
	$totalradtotal=$totalradtotal+$amount;
	//$sno = $sno + 1;
	if($num6>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
	$totalpharmtotal=0;
	$query6 = "SELECT medicinename,amount FROM refund_paylaterpharmacy WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num6 = mysqli_num_rows($exec6);
	while($res6 = mysqli_fetch_array($exec6)){
	$item = $res6['medicinename'];
	$amount = $res6['amount'];
	$totalpharmtotal=$totalpharmtotal+$amount;
	//$sno = $sno + 1;
	if($num6>=1)
	{
		$sno = $sno + 1;
	}
	?>
	<tr>
		<td class="bodytext" align="center"><?php echo $sno;?></td>
	    <td class="bodytext"><?php echo $item;?></td>
	    <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
	</tr>
   	
<?php
	}
	$totalsertotal=0;
	$query7 = "SELECT servicesitemname,amount FROM refund_paylaterservices WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num7 = mysqli_num_rows($exec7);
	while($res7 = mysqli_fetch_array($exec7)){
	$item = $res7['servicesitemname'];
	$amount = $res7['amount'];
	$totalsertotal=$totalsertotal+$amount;
	//$sno = $sno + 1;
	if($num7>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
	$totalreftotal=0;
	$query8 = "SELECT referalname,referalrate FROM refund_paylaterreferal WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num8 = mysqli_num_rows($exec8);
	while($res8 = mysqli_fetch_array($exec8)){
	$item = $res8['referalname'];
	$amount = $res8['referalrate'];
	$totalreftotal=$totalreftotal+$amount;
	//$sno = $sno + 1;
	if($num8>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
	$totalambtotal=0;
	$query9 = "SELECT description,amount FROM refund_paylaterambulance WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num9 = mysqli_num_rows($exec9);
	while($res9 = mysqli_fetch_array($exec9)){
	$item = $res9['description'];
	$amount = $res9['amount'];
	$totalambtotal=$totalambtotal+$amount;
	//$sno = $sno + 1;
	if($num9>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
	$totalhometotal=0;
	$query10 = "SELECT description,amount FROM refund_paylaterhomecare WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND billnumber = '$billnumber'";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num10 = mysqli_num_rows($exec10);
	while($res10 = mysqli_fetch_array($exec10)){
	$item = $res10['description'];
	$amount = $res10['amount'];
	$totalhometotal=$totalhometotal+$amount;
	//$sno = $sno + 1;
	if($num10>=1)
	{
		$sno = $sno + 1;
	}
?>
   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext"><?php echo $item;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2,'.',',');?></td>
    </tr>
<?php
	}
?>
	<tr>
    	<td class="bodytextbold" colspan="2" align="right">Net Amount:</td>
        <td class="bodytext" align="right"><?php echo number_format($totalamount,2);?></td>
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
        $html2pdf->Output('printopcreditnote.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
