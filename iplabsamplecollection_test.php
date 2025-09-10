<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';
$docno = $_SESSION['docno'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];


if (isset($_REQUEST["q_itemcode"])) { $q_itemcode = $_REQUEST["q_itemcode"]; } else { $q_itemcode = ""; }
if (isset($_REQUEST["q_refno"])) { $q_refno = $_REQUEST["q_refno"]; } else { $q_refno = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$docnumber=$_REQUEST['docnumber'];
$comments = $_REQUEST['comments'];
$dateonly = date("Y-m-d");
$f= 0;
foreach($_POST['anumber1'] as $key => $value)
		{
		$labname=$_POST['lab'][$key];
		$itemcode=$_POST['code'][$key];
		$sample=$_POST['sample'][$key];
		$itemstatus=$_POST['status'][$key];
		$remarks=$_POST['remarks'][$key];
		$anumber1=$_POST['anumber1'][$key];
		
		$transferloc = isset($_POST['transferlocation'][$key])?$_POST['transferlocation'][$key]:'|';
		//$transferlocsplit = explode('|',$transferloc);
		$transferloccode = isset($_POST['transferlocationcode'][$key])?$_POST['transferlocationcode'][$key]:'';
		$transferlocname = isset($_POST['transferlocation'][$key])?$_POST['transferlocation'][$key]:'';
		
		if(isset($_POST['ack']))
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	foreach($_POST['ack'] as $check => $value)
		{
		$acknow=$check;
	
		if($acknow == $anumber1)
		{
		$status='completed';
		$status2='norefund';
		break;
		}
		else
		{
		$status='pending';
		}
	}
$status1='norefund';
	foreach($_POST['ref'] as $check1 => $value)
	{
	$refund=$check1;
	if($refund == $anumber1)
	{
	$status1='refund';
	$status2='refund';
	$status='completed';
	break;
	}
	else
	{
	$status1='norefund';
	}
	}
	//echo $status1;
		
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($labname != "")
   {
   	if(($status == 'completed')&&($itemstatus != ''))
   {	
	$paynowbillprefix = 'IPS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from opipsampleid_lab where patientcode <> 'walkin' and sampleid <> '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$sampleidno = $res2["sampleid"];
$billdigit=strlen($sampleidno);
if ($sampleidno == '')
{
	$sampleid ='IPS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$sampleidno = $res2["sampleid"];
	$sampleid = substr($sampleidno,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$sampleid = intval($sampleid);
	$sampleid = $sampleid + 1;
	$maxanum = $sampleid;	
	$sampleid = 'IPS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
if($f == 0)
{
$maxanum1 = $maxanum;
}
$sampleprefex = substr($sample,0,3);
$sampleid1 = $sampleprefex.$maxanum1;
$sampleidno1 = $maxanum1;

$f++;
if($itemstatus != 'discard') { 

 $query26="insert into ipsamplecollection_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber,comments,sampleid,locationcode,locationname,transferloccode,transferlocname,username)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$docnumber','$comments','$sampleid','$locationcode','$locationname','$transferloccode','$transferlocname','$username')";
 $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die("Error in query26".mysqli_error($GLOBALS["___mysqli_ston"]));
   
   $query261="insert into opipsampleid_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber,comments,sampleid,locationcode,locationname)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$docnumber','$comments','$sampleid','$locationcode','$locationname')";
$exec261=mysqli_query($GLOBALS["___mysqli_ston"], $query261) or die("Error in query261".mysqli_error($GLOBALS["___mysqli_ston"]));
   
   $getdob = "select dateofbirth,gender from master_customer where customercode like '$patientcode'";
  $execdob = mysqli_query($GLOBALS["___mysqli_ston"], $getdob) or die("Error in getdob".mysqli_error($GLOBALS["___mysqli_ston"]));
  $resdob = mysqli_fetch_array($execdob);
 $dateofbirth = $resdob['dateofbirth'];
 $gender = $resdob['gender'];
  list($year, $month, $day) = explode("-", $dateofbirth);
	if($dateofbirth=="0000-00-00" ||$dateofbirth>=date("Y-m-d"))
	{
    $age = 0;
	$duration = 'Days';
	}
	else{
	$age  = date("Y") - $year;
	$duration = 'Years';
	if($age == 0)
	{
	$age = date("m") - $month;
	$duration = 'Months';
	if($age == 0)
	{
	$age = date("d") - $day;
	$duration = 'Days';
	}
	}
	}
	$qryward = "select ward from ip_bedallocation where visitcode = '$visitcode'  and recordstatus like ''
				union select ward from ip_bedtransfer where visitcode = '$visitcode'  and recordstatus like ''";
	$execward = mysqli_query($GLOBALS["___mysqli_ston"], $qryward) or die("Error in qryward".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resward = mysqli_fetch_array($execward);
	$wardanum = $resward['ward'];
	$qryward2 = "select ward from master_ward where auto_number = '$wardanum'";
	$execward2 = mysqli_query($GLOBALS["___mysqli_ston"], $qryward2) or die("Error in qryward2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resward2 = mysqli_fetch_array($execward2);
	$ward = $resward2['ward'];

	$datetime = date('Y-m-d h:i:s');
 $qrygetparam = "select * from master_test_parameter where labcode like '$itemcode'";
  $execgetparam = mysqli_query($GLOBALS["___mysqli_ston"], $qrygetparam) or die("Error in qrygetparam".mysqli_error($GLOBALS["___mysqli_ston"])); 
  while($resparam = mysqli_fetch_array($execgetparam))
  {
  $parametername = $resparam['parametername'];
  $parametercode = $resparam['parametercode'];
 $qryparam = "INSERT INTO `pending_test_orders`(`patientname`,`patientcode`, `visitcode`, `testcode`, `testname`, `age`,`duration`, `gender`, `sample_id`,`full_sample_id`, `sample_type`, `patient_from`,`ward`, `dob`, `samplecollectedby`, `sampledate`, `parametercode`, `parametername`) values ('$patientname','$patientcode','$visitcode','$itemcode','$labname','$age','$duration','$gender','$sampleidno1','$sampleid1','$sample','In-Patient','$ward','$dateofbirth','$username','$datetime','$parametercode','$parametername')";
mysqli_query($GLOBALS["___mysqli_ston"], $qryparam) or die("Error in qryparam".mysqli_error($GLOBALS["___mysqli_ston"]));
  } 
   
   $query29="update ipconsultation_lab set labsamplecoll='$status',labrefund='$status1',docnumber='$docnumber',comments='$comments', sampleid = '$sampleid' where labitemcode = '$itemcode' and patientvisitcode='$visitcode' and auto_number='$anumber1'";
   $exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query29".mysqli_error($GLOBALS["___mysqli_ston"]));
   
   }
   
     $query42="select * from master_ipvisitentry where visitcode='$visitcode' and itemrefund='refund'";
   $exec42=mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
   $num42=mysqli_num_rows($exec42);
   if($num42 > 0)
   {
  $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='refund' where visitcode='$visitcode'") or die("Error in Query39".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
   else
   {
   $query39=mysqli_query($GLOBALS["___mysqli_ston"], "update master_ipvisitentry set itemrefund='$status2' where visitcode='$visitcode'") or die("Error in Query39".mysqli_error($GLOBALS["___mysqli_ston"]));
   }
}

  	}
	
}

  header("location:collectedsampleviewip.php?patientcode=$patientcode&&visitcode=$visitcode&&docnumber=$docnumber");
  exit();
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPLS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipsamplecollection_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPLS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'IPLS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script src="jquery/jquery-1.11.3.min.js"></script>
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>

$(document).ready(function(){
	
	$("#comments").hide();
    $(".refcheck").click(function(){
		if (this.checked) {
        $("#comments").show();
		
		}
		else
		{
		 $("#comments").hide();	
		}
    });
});


function acknowledgevalid()
{
var chks = document.getElementsByClass('ackcheck');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}

var chks1 = document.getElementsByClass('refcheck');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;
}
}

if (hasChecked == false && hasChecked1 == false)
{
alert("Please either acknowledge/refund a sample  or click back button on the browser to exit sample collection");
return false;
}
for(n=1;n<10;n++)
	{
if(document.getElementById("status"+n+"").value == 'discard')
{
if(document.getElementById("remarks"+n+"").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks"+n+"").focus();
return false;
}
}

if(document.getElementById("status"+n+"").value == 'transfer')
{
if(document.getElementById("transferlocation"+n+"").value == '')
{
alert("Please Select Location");
document.getElementById("transferlocation"+n+"").focus();
return false;
}
}

}
return true;
}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
document.getElementById("ref"+varserialnumber+"").disabled = false;
}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{

document.getElementById("ack"+varserialnumber1+"").disabled = true;
document.getElementById("remarks"+varserialnumber1+"").style.display='block';

}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
	document.getElementById("remarks"+varserialnumber1+"").style.display = 'none';
}
}

