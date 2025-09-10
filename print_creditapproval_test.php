<?php

ob_start();





session_start();



ini_set('max_execution_time', 3000);

ini_set('memory_limit','-1');



include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

$updatedate = date('Y-m-d');

$currentdate = date('Y-m-d');

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$colorloopcount = '';

$sno = '';

			



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



function roundTo($number, $to){ 

    return round($number/$to, 0)* $to; 

} 





if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

   

 



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

}



?>

<br />



<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if(isset($_REQUEST['billnumber'])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }

include("print_header_pdf3.php");

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

</style>



	<table width="700" border="0" align="center" cellpadding="2" cellspacing="4" style="margin: 0px 0px 0px 0px;">

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

		$querybill = "select billno from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode'";

		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resbill = mysqli_fetch_array($execbill);

		$billno = $resbill['billno'];





		$from_limit_date=$admissiondate;

		$to_limit_date =date('Y-m-d');

		$querybill = "select billdate,billno as billno2 from billing_ipcreditapproved where patientcode = '$patientcode' and visitcode = '$visitcode'";

		$execbill = mysqli_query($GLOBALS["___mysqli_ston"], $querybill) or die ("Error in querybill".mysqli_error($GLOBALS["___mysqli_ston"]));

		if($resbill = mysqli_fetch_array($execbill)){

			$billdate1=$to_limit_date = $resbill['billdate'];

			$billno2 = $resbill['billno2'];		

		}

		

		$query813 = "select recorddate from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";

		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res813 = mysqli_fetch_array($exec813);

		$num813 = mysqli_num_rows($exec813);

		if($num813 > 0)

		{

		$to_limit_date=$res813['recorddate'];

		}

		

		if(isset($_REQUEST['account'])){
				   
		$accountname=$_REQUEST['account'];
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		$subtypeanum = $res67['subtype'];

		$query13 = "select * from master_subtype where  auto_number = '$subtypeanum'";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res13 = mysqli_fetch_array($exec13);
		$subtype = $res13['subtype'];


		}

		?>

		   <tr>

             <td width="103" align="left" valign="center" class="bodytext31">&nbsp;</td> 

		     <td width="200" align="left" valign="center" class="bodytext31">&nbsp;</td>

		     <td width="103" align="left" valign="center" class="bodytext31">&nbsp;</td> 

		     <td width="121" align="left" valign="center" class="bodytext31">&nbsp;</td>

          </tr>

		   <tr>

             <td width="73" align="left" valign="center" class="bodytext31"><strong>Name:</strong></td> 

		     <td width="200" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>

		     <td width="83" align="left" valign="center" class="bodytext31"><strong>Invoice No:</strong></td> 

		     <td width="121" align="left" valign="center" class="bodytext31"><?php echo $billno2; ?></td>

          </tr>

		  

	       <tr>

             <td width="73" align="left" valign="center" class="bodytext31"><strong>Reg. No.:</strong></td>

	         <td width="200" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>

	         <td width="83" align="left" valign="center" class="bodytext31"><strong>Bill Date:</strong></td> 

		     <td width="121" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($billdate1)); ?></td>

         </tr>

          <tr>

             <td width="73" align="left" valign="center" class="bodytext31"><strong>Bill Type:</strong></td>

	         <td width="200" align="left" valign="center" class="bodytext31"><?php echo $billtype; ?></td>

	         <td width="83" align="left" valign="center" class="bodytext31"><strong>IP Visit No.:</strong></td>

			 <td width="121" align="auto" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>

         </tr>

        <tr>

			<td width="73" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td>

			<td width="200" align="left" valign="center" class="bodytext31"><?php echo $accname; ?></td>

			<td width="83" align="left" valign="center" class="bodytext31"><strong>Admission Date:</strong></td> 

	        <td width="121" align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($admissiondate)); ?></td>

		</tr>

        <tr>

            <td width="73" align="left" valign="center" class="bodytext31"><strong>Covered By: </strong></td>

            <td width="200" align="left" valign="center" class="bodytext31"><?php echo $subtype; ?></td>

            <td width="83" align="left" valign="center" class="bodytext31"><strong>Discharge Date:</strong></td>

			<td width="121" align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($updatedate));; ?></td>

		</tr>

		 <tr>

         	<td width="73" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="200" align="left" valign="center" class="bodytext31">&nbsp;</td>

            <td width="83" align="left" valign="center" class="bodytext31"><strong>No of Days:</strong></td>

			<td width="121" align="left" valign="left" class="bodytext31"><?php echo $nbOfDays; ?></td>

      </tr>

         <tr>

			<td width="73" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="200" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="83" align="left" valign="center" class="bodytext31"><strong>Type:</strong></td>

			<td width="121" align="left" valign="left" class="bodytext31"><?php echo $type; ?></td>

      </tr>

          <tr>

            <td width="73" align="left" valign="center" class="bodytext31">&nbsp;</td>

            <td width="200" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="83" align="left" valign="center" class="bodytext31"><strong>Bed No:</strong></td>

			<td width="121" align="left" valign="center" class="bodytext31"><?php echo $bed;?></td>

		</tr>

		<tr>

            <td width="73" align="left" valign="center" class="bodytext31">&nbsp;</td>

            <td width="200" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="83" align="left" valign="center" class="bodytext31">&nbsp;</td>

			<td width="121" align="left" valign="center" class="bodytext31">&nbsp;</td>

		</tr>

	</table>

 <table width="725" border="0"  cellpadding="0" cellspacing="0" align="center" style="margin: 0px 30px 0px 60px;">

 

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

 <?php $queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";

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

 <?php $queryicd = "select * from discharge_icd where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number DESC";

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

	<table align="center" border="0" cellspacing="4" cellpadding="2" >

			<tr>

			 	<td colspan="7" align="center"><span class="underline">Transaction Details</span></td>

			</tr>

		<thead>

			<tr>

				<td width="5%" align="left" valign="center" 

				bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

				<td  align="left" valign="center"  width="85"

				bgcolor="#ffffff" class="bodytext31"><strong>BILL DATE</strong></td>

				<td  align="left" valign="center"  width="85"

				bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>

				<td  align="left" valign="center" style="white-space:normal" width="275"

				bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>

				<td  align="right" valign="center" width="45"

				bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>

				<td  align="right" valign="center"  width="112"

				bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>

				<td  align="right" valign="center"  width="112"

				bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>

			</tr>

          </thead>

            <tbody>

            <?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			$totalquantity = 0;

			$totalop =0;

			$query17 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$packageanum1 = $res17['package'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			

			

			$query53 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

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

			$totalop=$consultationfee/$fxrate;

			?>

            <tr><td colspan="7"><strong>ADMISSION FEE</strong></td></tr>

			  <tr>

			 <td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			    <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-Y',strtotime($consultationdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>

			 <td class="bodytext31" valign="center"  align="left" width="250"><?php echo 'Admission Charge'; ?></td>

			     <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee/$fxrate,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right"><?php echo $consultationfee/$fxrate; ?></td>

				

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

			$totalop=$consultationfee/$fxrate;

			?>

            <tr><td colspan="7"><strong>ADMISSION FEE</strong></td></tr>

			  <tr>

			 <td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			    <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-Y', strtotime($consultationdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>

			 <td class="bodytext31" valign="center"  align="left" width="250"><?php echo 'Admission Charge'; ?></td>

			     <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee/$fxrate,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee/$fxrate,2,'.',','); ?></td>

				

           	</tr>

			<?php

			}

			?>

			<?php



					  $packageamount = 0;

			 $query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$packageanum1 = $res731['package'];

			$packagedate1 = $res731['consultationdate'];

			$packageamount = $res731['packagecharge'];

			

			$query741 = "select * from master_ippackage where locationcode='$locationcode' and auto_number='$packageanum1'";

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

              <tr><td colspan="7"><strong>PACKAGE CHARGE</strong></td></tr>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($packagedate1)); ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $packagename; ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>

		</tr>

			  <?php

			  }

			

			$totalbedallocationamount = 0;

			

			 $requireddate = '';

			 $quantity = '';

			 $allocatenewquantity = '';

