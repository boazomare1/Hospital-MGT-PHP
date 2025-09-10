<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$docno = $_SESSION["docno"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$subtotal = '';

$res19amount1 = ''; 

$res20amount1 = ''; 

$res21amount1 = ''; 

$res22amount1 = '';

$res23amount1 = '';

$res18total  = '';

$colorloopcount = '';

$totallab = 0.00;

$totalradiology = 0.00;

$totalmedicine = 0.00;

$totalservices = 0.00;

$totalreferal = 0.00;

$overalltotal = 0.00;

$sno = 0;

$labrate =0.00;



//$financialyear = $_SESSION["financialyear"];



	$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';





	$query6 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res6 = mysqli_fetch_array($exec6);

	$res6companycode = $res6["companycode"];

	

	$query7 = "select * from master_settings where locationcode='$locationcode' and companycode = '$res6companycode' and modulename = 'SETTINGS' and 

	settingsname = 'CURRENT_FINANCIAL_YEAR'";

	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res7 = mysqli_fetch_array($exec7);

	$financialyear = $res7["settingsvalue"];

	$_SESSION["financialyear"] = $financialyear;

	//echo $_SESSION['financialyear'];

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

 $locationcode;

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }



if (isset($_REQUEST["patientcode"])) { $patientcode1 = $_REQUEST["patientcode"]; } else { $patientcode1 = ""; }

//echo $billnumber;

if (isset($_REQUEST["visitcode"])) { $visitcode1 = $_REQUEST["visitcode"]; } else { $visitcode1 = ""; }



	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	

 	$logolocationname = $res1["locationname"];

	$logolocationcode = $res1["locationcode"];

	$query3 = "select * from master_location where locationcode = '$logolocationcode'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	//$companyname = $res2["companyname"];

	$logoaddress1 = $res3["address1"];

	$logoaddress2 = $res3["address2"];

	//$area = $res2["area"];

	//$city = $res2["city"];

	//$pincode = $res2["pincode"];

	$logoemailid1 = $res3["email"];

	$logophonenumber = $res3["phone"];

	$logolocationcode = $res3["locationcode"];

	//$phonenumber2 = $res2["phonenumber2"];

	//$tinnumber1 = $res2["tinnumber"];

	//$cstnumber1 = $res2["cstnumber"];

	$logolocationname =  $res3["locationname"];

	$logoprefix = $res3["prefix"];

	$logosuffix = $res3["suffix"];

	

$query1 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$res1phonenumber1 = $res1['phonenumber1'];





$query2 = "select * from master_transactionpaylater where locationcode='".$locationcode."' and billnumber = '$billnumber'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$res2patientname = $res2['patientname'];

$res2patientcode = $res2['patientcode'];

$res2visitcode = $res2['visitcode'];

$res2billnumber = $res2['billnumber'];

$res2transactionamount = $res2['transactionamount'];

$res2transactiondate = $res2['transactiondate'];

$res2transactiontime = $res2['transactiontime'];

$res2transactiontime = explode(":",$res2transactiontime);

$res2transactionmode = $res2['transactionmode'];

$res2username = $res2['username'];

$res2accountname = $res2['accountname'];



$res2username = strtoupper($res2username);

//$res2cashgiventocustomer = $res2['cashgiventocustomer'];

//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];



$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where locationcode='$locationcode' and customercode='$patientcode1'");

$execlab1=mysqli_fetch_array($querylab1);

$res22patientname=$execlab1['customerfullname'];

$res22patientaccount=$execlab1['accountname'];



$query26 = "select * from refund_paynowlab where locationcode='$locationcode' and billnumber = '$billnumber' ";

$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));

$res26 = mysqli_fetch_array($exec26);

//$res22patientname = $res22['patientname'];

$res26billnumber = $res26['billnumber'];

$res26transactionamount = $res26['labitemrate'];



$res26accountname = $res26['accountname'];

$res26username = $res26['username'];



$query27 = "select * from refund_paynow where locationcode='$locationcode' and billnumber = '$billnumber' ";

$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

$res27 = mysqli_fetch_array($exec27);

$res27billnumber = $res27['billnumber'];

$res27transactiontime = $res27['transactiontime'];

$res27accountname = $res27['accountname'];

$res27username = $res27['username'];

$res27transactiondate = $res27['transactiondate'];

$res27username = strtoupper($res27username);

$res26patientcode = $res27['patientcode'];

$res26visitcode = $res27['visitcode'];

$res26patientname = $res27['patientname'];



$queryuser="select employeename from master_employee where username='$res27username'";

		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resuser = mysqli_fetch_array($execuser);

		$username=$resuser['employeename'];

//$res2cashgiventocustomer = $res2['cashgiventocustomer'];

