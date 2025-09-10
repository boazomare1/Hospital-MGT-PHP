<?php
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

ob_start();
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = "";}

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	//$locationcode = $res1["locationcode"];

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
		//$locationcode = $res3["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res3["locationname"];
		$prefix = $res3["prefix"];
		$suffix = $res3["suffix"];

	 $query2 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$billautonumber'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$res2patientname = $res2['patientname'];
	$res2patientcode = $res2['patientcode'];
	$res2visitcode = $res2['visitcode'];
	$res2billnumber = $res2['billnumber'];
	$res2transactionamount = $res2['transactionamount'];
	$res2transactiondate = $res2['transactiondate'];
	$updatedatetime = $res2['transactiondate'];
	$res2transactiontime = $res2['transactiontime'];
	$res2transactiontime = explode(":",$res2transactiontime);
	$res2transactionmode = $res2['transactionmode'];
	$res2username = $res2['username'];
	$res2accountname = $res2['accountname'];
	$res15accountname = $res2['accountname'];
	$res15accountno = $res2['accountnameid'];
	
	$res2username = strtoupper($res2username);
	
	$querymember = "select planpercentage from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
	$execmember = mysqli_query($GLOBALS["___mysqli_ston"], $querymember) or die ("Error in querymember".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resmember = mysqli_fetch_array($execmember);
	//$plancount = mysql_num_rows($execmember);
	 $planpercentage = $resmember['planpercentage'];


 $query44 = "select * from master_customer WHERE customercode = '$res2patientcode' ";
$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));
$num44 = mysqli_num_rows($exec44);
$res44 = mysqli_fetch_array($exec44);
$res44accountname = $res44['accountname'];
$res44customerfullname = $res44['customerfullname'];
$res44subtype = $res44['subtype'];

$query441 = "select subtype from master_subtype WHERE auto_number = '$res44subtype' ";
$exec441 = mysqli_query($GLOBALS["___mysqli_ston"], $query441) or die ("Error in Query441".mysqli_error($GLOBALS["___mysqli_ston"]));
$num441= mysqli_num_rows($exec441);
$res441 = mysqli_fetch_array($exec441);
$res2subtype = $res2['subtype'];

$query15 = "select * from master_accountname where auto_number = '$res44accountname'";
$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
$res15 = mysqli_fetch_array($exec15);
//$res15accountname = $res15['accountname'];
//$res15accountno = $res15['id'];
  
$query4 = "select sum(totalamount) as totalamount1 from billing_paylaterconsultation where billno = '$res2billnumber' and visitcode = '$res2visitcode'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$res4totalamount = $res4['totalamount1'];

 $querycr = "select * from refund_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' ";
	$execcr = mysqli_query($GLOBALS["___mysqli_ston"], $querycr) or die ("Error in Querycr".mysqli_error($GLOBALS["___mysqli_ston"]));
	$numcr=mysqli_num_rows($execcr);
	$rescr = mysqli_fetch_array($execcr);
	$rescrconsultation = $rescr['consultation'];
	
	if($planpercentage>0.00){ $concopay=($res4totalamount/100)*$planpercentage; $res4totalamount=$res4totalamount-$concopay;}
	if($numcr>0){ $res4totalamount=$res4totalamount+$rescrconsultation;}

$query5 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
$res5 = mysqli_fetch_array($exec5);
//echo $num = mysql_num_rows($exec5);
$res5amount = $res5['amount1'];

$query8 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$res8labitemrate = $res8['labitemrate1'];

$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9radiologyitemrate = $res9['radiologyitemrate1'];

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

$query11 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));
$res11 = mysqli_fetch_array($exec11);
$res11servicesitemrate = $res11['servicesitemrate1'];

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

$queryopmis = "select sum(amount) as opmiscrate from billing_opmisc where  patientvisitcode = '$res2visitcode'";
$execopmis = mysqli_query($GLOBALS["___mysqli_ston"], $queryopmis) or die ("Error in Queryopmis". mysqli_error($GLOBALS["___mysqli_ston"]));
$resopmis = mysqli_fetch_array($execopmis);
$opmiscrate = $resopmis['opmiscrate'];



