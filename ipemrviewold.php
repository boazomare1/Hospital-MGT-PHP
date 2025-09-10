<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("includes/loginverify.php");

include ("db/db_connectemr.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");

$transactiondatefrom = date('Y-m-d', strtotime('-6 day'));
$transactiondateto = date('Y-m-d');

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'VS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_vitalio order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='VS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'VS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	    $billdate=$_REQUEST['billdate'];
	
	    $paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		
		$account = $_REQUEST['account'];
		$vitalipdate =  $_REQUEST['vitalipdate'];
		$vitaliptime =  $_REQUEST['vitaliptime'];
		$iodate = $_REQUEST['iodate'];
		$iotime = $_REQUEST['iotime'];
		$systolic = $_REQUEST['bpsystolic'];
		$diastolic = $_REQUEST['bpdiastolic'];
		$respiration = $_REQUEST['respiration'];
		$pulse = $_REQUEST['pulse'];
		$celsius = $_REQUEST['celsius'];
		$fahrenheit = $_REQUEST['fahrenheit'];
		$iv = $_REQUEST['ivquantity'];
		$fluids = $_REQUEST['fluidsquantity'];
		$vomitus = $_REQUEST['vomitusquantity'];
		$urine = $_REQUEST['urinequantity'];
		$secretion = $_REQUEST['secretionquantity'];
		
	
			
	  	
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ip_vitalio(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,systolic,diastolic,pulse,resp,tempc,tempf,iv,fluids,vomitus,urine,secretion,vitalipdate,vitaliptime,iodate,iotime)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$systolic','$diastolic','$pulse','$respiration','$celsius','$fahrenheit','$iv','$fluids','$vomitus','$urine','$secretion','$vitalipdate','$vitaliptime','$iodate','$iotime')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:inpatientactivity.php");
		exit;

}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
$docnumber=$_REQUEST["docnumber"];
}


if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'NHIF is already processed.';	
}

//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];




/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}

?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientname = $execlab['patientname'];
$bedno = $execlab['bed'];
$accountname = $execlab['accountname'];
$patienttype=$execlab['maintype'];

$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$ipdate = $res66['consultationdate'];
$nhifrebate = $res66['nhifrebate'];

$datediff = abs(strtotime($currentdate) - strtotime($ipdate));

$years5 = floor($datediff / (365*60*60*24));
$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
if($days5 == '0')
{
$days5 = 1;
}
$nhifrebateamount = $nhifrebate * $days5;

?>

<?php

$query2 = "select * from ip_vitalio order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='VS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'VS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}?>


<style type="text/css">
.bodytext313 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
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
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
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
 <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">



