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

$totalraddisc_amount = 0;


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

	//$res15accountname = $res2['accountname'];

	$res15accountno = $res2['accountcode'];

	

	

	$queryuser="select employeename from master_employee where username='$res2username'";

		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resuser = mysqli_fetch_array($execuser);

	if($res2username !='')

	{

		$username=$resuser['employeename'];

	$res2username = strtoupper($username);

	}

	

	$querymember = "select planpercentage,planname,subtype,consultationdate,consultationtime,accountname,scheme_id from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";

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
  $scheme_id = $resmember["scheme_id"];
	$query_sc = "select * from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);

	$res15accountname = $res_sc['scheme_name'];

 $querysub = "select * from master_subtype where auto_number='$patientsubtype'";

 $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], $querysub);

$execsubtype=mysqli_fetch_array($querysubtype);

$patientsubtype1=$execsubtype['subtype'];

$currency=$execsubtype['currency'];

$fxrate=$execsubtype['fxrate'];

if($currency=='')

{

	$currency='KSH';

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

$query_pw1a = "select preauthcode from billing_paylater where patientcode='$res2patientcode' and visitcode = '$res2visitcode'";

$exec_pw1a = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw1a) or die ("Error in Query_pw1a".mysqli_error($GLOBALS["___mysqli_ston"]));

$res_pw1a = mysqli_fetch_array($exec_pw1a);

$preauthcode = $res_pw1a['preauthcode'];

$query4 = "select sum(consultationfees) as totalamount1,planpercentage,planfixedamount from master_visitentry where patientcode='$res2patientcode' and visitcode = '$res2visitcode'";

$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$res4 = mysqli_fetch_array($exec4);

$visconsult = $res4['totalamount1'];
$planpercentage = $res4['planpercentage'];
$planfixedamount = $res4['planfixedamount'];

$query33 = "select consultation from billing_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";

$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

$res33 = mysqli_fetch_array($exec33);

$copayconsult = $res33['consultation'];

/*if($copayconsult > 0)

{

$copay=($visconsult/100)*$planpercentage;

}

else

{

$copay = 0;

}*/

//$copayconsult = $copay + $copayconsult;

if(($planpercentage>0 || $planfixedamount>0) && $copayconsult > 0)
  $res4totalamount = $visconsult-$copayconsult;
 else
   $res4totalamount = $visconsult;



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

$num4 = mysqli_num_rows($exec5);

$res5 = mysqli_fetch_array($exec5);

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

$querycopay = "select cash_copay, discount from consultation_radiology where patientvisitcode = '$res2visitcode' and radiologyitemcode = '$res9radiologyitemcode' and `op_package_id` IS NULL";
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
$query11 = "select servicesitemcode,serviceqty,servicesitemrate,amount from billing_paylaterservices where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode' and wellnessitem <> '1'";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));

while($res11 = mysqli_fetch_array($exec11))

