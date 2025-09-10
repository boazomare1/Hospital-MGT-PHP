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
$currentdate = date('Y-m-d');
$docno=$_SESSION["docno"];


$pharmacy_fxrate=2872.49;

$query = "select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	
 	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
$reqdate="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>

<?php
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>
 
<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; 
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 40px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.underline{text-decoration: underline;}

body {
	margin:0 auto; 
	width:100%;
	background-color: #FFFFFF;
	font-family:Arial, Helvetica, sans-serif;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }
.page_footer
{
	font-family: Times;
	text-align:center;
	font-weight:bold;
	margin-bottom:25px;
	
}

</style>
<page pagegroup="new" backtop="2mm" backbottom="15mm" backleft="2mm" backright="3mm" >
	<page_footer>
                <div class="page_footer" style="width: 100%; text-align: center">
                    <?php //echo $footer="Blood is FREE for all @ Nakasero Hospital. Sale of blood is illegal. Should you ever be asked to pay for blood at this facility please report IMMEDIATELY to info@nhl.co.ug"; ?>
                </div>
    </page_footer>


<?php 
/*$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];*/
$query2 = "select address1, address2, email, phone, locationcode, locationname, prefix, suffix from master_location where locationcode = '$locationcode'";
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
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
include('print_header_pdf3.php');
?>
           <?php

		$querymenu = "select dateofbirth from master_customer where customercode='$patientcode'";
		$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resmenu = mysqli_fetch_array($execmenu);
		$dateofbirth=$resmenu['dateofbirth'];

		function format_interval(DateInterval $interval) {
			$result = "0";
			if ($interval->y) { $result = $interval->format("%y"); }
			return $result;
		}
		function format_interval_dob(DateInterval $interval) {
			$result = "";
			if ($interval->y) { $result .= $interval->format("%y Years "); }
			if ($interval->m) { $result .= $interval->format("%m Months "); }
			if ($interval->d) { $result .= $interval->format("%d Days "); }

			return $result;
		}

 		$query1 = "select patientfullname, patientcode, accountname,billtype,consultationdate, gender, age, consultingdoctor, nhifid, subtype, type from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
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
        $consultationdate=$res1['consultationdate'];
		if($dateofbirth>'0000-00-00'){
		$today = new DateTime($consultationdate);
		$diff = $today->diff(new DateTime($dateofbirth));
		$age = format_interval_dob($diff);
		}else{
		  $age = '<font color="red">DOB Not Found.</font>';
		}
		
		$query13 = "select currency,subtype, fxrate,bedtemplate,labtemplate,radtemplate,sertemplate,ippactemplate from master_subtype where auto_number = '$subtypeanum'";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13 = mysqli_fetch_array($exec13);
		$subtype = $res13['subtype'];
		$currency=$res13['currency'];
		$fxrate=$res13['fxrate'];
		$bedtemplate=$res13['bedtemplate'];
		$labtemplate=$res13['labtemplate'];
		$radtemplate=$res13['radtemplate'];
		$sertemplate=$res13['sertemplate'];
		$ippactemplate=$res13['ippactemplate'];
		
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
		
		$querytt32 = "select * from master_testtemplate where templatename='$ippactemplate'";
        $exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
        $numtt32 = mysqli_num_rows($exectt32);
        $exectt=mysqli_fetch_array($exectt32);
        $ippactemplate=$exectt['templatename'];
        if($ippactemplate=='')
        {
        	$ippactemplate='master_ippackage';
        }
		
		
		
		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
		
		$query67 = "select accountname from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
	     }
		 
		 $query677 = "select mrdno from master_customer where customercode='$patientcode'"; 
		$exec677 = mysqli_query($GLOBALS["___mysqli_ston"], $query677); 
		$res677 = mysqli_fetch_array($exec677);
		$mrdno = $res677['mrdno'];
		
		 $query622 = "select primarydiag from consultation_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'"  ; 
		$exec622 = mysqli_query($GLOBALS["___mysqli_ston"], $query622); 
		$res622 = mysqli_fetch_array($exec622);
		$diagnostic = $res622['primarydiag'];
		
		 $query453 = "select disease from consultation_icd1 where  patientcode='$patientcode' and patientvisitcode='$visitcode'" ; 
		$exec453 = mysqli_query($GLOBALS["___mysqli_ston"], $query453); 
		$res453 = mysqli_fetch_array($exec453);
		$diagnostic1 = $res453['disease'];
		 
		$query2 = "select recorddate, ward, bed, recordtime from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
		$wardanum = $res2['ward'];
		$bed = $res2['bed'];
		$admissiontime = $res2['recordtime'];
		
		 $query511 = "select bed from `$bedtable` where auto_number='$bed'";
		 $exec511 = mysqli_query($GLOBALS["___mysqli_ston"], $query511) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $res511 = mysqli_fetch_array($exec511);
		 $bedname1 = $res511['bed'];
		
		$query12 = "select ward from master_ward where auto_number = '$wardanum'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res12 = mysqli_fetch_array($exec12);
		$wardname = $res12['ward'];
		//No. of days calculation
		$startdate = strtotime($admissiondate);
		$enddate = strtotime($currentdate);
		$nbOfDays = $enddate - $startdate;
		$nbOfDays = ceil($nbOfDays/60/60/24);
		//billno
		$querybill = "select billno from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode'"; 
		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resbill = mysqli_fetch_array($execbill);
		$billno = $resbill['billno'];

		$from_limit_date=$admissiondate;
		$to_limit_date =date('Y-m-d');
		$querybill = "select billdate from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($resbill = mysqli_fetch_array($execbill)){
			$to_limit_date = $resbill['billdate'];		
		}
		$querybill = "select billdate from billing_ipcreditapproved where patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($resbill = mysqli_fetch_array($execbill)){
			$to_limit_date = $resbill['billdate'];		
		}

		$query813 = "select recorddate,recordtime from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$to_limit_date=$res813['recorddate'];
		$dis_date=date("d/m/Y", strtotime($res813['recorddate']));
		$updatedatetime=$res813['recordtime'];
		$dis_datetime=$res813['recordtime'];
		}else{
		$dis_date='';
		$dis_datetime='';
		}
       $to_limit_date =date('Y-m-d');
		
		?>
        <table width="675" align="center" border="0" cellspacing="1" cellpadding="2">
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31">&nbsp;</td> 
			<td width="233" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td> 
			<td width="118" align="left" valign="center" class="bodytext31">&nbsp;</td>
		</tr>
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Name:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Bill Date:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($currentdate)); ?></td>
		</tr>
        
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Reg. No.:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
            
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Age.:</strong></td> 
		    <td width="118" align="left" valign="center" class="bodytext31"><?php echo $age; ?></td>
			
		</tr>
		<tr>
		    <td width="169" align="left" valign="center" class="bodytext31"><strong>Bill Type:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
		    <td width="134" align="left" valign="center" class="bodytext31"><strong>IP Visit No.:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
		</tr>
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Admission Date:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($admissiondate))." ".$admissiontime; ?></td>
		</tr>
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Covered By:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $subtype; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Discharge Date</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $dis_date." ".$dis_datetime; ?></td>
		</tr>
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Membership No:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $mrdno; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>No of Days:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $nbOfDays; ?></td>
		</tr>
		<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Type</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $type; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Bed No:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $bed; ?></td>
		</tr>
		
		<!--<tr>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Diagnostic Code 2:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $diagnostic1; ?></td>
			<td width="169" align="left" valign="center" class="bodytext31"><strong>Diagnostic Code 1:</strong></td> 
			<td width="233" align="left" valign="center" class="bodytext31"><?php echo $diagnostic; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td> 
			<td width="118" align="left" valign="center" class="bodytext31">&nbsp;</td>
		</tr>-->
		<tr>
			<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>
			<td width="233" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="118" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
		</tr>
		<tr>
			<td width="169" align="left"  valign="center" class="bodytext31">&nbsp;</td>
			<td width="233" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="118" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
		</tr>
	</table>
	
		<table width="667" align="center" border="0" cellspacing="4" cellpadding="0">
			<tr>
			 	<td colspan="7">&nbsp;</td>
			</tr>
		
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="74"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
				<td width="80"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
				<td width="242"  align="left" valign="center" style="white-space:normal"
				bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
				<td width="49"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
				<td width="70"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Rate  </strong></td>
				<td width="94"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Amount </strong></td>
			</tr>
				  		<?php
						
	
						
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$query17 = "select admissionfees, package, visitcode, consultationdate, packchargeapply from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$packageanum1 = $res17['package'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			
			
			$query53 = "select docno from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
		{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			//$totalop=$consultationfee/$fxrate;
			$totalop=$consultationfee;
			?>
			  <tr>
			 <td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			    <td width="74" class="bodytext31" valign="center"  align="left"><?php echo $consultationdate; ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $viscode; ?></td>
			 <td width="242" class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
			     <td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
                <td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				
           	</tr>
			<?php
			}
			}
			else
			{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			//$totalop=$consultationfee/$fxrate;
			$totalop=$consultationfee;
			?>
			  <tr>
			 <td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			    <td width="74" class="bodytext31" valign="center"  align="left"><?php echo date("d/m/y", strtotime($consultationdate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $viscode; ?></td>
			 <td width="242" class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
			     <td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
                <td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				
           	</tr>
			<?php
			}
			?>
			<?php

					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			$doctorType = $res731['doctorType'];
			$consultationdate=$res731['consultationdate'];
			if($dateofbirth>'0000-00-00'){
			  $today = new DateTime($consultationdate);
			  $diff = $today->diff(new DateTime($dateofbirth));
			  $ipage = format_interval($diff);
			}else{
			  $ipage = $res731['age'];
			}
			
			$query741 = "select packagename, days from $ippactemplate where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
			  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			  ?>
		<tr>
			<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($packagedate1)); ?></td>
			<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>
			<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $packagename; ?></td>
			<td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
			<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
		</tr>
			  <?php
			  }
			  ?>
			<?php 
			
			  	$totalbedallocationamount=0;
				$discount_bed = 0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];		

					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}
					
					$queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number = '$ward'");	
					$resw = mysqli_fetch_array($queryward);
					$wdesc = $resw['description'];
					
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$leavingdate_org = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity_bedt =$quantity1 =  $interval->format("%a");
					$pack_days=$packdays1;//added by krishna
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity_bedt;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);
					$tmp=array();
					$tmpbed=array();
					$tmpbedcharge=array();
					while($res91 = mysqli_fetch_array($exec91))
					{
                       $tmp[]=$res91;
					}
										
					if(is_array($tmp)){
						foreach($tmp as $k =>$v){
						   if($v[0]=='Accommodation Only'){
                              $tmpbed[0]=$v[0];
							  $tmpbed['charge']=$v[0];
						      $tmpbed[1]=$v[1];
							  $tmpbed['rate']=$v[1];
                              unset($tmp[$k]);
						   }
						}

						if(is_array($tmpbed) and count($tmpbed)>0){
                           
						   foreach($tmp as $k =>$v){
                              if($v[0]=='Bed Charges'){
                                 $tmpbedcharge[]=$v;
								 $tmpbedcharge[]=$tmpbed;
							  }else
								  $tmpbedcharge[]=$v;

						   }
						   unset($tmp);
						   $tmp=$tmpbedcharge;
						}
					}
					
					foreach($tmp as $rslt)
					{
						$charge = $rslt['charge'];
						$rate = $rslt['rate'];	
                        
						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;

						if($ipage >7 && $charge=='Accommodation Only' )
						  continue;
						
						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/* if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else { */
								$quantity=$quantity1;
								//} 
							}
						}
						else
						{
							$rate = $rate-$discount_bed-$ward_discount;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/* if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else { */
								$quantity=$quantity1;
								//} 
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($quantity>0 && $amount>0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								$colorloopcount = $sno + 1;
								if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Non Pharms';
									}
									else{
										$charge1 = $charge;
									}
								$showcolor = ($colorloopcount & 1); 
								if ($showcolor == 0)
								{
									//echo "if";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								else
								{
									//echo "else";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								if($quantity!=0){
								$totalbedallocationamount=$totalbedallocationamount+($quantity*($rate));
									$bedallocateddate1 = date('Y-m-d',strtotime($bedallocateddate) + (24*3600*$pack_days));//added by krishna	
					  ?>
								<tr <?php echo $colorcode; ?>>
									<td width="49" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
									<td width="74" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("d/m/y", strtotime($bedallocateddate1)); ?></div></td>
									<td width="80" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $wdesc; ?></div></td>
									<td width="242" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge1; ?>(<?php echo $bedname; ?>)</div></td>
									<td width="49" class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
									<input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
									<input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
									<input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
									<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
									<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
									<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
									<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
									<td width="70" class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
									<td width="94" class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
								</tr>              
					 
					   <?php 	} // if quantity !=0 loop
							}
						}
					}
				}
				$totalbedtransferamount=0;
				$discount_bed =0 ;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];		

					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}

					
					$queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number = '$ward'");	
					$resw = mysqli_fetch_array($queryward);
					$wdesc = $resw['description'];
						
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$leavingdate_org = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($date);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$bedcharge='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);
					while($res91 = mysqli_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	

						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;
						 
						if($ipage > 7 && $charge=='Accommodation Only' ) {
						  continue;
						  }
						

						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/* if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else { */
								$quantity=$quantity1;
								//} 
							}
						}
						else
						{
							$rate = $rate-$discount_bed-$ward_discount;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								/* if($leavingdate_org=='0000-00-00')
								{ 
								$quantity=$quantity1+1;
								 } else { */
								$quantity=$quantity1;
								//} 
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($bedcharge=='0')
						{
							if($quantity> 0&& $amount>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
									if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Non Pharms';
									}
									else{
										$charge1 = $charge;
									}
									$showcolor = ($colorloopcount & 1); 
									if ($showcolor == 0)
									{
										//echo "if";
										$colorcode = 'bgcolor="#FFFFFF"';
									}
									else
									{
										//echo "else";
										$colorcode = 'bgcolor="#FFFFFF"';
									}
									if($quantity!=0){
									$totalbedtransferamount=$totalbedtransferamount+($quantity*($rate));
						  ?>
									<tr <?php echo $colorcode; ?>>
										<td width="49" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
										<td width="74" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("d/m/y", strtotime($date)); ?></div></td>
										<td width="80" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $wdesc; ?></div></td>
										<td width="242" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge1; ?>(<?php echo $bedname; ?>)</div></td>
										<td width="49" class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
										<input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
										<input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
										<input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
										<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
										<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
										<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
										<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
										<td width="70" class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
										<td width="94" class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
									</tr>              
						 
						   <?php 	} // if quantity !=0 loop
								}
							}
							else
							{								
								if($charge=='Bed Charges')
								{
									//$bedcharge='1';
								}
							}
						}
					}
				}
			  ?>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
			<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($totalop+$packageamount+$totalbedallocationamount+$totalbedtransferamount,2,'.',','); ?></strong></td>
			</tr>
			  
			 
			   <?php 

			$totalpharm=0;
		    $totallab=0;
			$totalrad=0;
			$totalser=0;