<table width="100%" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
		<td colspan="11" class="bodytext32"><strong>&nbsp;</strong></td>
	</tr>
	
	<tr>
		<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
		
		<td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		<strong>Patientcode</strong></td>
		<td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Bed No. </strong></td>
		<td width="33%" colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1">Account</span></td>
		</tr>       
	
	<tr>
		<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientname; ?></td>
		
		<td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?></td>
		<td align="left" valign="top" class="bodytext3"><?php echo $bedno; ?></td>
		<td colspan="2" align="left" valign="top" class="bodytext3"><?php echo $accountname; ?></td>
		</tr>
	<tr>
		<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		<td align="left" valign="middle" class="bodytext3">&nbsp;</td>
		<td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>			
		<td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		</tr>
	
	<tr>
		<td colspan="11" class="bodytext31"><strong><u>Visit Summary </u></strong></td>
	</tr>
	
	<tr>
	<?php 
		$query22=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_iptriage where patientcode='$patientcode' and visitcode='$visitcode' ");
		$exec22=mysqli_fetch_array($query22);
		$foodallergy = $exec22['foodallergy'];
		$drugallergy = $exec22['drugallergy'];
		$foodallergy = $exec22['foodallergy'];
		$emergencycontact = $exec22['emergencycontact'];
		$privatedoctor = $exec22['privatedoctor'];
		$weight = $exec22['weight'];
		$height = $exec22['height'];
		$bmi = $exec22['bmi'];
		$doctornotes = $exec22['notes'];
	    $ipconsultationdate = $exec22['consultationdate'];
	?>
	
	  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1">Height</span></td>
	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $height; ?></td>
  </tr>
	<tr>
	
	
		<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Drug Allergy </strong>  </span></td>
		<td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $drugallergy; ?></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext313"><strong>Weight</strong></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $weight; ?></td>
	</tr>       
	
	<tr>
		<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Food  Allergy </strong></td>
		<td align="left" valign="middle" class="bodytext3"><?php echo $foodallergy; ?></td>
		<td colspan="2" align="left" valign="middle" class="style1">BMI</td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $bmi; ?></td>
	</tr>
	<tr>
	<?php 
	$query36=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' ");
    $exec36=mysqli_fetch_array($query36);
	$res36recorddate = $exec36['recorddate'];
    //$drugallergy = $exec36['drugallergy'];
	
	?>
	  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
	  <td width="9%" align="left" valign="middle" class="style1">Discharge Date </td>
	  <td width="6%" align="left" valign="middle" class="bodytext3"><?php echo $res36recorddate; ?></td>
	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="style1"><a target="_blank" href="ipemrdischargesummary.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Discharge Summary</a></td>
	  </tr>
	<tr>
	  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><table width="433">
        <tr>
	  <td colspan="9" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				 <strong>VITALS INPUT </strong></td> 
     </tr>
				  
				   <tr>
		    <td width="69" class="bodytext3" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
			<td width="65"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>
			<td width="58"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Systolic</strong></td>
			<td width="62"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Diastolic</strong></td>
			<td width="56"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Pulse</strong></td>
			<td width="56"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Resp</strong></td>
	 </tr>
				  
       <?php
	   
	  $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
       $recorddate=$res31['recorddate'];
	   $recorddate=date("d/m/Y", strtotime($recorddate));
	   $recordtime=$res31['recordtime'];
	 
	   $systolic=$res31['systolic'];
	   $stolic_array[] =$systolic;
	   $highstolic=rsort($stolic_array);
	   $highstolic[0];
	  
	   $diastolic=$res31['diastolic'];
	   $diastolic_array[]=$diastolic;
	   $diasort[]=sort($diastolic_array);
	   $diasort[6];
	   //echo end($diastolic_array);
	   $lastIndex = key($diastolic_array);  
	   $last[] = $diastolic_array[$lastIndex];
	 
	   $resp=$res31['resp'];
	   $pulse=$res31['pulse'];
	   $tempc=$res31['tempc'];
	   $tempf=$res31['tempf'];
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
		 
		  <td height="25" width="69" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recorddate; ?></td>
		   <td width="65" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recordtime; ?></td>
		  <td width="58" class="bodytext3" valign="center"  align="center" 
               ><?php echo $systolic; ?></td>
		  <td width="62" class="bodytext3" valign="center"  align="center"><?php echo $diastolic; ?>
	      <td width="56" class="bodytext3" valign="center"  align="center" 
               ><?php echo $resp; ?></td>
		  <td width="56" class="bodytext3" valign="center"  align="center" 
               ><?php echo $pulse; ?></td>    
	    </tr>
		  <?php
		 }
		 ?>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
	  <td colspan="4" align="left" valign="middle" class="bodytext3"><table width="433">
        <tr>
          <td colspan="10" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>INPUT / OUTPUT </strong></td>
        </tr>
        <tr>
          <td class="bodytext3" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
          <td  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>
                    <td  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Vomitus</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Urine</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Diarrhea</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>N/Gast</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Drains</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Infused</strong></td>  
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Others</strong></td>           
          </tr>
        <?php
	   
	  $query32="select * from fluidbalance where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
	  $exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	  $num=mysqli_num_rows($exec32);
	  while($res32=mysqli_fetch_array($exec32))
	  { 
       $fluids=$res32['fluids'];
	   $recorddate=date("d/m/Y", strtotime($res32['recorddate']));
	   $recordtime=$res32['recordtime'];
	   $vomitus=$res32['vomitus'];
	   $urine=$res32['urine'];
	   $drains=$res32['drains'];
       $diarrhea=$res32['diarrhea'];
	   $ngast=$res32['ngast'];
	   $bottle=$res32['bottle'];
	   $amount=$res32['amount'];
	   $infused=$res32['infused'];
	   $others=$res32['others'];


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
          <td height="10" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recorddate; ?></td>
          <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $recordtime; ?></td>
                   <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $vomitus; ?></td>
          <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $urine; ?></td>
          <td  align="center" valign="center" 
				class="bodytext3"><?php echo $diarrhea; ?></td>
           <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $ngast; ?></td>
          <td  align="center" valign="center" 
				class="bodytext3"><?php echo $drains; ?></td> 
           <td  align="center" valign="center" 
				class="bodytext3"><?php echo $infused; ?></td>    
           <td  align="center" valign="center" 
				class="bodytext3"><?php echo $others; ?></td>                 
        </tr>
        <?php
		 }
		 ?>
        <tr>
          <td>&nbsp;</td>
        </tr>
              </table></td>
  </tr>
	
	<tr>
		<td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><table width="433">
         <tr>
	  <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				 <strong>LAB TESTS </strong></td> 
     </tr>
	
				  <?php
      $query33="select * from  ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname " ;
	  $exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33);
	  $num=mysqli_num_rows($exec33);
	  while($res33=mysqli_fetch_array($exec33))
	  { 
		
		$itemname='';
		//$itemname=$res33['itemname'];
		$labdocnumber=$res33['docnumber'];
		$itemname=$res33['itemname'];
         
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
		 
		  <td height="10" width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $itemname; ?></td>
		   <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><a href="iplabresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $labdocnumber; ?>" target="_blank"><strong>View</strong></a></td>
		</tr>
		   <?php
		
		 
		 }
		 ?>
        </table></td>
       
	    <td colspan="4" align="left" valign="middle" class="bodytext3"><table width="434">
          <tr>
	  <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				 <strong>RADIOLOGY TESTS </strong></td> 
     </tr>
				  <?php
  				  $query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode='$visitcode' order by auto_number desc";
				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res1 = mysqli_fetch_array($exec1))
				  {
				  $visitcode = $res1['visitcode'];
				  $visitdate = $res1['registrationdate'];
				  ?>
                  <tr>
				  <?php 
				  if($searchpatient!= '') { ?> 
                    <td width="264" bgcolor="#ffffff" class="bodytext3"><?php echo $visitcode; ?>&nbsp;</td>
                    <td width="158" bgcolor="#ffffff" class="bodytext3"><?php echo $visitdate; ?>&nbsp;</td>
                  <?php } ?>
				  </tr>
				  <?php
				  $query2 = "select * from ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname ";
				  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				  while ($res2 = mysqli_fetch_array($exec2))
				  {
				  $labtestname = $res2['itemname'];
				  $labdocnumber = $res2['docnumber'];
				  
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
				  
			<?php }  }?>	  