function funcremarksshow(k)
{
var i = k;
//alert(k);
  for(i=1;i<10;i++)
	{
	if (document.getElementById("status"+i+"") != null) 
	{
		if (document.getElementById("status"+i+"").value == 'discard') 
		{	
			document.getElementById("remarks"+i+"").style.display = '';
			document.getElementById("transferlocation"+i+"").style.display = 'none';
		}
		if (document.getElementById("status"+i+"").value == 'transfer') 
		{	
			document.getElementById("transferlocation"+i+"").style.display = '';
			document.getElementById("remarks"+i+"").style.display = 'none';
		}
	}
	}	
	
}

function funcremarkshide()
{			
	for(i=1;i<10;i++)
	{
	if (document.getElementById("status"+i+"") != null) 
	{
		if (document.getElementById("status"+i+"").value == 'completed')  
		{	
			document.getElementById("remarks"+i+"").style.display = 'none';
			document.getElementById("transferlocation"+i+"").style.display = 'none';
		}
	}
	}		
}

function funcstatus(j)
{
var j = j;
if(document.getElementById("status"+j+"").value == 'discard')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'transfer')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'completed')
{
funcremarkshide();
}
}

function validcheck()
{
if(confirm("Do You Want To Save The Record?")==false){return false;}	
}

function funcOnLoadBodyFunctionCall()
{
funcremarkshide();

}
</script>
<script>
$(function() {
	
$('.transfer').autocomplete({
		
	source:'ajaxtransferlocsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
		    var textid = $(this).attr('id');
			var tid = textid.split('transferlocation');
			//alert(tid[1]);
			var loccode = ui.item.acccode;
			var locname = ui.item.accname;
			
			$('#transferlocationcode'+tid[1]).val(loccode);
			
			},
    });
});
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

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
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.ui-menu .ui-menu-item {
	margin:0;
	padding: 0;
	zoom: 1 !important;
}	
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];