//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];



  

$query4 = "select sum(totalamount) as totalamount1 from billing_paylaterconsultation where locationcode='$locationcode' and billno = '$res2billnumber' and visitcode = '$res2visitcode'";

$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$res4 = mysqli_fetch_array($exec4);

$res4totalamount = $res4['totalamount1'];



$query5 = "select sum(amount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

//echo $num = mysql_num_rows($exec5);

$res5amount = $res5['amount1'];



$query8 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

$res8 = mysqli_fetch_array($exec8);

$res8labitemrate = $res8['labitemrate1'];



$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

$res9 = mysqli_fetch_array($exec9);

$res9radiologyitemrate = $res9['radiologyitemrate1'];



$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10". mysqli_error($GLOBALS["___mysqli_ston"]));

$res10 = mysqli_fetch_array($exec10);

$res10referalrate = $res10['referalrate1'];



$query11 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));

$res11 = mysqli_fetch_array($exec11);

$res11servicesitemrate = $res11['servicesitemrate1'];



$query12 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'paylatercredit'";

$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12". mysqli_error($GLOBALS["___mysqli_ston"]));

$res12 = mysqli_fetch_array($exec12);

$res12transactionamount = $res12['transactionamount'];



$query13 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'pharmacycredit'";

$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13". mysqli_error($GLOBALS["___mysqli_ston"]));

$res13 = mysqli_fetch_array($exec13);

$res13transactionamount = $res13['transactionamount'];



$query14 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactionmodule = 'PAYMENT'";

$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14". mysqli_error($GLOBALS["___mysqli_ston"]));

$res14 = mysqli_fetch_array($exec14);

$res14transactionamount = $res14['transactionamount'];



$credit = $res12transactionamount + $res13transactionamount;



$query200 = "select * from refund_paynowlab where locationcode='$locationcode' and billnumber = '$billnumber' ";

$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));



$totalpharm=0;

$phaname = '';



$query25 = "select * from pharmacysalesreturn_details where locationcode='$locationcode' and visitcode='$visitcode1' and patientcode='$patientcode1' and billstatus='pending'";

$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res25 = mysqli_fetch_array($exec25))

			{

			$phadate=$res25['entrydate'];

			$phaname=$res25['itemname'];

			$phaquantity=$res25['quantity'];

			$pharate=$res25['rate'];

			$phaamount=$res25['totalamount'];

			}

			

$query87="select * from master_consultationpharm where locationcode='$locationcode' and patientcode='$patientcode1' and patientvisitcode='$visitcode1' and medicinename='$phaname'";

			$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res87=mysqli_fetch_array($exec87);

			$pharefno=$res87['billnumber'];

						 

			 ?>

<script language="javascript">

window.onload = function() {

    if(!window.location.hash) {

        window.location = window.location + '#externalbill';

        window.location.reload();

    }

}



function escapekeypressed()

{

	//alert(event.keyCode);

	if(event.keyCode=='27'){ window.close(); }

}



</script>

<style>

.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; 

}

.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; 

}

.style2 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}

.bodytext40{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }

.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }

.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}



.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }

.bodytext30 { FONT-SIZE: 18px; FONT-WEIGHT: bold; COLOR: #000000; }

.logo {

	font-weight: bold;

	font-size: 18px;

	text-align: center;

}

.bodyhead {

	font-weight: bold;

	font-size: 20px;

	text-align: center;

}

.bodytextbold {

	font-weight: bold;

	font-size: 16px;

	text-align: center;

}

.bodytext {

	font-weight: bold;

	font-size: 16px;

	text-align: center;

	vertical-align: middle;

}

.border {

	border-top: 1px #000000;

	border-bottom: 1px #000000;

}

td {

{

height: 50px;

padding: 5px;

}

table {

	table-layout: fixed;

	width: 100%;

	display: table;

}

</style>

<body>

<?php //include('print_header80x80.php'); ?>

<?php 

  $total = $res4totalamount + $res5amount + $res8labitemrate + $res9radiologyitemrate + $res10referalrate + $res11servicesitemrate;

  $amountdue = $total - $credit; 

  ?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td colspan="2" align="left" valign="center" 

	bgcolor="#ffffff" class="bodytext">&nbsp;</td>

    <td align="center" valign="center" bgcolor="#ffffff" class="bodytext">&nbsp;</td>

    <td colspan="2"  align="right" valign="center" 

	bgcolor="#ffffff" class="bodytext">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="2" align="left" valign="center" 

	bgcolor="#ffffff" class="bodytext"><strong>Bill No: </strong><?php echo $billnumber; ?></td>

    <td valign="center" bgcolor="#ffffff" align="center" class="bodytext36">&nbsp;</td>

    <td colspan="2"  align="right" valign="center" 

	bgcolor="#ffffff" class="bodytext"><strong>Bill Date: </strong><?php echo date("d/m/Y", strtotime($res27transactiondate)); ?></td>

  </tr>

  

  <tr>

    <td colspan="5" align="left" valign="center" 

	bgcolor="#ffffff" class="bodytextbold"><?php echo $res26patientname; ?> (<?php echo $res26patientcode; ?>, <?php echo $res26visitcode; ?>)</td>

  </tr>

  



  <tr>

    <td align="left" valign="center" 

	bgcolor="#ffffff" class="bodytextbold" width="">S.No. </td>

    <td align="left" valign="center" 

	bgcolor="#ffffff" class="bodytextbold" width="200">Description</td>

    <td valign="center" bgcolor="#ffffff" align="center" class="bodytextbold" width="">Qty</td>

    <td align="right" valign="center" 

	bgcolor="#ffffff" class="bodytextbold" width="">Rate</td>

    <td align="right" valign="center" 

	bgcolor="#ffffff" class="bodytextbold" width="">Amount</td>

  </tr>

  <?php 

			$query201 = "select * from refund_paynowlab where locationcode='$locationcode' and billnumber = '$billnumber' ";

			$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res201 = mysqli_fetch_array($exec201))

			 {

			$labdate=$res201['billdate'];

			$labname=$res201['labitemname'];

			$labrate=$res201['labitemrate'];

			$totallab=$totallab+$labrate; 

			?>

  <tr>

    <td class="bodytext39"  valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>

    <td  align="left" valign="center" nowrap  width="200" class="bodytext39"><?php echo $labname; ?></td>

    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($labrate,2,'.',','); ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($labrate,2,'.',','); ?></td>

  </tr>

  <?php

			}

			?>
			
			
	<?php 

			$query201 = "select * from refund_consultation where locationcode='$locationcode' and billnumber = '$billnumber' ";

			$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res201 = mysqli_fetch_array($exec201))

			 {

			$labdate=$res201['billdate'];

			$labname=$res201['labitemname'];

			$labrate=$res201['labitemrate'];

			$totallab=$totallab+$labrate; 

			?>

  <tr>

    <td class="bodytext39"  valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>

    <td  align="left" valign="center" nowrap  width="200" class="bodytext39"><?php echo $labname; ?></td>

    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($labrate,2,'.',','); ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($labrate,2,'.',','); ?></td>

  </tr>

  <?php

			}

			?>		
			
			
			
			
			
			
			
			
			
			

  <?php 

			$query202 = "SELECT * FROM refund_paynowradiology WHERE locationcode='".$locationcode."' AND  billnumber = '".$billnumber."' ";

			$exec202 = mysqli_query($GLOBALS["___mysqli_ston"], $query202) or die ("Error in Query202".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res202 = mysqli_fetch_array($exec202))

			 {

			$radiologydate=$res202['billdate'];

			$radiologyitemname=$res202['radiologyitemname'];

			$radiologyitemrate=$res202['radiologyitemrate'];

			$totalradiology=$totalradiology+$radiologyitemrate; 

			?>

  <tr>

    <td class="bodytext39"  valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>

    <td  align="left" valign="center" nowrap  width="200" class="bodytext39"><?php echo $radiologyitemname; ?></td>

    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($radiologyitemrate,2,'.',','); ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($radiologyitemrate,2,'.',','); ?></td>

  </tr>

  <?php

			}

			?>

  <?php 

  $query78="select locationcode,planname,planpercentage from master_visitentry where patientcode='$patientcode1' and visitcode='$visitcode1'";

$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res78=mysqli_fetch_array($exec78);

$locationcodeget=$res78['locationcode'];

$plancode=$res78['planname'];

$planpercentage=$res78['planpercentage'];

//get plandetails 

$queryplan = "select forall from master_planname where auto_number='".$plancode."'";

$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $queryplan) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$resplan = mysqli_fetch_array($execplan);