</table>	
      </table>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top"><table width="433">
      <tr>
        <td colspan="8" align="center" valign="middle"  bgcolor="#ecf0f5" class="style1">PROGRESS NOTES </td>
      </tr>
	 
      <?php
      $query34="select * from  ip_progressnotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;
	  $exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34);
	  $num=mysqli_num_rows($exec34);
	  while($res34=mysqli_fetch_array($exec34))
	  { 
		$notes=$res34['notes'];
		$recorddate=$res34['recorddate'];
		
		
		
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
	     <td width="94"  align="center" valign="center"  class="bodytext3" 
               ><?php echo  date("d/m/Y", strtotime($recorddate)); ?></td>
        <td width="327"  align="center" valign="center"  class="bodytext3" 
               ><div align="left"><?php echo $notes; ?></div></td>
	  </tr>
	  
	   <?php
		 } 
		 ?>
	  
	  <?php 
	      $query35="select * from  ip_doctornotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;
	  $exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35);
	  $num=mysqli_num_rows($exec35);
	  while($res35=mysqli_fetch_array($exec35))
	  { 
		$ipdoctornotes=$res35['notes'];
		$iprecorddate=$res35['recorddate'];
		
		
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
         <td class="bodytext3" valign="center"  align="center"><?php echo  date("d/m/Y", strtotime($iprecorddate)); ?>
         <td  class="bodytext3" valign="center"  align="center" 
               ><div align="left"><?php echo $ipdoctornotes; ?></div></td>
      </tr>
      <?php } ?>
		 
		
    </table>	  
	</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>