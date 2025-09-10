<?php



ob_start();

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$docno=$_SESSION["docno"];

$res21radiologyitemrate = '';

$subtotal = '';

$res19amount1 = ''; 

$res20amount1 = ''; 

$res21amount1 = ''; 

$res22amount1 = '';

$res23amount1 = '';

$res18total  = '';

$res17memberno = '';

$res18copayfixedamount='';

 $res17planpercentage='';

 $planforall ='';

$totalcopaytot=0;

$totalcash_copay = 0;



$pharmacy_fxrate=2872.49;



	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	

 	$locationname = $res1["locationname"];

	$locationcode = $res1["locationcode"];



//$financialyear = $_SESSION["financialyear"];

	//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

	

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





if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//echo $billautonumber;



		$query3 = "select * from master_location where locationcode = '$locationcode'";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res3 = mysqli_fetch_array($exec3);

		//$companyname = $res2["companyname"];

		$address1 = $res3["address1"];

		$address2 = $res3["address2"];

//		$area = $res2["area"];

//		$city = $res2["city"];

//		$pincode = $res2["pincode"];

		$emailid1 = $res3["email"];

		$phonenumber1 = $res3["phone"];

		$locationcode = $res3["locationcode"];

//		$phonenumber2 = $res2["phonenumber2"];

//		$tinnumber1 = $res2["tinnumber"];

//		$cstnumber1 = $res2["cstnumber"];

		$locationname =  $res3["locationname"];

		$prefix = $res3["prefix"];

		$suffix = $res3["suffix"];



	$query2 = "select * from master_transactionpaylater as ms LEFT JOIN login_locationdetails as mel ON ms.username = mel.username where mel.locationcode='$locationcode' and ms.billnumber = '$billautonumber' group by ms.billnumber";

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

	$res2subtype = $res2['subtype'];

	$res2currency = $res2['currency'];

	$res15accountname = $res2['accountname'];

	$res15accountno = $res2['accountcode'];

	

	

	$queryuser="select employeename from master_employee where username='$res2username'";

		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resuser = mysqli_fetch_array($execuser);

	if($res2username !='')

	{

		$username=$resuser['employeename'];

	$res2username = strtoupper($username);

	}

	

	$querymember = "select planpercentage,planname,subtype,consultationdate,consultationtime,accountname from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";

	$execmember = mysqli_query($GLOBALS["___mysqli_ston"], $querymember) or die ("Error in querymember".mysqli_error($GLOBALS["___mysqli_ston"]));

	$resmember = mysqli_fetch_array($execmember);

	//$plancount = mysql_num_rows($execmember);

	 $planpercentage = $resmember['planpercentage'];

	 $res17planpercentage = $resmember['planpercentage'];

	 $plannumber = $resmember['planname'];

	 $patientsubtype = $resmember['subtype'];

	 $visitentrydate = $resmember['consultationdate'];

	 $visitentrytime = $resmember['consultationtime'];
	 $res44accountname=$resmember['accountname'];

  

 $querysub = "select * from master_subtype where auto_number='$patientsubtype'";

 $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], $querysub);

$execsubtype=mysqli_fetch_array($querysubtype);

$patientsubtype1=$execsubtype['subtype'];

$currency=$execsubtype['currency'];

$fxrate=$execsubtype['fxrate'];

if($currency=='')

{

	$currency='UGX';

}

$labtemplate = $execsubtype['labtemplate'];

if($labtemplate == '') { $labtemplate = 'master_lab'; }

$radtemplate = $execsubtype['radtemplate'];

if($radtemplate == '') { $radtemplate = 'master_radiology'; }

$sertemplate = $execsubtype['sertemplate'];

if($sertemplate == '') { $sertemplate = 'master_services'; }





	 

	 $queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resplanname = mysqli_fetch_array($execplanname);

		 	$planforall = $resplanname['forall'];







 $query44 = "select * from master_customer WHERE customercode = '$res2patientcode' ";

$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));

$num44 = mysqli_num_rows($exec44);

$res44 = mysqli_fetch_array($exec44);

//$res44accountname = $res44['accountname'];

$res44customerfullname = $res44['customerfullname'];



$query15 = "select * from master_accountname where auto_number = '$res44accountname'";

$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

$res15 = mysqli_fetch_array($exec15);

//$res15accountname = $res15['accountname'];

//$res15accountno = $res15['id'];



$query_pw = "select consultationamount, pharmacyamount, labamount, radiologyamount, servicesamount from billing_patientweivers where patientcode='$res2patientcode' and visitcode = '$res2visitcode'";

$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]));

$res_pw = mysqli_fetch_array($exec_pw);

$pw_consultation = $res_pw['consultationamount'];

$pw_pharmacy = $res_pw['pharmacyamount'];

$pw_lab = $res_pw['labamount'];

$pw_radiology = $res_pw['radiologyamount'];

$pw_services = $res_pw['servicesamount'];



$query_pw1 = "select docno from patientweivers where patientcode='$res2patientcode' and visitcode = '$res2visitcode'";

