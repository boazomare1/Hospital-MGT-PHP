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

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';


$docno = $_SESSION["docno"];
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];


if (isset($_REQUEST["q_itemcode"])) { $q_itemcode = $_REQUEST["q_itemcode"]; } else { $q_itemcode = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   


//////////////////// FOR AUDIT RESULT ENTRY //////////////////				  
 $paynowbillprefix_ad = 'ARE-';
$paynowbillprefix1_ad=strlen($paynowbillprefix_ad);
$query2_ad = "select * from audit_resultentry_lab order by auto_number desc limit 0, 1";
$exec2_ad = mysqli_query($GLOBALS["___mysqli_ston"], $query2_ad) or die ("Error in Query2_ad".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2_ad = mysqli_fetch_array($exec2_ad);
$billnumber_ad = $res2_ad["audit_id"];
$billdigit_ad=strlen($billnumber_ad);
if ($billnumber_ad == '')
{
	$billnumbercode_ad ='ARE-'.'1';
}
else
{
	$billnumber_ad = $res2_ad["audit_id"];
	$billnumbercode_ad = substr($billnumber_ad,$paynowbillprefix1_ad, $billdigit_ad);
	//echo $billnumbercode_ad;
	$billnumbercode_ad = intval($billnumbercode_ad);
	$billnumbercode_ad = $billnumbercode_ad + 1;

	$maxanum_ad = $billnumbercode_ad;
	$billnumbercode_ad = 'ARE-' .$maxanum_ad;
	//echo $companycode;
}
//////////////////// FOR AUDIT RESULT ENTRY //////////////////	


$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
$docnumber=$_REQUEST['docnumber'];
$lab_comments = $_REQUEST['lab_comments'];
$samplecollectiondocnumber=$_REQUEST['samplecollectiondocno'];
$accountname = $_REQUEST['account'];
$sampleid = $_REQUEST['sampleid'];


$query231 = "select * from master_employee where username='$username'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res551 = mysqli_fetch_array($exec551);
$location = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
$store = $res751['store'];
$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
	 $labname=$_POST['lab'][$key];
		 $itemcode=$_POST['code'][$key];
		$resultvalue=$_POST['result'][$key];
		$unit=$_POST['units'][$key];
		$referencevalue=$_POST['reference'][$key];
		$refname = $_POST['referencename'][$key];
		$refcomments = $_POST['refcomments'][$key];
		
		$radiology= $_POST['radiology'][$key];
		
		$color = $_POST['color'][$key];	

		$equipmentname = $_POST['eqname'];
		$equipmentcode = $_POST['eqid'];	
		
		foreach($_POST['ack'] as $ch)
		{
		 $acknow=$ch;
		
		if($acknow == $itemcode)
		{
		
		/* $query29=mysqli_query($GLOBALS["___mysqli_ston"], "select sampleid from ipsamplecollection_lab where itemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$samplecollectiondocnumber'");
		$res29 = mysqli_fetch_array($query29);
		$sampleid = $res29['sampleid']; */
		$status1='completed';
		$query26="INSERT into ipresultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,referencecomment,radiology,color,sampleid,username,equipmentcode,equipmentname,locationcode,locationname)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$refcomments','$radiology','$color','$sampleid','$username','$equipmentcode','$equipmentname','$locationcode','$locationname')";
   $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

   // FOR AUDIT ENTRY
   $query262="INSERT into audit_resultentry_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,resultvalue,referencerange,referenceunit,docnumber,referencename,account,referencecomments,radiology,color,sampleid,username,equipmentcode,equipmentname,audit_id,datetime,ipaddress,locationname,locationcode)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$resultvalue','$referencevalue','$unit','$docnumber','$refname','$accountname','$refcomments','$radiology','$color','$sampleid','$username','$equipmentcode','$equipmentname','$billnumbercode_ad','$updatedatetime','$ipaddress','$locationname','$locationcode')";
   $exec262=mysqli_query($GLOBALS["___mysqli_ston"], $query262) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   // FOR AUDIT ENTRY

   
 
   $query29=mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE ipconsultation_lab set resultentry='$status1', lab_comments='$lab_comments' where labitemcode='$itemcode' and patientvisitcode='$visitcode' and docnumber='$samplecollectiondocnumber' and sampleid='$sampleid'");
   
   $query67 = "update ipsamplecollection_lab set resultentry='$status1' where itemcode = '$itemcode' and patientvisitcode='$visitcode' and sampleid='$sampleid'";
   $exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));
   
		}
		
	}
	 
		    $query31 = "select * from master_lablinking where labcode = '$itemcode' and recordstatus = ''"; 
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num31 = mysqli_num_rows($exec31);
	while($res31 = mysqli_fetch_array($exec31))
	{
	$pharmacyitemcode = $res31['itemcode'];
	$pharmacyitemname = $res31['itemname'];
	$pharmacyquantity = $res31['quantity'];
	
	$query311 = "select * from master_itempharmacy where itemcode = '$pharmacyitemcode'"; 
	$exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res311 = mysqli_fetch_array($exec311);
	$pharmacyrate = $res311['rateperunit'];
	$categoryname = $res311['categoryname'];
	
	$pharmacyamount = $pharmacyrate * $pharmacyquantity;
	
	$query57 = "select * from purchase_details where itemcode='$pharmacyitemcode'";
//echo $query57;
	$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);
	$num57=mysqli_num_rows($res57);
	//echo $num57;
	while($exec57 = mysqli_fetch_array($res57))
	{
	 $batchname = $exec57['batchnumber']; 
//echo $batchname;
$companyanum = $_SESSION["companyanum"];
			 $itemcode = $pharmacyitemcode;
			 $batchname = $batchname;		
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	 $currentstock;
	if($currentstock > 0 )
	{
	
	mysqli_query($GLOBALS["___mysqli_ston"], "insert into pharmacysales_details(itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,categoryname)values('$pharmacyitemname','$pharmacyitemcode','$pharmacyquantity','$pharmacyrate','$pharmacyamount','$batchname','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly1','$accountname','$docnumber','$timeonly','$location','$store','$categoryname')");

	}
	}
	}
	
		 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");

	
}
header("location:samplecollection.php");
 exit;
 

}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="css/autocomplete.css">    -->
<script>
function equipmentsearch(){
	//$("#eqname"+sno).val('');
	$("#eqid").val('');
	
	$('#eqname').autocomplete({
	source:"ajaxequipmentname.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var citemnamevalue=ui.item.value;
			var citemname=ui.item.citemname;
			var citemcode=ui.item.citemcode;
			$("#eqname").val(citemname);
			$("#eqid").val(citemcode);
			},
    
	});
}

 
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
break;
}
}
if (hasChecked == false)
{
alert("Please acknowledge a lab item  or click back button on the browser to exit lab result entry");
return false;
}
return true;
}
</script>
<script>