$queryopdiscount = "select sum(rate) as opdiscountrate from billing_opdiscount where  patientvisitcode = '$res2visitcode'";
$execopdiscount = mysqli_query($GLOBALS["___mysqli_ston"], $queryopdiscount) or die ("Error in Queryopdiscount". mysqli_error($GLOBALS["___mysqli_ston"]));
$resopdiscount = mysqli_fetch_array($execopdiscount);
$opdiscountrate = $resopdiscount['opdiscountrate'];

$querymember = "select * from master_customer where customercode='$res2patientcode'";
$execmember = mysqli_query($GLOBALS["___mysqli_ston"], $querymember) or die ("Error in querymember".mysqli_error($GLOBALS["___mysqli_ston"]));
while($resmember = mysqli_fetch_array($execmember)){
$resmemberno = $resmember['mrdno'];
}
$credit = $res12transactionamount + $res13transactionamount;

$rescreditnote = 0.00;

$querycreditnote = "select * from ip_creditnote where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and locationcode = '$locationcode'";
$execcredit = mysqli_query($GLOBALS["___mysqli_ston"], $querycreditnote) or die ("Error in querycreditnote".mysqli_error($GLOBALS["___mysqli_ston"]));
while($rescredit = mysqli_fetch_array($execcredit)){
$rescredit1 = $rescredit['totalamount'];
$rescreditnote += $rescredit1;
}
include("print_header.php");
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
</style>

 <table width="100%" border="" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width=""><strong>Name : </strong></td>
    <td width="400" colspan="2"><?php echo $res2patientname; ?></td>
    <td class="bodytext32"><strong>&nbsp;&nbsp;Bill No: </strong></td>
    <td align="left" colspan="2"><?php echo $billautonumber; ?></td>
  </tr>
  <tr>
    <td><strong>Reg No: </strong></td>
    <td colspan="2"><?php echo $res2patientcode; ?></td>
	<td class="bodytext32"><strong>&nbsp;&nbsp;Bill Date: </strong></td>
	<td class=""><?php echo date("d/m/Y", strtotime($updatedatetime)); ?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td><span style="font-weight: bold">&nbsp;&nbsp;OP Visit No</span> : </td>
    <td colspan="2"><?php echo $res2visitcode; ?></td>

  </tr>
  <tr>
  	<td align="left" valign="middle" width=""><span style="font-weight: bold">Account: </span></td>
    <td class= "" align="left" width="250" valign="middle" colspan=""><?php echo nl2br($res15accountname); ?></td>
    <td valign="middle"><strong>A/c No: </strong><?php echo "$res15accountno";?></td>
    
    
    <td rowspan="2" colspan="3" width="50%">
    	<table width="50%" border="0" cellpadding="0" cellspacing="5" align="left">
            <tr>
                <td width="auto" align="left" ><strong>Consultation Amount:</strong></td>
                <td align="right" ><?php echo number_format($res4totalamount,2,'.',','); ?></td>
            </tr>
            <tr>
              <td align="left"><strong>Pharmacy Amount:</strong></td>
              <td align="right" ><?php echo number_format($res5amount,2,'.',','); ?></td>
            </tr>
            <tr>
              <td align="left"><strong>Lab Amount:</strong></td>
              <td align="right" ><?php echo number_format($res8labitemrate,2,'.',','); ?></td>
            </tr>
            <tr>
              <td align="left" ><strong>Radiology Amount:</strong></td>
              <td align="right"><?php echo number_format($res9radiologyitemrate,2,'.',','); ?></td>
            </tr>
            
            <tr>
              <td align="left"><strong>Referral Amount:</strong></td>
              <td align="right"><?php echo number_format($res10referalrate,2,'.',','); ?></td>
            </tr>
            <tr>
              <td align="left"><strong>Service Amount:</strong></td>
              <td align="right"><?php echo number_format($res11servicesitemrate,2,'.',','); ?></td>
            </tr>
            <tr>
              <td align="left"><strong>Credit Notes Amount:</strong></td>
              <td align="right"><?php echo $rescreditnote; ?></td>
            </tr>
               <tr>
              <td align="left"><strong>Credit Amount:</strong></td>
              <td align="right">-<?php echo number_format($opdiscountrate,2,'.',','); ?></td>
            </tr>
            <tr>
              <td align="left"><strong>Debit Amount:</strong></td>
              <td align="right"><?php echo $opmiscrate; ?></td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td width="" align="left"><strong>Catagory: </strong></td>
    <td align="left" width="250" colspan="2"><?php echo nl2br($res2subtype); ?></td> 
  </tr>
  <tr>
    <td width="" align="left"><strong>Membership No: </strong></td>
    <td align="left" width="200" colspan=""><?php echo $resmemberno; ?></td> 
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  </table>
  <table width="100%"  cellpadding="0" cellspacing="0" align="center">
  
   <thead>
  <tr>
    <td colspan="6" width="725" align="center"><strong><?php echo 'DETAILED INVOICE'; ?></strong></td>
  </tr>

 <tr>
   <td colspan="6" align="left">&nbsp;</td>
   </tr>
  
  <tr>
	<td width="auto" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31 border"><strong>BILL DATE</strong></td>
	<td width="auto" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>REF No.</strong></td>
	<td width="auto"  align="left" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>DESCRIPTION</strong></td>
	<td width="auto"align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>QTY</strong></td>
	<td width="auto"  align="right" valign="center" 
	 bgcolor="#ffffff" class="bodytext31 border"><strong>RATE</strong></td>
	<td width="auto"  align="right" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>AMOUNT</strong></td>
  </tr>
  </thead>
  <tbody>