$exec_pw1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw1) or die ("Error in Query_pw1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res_pw1 = mysqli_fetch_array($exec_pw1);

$pw_docno = $res_pw1['docno'];



$query4 = "select sum(consultationfees) as totalamount1 from master_visitentry where patientcode='$res2patientcode' and visitcode = '$res2visitcode'";

$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$res4 = mysqli_fetch_array($exec4);

$visconsult = $res4['totalamount1'];

$query33 = "select consultation from billing_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

$res33 = mysqli_fetch_array($exec33);

$copayconsult = $res33['consultation'];

if($copayconsult > 0)

{

$copay=($visconsult/100)*$planpercentage;

}

else

{

$copay = 0;

}

$copayconsult = $copay + $copayconsult;

$res4totalamount = $visconsult-$copayconsult;



 $querycr = "select * from refund_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' ";

	$execcr = mysqli_query($GLOBALS["___mysqli_ston"], $querycr) or die ("Error in Querycr".mysqli_error($GLOBALS["___mysqli_ston"]));

	$numcr=mysqli_num_rows($execcr);

	$rescr = mysqli_fetch_array($execcr);

	$rescrconsultation = $rescr['consultation'];

	if($rescrconsultation > 0)

	{

	$rescrconsultation=($visconsult/100)*$planpercentage;

	}

	else

	{

	$rescrconsultation = 0;

	}

	//if($planpercentage>0.00){ $concopay=($res4totalamount/100)*$planpercentage; $res4totalamount=$res4totalamount-$concopay;}

	if($numcr>0){ $res4totalamount=$res4totalamount+$rescrconsultation;}



$res4totalamount=$res4totalamount-$pw_consultation;	



$query5 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

//echo $num = mysql_num_rows($exec5);

$res5amount = $res5['amount1'];

$res5amount = $res5amount - $pw_pharmacy;



$res8labitemrate = 0;
$totallab_copay = 0;

$query8 = "select labitemcode,labitemrate from billing_paylaterlab where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res8 = mysqli_fetch_array($exec8))

{

$res8labitemcode = $res8['labitemcode'];

$queryfx = "select rateperunit from $labtemplate where itemcode = '$res8labitemcode'";

$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

$resfx = mysqli_fetch_array($execfx);

$res200labitemrate=$res8['labitemrate'];

$querycopay = "select cash_copay from consultation_lab where patientvisitcode = '$res2visitcode' and labitemcode = '$res8labitemcode'";
$execcopay = mysqli_query($GLOBALS["___mysqli_ston"], $querycopay) or die("Error in QueryCopay".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescopay = mysqli_fetch_array($execcopay);
$labcash_copay = $rescopay['cash_copay'];
$totallab_copay += $labcash_copay;

$res8labitemrate = $res8labitemrate + $res200labitemrate;

}

$res8labitemrate = $res8labitemrate - $pw_lab;



$res9radiologyitemrate = 0;
$totalrad_copay = 0;
$totalrad_discount = 0;

$query9 = "select radiologyitemcode,radiologyitemrate from billing_paylaterradiology where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res9 = mysqli_fetch_array($exec9))

{

$res9radiologyitemcode = $res9['radiologyitemcode'];

$queryfx = "select rateperunit from $radtemplate where itemcode = '$res9radiologyitemcode'";

$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

$resfx = mysqli_fetch_array($execfx);

$res2002abitemrate=$res9['radiologyitemrate'];

$querycopay = "select cash_copay,discount from consultation_radiology where patientvisitcode = '$res2visitcode' and radiologyitemcode = '$res9radiologyitemcode'";
$execcopay = mysqli_query($GLOBALS["___mysqli_ston"], $querycopay) or die("Error in QueryCopay".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescopay = mysqli_fetch_array($execcopay);
$radcash_copay = $rescopay['cash_copay'];
$raddisc_amount = $rescopay['discount'];
$totalrad_copay += $radcash_copay;
$totalrad_discount += $raddisc_amount;

$res9radiologyitemrate = $res9radiologyitemrate + $res2002abitemrate;

}

$res9radiologyitemrate = $res9radiologyitemrate - $pw_radiology;



$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10". mysqli_error($GLOBALS["___mysqli_ston"]));

$res10 = mysqli_fetch_array($exec10);

$res10referalrate = $res10['referalrate1'];



$queryopamb = "select sum(rate) as opambrate1 from billing_opambulancepaylater where  visitcode = '$res2visitcode'";

$execopamb = mysqli_query($GLOBALS["___mysqli_ston"], $queryopamb) or die ("Error in Queryopamb". mysqli_error($GLOBALS["___mysqli_ston"]));

$resopamb = mysqli_fetch_array($execopamb);

$resopambrate = $resopamb['opambrate1'];





$queryophom = "select sum(rate) as ophomrate1 from billing_homecarepaylater where  visitcode = '$res2visitcode'";

$execophom = mysqli_query($GLOBALS["___mysqli_ston"], $queryophom) or die ("Error in Queryophom". mysqli_error($GLOBALS["___mysqli_ston"]));

$resophom = mysqli_fetch_array($execophom);

$resophomrate = $resophom['ophomrate1'];



$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";

$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10". mysqli_error($GLOBALS["___mysqli_ston"]));

$res10 = mysqli_fetch_array($exec10);

$res10referalrate = $res10['referalrate1'];



$res11servicesitemrate = 0;
$totalser_copay = 0;

$query11 = "select servicesitemcode,serviceqty,servicesitemrate from billing_paylaterservices where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode' and wellnessitem <> '1'";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));

while($res11 = mysqli_fetch_array($exec11))

{

$res11servicesitemcode = $res11['servicesitemcode'];

$queryfx = "select rateperunit from $sertemplate where itemcode = '$res11servicesitemcode'";

$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

$resfx = mysqli_fetch_array($execfx);

$res2003abitemrate=$res11['servicesitemrate']*$res11['serviceqty'];

$querycopay = "select cash_copay from consultation_services where patientvisitcode = '$res2visitcode' and servicesitemcode = '$res11servicesitemcode'";
$execcopay = mysqli_query($GLOBALS["___mysqli_ston"], $querycopay) or die("Error in QueryCopay".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescopay = mysqli_fetch_array($execcopay);
$sercash_copay = $rescopay['cash_copay'];
$totalser_copay += $sercash_copay;

$res11servicesitemrate = $res11servicesitemrate + $res2003abitemrate;

}

$res11servicesitemrate = $res11servicesitemrate - $pw_services;



$query12 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'paylatercredit'";

$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12". mysqli_error($GLOBALS["___mysqli_ston"]));

$res12 = mysqli_fetch_array($exec12);

$res12transactionamount = $res12['transactionamount'];



$query13 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'pharmacycredit'";

$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13". mysqli_error($GLOBALS["___mysqli_ston"]));

$res13 = mysqli_fetch_array($exec13);

$res13transactionamount = $res13['transactionamount'];



$query14 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactionmodule = 'PAYMENT'";

$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14". mysqli_error($GLOBALS["___mysqli_ston"]));

$res14 = mysqli_fetch_array($exec14);

$res14transactionamount = $res14['transactionamount'];

$resmemberno ='';

$querymember = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";

$execmember = mysqli_query($GLOBALS["___mysqli_ston"], $querymember) or die ("Error in querymember".mysqli_error($GLOBALS["___mysqli_ston"]));

while($resmember = mysqli_fetch_array($execmember)){

$resmemberno = $resmember['memberno'];

}

$res_doctor_fullname = '';
 $query_doctor = "SELECT username from master_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' order by auto_number asc limit 0,1 ";
$exec_doctor  = mysqli_query($GLOBALS["___mysqli_ston"], $query_doctor) or die ("Error in query_doctor".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_doctor  = mysqli_fetch_array($exec_doctor);
 $res_doctor_username = $res_doctor['username'];

 $query_doctor_name= "SELECT employeename from master_employee where username='$res_doctor_username'  ";
$exec_doctor_name  = mysqli_query($GLOBALS["___mysqli_ston"], $query_doctor_name) or die ("Error in query_doctor_name".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res_doctor_name  = mysqli_fetch_array($exec_doctor_name)){
 $res_doctor_fullname = $res_doctor_name['employeename'];
}


$credit = $res12transactionamount + $res13transactionamount;



$rescreditnote = 0.00;



$querycreditnote = "select * from ip_creditnote where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and locationcode = '$locationcode'";

$execcredit = mysqli_query($GLOBALS["___mysqli_ston"], $querycreditnote) or die ("Error in querycreditnote".mysqli_error($GLOBALS["___mysqli_ston"]));

while($rescredit = mysqli_fetch_array($execcredit)){

$rescredit1 = $rescredit['totalamount'];

$rescreditnote += $rescredit1;

}





?>

<style type="text/css">

<!--

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 

}

-->

.bodytext313 {FONT-WEIGHT: bold; FONT-SIZE: 12px; vertical-align:text-bottom; COLOR: #000000; 

}

.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}







.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.border{border-top:1px #000000; border-bottom:1px #000000;}





body{margin:auto; width:100%}



#test {

   width: 16em; 

    word-wrap: break-word;

}

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}