$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];




$patientdob=$res69['dateofbirth'];
if($patientdob=="0000-00-00" ||$patientdob>=date("Y-m-d"))
{


    $year_diff  = 0;
    $month_diff = 0;
    $day_diff   = 0;
	}
else{
 list($year, $month, $day) = explode("-", $patientdob);

    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
	}
	
$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);


$patientage=$res78['age'];
$patientgender=$res78['gender'];
$patientsubtype=$res78['subtype'];

$subtype="select labtemplate from master_subtype where auto_number='$patientsubtype'";
$exesub=mysqli_query($GLOBALS["___mysqli_ston"], $subtype)or die("Error in subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
$ressub=mysqli_fetch_array($exesub);
$labtemplate=$ressub['labtemplate'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="iplabsamplecollection.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
	  <td class="bodytext3" width="25%" align="left" valign="middle" bgcolor="#ecf0f5">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="27%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               
               <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td width="23%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>
                  </td>
              </tr>
			 
		
			  <tr>

			    <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td class="bodytext3" width="25%" align="left" valign="middle" >
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" class="bodytext3" valign="top" >
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
              
                
			    </tr>
				
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type ="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php if($year_diff>0){echo $year_diff." year";} else {if($month_diff>0){echo $month_diff." month";} else{echo $day_diff." days";}} ?>
				&
				<input name="patientgender" type="hidden" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				
				  </tr>
			    
				  <tr>
				  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
				  
				  <tr>
				  <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Primary Diagnosis</strong></td>
                
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
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Type</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
                <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311"><strong>Remarks</strong></td>
			      </tr>
			<?php

			$colorloopcount = '';
			$sno = '';

						$queryaa1 = "select categoryname,auto_number from master_categorylab order by categoryname ";
						$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($resaa1 = mysqli_fetch_array($execaa1))
						{
				
						$data_count=0;
						$categoryname = $resaa1["categoryname"];
						$auto_number = $resaa1["auto_number"];
					?>
	  		<?php
			$tno=0;
			$ssno=0;
			$totalamount=0;			
			echo $query61 = "select a.* from ipconsultation_lab as a  JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname'  where a.patientcode = '$patientcode' and a.patientvisitcode = '$visitcode' and a.labsamplecoll='pending' and a.labrefund='norefund' and a.labitemname <> '' group by a.labitemname,a.auto_number";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
while($res61 = mysqli_fetch_array($exec61))
{
$labname =$res61["labitemname"];
$labitemcode=$res61["labitemcode"];
$auto_number=$res61["auto_number"];


if($tno==0){
	echo '<tr> <td colspan="6" class="bodytext31" bgcolor="oldlace" > '.$categoryname .' </td> </tr>';
}
$tno++;

if($labtemplate =='')
{
$query68="select * from master_lab where itemcode='$labitemcode' and status <> 'deleted'";
}
else
{
$query68="select * from $labtemplate where itemcode='$labitemcode' and status <> 'deleted'";
}

$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$samplename=$res68['sampletype'];
$itemcode=$res68['itemcode'];
$query41="select * from master_categorylab where categoryname='$labname'";
$exec41=mysqli_query($GLOBALS["___mysqli_ston"], $query41);
$num41=mysqli_num_rows($exec41);
if($num41 > 0)
{
//$itemcode=$ssno;
$ssno=$ssno + 1;
}
$sno = $sno + 1;
?>
  <tr>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labname;?></div></td>
		<input type="hidden" name="lab[<?= $auto_number ?>]" value="<?php echo $labname;?>">
		<input type="hidden" name="code[<?= $auto_number ?>]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="anumber1[<?= $auto_number ?>]" value="<?php echo $auto_number; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $samplename; ?>
       </div></td><input type="hidden" name="sample[<?= $auto_number ?>]" value="<?php echo $samplename; ?>">
        <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[<?= $auto_number ?>]" class="ackcheck" value="<?php echo $anumber1; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[<?= $auto_number ?>]"  class="refcheck" id="ref<?php echo $sno; ?>" value="<?php echo $anumber1; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>
        <td class="bodytext31" valign="center"  align="left"><div align="center">
		 <select name="status[<?= $auto_number ?>]" id="status<?php echo $sno; ?>" onChange="return funcstatus('<?php echo $sno; ?>');">
		 <option value="completed">Completed</option>
		 <option value="discard">Discard</option>
		 <option value="transfer">Transfer</option>
		 </select>
		 </div></td>
		<td align="center" valign="center" class="bodytext311" id="remarks123<?php echo $sno; ?>"><textarea name="remarks[<?= $auto_number ?>]" id="remarks<?php echo $sno; ?>" style="display:none"></textarea>
		<input type="text" class="transfer" name="transferlocation[<?= $auto_number ?>]" id="transferlocation<?php echo $sno; ?>" style="border: 1px solid #001E6A;">
        <input type="hidden" name="transferlocationcode[<?= $auto_number ?>]" id="transferlocationcode<?php echo $sno; ?>" style="border: 1px solid #001E6A;">
		</td>
				</tr>
			<?php 
		
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
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             </tr>
             <tr>
             <td >&nbsp;</td>
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>