<?php
if($res4totalamount !='')
{
?>
	<tr>
		 <td colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" class="bodytext31" valign="center"  align="left">
		<strong>Consultation</strong></td>
	</tr>
	
<?php 
$query17 = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res17 = mysqli_fetch_array($exec17))
{
$res17consultationfee=$res17['consultationfees'];
$res17viscode=$res17['visitcode'];
$res17consultationdate=$res17['consultationdate'];

 $res17planpercentage=$res17['planpercentage'];
  $plannumber = $res17['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];

$res17quantity = '1.00';
 $res17total = $res17consultationfee/$res17quantity;
 $copayconsult = ($res17consultationfee/100)*$res17planpercentage;
$copaytotalconsult = $res17total-$copayconsult;
//$res41billdate = $res41bill['billdate'];
?>

<tr>
	<td  align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res17consultationdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" ><?php echo $res17viscode; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" ><?php echo 'OP Consultation'; ?></td>
	<td align="center" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res17quantity; ?></td>
    <td align="right" valign="right" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res17consultationfee,2,'.',','); ?></td>
	<td align="right" valign="right" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res17total,2,'.',','); ?></td>
</tr>
<?php
if($copayconsult!=0.00){
	
?>

<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayconsult,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayconsult,2,'.',','); ?></td>
	</tr>
<?php
}
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

if($res18copayfixedamount!=0.00){
	
?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billingdatetime; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Fixed Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18quantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($res18copayfixedamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$res18total,2,'.',','); ?></td>
	</tr>
<?php 
}
}
	$query11 = "select * from refund_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num=mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11billnumber = $res11['billnumber'];
	$consultationrefund = $res11['consultation'];
	$res11transactiondate= $res11['billdate'];
