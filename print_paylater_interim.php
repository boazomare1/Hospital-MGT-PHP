<?php
ob_start();
session_start();
error_reporting(0);
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
if (isset($_REQUEST["visitcode"])) { $res2visitcode = $_REQUEST["visitcode"]; } else { $res2visitcode = ""; }
if (isset($_REQUEST["patientcode"])) { $res2patientcode = $_REQUEST["patientcode"]; } else { $res2patientcode = ""; }
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
	$querymember = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
	$execmember = mysqli_query($GLOBALS["___mysqli_ston"], $querymember) or die ("Error in querymember".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resmember = mysqli_fetch_array($execmember);
	//$plancount = mysql_num_rows($execmember);
	 $planpercentage = $resmember['planpercentage'];
	 $res17planpercentage = $resmember['planpercentage'];
	 $plannumber = $resmember['planname'];
	 $res2subtype =$patientsubtype = $resmember['subtype'];
	 $visitentrydate = $resmember['consultationdate'];
	 $visitentrytime = $resmember['consultationtime'];
     
     $res15accountname = $res2accountname =$res44accountname=$resmember['accountname'];
	 $res2patientname = $resmember['patientfullname'];
	$patientcode=$res2patientcode = $resmember['patientcode'];
	$visitcode=$res2visitcode = $resmember['visitcode'];
  $scheme_id = $resmember["scheme_id"];
	$query_sc = "select * from master_planname where scheme_id = '$scheme_id'";
	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_sc = mysqli_fetch_array($exec_sc);
	$res15accountname = $res_sc['scheme_name'];
 $querysub = "select * from master_subtype where auto_number='$patientsubtype'";
 $querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], $querysub);
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
  if (strpos(strtolower($patientsubtype1), 'nhif') !== false)
      $isnhif=1;
    else
	  $isnhif=0;
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
$query15 = "select accountname,id from master_accountname where auto_number = '$res44accountname'";
$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
$res15 = mysqli_fetch_array($exec15);
//$res15accountname = $res15['accountname'];
$res15accountid = $res15['id'];
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
<?php
include("print_header.php");
?>
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
    <td width="148" align="left" valign="center" class="bodytext31"><strong>Reg No:</strong></td>
    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $res2patientcode; ?></td>
  </tr>
    <tr>
    <td width="110" align="left" valign="center" class="bodytext31"><strong>OP Visit Date.</strong></td>
    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $visitentrydate.' '.$visitentrytime; ?></td>
	<td width="148" align="left" valign="center" class="bodytext31"><strong>OP Visit No.</strong></td>
    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $res2visitcode; ?></td>
  </tr>
  
  <tr>
  <td width="110" align="left" valign="center" class="bodytext31"><strong>Account:</strong></td>
    <td width="361" align="left" valign="center" class="bodytext31"><?php echo nl2br($res15accountname); ?></td>
    
    <td width="148" align="left" valign="center" class="bodytext31"><strong>A/c No:</strong></td>
    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $res15accountid;?></td>
  </tr>
  
  <tr>
    <td width="110" align="left" valign="center" class="bodytext31"><strong>Insurance Co:</strong></td>
    <td width="361" align="left" valign="center" class="bodytext31"><?php echo nl2br($patientsubtype1); ?></td>
    <td width="148" align="left" valign="center" class="bodytext31"><strong>Membership No:</strong></td>
    <td width="93" align="right" valign="center" class="bodytext31"><?php echo $resmemberno; ?></td>
  </tr>
  <tr>
    <td width="110" align="left" valign="center" class="bodytext31"><strong>Doctor :</strong></td>
    <td width="361" align="left" valign="center" class="bodytext31"><?php echo $res_doctor_fullname ;?></td>
    <td width="148" align="left" valign="center" class="bodytext31"><strong><!--Credit Notes Amount:--></strong></td>
    <td width="93" align="right" valign="center" class="bodytext31"><?php //echo $rescreditnote; ?></td>
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
 <?php $queryicd = "select * from consultation_icd where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' order by auto_number DESC limit 1,1";
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
    <td colspan="6" width="725" align="center"><strong><?php echo 'DETAILED INTERIM INVOICE'; ?></strong></td>
  </tr>
 <tr>
   <td colspan="6" align="left">&nbsp;</td>
   </tr>
  
  <tr>
	<td  align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31 border"><strong>DATE</strong></td>
	<td  valign="center" 
	bgcolor="#ffffff" class="bodytext31 border" ><strong>REF No.</strong></td>
	<td   align="left" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border" width='280'><strong>DESCRIPTION</strong></td>
	<td align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>QTY</strong></td>
	<td   align="right" valign="center" 
	 bgcolor="#ffffff" class="bodytext31 border"><strong>RATE(KES)</strong></td>
	<td   align="right" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>AMOUNT(KES)</strong></td>
  </tr>
 
  <tbody>
	<tr>
		 <td colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" class="bodytext31" valign="center"  align="left">
		<strong>Consultation</strong></td>
	</tr>
	
