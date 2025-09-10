<?php
ob_start();
session_start();
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

$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
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

 			$query1 = "select patientfullname, patientcode, accountname,billtype, gender, age, consultingdoctor, nhifid, subtype,scheme_id, type,consultationdate from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
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
		
		$query13 = "select currency,subtype, fxrate,bedtemplate,labtemplate,radtemplate,sertemplate from master_subtype where auto_number = '$subtypeanum'";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13 = mysqli_fetch_array($exec13);
		$subtype = $res13['subtype'];
		$currency=$res13['currency'];
		$fxrate=$res13['fxrate'];
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
		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
		
		
		$scheme_id = $res1["scheme_id"];
	$query_sc = "select scheme_name from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);

	$accname = $res_sc['scheme_name'];
		
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
		 
		$query2 = "select recorddate, ward, bed from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
		$wardanum = $res2['ward'];
		$bed = $res2['bed'];
		
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

		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$to_limit_date=$res813['recorddate'];
		}
		?>
	<table width="675" align="center" border="0" cellspacing="1" cellpadding="2">
			<tr>
			<td width="96" align="left" valign="center" class="bodytext31">&nbsp;</td> 
			<td width="250" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td> 
			<td width="118" align="left" valign="center" class="bodytext31">&nbsp;</td>
		</tr>
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Name:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Bill Date:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($currentdate)); ?></td>
		</tr>
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Reg. No.:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>

            <td width="134" align="left" valign="center" class="bodytext31"><strong>Age.:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $age; ?></td>

		</tr>

		<tr>
            <td width="96" align="left" valign="center" class="bodytext31"><strong>Bill Type:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>IP Visit No.:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
		</tr>
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Admission Date:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($admissiondate)); ?></td>
		</tr>
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Category:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $subtype; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>No of Days:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $nbOfDays; ?></td>
			<!--<td  width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Doctor :</strong></td>
			<td align="" valign="center" class="bodytext31"><?php //echo $consultingdoctor; ?></td>-->
		</tr>
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Membership No:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $mrdno; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Type:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $type; ?></td>
		</tr>
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Diagnostic Code 1:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $diagnostic; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31"><strong>Bed:</strong></td> 
			<td width="118" align="left" valign="center" class="bodytext31"><?php echo $bedname1; ?></td>
		</tr>
		
		<tr>
			<td width="96" align="left" valign="center" class="bodytext31"><strong>Diagnostic Code 2:</strong></td> 
			<td width="250" align="left" valign="center" class="bodytext31"><?php echo $diagnostic1; ?></td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td> 
			<td width="118" align="left" valign="center" class="bodytext31">&nbsp;</td>
		</tr>
		<tr>
			<td width="96" align="left"  valign="center" class="bodytext31">&nbsp;</td>
			<td width="250" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="118" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
		</tr>
		<tr>
			<td width="96" align="left"  valign="center" class="bodytext31">&nbsp;</td>
			<td width="250" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
			<td width="134" align="left" valign="center" class="bodytext31">&nbsp;</td>
			<td width="118" align="left"  valign="center"  class="bodytext31">&nbsp;</td>
		</tr>
	</table>	
	
		<table width="667" align="center" border="0" cellspacing="4" cellpadding="2">
			<tr>
			 	<td colspan="2"  align="center"><strong>SUMMARY INVOICE</strong></td>
			</tr>
		<!--<thead>
			<tr class="flyleaf">
				<td width=""  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
				<td width="20%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>BILL DATE</strong></td>
				<td width="20%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>REF No.</strong></td>
				<td width="25%"  align="left" valign="center" style="white-space:normal"
				bgcolor="#ffffff" class="bodytext31"><strong>DESCRIPTION</strong></td>
				<td width="7%"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>QTY</strong></td>
				<td width="12%"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>RATE </strong></td>
				<td width="16%"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>AMOUNT </strong></td>
			</tr>
            </thead>-->
            
				  		
			
			<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;

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
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
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
                        <td class="bodytext31"  valign="center"  align="left" width="467"><strong><?php echo "Package Charge";?></strong></td>
                        <td class="bodytext31" valign="center"  align="right" width="200"><?php  echo number_format($packageamount,2,'.',',');  ?></td>                   
                    </tr>
			  <?php
			  }
			  
			$totalbedallocationamount = 0;
			$discount_bed = 0;
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];

					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}

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
								$quantity=$quantity1;
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
								$quantity=$quantity1;
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
										$charge1 = 'Sundries';
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
								$totalbedallocationamount=$totalbedallocationamount+($quantity*($rate));
								
					  ?>
					<tr>
                        <td class="bodytext31"  valign="center"  align="left" width="467"><strong><?php echo $charge1;?></strong></td>
                        <td class="bodytext31" valign="center"  align="right" width="200"><?php  echo number_format($amount,2,'.',',');  ?></td>                   
                    </tr>              
					 
					   <?php 
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


					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
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
					$bedcharge='0';
					$quantity='0';
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
								$quantity=$quantity1;
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
								$quantity=$quantity1;
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($bedcharge=='0')
						{
							if($quantity>0)
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
										$charge1 = 'Sundries';
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
									$totalbedtransferamount=$totalbedtransferamount+($quantity*($rate));
						  ?>
						<tr>
							<td class="bodytext31"  valign="center"  align="left" width="467"><strong><?php echo $charge1;?></strong></td>
							<td class="bodytext31" valign="center"  align="right" width="200"><?php  echo number_format($amount,2,'.',',');  ?></td>                   
						</tr>							
						 
						   <?php 
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
			 
			<?php 
			   

			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}

			$totalpharm=0;
			$phaamount31=0;
			$phaamount3=0;
            $totalreturnamount='';
			$query23 = "select entrydate, itemname, itemcode, rate, ipdocno, quantity, freestatus from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' GROUP BY ipdocno,itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pharmacy = mysqli_num_rows($exec23);
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
			$resamount = $amount;
			
			$resamount31=number_format(($amount1/$fxrate),2,'.','');
			$resamount=number_format(($resamount/$fxrate),2,'.','');
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
			{
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			$totalpharm=$totalpharm+$resamount;
		$phaamount31+=$resamount31;			
		$phaamount3+=$resamount;
		
				 }
			  }
			  }
		$totalpharm= $totalpharm-$phaamount31;				   
		if($num_pharmacy>0) {
		?>
        
		<tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Pharmacy:</strong></td>
			 
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
			
			 <td class="bodytext31" valign="center"  align="right" width="200"><?php  echo number_format($phaamount3,2,'.',',');  ?></td>
		     
		</tr>
        <tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Pharmacy Returns:</strong></td>
			 
			 	
			 <td class="bodytext31" valign="center"  align="right" width="200">-<?php  echo number_format($phaamount31,2,'.',',');  ?></td>
		     
		</tr>	
	
		<?php 
		}else {
			$phaamount3=0;
			$phaamount31=0;
        ?>
		<tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Pharmacy:</strong></td>
			
			
			 <td class="bodytext31" valign="center"  align="right" width="200"><?php  echo number_format($phaamount3,2,'.',',');  ?></td>
		     
		</tr>
        <tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Pharmacy Returns:</strong></td>
			 
			 	
			 <td class="bodytext31" valign="center"  align="right" width="200">-<?php  echo number_format($phaamount31,2,'.',',');  ?></td>
		     
		</tr>	

		<?php

		}
			 
			 
			$fxrate = $original_fxrate;

			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' and freestatus='No'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_lab = mysqli_num_rows($exec19);
				
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
			 }
			  }

			  if($num_lab>0){
			?>
        
		<tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Laboratory:</strong></td>				
			<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totallab,2,'.',','); ?></td>
		</tr>
		<?php 
			  }else { 
			$totallab=0;
		?>

		<tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Laboratory:</strong></td>				
			<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totallab,2,'.',','); ?></td>
		</tr>	
		<?php 
		}
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_radio = mysqli_num_rows($exec20);
						
			/*if($num_radio>0){
			echo "<tr><td colspan='7'><strong>RADIOLOGY</strong></td></tr>";   
			}*/
			
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
			}
			}

			if($num_radio>0){
			?>
       
		<tr>
        
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Radiology:</strong></td>
			
			<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalrad,2,'.',','); ?></td>
		</tr>	
		<?php 

			}
			else {  
				$totalrad =0;
				?>

            <tr>
        
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Radiology:</strong></td>
			
			<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalrad,2,'.',','); ?></td>
		   </tr>	
			<?php

			}

			  $theatreamt=0;
			
		   $query199 = "select * from ipconsultation_services where servicesitemname like '%THEATRE%' AND patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
				
			while($res199 = mysqli_fetch_array($exec199))
			{
			
			$theatrerate=$res199['amount'];
			$theatrefreestatus=$res199['freestatus'];
			
			
			if(strtoupper($theatrefreestatus) == 'NO')
			{
			
			
			//$theatreamt=$theatreamt+$theatrerate;
			  }
              }
			?>
        
		<?php /*?><tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Theatre:</strong></td>
			
				
			<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($theatreamt,2,'.',','); ?></td>
		</tr><?php */?>
        <?php	
            		
			  ?>
              <?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$consultationfee =0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$packageanum1 = $res17['package'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			
			$totalop=$consultationfee;
			
			?>
       
			  <tr>
			 <td class="bodytext31"  valign="center"  align="left" width="467"><strong>Admission Fees:</strong></td>
			   
                <td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 
           	</tr>	
              
              
              
              
			  	    <?php 
					
			
					$totalser=0;
		    $query21 = "select consultationdate,servicesitemname,servicesitemrate,iptestdocno,freestatus,servicesitemcode from ipconsultation_services where patientvisitcode='$visitcode' and wellnessitem <> '1' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemcode, iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_exec21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and wellnessitem <> '1' and servicerefund <> 'refund' and iptestdocno = '$serref'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			 $serqty=$resqty['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			if(strtoupper($servicesfree) == 'NO')
			{
			 $totserrate=$resqty['amount'];
			  if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			
			  $totalser=$totalser+$totserrate;
			}
			}

			if($num_exec21 >0){
			?>
            
			<tr>
				<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Services and Procedures:</strong></td>
				
				<input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
				<input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
				
				<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalser,2,'.',','); ?></td>
			</tr>	
			 <?php }else {  

			 $totalser =0;
			 ?>
			 <tr>
				<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Services and Procedures:</strong></td>
				
				<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalser,2,'.',','); ?></td>
			</tr>	
             <?php
				}
			 ?>
			 
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_ot = mysqli_num_rows($exec61);
			/*if($num_ot>0 ){
				echo "<tr><td colspan='7'><strong>OT SURGERY</strong></td></tr>";
			}*/
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			$otbillingrate = 1*($otbillingrate/$fxrate);
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
		   }
			?>
		<tr>
			<td class="bodytext31"  valign="center"  align="left" width="467"><strong>OT Surgery:</strong></td>
			
			
			<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalotbillingamount,2,'.',','); ?></td>
		</tr>
				
				<?php
			$totalipprivatedoctorfees = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_pvt = mysqli_num_rows($exec62);
			
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			if($description != '')
			{
			$description = '-'.$description;
			}
			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
			$totalipprivatedoctorfees = $totalipprivatedoctorfees + $privatedoctoramount;
			//$totalipprivatedoctorfees = $totalipprivatedoctorfees + $privatedoctoramount; //14
		   }
			?>
            
			<tr>
				<td class="bodytext31"  valign="center"  align="left" width="467"><strong>PVT Doctor Charges</strong></td>
				
				
			
				<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalipprivatedoctorfees,2,'.',','); ?></td>
			</tr>
				
				<?php
					
				
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_rescue = mysqli_num_rows($exec63);
			
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
		   }
			?>
            
			<tr>
				<td class="bodytext31"  valign="center"  align="left" width="467"><strong>Rescue Charges:</strong></td>
				
							
				<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalambulanceamount,2,'.',','); ?></td>
			</tr>
				
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_misc = mysqli_num_rows($exec69);
			/*if($num_misc>0){
			echo "<tr><td colspan='7'><strong>MISC CHARGES</strong></td></tr>";
			}*/
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
		   }
			?>
			<tr>
				<td class="bodytext31"  valign="center"  align="left" width="467"><strong>MISC Charges: </strong></td>
				
								
				<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalmiscbillingamount,2,'.',','); ?></td>
			</tr>
				
				
				
		    <?php
			$queryve1 = "select planfixedamount,planpercentage from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
			$execve1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryve1) or die ("Error in queryve1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $resve1 = mysqli_fetch_array($execve1);

			if($resve1['planfixedamount'] > 0)
				$copayamt = $resve1['planfixedamount'];
			elseif($resve1['planpercentage']>0)
			    $copayamt =( $totalipprivatedoctorfees/100)*$resve1['planpercentage'] ;
			else
				$copayamt =0;


			$copayamt =0;
			?>
			<tr>
			<td align="left" class="bodytext31" valign="middle" width="467"><strong> Copay Amount: :</strong></td>
			<td align="right" class="bodytext31" valign="middle" style="" width="200">-<?php echo number_format($copayamt,2,'.',','); ?></td>
			</tr>
			
            <?php
				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalipprivatedoctorfees+$totalambulanceamount+$totalmiscbillingamount-$totalreturnamount-$copayamt);
				?>	
            
			<tr>
			<td align="left" class="bodytext31" valign="middle" width="467"><strong> Total Bill Amount: :</strong></td>
			<td align="right" class="bodytext31" valign="middle" style="" width="200"><?php echo number_format($payoveralltotal,2,'.',','); ?></td>
			</tr>
			
            
            <?php 
				
			$totalcreditamt = 0;
			$query644 = "select * from ip_creditnote where patientcode='$patientcode' and visitcode='$visitcode'";  
			$exec644 = mysqli_query($GLOBALS["___mysqli_ston"], $query644) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_ipdiscount = mysqli_num_rows($exec644);
			
			while($res644 = mysqli_fetch_array($exec644))
		   {
			
			
			$creditamount = $res644['totalamount']/$fxrate; 
					
			$totalcreditamt = $totalcreditamt + $creditamount; 
		  } 
		  	$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			 $discountrate = $res64['rate']/$fxrate;
			 $discountrate = -$discountrate;
			// $discountrate = 1*($discountrate/$fxrate);
			 $totaldiscountamount = $totaldiscountamount + $discountrate;  
			   
		   }
		   $totalcreditamt = $totalcreditamt + $totaldiscountamount; 

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
			$nhif_claimdays = $res641['nhif_claimdays'];
			if($nhif_claimdays=='0'){
			$nhifqty = -$nhifqty;
			$nhifclaim = -$nhifclaim;
			}
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = $totalnhifamount + $nhifclaim;
		   }
		   $totalcreditamt = $totalcreditamt + $totalnhifamount; 
			?>
			<tr>
				<td class="bodytext31"  valign="center"  align="left" width="467"> <strong>Total Credits</strong></td>
				
				<td class="bodytext31" valign="center"  align="right" width="200"><?php echo number_format($totalcreditamt,2,'.',','); ?></td>
			</tr>
			
            
			<?php
			
			$totaldepositfinal=0;
			$totaldepositamount=0;
			$totaldepositrefundamount = 0;	
			$depositrefundamount=0;
			$totaldeposit=0;
			$tot=0;
