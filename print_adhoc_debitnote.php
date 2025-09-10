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


$defaulttax = '';
$docno = $_SESSION['docno'];



$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';



if($locationcode!='')

{

	$locationcode=$_REQUEST['locationcode'];

}

else

{

//header location

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	

 	$locationname = $res1["locationname"];

	$locationcode = $res1["locationcode"];

}

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

	


// include("print_header.php");
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

// $oporip=substr($visitcode,-1);

}
 // `consultationdate`, `consultationtime`, `patientcode`, `patientname`, `patientvisitcode`, `description`, `rate`, `amount`, `units`, `docno`, `ref_no`, `billtype`, `accountname`, `locationname`, `locationcode`, `paymentstatus`, `remarks`, `referalrefund`, `username`, `ipaddress`, `billingaccountname`, `billingaccountcode` FROM `adhoc_debitnote`


	$query4 = "SELECT * FROM adhoc_debitnote WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND docno = '$billnumber'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	 $patientname = $res4['patientname']; 

	$billnumbercode = $res4['docno']; 

	$patientcode = $res4['patientcode'];

	$dateonly = $res4['consultationdate']; 

	$visitcode = $res4['patientvisitcode'];

	$patientaccount1 = $res4['accountname'];

	$totalamount = $res4['amount'];
	$rate = $res4['rate'];
	$units = $res4['units'];

	$remarks = $res4['remarks'];
    $ref_no = $res4['ref_no'];

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

    	<td class="bodyhead" colspan="5">DEBIT NOTE</td>

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

    	 

    	<td class="bodytextbold">IP Visit No:</td>

        <td class="bodytext"><?php echo $visitcode; ?></td>

        <td class="bodytext">&nbsp;</td>

        <td class="bodytextbold">Ref No:</td>

        <td class="bodytext"><?php echo $ref_no; ?></td>

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

    	<td class="bodytextbold" width="30" align="center">S.No</td>
        <td class="bodytextbold" width="300" align="center">Item Name</td>
        <td class="bodytextbold" width="70" align="center">Rate</td>
        <td class="bodytextbold" width="70" align="center">Units</td>
        <td class="bodytextbold" width="70" align="center">Amount</td>
    </tr>

<?php

	$sno = '';

	$totalamount = 0;

	$query5 = "SELECT * FROM adhoc_debitnote WHERE patientcode = '$patientcode' AND patientvisitcode = '$visitcode' AND docno = '$billnumber'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	$row5 = mysqli_num_rows($exec5);

	if($row5 > 0)

	{

	while($res5 = mysqli_fetch_array($exec5)){

	$item = $res5['billingaccountname'];
    $description = $res5['description'];

	$amount = $res5['amount'];
	$rate = $res5['rate'];
	$units = $res5['units'];

	$sno = $sno + 1;

	$totalamount = $totalamount + $amount;

?>

   	<tr>
    	<td class="bodytext" align="center"><?php echo $sno;?></td>
        <td class="bodytext" width="300"><?php echo ucwords(strtolower($description));?></td>
        
        <td class="bodytext" align="right"><?php echo $rate;?></td>
        <td class="bodytext" align="right"><?php echo $units;?></td>
        <td class="bodytext" align="right"><?php echo $amount;?></td>
    </tr>
<?php

	}

	}


?>
	<tr>
    	<td class="bodytextbold" colspan="4" align="right">Net Amount:</td>
        <td class="bodytext" align="right"><?php echo number_format($totalamount,2,'.',',');?></td>
    </tr>

</table>

<table align="center" width="100%" border="0">

<?php if($remarks != ""){ ?>

    <tr>

    	<td width="700" class="bodytext" colspan="2" align="left">&nbsp;</td>

    </tr>

    <tr>

    	<td width="100" class="bodytextbold" align="left">Remarks:</td>

        <td width="500" class="bodytext" align="left"><?php echo $remarks; ?></td>

    </tr>

<?php } ?>

</table>

<table width="" border=""  align="center" cellpadding="0" cellspacing="2">
<?php
  $res11billingdatetime=$dateonly;
$res11visitcode=$visitcode;
$res11locationcode=$locationcode;
$res11subtotalamount=$totalamount;
$billautonumber =$billnumbercode;
$ref_billno=$ref_no;
$res11subtotalamount = str_replace(',', '', $res11subtotalamount);
  $source_from='debitnote';
  include ("eTimsapi.php");
  ?>
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

        $html2pdf->Output('printcreditnote.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