{

$res11servicesitemcode = $res11['servicesitemcode'];

//$queryfx = "select rateperunit from $sertemplate where itemcode = '$res11servicesitemcode'";

//$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));

//$resfx = mysqli_fetch_array($execfx);

//$res2003abitemrate=$res11['servicesitemrate']*$res11['serviceqty'];
$res2003abitemrate=$res11['amount'];

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


$resmemberno='';
$querymember = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$execmember = mysqli_query($GLOBALS["___mysqli_ston"], $querymember) or die ("Error in querymember".mysqli_error($GLOBALS["___mysqli_ston"]));
while($resmember = mysqli_fetch_array($execmember)){
$resmemberno = $resmember['memberno'];
$visitdoctor = $resmember['consultingdoctor'];
}
$res_doctor_fullname="";
 $query_doctor = "SELECT username from master_consultationlist where visitcode='$res2visitcode' and patientcode='$res2patientcode' order by auto_number asc limit 0,1 ";
$exec_doctor  = mysqli_query($GLOBALS["___mysqli_ston"], $query_doctor) or die ("Error in query_doctor".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_doctor  = mysqli_fetch_array($exec_doctor);
$res_doctor_username = $res_doctor['username'];

if($res_doctor_username!=''){

 $query_doctor_name= "SELECT employeename from master_employee where username='$res_doctor_username'  ";
$exec_doctor_name  = mysqli_query($GLOBALS["___mysqli_ston"], $query_doctor_name) or die ("Error in query_doctor_name".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res_doctor_name  = mysqli_fetch_array($exec_doctor_name)){
 $res_doctor_fullname = $res_doctor_name['employeename'];
}
}

// if patient not in consultaion table , then pick doctor from visit table
if($res_doctor_fullname=='')
  $res_doctor_fullname = $visitdoctor;

/*if($res_doctor_username!=''){

 $query_doctor_name= "SELECT employeename from master_employee where username='$res_doctor_username'  ";
$exec_doctor_name  = mysql_query($query_doctor_name) or die ("Error in query_doctor_name".mysql_error());
while($res_doctor_name  = mysql_fetch_array($exec_doctor_name)){
 $res_doctor_fullname = $res_doctor_name['employeename'];
}
}*/

$credit = $res12transactionamount + $res13transactionamount;



$rescreditnote = 0.00;



$querycreditnote = "select * from ip_creditnote where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and locationcode = '$locationcode'";

$execcredit = mysqli_query($GLOBALS["___mysqli_ston"], $querycreditnote) or die ("Error in querycreditnote".mysqli_error($GLOBALS["___mysqli_ston"]));

while($rescredit = mysqli_fetch_array($execcredit)){

$rescredit1 = $rescredit['totalamount'];

//$rescreditnote += $rescredit1;

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

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res44customerfullname; ?></td>

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

	<td width="148" align="left" valign="center" class="bodytext31"><strong>OP Visit No:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $res2visitcode; ?></td>    

  </tr>
 

  <tr>

  <td width="110" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo nl2br($res15accountname); ?></td>

    <td width="148" align="left" valign="center" class="bodytext31"><strong>Membership No:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $resmemberno; ?></td>


    

  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Insurance Co:</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo nl2br($res2subtype); ?></td>

    <td width="148" align="left" valign="center" class="bodytext31"><strong>A/c No:</strong></td>

    <td width="93" align="right" valign="center" class="bodytext31"><?php echo "$res15accountno";?></td>

  </tr>



  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Doctor :</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res_doctor_fullname ;?></td>


  </tr>

  <tr>

    <td width="110" align="left" valign="center" class="bodytext31"><strong>Pre Auth Code :</strong></td>

    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $preauthcode ;?></td>

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

 <?php $queryicd = "select * from consultation_icd where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' group by primaryicdcode order by auto_number DESC";

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

    <td colspan="6" width="725" align="center"><strong><?php echo 'Summary'; ?></strong></td>

  </tr>



 <tr>

   <td colspan="6" align="left">&nbsp;</td>

   </tr>

  

  

 




<tr>


<td width="148" align="left" valign="center" class="bodytext31"><strong>Consultation Amount:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res4totalamount,2,'.',','); ?></td>

</tr>

<tr>


<td width="148" align="left" valign="center" class="bodytext31"><strong>Pharmacy Amount:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res5amount,2,'.',','); ?></td>

</tr>



<tr>


<td width="148" align="left" valign="center" class="bodytext31"><strong>Lab Amount:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res8labitemrate,2,'.',','); ?></td>

</tr>

<tr>



<td width="148" align="left" valign="center" class="bodytext31"><strong>Radiology Amount:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res9radiologyitemrate,2,'.',','); ?></td>

</tr>

<tr>



<td width="148" align="left" valign="center" class="bodytext31"><strong>Referral Amount:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res10referalrate,2,'.',','); ?></td>

</tr>

<tr>


<td width="148" align="left" valign="center" class="bodytext31"><strong>Service Amount:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($res11servicesitemrate,2,'.',','); ?></td>

</tr>

<?php
 $payoveralltotal=($res4totalamount+$res5amount+$res8labitemrate+$res9radiologyitemrate+$res10referalrate+$res11servicesitemrate); 
?>	

<tr>


<td width="148" align="left" valign="center" class="bodytext31">&nbsp;</td>

<td width="93" align="right" valign="center" class="bodytext31">&nbsp;</td>

</tr>

<tr>


<td width="148" align="left" valign="center" class="bodytext31">&nbsp;</td>

<td width="93" align="right" valign="center" class="bodytext31">&nbsp;</td>

</tr>

<tr>

<td width="148" align="left" valign="center" class="bodytext31"><strong>Cumulative Total:</strong></td>

<td width="93" align="right" valign="center" class="bodytext31"><?php echo number_format($payoveralltotal,2,'.',','); ?></td>

</tr>

</table>


<?php 
include('convert_currency_to_words.php');

$convertedwords = @covert_currency_to_words(number_format($payoveralltotal,2,'.',''));

?>


<table align="center" cellpadding="0" cellspacing="2" width="" border="">
			<tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
		<tr> 
            <td  width="550" class="bodytext31" align="left"><strong><?php echo $currency; ?></strong>
			<?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td> 
			<!-- <td  width="75" class="bodytext31" align="right"><strong>Balance :</strong></td>
			<td  width="90" align="right" class="bodytext31"><strong><?php echo number_format($payoveralltotal,2,'.',','); ?></strong></td> -->
		</tr>
		
         <tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
        
		 <tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
            <td width="" class="bodytext31" align="right">&nbsp;</td>
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

	$html2pdf->Output('print_paylater.pdf');

}

catch(HTML2PDF_exception $e) {

	echo $e;

	exit;

}

?>