$totalbedtransferamount=0;



			$ki=1;

			$querya01 = "select * from billing_ipbedcharges where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and docno='$billno2' and bed <> '0' order by recorddate";

			$execa01 = mysqli_query($GLOBALS["___mysqli_ston"], $querya01) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numa01 = mysqli_num_rows($execa01);

			if($numa01>0){

				echo "<tr><td colspan='6'>&nbsp;</td></tr><tr><td colspan='7'><strong>BED CHARGES</strong></td></tr>";	

			}

			while($resca01=mysqli_fetch_array($execa01)){



				$date=$resca01['recorddate'];

				$refno =$visitcode;

				$charge=$resca01['description'];

				$bed=$resca01['bed'];

				$ward=$resca01['ward'];

				$quantity=$resca01['quantity'];

				$rate=$resca01['rate'];

				$amount=$resca01['amount'];

				

				$querybed = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from master_bed where auto_number='$bed'");

				$resbed = mysqli_fetch_array($querybed);

				$bedname = $resbed['bed'];

				

				$queryward = mysqli_query($GLOBALS["___mysqli_ston"], "select description from master_ward where auto_number='$ward'");

				$resward = mysqli_fetch_array($queryward);

				$wardname = $resward['description'];

				

				if($quantity==0){

					$quantity=1;

				}

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
									if($quantity!=0){

				$totalbedallocationamount=$totalbedallocationamount+$amount;



				?>	

                <tr>
                   <td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

                    <td class="bodytext31" valign="center"  align="left" width="85"><?php echo date("d-m-Y", strtotime($date)); ?></td>

                    <td class="bodytext31" valign="center"  align="left" width="85"><?php echo trim($wardname); ?></td>

                    <td class="bodytext31" valign="center"  align="left" width="225"><?php echo trim($charge1).' ('.$bedname.')'; ?></td>

                    <td class="bodytext31" valign="center"  align="right" width="45"><?php echo $quantity; ?></td>

                    <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($rate,2,'.',','); ?></td>

                    <td class="bodytext31" valign="center"  align="right" width="75"><?php echo number_format($amount,2,'.',','); ?></td>

                </tr>              

			

			<?php		 } // if qty !=0 ends		

			}

			



			

			$totalpharm=0;

		  $totallab=0;

				$totalrad=0;

					$totalser=0;





