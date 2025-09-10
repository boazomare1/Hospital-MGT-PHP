<?php

ob_start();
session_start();
ini_set('max_execution_time', 3000);
ini_set('memory_limit','-1');

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');
$currtime = date('H:i:s');

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d');

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$temp = 0;

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$docno=$_SESSION["docno"];




$pharmacy_fxrate=2872.49;



$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";

	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res = mysqli_fetch_array($exec);

	

 	$locationname = $res["locationname"];

	$locationcode = $res["locationcode"];

//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }



$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where locationcode='$locationcode' and customercode='$patientcode'");

$execlab=mysqli_fetch_array($Querylab);

 $patientage=$execlab['age'];

 $patientgender=$execlab['gender'];



$patienttype=$execlab['maintype'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where locationcode='$locationcode' and auto_number='$patienttype'");

$exectype=mysqli_fetch_array($querytype);

$patienttype1=$exectype['paymenttype'];

$patientsubtype=$execlab['subtype'];

$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where locationcode='$locationcode' and auto_number='$patientsubtype'");

$execsubtype=mysqli_fetch_array($querysubtype);

$patientsubtype1=$execsubtype['subtype'];



$query32 = "select * from ip_discharge where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";

$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$num32 = mysqli_num_rows($exec32);

$res32 = mysqli_fetch_array($exec32);

$dischargedby = $res32['username'];



$query33 = "select * from master_employee where locationcode='$locationcode' and username = '$dischargedby'";

$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res33 = mysqli_fetch_array($exec33);

$employeename = $res33['employeename'];



?>



<?php

function roundTo($number, $to){ 

    return round($number/$to, 0)* $to; 

} 



?>



<?php

		$query2 = "select * from master_location where locationcode = '$locationcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		//$companyname = $res2["companyname"];

		$address1 = $res2["address1"];

		$address2 = $res2["address2"];

//		$area = $res2["area"];

//		$city = $res2["city"];

//		$pincode = $res2["pincode"];

		$emailid1 = $res2["email"];

		$phonenumber1 = $res2["phone"];

		$locationcode = $res2["locationcode"];

//		$phonenumber2 = $res2["phonenumber2"];

//		$tinnumber1 = $res2["tinnumber"];

//		$cstnumber1 = $res2["cstnumber"];

	//	$locationname =  $res2["locationname"];

		$prefix = $res2["prefix"];

		$suffix = $res2["suffix"];

		

?>

<style type="text/css">

/*.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

	font-family:Arial, Helvetica, sans-serif;

}

.underline {text-decoration: underline;}

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}*/

/*.ft0{font: 1px 'Helvetica';line-height: 1px;}
.ft1{font: bold 19px 'Helvetica';line-height: 22px;}
.ft2{font: bold 12px 'Times';line-height: 15px;}
.ft3{font: italic bold 12px 'Times';line-height: 15px;}
.ft4{font: 1px 'Helvetica';line-height: 13px;}
.ft5{font: bold 12px 'Helvetica';line-height: 15px;}
.ft6{font: bold 11px 'Helvetica';line-height: 14px;}
.ft7{font: bold 12px 'Helvetica';line-height: 13px;}
.ft8{font: 1px 'Helvetica';line-height: 12px;}
.ft9{font: bold 12px 'Helvetica';line-height: 12px;}
.ft10{font: 1px 'Helvetica';line-height: 10px;}
.ft11{font: bold 15px 'Times';line-height: 17px;}
.ft12{font: bold 15px 'Helvetica';line-height: 18px;}
*/
.p0{text-align: left;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p1{text-align: left;padding-left: 17px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p2{text-align: right;padding-right: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p3{text-align: right;padding-right: 171px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p4{text-align: left;padding-left: 18px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p5{text-align: left;padding-left: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p6{text-align: right;padding-right: 114px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p7{text-align: right;padding-right: 185px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p8{text-align: right;padding-right: 174px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p9{text-align: right;padding-right: 169px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p10{text-align: left;padding-left: 14px;margin-top: 11px;margin-bottom: 0px;}
.p11{text-align: left;padding-left: 124px;margin-top: 3px;margin-bottom: 0px;}
.p12{text-align: left;padding-left: 146px;margin-top: 3px;margin-bottom: 0px;}
.p13{text-align: left;padding-left: 130px;margin-top: 3px;margin-bottom: 0px;}
.p14{text-align: left;padding-left: 55px;margin-top: 22px;margin-bottom: 0px;}
.p15{text-align: left;padding-left: 45px;margin-top: 3px;margin-bottom: 0px;}
.p16{text-align: left;padding-left: 51px;margin-top: 3px;margin-bottom: 0px;}
.p17{text-align: left;padding-left: 81px;margin-top: 4px;margin-bottom: 0px;}
.p18{text-align: left;padding-left: 29px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p19{text-align: left;padding-left: 54px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
.p20{text-align: left;padding-left: 44px;margin-top: 11px;margin-bottom: 0px;}
.p21{text-align: left;padding-left: 16px;margin-top: 3px;margin-bottom: 0px;}
.p22{text-align: left;padding-left: 191px;margin-top: 0px;margin-bottom: 0px;}
.p23{text-align: left;padding-left: 74px;margin-top: 57px;margin-bottom: 0px;}
.p24{text-align: left;padding-left: 2px;padding-right: 52px;margin-top: 4px;margin-bottom: 0px;}
.p25{text-align: left;padding-left: 99px;margin-top: 0px;margin-bottom: 0px;}
.p26{text-align: left;margin-top: 0px;margin-bottom: 0px;}

.p12a{text-align: left;padding-left: 4px;margin-top: 5px;margin-bottom: 0px;}

.td0{padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td1{padding: 0px;margin: 0px;width: 226px;vertical-align: bottom;}
.td2{padding: 0px;margin: 0px;width: 274px;vertical-align: bottom;}
.td3{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 149px;vertical-align: bottom;}
.td4{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 226px;vertical-align: bottom;}
.td5{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;}
.td6{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 178px;vertical-align: bottom;}
.td7{padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;}
.td8{padding: 0px;margin: 0px;width: 178px;vertical-align: bottom;}
.td9{padding: 0px;margin: 0px;width: 375px;vertical-align: bottom;}
.td10{padding: 0px;margin: 0px;width: 369px;vertical-align: bottom;}
.td11{padding: 0px;margin: 0px;width: 280px;vertical-align: bottom;}
.td12{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 369px;vertical-align: bottom;}
.td13{border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 280px;vertical-align: bottom;}
.td14{padding: 0px;margin: 0px;width: 318px;vertical-align: bottom;}
.td15{padding: 0px;margin: 0px;width: 148px;vertical-align: bottom;}

.tr0{height: 29px;}
.tr1{height: 17px;}
.tr2{height: 18px;}
.tr3{height: 33px;}
.tr4{height: 13px;}
.tr5{height: 26px;}
.tr6{height: 22px;}
.tr7{height: 20px;}
.tr8{height: 12px;}
.tr9{height: 19px;}
.tr10{height: 10px;}
.tr11{height: 23px;}

.t0{width: 649px;font: bold 12px 'Helvetica';}
.t1{width: 649px;margin-top: 18px;font: bold 12px 'Helvetica';}
.t2{width: 466px;margin-left: 73px;margin-top: 38px;font: bold 11px 'Helvetica';}


</style>



<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

 <?php // include('print_header.php'); ?>

    

<!--<page_footer>

  <div class="page_footer" style="width: 100%; text-align: center">

                    <?= $footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; ?>

                </div>

    </page_footer>-->



	

	

 

           <?php

         $query_pat= "SELECT * from master_customer where locationcode='$locationcode' and customercode='$patientcode' ";
		$exec_pat = mysqli_query($GLOBALS["___mysqli_ston"], $query_pat) or die ("Error in Query_pat".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_pat=mysqli_num_rows($exec_pat);
		while($res_pat = mysqli_fetch_array($exec_pat))
		{
				$dob=$res_pat['dateofbirth'];
				$nationalidnumber=$res_pat['nationalidnumber'];
				$area=$res_pat['area'];
				$city=$res_pat['city'];
				$mobilenumber=$res_pat['mobilenumber'];
				$memberno=$res_pat['memberno'];
				$kinname=$res_pat['kinname'];
				$kincontactnumber=$res_pat['kincontactnumber'];
		}

		$query_past_b = "SELECT * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' order by auto_number desc";
		
		$exec_past_b = mysqli_query($GLOBALS["___mysqli_ston"], $query_past_b) or die ("Error in Query_past_b".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_past_b=mysqli_num_rows($exec_past_b);
		if($num_past_b>1){
		$query_past = "SELECT * from
  (select * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' order by auto_number desc limit 2) table_alias
order by auto_number asc limit 1 ";
		$exec_past = mysqli_query($GLOBALS["___mysqli_ston"], $query_past) or die ("Error in Query_past".mysqli_error($GLOBALS["___mysqli_ston"]));
		 $num_past=mysqli_num_rows($exec_past);
		while($res_past = mysqli_fetch_array($exec_past))
		{
			 $pastvisitcode=$res_past['visitcode'];
			 $past_finalbill=$res_past['finalbillno'];

		}
	}
		else{
			$past_finalbill="";
			 $pastvisitcode=$visitcode;
		}


 		$query1 = "SELECT * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc limit 1";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$admissionnotes=$res1['admissionnotes'];
		$consultingdoctorName=$res1['consultingdoctorName'];
		$finalbillno=$res1['finalbillno'];
		$user=$res1['username'];
		$consultationdate=$res1['consultationdate'];
		$consultationtime=$res1['consultationtime'];


		$patientname=$res1['patientfullname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];

		$billtype = $res1['billtype'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		$consultingdoctor = $res1['consultingdoctor'];

		$nhifid = $res1['nhifid'];

		$subtypeanum = $res1['subtype'];

		$type = $res1['type'];

		

		$query13 = "select * from master_subtype where  auto_number = '$subtypeanum'";

		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res13 = mysqli_fetch_array($exec13);

		$subtype = $res13['subtype'];

		$fxrate=$res13['fxrate'];

		$currency=$res13['currency'];

		$bedtemplate=$res13['bedtemplate'];

		$labtemplate=$res13['labtemplate'];

		$radtemplate=$res13['radtemplate'];

		$sertemplate=$res13['sertemplate'];

		$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";

		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtt32 = mysqli_num_rows($exectt32);

		$exectt=mysqli_fetch_array($exectt32);

		$bedtable=$exectt['referencetable'];

		if($bedtable=='')

		{

			$bedtable='master_bed';

		}

		$bedchargetable=$exectt['templatename'];

		if($bedchargetable=='')

		{

			$bedchargetable='master_bedcharge';

		}

		$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";

		$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtl32 = mysqli_num_rows($exectl32);

		$exectl=mysqli_fetch_array($exectl32);		

		$labtable=$exectl['templatename'];

		if($labtable=='')

		{

			$labtable='master_lab';

		}

		

		$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";

		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtt32 = mysqli_num_rows($exectt32);

		$exectt=mysqli_fetch_array($exectt32);		

		$radtable=$exectt['templatename'];

		if($radtable=='')

		{

			$radtable='master_radiology';

		}

		

		$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";

		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$numtt32 = mysqli_num_rows($exectt32);

		$exectt=mysqli_fetch_array($exectt32);

		$sertable=$exectt['templatename'];

		if($sertable=='')

		{

			$sertable='master_services';

		}

		$query813 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$pastvisitcode' and patientcode='$patientcode'";

		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res813 = mysqli_fetch_array($exec813);

		$num813 = mysqli_num_rows($exec813);

		if($num813 > 0)

		{

		$updatedate=$res813['recorddate'];

		$updatedatetime=$res813['recordtime'];

		

		}

		

		$query67 = "select * from master_accountname where auto_number='$accountname'";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 

		$res67 = mysqli_fetch_array($exec67);

		$accname = $res67['accountname'];

	     }

		 

		$query2 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res2 = mysqli_fetch_array($exec2);

		$admissiondate = $res2['recorddate'];

		$wardanum = $res2['ward'];

		$bed = $res2['bed'];

		$admissiontime = $res2['recordtime'];

		

		

		$query12 = "select * from master_ward where locationcode='$locationcode' and auto_number = '$wardanum'";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res12 = mysqli_fetch_array($exec12);

		$wardname = $res12['ward'];

		//No. of days calculation

		$startdate = strtotime($admissiondate);

		$enddate = strtotime($updatedate);

		$nbOfDays = $enddate - $startdate;

		$nbOfDays = ceil($nbOfDays/60/60/24);

		//billno

		$querybill = "select billno, billdate from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billnumbers'";

		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resbill = mysqli_fetch_array($execbill);

		$billno = $resbill['billno'];

		$billdate1 = $resbill['billdate'];

	



		$from_limit_date=$admissiondate;

		$to_limit_date =date('Y-m-d');

		$querybill = "select billdate from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";

		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));

		if($resbill = mysqli_fetch_array($execbill)){

			$to_limit_date = $resbill['billdate'];		

		}



		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";

		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res813 = mysqli_fetch_array($exec813);

		$num813 = mysqli_num_rows($exec813);

		if($num813 > 0)

		{

		//$to_limit_date=$res813['recorddate'];

		}

		

		$queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";

$execicd = mysqli_query($GLOBALS["___mysqli_ston"], $queryicd) or die ("Error in queryicd".mysqli_error($GLOBALS["___mysqli_ston"]));

$resicd = mysqli_fetch_array($execicd);

$primary = $resicd['primarydiag'];

		

		?>
		
		

			  <?php 

			  //include('convert_currency_to_words.php');

			 ?>

            

 <!-- <DIV > -->
 


<!-- <DIV id="id1_1" style=" margin: 20px 30px 20px 60px;"> -->
<TABLE cellpadding=0 cellspacing=0   style=" margin: 20px 30px 0px 60px;">
	<tr>
		<td width="" rowspan="5"  align="center" valign="center"  bgcolor="#ffffff" class="bodytext31"><?php

			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";

			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3showlogo = mysqli_fetch_array($exec3showlogo);

			$showlogo = $res3showlogo['showlogo'];

			if ($showlogo == 'SHOW LOGO')

			{ 

			?>

      <img src="logofiles/1.jpg" width="150" height="80" />

    <?php

			}

			?></td>
	</tr>
<TR>
	 
	<TD class="tr0 td1"><P class="p0 ft0">&nbsp;</P></TD>
	<TD colspan=2 class="tr0 td2"><h4 class="p1 ft1">&nbsp;&nbsp;&nbsp;ADMISSION FORM</h4></TD>
</TR>
<TR>
 
	<TD class="tr1 td1"><P class="p0 ft0">&nbsp;</P></TD>
	<TD colspan=2 class="tr1 td2"><P class="p1 ft2">Admission : <?=$visitcode;?></P></TD>
</TR>
<TR>
	 
	<TD class="tr2 td1"><P class="p0 ft0">&nbsp;</P></TD>
	<TD colspan=2 class="tr2 td2"><P class="p1 ft2">Admitted On : <?php  echo  date("d/m/Y", strtotime($consultationdate));?></P></TD>
	<!-- <TD colspan=2 class="tr2 td2"><P class="p1 ft2">Admitted On : <?php  echo  date("d/m/Y", strtotime($consultationdate))." ".$consultationtime; ?></P></TD> -->
	 
</TR>
<TR>
	 	<TD class="tr2 td1"><P class="p0 ft0">&nbsp;</P></TD>
	<TD colspan=2 class="tr2 td2"><P class="p1 ft2">Current Status : Admitted</P></TD>
</TR>
<!-- <TR>
	<TD class="tr3 td0"><P class="p0 ft0">&nbsp;</P></TD>
	<TD class="tr3 td1"><P class="p0 ft0">&nbsp;</P></TD>
	<TD colspan=2 class="tr3 td2"><P class="p1 ft2">Current Status : <SPAN class="ft3">Admitted</SPAN></P></TD>
</TR> -->
</TABLE>
<div style=" margin: 20px 30px 0px 60px;"><hr></div>
<table width="100%" align="center" border="0" cellspacing="4" cellpadding="0"  class="bodytext3"  style="">

		    <tr><td colspan="4">&nbsp;</td></tr>
		   <tr>
		   	 <td width="110" align="right" valign="center" class="bodytext31"><strong>Reg. No. :</strong></td>
	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
		     <td width="110" align="right" valign="center" class="bodytext31"><strong>DOB :</strong></td> 
		     <td width="160" align="left" valign="center" class="bodytext31"><?php echo $dob;  ?></td>
          </tr>
	       <tr>
              <td width="110" align="right" valign="center" class="bodytext31"><strong>Name :</strong></td> 
		     <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
	         <td width="110" align="right" valign="center" class="bodytext31"><strong>Age/Weight :</strong></td> 
		     <td width="160" align="left" valign="center" class="bodytext31"><?php echo $age; ?></td>
         </tr>

          <tr>
             <td width="130" align="right" valign="center" class="bodytext31"><strong>Accompanied By :</strong></td>
	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo ''; ?></td>
	         <td width="110" align="right" valign="center" class="bodytext31"><strong>Gender :</strong></td>
			 <td width="160" align="left" valign="left" class="bodytext31"><?php echo $gender; ?></td>
         </tr>

        <tr>
			<td width="110" align="right" valign="center" class="bodytext31"><strong>National Id No :</strong></td>
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $nationalidnumber; ?></td>
			<td width="110" align="right" valign="center" class="bodytext31"><strong>Sponsor :</strong></td> 
	        <td width="160" align="left" valign="center" class="bodytext31"><?php echo  $subtype;?></td>
			</tr>		<tr>
            <td width="110" align="right" valign="center" class="bodytext31"><strong>Passport No :</strong></td>
            <td width="250" align="left" valign="center" class="bodytext31"><?php echo ''; ?></td>
            <td width="110" align="right" valign="center" class="bodytext31"><strong>Company Name :</strong></td>
			<td width="160" align="left" valign="center" class="bodytext31"><?php echo $accname;?></td>
		</tr>

		 <tr>
			<td width="110" align="right" valign="center" class="bodytext31"><strong>Address :</strong></td>
             <td width="250" align="left" valign="center" class="bodytext31"><?=$area;?></td>
            <td width="130" align="right" valign="center" class="bodytext31"><strong>NHIF Contributor :</strong></td>
			<td width="160" align="left" valign="left" class="bodytext31"><?php if($nhifid==""){ echo 'No'; }else{ echo 'Yes' ;} ?></td>
        </tr>


         <tr> 
			<td width="110" align="right" valign="center" class="bodytext31"><strong>City :</strong></td>
			<td width="250" align="left" valign="center" class="bodytext31"><?=$city;?></td>
			<td width="110" align="right" valign="center" class="bodytext31"><strong>NHIF No :</strong></td>
			<td width="160" align="left" valign="left" class="bodytext31"><?php echo $nhifid; ?></td>
          </tr>

		<tr>
            <td width="110" align="right" valign="center" class="bodytext31"><strong>Residence :</strong></td>
            <td width="250" align="left" valign="center" class="bodytext31"><?=$area;?></td>
			<td width="110" align="right" valign="center" class="bodytext31"><strong>Next Of Kin :</strong></td>
			<td width="160" align="left" valign="center" class="bodytext31"><?php echo $kinname; ?></td>
		</tr>
		 <tr>
            <td width="110" align="right" valign="center" class="bodytext31"><strong>Contact No :</strong></td>
            <td width="250" align="left" valign="center" class="bodytext31"><?=$mobilenumber;?></td>
			<td width="110" align="right" valign="center" class="bodytext31"><strong>Next Of Kin Tel# :</strong></td>
			<td width="160" align="left" valign="center" class="bodytext31"><?php echo $kincontactnumber; ?></td>

		</tr>

		</table>

<!-- <div style=" margin: 20px 30px 0px 60px;"></div> -->


<div style=" margin: 0px 30px 0px 60px;">
	<hr></div>
<table width="100%" align="left" border="0"    style=" margin: 10px 30px 0px 60px;">
		     
		   	 <tr>
		            <td align="right" valign="left" class="bodytext31">Person Responsible For The Bill :</td>
		            <td  align="left" valign="center" class="bodytext31"> </td>
					<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
					<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
			<tr>
			            <td align="right" valign="left" class="bodytext31">Relationship :</td>
			            <td  align="left" valign="center" class="bodytext31"> </td>
						<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
						<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
			<tr>
			            <td align="right" valign="left" class="bodytext31">Address :</td>
			            <td  align="left" valign="center" class="bodytext31"> </td>
						<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
						<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
			<tr>
			            <td align="right" valign="left" class="bodytext31">Contact No :</td>
			            <td  align="left" valign="center" class="bodytext31"></td>
						<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
						<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
</table>

<div style=" margin: 0px 30px 0px 60px;">
	<hr></div>
<table width="100%" align="left" border="0"    style=" margin: 10px 30px 0px 160px;">
		     
		   	 <tr>
		            <td align="right" valign="left" class="bodytext31">Readmission :</td>
		            <td  align="left" valign="center" class="bodytext31"><?php if($past_finalbill==""){ echo 'No';}else{ echo 'Yes';} ?></td>
					<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
					<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
			<tr>
			            <td align="right" valign="left" class="bodytext31">Last Discharge :</td>
			            <td  align="left" valign="center" class="bodytext31"><?php if($past_finalbill!=""){ echo date("d/m/Y", strtotime($updatedate))." ".$updatedatetime; } ?></td>
						<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
						<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
			<tr>
			            <td align="right" valign="left" class="bodytext31">Last Invoice :</td>
			            <td  align="left" valign="center" class="bodytext31"><?php echo $past_finalbill; ?></td>
						<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
						<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
			<tr>
			            <td align="right" valign="left" class="bodytext31">Balance :</td>
			            <td  align="left" valign="center" class="bodytext31"></td>
						<td  align="left" valign="center" class="bodytext31"><strong>&nbsp;</strong></td>
						<td  align="left" valign="center" class="bodytext31">&nbsp;</td>

			</tr>
</table>
<!-- <div style=" margin: 20px 30px 0px 60px;">
<P class="p10 ft5">Person Responsible For The Bill:</P>
<P class="p11 ft5">Relationship:</P>
<P class="p12 ft5">Address: </P>
<P class="p13 ft5">Contact No:</P>

<hr>
<P class="p14 ft5">Readmission&nbsp;&nbsp;&nbsp;: <?php if($past_finalbill==""){ echo 'No';}else{ echo 'Yes';} ?></P>
<P class="p15 ft5">Last Discharge&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php if($past_finalbill!=""){ echo date("d/m/Y", strtotime($updatedate))." ".$updatedatetime; } ?></P>
<P class="p16 ft5">Last Invoice&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $past_finalbill; ?></P>
<P class="p17 ft5">Balance&nbsp;&nbsp;&nbsp;&nbsp;:</P>


</div> -->
<div style=" margin: 10px 30px 0px 60px;"><hr></div>
<TABLE cellpadding=0 cellspacing=0 class="t1" style=" margin: 20px 30px 0px 60px;">
	<TR>
		<TD class="tr11 td10"><P class="p18 ft5">Consulting Doctor :&nbsp;&nbsp;<?=$consultingdoctorName;?></P></TD>
		<TD class="tr11 td11"><P class="p0 ft5">Member No :&nbsp;&nbsp; <?=$memberno;?><SPAN class="ft11"></SPAN></P></TD>
	</TR>
	<TR>
		<TD class="tr1 td10"><P class="p19 ft5">Holder Name&nbsp;&nbsp;: </P></TD>
		<TD class="tr1 td11"><P class="p0 ft0">&nbsp;</P></TD>
	</TR>
</TABLE>
<div style=" margin: 20px 30px 0px 60px;">
	<hr>
<P  style="text-align: justify;">Admission officer`s Comments  : </P>
  <P class="p21 "><?=$admissionnotes;?></P>
<!-- <P class="p21 ">'PATIENT TO BE ADMITTED IN NOOR UNDER KENYA POLICE AND PRISONS</P>
<P class="p22 ">SCHEME-2500'</P> -->
<hr>
<P >Important:</P>
<P class="p21 " style="text-align: justify;">I undertake to pay at any time on demand all fees and expenses over and above the undertaking of the medical scheme which may from time to time become payable to the hospital by or on behalf of the patient during his/her hospital stay.</P>
</div>
<div style=" margin: 10px 30px 0px 60px;"><hr></div>
<TABLE cellpadding=0 cellspacing=0  style=" margin: 20px 30px 0px 60px;">
<TR>
	<TD class="tr2 "><P class="p0 ">&nbsp;</P></TD>
	<TD class="tr2 td14"><P class="p0 ">Signature:</P></TD>
	<TD class="tr2 "><P class="p0 ">Created by: <?=ucwords($user);?></P></TD>
</TR>
<TR>
	<TD class="tr2 "><P class="p0 ">&nbsp;</P></TD>
	<TD class="tr2 td14"><P class="p0 ">Date: <?=$currentdate; ?></P></TD>
	<TD class="tr2 td15"><P class="p0 ">&nbsp;</P></TD>
</TR>
</TABLE>

<!-- </DIV> -->

<!-- ////////////////////////// SECOND PAGE //////////////////////////// -->
 

<div style='page-break-before: always;'></div> <br>
<br>
<?php  include('print_header_pdf.php'); ?>
<div style="margin: 20px 30px 20px 60px;">
	 <hr>
<h4 align="center">CONSENT FOR TREATMENT</h4>

<p style="text-align: justify; width: 80%; line-height: 1.6;">
	I <b><?php if($gender=='Female'){ echo 'Mrs.'; }else{ echo 'Mr.'; } ?> <?=$patientname; ?></b> 
	hereby request & consent to care & medical treatment from the hospital for medical care
deemed necessary or advisable including administration of drugs, examinations, diagnostic & therapeutic treatments.</p>

<p style="text-align: justify; width: 80%; line-height: 1.6;">I know that the hospital will exercise ethical & competent professional judgment in providing the necessary treatment &
am also aware that no guarantees have been made as to the outcome of the treatment.I also know that I have a right to
refuse treatment & be informed of the consequence of such refusal.I am also aware that the hospital reserves the right to
decide on the appropriate form(s) of treatment.</p>

<p style="text-align: justify; width: 80%; line-height: 1.6;">
I also consent that the hospital will process the transfer of patient to an appropriate location as per the professional
judgment of the medical staff responsible for the patient.</p>

<p style="text-align: justify; width: 80%; line-height: 1.6;">I have read this consent for treatment or explained to me & have understood its contents.</p>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table>
	<tr>
		<td>
			<table>
				<tr><td><hr></td></tr>
				<tr><td>Signature of Consenting Person</td></tr>
				<tr><td>(Patient/Guardian)</td></tr>
				<tr><td>Name: <?php if($gender=='Female'){ echo 'Mrs. '; }else{ echo 'Mr. '; } ?> <?=$patientname; ?>   </td></tr>
				<tr><td>Reg. No.: <?=$patientcode; ?></td></tr>
				<tr><td>Date: <?=$currentdate; ?></td></tr>
			</table>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		 
		<td>
			<table>
				<tr><td><hr></td></tr>
				<tr><td>Signature of Hospital Staff</td></tr>
				<tr><td>&nbsp; </td></tr>
				<tr><td>Name of Authorized Staff :  <?=ucwords($username); ?>   </td></tr>
				<tr><td> &nbsp;&nbsp;</td></tr>
				<tr><td>Date: <?=$currentdate; ?></td></tr>
			</table>
		</td>
	</tr>
</table>

</div>
<!-- ////////////////////////// THIRD PAGE //////////////////////////// -->

<div style='page-break-before: always;'></div><br><br><br><br><br><br><br><br>
<!-- <div style="page-break-before: always; width: 100%; height: 500px;"></div> -->
<?php  include('print_header_pdf.php'); ?>

 <div style="margin: 0px 30px 0px 60px;"> <hr></div>
<h4 align="center">PAYMENT GUARANTEE FORM</h4>
<div style="margin: 0px 30px 0px 60px;"> 

	<table width="100%" align="center" border="0" cellspacing="4" cellpadding="0">
		<tr>

  <td colspan="10">&nbsp;</td></tr>

		   <tr>
             <td width="170" align="left" valign="center" class="bodytext31"><strong>Name Of Patient:</strong></td> 
		     <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
		     <td width="110" align="left" valign="center" class="bodytext31"><strong>Reg. No.:</strong></td>
	         <td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
          </tr>
		</table>
	</div>
	<div style="margin: 0px 30px 0px 60px;"> 
		<p style="text-align: justify; width: 80%; line-height: 1.6;">I 0 of P.O Box ID NO  ________________________ Employer/Business name __________________</p>
		<!-- <br> -->
		<p style="text-align: justify; width: 80%; ">Occupation/Position:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Town:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      Mobile no:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     Residential address: </p>
		<h4><b>I confirm that:</b></h4>
		<p  style="text-align: justify;  line-height: 120%;">
			
1. I have been informed that the Admission deposit for Ward: NOOR PAVILLION is KES _______________and <br>
I have made a payment of KES.____________________ towards a Deposit for Admission and undertake to top<br> up the balance of KES ________________________not later than Date______________Time __________.<br><br>
2. I shall pay Premier Hospital the full cost of treatment, accommodation and any other services provided to the<br>
above-named patient.<br><br>
3. The hospital will issue me with interim bill every 24hours..<br><br>
4. Amounts due are payable on demand and progressively during the stay in the hospital<br><br>
5. I shall pay any outstanding bills for the above named patient before discharge.<br><br>
		</p>
</div>

<div style="border: 1px solid black; margin: 0px 30px 0px 60px; padding: 10px;">
<P class="p12a ft0" ><b>Declaration</b></P>
<P  style="text-align: justify;">I hereby declare that the details furnished above are true and correct to the best of my knowledge. In case any of the above information is found to be false, untrue, misleading or misrepresenting, I am aware that I will be held liable.</P>
<P class="p12a ft0">Signature of Guarantor :____________________</P>
<P class="p12a ft0">Relationship to Patient: ____________________</P>
</div>

<div style="border: 1px solid black; margin: 30px 30px 10px 60px; padding: 10px;">
	<P  class="p12a ft0">Prepared By____________________ Designation________________________</P>
	<P class="p12a ft0">Date: <?=$currentdate; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       Time : <?=$currtime; ?> Sign: ________________________________</P>
</div>

<div style="border: 1px solid black; margin: 10px 30px 10px 60px; padding: 10px;">
	<P  class="p12a ft0">Authorized By____________________ Designation________________________</P>
	<P class="p12a ft0">Date: <?=$currentdate; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     Time : <?=$currtime; ?> Sign: ________________________________</P>
</div>
<p style=" margin: 0px 30px 0px 60px; ">NB: Attach ID copy or Passport of both the guarantor and the Patient.</p>

</page>

<?php	

/*require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4");

$dompdf->render();

$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("Arial", "normal");

$canvas->page_text(544, 1628,"1/21", $font, 10, array(0,0,0));

$canvas->page_text(272, 814," Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("FinalBill.pdf", array("Attachment" => 0)); */

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

        $html2pdf->Output('print_ip_final.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>