<?php
$conindtotalamount=0;
$totalcopay=0;
$admitid='';
			$colorloopcount = '';
			$totalcopayconsult='';
			$sno = '';
			$totalamount=0;
			$totalfxamount=0;
			$totalfxcopay=0;
			$consfxrate=0;
			$conscopayfxrate=0;
			
			
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['consultationfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$plannumber = $res17['planname'];
			$consultingdoctor = $res17['consultingdoctor'];
			$doctorcode = $res17['consultingdoctorcode'];
			$memberno=$res17['memberno'];
			$pvtype = $res17["visittype"];
			
			
			$admitid = $res17['admitid'];
			$availablelimit = $res17['availablelimit'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$planpercentage=$res17['planpercentage'];
			$planfixedamount=$res17['planfixedamount'];
			$copay=($consultationfee/100)*$planpercentage;
			$copay1=($consultationfee/100)*$planpercentage;
			
			$query_pw = "select `docno`, `entrydate`, `consult_discamount`, `pharmacy_discamount`, `lab_discamount`, `radiology_discamount`, `services_discamount` from patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res_pw = mysqli_fetch_array($exec_pw);
			$consult_discamount = $res_pw['consult_discamount'];
			$pharmacy_discamount = $res_pw['pharmacy_discamount'];
			$lab_discamount = $res_pw['lab_discamount'];
			$radiology_discamount = $res_pw['radiology_discamount'];
			$services_discamount = $res_pw['services_discamount'];
			$pw_docno = $res_pw['docno'];
			$pw_entrydate = $res_pw['entrydate'];
			 
			
			$consultationfee = number_format($consultationfee,2,'.','');
			$consfxrate=$consultationfee*$fxrate;
			$conscopayfxrate=$copay*$fxrate;
			
			$query33 = "select consultation from billing_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			 $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			 $row33 = mysqli_num_rows($exec33);
 
			if($planpercentage!=0.00 && $row33 > 0)
			{
			 $totalop=$consultationfee; 
			 $totalcopay=$totalcopay+$copay;
			 $totalcopayconsult=$totalcopayconsult+$copay;
			 $totalfxamount=$totalfxamount+$consfxrate;
			 $conindtotalamount=$conindtotalamount+$consfxrate;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			else
			{
				$totalop=$consultationfee; 
	        	$totalcopay=$totalcopay+$copay;
				$totalcopayconsult=$totalcopayconsult+$copay;
				$totalfxamount=$totalfxamount+$consfxrate;
				$conindtotalamount=$conindtotalamount+$consfxrate;
				$totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			
			
?>
<tr>
	<td  align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $consultationdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" ><?php echo $viscode; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width='280'><?php echo $consultingdoctor; ?></td>
	<td align="center" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo '1'; ?></td>
    <td align="right" valign="right" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></td>
	<td align="right" valign="right" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($consfxrate,2,'.',','); ?></td>
</tr>
<?php if(($planpercentage!=0.00)){
 $totalfxamount-=$conscopayfxrate;
 $conindtotalamount=$conindtotalamount-$conscopayfxrate;
 $consfxrate-=$conscopayfxrate;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $consultationdate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res2visitcode; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php
}
$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res18 = mysqli_fetch_array($exec18);
$billingdatetime=$res18['billingdatetime'];
$billno=$res18['billnumber'];
/*$query177 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec177 = mysql_query($query177) or die ("Error in Query177".mysql_error().__LINE__);
$res177 = mysql_fetch_array($exec177);*/
$copayfixed=$res18['copayfixedamount'];
if($copayfixed > 0 && $consultationfee>='0.00')
{
$consfxrate=$consfxrate-$copayfixed;
$conindtotalamount=$conindtotalamount-$copayfixed;
 $conscopayfxrate=$copayfixed*$fxrate;
 $totalfxamount=$totalfxamount-$conscopayfxrate;
 $totalcopayfixedamount=$copayfixed;
 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
	
?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $billingdatetime; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $billno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Fixed Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayfixed,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayfixed,2,'.',','); ?></td>
	</tr>
<?php 
}
$consfxrefund=0;
$query11 = "select * from refund_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$num=mysqli_num_rows($exec11);
$res11 = mysqli_fetch_array($exec11);
$res11billnumber = $res11['billnumber'];
if($num > 0)
{
$consultationrefund = $res11['consultation'];
$res11transactiondate= $res11['billdate'];
$res11transactiontime= $res11['transactiontime'];
$consfxrefund=$consultationrefund*$fxrate;
$consfxrate+=$consfxrefund;
$conindtotalamount-=$consfxrefund;
$totalfxamount=$totalfxamount+$consfxrefund;
?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res11transactiondate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res11billnumber; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Consultation Refund'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($consultationrefund,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($consultationrefund,2,'.',','); ?></td>
	</tr>
    
<?php }
if($consult_discamount > 0)
{
$consult_fxdiscamount = $consult_discamount * $fxrate;
$conindtotalamount -= $consult_discamount * $fxrate;
$totalfxamount=$totalfxamount-$consult_fxdiscamount;
			
			?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Consultation Discount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($consult_discamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($consult_discamount,2,'.',','); ?></td>
	</tr>
    
<?php 
} ?>
<?php 
$totalref=0;
$totalfxref=0;
$totalfxrefcopay=0;
$query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'  ";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while($res22 = mysqli_fetch_array($exec22))
{
$refdate=$res22['consultationdate'];
$refname=$res22['referalname'];
$refrate=$res22['referalrate'];
$refref=$res22['refno'];
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1); 
$reffxrate=$refrate;
$refrate=number_format($reffxrate,2,'.','');
$copay=($refrate/100)*$planpercentage;
$refcopayfxrate=($reffxrate/100)*$planpercentage;
$totalref=$totalref+$refrate;
$conindtotalamount=$conindtotalamount+$refrate;
?>
 <tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $refdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $refref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $refname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo '1'; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($refrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($refrate,2,'.',','); ?></td>
</tr>
 <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
$totalfxamount-=$copay;
$totalfxref-=$copay;
$totalfxrefcopay=$totalfxrefcopay+$copay;
$conindtotalamount=$conindtotalamount-$copay;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $refdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $refref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php } ?>
 <?php }  ?>
<tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($conindtotalamount,2); ?></td>
</tr>
<?php
$labindtotalamount=0;
$ladfxdisamt=0;
 $totallab=0;
  $labfxrate=0;
  $labfxcopay=0;
  $totalfxlab=0;
  $labfxcopay=0;
  $labcashcopay=0;
  $query19 = "select * from consultation_lab where  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund'   and `op_package_id` IS NULL";
$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$row19 = mysqli_num_rows($exec19);
if($row19>0){
?>
<tr>
<td colspan="6" class="bodytext31" valign="center"  align="left">
<strong>Lab</strong></td>
</tr>
<?php
}
while($res19 = mysqli_fetch_array($exec19))
{
	$labdate=$res19['consultationdate'];
	$labname=$res19['labitemname'];
	$labcode=$res19['labitemcode'];
	$labrate=$res19['labitemrate'];
	$labrefno=$res19['refno'];
	
	$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
	$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
	$resfx = mysqli_fetch_array($execfx);
	//$labrate=$resfx['rateperunit'];
	$querycopay = "select cash_copay from consultation_lab where refno = '$labrefno' and labitemcode = '$labcode'";
	$execcopay = mysqli_query($GLOBALS["___mysqli_ston"], $querycopay) or die ("Error in QueryCopay".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rescopay = mysqli_fetch_array($execcopay);
	$cash_copay = $rescopay['cash_copay'];
	if($isnhif==1)
	{
		$labrate=$labrate-$cash_copay;
		$cash_copay=0;
	}
	if($labrate==0){
   continue;
    }
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1); 
$labrate = number_format($labrate,2,'.','');
$labfxrate=($labrate*$fxrate);
$copay=($labrate/100)*$planpercentage;
$labfxcopay=$copay*$fxrate;
$labfxcashcopay=$cash_copay;
 $quer_copays = "SELECT billnumber FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode = '$labcode'";
$exec_copays = mysqli_query($GLOBALS["___mysqli_ston"], $quer_copays) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$rows_copay = mysqli_num_rows($exec_copays);
$res_copay = mysqli_fetch_array($exec_copays);
$copay_bill_no=$res_copay['billnumber'];

if(($planpercentage!=0.00)&&($planforall=='yes')&&($rows_copay>0))
			  { 
			    $totallab=$totallab+$labrate; 
			    $labindtotalamount=$labindtotalamount+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
				$totalfxamount=$totalfxamount+$labfxrate;
			   }
			   else
			  {
				  $totallab=$totallab+$labrate;
				  $labindtotalamount=$labindtotalamount+$labrate;
		  $totalfxamount=$totalfxamount+$labfxrate;
		  $totalfxlab=$totalfxlab+$labfxrate;
		  }
		  
		     
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $labdate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $labrefno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $labname; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($labrate,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($labrate,2,'.',','); ?></td>
	</tr>
<?php if(($planpercentage!=0.00)&&($planforall=='yes')&&($rows_copay>0)){ 
$totalcopay=$totalcopay+$copay;
$labindtotalamount=$labindtotalamount-$copay;
$totalfxamount-=$labfxcopay;
$totalfxlab-=$labfxcopay;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $labdate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $copay_bill_no; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($copay,2,'.',','); ?></td>
	</tr>
<?php }?>
  <?php 
	if(($cash_copay != 0)&&($rows_copay>0)){
		$totalfxamount-=$labfxcashcopay; 
		$labindtotalamount-=$labfxcashcopay; 
		$totalfxlab-=$labfxcashcopay;
		$labcashcopay+=$cash_copay;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $labdate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $copay_bill_no; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $labname." - Copay"; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($cash_copay,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($cash_copay,2,'.',','); ?></td>
	</tr>
<?php } ?>	
<?php } 
if($lab_discamount > 0 && $row19 > 0)
{
$lab_fxdiscamount = $lab_discamount * $fxrate;
$ladfxdisamt=$ladfxdisamt+$lab_fxdiscamount;
$labindtotalamount=$labindtotalamount+$lab_fxdiscamount;
$totalfxamount=$totalfxamount-$lab_fxdiscamount;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Lab Discount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($lab_discamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($lab_discamount,2,'.',','); ?></td>
	</tr>
<?php } if($labindtotalamount>0){?>
<tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($labindtotalamount,2); ?></td>
</tr>
<?php }
$original_fxrate= $fxrate;
if(strtoupper($currency)=="USD"){
	$fxrate = $pharmacy_fxrate;
}



//santu writen code start


$totalpharm=0;

$query23_con = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and patientvisitcode not in (select visitcode from pharmacysales_details where visitcode='$visitcode')";
$exec23_con = mysqli_query($GLOBALS["___mysqli_ston"], $query23_con) or die ("Error in query23_con".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$pharno_con = mysqli_num_rows($exec23_con);
if($pharno_con>0){
?>
<tr>
<td colspan="6" class="bodytext31" valign="center"  align="left">
<strong>Pharamcy</strong></td>
</tr>
<?php
}

$querycon= "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and patientvisitcode not in (select visitcode from pharmacysales_details where visitcode='$visitcode')";
$execcon = mysqli_query($GLOBALS["___mysqli_ston"], $querycon) or die ("Error in querycon".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while($res_con = mysqli_fetch_array($execcon))
{
	$recorddate_con=$res_con['recorddate'];
	$medicinecode_con=$res_con['medicinecode'];
	$medicinename_con=$res_con['medicinename'];
	$quantity_con=$res_con['quantity'];
	$rate_con=$res_con['rate'];
	$amount_con=$res_con['amount'];
	$refno_con=$res_con['refno'];
	$totalpharm+=$amount_con;
?>

		<tr>
		<td align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><?php echo $recorddate_con; ?></td>
		<td align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><?php echo $refno_con; ?></td>
		<td align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><?php echo $medicinename_con; ?></td>
		<td align="center" valign="left" bgcolor="#ffffff" class="bodytext31"><?php echo $quantity_con; ?></td>
		<td align="right" valign="left" bgcolor="#ffffff" class="bodytext31"><?php echo number_format($rate_con,2,'.',','); ?></td>
		<td align="right" valign="left" bgcolor="#ffffff" class="bodytext31"><?php echo number_format($amount_con,2,'.',','); ?></td>
		</tr>

<?php
}




//santu writen code end







$phindtotalamount=0;
   
   $totalfxpharm=0;
   $totalfxcopaypharm=0;
   $pharno1=1;
  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' and freestatus!='Yes' group by itemcode";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$pharno = mysqli_num_rows($exec23);
if($pharno>0){
?>
<tr>
<td colspan="6" class="bodytext31" valign="center"  align="left">
<strong>Pharamcy</strong></td>
</tr>
<?php
}
while($res23 = mysqli_fetch_array($exec23))
{
	$phaquantity=0;
$phaamount=0;
$totalrefquantity=0;
$reftotalamount=0;
$phadate=$res23['entrydate'];
$phaname=$res23['itemname'];
$phaitemcode=$res23['itemcode'];
$pharate=$res23['rate'];
 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$pharno1 = mysqli_num_rows($execphar);
	if($pharno1==0){
$pharno1=3;
$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and freestatus!='Yes'";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while($res33 = mysqli_fetch_array($exec33))
{
$quantity=$res33['quantity'];
$phaquantity=$phaquantity+$quantity;
$amount=$res33['totalamount'];
$phaamount=$phaamount+$amount;
}
$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while($res47 = mysqli_fetch_array($exec47))
{
$refquantity = $res47['quantity'];
$refamount = $res47['totalamount'];
$totalrefquantity =  $totalrefquantity + $refquantity;
$reftotalamount = $reftotalamount + $refamount;
}
 $query28 = "select sum(quantity) as quantity from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus = '2'";
$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while($res28 = mysqli_fetch_array($exec28)){		
	$totalrefquantity+=$res28['quantity'];
				
}
$realquantity = $phaquantity - $totalrefquantity;
if($realquantity<=0){
	continue;
}
$phaamount = $phaamount - $reftotalamount;
$pharfxrate=$pharate;
$pharfxamount=$pharate*$realquantity;
$pharate=number_format($pharate/$fxrate,2,'.','');
$phaamount=number_format($pharate*$realquantity,2,'.','');
$phaamount=number_format($phaamount,2,'.','');
 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode'";
$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$res28 = mysqli_fetch_array($exec28);
$pharefno=$res28['refno'];
$excludestatus=$res28['excludestatus'];
$approvalstatus = $res28['approvalstatus'];
if($excludestatus == '')
{
$copayfxamount=(($pharate)/100)*$planpercentage;
$copay=($copayfxamount/$fxrate);
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$totalpharm=$totalpharm+$phaamount;
$totalcopaypharm=$totalcopaypharm+$copay;
$totalpharm=$totalpharm+$phaamount;
$phindtotalamount=$phindtotalamount+$phaamount;
$totalcopaypharm=$totalcopaypharm+$copay;
$totalfxpharm=$totalfxpharm+$pharfxamount;
$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
$totalfxcopay=$totalfxcopay+$copayfxamount;
$totalfxamount=$totalfxamount+$pharfxamount;
}
else
{
	$totalpharm=$totalpharm+$phaamount;
	$phindtotalamount=$phindtotalamount+$phaamount;
$totalfxamount=$totalfxamount+$pharfxamount;
$totalfxpharm=$totalfxpharm+$pharfxamount;
}
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $phadate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pharefno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $phaname; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $realquantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($pharate,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($phaamount,2,'.',','); ?></td>
	</tr>
<?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
  $totalfxamount-=$copay*$realquantity;
  $phindtotalamount-=$copay*$realquantity;
	$totalfxpharm-=$copay*$realquantity;
 ?>
 <tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $phadate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pharefno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $realquantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		-<?php echo number_format($copay*$realquantity,2); ?></td>
	</tr>
<?php }?>
			  
<?php }
}}
 if($pharmacy_discamount > 0 && $pharno > 0 && $pharno1==1)
			  {
			  $queryphar = "select auto_number from billing_paynowpharmacy where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			  $execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			  $pharno1 = mysqli_num_rows($execphar);
			  if($pharno1==0){
			  $pharmacy_fxdiscamount = $pharmacy_discamount * $fxrate;
			  $phindtotalamount = $phindtotalamount * $fxrate;
			  $totinddisphamt=$totinddisphamt+$pharmacy_fxdiscamount;
			  $totalfxamount=$totalfxamount-$pharmacy_fxdiscamount;
 ?>
 <tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Pharmacy Discount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($pharmacy_fxdiscamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($pharmacy_fxdiscamount,2,'.',','); ?></td>
	</tr>
	 <?php
	  }
	  }
	  ?>
  <!--copay-->
   <?php 
   //$totalpharm=0;
  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' and freestatus!='Yes' group by itemcode";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$pharno = mysqli_num_rows($exec23);
while($res23 = mysqli_fetch_array($exec23))
{
	$phaquantity=0;
$phaamount=0;
$totalrefquantity=0;
$reftotalamount=0;
$phadate=$res23['entrydate'];
$phaname=$res23['itemname'];
$phaitemcode=$res23['itemcode'];
$pharate=$res23['rate'];
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1>0){
if($planforall!='yes' && $pharno1>0){
	continue;
}
			
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and freestatus!='Yes'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			
				 $query28 = "select sum(quantity) as quantity from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus = '2'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1sd".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			while($res28 = mysqli_fetch_array($exec28)){		
				$totalrefquantity+=$res28['quantity'];
							
			}
			
			$realquantity = $phaquantity - $totalrefquantity;
			if($realquantity<=0){
				continue;
			}
			$phaamount = $phaamount - $reftotalamount;
			$pharfxrate=$pharate;
//			$pharfxamount=$phaamount;
			
						$pharfxamount=$pharate*$realquantity;
			$pharate=number_format($pharate/$fxrate,2,'.','');
			$phaamount=number_format($pharate*$realquantity,2,'.','');
			$phaamount=number_format($phaamount,2,'.','');
			 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1as".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
			{
				$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
				
			 $copay=(($pharate)/100)*$planpercentage;
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   $totalpharm=$totalpharm+$phaamount;
			   $phindtotalamount=$phindtotalamount+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay*$realquantity;
				 $totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;
				$totalfxamount=$totalfxamount+$pharfxamount;
				
			   }
			   else
			  {
				  $totalpharm=$totalpharm+$phaamount;
				  $phindtotalamount=$phindtotalamount+$phaamount;
				  $totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $phadate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pharefno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $phaname; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $realquantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($pharate,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($phaamount,2,'.',','); ?></td>
	</tr>
<?php if(($planpercentage!=0.00)&&($planforall=='yes')){
$pharfxrate=number_format($copay*$fxrate,5,'.','');
$pharfxamount=number_format($pharfxrate*$realquantity,5,'.','');
$copay*$realquantity;
$totalcopay=$totalcopay+($copay*$realquantity);
$phindtotalamount=$phindtotalamount-($copay*$realquantity);
$totalfxamount-=$pharfxamount;
$totalfxpharm-=$pharfxamount;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $phadate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pharefno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $realquantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		-<?php echo number_format($copay*$realquantity,2); ?></td>
	</tr>
<?php }?>
			  
<?php }
}}
?>
<?php
if($pharmacy_discamount > 0 && $pharno > 0)
{
$pharmacy_fxdiscamount = $pharmacy_discamount * $fxrate;
$phindtotalamount=$phindtotalamount-$pharmacy_fxdiscamount;
$totalfxamount=$totalfxamount-$pharmacy_fxdiscamount;
?>
 <tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Pharmacy Discount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($pharmacy_fxdiscamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '-'.number_format($pharmacy_fxdiscamount,2,'.',','); ?></td>
	</tr>
 <?php
  } if($totalpharm>0){?>
 <tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($phindtotalamount,2); ?></td>
</tr>
  
  <?php } $fxrate = $original_fxrate;
$radindtotalamount=0;
	$totalrad=0;
	$totalcopayrad='';
	$radfxrate=0;
	$totalfxrad=0;
	$totalfxcopayrad=0;
	$radfxcopay=0;
	$radcashcopay=0;
	$raddiscamount= 0;
  $query20 = "select * from consultation_radiology where radiologyitemcode NOT IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed'  and `op_package_id` IS NULL";
$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$row20 = mysqli_num_rows($exec20);
if($row20>0){
?>
<tr>
<td colspan="6" class="bodytext31" valign="center"  align="left">
<strong>Radiology</strong></td>
</tr>
<?php
}
while($res20 = mysqli_fetch_array($exec20))
{
$raddate=$res20['consultationdate'];
$radname=$res20['radiologyitemname'];
$radcode=$res20['radiologyitemcode'];
$resultentry=$res20['resultentry'];
$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resfx = mysqli_fetch_array($execfx);
$radrate=$res20['radiologyitemrate'];
$radref=$res20['refno'];
$querycopay = "select cash_copay,discount from consultation_radiology where refno = '$radref' and radiologyitemcode = '$radcode'";
$execcopay = mysqli_query($GLOBALS["___mysqli_ston"], $querycopay) or die ("Error in QueryCopay".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescopay = mysqli_fetch_array($execcopay);
$cash_copay = $rescopay['cash_copay'];
$disc_amount = $rescopay['discount'];
if($isnhif==1)
{
	$radrate=$radrate-$cash_copay;
	$cash_copay=0;
}
if($radrate==0){
   continue;
}
	
//$radrate=$res20['radiologyitemrate'];
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1); 
$radrate = number_format($radrate,2,'.','');
$copay=($radrate/100)*$planpercentage;
$radfxrate=($radrate*$fxrate);
$radfxcopay=$copay*$fxrate;
$radfxcashcopay=$cash_copay;
$radcashcopay+=$cash_copay;
$radfxdiscamount=$disc_amount;
$raddiscamount+= $disc_amount;
 if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$totalrad=$totalrad+$radrate; 
$radindtotalamount=$radindtotalamount+$radrate; 
$totalcopayrad=$totalcopayrad+$copay;
$totalfxcopay=$totalfxcopay+$radfxcopay;
$totalfxamount=$totalfxamount+$radfxrate;				
$totalfxrad=$totalfxrad+$radfxrate;
$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
}
else
{
	$totalrad=$totalrad+$radrate;
	$radindtotalamount=$radindtotalamount+$radrate;
	$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $raddate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $radref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $radname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo '1'; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($radrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($radrate,2,'.',','); ?></td>
</tr>
 <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
 
 $totalcopay=$totalcopay+$copay;
 $radindtotalamount=$radindtotalamount-$copay;
$totalfxamount-=$radfxcopay;
  $totalfxrad-=$radfxcopay;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $raddate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $radref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
	<?php }?>
<?php if($cash_copay != 0){
	$totalfxamount-=$radfxcashcopay;
	$radindtotalamount-=$radfxcashcopay;
	  $totalfxrad-=$radfxcashcopay;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $raddate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $radref; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31" width='280'>
	<?php echo $radname.' - Copay'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
</tr>
<?php }?>
			  
			  <?php if($disc_amount != 0){
			  							 	$totalfxamount-=$radfxdiscamount;
			  							 	$radindtotalamount-=$radfxdiscamount;
											  $totalfxrad-=$radfxdiscamount;
 	
			  ?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $raddate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $radref; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo $radname.' - Discount'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$disc_amount,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$disc_amount,2,'.',','); ?></td>
</tr>
<?php }?>
			  
<?php }
?>
<?php
if($radiology_discamount > 0 && $row20 > 0)
{
$radiology_fxdiscamount = $radiology_discamount * $fxrate;
$totalfxamount=$totalfxamount-$radiology_fxdiscamount;
$radindtotalamount=$radindtotalamount-$radiology_fxdiscamount;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo 'Radiology Discount'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$radiology_discamount,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$radiology_discamount,2,'.',','); ?></td>
</tr>
<?php 
  }
  ?>
  <!--copay-->
  <?php  
//$totalrad=0;
//$totalcopayrad='';
$query20 = "select * from consultation_radiology where radiologyitemcode  IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed'  and `op_package_id` IS NULL";
$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$row20 = mysqli_num_rows($exec20);
while($res20 = mysqli_fetch_array($exec20))
{
$raddate=$res20['consultationdate'];
$radname=$res20['radiologyitemname'];
$radcode=$res20['radiologyitemcode'];
$radref=$res20['refno'];
$resultentry=$res20['resultentry'];
$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$resfx = mysqli_fetch_array($execfx);
$radrate=$res20['radiologyitemrate'];
$querycopay = "select cash_copay, discount from consultation_radiology where refno = '$radref' and radiologyitemcode = '$radcode'";
$execcopay = mysqli_query($GLOBALS["___mysqli_ston"], $querycopay) or die ("Error in QueryCopay".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescopay = mysqli_fetch_array($execcopay);
$cash_copay = $rescopay['cash_copay'];
$disc_amount = $rescopay['discount'];
if($isnhif==1)
{
	$radrate=$radrate-$cash_copay;
	$cash_copay=0;
}
if($radrate==0){
   continue;
}
//$radrate=$res20['radiologyitemrate'];
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1); 
$copay=($radrate/100)*$planpercentage;
$radfxrate=($radrate*$fxrate);
$radfxcopay=$copay*$fxrate;
$radfxcashcopay=$cash_copay;
$radcashcopay+=$cash_copay;
$radfxdiscamount=$disc_amount;
$raddiscamount+=$disc_amount;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$totalrad=$totalrad+$radrate; 
$radindtotalamount=$radindtotalamount+$radrate; 
$totalcopayrad=$totalcopayrad+$copay;
$totalfxcopay=$totalfxcopay+$radfxcopay;
$totalfxamount=$totalfxamount+$radfxrate;				
$totalfxrad=$totalfxrad+$radfxrate;
$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
}
else
{
	$totalrad=$totalrad+$radrate;
	$radindtotalamount=$radindtotalamount+$radrate;
	$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $raddate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $radref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $radname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo '1'; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($radrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($radrate,2,'.',','); ?></td>
</tr>			
<?php if(($planpercentage!=0.00)&&($planforall=='yes')){ 
$totalcopay=$totalcopay+$copay;
$radindtotalamount=$radindtotalamount-$copay;
$totalfxamount-=$radfxcopay;
  $totalfxrad-=$radfxcopay;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $raddate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $radref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php }?>
<?php if($cash_copay != 0){
	$totalfxamount-=$radfxcashcopay;
	$radindtotalamount-=$radfxcashcopay;
	  $totalfxrad-=$radfxcashcopay;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $raddate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $radref; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31" width='280'>
	<?php echo $radname.' - Copay'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
</tr>
<?php }?>
<?php if($disc_amount != 0){
$totalfxamount-=$radfxdiscamount;
$radindtotalamount-=$radfxdiscamount;
$totalfxrad-=$radfxdiscamount;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $raddate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $radref; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo $radname.' - Discount'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$disc_amount,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$disc_amount,2,'.',','); ?></td>
</tr>
<?php }?>
<?php }
?>
<?php
if($radiology_discamount > 0 && $row20 > 0)
{
$radiology_fxdiscamount = $radiology_discamount * $fxrate;
$totalfxamount=$totalfxamount-$radiology_fxdiscamount;
$radindtotalamount=$radindtotalamount-$radiology_fxdiscamount;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo 'Radiology Discount'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$radiology_discamount,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$radiology_discamount,2,'.',','); ?></td>
</tr>
 <?php
			  }  if($radindtotalamount>0){
			  ?>
			  
			    <tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($radindtotalamount,2); ?></td>
</tr>
			  <?php }
					$serindtotalamount=0;
					$totalser=0;
					$serfxrate=0;
					$serfxcopay=0;
					$totalfxser=0;
					$totalfxcopayser=0;
					$serfxcopayqty=0;
					$serfxrateqty=0;
					$sercashcopay=0;
			  $query21 = "select * from consultation_services where servicesitemcode NOT IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''    and `op_package_id` IS NULL group by servicesitemcode ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			if($row21>0){
?>
<tr>
<td colspan="6" class="bodytext31" valign="center"  align="left">
<strong>Services</strong></td>
</tr>
<?php
}
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			//$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$wellnessitem=$res21['wellnessitem'];
			$wellnesspkg=$res21['wellnesspkg'];
			$process=$res21['process'];
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$res21['servicesitemrate'];
			
			$serref=$res21['refno'];
			
			$query2111 = "select sum(serviceqty) as serviceqty,sum(refundquantity) as refundquantity,sum(amount) as amount,sum(cash_copay) as cash_copay from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' group by servicesitemcode";//and approvalstatus <> '2' and approvalstatus = '1'";
			//$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
			$cash_copay=$resqty['cash_copay'];
			if($isnhif==1)
			{
				$serrate=$serrate-$cash_copay;
				$cash_copay=0;
			}
			if($serrate==0){
			   continue;
			}
		    //$perrate=$resqty['servicesitemrate'];
			$perrate = $serrate;
			//$totserrate=$serrate*$serqty;
			//echo $serrate;
			$serrate = number_format($serrate,2,'.','');
			$perrate = number_format($perrate,2,'.','');
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$perrate*$serqty;
			$serfxrate=($perrate*$fxrate);
			$serfxcopay=$copaysingle*$fxrate;
			$serfxcopayqty=$serfxcopay*$serqty;
			$serfxrateqty = $serfxrate*$serqty;
			$serfxcashcopay = $cash_copay;
			$sercashcopay += $cash_copay;
			$totserrate=$totamt;
 if(($planpercentage!=0.00)&&($planforall=='yes'))
  { 
   
	$serratetot=$serrate;
	//$totalser=$totalser+$serratetot; 
	$totserrate = $totamt-$copay;
	$totalser=$totalser+$totamt;
	
	$totalcopayser=$totalcopayser+$copay;
	$totalfxcopay=$totalfxcopay+$serfxcopayqty;
	$totalfxamount=$totalfxamount+$serfxrateqty;
	$totalfxser=$totalfxser+$serfxrateqty;
	$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
   }
   else if(($planpercentage!=0.00)&&($planforall==''))
  { 
	$serratetot=$serrate;
	//$totamt=$perrate*$numrow2111;
	$totalser=$totalser+$totamt; 
	$serindtotalamount=$serindtotalamount+$totamt; 
	//$totalcopayser=$totalcopayser+$copay;
	
	$totalfxcopay=$totalfxcopay+$serfxcopayqty;
	$totalfxamount=$totalfxamount+$serfxrateqty;
	$totalfxser=$totalfxser+$serfxrateqty;
	$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
   }
   
   else
  {
		$serratetot=$serrate;
		$totalser=$totalser+$totamt;
		$serindtotalamount=$serindtotalamount+$totamt;
		$totalfxamount=$totalfxamount+$serfxrateqty;
		$totalfxser=$totalfxser+$serfxrateqty;
  }
  ?>
  <tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $serdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $serref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $sername; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo $serqty; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($serrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($totamt,2,'.',','); ?></td>
</tr>
 <?php 
 if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay; 
 $copayperser=$copay/$serqty;
 $serindtotalamount=$serindtotalamount-$copayperser;
			  	$totalfxamount-=$serfxcopayqty;
			    $totalfxser-=$serfxcopayqty;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $serdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $serref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $serqty; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayperser,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php }?>
<?php if($cash_copay != 0){ 
$totalfxamount-=$serfxcashcopay;
$serindtotalamount-=$serfxcashcopay;
$totalfxser-=$serfxcashcopay;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $serdate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $serref; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31" width='280'>
	<?php echo $sername.' - Copay'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
</tr>
<?php }?>
			  
<?php }
?>
<?php
if($services_discamount > 0 && $row21 > 0)
{
$services_fxdiscamount = $services_discamount * $fxrate;
$totalfxamount=$totalfxamount-$services_fxdiscamount;
$serindtotalamount=$serindtotalamount-$services_fxdiscamount;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo 'Services Discount';  ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$services_discamount,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$services_discamount,2,'.',','); ?></td>
</tr>
<?php
			  }
			  ?>
              <!--copay-->
              <?php 
					
					//$totalser=0;
			  $query21 = "select * from consultation_services where servicesitemcode  IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   group by servicesitemcode ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$row21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['refno'];
			$process=$res21['process'];
			
			
			//$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$query2111 = "select sum(serviceqty) as serviceqty,sum(refundquantity) as refundquantity,sum(amount) as amount,sum(cash_copay) as cash_copay from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' group by servicesitemcode";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
		    $cash_copay=$resqty['cash_copay'];
			if($isnhif==1)
			{
				$serrate=$serrate-$cash_copay;
				$cash_copay=0;
			}
			if($serrate==0){
			   continue;
			}
			$perrate=$serrate;
			//$totserrate=$serrate*$serqty;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$perrate*$serqty;
			$serfxrate=($perrate*$fxrate);
			$serfxcopay=$copaysingle*$fxrate;
			$serfxcopayqty=$serfxcopay*$serqty;
			$serfxrateqty = $serfxrate*$serqty;
			$serfxcashcopay = $cash_copay;
			$sercashcopay += $cash_copay;
			$totserrate=$totamt;
	if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
			    $serindtotalamount=$serindtotalamount+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
				$totalfxcopay=$totalfxcopay+$serfxcopayqty;
				$totalfxamount=$totalfxamount+$serfxrateqty;
				$totalfxser=$totalfxser+$serfxrateqty;
				$totalfxcopayser=$totalfxcopayser+$serfxcopayqty;
			   }
			   
			   else
			  {
				   $serratetot=$serrate;
				  	$totalser=$totalser+$totamt;
				  	$serindtotalamount=$serindtotalamount+$totamt;
				  	$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
				}
			  ?>
 <tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $serdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $serref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $sername; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo $serqty; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($serrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($totamt,2,'.',','); ?></td>
</tr>
<?php if(($planpercentage!=0.00)&&($planforall=='yes')){
	$totalcopay=$totalcopay+$copay;  
	$serindtotalamount=$serindtotalamount-$copay;  
$copayperser=$copay/$serqty;
			  $totalfxamount-=$serfxcopayqty;
			  			  $totalfxser-=$serfxcopayqty;
	
			  ?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $serdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $serref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $serqty; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayperser,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php }?>
<?php if($cash_copay != 0){ 
$totalfxamount-=$serfxcashcopay;
$serindtotalamount-=$serfxcashcopay;
$totalfxser-=$serfxcashcopay;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $serdate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $serref; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31" width='280'>
	<?php echo $sername.' - Copay'; ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$cash_copay,2,'.',','); ?></td>
</tr>
<?php }?>
			  
<?php }
?>
<?php
if($services_discamount > 0 && $row21 > 0)
{
$services_fxdiscamount = $services_discamount * $fxrate;
$totalfxamount=$totalfxamount-$services_fxdiscamount;
$serindtotalamount=$serindtotalamount-$services_fxdiscamount;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_entrydate; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $pw_docno; ?></td>
	<td align="left" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo 'Services Discount';  ?></td>
	<td align="center" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo '1'; ?></td>
<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$services_discamount,2,'.',','); ?></td>
	<td align="right" valign="left" 
 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format(-$services_discamount,2,'.',','); ?></td>
</tr>
<?php
} if($serindtotalamount>0){
?>
  <tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($serindtotalamount,2); ?></td>
</tr>
<?php  }
$ambindtotalamount=0;
   $totalamb=0;
	$snohome='0';
	$totalfxambcopay=0;
	$totalfxamb=0;
  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' ";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