</style>





	<page pagegroup="new" backtop="8mm" backbottom="16mm" backleft="2mm" backright="3mm">

<?php include("print_header.php");

?>

	<page_footer>

                <!---<div class="page_footer" style="width: 100%; text-align: center">

                    <?= $footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; ?>

                </div>---->

    </page_footer>







 <table width="712" border="0" cellspacing="4" cellpadding="0" align="center">

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="361" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="148" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="93" align="left" valign="center" class="bodytext31">&nbsp;</td>

  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Name:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res2patientname; ?></td>

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Invoice No:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $billautonumber; ?></td>

  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Reg No:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res2patientcode; ?></td>

	<td width="148" align="left" valign="center" class="bodytext31"><strong>Invoice Date:</strong></td>

	<td width="93" align="right" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($res2transactiondate)); ?></td>

  </tr>

  <tr>

  	<td width="110" align="left" valign="center" class="bodytext31"><strong>OP Visit Date.</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $visitentrydate.' '.$visitentrytime; ?></td>



    <td width="148" align="left" valign="center" class="bodytext31"><strong>Consultation Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res4totalamount,2,'.',','); ?></td>

  </tr>

  <tr>

    

	<td width="110" align="left" valign="center" class="bodytext31"><strong>OP Visit No.</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res2visitcode; ?></td>

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Pharmacy Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res5amount,2,'.',','); ?></td>

  </tr>

  

  <tr>

  <td width="110" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo nl2br($res15accountname); ?></td>

    

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Lab Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res8labitemrate,2,'.',','); ?></td>

  </tr>

  <tr>