// 			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
// 			$exec112 = mysql_query($query112) or die(mysql_error());
// 			$num_receipt = mysql_num_rows($exec112);
			
// 			while($res112 = mysql_fetch_array($exec112))
// 			{
// 			$depositamount = $res112['transactionamount'];
// 			$depositamount = 1*($depositamount/$fxrate);
// 			$depositamount1 = -$depositamount;
// 			$docno = $res112['docno'];
// 			$transactionmode = $res112['transactionmode'];
// 			$transactiondate = $res112['transactiondate'];
// 			$chequenumber = $res112['chequenumber'];
			
// 			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
// 			$exec731 = mysql_query($query731) or die(mysql_error());
// 			$res731 = mysql_fetch_array($exec731);
// 			$depositbilltype = $res731['billtype'];
			
// 			$totaldiscountamount = 0;
			
			 
// 			$query1122 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
// 			$exec1122 = mysql_query($query1122) or die(mysql_error());
// 			$num_receipt1 = mysql_num_rows($exec1122);
// 			 while($res1122 = mysql_fetch_array($exec1122))
// 			{
// 			$depositrefundamount = $res1122['amount'];
			
// 			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			 
// 			}
			
// 			$totaldepositamount = $totaldepositamount + $depositamount1;
// 			$tot=$tot+$depositamount; 
// 			$totaldeposit=$tot-$totaldepositrefundamount-$totaldiscountamount; 
// 			//$totaldepositfinal=-$totaldeposit; 
// 			} 
// 			//*****************advance deposit*******************
// 			$totaladvancedepositamount = 0;
// 			$queryadv = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
// 			$execadv = mysql_query($queryadv) or die("Error in Queryadv".mysql_error());
// 			$num_advdep = mysql_num_rows($execadv);
// 			 while($resadv = mysql_fetch_array($execadv))
// 			{
// 			$advancedepositamount = $resadv['transactionamount'];
// 			$totaladvancedepositamount += $advancedepositamount;			 
// 			}
// 			//*****************advance deposit ends*******************
// 			$totaldeposit += $totaladvancedepositamount;
// //			$totaldepositfinal=-$totaldeposit/$fxrate;