//while (strtotime($from_limit_date) <= strtotime($to_limit_date)) {





			//	echo "<tr><td colspan='7' style='background-color:#ccc'><strong>".date('d M Y',strtotime($from_limit_date))."</strong></td></tr>";

				$data_count=0;

			

			

			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No'  GROUP BY ipdocno,itemcode";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_pharmacy = mysqli_num_rows($exec23);

			if($num_pharmacy>0){

				echo "<tr><td colspan='7'><strong>PHARMACY</strong></td></tr>";

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

			$pharate=$res23['rate']/$fxrate;

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

			//if($resquantity != 0)

			{

			if(strtoupper($pharmfree) =='NO')

			{

				$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

		
			if($resquantity!=0){ 
			$totalpharm=$totalpharm+$resamount;

			$data_count++;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($phadate)); ?></td>

			 <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>

			 <td class="bodytext31" valign="center"  align="left" width="250"><?php echo $phaname; ?></td>

			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">

			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">

			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">

			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">

			 <td class="bodytext31" valign="center"  align="right"><?php echo $resquantity; ?></td>

             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($pharate,2,'.',','); ?></td>

			 <td class="bodytext31" valign="center"  align="right"><?php echo $resamount; ?></td>

		     

		</tr>	

			

			  

			  <?php 	} // if Qtantity !=0 close
					}

			  }

			  }

			  ?>

			  <?php 

			//  $totallab=0;

			  $query19 = "select * from ipconsultation_lab where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' and freestatus='No' ";

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

			$queryl51 = "select  labitemrate as rateperunit from `billing_iplab` where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labcode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];

			

			$totallab=$totallab+$labrate;

			$data_count++;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($labdate)); ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo $labrefno; ?></td>

			<input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">

			<input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">

			<input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">

			<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $labname; ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>

		</tr>	

			  

			  <?php 

			  }

			  }

			  ?>

			  

			    <?php 

			//	$totalrad=0;

			  $query20 = "select * from ipconsultation_radiology where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No' ";

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

			

			$queryr51 = "select radiologyitemrate rateperunit from `billing_ipradiology` where  patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$radiologyitemcode'";

			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resr51 = mysqli_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];

			

			$totalrad=$totalrad+$radrate;

			$data_count++;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($raddate)); ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo $radref; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $radname; ?></td>

			

			<input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">

			<input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">

			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>

		</tr>	

			  

			  <?php 

			  }

			  }

			  ?>

			  	    <?php 

					

			//		$totalser=0;

		    echo $query21 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' and freestatus = 'No'  group by servicesitemname,iptestdocno ";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_service = mysqli_num_rows($exec21);

			if($num_service>0){

			echo "<tr><td colspan='7'><strong>SERVICE</strong></td></tr>";

			}

			while($res21 = mysqli_fetch_array($exec21))

			{

			$serdate=$res21['consultationdate'];

			$sername=$res21['servicesitemname'];

			//$serrate=$res21['servicesitemrate'];

			$serref=$res21['iptestdocno'];

			$servicesfree = $res21['freestatus'];

			$servicesdoctorname = $res21['doctorname'];

			$sercode=$res21['servicesitemcode'];

			$serqty=$res21['serviceqty'];

			//$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";

			//$execs51 = mysql_query($querys51) or die(mysql_error());

			//$ress51 = mysql_fetch_array($execs51);

			//$serrate = $ress51['rateperunit'];

			$queryl51 = "select  servicesitemrate as rateperunit from billing_ipservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode='$sercode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$serrate = $resl51['rateperunit'];

			$query2111 = "select serviceqty, amount from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";

			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrow2111 = mysqli_num_rows($exec2111);

			$resqty = mysqli_fetch_array($exec2111);

			 $serqty=$resqty['serviceqty'];

			if($serqty==0){$serqty=$numrow2111;}


			if(strtoupper($servicesfree) == 'NO')

			{

				//$totserrate=$resqty['amount'];

				// if($totserrate==0){

					$totserrate=$serrate*$serqty;

			  //}

			//$totserrate=$serrate*$numrow2111;

	
					if($serqty!=0){
			$totalser=$totalser+$totserrate;

			$data_count++;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($serdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $serref; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $sername." - ".$servicesdoctorname; ?></td>

				<input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">

				<input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">

				<td class="bodytext31" valign="center"  align="right"><?php echo (int)$serqty; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($serrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totserrate,2,'.',','); ?></td>

			</tr>	

			  

			  <?php 		} // if Qtantity !=0 close
						}

			  }



			if($data_count==0){

				echo "<tr ><td colspan='7'>No data found on this day.</td></tr>";				

			}



			                  $from_limit_date = date ("Y-m-d", strtotime("+1 day", strtotime($from_limit_date)));

			  

			 // }

			  ?>

			<?php

			$totalotbillingamount = 0;

			$query61 = "select * from ip_otbilling where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_ot = mysqli_num_rows($exec61);

			if($num_ot>0 ){

				echo "<tr><td colspan='7'><strong>OT SURGERY</strong></td></tr>";

			}

			while($res61 = mysqli_fetch_array($exec61))

		   {

			$otbillingdate = $res61['consultationdate'];

			$otbillingrefno = $res61['docno'];

			$otbillingname = $res61['surgeryname'];

			$otbillingrate = $res61['rate'];

			$otbillingrate = 1*($otbillingrate/$fxrate);

			$totalotbillingamount = $totalotbillingamount + $otbillingrate;

			?>

		<tr>

			<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($otbillingdate)); ?></td>

			<td class="bodytext31" valign="center"  align="left"><?php echo $otbillingrefno; ?></td>

			<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $otbillingname; ?></td>

			<input name="surgeryname[]" type="hidden" id="surgeryname" size="69" value="<?php echo $otbillingname; ?>">

			<input name="surgeryrate[]" type="hidden" id="surgeryrate" readonly size="8" value="<?php echo $otbillingrate; ?>">

			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>

			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>

		</tr>

				<?php

				}

				?>

				<?php

			$totalprivatedoctoramount = 0;

			$query62 = "select * from ipprivate_doctor where  patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg ='1'";

			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_pvt = mysqli_num_rows($exec62);

			if($num_pvt>0 ){

				echo "<tr><td colspan='7'><strong>PVT DOCTOR CHARGES</strong></td></tr>";

			}

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

			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($privatedoctordate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctorrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $privatedoctor.' '.$description; ?></td>

				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $privatedoctor; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $privatedoctorrate/$fxrate; ?>">

				<td class="bodytext31" valign="center"  align="right"><?php echo $privatedoctorunit; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctorrate/$fxrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

				<?php

			$totalambulanceamount = 0;

			$query63 = "select * from ip_ambulance where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_rescue = mysqli_num_rows($exec63);

			if($num_rescue>0){

			echo "<tr><td colspan='7'><strong>RESCUE CHARGES</strong></td></tr>";

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

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($ambulancedate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $ambulancerefno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $ambulance; ?></td>

				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $ambulance; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $ambulancerate; ?>">

				<td class="bodytext31" valign="center"  align="right"><?php echo $ambulanceunit; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulancerate/$fxrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

				<?php

			$totalmiscbillingamount = 0;

			$query69 = "select * from ipmisc_billing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_misc = mysqli_num_rows($exec69);

			if($num_misc>0){

			echo "<tr><td colspan='7'><strong>MISC CHARGES</strong></td></tr>";

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

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($miscbillingdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $miscbillingrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250"><?php echo $miscbilling; ?></td>

				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $miscbilling; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $miscbillingrate; ?>">

				<td class="bodytext31" valign="center"  align="right"><?php echo $miscbillingunit; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingrate/$fxrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

				<?php

				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount);

				?>			

			<tr>

			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>

			</tr>

			<tr>

			<td align="right" class="bodytext31" colspan="6" valign="middle"><strong>INVOICE TOTAL AMOUNT :</strong></td>

			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($payoveralltotal,2,'.',','); ?></strong></td>

			</tr>

			<tr>

			<td colspan="7" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>

			</tr>

			<?php

			$totaldepositamount = 0;
			$temp = 0;

			$query112 = "select * from master_transactionipdeposit where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt = mysqli_num_rows($exec112);

			if($num_receipt>0){

				$temp = 1;

				echo '<tr><td align="center" class="underline" colspan="7" valign="middle">RECEIPTS</td></tr>';	

			}

			while($res112 = mysqli_fetch_array($exec112))

			{

			$depositamount = $res112['transactionamount'];

			$depositamount = 1*($depositamount/$fxrate);

			$depositamount1 = -$depositamount;

			$docno = $res112['docno'];

			$transactionmode = $res112['transactionmode'];

			$transactiondate = $res112['transactiondate'];

			$chequenumber = $res112['chequenumber'];

			

			

			$query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$depositbilltype = $res731['billtype'];

		

		

			$totaldepositamount = $totaldepositamount + $depositamount1;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($transactiondate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>

				<?php

				if($transactionmode == 'CHEQUE')

				{

				echo $chequenumber;

				}

				?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">-<?php echo number_format($depositamount,2,'.',','); ?></td>

			</tr>

			    

			  

			  <?php }

				  

			  ?>

			  <?php

			$totaldepositrefundamount = 0;

			$query112 = "select * from deposit_refund where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";

			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt1 = mysqli_num_rows($exec112);

			if($num_receipt1>0 && $temp !=1){

				$temp = 1;

				echo '<tr><td align="center" class="underline" colspan="7" valign="middle">RECEIPTS</td></tr>';	

			}

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

				 <td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				 <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-Y', strtotime($transactiondate)); ?></td>

				 <td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>

				 <td class="bodytext31" valign="center"  align="left" width="250"><?php echo 'Deposit Refund'; ?></td>

				 <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

				 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>

			  </tr>

			  <?php 

			  }

			  ?>

			  

						<?php

			$totalnhifamount = 0;

			$query641 = "select * from ip_nhifprocessing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_receipt2 = mysqli_num_rows($exec641);

			if($num_receipt2>0 && $temp !=1){

				$temp = 1;

				echo '<tr><td align="center" class="underline" colspan="7" valign="middle">RECEIPTS</td></tr>';	

			}

			while($res641= mysqli_fetch_array($exec641))

		   {

			$nhifdate = $res641['consultationdate'];

			$nhifrefno = $res641['docno'];

			$nhifqty = $res641['totaldays'];

			$nhifrate = $res641['nhifrebate'];

			$nhifclaim = $res641['nhifclaim'];

			$nhifclaim = -$nhifclaim;

			$nhifclaim = $nhifqty*($nhifrate/$fxrate);

			$totalnhifamount = -($totalnhifamount + $nhifclaim);

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($nhifdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250"> <?php echo 'NHIF'; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo $nhifqty; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

			  <tr>

			<td colspan="7" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>

			</tr>

				<?php

			$totaldiscountamount = 0;

			$query64 = "select * from ip_discount where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$num_ipdiscount = mysqli_num_rows($exec64);

			if($num_ipdiscount>0){

				echo '<tr><td align="center" colspan="7" class="underline" valign="middle">CREDITS</td></tr>';

			}

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

			//$discountrate = 1*($discountrate/$fxrate);

			$totaldiscountamount = $totaldiscountamount + $discountrate;

			?>

			<tr>

				<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($discountdate)); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $discountrefno; ?></td>

				<td class="bodytext31" valign="center"  align="left" width="250">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>

				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">

				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>">

				<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>

			</tr>

				<?php

				}

				?>

					

			  <?php 

			  include('convert_currency_to_words.php');

			  $depositamount = 0;

			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);

			  $convertedwords = covert_currency_to_words(number_format($overalltotal,2,'.',''));

			  $overalltotal=number_format($overalltotal,2,'.','');

			  $consultationtotal=$totalop;

			   $consultationtotal=number_format($consultationtotal,2,'.','');

			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;

			   $netpay=number_format($netpay,2,'.','');

			  ?>

              

              

          </tbody>		

			 

	         <tr>

	            <td colspan="7" class="bodytext31" align="right">&nbsp;</td>

              </tr>

	          <tr>

	<td colspan="7" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>

	</tr>

	   

	<tr>

	<?php  $overalltotal = round($overalltotal); ?>

	<td colspan="7" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>

	</tr>

       

      

	    <tr>

	      <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>

        </tr>

	    <tr>

		<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext31"><strong>Receivable Accounts:</strong></td>

	   </tr>

	   <tr>

	     <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>

       </tr>

		   <?php

			$query41="select * from master_transactionipcreditapproved where  transactiontype='finalize' and patientcode='$patientcode' and visitcode='$visitcode' and billnumber='$billnumbers' ";

		   $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res41=mysqli_fetch_array($exec41))

			{

			$postingaccount = $res41['accountnameano'];

			$transactionamount = $res41['transactionamount'];


			$subsql='select b.subtype as name from master_accountname as a,master_subtype as b where a.subtype=b.auto_number and a.auto_number="'.$postingaccount.'"';
			$exec456 = mysqli_query($GLOBALS["___mysqli_ston"], $subsql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res412=mysqli_fetch_array($exec456);

			$postingaccount =
$res412['name'];

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



			//if ($balanceamount != 0.00)

			//{

			?>

			<tr>

				<td colspan="6" class="bodytext31" valign="center" bordercolor="#f3f3f3"  align="right"><strong><?php echo $postingaccount; ?></strong></td>

				<td  align="right" valign="center" bordercolor="#f3f3f3" class="bodytext31"><?php echo number_format($transactionamount,2,'.',','); ?></td>

			</tr>

			<tr>

			  <td colspan="4" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="right">&nbsp;</td>

			  <td align="right" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>

			  <td  align="right" valign="right" colspan="2" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>

	    </tr>

			
			<?php 

		   } 



		   ?>

</table>



<?php

/*



   require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4");

$dompdf->render();

$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("Arial", "normal");

$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("FinalBill.pdf", array("Attachment" => 0)); 

*/

?>



<?php



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

$content = ob_get_clean();


    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('FinalBill.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    } 

?>

	