<td width="110" align="left" valign="center" class="bodytext31"><strong>A/c No:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo "$res15accountno";?></td>

    

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Radiology Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res9radiologyitemrate,2,'.',','); ?></td>

  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Insurance Co:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo nl2br($res2subtype); ?></td>

    

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Referral Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res10referalrate,2,'.',','); ?></td>

  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Membership No:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $resmemberno; ?></td>

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Service Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res11servicesitemrate,2,'.',','); ?></td>

  </tr>

  <tr>

    <!-- <td width="110" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="361" align="left" valign="center" class="bodytext31">&nbsp;</td> -->
    
    <td width="110" align="left" valign="center" class="bodytext31"><strong>Doctor :</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res_doctor_fullname ;?></td>

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Credit Notes Amount:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $rescreditnote; ?></td>

  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="361" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="148" align="left" valign="center" class="bodytext31">&nbsp;</td>

    <td width="93" align="right" valign="center" class="bodytext31">&nbsp;</td>

  </tr>

  </table>

  <table width="725" border="0"  cellpadding="0" cellspacing="0" align="center">

 

  <tr>

    <td colspan="2" align="center"><strong><?php echo 'Diagnosis'; ?></strong></td>

  </tr>

   <tr>

   <td colspan="2" align="left">&nbsp;</td>

   </tr>

 <tr>

   <th width='125' align="left">ICD Code</th>

   <th width='600' align="left">ICD Name</th>

   </tr>



<tr>

    <td colspan="2" align="left"><strong><?php echo 'Impression'; ?></strong></td>

  </tr>

 <?php $queryicd = "select * from consultation_icd where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' order by auto_number DESC";

$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));

while($resicd = mysqli_fetch_array($execicd)){

$primarycode = $resicd['primaryicdcode'];

$primary = $resicd['primarydiag'];

?>

 <tr>

   <td align="left"><?= $primarycode; ?></td>

   <td  align="left"><?= $primary; ?></td>

   </tr>

<?php

}

?>

<tr>

    <td colspan="2" align="left"><strong><?php echo 'Final Diagnosis'; ?></strong></td>

  </tr>

 <?php $queryicd = "select * from consultation_icd where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' order by auto_number DESC";

$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));

while($resicd = mysqli_fetch_array($execicd)){

$primarycode = $resicd['secicdcode'];

$primary = $resicd['secondarydiag'];

?>

 <tr>

   <td align="left"><?= $primarycode; ?></td>

   <td  align="left"><?= $primary; ?></td>

   </tr>

<?php

}

?>

<tr>

   <td colspan="2" align="left">&nbsp;</td>

   </tr>

</table>

  <table width="100%" border="0"  cellpadding="0" cellspacing="0" align="center">

 

  <tr>

    <td colspan="6" width="500" align="center"><strong><?php echo 'SUMMARY INVOICE'; ?></strong></td>

  </tr>



 <tr>

   <td colspan="6" align="left">&nbsp;</td>

   </tr>

  

 

 

  <tbody>

<?php

$res4totalamount = number_format($res4totalamount,2);

if($res4totalamount !='0.00')

{

?>

	<tr>

		 <td colspan="6">&nbsp;</td>

	</tr>

	

	

<?php 

$query17 = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res17 = mysqli_fetch_array($exec17))

{

$res17consultationfee=$res17['consultationfees'];



if($res17consultationfee==""){

	$res17consultationfee=0;	

}



$res17viscode=$res17['visitcode'];

$res17consultationdate=$res17['consultationdate'];



 $res17planpercentage=$res17['planpercentage'];

  $plannumber = $res17['planname'];

  $consultingdoctor = $res17['consultingdoctor'];



			

			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resplanname = mysqli_fetch_array($execplanname);

		 	$planforall = $resplanname['forall'];



$res17quantity = '1.00';

 $res17total = $res17consultationfee/$res17quantity;

 //$copayconsult = ($res17consultationfee/100)*$res17planpercentage;

 $query33 = "select consultation,billnumber,billdate from billing_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

 $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

 $res33 = mysqli_fetch_array($exec33);

 $copayconsult = $res33['consultation'];

 $conbillno = $res33['billnumber'];

 $conbilldate = $res33['billdate'];

 $copayconsult = $res33['consultation'];

if($copayconsult > 0)

{

$copayconsult=($res17total/100)*$planpercentage;

}

else

{

$copayconsult = 0;

}

$copaytotalconsult = $res17total-$copayconsult;

//$res41billdate = $res41bill['billdate'];



if($copayconsult!=0.00){

$totalcopaytot = $totalcopaytot + $copayconsult;



}

}



$query11 = "select * from refund_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num=mysqli_num_rows($exec11);

	$res11 = mysqli_fetch_array($exec11);

	$res11billnumber = $res11['billnumber'];

	$consultationrefund = $res11['consultation'];

	if($consultationrefund > 0)

	{

	$consultationrefund=$consultationrefund*$fxrate;

	}

	else

	{

	$consultationrefund = 0;

	}

	



?>



<?php 



$query18 = "select * from master_billing where visitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res18 = mysqli_fetch_array($exec18))

