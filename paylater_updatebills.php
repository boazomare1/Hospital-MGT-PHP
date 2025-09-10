<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$onemonth = date("Y-m-d",strtotime('-1 month'));
$currentdate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$printbill = $_REQUEST["printbill"];
$docno=$_SESSION["docno"];
$totalcopayfixedamount='';
$totalcopay='';
$pharmacy_fxrate=2872.49;
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
$billno='';
 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
 $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["patientname"])) { $patientname = $_REQUEST["patientname"]; } else { $patientname = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
?>

<script language="javascript">



<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>


function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
}


//Print() is at bottom of this page.

</script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

<script src="js/datetimepicker_css.js"></script>
<script>
function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_paylater_summary.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


</script>
<script src="js/autocustomersmartsearch.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" onKeyDown="return disableEnterKey(event)" onSubmit="return funcSaveBill1()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
	<td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
	<td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>
  <tr>
	<td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
	<td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
	<td width="1%">&nbsp;</td>
	<td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			<tr>
					  <td class="bodytext31" valign="center"  align="left" 
				bgcolor="#FFFFFF"> Date From </td>
					  <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $onemonth; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
						  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
					  <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
					  <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
						<input name="ADate2" id="ADate2" value="<?php echo $currentdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
						<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
					</tr>
					<tr>
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
			  <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
					<?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
					  </select>
					 
			  </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
					
					<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
						  <input  type="submit" onClick= "return funcBill();" value="Search" name="Submit" />
						  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
					</tr>
			
				  <?php
				  if(isset($_REQUEST['cbfrmflag1']))
				  {
						$fromdate = $_REQUEST['ADate1'];
						$todate = $_REQUEST['ADate2'];
						$query76 = "select * from master_financialintegration where field='labpaylater'";
						$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$res76 = mysqli_fetch_array($exec76);
						$labcoa = $res76['code'];
						?>
						
				<tr bgcolor="#011E6A">
				<td colspan="9" bgcolor="#ecf0f5" class="bodytext32"><strong>Pay Later Bills Update for Account in date range </strong></td>
				</tr>
		<?php
		$pno=1;
		$query1 = "select * from master_transactionpaylater where paymenttype like 'cash' and visitcode <> '' and transactiondate between '$fromdate' and '$todate' order by auto_number asc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			?>
			<tr>
			<td colspan="9" bgcolor="#FFF">Total Patients to update: <?=mysqli_num_rows($exec1);?></td>
			</tr>
			<?php
			while($res1=mysqli_fetch_array($exec1))
			{ 
				$visitcode = $res1['visitcode'];
				$patientcode = $res1['patientcode'];
				$patientname = $res1['patientname'];
				$billno1 = $res1['billnumber'];
				$billdate = $res1['transactiondate'];
				$accountname = $res1['accountname'];
				$currency = $res1['currency'];
				$fxrate = $res1['exchrate'];
				$billuser = $res1['username'];
				$prevbillamount = $res1['billamount'];
				$prevtransactionamount = $res1['transactionamount'];
				$prevfxamount = $res1['fxamount'];

				$locationname = $res1["locationname"];
				$locationcode = $res1["locationcode"];
				?>
			<tr>
			<td colspan="10" bgcolor="#FFF"><?=$pno++.' - '.$patientname.' - '.$visitcode.' ( '.$patientcode.')'.' - '.$currency.' '.$prevtransactionamount;?></td>
			</tr>
						  <?php
				$quer21 = "select * from master_visitentry where visitcode = '$visitcode' and patientcode = '$patientcode'";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $quer21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(!mysqli_num_rows($exec1))
				{
				echo $billno;
				}
				else
				{
				$res21=mysqli_fetch_array($exec21);
				$res21visitcode = $res21['visitcode'];
				$res21patientcode = $res21['patientcode'];
				$res21patientname = $res21['patientname'];
				$res21paymenttype = $res21['paymenttype'];
				$res21subtype = $res21['subtype'];
				$res21accountname = $res21['accountfullname'];
				$res21accountnameano = $res21['accountname'];
				$queryacc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$res21accountnameano'");
				$resacc=mysqli_fetch_array($queryacc);
				$accountnameid= $resacc['id'];
				$accountnameano= $resacc['auto_number'];
				$accountname1= $resacc['accountname'];
				$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$res21paymenttype'");
				$exectype=mysqli_fetch_array($querytype);
				$patienttype1=$exectype['paymenttype'];
				$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$res21subtype'");
				$execsubtype=mysqli_fetch_array($querysubtype);
				$patientsubtype1=$execsubtype['subtype'];
				$patientsubtypeano=$execsubtype['auto_number'];
				$patientplan=$res21['planname'];
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
				$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
				$execplan=mysqli_fetch_array($queryplan);
				$patientplan1=$execplan['planname'];
				$smartap=$execplan['smartap'];		
			?>
			<tr>
			<td colspan="10" bgcolor="#FFF"><?=$res21paymenttype.' - '.$res21subtype.' - '.$res21accountname.' ( '.$accountname.')';?></td>
			</tr>
						 <tr bgcolor="#011E6A">
				<td colspan="10" bgcolor="#ecf0f5" class="bodytext32"><strong>Transaction Details</strong></td>
				
			 </tr>
		  
			<tr>
			  <td width="5%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
				<td width="4%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo $currency; ?> Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><strong><?php echo $currency; ?> Amount </strong></div></td>
				<td width="4%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>UGX Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>UGX Amount </strong></div></td>
				
				  </tr>
						<?php
						$admitid='';
			$colorloopcount = '';
			$totalcopayconsult='';
			$sno = '';
			$totalamount=0;
			$totalfxamount=0;
			$totalfxcopay=0;
			$consfxrate=0;
			$conscopayfxrate=0;
			$consult_discamount = 0;
			$pharmacy_discamount = 0;
			$lab_discamount = 0;
			$radiology_discamount = 0;
			$services_discamount = 0;
			$overalltotal=0;
			$totalcopay=0;
			$consultationtotal=0;
			$totalcopayfixedamount='';
			$totalcopay='';
			$consult_fxdiscamount = 0;
			$pharmacy_fxdiscamount = 0;
			$lab_fxdiscamount = 0;
			$radiology_fxdiscamount = 0;
			$services_fxdiscamount = 0;
			$totalpharm=0;
			$totalcopaypharm=0;
			$totallab=0;
			$totalcopaylab=0;
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['consultationfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$plannumber = $res17['planname'];
			$consultingdoctor = $res17['consultingdoctor'];
			
			$admitid = $res17['admitid'];
			$availablelimit = $res17['availablelimit'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
			$planforall = $resplanname['forall'];
			$planpercentage=$res17['planpercentage'];
			$copay=($consultationfee/100)*$planpercentage;
			
			$query_pw = "select `docno`, `entrydate`, `consult_discamount`, `pharmacy_discamount`, `lab_discamount`, `radiology_discamount`, `services_discamount` from patientweivers where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec_pw = mysqli_query($GLOBALS["___mysqli_ston"], $query_pw) or die ("Error in Query_pw".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_pw = mysqli_fetch_array($exec_pw);
			$consult_discamount = $res_pw['consult_discamount'];
			$pharmacy_discamount = $res_pw['pharmacy_discamount'];
			$lab_discamount = $res_pw['lab_discamount'];
			$radiology_discamount = $res_pw['radiology_discamount'];
			$services_discamount = $res_pw['services_discamount'];
			$pw_docno = $res_pw['docno'];
			$pw_entrydate = $res_pw['entrydate'];
			 
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
			$consultationfee = number_format($consultationfee,2,'.','');
			$consfxrate=$consultationfee*$fxrate;
			$conscopayfxrate=$copay*$fxrate;
			
			$query33 = "select consultation from billing_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			 $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $row33 = mysqli_num_rows($exec33);
 
			if($planpercentage!=0.00 && $row33 > 0)
			{
			 $totalop=$consultationfee; 
			 $totalcopay=$totalcopay+$copay;
			 $totalcopayconsult=$totalcopayconsult+$copay;
			 $totalfxamount=$totalfxamount+$consfxrate;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			else
			{
				$totalop=$consultationfee; 
				$totalcopay=$totalcopay+$copay;
				$totalcopayconsult=$totalcopayconsult+$copay;
				$totalfxamount=$totalfxamount+$consfxrate;
				$totalfxcopay=$totalfxcopay+$conscopayfxrate;
			}
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $viscode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $consultingdoctor; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrate,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrate,2,'.',','); ?>
				 <input type="hidden" name="consultationfxamount" id="consultationfxamount" value="<?php echo $consfxrate; ?>">
				 </div></td>
				 
			 
				</tr>
				
				<?php
				
				 if(($planpercentage!=0.00)){
					 $totalfxamount-=$conscopayfxrate;
					 $consfxrate-=$conscopayfxrate;
					?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($conscopayfxrate,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($conscopayfxrate,2); ?></div></td>
			   </tr>
				 
			<?php 
			}
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copayfixed=$res18['copayfixedamount'];
			if($copayfixed > 0)
			{
			$consfxrate=$consfxrate-$copayfixed;
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
			 $conscopayfxrate=$copayfixed*$fxrate;
			 $totalfxamount=$totalfxamount-$conscopayfxrate;
			 $totalcopayfixedamount=$copayfixed;
			 $totalfxcopay=$totalfxcopay+$conscopayfxrate;
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Fixed Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayfixed,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copayfixed,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($conscopayfxrate,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($conscopayfxrate,2); ?></div></td>
			  
			 
			  </tr>
			  <?php 
			} 
			$consfxrefund=0;
			$query11 = "select * from refund_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$totalfxamount=$totalfxamount+$consfxrefund;
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
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res11transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res11billnumber; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Consultation Refund'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationrefund,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationrefund,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrefund,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consfxrefund,2); ?></div></td>
			  </tr>
			  <?php 
			} 
			
			if($consult_discamount > 0)
			{
			$consult_fxdiscamount = $consult_discamount * $fxrate;
			$totalfxamount=$totalfxamount-$consult_fxdiscamount;
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Consultation Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_discamount,2); ?></div>
			  <input type="hidden" name="consult_discamount[]" id="consult_discamount[]" value="<?php echo $consult_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_fxdiscamount,2); ?></div>
			  <input type="hidden" name="consult_fxdiscamount[]" id="consult_fxdiscamount[]" value="<?php echo $consult_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($consult_fxdiscamount,2); ?></div></td>
			  </tr>
			<?php
			}
			
			  $totallab=0;
			  $labfxrate=0;
			  $labfxcopay=0;
			  $totalfxlab=0;
			  $labfxcopay=0;
			  $query19 = "select * from consultation_lab where labitemcode NOT IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> ''"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row19 = mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
				$labname=$res19['labitemname'];
				$labcode=$res19['labitemcode'];
				//$labrate=$res19['labitemrate'];
				$labrefno=$res19['refno'];
				
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'];
		
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$labrate = number_format($labrate,2,'.','');
			$labfxrate=($labrate*$fxrate);
			$copay=($labrate/100)*$planpercentage;
			$labfxcopay=$copay*$fxrate;
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
			  <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
				$totalfxamount=$totalfxamount+$labfxrate;
			   }
			   else
			  {$totallab=$totallab+$labrate;$totalfxamount=$totalfxamount+$labfxrate;$totalfxlab=$totalfxlab+$labfxrate; }
			  ?>
			  
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labrate-$copay; } else { echo $labrate;}?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <input name="labfxrate[]" id="labfxrate" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labfxrate-$labfxcopay; } else { echo $labfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2,'.',','); ?></div></td>
			
			 </tr>
			  <?php
			  $query2 = "update billing_paylaterlab set labitemrate='$labrate',fxrate='$labfxrate',fxamount='$labfxrate',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and labitemcode = '$labcode'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2lab1".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				 if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$labfxcopay;
				$totalfxlab-=$labfxcopay;
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($labfxcopay,2); ?></div></td>
			  </tr>
				<?php }?>
			  
			  <?php } 
			  
			if($lab_discamount > 0 && $row19 > 0)
			{
			$lab_fxdiscamount = $lab_discamount * $fxrate;
			$totalfxamount=$totalfxamount-$lab_fxdiscamount;
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Lab Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div>
			   <input type="hidden" name="lab_discamount[]" id="lab_discamount[]" value="<?php echo $lab_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div>
			   <input type="hidden" name="lab_fxdiscamount[]" id="lab_fxdiscamount[]" value="<?php echo $lab_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div></td>
			  </tr>
			<?php
			}
			
			  //copay
			   //$totallab=0;
			  $query19 = "select * from consultation_lab where labitemcode  IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> ''"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row19 = mysqli_num_rows($exec19);
			while($res19 = mysqli_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
				$labname=$res19['labitemname'];
				$labcode=$res19['labitemcode'];
				//$labrate=$res19['labitemrate'];
				$labrefno=$res19['refno'];
				
				$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
				$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
				$resfx = mysqli_fetch_array($execfx);
				$labrate=$resfx['rateperunit'];
				
				$labfxrate=($labrate*$fxrate);
				
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$copay=($labrate/100)*$planpercentage;
			$labfxcopay=$copay*$fxrate;
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
			  <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
				$totalfxamount=$totalfxamount+$labfxrate;
				$totalfxcopay=$totalfxcopay+$labfxcopay;
				$totalfxlab=$totalfxlab+$labfxrate;
				$totalfxcopaylab=$totalfxcopaylab+$labfxcopay; 
			   }
			   else
			  {$totallab=$totallab+$labrate;$totalfxamount=$totalfxamount+$labfxrate;$totalfxlab=$totalfxlab+$labfxrate;}
			  ?>
			  
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labrate-$copay; } else { echo $labrate;}?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <input name="labfxrate[]" id="labfxrate" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labfxrate-$labfxcopay; } else { echo $labfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxrate,2); ?></div></td>
			
			 </tr>
			  <?php
			  $labrate1=$labrate-$copay;
			 $labfxrate1=$labfxrate-$labfxcopay;
			 
			 $query2 = "update billing_paylaterlab set labitemrate='$labrate1',fxrate='$labfxrate1',fxamount='$labfxrate1',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and labitemcode = '$labcode'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2lab2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  
			   if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$labfxcopay;
				 $totalfxlab-=$labfxcopay;
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($labfxcopay,2); ?></div></td>
			  </tr>
				<?php }?>
			  
			  <?php } 
	
			if($lab_discamount > 0 && $row19 > 0)
			{
			$lab_fxdiscamount = $lab_discamount * $fxrate;
			$totalfxamount=$totalfxamount-$lab_fxdiscamount;
			?>
			<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Lab Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div>
			   <input type="hidden" name="lab_discamount[]" id="lab_discamount[]" value="<?php echo $lab_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div>
			   <input type="hidden" name="lab_fxdiscamount[]" id="lab_fxdiscamount[]" value="<?php echo $lab_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($lab_fxdiscamount,2); ?></div></td>
			 </tr>
			<?php
			}
			
			$original_fxrate= $fxrate;
			if(strtoupper($currency)=="USD"){
				$fxrate = $pharmacy_fxrate;
			}
			
			   $totalpharm=0;
			   $totalfxpharm=0;
			   $totalfxcopaypharm=0;
			   $pharno1=1;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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