$ambcount=mysqli_num_rows($exec22);
while($res22 = mysqli_fetch_array($exec22))
{
$refdate=$res22['consultationdate'];
$refname=$res22['description'];
$refrate=$res22['rate'];
$refamount=$res22['amount'];
$refref=$res22['docno'];
$qty=$res22['units'];
$reffxrate=$refrate;
$reffxamount=$refamount;
$refrate=number_format($reffxrate,2,'.','');
$refamount=number_format($refrate*$qty,2,'.','');
$accountname=$res22['accountname'];
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1); 
$copay=(($refrate*$qty)/100)*$planpercentage;
$refcopayfxrate=($reffxrate/100)*$planpercentage;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$totalamb=$totalamb+$refamount;
$ambindtotalamount=$ambindtotalamount+$refamount;
$totalcopayamb=$totalcopayamb+$copay;
$totalambulance=$totalamb;
$totalfxamb=$totalfxamb+$reffxamount; 
$totalfxambcopay=$totalfxambcopay+$refcopayfxrate;
$totalfxcopay=$totalfxcopay+$refcopayfxrate;
$totalfxamount=$totalfxamount+$reffxamount;
}
else
{
$totalamb=$totalamb+$refamount;
$ambindtotalamount=$ambindtotalamount+$refamount;
$totalambulance=$totalamb;
$totalfxamb=$totalfxamb+$reffxamount; 
$totalfxamount=$totalfxamount+$reffxamount;
}
?>
 <tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $refdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $refref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $refname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo '1'; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($refrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($refrate,2,'.',','); ?></td>
</tr>
 <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ 
 $totalcopay=$totalcopay+$copay;
 $ambindtotalamount=$ambindtotalamount-$copay;
$totalfxamount-=$copay;
$totalfxamb-=$copay;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $refdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $refref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php }?>
			  