function validcheck()
{
	// var sno = document.getElementById("serialnumber").value;
// for(var i = 1; i<= sno; i++){
	var eorm = document.getElementById("eqname").value;
	var eoid = document.getElementById("eqid").value;
	// var acks = document.getElementById("ack").value;
	var checkack = document.getElementById("ack").checked;
	if(checkack == true){
		if(eoid == ''){
			alert('Please select the Equipment from the list');
			$("#eqname").focus();
			return false;
		}
	}
	else{
		alert("Please acknowledge a lab item  or click back button on the browser to exit lab result entry");
		return false;
	}
	
 
if(confirm("Do You Want To Save The Record?")==false){return false;}		
}
function validcheck1()
{
var varUserChoice; 
	varUserChoice = confirm('Have you entered all the results? Once acknowledged, patient will exit from View Samples. Please Confirm.'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		document.getElementById("ack").checked = false;
	}
	if(document.getElementById("ack").checked == false){
		
		$('#eqname').hide();
		$('#eqname').val('');
		$('#eqid').val('');
		
	}
	else{
		$('#eqname').show();
	}
	
}







function funcLabHideView(para)
{	
var idname=para;
alert(idname);
 if (document.getElementById(idname) != null) 
	{
	document.getElementById(idname).style.display = 'none';
	}			
}
function funcLabShowView(param)
{
var idname1=param;

  if (document.getElementById(idname) != null) 
     {
	 document.getElementById(idname).style.display = 'none';
	}
	if (document.getElementById(idname) != null) 
	  {
	  document.getElementById(idname).style.display = '';
	 }
}
</script>
<script>
function funcOnLoadBodyFunctionCall()
{
funcLabHideView();
	}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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

</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
$sampleid = isset($_REQUEST["sampleid"]) ? $_REQUEST["sampleid"] : '';

 $query79="SELECT recorddate from ipsamplecollection_lab where patientcode='$patientcode' and patientvisitcode='$visitcode' and itemcode='$q_itemcode' and sampleid='$sampleid'";
$exec79=mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res79=mysqli_fetch_array($exec79);
 $date2_recorddate=$res79['recorddate'];

?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];
$dateofbirth=$res69['dateofbirth'];

