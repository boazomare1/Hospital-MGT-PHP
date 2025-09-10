<?php

ob_start();
session_start();
error_reporting(0);
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
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
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

//include("print_header.php");




$locationcode = 'LTC-1';

$queryloc = "select * from master_location where locationcode = '$locationcode'";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$locationname = $resloc['locationname'];

$address1 = $resloc['address1'];

$address2 = $resloc['address2'];

$phone = $resloc['phone'];

$email = $resloc['email'];

$website = $resloc['website'];



$queryloc = "select tinnumber from master_company";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$tinnumber = $resloc['tinnumber'];

?>
<style>

.logo{font-weight:bold; font-size:18px; text-align:center;}

.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}

.bodytextbold{font-weight:bold; font-size:15px; }

.bodytextnew{font-weight:bold; font-size:15px; }

.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}

.border{border-top: 1px #000000; border-bottom:1px #000000;}

td{{height: 50px;padding: 5px;}

table{table-layout:fixed;

width:100%;

display:table;

border-collapse:collapse;}


input {
  height:20px;
  border: none;
  box-shadow: -2px 5px 0px -2px grey, 2px 5px 0px -2px grey;
}
input:focus {
  outline: none;
}


</style>

<table border="0" cellpadding="0" cellspacing="0" align="center" width='700' >



  <tr>

    <td width="250" rowspan="5"  align="left" valign="center" 

	 bgcolor="#ffffff" class="bodytext31"><?php

			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";

			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3showlogo = mysqli_fetch_array($exec3showlogo);

			$showlogo = $res3showlogo['showlogo'];

			if ($showlogo == 'SHOW LOGO')

			{ 

			?>

      <img src="logofiles/1.jpg" width="150" height="120" />

    <?php

			}

			?></td>
			

    <td width="325" align="right" valign="middle" 

	 bgcolor="#ffffff" class="bodytexthead"></td>
	 
	 
<td width="50"></td>
  </tr>

   <!-- <tr>

      <td height="16" align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytexttin"><strong>Tin Number: <?= $tinnumber;?></strong></td>

    </tr> -->
		
	<tr>
	<td align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytextaddress"></td>

      <td align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytextnew"><?php echo $locationname; ?> <br /><?php echo $address1; ?><br />

        <?php echo $address2; ?><br />

      Tel : <?php echo $phone; ?><br />

      Email : <?php echo $email; ?></td>

    </tr>

    <tr>
<td align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytextaddress"></td>
      <td align="left" valign="top" 

	 bgcolor="#ffffff" class="bodytextnew">Website : <?php echo $website; ?></td>

  </tr>






</table>

<hr />




<?php


 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
	$locationcode=$location;
	}
	
	
	$query4 = "SELECT * FROM master_journalentries WHERE   docno = '$billnumber'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$docno = $res4['docno']; 
	$entrydate = $res4['entrydate']; 
	$narration = $res4['narration']; 
	


		//location get end here
?>



<table align="center">

   <tr>
    	<td class="bodyhead" colspan="5">Journal Entries</td>
   </tr>
    <tr>
    	<td class="bodytextbold">Doc No:</td>
        <td class="bodytext"><?php echo $docno; ?></td>
        <td class="bodytext">&nbsp;</td>
        <td class="bodytextbold">Doc Date:</td>
        <td class="bodytext"><?php echo $entrydate; ?></td>
    </tr>
	<tr>
    	<td width="700" colspan="5">&nbsp;</td>
    </tr>
</table>

<table align="center"  border="border-collapse">
	<tr>
    	<td class="bodytextbold" width="18" align="center">S.No</td>
		<td class="bodytextbold" width="10" align="center"></td>
		<td class="bodytextbold" width="180" align="center">Ledger</td>
		<td class="bodytextbold" width="100" align="center">Dr.Amt</td>
		<td class="bodytextbold" width="10" align="center"></td>
        <td class="bodytextbold" width="100" align="center">Cr.Amt</td>
        <td class="bodytextbold" width="10" align="center"></td>
		<td class="bodytextbold" width="150" align="center">Cost Center</td>
		<td class="bodytextbold" width="150" align="center">Remarks</td>
   </tr>

<?php
	$sno = '';
	$totalamountcredit = 0;
	$totalamountdebit = 0;
	$query5 = "SELECT * FROM master_journalentries WHERE docno = '$docno' ";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row5 = mysqli_num_rows($exec5);
	if($row5 > 0)
	{
	while($res5 = mysqli_fetch_array($exec5)){
	$ledgername = $res5['ledgername'];
	$selecttype = $res5['selecttype'];
	$creditamount = $res5['creditamount'];
	$debitamount = $res5['debitamount'];
	$cost_center = $res5['cost_center'];
	
	$totalamountcredit=$totalamountcredit+$creditamount;
	$totalamountdebit=$totalamountdebit+$debitamount;
	
	
	$remarks = $res5['remarks'];
	
	
	 $query41 = "SELECT * FROM master_costcenter WHERE   auto_number = '$cost_center'";
	$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in query41".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res41 = mysqli_fetch_array($exec41);
	 $res41name = $res41['name']; 
	
	$sno = $sno + 1;
	
?>

   	<tr>

    	<td class="bodytext" align="center"><?php echo $sno;?></td>
		
		<td class="bodytext" align="center"></td>

        <td class="bodytext"><?php echo $ledgername;?></td>

        <td class="bodytext" align="right"><?php if($selecttype!='Cr'){  echo number_format($debitamount,2); } else {echo '0.00';}?></td>
		
		<td class="bodytext" align="center"></td>
		
        <td class="bodytext" align="right"><?php if($selecttype!='Dr'){  echo number_format($creditamount,2); } else {echo '0.00';}?></td>
		
		<td class="bodytext" align="center"></td>
		
		<td class="bodytext" align="center"><?php echo $res41name;?></td>
		
		<td class="bodytext" align="center"> <?php  echo wordwrap($remarks,30,"<br>\n",TRUE);?></td>
    </tr>

<?php

	}
	}

?>

<tr>

    	<td class="bodytextbold" width="18" align="center"></td>
		<td class="bodytextbold" width="10" align="center"></td>
		<td class="bodytextbold" width="180" align="center"></td>
		<td class="bodytextbold" width="100" align="right"><?php echo number_format($totalamountdebit,2);?></td>
		<td class="bodytextbold" width="10" align="center"></td>
        <td class="bodytextbold" width="100" align="right"><?php echo number_format($totalamountcredit,2);?></td>
        <td class="bodytextbold" width="10" align="center"></td>
		<td class="bodytextbold" width="150" align="center"></td>
		<td class="bodytextbold" width="150" align="center"></td>
    </tr>


</table>


<table align="center" >
<tr>
    	<td width="700" colspan="5">&nbsp;</td>
 </tr>
</table>
<table align="center" border="border-collapse"  > 
   <tr >
   
        <td class="bodytext" width="100" ><strong>Narration</strong></td>
        <td class="bodytext" align="left" width="300" height="50" >  <?php echo $narration; ?></td>
       
    </tr>
	
</table>




<?php

    $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('journalprint.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

