<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$colorloopcount='';
$snocount='';
$totalpharmacysalesreturn='0';
$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$overaltotalrefund='0.00';
 
$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	$department=isset($_REQUEST['department'])?$_REQUEST['department']:'%%';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

/*if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$ADate1 = $_REQUEST['ADate1'];
	$ADate2 = $_REQUEST['ADate2'];
}
else
{
	$ADate1 = date('Y-m-d', strtotime('-1 month'));
	$ADate2 = date('Y-m-d');
}
*/
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
            <tr>
              <td class="bodytext31" width="4%" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient code</strong></td>
				
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient </strong></td>
             
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Location </strong></td>
       
            </tr>
			<?php
				$query12 = "select locationname from master_location where locationcode='$locationcode' order by locationname";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	$res1location = $res12["locationname"];
			
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			$searchsuppliername='';
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
			<?php
				$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$totalamount8 = '0.00';
$totalpharmacysalesreturn  = '0.00';
$overaltotalrefund  = '0.00';
$searchsuppliername='';
$query21 = "select * from master_visitentry where billtype='PAY LATER' and accountfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater) group by accountfullname order by accountfullname desc";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res21 = mysqli_fetch_array($exec21))
{
$res21accountnameano = $res21['accountname'];

$query22 = "select * from master_accountname where auto_number = '$res21accountnameano' and recordstatus <>'DELETED' ";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
$res22 = mysqli_fetch_array($exec22);
$res22accountname = $res22['accountname'];
$res21accountname = $res22['accountname'];

if( $res21accountname != '')
{
$res3labitemrate = "0.00";

$query2 = "select * from master_visitentry where billtype='PAY LATER' and accountname = '$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' AND visitcode NOT IN (SELECT visitcode FROM billing_paylater)  and department like '$department' and locationcode='$locationcode' order by accountfullname desc ";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2patientfullname = $res2['patientfullname'];
$res2registrationdate = $res2['consultationdate'];
$res2accountname = $res2['accountfullname'];
$subtype = $res2['subtype'];
$plannumber = $res2['planname'];

$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
$resplanname = mysqli_fetch_array($execplanname);
$planforall = $resplanname['forall'];
$planpercentage=$res2['planpercentage'];
//$copay=($consultationfee/100)*$planpercentage;


$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$res2patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientsubtypeano=$execsubtype['auto_number'];
$patientplan=$execlab['planname'];
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

$res3labitemrate = 0;
$query3 = "select labitemcode from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
$labcode = $res3['labitemcode']; 
$queryfx = "select rateperunit from $labtemplate where itemcode = '$labcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$labrate=$resfx['rateperunit'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$labrate = $labrate - ($labrate/100)*$planpercentage;
}
$res3labitemrate = $res3labitemrate + $labrate;
	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2registrationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="left">
			    <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
            
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res1location; ?></div></td>
           </tr>
			<?php
			
}

$res4servicesitemrate = 0;
$query4 = "select servicesitemcode,serviceqty,refundquantity from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res4 = mysqli_fetch_array($exec4))
{
$sercode=$res4['servicesitemcode'];
$serqty=$res4['serviceqty'];
$serrefqty=$res4['refundquantity'];

$serqty = $serqty-$serrefqty;

$queryfx = "select rateperunit from $sertemplate where itemcode = '$sercode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$serrate=$resfx['rateperunit'] * $fxrate;
$serrate = $serrate * $serqty;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$serrate = $serrate - ($serrate/100)*$planpercentage;
}
$res4servicesitemrate = $res4servicesitemrate + $serrate;
}