<?php } if($ambindtotalamount>0){
?>
  <tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($ambindtotalamount,2); ?></td>
</tr>
<?php  }
$homindtotalamount=0;
			   $totalhom=0;
			   $snohome='0';
			   $totalfxhome=0;
			   $totalfxhomecopay=0;
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
			$ambcount1=mysqli_num_rows($exec22);
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			$reffxrate=$refrate;
			$reffxamount=$refamount;
			$refrate=number_format($refrate,2,'.','');
			$refamount=number_format($refrate*$qty,2,'.','');
			$accountname=$res22['accountname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=(($refrate*$qty)/100)*$planpercentage;
			$refcopayfxrate=($reffxrate/100)*$planpercentage;
			 if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalhom=$totalhom+$refamount;
			    $homindtotalamount=$homindtotalamount+$refamount;
				$totalcopayhom=$totalcopayhom+$copay;
				$totalhomecare=$totalhom;
				$totalfxhome=$totalfxhome+$reffxamount; 
				$totalfxhomecopay=$totalfxhomecopay+$refcopayfxrate;
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxamount;
			   }
			   else
			  {
				  $totalhom=$totalhom+$refamount;
				  $homindtotalamount=$homindtotalamount+$refamount;
				$totalhomecare=$totalhom;
				$totalfxhome=$totalfxhome+$reffxamount; 
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxamount;
				 // $totalamb=$totalamb+$refamount;
				  }
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $refdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $refref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test"><?php echo $refname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo '1'; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($refrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($refrate,2,'.',','); ?></td>
</tr>
<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$copay;
			   $homindtotalamount-=$copay;
			   $totalfxhome-=$copay;
			  ?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $refdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $refref; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copay,2); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copay,2,'.',','); ?></td>
	</tr>