{

$res18billingdatetime=$res18['billingdatetime'];

$res18quantity = '1.00';

$res18billno = $res18['billnumber'];

$res18copayfixedamount = $res18['copayfixedamount'];

$res18total = $res18copayfixedamount/$res18quantity;



}











$subtotal = $res17consultationfee-$copayconsult-$res18copayfixedamount+$consultationrefund-$pw_consultation;

?>



<tr>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 Consultation	  </td>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	  <?php //echo $patientcode; ?>    </td>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	  <?php //echo 'Copay Amount'; ?>    </td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;	</td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	<strong></strong></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	<?php echo number_format($subtotal,2,'.',','); ?></td>

</tr>

<?php

}

?>



<?php



	$original_fxrate= $fxrate;

	if(strtoupper($currency)=="USD"){

		$fxrate = $pharmacy_fxrate;

	}



if($res5amount != '')

{

	

?>



<?php 

$query17 = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));

$res17 = mysqli_fetch_array($exec17);



 $res17planpercentage=$res17['planpercentage'];

 $plannumber = $res17['planname'];

			

			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//

			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resplanname = mysqli_fetch_array($execplanname);

		 	$planforall = $resplanname['forall'];

$res19amount1 = '0.00';

$totalcopaypharm='';

$query19 = "select * from billing_paylaterpharmacy where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber' and medicinename <> 'DISPENSING'";

$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));

$medno=mysqli_num_rows($exec19);

while($res19 = mysqli_fetch_array($exec19))

{



$res19billdate = $res19['billdate'];

$res19medicinename = $res19['medicinename'];

$res19quantity = $res19['quantity'];

$res19rate = $res19['rate'];

$res19amount = $res19['amount'];

$res19medicinecode = $res19['medicinecode'];



/*	$query199b = mysql_query("select a.auto_number from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$res2visitcode' and b.pkg='Yes'");

  	    $count199b = mysql_num_rows($query199b);

		if($count199b>0){

			$query199a = mysql_query("select auto_number from master_medicine where itemcode = '$res19medicinecode' and pkg='Yes'");

			$count199a = mysql_num_rows($query199a);

			if($count199a>0){

				$medno-=1; 			

				continue;

			}

		}

*/





$serviceitemcode199b=array();

		$query199b = mysqli_query($GLOBALS["___mysqli_ston"], "select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$res2visitcode' and b.pkg='Yes'");

/*  		$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where b.pkg='Yes' limit 0,50");

	*/

		$count199b = mysqli_num_rows($query199b);

		if($count199b>0){

  	    while($fetch199b = mysqli_fetch_array($query199b)){			

			array_push($serviceitemcode199b,$fetch199b['itemcode']);

			//$serviceitemcode199b=$fetch199b['itemcode'];

		}

		}

		

 $serviceitemcode=implode("','",$serviceitemcode199b);

	

		$query199a = mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$res19medicinecode' and recordstatus<>'deleted'");

		$count199a = mysqli_num_rows($query199a);

		if($count199a>0){

			$medno-=1; 			

			continue;

		}

			//$pharno1=0;





$query199 = "select * from master_consultationpharm where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and medicinecode = '".$res19medicinecode."'";

$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query199".mysqli_error($GLOBALS["___mysqli_ston"]));

$res199 = mysqli_fetch_array($exec199);

$res199rate = $res199['rate'];

$res199rate = $res19rate;

$res199rate1 = $res199['rate'];

$res199referalno=$res199['refno'];

 $res199amount = $res199['amount'];

$copaypharm = (($res199rate1*$res19quantity)/100)*$res17planpercentage;

$copaypharm = $copaypharm / $fxrate;

$res19rate = $res199rate1 / $fxrate;

$resqtymedrate=$res19rate*$res19quantity;

$res19amount1 = $res19amount1 + $resqtymedrate;



if($planforall=='yes'){ $totalcopaypharm=$totalcopaypharm+$copaypharm;

$totalcopaytot = $totalcopaytot + $copaypharm;

?>



<?php

}

}



if($medno>0)

{

?>



<!--<tr>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	  <?php echo $visitentrydate; ?></td>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <?php echo $res199referalno; ?></td>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	<?php echo "DISPENSING"; ?></td>

	<td align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	<?php echo 1; ?></td>

    <td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <?php echo 0.00; ?></td>

	<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <?php echo 0.00; $res19amount1=$res19amount1+0;?></td>

     

</tr>-->

<?php if($planforall=='yes'){$despamount = 0;  $totalcopaypharm=$totalcopaypharm+$despamount;

$totalcopaytot = $totalcopaytot + $despamount;

?>



<?php

}  }?>

<tr>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">Pharmacy</td>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 

		<?php //echo $patientcode; ?>	</td>

<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

		<?php //echo 'Copay Amount'; ?>	</td>

<td align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	<?php //echo $res18quantity; ?></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <strong></strong></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <?php echo number_format($res19amount1=$res19amount1-$totalcopaypharm-$pw_pharmacy,2,'.',','); ?></td>

</tr>

<?php

}

?>



<?php 

$fxrate = $original_fxrate;



if($res8labitemrate != '')