$res5radiologyitemrate = 0;
$query5 = "select radiologyitemcode from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res5 = mysqli_fetch_array($exec5))
{
$radcode=$res5['radiologyitemcode'];

$queryfx = "select rateperunit from $radtemplate where itemcode = '$radcode'";
$execfx = mysqli_query($GLOBALS["___mysqli_ston"], $queryfx) or die ("Error in Queryfx".mysqli_error($GLOBALS["___mysqli_ston"]));
$resfx = mysqli_fetch_array($execfx);
$radrate=$resfx['rateperunit'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$radrate = $radrate - ($radrate/100)*$planpercentage;
}
$res5radiologyitemrate = $res5radiologyitemrate + $radrate;
}

$query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2' ";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$res6referalrate = $res6['referalrate1'];
if ($res6referalrate =='')
{
$res6referalrate = '0.00';
}
else 
{
$res6referalrate = $res6['referalrate1'] * $fxrate;
}
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$res6referalrate=$res6referalrate - ($res6referalrate/100)*$planpercentage;
}

$query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$res7consultationfees = $res7['consultationfees1'] * $fxrate;
if(($planpercentage!=0.00)&&($planforall=='yes'))
{ 
$copay=($res7consultationfees/100)*$planpercentage;
}
else
{
$copay = 0;
}
$res7consultationfees = $res7consultationfees - $copay;

$query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and consultationdate between '$ADate1' and '$ADate2'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$res8copayfixedamount = $res8['copayfixedamount1'];
$res8copayfixedamount = 0;

$consultation = $res7consultationfees - $res8copayfixedamount;

$query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and entrydate between '$ADate1' and '$ADate2' ";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
$res9 = mysqli_fetch_array($exec9);
$res9pharmacyrate = $res9['totalamount1'];

if ($res9pharmacyrate == '')
{
$res9pharmacyrate = '0.00';
}
else 
{
$res9pharmacyrate = $res9['totalamount1'];
}

if(($planpercentage!=0.00)&&($planforall=='yes'))
{
$res9pharmacyrate = $res9pharmacyrate - ($res9pharmacyrate/100)*$planpercentage;
}

$query321 = "select sum(totalamount) as totalamount2 from pharmacysalesreturn_details where visitcode='$res2visitcode' and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
$exec321 = mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
$numpharmacysalereturn=mysqli_num_rows($exec321);
$totalpharmacysalesreturn=$totalpharmacysalesreturn+$numpharmacysalereturn;
//echo '<br>Total Pharmacy Return '.mysql_num_rows($exec321);
$res321 = mysqli_fetch_array($exec321);

$res9pharmacyreturnrate = $res321['totalamount2'];
if(($planpercentage!=0.00)&&($planforall=='yes'))
{
$res9pharmacyreturnrate = $res9pharmacyreturnrate - ($res9pharmacyreturnrate/100)*$planpercentage;
}
$res9pharmacyrate=$res9pharmacyrate- $res9pharmacyreturnrate;

$query322 = "select sum(totalamount) as totalrefund from refund_paylater where visitcode='$res2visitcode'";// and entrydate between '$ADate1' and '$ADate2'";// and ipdocno = '$refno'";//group by itemcode";
$exec322 = mysqli_query($GLOBALS["___mysqli_ston"], $query322) or die ("Error in Query321".mysqli_error($GLOBALS["___mysqli_ston"]));
$res322 = mysqli_fetch_array($exec322);
$totalrefund = $res322['totalrefund'];

$overaltotalrefund=$overaltotalrefund+$totalrefund;



$totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate + $overaltotalrefund;
$totalamount1 = $totalamount1 + $totalamount;
$totalamount2 = $totalamount2 + $res3labitemrate;
$totalamount3 = $totalamount3 + $res4servicesitemrate;
$totalamount4 = $totalamount4 + $res9pharmacyrate;
$totalamount5 = $totalamount5 + $res5radiologyitemrate;
$totalamount6 = $totalamount6 + $consultation;
$totalamount7 = $totalamount7 + $res6referalrate;
		  
			}
			}
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
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
            
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             
			
            </tr>
		 		
          </tbody>
        </table></td>
      </tr>
	  
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

