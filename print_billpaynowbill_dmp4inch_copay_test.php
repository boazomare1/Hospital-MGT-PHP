<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

/*	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = $res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];*/
	
	include('convert_currency_to_words.php');
	
	$query11 = "select * from master_transactionpaynow where billnumber = '$billautonumber' and patientcode = '$patientcode'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	mysqli_num_rows($exec11);
	$res11 = mysqli_fetch_array($exec11);
	$res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	$res11billingdatetime = $res11['transactiondate'];
	$res11patientpaymentmode = $res11['transactionmode'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
	$res11transactionamount = $res11['transactionamount'];
	$convertedwords = covert_currency_to_words($res11transactionamount); 
    $res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11updatetime= $res11['transactiontime'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
	$res11locationcode = $res11['locationcode'];
	
	$queryuser="select employeename from master_employee where username='$res11username'";
		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resuser = mysqli_fetch_array($execuser);
		$res11username=$resuser['employeename'];
?>

<?php 
$query2 = "select * from master_location where locationcode = '$res11locationcode'";
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
?>
<style type="text/css">
.bodytext31 { FONT-SIZE: 8px; COLOR: #000000; }
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext34 { FONT-SIZE: 9px; COLOR: #000000; vertical-align:bottom;}
table {
   display: table;
   width: 100%;
   table-layout: fixed;
   border-collapse:collapse;
}
.tableborder{
   border-collapse:collapse;
   border:1px solid black;}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; text-decoration:underline;}
border{border:1px solid #000000; }
borderbottom{border-bottom:1px solid #000000;}
</style>

<table width="100%"  border="" align="center" cellpadding="0" cellspacing="0">
	<tr><td colspan="" width="375">&nbsp;</td></tr>
		<tr valign="middle">
			<td colspan="" class="bodytext32" align="center" ><?php echo "".$locationname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
            </td>
            </tr>
            <tr valign="middle">
			<td colspan="" class="bodytext32" align="center" >
				<?php echo "TEL: ".$phonenumber1; ?>
		        <?php
			/*$address3 = "TEL: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}*/
			?></td>
		</tr>
		<!--<tr>
			<td colspan="4" class="bodytext32"><div align="center"><?php //echo $address1; ?>
		      <?php
/*			$address2 = $area.''.$city.' - '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}*/
			?>		
		    </div></td>
		</tr>-->
		

  <!--<tr>
    <td>Consultation Charges:</td>
    <td width="125" align="right"><strong><?php //echo $res11subtotalamount; ?></strong></td>
  </tr>-->
  
</table>
<table width="100%"  border="" align="center" cellpadding="0" cellspacing="0">
<tr><td class="" colspan="4" width="375">&nbsp;</td></tr>
	<tr>
    	<td class="bodytext32" >Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $res11patientfirstname; ?></td>
        <td  class="bodytext32">Bill No: </td>
        <td  class="bodytext34"><?php echo $res11billnumber; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Reg. No: </td>
        <td colspan="" class="bodytext34"><?php echo $res11patientcode; ?></td>
        <td class="bodytext32">Bill Date: </td>
		<td class="bodytext34"><?php echo date("d/m/y", strtotime($res11billingdatetime)); ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">OPVisit No: </td>
        <td colspan="3" class="bodytext34"><?php echo $res11visitcode; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
    </table>
    <table width=""  border="" align="center" cellpadding="0" cellspacing="0">
  <tr>
	 <td align="center" class="bodytext32 border" width="30">S.No</td>
	  <td align="center" class="bodytext32 border" width="65%"><strong>Description</strong></td>
	  <td align="center" class="bodytext32 border" width="5%"><strong>Qty</strong></td>
	  <td align="right" class="bodytext32 border" width="10%"><strong>Rate</strong></td>
    <td align="right" class="bodytext32 border" width="10%"><strong>Amount</strong></td>
  </tr>
  
   <?php
   $totalcopay='';
   $labrate='';
   $query14 = "select planpercentage,planname,subtype from master_visitentry where locationcode='$locationcode' and visitcode = '$res11visitcode' and patientcode = '$res11patientcode'  ";
			$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res14 = mysqli_fetch_array($exec14);
			 $planpercent=$res14['planpercentage'];
			 $plannumber = $res14['planname'];
			 $subtype = $res14['subtype'];
			 
			$query47="select * from master_subtype where auto_number='$subtype'";
			$exec47=mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res47=mysqli_fetch_array($exec47);
			$subtype=$res47['subtype'];
			$currency = $res47['currency'];
			 
			 $query = mysqli_query($GLOBALS["___mysqli_ston"], "select rate from master_currency where currency = '$currency'");
			$res = mysqli_fetch_array($query);
			$num = mysqli_num_rows($query);
			if($num > 0){
			$fxrate = $res['rate'];
			} else {
			$fxrate = '1';
			}
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
   
   
			$colorloopcount = '';
			$sno = '';
			
			$query1 = "select * from billing_paynowlab where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
		    $res1labitemname = $res1['labitemname'];
			$res1labitemrate = $res1['labitemrate'];
			
			$colorloopcount = $colorloopcount + 1;
			$sno =$sno + 1;
			
			
			$showcolor = ($colorloopcount & 1); 

			
			$res1labitemcode = $res1['labitemcode'];
			$query2con = "select * from consultation_lab where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and labitemcode = '".$res1labitemcode."'";
			$exec2con = mysqli_query($GLOBALS["___mysqli_ston"], $query2con) or die ("Error in Query2con".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2con = mysqli_fetch_array($exec2con);
			$actlabrate = $res2con['labitemrate'];
			
			 $labrate = $labrate+$actlabrate;
			
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
			?>
			  <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo nl2br($res1labitemname); ?></td>
				<td class="bodytext34 border" valign="center"  align="center">
			   <?php echo 1; ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php echo number_format($actlabrate,2,'.',','); ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php echo number_format($actlabrate,2,'.',','); ?></td>
              </tr>
              <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=$res1labitemrate; echo '-',number_format($copay,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}}
			?>
			
			<?php
			$colorloopcount = '';
			$radrate='';
			
			$query2 = "select * from billing_paynowradiology where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
		    $res2radiologyitemname = $res2['radiologyitemname'];
			$res2radiologyitemrate = $res2['radiologyitemrate'];
			
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			
			$res2radiologyitemcode = $res2['radiologyitemcode'];
			$query2con = "select * from consultation_radiology where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and radiologyitemcode = '".$res2radiologyitemcode."'";
			$exec2con = mysqli_query($GLOBALS["___mysqli_ston"], $query2con) or die ("Error in Query2con".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2con = mysqli_fetch_array($exec2con);
			$actradrate = $res2con['radiologyitemrate'];
			
			$radrate = $radrate+$actradrate;
			
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
			?>
			   
			 <?php if($res2radiologyitemrate != '0.00' ) { ?>
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			 <?php echo nl2br($res2radiologyitemname); ?></td>
				<td class="bodytext34 border" valign="center"  align="center">
			<?php echo 1; ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			   <?php echo number_format($actradrate,2,'.',','); ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			   <?php echo number_format($actradrate,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=$res2radiologyitemrate; echo '-',number_format($res2radiologyitemrate,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			  
			}  }
			?>
			
			<?php
			$colorloopcount = '';
			$serrate='';
			
			$query3 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' group by servicesitemcode";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res3 = mysqli_fetch_array($exec3))
			{
		    $res3servicesitemname = $res3['servicesitemname'];
			$res3servicesitemrate = $res3['servicesitemrate'];
			$res3servicesitemcode = $res3['servicesitemcode'];
			$res3serviceqty = $res3['serviceqty'];
			$res3serviceamount = $res3['amount'];
			$res3serviceserviceqty = $res3serviceqty;
			/*$query2111 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode='$res11visitcode' and patientcode='$res11patientcode' and servicesitemcode = '$res3servicesitemcode' and billnumber = '$res11billnumber'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			
			$res3serviceserviceqty = $res3serviceqty;
			if($res3serviceserviceqty==0){$res3serviceserviceqty=$numrow2111;}
			$res3servicesitemamount = $res3['amount'];
			if($res3servicesitemamount==0){
			$res3servicesitemamount = $res3servicesitemrate*$numrow2111;
			}*/
			
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			//$res2radiologyitemcode = $res2['radiologyitemcode'];
			$query2con = "select * from consultation_services where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and servicesitemcode = '".$res3servicesitemcode."'";
			$exec2con = mysqli_query($GLOBALS["___mysqli_ston"], $query2con) or die ("Error in Query2con".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2con = mysqli_fetch_array($exec2con);
			$actserrate = $res2con['servicesitemrate'];
			$actseramount = $res2con['amount'];
			
			$serrate = $serrate+$actseramount;
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
			?>
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			  <?php echo nl2br($res3servicesitemname); ?></td>
				<td class="bodytext34 border" valign="center"  align="center">
			  <?php echo $res3serviceserviceqty; ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($actserrate,2,'.',','); ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($actseramount,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=$res3serviceamount; echo '-',number_format($copay,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			  
			  
			}
			?>
			<?php
			$colorloopcount = '';
			$refrate='';
			
			$query5 = "select * from billing_paynowreferal where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber'  ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
		    $res3referalname = $res5['referalname'];
			$res3referalrate = $res5['referalrate'];
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			
			$res2referalitemcode = $res2['referalcode'];
			$query2con = "select * from consultation_referal where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and referalname = '".$res3referalname."'";
			$exec2con = mysqli_query($GLOBALS["___mysqli_ston"], $query2con) or die ("Error in Query2con".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2con = mysqli_fetch_array($exec2con);
			$actrefrate = $res2con['referalrate'];
			//$actrefamount = $res2con['amount'];
			
			$refrate=$refrate+$actrefrate;
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
			?>
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			 <?php echo nl2br("Referral Fee - ".$res3referalname); ?></td>
				<td class="bodytext34 border" valign="center"  align="center">
			  <?php echo 1; ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($actrefrate,2,'.',','); ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($actrefrate,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=$res3referalrate; echo '-',number_format($copay,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			}
			?>
            
            <!--opambulance-->
            <?php
			$colorloopcount = '';
			$refrate='';
			
			$query5 = "select * from billing_opambulance where locationcode='$locationcode' and visitcode = '$res11visitcode' and patientcode = '$res11patientcode'   ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
		    $res3referalname = $res5['description'];
			$res3referalrate = $res5['rate'];
			$resaquantity = $res5['quantity'];
			$resaamount = $res5['amount'];
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$refrate=$refrate+($res3referalrate*$resaquantity);
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
			?>
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			 <?php echo nl2br("Op Ambulance - ".$res3referalname); ?></td>
				<td class="bodytext34 border" valign="center"  align="center">
			  <?php echo $resaquantity; ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($res3referalrate,2,'.',','); ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($res3referalrate*$resaquantity,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=(($res3referalrate*$resaquantity)/100)*$planpercent; echo '-',number_format($copay,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			}
			?>
            
             <?php
			$colorloopcount = '';
			$refrate='';
			
			$query5 = "select * from billing_homecare where locationcode='$locationcode' and visitcode = '$res11visitcode' and patientcode = '$res11patientcode'   ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
		    $res3referalname = $res5['description'];
			$res3referalrate = $res5['rate'];
			$resaquantity = $res5['quantity'];
			$resaamount = $res5['amount'];
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$refrate=$refrate+($res3referalrate*$resaquantity);
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
			?>
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			 <?php echo nl2br("Homecare - ".$res3referalname); ?></td>
				<td class="bodytext34 border" valign="center"  align="center">
			  <?php echo $resaquantity; ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($res3referalrate,2,'.',','); ?></td>
				<td class="bodytext34 border" valign="center"  align="right">
			 <?php echo number_format($res3referalrate*$resaquantity,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=(($res3referalrate*$resaquantity)/100)*$planpercent; echo '-',number_format($copay,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			}
			?>
             
			<?php
			$colorloopcount = '';
			$pharmrate='';
			
			$query4 = "select * from billing_paynowpharmacy where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' and medicinecode<>'DISPENS'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res4 = mysqli_fetch_array($exec4))
			{
		    $res4medicinename = $res4['medicinename'];
			$res4amount1 = $res4['amount'];
			$res4quantity = $res4['quantity'];
			 $res4rate = $res4['rate'];
			 
			
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$medamount=$res4rate*$res4quantity;
		
			
			 $res4medicinecode = $res4['medicinecode'];
			$query2con = "select * from master_consultationpharm where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and medicinecode = '".$res4medicinecode."'";
			$exec2con = mysqli_query($GLOBALS["___mysqli_ston"], $query2con) or die ("Error in Query2con".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2con = mysqli_fetch_array($exec2con);
				$actmedrate = $res2con['rate'];
				$actmedrateamount = $res2con['amount'];
		
			$pharmrate=$pharmrate+$actmedrateamount;
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
			?>
            <?php if($res4medicinename!='Dispensing Fee'){?>
			  <tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			    <td class="bodytext34 border" valign="center"  align="left"><?php echo nl2br($res4medicinename); ?></td>
			    <td class="bodytext34 border" valign="center"  align="center"><?php echo $res4quantity; ?></td>
			    <td class="bodytext34 border" valign="center"  align="right"><?php echo number_format($res4rate,2,'.',','); ?></td>
			    <td class="bodytext34 border" valign="center"  align="right"><?php echo number_format($medamount,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php $copay=$res4amount1; echo '-',number_format($copay,2,'.',','); $totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			
			}
			?>
			
			<?php
			    }
				?>
                <?php
			$colorloopcount = '';
			$desprate='';
			
			$query4 = "select * from billing_paynowpharmacy where locationcode='$locationcode' and patientvisitcode = '$res11visitcode' and patientcode = '$res11patientcode' and billnumber = '$res11billnumber' and medicinecode='DISPENS'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res4 = mysqli_fetch_array($exec4))
			{
		    $res4medicinename = $res4['medicinename'];
			$res4amount1desp = $res4['amount'];
			$res4quantity = $res4['quantity'];
			 $res4rate = $res4['rate'];
			$sno =$sno + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$medamount=$res4rate*$res4quantity;
			$desprate=$desprate+$medamount;
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
			
				$res4amount1desp=0;
				$desprate=$res4amount1desp;
				if($planforall=='yes')
				{ $desprate=($res4amount1desp/100)*$planpercent;}
				
			?>
            
              
			  <?php
			
			
			 ?>
			<tr <?php //echo $colorcode; ?>>
              <td class="bodytext34 border" valign="center"  align="center" width="10%">
			   <?php echo $sno; ?></td>
			    <td class="bodytext34 border" valign="center"  align="left"><?php echo nl2br($res4medicinename); ?></td>
			    <td class="bodytext34 border" valign="center"  align="center"><?php echo $res4quantity; ?></td>
			    <td class="bodytext34 border" valign="center"  align="right"><?php echo number_format($res4amount1desp,2,'.',','); ?></td>
			    <td class="bodytext34 border" valign="center"  align="right"><?php echo number_format($res4amount1desp,2,'.',','); ?></td>
              </tr>
               <?php  if($planforall=='yes'){?>
               <tr <?php //echo $colorcode; ?>>
              	<td class="bodytext34 " valign="center"  align="center">
			   <?php echo $sno=$sno+1; ?></td>
			   <td class="bodytext34 border" valign="center"  align="left" >
			   <?php echo "COPAY"; ?></td>
				<td class="bodytext34 border" valign="center"  align="center">&nbsp;
			   </td>
				<td class="bodytext34 border" valign="center"  align="right">
			  <?php  ?></td>
				<td  align="right" valign="center" class="bodytext34 border">
			   <?php  $copay=$desprate; echo '-',number_format($copay,2,'.',','); //$totalcopay=$totalcopay+$copay;?></td>
              </tr>
			  <?php
			}
			 }
			    
				?>

	          <!--<tr>
	            <td>&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
	            <td align="right">&nbsp;</td>
  </tr>-->
    <tr>
		<td align="right " colspan="4" class="bodytext32">Bill Amount:</td>
		<td align="right " class="bodytext34"><?php if($planforall=='yes'){ echo number_format($totalcopay+$desprate,2,'.',',');}
		else{ echo number_format(($labrate+$radrate+$serrate+$pharmrate+$refrate+$desprate),2,'.',',');}
		 ?></td>
	</tr> 
	<tr>
		<td align="right " colspan="4" class="bodytext32">Fx Amount:</td>
		<td align="right " class="bodytext34"><?php if($planforall=='yes'){ echo number_format(($totalcopay+$desprate)*$fxrate,2,'.',',');}
		else{ echo number_format(($labrate+$radrate+$serrate+$pharmrate+$refrate+$desprate)*$fxrate,2,'.',',');} ?></td>
	</tr> 
	<tr>
		<td colspan="5" width="375">&nbsp;</td>
	</tr>
    </table>
<table width="100%"  align="center" cellpadding="0" cellspacing="0">
	
 <?php if($res11cashgivenbycustomer != 0.00) { ?> 
 	<tr><td colspan="5" class="bodytext33">Payment Mode:</td></tr>
    <tr>
		<td class="bodytext32"  ><strong>Cash Received:</strong></td>
        <td align="right"  class="bodytext34" valign="middle"><?php  echo number_format($res11cashgivenbycustomer,2,'.',',');?></td>
		<td align="right" width="">&nbsp;</td>
		<td align="right" width="">&nbsp;</td>
		<td align="right" width="" ><?php for($i=0;$i<=60;$i++){echo "&nbsp;";}?></td>
	</tr>
	<tr>
		<td class="bodytext32"><strong>CashReturned:</strong></td>
        <td   class="bodytext34" align="right" valign="middle"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
	</tr>
	<?php } ?>
	<?php if($res11chequeamount != 0.00) { ?> 
	<tr>
		<td class="bodytext32"><strong>Cheque Amount</strong></td>
		<td align="right" class="bodytext34" valign="middle"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
	</tr>
	<?php } ?>
	<?php if($res11onlineamount != 0.00) { ?> 
	<tr>
		<td class="bodytext32"><strong>Online Amount</strong></td>
		<td align="right" class="bodytext34" valign="middle"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
	</tr>
	<?php } ?>
	<?php if($res11cardamount != 0.00) { ?> 
	<tr>
		<td class="bodytext32"><strong>Credit Amount</strong></td>
        <td align="right" class="bodytext34" valign="middle"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
		
	</tr>
	<?php } ?>
	
    <?php if($res11creditamount != 0.00) { ?> 
	<tr>
		<td class="bodytext32"><strong>MPESA</strong><span align="right"></span></td>
        <td align="right" class="bodytext34" valign="middle"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
		
	</tr>
	<?php } ?>		   
	
			   
	<tr>
	  <td colspan="5" width="375">&nbsp;</td>
  </tr>
	<tr><?php if($planforall=='yes'){ $convertedwords=covert_currency_to_words($totalcopay+$desprate);} else{ $convertedwords=covert_currency_to_words($labrate+$radrate+$serrate+$pharmrate+$refrate+$desprate);}?>
		<td colspan="5" class="bodytext35"><strong>Uganda Shillings </strong><?php echo str_replace('Uganda Shillings','',$convertedwords); ?></td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5" align="right" class="bodytext32">Served By: <?php echo strtoupper($res11username); ?> </td>
	</tr>
	<tr>
		<td colspan="5" align="right" class="bodytext31"><?php echo date("d/m/Y", strtotime($res11billingdatetime))."&nbsp;".date("g.i A",strtotime($res11updatetime)); ?> </td>
	</tr>
</table> 
	


<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 4.38;
		$height_in_inches = 6.120;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_consultationbill.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>