// $transactiondateto = date('Y-m-d');
$date1=strtotime($dateofbirth);
$date2=strtotime($date2_recorddate);
$datediff = $date2 - $date1;
 $birth_days = round($datediff / (60 * 60 * 24));

if($dateofbirth>'0000-00-00'){
$today = new DateTime($date2_recorddate);
$diff = $today->diff(new DateTime($dateofbirth));
$patientage1 = format_interval($diff);
}else{
  $patientage1 = '<font color="red">DOB Not Found.</font>';
}

function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y Years "); }
    if ($interval->m) { $result .= $interval->format("%m Months "); }
    if ($interval->d) { $result .= $interval->format("%d Days "); }

    return $result;
}

$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

// 2019-03-03
$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'IPLRE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipresultentry_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPLRE-'.'1';
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
	
	
	$billnumbercode = 'IPLRE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<script type="text/javascript">
function funcrange(varserialnumber1)
{
//alert('hi');
var varserialnumber1 = varserialnumber1;
//alert(varserialnumber1);
var varrange111 = document.getElementById("range111"+varserialnumber1+"").value;
var varrange112 = document.getElementById("range112"+varserialnumber1+"").value;
var result1 = document.getElementById("result"+varserialnumber1+"").value;
//alert(result1);
//alert(varrange112);
if(parseFloat(result1) < parseFloat(varrange111))
{
//alert('h');


document.getElementById("result"+varserialnumber1+"").style.borderColor="orange";
document.getElementById("color"+varserialnumber1+"").value="orange";

}
else if(parseFloat(result1) > parseFloat(varrange112))
{
//alert('hi');
document.getElementById("result"+varserialnumber1+"").style.borderColor="red";
document.getElementById("color"+varserialnumber1+"").value="red";
}
else if(parseFloat(result1) >= parseFloat(varrange111) && parseFloat(result1) <=(varrange112))
{
document.getElementById("result"+varserialnumber1+"").style.borderColor="green";
document.getElementById("color"+varserialnumber1+"").value="green";
}
}
</script>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript">
function loadGeneric(sno){
	var sno = sno;
	var itemcode = document.getElementById('itemcode'+sno).value;
	var referencename = document.getElementById('referencename'+sno).value;
	window.open("genericsearch2.php?sno="+sno+"&referencename="+referencename,"OriginalWindowA4",'width=722,height=450,toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=1,resizable=1,left=225,top=100');
}
</script>
<!-- <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />         -->
<body>
<form name="frm" id="frmsales" method="post" action="iplabresultentry.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()" >
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
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#ecf0f5">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
	  <td width="22%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="26%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
				<td width="11%" align="left" valign="middle"  class="bodytext3"><strong>Doc No</strong></td>
                <td width="21%" align="left" class="bodytext3" valign="middle" >
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>
                  </td>
              </tr>
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" align="left" valign="middle" class="bodytext3">
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
                  </td>
                 <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage1; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
			        </td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>
				<input type="hidden" name="samplecollectiondocno" value="<?php echo $docnumber; ?>">
				</td>
				  </tr>
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
              
				  </tr>
            </tbody>
        </table></td>
      </tr>
	
     <tr>
	  <td colspan="7" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext365">
				 <strong>LAB TEST RESULTS</strong>
				  </td> </tr>
				  
				   <tr>
		    <td width="19%" class="bodytext366" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Test Name</strong></div></td>
			<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="left"><strong>Result value</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Units</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"></td>

			<td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="right"><strong>Reference Value</strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Acknowledge</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><div align="center"><strong>Equipment</strong></div></td>
		  </tr>
				  <?php
				  $sn = 0;
	  $query31="select * from ipconsultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labsamplecoll='completed' and resultentry='pending' and docnumber='$docnumber' and sampleid = '$sampleid' and labitemcode='$q_itemcode' group by labitemname";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
	   $labname1=$res31['labitemname'];
	   $labitemcode = $res31['labitemcode'];
	   
	   
	   
			     $query521="select radiology from master_lab where itemcode='$labitemcode'";
				  $exec521=mysqli_query($GLOBALS["___mysqli_ston"], $query521);
				  $res521=mysqli_fetch_array($exec521);
				  $radiology=$res521['radiology'];
	
	
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
			$sno = $sno + 1;
		?>		  
			  <tr id="idTRMain<?php echo $sno; ?>" <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="center"><div align="left"><?php echo $labname1; ?>
              
              
              </div>
              
               <input type="hidden" id="radiology" name="radiology[]" value="<?php echo $radiology; ?>">
            
              </td>
			  	   
              <td class="bodytext31" valign="center"  align="center">
			  <div align="left">
			  <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcShowDetailHide('<?php echo $sno; ?>')" onClick="return funcShowDetailView('<?php echo $sno; ?>')">			  </div>			  </td>
               <td class="bodytext31" valign="center"  align="center"><div align="center"></div></td>
			       	  <td colspan="2" class="bodytext31" valign="center"  align="center">
			  <div  class="bodytext31"></div></td>
			  <td  class="bodytext31" valign="center"  align="center"><div align="center"><input type="checkbox" name="ack[]" id="ack" value="<?php echo $labitemcode; ?>" onClick="return validcheck1()"></div></td>

			  <td class="bodytext31" valign="center"  align="right"><div align="right">
				<input type="text" id="eqname" name="eqname"  value="<?php echo $eqname; ?>" onkeyup = "return equipmentsearch()" hidden size='23'>
				<input type="hidden" id="eqid" name="eqid"  value="<?php echo $eqid; ?>" hidden></div>
				<input type="hidden" name="sampleid" id="sampleid" value="<?php echo $sampleid; ?>"></td>
		
         </tr>
		 	<tr id="idTRSub<?php echo $sno; ?>">
			<td colspan="8"  align="left" valign="center" class="bodytext31">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="1000"
            align="left" border="0">
              <tbody>
                 
			   <?php 
			   $subTRsno = 0;
			  //$query52="select * from master_labreference where itemname='$labname1' and itemcode='$labitemcode'";
			  $query52="select * from master_labreference where  itemcode='$labitemcode' and (gender = '$patientgender' or gender='All' or gender='') and '$birth_days' >= agefrom and '$birth_days' <= ageto and status <> 'deleted'"; 
			   $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52);
			   $num=mysqli_num_rows($exec52);
			   while($res52=mysqli_fetch_array($exec52))
			   {
			   $labname2=$res52['itemname'];
			 	$itemcode2=$res52['itemcode'];
			    /* $query52="select * from master_lab where itemname='$labname2'";
				  $exec52=mysql_query($query52);
				  $res52=mysql_fetch_array($exec52);*/
				  $labunit1=$res52['itemname_abbreviation'];
				  $labreferenceunit = $res52['referenceunit'];
				  $refrange_label = $res52['refrange_label'];
				   
				$labreferencename = $res52['referencename'];
				$genericsearch = $res52['generic_search'];
				$labitemanum = $res52['auto_number'];
				 $referencecomments = $res52['referencecomments'];
				
				   $labreferencerange = $res52['referencerange'];
				  $labreferencevalue1=$res52['referencevalue'];
				  
				  $labreferencerange1 = $labreferencerange;
				  $labreferencerange1 = explode('-',$labreferencerange1);
				  if(!ctype_digit($labreferencerange1[0]))
				{
				$labreferencerange1length = strlen($labreferencerange1[0]);
				$labreferencerange1symbol = substr($labreferencerange1[0],0,1);
				$labreferencerange1withoutsymbol = substr($labreferencerange1[0],1,$labreferencerange1length);
				if($labreferencerange1symbol == '<')
				{
				$labreferencerange1[0] = 0;
				$labreferencerange1[1] = $labreferencerange1withoutsymbol;
				}
				if($labreferencerange1symbol == '>')
				{
				$labreferencerange1[0] = $labreferencerange1withoutsymbol;
				$labreferencerange1[1] = 1000000;
				}
				}
				  
				  $query64 = "select * from master_labreference where itemcode='$itemcode2' and referencename = '$labreferencename' and auto_number = '$labitemanum' and status <> 'deleted' group by referencename";
				  $exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $num64 = mysqli_num_rows($exec64);
				  if($num64 > 0)
				  {
				  	$subTRcolorloopcount = $subTRcolorloopcount + 1;
					$sn = $sn + 1;
				$subTRshowcolor = ($subTRcolorloopcount & 1); 
				if ($subTRshowcolor == 0)
				{
					//echo "if";
					$subTRcolorcode = 'bgcolor="#CBDBFA"';
				}
				else
				{
					//echo "else";
					$subTRcolorcode = 'bgcolor="#ecf0f5"';
				}
						   ?> 
						     <tr <?php echo $subTRcolorcode; ?>>
							 <input type="hidden" value="<?php echo $subTRsno = $subTRsno + 1; ?>">
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="316"><div class="bodytext311"> <?php if($labreferencename == '')
				   {
				   echo $labname2;
				   }
				   else
				   {
				   echo $labreferencename;
				   } ?>
				   <?php if($genericsearch == '1'){ ?><button id="genericsearch<?php echo $sn; ?>" onclick="loadGeneric(<?php echo $sn; ?>)"><img src="data-search-icon.png" height="15" width="15" /></button><?php } ?>
				   <input type="hidden" name="lab[]" value="<?php echo $labname2;?>"><input type="hidden" name="referencename[]" id="referencename<?php echo $sn; ?>" value="<?php echo $labreferencename; ?>">
				  <input type="hidden" name="code[]" id="itemcode<?php echo $sn; ?>" value="<?php echo $itemcode2; ?>">
					</div></td>
				  
                  <td width="214" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext311"><div align="left"><textarea rows="3" cols="30" name="result[]" id="result<?php echo $sn; ?>" size="25" value="" onBlur="return funcrange('<?php echo $sn; ?>')"></textarea></div>
				  <input type="hidden" name="range111[]" id="range111<?php echo $sn; ?>" value="<?php echo $labreferencerange1[0] ; ?>">
				  <input type="hidden" name="range112[]" id="range112<?php echo $sn; ?>" value="<?php echo $labreferencerange1[1] ; ?>">
				  <input type="hidden" name="color[]" id="color<?php echo $sn; ?>" value="">
				  </td>
                  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="177"><div align="left"> <?php if($labreferenceunit == '')
				  {
				  echo $labunit1;
				  }
				  else
				  {
				  echo $labreferenceunit;
				  } ?><input type="hidden" name="units[]" size="8" value="<?php echo $labreferenceunit; ?>"/> </div></td>

				  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="166">
				  	<div align="left"><?=$refrange_label;?></div>
				  </td>


               <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="166"><div align="left"> <?php if($labreferencerange == '')
			   {
			   echo $labreferencevalue1;
			   }
			   else
			   {
			   echo $labreferencerange;
			   } ?><input type="hidden" name="reference[]" size="8" value="<?php echo $labreferencerange; ?>"/></div></td>
			   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="center" width="107"><div align="center">
			   <textarea rows="3" cols="15" name="refcomments[]" placeholder="Comments"><?php echo $referencecomments; ?></textarea></div></td>
              </tr>
			  <?php 
		 }
		 }
		 ?>
			  </tbody>
            </table>			</td>
			<td width="0%"  align="left" valign="center" class="bodytext31"><div align="left">&nbsp;</div></td>
			</tr>
			 
		 
			 
		 <tr>
		 <td class="bodytext31" colspan="7" valign="center"  align="left"><div align="left">&nbsp;</div></td>
			
		 </tr> 
		 <?php
		  
		 }
		 ?>
		 
				  
				  
				  	<script language="javascript">
			//alert ("Inside JS");
			//To Hide idTRSub rows this code is not given inside function. This needs to run after rows are completed.
			// for (i=1;i<=100;i++)
			// {
			// 	if (document.getElementById("idTRSub"+i+"") != null) 
			// 	{
			// 		document.getElementById("idTRSub"+i+"").style.display = 'none';
			// 	}
			// }
			
			// function funcShowDetailView(varSerialNumber)
			// {
			// 	//alert ("Inside Function.");
			// 	var varSerialNumber = varSerialNumber
			// 	//alert (varSerialNumber);

			// 	for (i=1;i<=100;i++)
			// 	{
			// 		if (document.getElementById("idTRSub"+i+"") != null) 
			// 		{
			// 			document.getElementById("idTRSub"+i+"").style.display = 'none';
			// 		}
			// 	}

			// 	if (document.getElementById("idTRSub"+varSerialNumber+"") != null) 
			// 	{
			// 		document.getElementById("idTRSub"+varSerialNumber+"").style.display = '';
			// 	}
			// }
			
			// function funcShowDetailHide(varSerialNumber)
			// {
			// 	//alert ("Inside Function.");
			// 	var varSerialNumber = varSerialNumber
			// 	//alert (varSerialNumber);

			// 	for (i=1;i<=100;i++)
			// 	{
			// 		if (document.getElementById("idTRSub"+i+"") != null) 
			// 		{
			// 			document.getElementById("idTRSub"+i+"").style.display = 'none';
			// 		}
			// 	}
			// }
			</script>	

				<tr><td colspan="8"></td></tr>
				<tr><td colspan="8" align="center">Lab Comments</td></tr>

          		<tr>
					<td colspan="8" align="center">
							<textarea name="lab_comments" rows="4" cols="50"></textarea>
					</td>
				</tr>

      <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext32">User Name: 
               <input name="user" type="hidden" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>"><?php echo strtoupper($_SESSION['username']); ?></td>
               </tr>
			   <tr> 
              <td colspan="7" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()"  accesskey="b" class="button"/>
               </td>
          </tr>
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>