while (strtotime($from_limit_date) <= strtotime($to_limit_date)) {
				echo "<tr><td colspan='7' style='background-color:#ccc'><strong>".date('d M Y',strtotime($from_limit_date))."</strong></td></tr>";


			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}
			

				$data_count=0;

			$pharmacyquantity='';
			$s='';
			$returneditemcode='';
			$retno='';
			$totalreturnamount='';

			//$totalpharm=0;
			$pharmadayamount=0;
			 $titleName ='';
			$storequery ="select p.store as storecode,s.storelable as storelable from pharmacysales_details as p left join master_store as s on p.store=s.storecode where p.locationcode='$locationcode' and p.visitcode='$visitcode' and p.patientcode='$patientcode' and p.freestatus = 'No' GROUP BY p.store order by s.storelable";
            $cateTotal = 0 ;
			$storetotal = 0 ;
			$execStore = mysqli_query($GLOBALS["___mysqli_ston"], $storequery) or die ("Error in storequery".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($resStore = mysqli_fetch_array($execStore))
			{

			$query23 = "select entrydate, itemname, itemcode, rate, ipdocno, quantity, freestatus from pharmacysales_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' and entrydate='$from_limit_date' and store='".$resStore['storecode']."'  GROUP BY ipdocno,itemcode";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pharmacy = mysqli_num_rows($exec23);
			if($num_pharmacy>0 ){
				if($titleName!=$resStore['storelable']) {
				
				$titleName = $resStore['storelable'];
				if($resStore['storelable']=='ward')
					$catestoreName ='Ward Items';
				else
                   $catestoreName = ucfirst($resStore['storelable']);

                 if($cateTotal>0){
				 echo "<tr><td colspan='7' align='right'><strong>Total</strong></td><td align='right'><strong>".number_format($cateTotal,2,'.',',')."</strong></td></tr>";
				 $cateTotal = 0 ;
				 }
                 
				 echo "<tr><td colspan='3'></td><td colspan='4' align='left'><strong>".$catestoreName."</strong></td></tr>"; 
				 $storetotal = 1 ;
				}
				
				
			}

			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$refno = $res23['ipdocno'];
			$quantity=$res23['quantity'];
			$pharmfree = $res23['freestatus'];
			$amount=$pharate*$quantity;
			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
   			$quantity=$phaquantity;
			$amount=$pharate*$quantity;
			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res331 = mysqli_fetch_array($exec331);
			
			$quantity1=$res331['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			
			$resquantity = $quantity - $quantity1;
			$resamount = $amount - $amount1;
			$resamount=number_format(($resamount/$fxrate),2,'.','');

			//$cateTotal = $cateTotal +$resamount;
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
			{
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if($resquantity!=0){
			$totalpharm=$totalpharm+$resamount;
			$pharmadayamount=$pharmadayamount+$resamount;
			$data_count++;
			?>
		<tr>
			<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date('d/m/y', strtotime($phadate)); ?></td>
			 <td width="80" class="bodytext31" valign="center"  align="left"><?php echo $phaitemcode; ?></td>
			 <td width="242" class="bodytext31" valign="center"  align="left"><?php echo $phaname; ?></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td width="49" class="bodytext31" valign="center"  align="right"><?php echo $resquantity; ?></td>
             <td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format(($pharate/$fxrate),2,'.',','); ?></td>
			 <td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($resamount,2,'.',','); ?></td>
		     
		</tr>	
			
			  
			  <?php } } // if quantity !=0 loop
			  }
			  }
			}
			if($pharmadayamount>0){
            ?>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
			<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($pharmadayamount,2,'.',','); ?></strong></td>
			</tr>
			
			
			  <?php 
			}

	$fxrate = $original_fxrate;
			$laddayamount=0;
			//  $totallab=0;
			  $query19 = "select consultationdate,labitemname,labitemcode,labitemrate,iptestdocno,freestatus from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'  and freestatus = 'No' and consultationdate='$from_limit_date' ";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_lab = mysqli_num_rows($exec19);
			if($num_lab>0){
			echo "<tr><td colspan='7'><strong>LAB</strong></td></tr>";
			}
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if(strtoupper($labfree) == 'NO')
			{
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resl51 = mysqli_fetch_array($execl51);
			$labrate = $resl51['rateperunit'];
			
			$totallab=$totallab+$labrate;
			$laddayamount=$laddayamount+$labrate;
			$data_count++;
			?>
		<tr>
			<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($labdate)); ?></td>
			<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $labcode; ?></td>
			<input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			<input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			<input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $labname; ?></td>
			<td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
			<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  }
			  }
			  if($laddayamount>0){
			  ?>
			  <tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($laddayamount,2,'.',','); ?></strong></td>
				</tr>
			  
			    <?php
			  }
				$raddayamount=0;
			//	$totalrad=0;
			  $query20 = "select consultationdate,radiologyitemname,radiologyitemrate,iptestdocno,freestatus,radiologyitemcode from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'  and freestatus = 'No' and consultationdate='$from_limit_date' ";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_radio = mysqli_num_rows($exec20);						
			if($num_radio>0){
			echo "<tr><td colspan='7'><strong>RADIOLOGY</strong></td></tr>";   
			}
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			$radiologyitemcode = $res20['radiologyitemcode'];
			if(strtoupper($radiologyfree) == 'NO')
			{
			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resr51 = mysqli_fetch_array($execr51);
			$radrate = $resr51['rateperunit'];
		
			
			$totalrad=$totalrad+$radrate;
			$raddayamount=$raddayamount+$radrate;
			$data_count++;
			?>
		<tr>
			<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($raddate)); ?></td>
			<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $radiologyitemcode; ?></td>
			<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $radname; ?></td>
			
			<input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			<input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			<td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
			<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  }
			  }
			  if($raddayamount>0){
			  ?>
			  
			  <tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($raddayamount,2,'.',','); ?></strong></td>
				</tr>
			  	    <?php 
			  }
				$serdayamount=0;	
					//$totalser=0;
		    $query21 = "select doctorname,consultationdate,servicesitemname,servicesitemrate,iptestdocno,freestatus,servicesitemcode from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and freestatus = 'No' and wellnessitem <> '1' and consultationdate='$from_limit_date'  group by servicesitemcode, iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_service = mysqli_num_rows($exec21);
			if($num_service>0){
			echo "<tr><td colspan='7'><strong>SERVICE</strong></td></tr>";
			}
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesdoctorname = $res21['doctorname'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			 $serqty=$resqty['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			if(strtoupper($servicesfree) == 'NO')
			{
			 $totserrate=$resqty['amount'];
			  if($serqty!=0){
			  $totalser=$totalser+$totserrate;
			  $serdayamount=$serdayamount+$totserrate;
			$data_count++;
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($serdate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $sercode; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $sername." - ".$servicesdoctorname; ?></td>
				<input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
				<input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo $serqty; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($serrate,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($totserrate,2,'.',','); ?></td>
			</tr>	
			  
			  <?php } } // if quantity !=0 loop
			  }
			if($data_count==0){
				echo "<tr ><td colspan='7'>No data found on this day.</td></tr>";				
			}

			                  $from_limit_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_limit_date)));
			if($serdayamount>0){	
?>			
				<tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($serdayamount,2,'.',','); ?></strong></td>
				</tr>
			  
			<?php
			 }			  
							  
			 } // date close
			 
			  $otdayamount=0;
			$totalotbillingamount = 0;
			$query61 = "select consultationdate,docno,surgeryname,rate from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_service = mysqli_num_rows($exec61);
			if($num_service>0){
			echo "<tr><td colspan='7'><strong>OT Surgery</strong></td></tr>";
			}
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			$otbillingrate = 1*($otbillingrate/$fxrate);
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			$otdayamount = $otdayamount + $otbillingrate;
			?>

		<tr>
			<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($otbillingdate)); ?></td>
			<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $otbillingrefno; ?></td>
			<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $otbillingname; ?></td>
			<input name="surgeryname[]" type="hidden" id="surgeryname" size="69" value="<?php echo $otbillingname; ?>">
			<input name="surgeryrate[]" type="hidden" id="surgeryrate" readonly size="8" value="<?php echo $otbillingrate; ?>">
			<td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
			<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
		</tr>
				<?php
				}
				if($otdayamount>0){
					?>
				<tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($otdayamount,2,'.',','); ?></strong></td>
				</tr>
				
			<?php 
				}			
				
			$totalipprivatedoctorfees = 0;
			$copayamt =0;
			
			$query621 = "select consultationdate,docno,doctorname,rate,amount,units,remarks from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
			$exec621 = mysqli_query($GLOBALS["___mysqli_ston"], $query621) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_service = mysqli_num_rows($exec621);
			if($num_service>0){
			echo "<tr><td colspan='7'><strong>PVT Doctor Charges</strong></td></tr>";
			}

			while($res621 = mysqli_fetch_array($exec621))
		   {
			$privatedoctordate = $res621['consultationdate'];
			$privatedoctorrefno = $res621['docno'];
			$privatedoctor = $res621['doctorname'];
			$privatedoctorrate = $res621['rate'];
			$privatedoctoramount = $res621['amount'];
			$privatedoctorunit = $res621['units'];
			$description = $res621['remarks'];
			if($description != '')
			{
			$description = '- '.$description;
			}
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}

			$queryve1 = "select planfixedamount,planpercentage from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
			$execve1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryve1) or die ("Error in queryve1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $resve1 = mysqli_fetch_array($execve1);

			/*if($resve1['planfixedamount'] > 0)
				$copayamt = $resve1['planfixedamount'];
			elseif($resve1['planpercentage']>0)
			    $copayamt =( $privatedoctoramount/100)*$resve1['planpercentage'] ;
			else */
				$copayamt =0;

			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
			$totalipprivatedoctorfees = $totalipprivatedoctorfees + $privatedoctoramount -$copayamt;//14
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($privatedoctordate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $privatedoctorrefno; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $privatedoctor.' '.$description; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $privatedoctor; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $privatedoctorrate/$fxrate; ?>">
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo $privatedoctorunit; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctorrate/$fxrate,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>
			</tr>
				<?php
				}

			   if($copayamt > 0 ) {
			     ?>

                <tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($privatedoctordate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"></td>
				<td width="242" class="bodytext31" valign="center"  align="left">Copay Amount</td>
				<td width="49" class="bodytext31" valign="center"  align="right">1</td>
				<td width="70" class="bodytext31" valign="center"  align="right">-<?php echo number_format($copayamt,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right">-<?php echo number_format($copayamt,2,'.',','); ?></td>
			</tr>
                <?php
				}
				if($totalipprivatedoctorfees>0){
					?>
				<tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($totalipprivatedoctorfees,2,'.',','); ?></strong></td>
				</tr>
                <?php
				}
                
			$totalambulanceamount = 0;
			$query63 = "select consultationdate,docno,description,rate,amount,units from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_service = mysqli_num_rows($exec63);
			if($num_service>0){
			echo "<tr><td colspan='7'><strong>Rescue Charges</strong></td></tr>";
			}
			while($res63 = mysqli_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($ambulancedate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $ambulancerefno; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $ambulance; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $ambulance; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $ambulancerate; ?>">
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo $ambulanceunit; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulancerate/$fxrate,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				if($totalambulanceamount>0){
				?>
				<tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>
				</tr>
                <?php
				}
			$totalmiscbillingamount = 0;
			$query69 = "select consultationdate,docno,description,rate,amount,units from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_service = mysqli_num_rows($exec69);
			if($num_service>0){
			echo "<tr><td colspan='7'><strong>MISC Charges</strong></td></tr>";
			}
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($miscbillingdate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $miscbillingrefno; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left"><?php echo $miscbilling; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $miscbilling; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $miscbillingrate/$fxrate; ?>">
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo $miscbillingunit; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingrate/$fxrate,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				if($totalmiscbillingamount>0){
				?>
				<tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($totalmiscbillingamount,2,'.',','); ?></strong></td>
				</tr>
                <?php
				}
				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalipprivatedoctorfees+$totalambulanceamount+$totalmiscbillingamount-$totalreturnamount);
				?>			
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>INVOICE TOTAL AMOUNT :</strong></td>
			<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($payoveralltotal,2,'.',','); ?></strong></td>
			</tr>
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>RECEIPTS</strong></td>
			<td colspan="3" align="right" class="bodytext31" valign="middle"><strong>&nbsp;</strong></td>
			</tr>
				
			<?php
			$totaldepositamount = 0;
			$query112 = "select transactionamount,docno,transactionmode,transactiondate,chequenumber from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount = 1*($depositamount/$fxrate);
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select billtype from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($transactiondate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
				<?php
				if($transactionmode == 'CHEQUE')
				{
				echo $chequenumber;
				}
				?></td>
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($depositamount,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right">-<?php echo number_format($depositamount,2,'.',','); ?></td>
			</tr>
			  <?php }
				  
			  ?>
			  <?php
			$totaldepositrefundamount = 0;
			$query112 = "select amount,docno,recorddate from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
			$depositrefundamount = 1*($depositrefundamount/$fxrate);
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			?>
			  <tr>
				 <td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				 <td width="74" class="bodytext31" valign="center"  align="left"><?php echo date("d/m/y", strtotime($transactiondate)); ?></td>
				 <td width="80" class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
				 <td width="242" class="bodytext31" valign="center"  align="left"><?php echo 'Deposit Refund'; ?></td>
				 <td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				 <td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
				 <td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
				 </tr>
			  <?php 
			  }
			  ?>
			  
						<?php
			$totalnhifamount = 0;
			$query641 = "select consultationdate,docno,totaldays,nhifrebate,nhifclaim,nhif_claimdays from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			//$nhifclaim = -$nhifclaim;
			
			$nhif_claimdays = $res641['nhif_claimdays'];
			if($nhif_claimdays=='0'){
			$nhifqty = -$nhifqty;
			$nhifclaim = (-1)*-$nhifclaim;
			}
			
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left" width="74"><?php echo  date("d/m/y", strtotime($nhifdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left" width="80"><?php echo $nhifrefno; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left"> <?php echo 'NHIF- Gain / Loss'; ?></td>
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo $nhifqty; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifrate,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
                <?php
			$totaladvancedepositamount = 0;
			$query112 = "select transactionamount,docno,transactiondate from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
			$advancedepositamount = 1*($advancedepositamount/$fxrate);
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			$totaladvancedepositamount += $advancedepositamount;
			?>
			  <tr>
				 <td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				 <td width="74" class="bodytext31" valign="center"  align="left"><?php echo date("d/m/y", strtotime($transactiondate)); ?></td>
				 <td width="80" class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
				 <td width="242" class="bodytext31" valign="center"  align="left"><?php echo 'Advance Deposit'; ?></td>
				 <td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				 <td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($advancedepositamount,2,'.',','); ?></td>
				 <td width="94" class="bodytext31" valign="center"  align="right">-<?php echo number_format($advancedepositamount,2,'.',','); ?></td>
				 </tr>
			  <?php 
			  }
			  ?>
			  
				<tr>
				<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT : </strong></td>
				<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
				<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($totaladvancedepositamount+$totalnhifamount+$totaldepositrefundamount+$totaldepositamount,2,'.',','); ?></strong></td>
				</tr>
                
			  <tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>CREDITS</strong></td>
			<td colspan="3" align="right" class="bodytext31" valign="middle"><strong>&nbsp;</strong></td>
			</tr>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select consultationdate,docno,description,rate,authorizedby from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate = 1*($discountrate/$fxrate);
			$discountrate1 = $discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			<tr>
				<td width="49" class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td width="74" class="bodytext31" valign="center"  align="left"><?php echo  date("d/m/y", strtotime($discountdate)); ?></td>
				<td width="80" class="bodytext31" valign="center"  align="left"><?php echo $discountrefno; ?></td>
				<td width="242" class="bodytext31" valign="center"  align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>">
				<td width="49" class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				<td width="70" class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>
				<td width="94" class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>
			</tr>
				<?php
				}
				if($totaldiscountamount>0){
				?>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>TOTAL AMOUNT :</strong></td>
			<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($totaldiscountamount,2,'.',','); ?></strong></td>
			</tr>	
			  <?php 
				}
			 $totaladvancedepositamount= number_format($totaladvancedepositamount,2,'.','');
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalipprivatedoctorfees+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount-$totalreturnamount-$totaladvancedepositamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			  

			  ?>
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Balance :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
		</tr>
		<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
         <tr>
			<td colspan="7" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
         <tr>
			<td colspan="7" class="bodytext31" align="center"><strong>This is an Interim Invoice only not final invoice.</strong></td>
		 </tr>

		 <tr>
			<td colspan="7" class="bodytext31" align="center">&nbsp;</td>
		  </tr>
         <tr>
			<td colspan="7" class="bodytext31" align="center">Printed on : <?php echo date('F d, Y H:i:s');?></td>
		  </tr>
</table>
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
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

//$canvas->page_text(0, 814, "if({PAGE_NUM}>1){header {PAGE_NUM}/{PAGE_COUNT}}", $font, 10, array(0,0,0));
$dompdf->stream("IpInterim.pdf", array("Attachment" => 0)); */
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