{

?>



<?php 

$res20amount1 = '0.00';
$totallabcash_copay = 0;
$res200labitemratetotal='';

$query20 = "select * from billing_paylaterlab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber'";

$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));



while($res20 = mysqli_fetch_array($exec20))

{

$res20billdate = $res20['billdate'];

$res20labitemname = $res20['labitemname'];

$res20quantity = '1.00';

$res20labitemrate = $res20['labitemrate'];

$res20labitemcode = $res20['labitemcode'];

$res20amount = $res20labitemrate/$res20quantity;


$query200 = "select * from consultation_lab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and labitemcode = '".$res20labitemcode."'";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
$res200 = mysqli_fetch_array($exec200);
//$res200referalno=$res200['refno'];
 $res200labitemrate = $res200['labitemrate'];
 $labcash_copay = $res200['cash_copay'];


$query200 = "select * from consultation_lab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and labitemcode = '".$res20labitemcode."'";

$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));

$res200 = mysqli_fetch_array($exec200);

$res200referalno=$res200['refno'];

 //$res200labitemrate = $res200['labitemrate'];

$queryfx = "select rateperunit from $labtemplate where itemcode = '$res20labitemcode'";

$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

$resfx = mysqli_fetch_array($execfx);

$res200labitemrate=$resfx['rateperunit'];

				

 $res20amount = $res200labitemrate/$res20quantity;



$res200labitemratetotal=$res200labitemratetotal+$res200labitemrate;

 $copaylab = ($res200labitemrate/100)*$res17planpercentage;

  $res20amount1 = $res20amount1 + $res20amount - $copaylab;



?>



<?php if($planforall=='yes'){

$totalcopaytot = $totalcopaytot + $copaylab; 

}

if($labcash_copay != 0){
	$totalcash_copay += $labcash_copay;
	$totallabcash_copay += $labcash_copay;
}

}


?>

<tr>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 Laboratory </td>

	<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 

		<?php //echo $patientcode; ?>	</td>

<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

		<?php //echo 'Copay Amount'; ?>	</td>

<td align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	<?php //echo $res18quantity; ?></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <strong></strong></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

	 <?php echo number_format($res20amount1-$pw_lab-$totallabcash_copay,2,'.',','); ?></td>

</tr>

<?php

}

?>



<?php 
$res21amount1 = '0.00';
$totalradcash_copay = 0;
$totalraddisc_amount = 0;
$totalraddisc = 0;
$res211referalratetotal='';

if($res9radiologyitemrate != '')

{

?>



<?php 



$query21 = "select * from billing_paylaterradiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber'";

$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res21 = mysqli_fetch_array($exec21))

{

$res21billdate = $res21['billdate'];

$res21radiologyitemname = $res21['radiologyitemname'];

$res21quantity = '1.00';

$res21radiologyitemrate = $res21['radiologyitemrate'];

$res21radiologyitemcode = $res21['radiologyitemcode'];

$res21amount = $res21radiologyitemrate/$res21quantity;

$query211 = "select * from consultation_radiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'  and radiologyitemcode = '".$res21radiologyitemcode."'";
$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
$res211 = mysqli_fetch_array($exec211);
$res211referal=$res211['refno'];
$radcash_copay=$res211['cash_copay'];
$raddisc_amount=$res211['discount'];


$query211 = "select * from consultation_radiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'  and radiologyitemcode = '".$res21radiologyitemcode."'";

$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));

$res211 = mysqli_fetch_array($exec211);

$res211referal=$res211['refno'];

			

$queryfx = "select rateperunit from $radtemplate where itemcode = '$res21radiologyitemcode'";

$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

$resfx = mysqli_fetch_array($execfx);

$res211referalrate=$resfx['rateperunit'];

			

//$res211referalrate = $res211['radiologyitemrate'];

$res21amount = $res211referalrate/$res21quantity;

$res211referalratetotal = $res211referalratetotal+$res211referalrate;

$copayrad = ($res211referalrate/100)*$res17planpercentage;

$res21amount1 = $res21amount1 + $res21amount - $copayrad;

?>



<?php if($planforall=='yes'){

$totalcopaytot = $totalcopaytot + $copayrad; ?>



<?php

}

if($radcash_copay != 0){
	$totalcash_copay += $radcash_copay;
	$totalradcash_copay += $radcash_copay;
}

if($raddisc_amount != 0){
	$totalraddisc += $raddisc_amount;
	$totalraddisc_amount += $raddisc_amount;
}

}



?>

<tr>

<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

		Radiology</td>

<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">		<?php //echo $patientcode; ?></td>

<td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">		<?php //echo 'Copay Amount'; ?></td>

<td align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php //echo $res18quantity; ?></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

<td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res21amount1-$pw_radiology-$totalradcash_copay-$totalraddisc_amount,2,'.',','); ?></td>

</tr>







<?php

}

?>



<?php

if($res10referalrate != '')

{

?>



<?php 

$res22amount1 = '0.00';

$copayreftotal='';

$query22 = "select * from billing_paylaterreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber'";

$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res22 = mysqli_fetch_array($exec22))

{

$res22billdate = $res22['billdate'];

$res22referalname = $res22['referalname'];

$res22quantity = '1.00';

$res22referalrate = $res22['referalrate'];



$res22referalrateamt = $res22['referalamount'];



$res22amount = $res22referalrateamt/$res22quantity;

$res22amount1 = $res22amount1 + $res22amount;



$query222 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));

