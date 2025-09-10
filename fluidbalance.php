<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");

  $locationcode = $_REQUEST['locationcode'];	
  $locationcode1=$_REQUEST['locationno'];
$query1 = "select * from master_location where locationcode='$locationcode' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
						
			}


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'VIO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from fluidbalance order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='VIO-'.'1';
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
	
	
	$billnumbercode = 'VIO-' .$maxanum;
	$openingbalance = '0.00';
}

	    $billdate=$_REQUEST['billdate'];
	
	    $paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$weight = $_REQUEST['weight'];
		$account = $_REQUEST['account'];
		$iv = $_REQUEST['iv'];
		$ivdescription = $_REQUEST['ivdescription'];
		$alimentary = $_REQUEST['alimentary'];
		$alimentarydesc = $_REQUEST['alimentarydesc'];
		$intravenoustype = $_REQUEST['intravenoustype'];
		$alimentarytype = $_REQUEST['alimentarytype'];
		$bottle = $_REQUEST['bottle'];
		$amount = $_REQUEST['amount'];
		$infused = $_REQUEST['infused'];
		$vomitus = $_REQUEST['vomitus'];
		$diarrhea = $_REQUEST['diarrhea'];
		$ngast = $_REQUEST['ngast'];
		$others = $_REQUEST['others'];
		$urine = $_REQUEST['urine'];
	  	$drains = $_REQUEST['drains'];
		
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into fluidbalance(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,iv,ivdescription,alimentary,alimentarydesc,intravenoustype,alimentarytype,bottle,amount,infused,vomitus,diarrhea,ngast,others,urine, drains,locationcode)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$iv','$ivdescription','$alimentary','$alimentarydesc','$intravenoustype','$alimentarytype','$bottle','$amount','$infused','$vomitus','$diarrhea','$ngast','$others','$urine','$drains','$locationcode1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:inpatientactivity.php");
		exit;

}

if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
$docnumber=$_REQUEST["docnumber"];
}

$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];

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
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
$patientgender=$execlab['gender'];
$patientname = $execlab['customerfullname'];
$billtype = $execlab['billtype'];
$patienttype=$execlab['maintype'];


$query123 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ipvisitentry where visitcode = '$visitcode' "); 
$exec123 = mysqli_fetch_array($query123);
$patientlocation = $exec123['locationname']; 
$patientlocationcode = $exec123['locationcode'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysqli_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");
$execplan=mysqli_fetch_array($queryplan);
$patientplan1=$execplan['planname'];

$query19=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ");
$exec19=mysqli_fetch_array($query19) or die ("Error in query19".mysqli_error($GLOBALS["___mysqli_ston"]));
$res19ward=$exec19['ward'];
$res19bed=$exec19['bed'];

$query30=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ward where auto_number='$res19ward' ");
$exec30=mysqli_fetch_array($query30);
$res30ward=$exec30['ward'];

$query31 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_bed where auto_number='$res19bed' ");
$exec31=mysqli_fetch_array($query31);
$res31bed=$exec31['bed'];

$query32 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_iptriage where patientcode='$patientcode' and visitcode = '$visitcode' ");
$exec32=mysqli_fetch_array($query32);
$res32weight=$exec32['weight'];
?>
<?php
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'VIO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from fluidbalance order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='VIO-'.'1';
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
	
	
	$billnumbercode = 'VIO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}?>

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


//Print() is at bottom of this page.

</script>



<script language="javascript">

var grandtotal=0;
function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}
function validcheck()
{
if(document.form1.nhifclaim.value == '0.00')
{
alert("NHIF not applicable for this patient");
document.getElementById("nhifclaim").focus();
return false;
}
}
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency()
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter a whole number");
		return false;
    }
    return true;
}

function MinimumBP()
{
	if(document.form1.bpsystolic.value > 120 && document.form1.bpsystolic.value !="")
	{
		document.form1.bpsystolic.style.background="#FFFF66";
	}
	else
	{
		document.form1.bpsystolic.style.background="#FFFFFF";
	}
}
function MaximumBP()
{
	if(document.form1.bpdiastolic.value < 80)
	{
		document.form1.bpdiastolic.style.background="#FFFF66";
	}
	else
	{
		document.form1.bpdiastolic.style.background="#FFFFFF";
	}
}

function funcamountcalc()
{

if(document.getElementById("units").value != '')
{
var units = document.getElementById("units").value;
var rate = document.getElementById("rate4").value;
var amount = units * rate;

document.getElementById("amount").value = amount.toFixed(2);
}
}