?><?php if($num>'0.00'){?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billingdatetime; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Consultation Refund'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1.00'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($consultationrefund,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($consultationrefund,2,'.',','); ?></td>
	</tr>
    
<?php }

$subtotal = $res17consultationfee-$copayconsult-$res18copayfixedamount+$consultationrefund;
?>

<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php //echo $res18billingdatetime; ?>	  </td>
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
	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format($subtotal,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php
if($res5amount != '')
{
?>
<tr>
	<td>
	<strong>Pharmacy</strong>	</td>
</tr>
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


$query199 = "select * from master_consultationpharm where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and medicinecode = '".$res19medicinecode."' order by auto_number desc";
$exec199 = mysqli_query($GLOBALS["___mysqli_ston"], $query199) or die ("Error in Query199".mysqli_error($GLOBALS["___mysqli_ston"]));
$res199 = mysqli_fetch_array($exec199);
$res199rate = $res199['rate'];
$res199referalno=$res199['refno'];
 $res199amount = $res199['amount'];
$copaypharm = (($res199rate*$res19quantity)/100)*$res17planpercentage;

$resqtymedrate=$res199rate*$res19quantity;
$res19amount1 = $res19amount1 + $resqtymedrate;


?>

<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php echo $res19billdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo $res199referalno; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res19medicinename; ?></td>
	<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res19quantity; ?></td>
    <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($res199rate,2,'.',','); ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($resqtymedrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $totalcopaypharm=$totalcopaypharm+$copaypharm;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copaypharm,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copaypharm,2,'.',','); ?></td>
	</tr>
<?php
}
}
if($medno>0)
{
$query194 = "select amount from billing_paylaterpharmacy where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber' and medicinename = 'DISPENSING'";
$exec194 = mysqli_query($GLOBALS["___mysqli_ston"], $query194) or die ("Error in Query194".mysqli_error($GLOBALS["___mysqli_ston"]));
$medno4=mysqli_num_rows($exec194);
$res194 = mysqli_fetch_array($exec194);
$dispamt = $res194['amount'];
if($updatedatetime<'2016-01-01')
{
	$dispamt = 30.00;
}
else
{
$dispamt = 40.00;
}
?>

<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php echo $res19billdate; ?></td>
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
	 <?php echo $dispamt; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo $dispamt; $res19amount1=$res19amount1+$dispamt;?></td>
     
</tr>
<?php if($planforall=='yes'){$despamount = (40/100)*$res17planpercentage;  $totalcopaypharm=$totalcopaypharm+$despamount;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>

		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($despamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$despamount,2,'.',','); ?></td>
	</tr>
<?php
}  }?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 
		<?php //echo $res18billingdatetime; ?>	 </td>
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
	 <strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($res19amount1=$res19amount1-$totalcopaypharm,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php 
if($res8labitemrate != '')
{
?>
<tr>
	<td>
	<strong>Laboratory</strong>	</td>
</tr>

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

$res20amount1 = '0.00';
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
$res20amount1 = $res20amount1 + $res20amount;

$query200 = "select * from consultation_lab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and labitemcode = '".$res20labitemcode."'";
$exec200 = mysqli_query($GLOBALS["___mysqli_ston"], $query200) or die ("Error in Query200".mysqli_error($GLOBALS["___mysqli_ston"]));
$res200 = mysqli_fetch_array($exec200);
$res200referalno=$res200['refno'];
 $res200labitemrate = $res200['labitemrate'];
 $res20amount = $res200labitemrate/$res20quantity;
$res200labitemratetotal=$res200labitemratetotal+$res200labitemrate;
 $copaylab = ($res200labitemrate/100)*$res17planpercentage;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res20billdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res200referalno; ?></td>
	<td align="left" valign="left" width="90" 
	 bgcolor="#ffffff" class="bodytext31">
<?php echo $res20labitemname; ?></td>
	<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res20quantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format($res20amount,2,'.',','); ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format($res200labitemrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copaylab,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copaylab,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 
		<?php //echo $res18billingdatetime; ?>	 </td>
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
	 <strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($res20amount1,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php 
if($res9radiologyitemrate != '')
{
?>
<tr>
	<td>
	<strong>Radiology</strong>	</td>
</tr>
<?php 
$res21amount1 = '0.00';
$res211referalratetotal='';
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
$res21amount1 = $res21amount1 + $res21amount;

$query211 = "select * from consultation_radiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'  and radiologyitemcode = '".$res21radiologyitemcode."'";
$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
$res211 = mysqli_fetch_array($exec211);
$res211referal=$res211['refno'];
$res211referalrate = $res211['radiologyitemrate'];
$res21amount = $res211referalrate/$res21quantity;
$res211referalratetotal = $res211referalratetotal+$res211referalrate;
$copayrad = ($res211referalrate/100)*$res17planpercentage;
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res21billdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res211referal; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res21radiologyitemname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res21quantity; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res21amount,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res211referalrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayrad,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayrad,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">		<?php //echo $patientcode; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">		<?php //echo 'Copay Amount'; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php //echo $res18quantity; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res21amount1,2,'.',','); ?></td>
</tr>



<?php
}
?>

<?php
if($res10referalrate != '')
{
?>
<tr>
	<td>
<strong>Referral</strong>	</td>
</tr>
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

//$res22referalrateamt = $res22['referalamount'];
$res22referalrateamt = $res22['referalrate'];

$res22amount = $res22referalrateamt/$res22quantity;
$res22amount1 = $res22amount1 + $res22amount;

$query222 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
$res222 = mysqli_fetch_array($exec222);
$res222referalno=$res222['refno'];

$copayref = ($res22referalrateamt/100)*$res17planpercentage;


?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res22billdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res222referalno; ?></td>
<td width="auto" align="left" valign="left" bgcolor="#ffffff" class="bodytext31">	<?php echo $res22referalname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res22quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res22referalrateamt,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res22amount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayreftotal=$copayreftotal+$copayref;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayref,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayreftotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
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
<tr>
	<td>
<strong>OP Ambulance</strong>	</td>
</tr>
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

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227billdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227referalno; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227referalname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2227referalrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2227amount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayambtotal=$copayambtotal+$copayopamb;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayopamb,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayambtotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
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
<tr>
	<td>
<strong>Homecare</strong>	</td>
</tr>
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

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2222billdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res222referalno; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2222referalname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2222quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2222referalrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2222amount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayhomtotal=$copayhomtotal+$copayhom;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayhom,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayhomtotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res2222amount1=$res2222amount1-$copayhomtotal,2,'.',','); ?></td>
</tr>
<?php
}
?>


<?php
if($res11servicesitemrate != '')
{
?>
<tr>
	<td>
	<strong>Service</strong></td>
</tr>
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

$res23amount1 = '0.00';
$res23servicesitemratetotal='';
$copaysertotal='';
$query23 = "select * from billing_paylaterservices where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber' group by servicesitemcode";
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
			 $servicesitemrate=$resqty['servicesitemrate'];
			 $seramount=$resqty['amount'];
/*$res23servicesitemamount = $res23servicesitemrate*$numrow2111;*/

$res23servicesitemamount = $seramount;

$res23amount = $res23servicesitemamount;
$res23amount1 = $res23amount1 + $res23amount;

$query233 = "select * from consultation_services where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and servicesitemcode = '".$res23servicesitemcode."'";
$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
$res233 = mysqli_fetch_array($exec233);
$numrow233 = mysqli_num_rows($exec233);
$res233referal=$res233['refno'];

 $res233serviceitemrate = $res233['servicesitemrate'];
$res23servicesitemrate = $res233serviceitemrate;
//$res23servicesitemratetotal1=$res23servicesitemrate*$serqty;
$res23servicesitemratetotal1=$seramount;
$res23servicesitemratetotal = $res23servicesitemratetotal+$res23servicesitemratetotal1;
$copayser = ($res233serviceitemrate/100)*$res17planpercentage;
$copayser1 = (($res233serviceitemrate*$serqty)/100)*$res17planpercentage;
$copaysertotal=$copaysertotal+$copayser1;
?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res23billdate; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res233referal; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res23servicesitemname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $serqty; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23servicesitemrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23servicesitemratetotal1,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayser,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayser1,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">		<?php //echo $patientcode; ?>    </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	
		<?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23amount1,2,'.',','); ?></td>
</tr>
<?php
}
?>


<?php
$totalopdiscount=0;

if($opdiscountrate != '')
{
?>
<tr>
	<td>
<strong>OP Credit</strong>	</td>
</tr>
<?php 
$totalopdiscount=0;
$copayhomtotal='';
$copayhom='';
$query2 = "select * from billing_opdiscount where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res2 = mysqli_fetch_array($exec2))
{
			$opdiscountdate = $res2['billdate'];
			$opdiscountdescription = $res2['description'];
			$opdiscountrate=$res2['rate'];
			$opdiscountamount=$res2['rate'];
			$opdiscountdcono=$res2['docno'];
			$quantity='1';
			$totalopdiscount=$totalopdiscount + $opdiscountrate;
$copayhom = (($opdiscountrate*$quantity)/100)*$res17planpercentage;

// $totalopdiscount=$totalopdiscount-$copayhomtotal;

?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $opdiscountdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $opdiscountdcono; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo wordwrap($opdiscountdescription, 30,"<br />\n" );?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($opdiscountrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	-<?php echo number_format($opdiscountrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayhomtotal=$copayhomtotal+$copayhom;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayhom,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayhomtotal,2,'.',','); ?></td>
	</tr>
<?php

}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">-<?php echo number_format($totalopdiscount,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php
$totalopmisc=0;
if($opmiscrate != '')
{
?>
<tr>
	<td>
<strong>OP Debit</strong>	</td>
</tr>
<?php 

$copayhomtotal='';
$copayhom='';
$query2 = "select * from billing_opmisc where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res2 = mysqli_fetch_array($exec2))
{
			$opmiscdate = $res2['billdate'];
			$opmiscdescription = $res2['description'];
			$opmiscrate=$res2['rate'];
			$opmiscamount=$res2['amount'];
			$opmiscdcono=$res2['docno'];
			$opmiscunits=$res2['units'];
			
			$totalopmisc=$totalopmisc+$opmiscamount;
$copayhom = (($opmiscrate*$opmiscunits)/100)*$res17planpercentage;


?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $opmiscdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $opmiscdcono; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo wordwrap($opmiscdescription, 30,"<br />\n" ); ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $opmiscunits; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($opmiscrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($opmiscamount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayhomtotal=$copayhomtotal+$copayhom;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayhom,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayhomtotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($totalopmisc=$totalopmisc-$copayhomtotal,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php 

$totalpayable = '';
$grandtotal = '';
$grandtotal = $subtotal + $res19amount1 + $res20amount1 + $res21amount1 + $res22amount1 + $res23amount1+$res222amount1+$res2222amount1+$totalopmisc - $totalopdiscount ;
$totalpayable = $grandtotal - $rescreditnote ;
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
<td width="auto" align="left" colspan="4" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Total Amount:</strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $grandtotal; ?></td>
</tr>
<tr>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Credits:</strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($rescreditnote,2,'.',','); ?></td>
</tr>
<tr>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Amount Payable:</strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $totalpayable; ?></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td width="auto" align="left" valign="middle" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Served By: </strong></td>
<td width="auto" align="left" valign="middle" colspan="5"
	 bgcolor="#ffffff" class="bodytext31"><?php echo strtoupper($res2username); ?></td>
</tr>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">    <?php //echo $res18billingdatetime; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">    <?php //echo $patientcode; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">    <?php //echo 'Copay Amount'; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php //echo $res18quantity; ?></td>
<td colspan="2" align="right" valign="left" 
	 bgcolor="#ffffff"><strong><?php //echo ' '.$res2transactiondate.' '.$res2transactiontime[0].':'.$res2transactiontime[1]; ?></strong></td>
</tr>

</table>


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
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_paylater.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	?>


  
	
				  