$serviceitemcode199b=array();
		$query199b = mysqli_query($GLOBALS["___mysqli_ston"], "select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$visitcode' and b.pkg='Yes'");
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
	
		$query199a = mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		$count199a = mysqli_num_rows($query199a);
		if($count199a>0){
			$pharno-=1; 			
			continue;
		}
			//$pharno1=0;
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1==0){
			$pharno1=3;
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' ";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
		
		
			 $query28 = "select sum(quantity) as quantity from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus = '2'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
			<?php 
			$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
			$copay=($copayfxamount/$fxrate);
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay;
				
				$totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay;
				$totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;

				$totalfxamount=$totalfxamount+$pharfxamount;
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;$totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div>Pharm1</td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $realquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $phaamount-$copay; } else { echo $phaamount;}  ?>">
			 <input name="pharfxrate[]" id="pharfxrate" readonly size="8" type="hidden" value="<?php echo $pharfxrate; ?>">
			 <input name="pharfxamount[]" id="pharfxamount" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $pharfxamount; } else { echo $pharfxamount;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxamount,2,'.',','); ?></div></td>
			
			 </tr>
			 <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay*$realquantity;
				$totalfxpharm-=$copay*$realquantity;
			 ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($realquantity,2); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$realquantity,2); ?></div></td>
			  
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  $query2 = "update billing_paylaterpharmacy set quantity = '$realquantity',rate='$pharate',amount='$phaamount',fxrate='$pharfxrate',fxamount='$pharfxamount',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and medicinecode = '$phaitemcode'";
				
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2pharm1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$fxrate = $original_fxrate;
			  }}
			  ?>
			  <?php
			  if($pharmacy_discamount > 0 && $pharno > 0 && $pharno1==1)
			  {
			  $queryphar = "select auto_number from billing_paynowpharmacy where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			  $execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $pharno1 = mysqli_num_rows($execphar);
			  if($pharno1==0){
			  $pharmacy_fxdiscamount = $pharmacy_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$pharmacy_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Pharmacy Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharmacy_discamount,2); ?></div>
			   <input type="hidden" name="pharmacy_discamount[]" id="pharmacy_discamount[]" value="<?php echo $pharmacy_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharmacy_fxdiscamount,2); ?></div>
			  <input type="hidden" name="pharmacy_fxdiscamount[]" id="pharmacy_fxdiscamount[]" value="<?php echo $pharmacy_fxdiscamount; ?>"></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  }
			  ?>
			  <!--copay-->
			   <?php 
			   //$totalpharm=0;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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


