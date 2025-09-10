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

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d H:i:s');

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

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

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

	

}

</style>



<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">

 <?php  include('print_header_pdf.php'); ?>

    

<!--<page_footer>

  <div class="page_footer" style="width: 100%; text-align: center">

                    <?= $footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; ?>

                </div>

    </page_footer>-->


 
 

           <?php

 		$query1 = "select * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

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

		$query813 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

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

		    

		   <?php // date("d/m/Y", strtotime($billdate1)); ?> 

    


			  <?php 

			  //include('convert_currency_to_words.php');

			 ?>
			
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