<?php }?>
			  
<?php } if($homindtotalamount>0){
?>
  <tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($homindtotalamount,2); ?></td>
</tr>
<?php  }
$totaldepartmentref=0;
$homindtotalamount=0;
$query231 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' ";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
while($res231 = mysqli_fetch_array($exec231))
{
$departmentrefdate=$res231['consultationdate'];
$departmentrefname=$res231['referalname'];
$departmentrefrate=$res231['referalrate'];
$departmentrefref=$res231['refno'];
$reffxrate=$departmentrefrate;
$reffxamount=$departmentrefrate;
$refrate=number_format($refamount/$fxrate,2,'.','');
$refamount=number_format($refrate*1,2,'.','');
$totalfxamount=$totalfxamount+$reffxamount;
$totaldepartmentref=$totaldepartmentref+$departmentrefrate;
$homindtotalamount=$homindtotalamount+$departmentrefrate;
$totalfxref=$totalfxref+$reffxamount; 
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo $departmentrefdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="50"><?php echo $departmentrefref; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="280" id="test">Referral Fee -<?php echo $departmentrefname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="30"><?php echo '1'; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="90"><?php echo number_format($departmentrefrate,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="120"><?php echo number_format($departmentrefrate,2,'.',','); ?></td>
</tr>
<?php } if($homindtotalamount>0){ ?>
  <tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount:</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($homindtotalamount,2); ?></td>
</tr>
<?php }
if(($planpercentage!=0.00)&&($planforall=='yes')){ 
  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund-$labcashcopay-$radcashcopay-$sercashcopay-$raddiscamount-$totalfxrefcopay;
$overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
$overalltotal=number_format($overalltotal,2,'.','');
$consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
$consultationtotal=number_format($consultationtotal,2,'.','');
$netpay= $overalltotal;
$netpay=number_format($netpay,2,'.','');
}
else if(($planpercentage!=0.00)&&($planforall=='')){
// echo $totalser;
   $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund-$labcashcopay-$radcashcopay-$sercashcopay-$raddiscamount-$totalfxrefcopay;
$overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
$consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
$consultationtotal=number_format($consultationtotal,2,'.','');
$netpay= $overalltotal;
$netpay=number_format($netpay,2,'.','');
}
else{
  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay+$consultationrefund-$totalcopayfixedamount-$labcashcopay-$radcashcopay-$sercashcopay-$raddiscamount-$totalfxrefcopay;
$overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
$overalltotal=number_format($overalltotal,2,'.','');
//echo $totalcopay;
$consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
$consultationtotal=number_format($consultationtotal,2,'.','');
$netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$totalambulance+$totalhomecare+$despratetotal;
$netpay= $overalltotal;
$netpay=number_format($netpay,2,'.','');
}
?>
<?php 
			  	//CAPITATION SERVICE LOOP
			  	$capitationamount = 0;
			  	$capitationtotal = $overalltotal;
			  	$query41 = "select iscapitation,serviceitemcode from master_accountname where id = '$res15accountid'";
		  		$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
		  		$res41 = mysqli_fetch_array($exec41);
		  		$iscapitation = $res41['iscapitation'];
                $capservicecode = $res41['serviceitemcode'];
		  		if($iscapitation == 1){
			  	$query40 = "select visitlimit from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
			  	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
			  	$res40 = mysqli_fetch_array($exec40);
			  	$capitationlimit = $res40['visitlimit'];
			  	if($overalltotal < $capitationlimit || $overalltotal > $capitationlimit){
			  		$getbalance = $capitationlimit - $overalltotal;
					
					$queryfx = "select * from master_services where itemcode = '$capservicecode'";
					$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
					$resfx = mysqli_fetch_array($execfx);
					$sername = $resfx['itemname'];
					$wellnesspkg = $resfx['wellnesspkg'];
					$sercode = $resfx['itemcode'];
					$serqty = 1;
					$serrate = $getbalance;
					$serref = $sercode;
					$serratetot = $serrate;
					$capitationamount = $capitationlimit - $getbalance;
					$capitationtotal += $getbalance;
					$serrate = number_format($serrate,2,'.','');
					$perrate = number_format($perrate,2,'.','');
					$colorloopcount = $colorloopcount + 1;
					$showcolor = ($colorloopcount & 1); 
					$totamt=$serrate*$serqty;
					$serfxrate=($serrate*$fxrate);
					$serfxrateqty = $serfxrate*$serqty;
					$totserrate=$totamt;
					$totalser += $getbalance;
					$totalfxser += $getbalance;
					$capitationamount=number_format($capitationamount,2,'.','');
					
					?>
			
			 <tr>
				<td align="left" valign="left" 
			 bgcolor="#ffffff" class="bodytext31">
				<?php echo $consultationdate; ?></td>
				<td align="left" valign="left" 
			 bgcolor="#ffffff" class="bodytext31">
				<?php echo $sercode; ?></td>
				<td align="left" valign="left" 
			 bgcolor="#ffffff" class="bodytext31">
				<?php echo $sername; ?></td>
				<td align="center" valign="left" 
			 bgcolor="#ffffff" class="bodytext31">
				<?php echo '1'; ?></td>
			<td align="right" valign="left" 
			 bgcolor="#ffffff" class="bodytext31">
				<?php echo number_format($serrate,2,'.',','); ?></td>
				<td align="right" valign="left" 
			 bgcolor="#ffffff" class="bodytext31">
				<?php echo number_format($serfxrate,2,'.',','); ?></td>
			</tr>
			  <?php } } ?>
<?php 
$totalpayable = number_format($capitationtotal,2,'.',',');
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
<td  colspan="6" align="left"  valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><span style="font-weight: bold">KES</span> </td>
  </tr>
  <tr>   
<td  align="left" colspan="6" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="100%" id="test">
	 <?php echo str_replace('Kenya Shillings','',$convertedwords); ?>
     </td>
     </tr>
<tr>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Amount(KES):</strong></td>
<td  align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $totalpayable; ?></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
	<td colspan="6" class="bodytext31" align="right">&nbsp;</td>
  </tr>
 <tr>
	<td colspan="6" class="bodytext31" align="center"><strong>This is an Interim Invoice only not final invoice.</strong></td>
 </tr>
 <tr>
	<td colspan="6" class="bodytext31" align="center">&nbsp;</td>
  </tr>
 <tr>
	<td colspan="6" class="bodytext31" align="center">Printed on : <?php echo date('F d, Y H:i:s');?></td>
  </tr>
<tr>
	<td colspan="6" class="bodytext31" align="right">&nbsp;</td>
  </tr><tr>
	<td colspan="6" class="bodytext31" align="right">&nbsp;</td>
  </tr>
</table>
</page>
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
  
	
				  