$serviceitemcode199b=array();
		$query199b = mysqli_query($GLOBALS["___mysqli_ston"], "select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$visitcode' and b.pkg='Yes'");
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


	$query199a = mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		$count199a = mysqli_num_rows($query199a);
		if($count199a>0){
			$pharno-=1; 			
			continue;
		}
			//$pharno1=0;
			
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysqli_query($GLOBALS["___mysqli_ston"], $queryphar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$pharno1 = mysqli_num_rows($execphar);
				if($pharno1>0){

if($planforall!='yes' && $pharno1>0){
	continue;
}
			
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysqli_query($GLOBALS["___mysqli_ston"], $query47) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res47 = mysqli_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			
				 $query28 = "select sum(quantity) as quantity from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus = '2'";
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1sd".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query1as".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
			<?php 
			$copayfxamount=(($pharate*$realquantity)/100)*$planpercentage;
				
			 $copay=(($pharate)/100)*$planpercentage;
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   $totalpharm=$totalpharm+$phaamount;
				$totalcopaypharm=$totalcopaypharm+$copay*$realquantity;
				 $totalfxpharm=$totalfxpharm+$pharfxamount;
				$totalfxcopaypharm=$totalfxcopaypharm+$copayfxamount;
				$totalfxcopay=$totalfxcopay+$copayfxamount;

				$totalfxamount=$totalfxamount+$pharfxamount;
				
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;$totalfxamount=$totalfxamount+$pharfxamount;$totalfxpharm=$totalfxpharm+$pharfxamount;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?>Pharm2</div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $realquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $pharate-$copay; } else { echo $pharate;} ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo ($pharate-$copay)*$realquantity; } else { echo $pharate*$realquantity;} ?>">
			 <input name="pharfxrate[]" id="pharfxrate" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo ($pharate-$copay)*$fxrate; } else { echo $pharate*$fxrate;} ?>">
			 <input name="pharfxamount[]" id="pharfxamount" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo ($pharate-$copay)*$realquantity*$fxrate; } else { echo $pharate*$realquantity*$fxrate;} ?>"></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxamount,2); ?></div></td>
			
			 </tr>
			 <?php 
			 $pharate1=$pharate-$copay;
			 $phaamount1=($pharate-$copay)*$realquantity;
			 $pharfxrate1=($pharate-$copay)*$fxrate;
			 $pharfxamount1=($pharate-$copay)*$realquantity*$fxrate;
			 
			 $query2 = "update billing_paylaterpharmacy set quantity = '$realquantity',rate='$pharate1',amount='$phaamount1',fxrate='$pharfxrate1',fxamount='$pharfxamount1',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and medicinecode = '$phaitemcode'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2pharm2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			 if(($planpercentage!=0.00)&&($planforall=='yes')){
							 $pharfxrate=number_format($copay*$fxrate,5,'.','');
							 $pharfxamount=number_format($pharfxrate*$realquantity,5,'.','');
							 $copay*$realquantity;
							 $totalcopay=$totalcopay+($copay*$realquantity);
								$totalfxamount-=$pharfxamount;
								$totalfxpharm-=$pharfxamount;
			 ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay*$realquantity,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharfxamount,2); ?></div></td>
			
			  </tr>
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
			  <?php
			  if($pharmacy_discamount > 0 && $pharno > 0)
			  {
			  $pharmacy_fxdiscamount = $pharmacy_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$pharmacy_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Pharmacy Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount,2); ?></div>
			   <input type="hidden" name="pharmacy_discamount[]" id="pharmacy_discamount[]" value="<?php echo $pharmacy_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_discamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_fxdiscamount,2); ?></div>
				<input type="hidden" name="pharmacy_fxdiscamount[]" id="pharmacy_fxdiscamount[]" value="<?php echo $pharmacy_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($pharmacy_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
				<?php 
				if($pharno>0){
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
			$desprate=0;
			$despratetotal=0;
			$totalcopaydesp=0;
			 
			 if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$desprate=($desprate/100)*$planpercentage;
				$totalcopaydesp=$desprate;
			   }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "DISPENSING"; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo "DISPENSING"; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo "1"; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $desprate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $desprate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($despratetotal,2); ?></div></td>
			 
			 </tr>
			  <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $copay=$desprate; $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$copay;
				$totalfxpharm-=$copay;
			   ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			
			  </tr>
				
			  
			  <?php }}
			  ?>
				<?php 


			 $fxrate = $original_fxrate;

				$totalrad=0;
				$totalcopayrad='';
				$radfxrate=0;
				$totalfxrad=0;
				$totalfxcopayrad=0;
				$radfxcopay=0;
			  $query20 = "select * from consultation_radiology where radiologyitemcode NOT IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed'"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row20 = mysqli_num_rows($exec20);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'];
				
			//$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$radrate = number_format($radrate,2,'.','');
			$copay=($radrate/100)*$planpercentage;
			$radfxrate=($radrate*$fxrate);
			$radfxcopay=$copay*$fxrate;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
			<?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
				$totalfxcopay=$totalfxcopay+$radfxcopay;
				$totalfxamount=$totalfxamount+$radfxrate;				
				$totalfxrad=$totalfxrad+$radfxrate;
				$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
			   }
			   else
			  {$totalrad=$totalrad+$radrate;$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="radcode[]" id="radcode" type="hidden" value="<?php echo $radcode; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radrate-$copay; } else { echo $radrate;}?>">
			 <input name="radfxrate[]" type="hidden" id="radfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radfxrate-$radfxcopay; } else { echo $radfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2,'.',','); ?></div></td>
			 
			 </tr>
			  <?php
			$query2 = "update billing_paylaterradiology set radiologyitemrate='$radrate',fxrate='$radfxrate',fxamount='$radfxrate',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and radiologyitemcode = '$radcode'";
				
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2rad1".mysqli_error($GLOBALS["___mysqli_ston"]));
			   if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
											$totalfxamount-=$radfxcopay;
											  $totalfxrad-=$radfxcopay;
	
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radfxcopay,2); ?></div></td>
			  
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			  <?php
			  if($radiology_discamount > 0 && $row20 > 0)
			  {
			  $radiology_fxdiscamount = $radiology_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$radiology_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Radiology Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div>
			   <input type="hidden" name="radiology_discamount[]" id="radiology_discamount[]" value="<?php echo $radiology_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div>
				<input type="hidden" name="radiology_fxdiscamount[]" id="radiology_fxdiscamount[]" value="<?php echo $radiology_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			  <!--copay-->
				<?php 
				//$totalrad=0;
				//$totalcopayrad='';
			  $query20 = "select * from consultation_radiology where radiologyitemcode  IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed'"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row20 = mysqli_num_rows($exec20);
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radcode=$res20['radiologyitemcode'];
			
			$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$radrate=$resfx['rateperunit'];
			
			//$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($radrate/100)*$planpercentage;
			$radfxrate=($radrate*$fxrate);
			$radfxcopay=$copay*$fxrate;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
			<?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
				$totalfxcopay=$totalfxcopay+$radfxcopay;
				$totalfxamount=$totalfxamount+$radfxrate;				
				$totalfxrad=$totalfxrad+$radfxrate;
				$totalfxcopayrad=$totalfxcopayrad+$radfxcopay; 
			   }
			   else
			  {$totalrad=$totalrad+$radrate;$totalfxamount=$totalfxamount+$radfxrate;$totalfxrad=$totalfxrad+$radfxrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="radcode[]" id="radcode" type="hidden" value="<?php echo $radcode; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radrate-$copay; } else { echo $radrate;}?>">
			 <input name="radfxrate[]" type="hidden" id="radfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radfxrate-$radfxcopay; } else { echo $radfxrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxrate,2); ?></div></td>
			 
			 </tr>
			  <?php
			  $radrate1=$radrate-$copay;
			  $radfxrate1=$radfxrate-$radfxcopay;
			  $query2 = "update billing_paylaterradiology set radiologyitemrate='$radrate1',fxrate='$radfxrate1',fxamount='$radfxrate1',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and radiologyitemcode = '$radcode'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2rad2".mysqli_error($GLOBALS["___mysqli_ston"]));
			   if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;
				$totalfxamount-=$radfxcopay;
				  $totalfxrad-=$radfxcopay;
				
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radfxcopay,2); ?></div></td>
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php
			  if($radiology_discamount > 0 && $row20 > 0)
			  {
			  $radiology_fxdiscamount = $radiology_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$radiology_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Radiology Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div>
			   <input type="hidden" name="radiology_discamount[]" id="radiology_discamount[]" value="<?php echo $radiology_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_discamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div>
				<input type="hidden" name="radiology_fxdiscamount[]" id="radiology_fxdiscamount[]" value="<?php echo $radiology_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($radiology_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
					<?php 
					
					$totalser=0;
					$serfxrate=0;
					$serfxcopay=0;
					$totalfxser=0;
					$totalfxcopayser=0;
					$serfxcopayqty=0;
					$serfxrateqty=0;
			  $query21 = "select * from consultation_services where servicesitemcode NOT IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed'  group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			//$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			
			$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
			$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resfx = mysqli_fetch_array($execfx);
			$serrate=$resfx['rateperunit'];
			
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
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
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
			 <?php 
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
					$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
			  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="sercode[]" type="hidden" id="sercode" size="69" value="<?php echo $sercode; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serratetot-$copaysingle; } else { echo $serratetot;}?>">
			 <input name="serfxrate[]" type="hidden" id="serfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrate; } else { echo $serfxrate;}?>">
			 <input name="serfxrateqty[]" type="hidden" id="serfxrateqty" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrateqty-$serfxcopayqty; } else { echo $serfxrateqty;}?>">
			  <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
			  <input name="totalservice3[]" type="hidden" id="totalservice3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totamt,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrateqty,2,'.',','); ?></div></td>
			 
			 </tr>
			  <?php
			 $query2 = "update billing_paylaterservices set serviceqty = '$serqty',servicesitemrate='$serratetot',amount='$totserrate',fxrate='$serfxrate',fxamount='$serfxrateqty',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and servicesitemcode = '$sercode'";
				
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2ser1".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				 if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;
				$totalfxamount-=$serfxcopayqty;
				$totalfxser-=$serfxcopayqty;
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayperser,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($serfxcopayqty,2); ?></div></td>
			 
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php
			  if($services_discamount > 0 && $row21 > 0)
			  {
			  $services_fxdiscamount = $services_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$services_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Services Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div>
			   <input type="hidden" name="services_discamount[]" id="services_discamount[]" value="<?php echo $services_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div>
				<input type="hidden" name="services_fxdiscamount[]" id="services_fxdiscamount[]" value="<?php echo $services_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			  <!--copay-->
			  <?php 
					
					//$totalser=0;
			  $query21 = "select * from consultation_services where servicesitemcode  IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed'  group by servicesitemcode";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row21 = mysqli_num_rows($exec21);
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$resqty = mysqli_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
			$perrate=$resqty['servicesitemrate'];
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
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
			 <?php 
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
					$totalfxamount=$totalfxamount+$serfxrateqty;
					$totalfxser=$totalfxser+$serfxrateqty;
				}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="sercode[]" type="hidden" id="sercode" size="69" value="<?php echo $sercode; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serratetot-$copaysingle; } else { echo $serratetot;}?>">
			  <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
			  <input name="totalservice3[]" type="hidden" id="totalservice3" readonly size="8" value="<?php echo $totserrate; ?>">
			  <input name="serfxrate[]" type="hidden" id="serfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrate; } else { echo $serfxrate;}?>">
			 <input name="serfxrateqty[]" type="hidden" id="serfxrateqty" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serfxrateqty-$serfxcopayqty; } else { echo $serfxrateqty;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totamt,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxrateqty,2,'.',','); ?></div></td>
			 
			 </tr>
			  <?php 
			  $serratetot1=$serratetot-$copaysingle;
			 $serfxrateqty1=$serfxrateqty-$serfxcopayqty;
			 
			$query2 = "update billing_paylaterservices set serviceqty = '$serqty',servicesitemrate='$serratetot',amount='$totserrate1',fxrate='$serfxrate',fxamount='$serfxrateqty1',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and servicesitemcode = '$sercode'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2ser2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  
			  if(($planpercentage!=0.00)&&($planforall=='yes')){ $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;
			  $totalfxamount-=$serfxcopayqty;
						  $totalfxser-=$serfxcopayqty;
	
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayperser,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serfxcopay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($serfxcopayqty,2); ?></div></td>
			  
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php
			  if($services_discamount > 0 && $row21 > 0)
			  {
			  $services_fxdiscamount = $services_discamount * $fxrate;
			  $totalfxamount=$totalfxamount-$services_fxdiscamount;
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_entrydate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pw_docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Services Discount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format(1,0); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div>
			   <input type="hidden" name="services_discamount[]" id="services_discamount[]" value="<?php echo $services_discamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_discamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div>
				<input type="hidden" name="services_fxdiscamount[]" id="services_fxdiscamount[]" value="<?php echo $services_fxdiscamount; ?>"></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($services_fxdiscamount,2); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			   <?php 
			   $totalref=0;
			   $totalfxref=0;
			   $totalfxrefcopay=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res22 = mysqli_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refcode=$res22['referalcode'];
			$refref=$res22['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$reffxrate=$refrate;
			$refrate=number_format($reffxrate,2,'.','');
			$copay=($refrate/100)*$planpercentage;
			$refcopayfxrate=($reffxrate/100)*$planpercentage;
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
			//$totalref=$totalref+$refrate;
			?>
			 <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totalref=$totalref+$refrate; 
				$totalcopayref=$totalcopayref+$copay;
				$totalfxref=$totalfxref+$reffxrate; 
				$totalfxrefcopay=$totalfxrefcopay+$refcopayfxrate;
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxrate;
			   }
			   else
			  {$totalref=$totalref+$refrate;$totalfxref=$totalfxref+$reffxrate;$totalfxamount=$totalfxamount+$reffxrate; }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rateref[]" type="hidden" id="rateref" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refrate-$copay; } else { echo $refrate;}  ?>">
			  <input name="raterefamt[]" type="hidden" id="raterefamt" readonly size="8" value="<?php echo $refrate;  ?>">
			  <input name="reffxrate[]" type="hidden" id="reffxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $reffxrate; } else { echo $reffxrate;}  ?>">
			  
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2); ?></div></td>
			 
			 </tr>
			  <?php
			  
			   $query2 = "update billing_paylaterreferal set referalrate='$refrate',referalamount='$refrate',fxrate='$reffxrate',fxamount='$reffxrate',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and billnumber = '$billno1' and referalcode = '$refcode'";
				exit;
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2ref".mysqli_error($GLOBALS["___mysqli_ston"]));
			 if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay;
			  $totalfxref-=$copay;
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
				class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			  
			   <?php 
			   $totalamb=0;
				$snohome='0';
				$totalfxambcopay=0;
				$totalfxamb=0;
			  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			//$totalamb=$totalamb+$refamount;
			//$totalambulance=$totalamb;
			?>
			<?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totalamb=$totalamb+$refamount;
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
			  $totalambulance=$totalamb;
			  $totalfxamb=$totalfxamb+$reffxamount; 
				$totalfxamount=$totalfxamount+$reffxamount;
			  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <?php /*?> <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>"><?php */?>
			 <input type="hidden" name="ambulancecount[]" value="<?php echo $snohome;?>">
			  <input name="accountname[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
			   <input name="description[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
				<input name="quantityamb[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
				 <input name="rateamb[]" type="hidden" id="rateamb" readonly size="8" value="<?php echo $refrate; ?>">
				  <input name="amountamb[]" type="hidden" id="amountamb" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){   echo $refamount-$copay; } else { echo $refamount;}  ?>">
				   <input name="actualamount[]" type="hidden" id="actualamount" readonly size="8" value="<?php echo $refamount; ?>">
				   <input name="amdocno[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
				   <input name="ambfxrate[]" type="hidden" id="ambfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxrate; } else { echo $reffxrate;}  ?>">
				   <input name="ambfxamount[]" type="hidden" id="ambfxamount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxamount; } else { echo $reffxamount;}  ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxamount,2,'.',','); ?></div></td>
			 
			 </tr>
			  <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			  $totalfxamount-=$copay;
			  $totalfxamb-=$copay;
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay/$qty,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
				class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><input type="hidden" name="ambcount" value="<?php echo $ambcount;?>">
			   <?php 
			   $totalhom=0;
			   $snohome='0';
			   $totalfxhome=0;
			   $totalfxhomecopay=0;
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			<?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
				$totalhom=$totalhom+$refamount;
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
				$totalhomecare=$totalhom;
				$totalfxhome=$totalfxhome+$reffxamount; 
				$totalfxcopay=$totalfxcopay+$refcopayfxrate;
				$totalfxamount=$totalfxamount+$reffxamount;
				 // $totalamb=$totalamb+$refamount;
				  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno2 = $sno2 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			<?php /*?>  <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>"><?php */?>
			 <input type="hidden" name="ambulancecounthom[]" value="<?php echo $snohome;?>">
			 <?php /*?> <input name="accountname2[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
			   <input name="description2[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
				<input name="quantity2[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
				 <input name="rate2[]" type="hidden" id="rate" readonly size="8" value="<?php echo $refrate; ?>">
				  <input name="amount2[]" type="hidden" id="amount" readonly size="8" value="<?php echo $refamount; ?>">
				   <input name="amdocno2[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>"><?php */?>
			   <input name="accountnamehom[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
			   <input name="descriptionhom[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
				<input name="quantityhom[]" type="hidden" id="quantityhom" readonly size="8" value="<?php echo $qty; ?>">
				 <input name="ratehom[]" type="hidden" id="ratehom" readonly size="8" value="<?php echo $refrate; ?>">
				  <input name="amounthom[]" type="hidden" id="amounthom" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $refamount-$copay; } else { echo $refamount;} ?>">
				   <input name="actualamounthom[]" type="hidden" id="actualamounthom" readonly size="8" value="<?php echo $refamount; ?>">
				   <input name="amdocnohom[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
				   <input name="homefxrate[]" type="hidden" id="homefxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxrate; } else { echo $reffxrate;}  ?>">
				   <input name="homefxamount[]" type="hidden" id="homefxamount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxamount; } else { echo $reffxamount;}  ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($refamount,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxamount,2,'.',','); ?></div></td>
			 
			 </tr>
			  <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;
			   $totalfxamount-=$copay;
			   $totalfxhome-=$copay;
			  ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copay/$qty,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($copay,2); ?></div></td>
			  <td width="4%"  align="left" valign="center" 
				class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			   
			 
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><input type="hidden" name="ambcount1" value="<?php echo $ambcount1;?>">
						  
			   <?php 
			   $totaldepartmentref=0;
			  $query231 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			$totalfxamount=$totalfxamount+$reffxamount;
			$totaldepartmentref=$totaldepartmentref+$departmentrefrate;
			$totalfxref=$totalfxref+$reffxamount; 
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefdate; ?></div></td>
			  <input type="hidden" name="departmentreferalname" value="<?php echo $departmentrefname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Referral Fee - <?php echo $departmentrefname; ?></div></td>
			  <input name="departmentreferal[]" type="hidden" id="departmentreferal" size="69" value="<?php echo $departmentrefname; ?>">
			 <input name="departmentreferalrate4[]" type="hidden" id="departmentreferalrate4" readonly size="8" value="<?php echo $departmentrefrate; ?>">
			<input name="deptfxrate[]" type="hidden" id="deptfxrate" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxrate; } else { echo $reffxrate;}  ?>">
			 <input name="deptfxamount[]" type="hidden" id="deptfxamount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $reffxamount; } else { echo $reffxamount;}  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($departmentrefrate,2); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxrate,2); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($reffxamount,2); ?></div></td>
			 
			 </tr>
			  
			  <?php }
			  ?>

			  <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes')){ 
			
				  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund;
			  $overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			   $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			 else if(($planpercentage!=0.00)&&($planforall=='')){
			 
			 // echo $totalser;
				   $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund;
			  $overalltotal = $overalltotal - ($consult_discamount+$pharmacy_discamount+$lab_discamount+$radiology_discamount+$services_discamount);
			   $consultationtotal=$totalop-$totalcopayconsult+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			  else{
			  
				  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay+$consultationrefund-$totalcopayfixedamount;
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
			  
			  
			  <tr>
			  <td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
				bgcolor="#ecf0f5"><strong>Total</strong></td>
			 <td class="bodytext31" valign="center"  align="right" 
				bgcolor="#ecf0f5"><strong><?php echo number_format($overalltotal,2,'.',''); ?>
				<input name="overalltotal" type="hidden" id="overalltotal" readonly size="8" value="<?php  echo $overalltotal; ?>" />
				</strong></td>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
				bgcolor="#ecf0f5"><strong><?php echo number_format($totalfxamount,2,'.','');?></strong></td>
				
			 
			 </tr>
		  
		<tr>
		 <td colspan="9" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td colspan="9">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
			bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
			align="left" border="0">
		  <tbody id="foo">
		 <tr bgcolor="#011E6A">
				<td colspan="7" bgcolor="#ecf0f5" class="bodytext32"><strong>Payable Details</strong></td>
			 </tr>
		  <tr>
			<td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
			  <td width="21%" class="bodytext31" valign="center" align="left" 
				bgcolor="#CBDBFA"><div align="left">Total for Consultation</div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($consultationtotal-$consult_discamount,2,'.',''); ?></div>
				<input type="hidden" name="consultation" value="<?php echo $consultationtotal-$consult_discamount; ?>"></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#CBDBFA"><div align="right"><?php echo number_format($consfxrate-$consult_fxdiscamount,2,'.',''); ?></div></td>
			<?php
			$consultationtotal=$consultationtotal-$consult_discamount;
			$query2 = "update billing_paylaterconsultation set totalamount='$consultationtotal',fxrate='$consfxrate',fxamount='$consfxrate',currency='$currency',exchrate='$fxrate',accountname = '$res21accountname' where patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billno1'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2cons".mysqli_error($GLOBALS["___mysqli_ston"]));
				$query12 = "update billing_paylater set totalamount='$netpay',fxamount='$totalfxamount',currency='$currency',exchrate='$fxrate',subtype='$patientsubtype1',accountcode='$accountnameid',accountnameid='$accountnameid',accountnameano='$accountnameano',accountname = '$res21accountname' where patientcode = '$patientcode' and visitcode = '$visitcode' and billno = '$billno1'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$query13 = "update master_transactionpaylater set transactionamount='$netpay',billamount='$netpay',fxamount='$totalfxamount',billbalanceamount='$totalfxamount',currency='$currency',exchrate='$fxrate',paymenttype='$patienttype1',subtype='$patientsubtype1',subtypeano='$patientsubtypeano',accountcode='$accountnameid',accountnameid='$accountnameid',accountnameano='$accountnameano',accountname = '$res21accountname' where patientcode = '$patientcode' and visitcode = '$visitcode' and billnumber = '$billno1' and transactiontype like 'finalize'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
			?>
			</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Pharmacy </div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalpharm-$totalcopaypharm-$pharmacy_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxpharm-$pharmacy_fxdiscamount,2,'.',''); ?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Laboratory</div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totallab-$totalcopaylab-$lab_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#CBDBFA"><div align="right"><?php echo number_format($totalfxlab-$lab_fxdiscamount,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
					<td width="21%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Radiology </div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalrad-$totalcopayrad-$radiology_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxrad-$radiology_fxdiscamount,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Service	</div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totalser-$totalcopayser-$services_discamount,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#CBDBFA"><div align="right"><?php echo number_format($totalfxser-$services_fxdiscamount,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Referral		</div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalref-$totalcopayref,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxref,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				 bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Ambulance		</div></td>
				<td width="25%"  align="left" valign="center" 
				 bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totalambulance-$totalcopayamb,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				 bgcolor="#CBDBFA"><div align="right"><?php echo number_format($totalfxamb,2,'.','');?></div></td>
			
				</tr>
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Homecare		</div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalhomecare-$totalcopayhom,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#ffffff"><div align="right"><?php echo number_format($totalfxhome,2,'.','');?></div></td>
			
				</tr>
				
				
				 <tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="21%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Dispensing Fee		</div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($despratetotal-$totalcopaydesp,2,'.',''); ?></div></td>
				 <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#ffffff"><div align="right"><strong>&nbsp;</strong></div></td>
			
				</tr>
				
				<tr>
				  <td width="33%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
			
			  <td width="21%"  align="left" valign="center" 
				bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Net Payable	</strong></div></td>
				<td width="25%"  align="left" valign="center" 
				bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo  $netpay; ?></strong></div></td>
				<input type="hidden" name="totalamount" id="totalamount" value="<?php echo  $netpay; ?>">
				<input type="hidden" name="totalfxamount" id="totalfxamount" value="<?php echo  $totalfxamount; ?>">
				<input type="hidden" id="smartbenefitno">
				<input type="hidden" id="admitid">
				  <td width="21%" class="bodytext31" valign="center"  align="right" 
				bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalfxamount,2,'.','');?></strong></div></td><?php if($totalfxamount-$prevfxamount == '0'){echo 'Match'; }else{echo 'Mismatch';}?>
			
			</tr>
				  </tbody>
				  </table>				  </td>
					<tr>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32"><div align="left"><strong>User Name</strong> <span class="bodytext3">
				 <?php echo $billuser; ?>
				</span>&nbsp;&nbsp;&nbsp;&nbsp;<b><input type="hidden" name="availablelimite" id="availablelimit" value="<?php echo $availablelimit;?>" <?php  if($availablelimit < $netpay){?> style="background:#F00;color:#FFF" <?php }?>></td>
				<td height="32" colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Updated Sucessfully <a href="print_paylater_detailed.php?locationcode=<?=$locationcode?>&&billautonumber=<?=$billno1;?>" target="_blank">Check Print</a></td>
					</tr>
					<?php }} }?>
	</table>

</form>
<script>

function loadprintpage4(btn)
{
	form1.method="POST";
	if(btn=='smart')
	{
	form1.frm1submit1.value="frm1submit1";
	}
	if(btn=='seek')
	{
	form1.frm1submit1.value="seekapproval";
	}
	if(btn=='submit')
	{
	form1.frm1submit1.value="frm1submit1";
	}
	form1.action="billing_paylater.php" 
	form1.submit();
	}
	
</script>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>