$res222 = mysqli_fetch_array($exec222);

$res222referalno=$res222['refno'];



$copayref = ($res22referalrateamt/100)*$res17planpercentage;





?>



<?php if($planforall=='yes'){ $copayreftotal=$copayreftotal+$copayref;

$totalcopaytot = $totalcopaytot + $copayref; ?>



<?php

}

}

?>

<tr>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

		Referral	  </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>

<td  align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<strong></strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res22amount1=$res22amount1-$copayreftotal,2,'.',','); ?></td>

</tr>

<?php

}

?>



<?php

$res222amount1 = '0.00';

if($resopambrate != '')

{

?>



<?php 



$copayambtotal='';

$copayopamb='';

$query2227 = "select * from billing_opambulancepaylater where visitcode='$res2visitcode' and patientcode='$res2patientcode' ";

$exec2227 = mysqli_query($GLOBALS["___mysqli_ston"], $query2227) or die ("Error in Query2227".mysqli_error($GLOBALS["___mysqli_ston"]));

$row = mysqli_num_rows($exec2227);

while($res2227 = mysqli_fetch_array($exec2227))

{

$res2227billdate = $res2227['recorddate'];

$res2227referalname = $res2227['description'];

$res2227quantity = $res2227['quantity'];

$res2227referalrate = $res2227['rate'];

$res2227amount = $res2227referalrate*$res2227quantity;

$res222amount1 = $res222amount1 + $res2227amount;



$query2221 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in Query2221".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2221 = mysqli_fetch_array($exec2221);

$res2227referalno=$res2221['refno'];



$copayopamb = (($res2227referalrate*$res2227quantity)/100)*$res17planpercentage;





?>



<?php if($planforall=='yes'){ $copayambtotal=$copayambtotal+$copayopamb;

$totalcopaytot = $totalcopaytot + $copayopamb; ?>



<?php

}

}

?>

<tr>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

		OP Ambulance  </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>

<td  align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<strong></strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res222amount1=$res222amount1-$copayambtotal,2,'.',','); ?></td>

</tr>

<?php

}

?>





<?php

$res2222amount1 = '0.00';

if($resophomrate != '')

{

?>



<?php 



$copayhomtotal='';

$copayhom='';

$query2222 = "select * from billing_homecarepaylater where visitcode='$res2visitcode' and patientcode='$res2patientcode' ";

$exec2222 = mysqli_query($GLOBALS["___mysqli_ston"], $query2222) or die ("Error in Query2222".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res2222 = mysqli_fetch_array($exec2222))

{

$res2222billdate = $res2222['recorddate'];

$res2222referalname = $res2222['description'];

$res2222quantity = $res2222['quantity'];

$res2222referalrate = $res2222['rate'];

$res2222amount = $res2222referalrate*$res2222quantity;

$res2222amount1 = $res2222amount1 + $res2222amount;



$query2228 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec2228 = mysqli_query($GLOBALS["___mysqli_ston"], $query2228) or die ("Error in Query2228".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2228 = mysqli_fetch_array($exec2228);

$res222referalno=$res2228['refno'];



$copayhom = (($res2222referalrate*$res2222quantity)/100)*$res17planpercentage;





?>



<?php if($planforall=='yes'){ $copayhomtotal=$copayhomtotal+$copayhom;

$totalcopaytot = $totalcopaytot + $copayhom; ?>



<?php

}

}

?>

<tr>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">

		Homecare </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>

<td  align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<strong></strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res2222amount1=$res2222amount1-$copayhomtotal,2,'.',','); ?></td>

</tr>

<?php

}

?>





<?php

if($res11servicesitemrate != '')

{

?>



<?php 

$res23amount1 = '0.00';
$totalsercash_copay = 0;
$res23servicesitemratetotal='';

$copaysertotal='';

$query23 = "select * from billing_paylaterservices where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber' and wellnessitem <> '1' group by servicesitemcode";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res23 = mysqli_fetch_array($exec23))

{

$res23billdate = $res23['billdate'];

$res23servicesitemname = $res23['servicesitemname'];

$res23servicesitemrate = $res23['servicesitemrate'];

$res23servicesitemcode = $res23['servicesitemcode'];





 $query2111 = "select * from billing_paylaterservices where  patientvisitcode='$res2visitcode' and patientcode ='$res2patientcode' and servicesitemcode = '$res23servicesitemcode' and billnumber = '$billautonumber'";

$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

$numrow2111 = mysqli_num_rows($exec2111);

$resqty = mysqli_fetch_array($exec2111);

			 $serqty=$resqty['serviceqty'];

			 //$servicesitemrate=$resqty['servicesitemrate'];

			 $seramount=$resqty['amount'];

			 

$queryfx = "select rateperunit from $sertemplate where itemcode = '$res23servicesitemcode'";

$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

$resfx = mysqli_fetch_array($execfx);

$res233serviceitemrate=$resfx['rateperunit'];

$servicesitemrate=$resfx['rateperunit'];

/*$res23servicesitemamount = $res23servicesitemrate*$numrow2111;*/



$res23servicesitemamount = $seramount;



$res23amount = $res23servicesitemamount;

$res23amount1 = $res23amount1 + $res23amount;



$query233 = "select * from consultation_services where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and servicesitemcode = '".$res23servicesitemcode."'";

$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));