function FunctionTemperature()
{
	if(document.form1.celsius.value != "" )
	{
		var fahrenheit = document.getElementById("fahrenheit").value;
		var celsius = document.getElementById("celsius").value;
		var fahrenheit = Math.round(1.8 * celsius + 32);
		document.getElementById("fahrenheit").value = fahrenheit;
	}
	
}

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
<form name="form1" id="frmsales" method="post" action="fluidbalance.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td width="99%" valign="top"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1121"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
			 <tr>
                <td colspan="14" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
		<tr>
                <td colspan="10" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<tr>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td width="31%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<strong>Patientcode</strong></td>
                <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?><a target="_blank" href="addiptriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
				<td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
				<td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />
                  <?php echo $visitcode; ?></td>
				<td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><a href="addipkeyinfo.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>" target="_blank"><strong>Key Info </strong></a><a href="addipkeyinfo.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>" target="_blank"></a></td>
				</tr>       
               
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1">Age</span></td>
                <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?></td>			
			   	  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style1">Gender</span></td>
                <td align="left" valign="top" class="bodytext3"><?php echo $patientgender; ?></td>	
                <td align="left" valign="top" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="top" class="bodytext3"><input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
                  <input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
                  <?php echo $patientaccount1; ?> </td>
                <td align="left" valign="top" class="bodytext3">&nbsp;</td>
			   </tr>
				  
				  <tr>
				    <td align="left" valign="middle" class="style1"><strong>Ward/Bed</strong></td>
				    <td class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?></td>
				    <td align="left" valign="middle" class="style1"><span class="bodytext3"><strong>Doc No</strong></span></td>
				    <td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                      <?php echo $billnumbercode; ?> </td>
			        <td class="bodytext3"><strong>Date</strong></td>
			        <td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                      <?php echo $dateonly; ?> </td>
			        <td class="bodytext3">&nbsp;</td>
				  </tr>
				  
				  <tr>
				  
				  			 <td align="left" valign="middle" class="style1">Location</td>
				             <td class="bodytext3"><?php echo $locationname; ?></td>
							 <td align="left" valign="middle" class="style1">Weight</td>
				             <td class="bodytext3"><?php echo $res32weight; ?></td>	
							 <td> <input type="hidden" name="locationno" id="locationno" value="<?php echo $locationcode; ?>" ></td>
							 
							 
							 	
                 <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				<td colspan="4" class="bodytext3">&nbsp;</td>
				  </tr>
                  				
				 		
				 
				  	<tr>
                <td colspan="10" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
				        <tr>
				   <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Intake</strong></span></td>
		           <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		           <td width="8%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
		           <td width="21%" align="right" valign="middle" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong> Output	</strong></span>	</td>
		           <td width="16%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
		           <td width="14%" align="left" valign="middle" class="bodytext3"><a target="_blank" href="viewvitalinputoutput.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
		          </tr>
				  
				        <tr>
				          <td colspan="2" align="center" valign="middle" class="bodytext3"><strong>Intravenous</strong></td>
				          <td colspan="2" align="center" valign="middle" class="style1">Alimentary</td>
				          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				          <td align="center" valign="middle" class="bodytext3">&nbsp;</td>
				          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
		          </tr>
		          <tr>
				 <td width="9%" align="center" valign="middle" class="bodytext3">Type</td>
				  <td width="12%" align="left" valign="middle" class="bodytext3"><input name="intravenoustype" type="text" id="intravenoustype"  size="20"></td>
				  <td width="7%" align="left" valign="middle" class="bodytext3">Type</td>
				  <td width="13%" align="left" valign="middle" class="bodytext3"><input name="alimentarytype" type="text" id="alimentarytype"  size="20"></td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Vomit- ml</td>
				  <td align="left" valign="middle" class="bodytext3"><input type="text" name="vomitus" id="vomitus" value="" size="8" onKeyPress="return isNumber(event)"></td>
				  <td align="left" valign="middle" class="bodytext3"><a target="_blank" href="viewfluidbalance.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"><strong>View I/O </strong></a></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Amount- ml</td>
				  <td align="left" valign="middle" class="bodytext3"><input name="bottle" type="text" id="bottle"  onKeyPress="return isNumber(event)" size="8"></td>
				  <td align="left" valign="middle" class="bodytext3">Amount- ml</td>
				  <td align="left" valign="middle" class="bodytext3"><input name="amount" type="text" id="amount"  onKeyPress="return isNumber(event)" size="8"></td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Diarrhea- ml</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="diarrhea" id="diarrhea" value="" size="8" onKeyPress="return isNumber(event)"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Infused- ml</td>
				  <td align="left" valign="middle" class="bodytext3"><input name="infused" type="text" id="infused"  onKeyPress="return isNumber(event)" size="8"></td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">N/Gast- ml</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="ngast" id="ngast" size="8" value="" style="text-align:left" onKeyPress="return isNumber(event)"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Others- ml</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="others" id="others" size="8" value="" style="text-align:left"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Urine- ml</td>
				  <td align="left" valign="middle" class="bodytext3"><input type="text" name="urine" id="urine" size="8" value="" style="text-align:left" onKeyPress="return isNumber(event)"></td>
				  <td align="left" valign="middle" class="bodytext3"><a target="_blank" href="viewvitalinputoutput.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
				</tr>
                <tr>
				 <td align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Drains- ml</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="drains" id="drains" size="8" value="" style="text-align:left"></td>
				</tr>
				
				
			<tr>
		<td colspan="2">&nbsp;		</td>
		</tr>
		       </tbody>
        </table>		</td></tr>
		
		<tr>
		 <td width="1121" class="bodytext31" align="left">User Name: &nbsp;&nbsp;
		   <input type="hidden" name="username" id="username" value="" class="bal1"><strong><?php echo strtoupper($username); ?></strong></td>		
		</tr>
             
               <tr>
	  <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" />		</td>
	  </tr>
              
            </tbody>
        </table>
	  </td>
		</tr>
     
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>