$forall = $resplan['forall'];



			$query203 = "select * from refund_paynowpharmacy where locationcode='".$locationcode."' AND  billnumber = '$billnumber' ";

			$exec203 = mysqli_query($GLOBALS["___mysqli_ston"], $query203) or die ("Error in Query203".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res203 = mysqli_fetch_array($exec203))

			 {

			$medicinedate=$res203['billdate'];

			$medicinename=$res203['medicinename'];

			$medicinerate=$res203['rate'];

			$medicineamount=$res203['amount'];

			$medicinequantity = $res203['quantity'];

		    $totalmedicine=$totalmedicine+$medicineamount; 

			if($forall=='yes'){$medicinerate=($medicinerate/100)*$planpercentage;}

			?>

  <tr>

    <td class="bodytext39"  valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>

    <td  align="left" valign="center" nowrap  width="200" class="bodytext39"><?php echo $medicinename; ?></td>

    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap"><?php echo $medicinequantity; ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($medicinerate,2,'.',','); ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($medicineamount,2,'.',','); ?></td>

  </tr>

  <?php

			}

			?>

  <?php 

			$query204 = "select * from refund_paynowreferal where locationcode='$locationcode' and billnumber = '$billnumber' ";

			$exec204 = mysqli_query($GLOBALS["___mysqli_ston"], $query204) or die ("Error in Query204".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res204 = mysqli_fetch_array($exec204))

			 {

			$referaldate=$res204['billdate'];

			$referalname=$res204['referalname'];

			$referalrate=$res204['referalrate'];

			$totalreferal=$totalreferal+$referalrate; 

			?>

  <tr>

    <td class="bodytext39"  valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>

    <td  align="left" valign="center" nowrap  width="200" class="bodytext39"><?php echo $referalname; ?></td>

    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($referalrate,2,'.',','); ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($referalrate,2,'.',','); ?></td>

  </tr>

  <?php

			}

			?>

  <?php 

			$query205 = "select * from refund_paynowservices where locationcode='$locationcode' and billnumber = '$billnumber' ";

			$exec205 = mysqli_query($GLOBALS["___mysqli_ston"], $query205) or die ("Error in Query205".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res205 = mysqli_fetch_array($exec205))

			 {

			$servicedate=$res205['billdate'];

			$servicesitemname=$res205['servicesitemname'];

			$servicesitemrate=$res205['servicesitemrate'];

			$servicesitemqty=$res205['servicequantity'];

			$totalser=$servicesitemrate*$servicesitemqty;

			$totalservices=$totalservices+$totalser; 

			?>

  <tr>

    <td class="bodytext39"  valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>

    <td  align="left" valign="center" nowrap  width="200" class="bodytext39"><?php echo $servicesitemname; ?></td>

    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap"><?php echo $servicesitemqty;?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($servicesitemrate,2,'.',','); ?></td>

    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($totalser,2,'.',','); ?></td>

  </tr>

  <?php

			}

			?>

  <?php $overalltotal = $totallab + $totalradiology + $totalmedicine + $totalreferal + $totalservices; ?>

  <tr>

    <td class="bodytext31"  valign="center"  align="left"></td>

    <td  align="left" width="200" valign="center" nowrap class="bodytext31">&nbsp;</td>

    <td class="bodytext31" valign="center"  align="left" nowrap="nowrap">&nbsp;</td>

    <td  align="center" valign="center" class="bodytext40">Total:</td>

    <td class="bodytext40" valign="center"  align="center"><?php echo number_format($overalltotal,2,'.',','); ?></td>

  </tr>

  

  <!-- 

		  <?php

	include ('convert_currency_to_words.php');

	$convertedwords = covert_currency_to_words($overalltotal); ?>

-->

  

  <tr>

    <td colspan="5"  align="left"  valign="center" bgcolor="#ffffff"  class="bodytext">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="5"  align="left"  valign="center" bgcolor="#ffffff"  class="bodytext"><strong>Kenya Shillings: </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

  </tr>

  <tr>

    <td class="bodytext31"  valign="center"  align="left">&nbsp;</td>

    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;</td>

    <td class="bodytext31" valign="center"  align="left" nowrap="nowrap">&nbsp;</td>

    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

    <td class="bodytext31" align="left">&nbsp;</td>

  </tr>

  <tr>

    

    <td class="bodytextbold" valign="center" colspan="2" align="right"><?php echo 'Served By:'; ?></td>

    <td class="bodytext" align="left" colspan="3" ><?php echo strtoupper($username); ?></td>

  </tr>

  <tr>

    <td class="bodytext31"  valign="center"  align="left">&nbsp;</td>

    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;

      <?php //echo 'Copay Amount'; ?></td>

    <td class="bodytext31" valign="center"  align="left"><?php //echo 'Served By:'; ?></td>

    <td class="bodytext31" align="center"><?php echo $res27transactiontime; ?></td>

    <td align="left" nowrap class=""></td>

  </tr>

</table>

<?php	

/*$content = ob_get_clean();



// convert in PDF



try

{

$html2pdf = new HTML2PDF('P', 'A5', 'en');

//      $html2pdf->setModeDebug();

//$html2pdf->setDefaultFont('Arial');

$html2pdf->writeHTML($content, isset($_GET['vuehtml']));



$html2pdf->Output('print_paynowrefund.pdf');

}

catch(HTML2PDF_exception $e) {

echo $e;

exit;

}*/

?>