// 			$totaladvancedepositamountrefund=0;
// 			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
// 			$exec112 = mysql_query($query112) or die(mysql_error());
// 			while($res112 = mysql_fetch_array($exec112))
// 			{
// 			$depositrefundamountfx = $res112['amount'];
// 			$totaladvancedepositamountrefund += $depositrefundamountfx;			 
// 			}

// 			$totaldeposit -= $totaladvancedepositamountrefund;


// 			$totaldepositfinal=-$totaldeposit/$fxrate;

			////////////// deposit and refund_deposit////////////////////
			$totaldepositamount = 0;
			$totaldepositamountuhx=0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode' and transactionmodule <> 'Adjustment'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			
			$depositamount1 = 1*($depositamount/$fxrate);
			$totaldepositamount = $totaldepositamount + $depositamount;
			
			 $depositamount1uhx = $depositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $depositamount1uhx;
			}
			 $totaladvancedepositamount = 0;
			$totaladvancedepositamountuhx=0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamountfx = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
			
			$advancedepositamount = 1*($advancedepositamountfx/$fxrate);
			$totaldepositamount += $advancedepositamount;

			$totaladvancedepositamount += $advancedepositamount;	
		}
			
			 // $advancedepositamountuhx = $advancedepositamountfx;
		  //  $totaldepositamountuhx = $totaldepositamountuhx + $advancedepositamountuhx;
		   ?>

			  <?php
			$totaldepositrefundamount = 0;
			$totaldepositrefundamountuhx=0;
			$query123444 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec123444 = mysqli_query($GLOBALS["___mysqli_ston"], $query123444) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res123444 = mysqli_fetch_array($exec123444))
			{
			$depositrefundamountfx = $res123444['amount'];
			$docno = $res123444['docno'];
			$transactiondate = $res123444['recorddate'];
			
			 
			$depositrefundamount = 1*($depositrefundamountfx/$fxrate);
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			}

			$totaldeposit = $totaldepositamount+$totaladvancedepositamount-$totaldepositrefundamount;
			////////////// deposit and refund_deposit////////////////////

			
			?>

			<tr>
				<td class="bodytext31" valign="center"  align="right" width="467"><strong>Less Deposit and Payments received:</strong></td>
				
				<td class="bodytext31" valign="center"  align="right" width="200">-<?php echo number_format($totaldeposit/$fxrate,2,'.',','); ?></td>
			</tr>
			
			  
				
			
			
				
			  <?php 
			  
			  include('convert_currency_to_words.php');
			  $totaladvancedepositamount= number_format($totaladvancedepositamount,2,'.','');
			  $depositamount = 0;
			  // $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalipprivatedoctorfees+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount-$totalnhifamount+$totaldepositrefundamount-$totalreturnamount-$totaladvancedepositamount-$copayamt);
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalipprivatedoctorfees+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totalnhifamount-$totalreturnamount-$totaldeposit-$copayamt);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');

			  ?>
			<tr>
			<td colspan="2" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
		<tr>
        	
        	<td   class="bodytext31" align="left" width="467"><strong>Amount Due :</strong></td>
			<td class="bodytext31" align="right" width="200"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
		</tr>
		<tr>
			<td colspan="2" class="bodytext31" align="center">&nbsp;</td>
		  </tr>

		 <tr>
			<td colspan="2" class="bodytext31" align="center">&nbsp;</td>
		  </tr>
         <tr>
			<td colspan="2" class="bodytext31" align="center">Printed on : <?php echo date('F d, Y H:i:s');?></td>
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