$res233 = mysqli_fetch_array($exec233);

$numrow233 = mysqli_num_rows($exec233);

$res233referal=$res233['refno'];

// $res233serviceitemrate=$res233['servicesitemrate'];
$sercash_copay=$res233['cash_copay'];

//$res23servicesitemrate = $res233serviceitemrate/$serqty;

if($res233serviceitemrate == 0){
	$res23servicesitemrate = $res23servicesitemrate;
} else {
	$res23servicesitemrate = $res233serviceitemrate;
}

$res23servicesitemratetotal1=$res23servicesitemrate*$serqty;

$res23servicesitemratetotal = $res23servicesitemratetotal+$res23servicesitemratetotal1;

$copayser = ($res233serviceitemrate/100)*$res17planpercentage;

$copayser1 = (($res233serviceitemrate*$serqty)/100)*$res17planpercentage;

$copaysertotal=$copaysertotal+$copayser1;
$res23amount1 = $res23servicesitemratetotal;

?>





<?php if($planforall=='yes'){

$totalcopaytot = $totalcopaytot + $copayser1; ?>



<?php

}

if($sercash_copay != 0){
	$totalcash_copay += $sercash_copay;
	$totalsercash_copay += $sercash_copay;
}

}



?>

<tr>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	  

		Service	  </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">		<?php //echo $patientcode; ?>    </td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	

		<?php //echo 'Copay Amount'; ?>    </td>

<td  align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23amount1-$pw_services-$totalsercash_copay,2,'.',','); ?></td>

</tr>

<?php

}

?>



<?php 



$totalpayable = '';

$grandtotal = '';

$totalcopaytot;

$grandtotal = $subtotal + $res19amount1 + $res20amount1 + $res21amount1 + $res22amount1 + $res23amount1+$res222amount1+$res2222amount1 - ($pw_lab+$pw_radiology+$pw_services) + $totalcopaytot - $totalcash_copay - $totalraddisc_amount;

$totalpayable = $grandtotal - $rescreditnote - $totalcopaytot;

$totalpayable = number_format($totalpayable,2,'.',',');

$grandtotal = number_format($grandtotal,2,'.',',');

include('convert_currency_to_words.php');

$convertedwords = covert_currency_to_words($totalpayable);

?>

</tbody>

<tr>

  <td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

  <td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

  <td align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

  <td align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

  <td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

  <td align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

</tr>



<tr>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo $grandtotal; ?></td>

</tr>



<tr>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Credits:</strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($rescreditnote,2,'.',','); ?></td>

</tr>

<tr>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Copay:</strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($totalcopaytot,2,'.',','); ?></td>

</tr>

<tr>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Amount Payable:</strong></td>

<td  align="right" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php echo $totalpayable; ?></td>

</tr>

<?php
$querya = "select accountname,transactionamount from master_transactionpaylater where visitcode='$res2visitcode' and patientcode='$res2patientcode' and transactiontype='finalize' and billnumber='$billautonumber'";
$execa = mysqli_query($GLOBALS["___mysqli_ston"], $querya) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
$numrowa = mysqli_num_rows($execa);
if($numrowa>1){
?>
<tr>
	<td colspan="6"><strong>Receivable Accounts : </strong></td>
</tr>
<?php
while($resa = mysqli_fetch_array($execa)){
?>
<tr>
<td colspan="3"><?= $resa['accountname'] ?></td>
<td align="right"><?= number_format($resa['transactionamount'],2) ?></td>
<td colspan="2"></td>
</tr>
<?php
}
}
?>
<tr>

<td>&nbsp;</td>

</tr>

<tr>

<td  align="left" valign="middle" 

	 bgcolor="#ffffff" class="bodytext31"><strong>Served By: </strong></td>

<td  align="left" valign="middle" colspan="5"

	 bgcolor="#ffffff" class="bodytext31"><?php echo strtoupper($res2username); ?></td>

</tr>



<tr>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">    <?php //echo $res18billingdatetime; ?></td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">    <?php //echo $patientcode; ?></td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">    <?php //echo 'Copay Amount'; ?></td>

<td  align="left" valign="left" 

	 bgcolor="#ffffff" class="bodytext31"><?php //echo $res18quantity; ?></td>

<td colspan="2" align="right" valign="left" 

	 bgcolor="#ffffff"><strong><?php //echo ' '.$res2transactiondate.' '.$res2transactiontime[0].':'.$res2transactiontime[1]; ?></strong></td>

</tr>



</table>





</page>

<?php 

  $total = $res4totalamount + $res5amount + $res8labitemrate + $res9radiologyitemrate + $res10referalrate + $res11servicesitemrate;

  $amountdue = $total - $credit; 

  ?>





<?php

$content = ob_get_clean();



// convert in PDF

require_once('html2pdf/html2pdf.class.php');

try

{

	$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

	//$html2pdf->setDefaultFont('Arial');

	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

	$html2pdf->Output('print_paylater2.pdf');

}

catch(HTML2PDF_exception $e) {

	echo $e;

	exit;

}

?>





