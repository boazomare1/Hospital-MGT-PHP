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

$query1 = "select * from master_location where locationcode='$locationcode' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
					
			}

	

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if ($frm1submit1 == 'frm1submit1')
{
/*$paynowbillprefix = 'ICR-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipclinicalrecord order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ICR-'.'1';
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
	
	
	$billnumbercode = 'ICR-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}*/

	    $billdate=$_REQUEST['billdate'];
	    $paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$account = $_REQUEST['account'];
		$welcomerelative =  $_REQUEST['welcomerelative'];
		$receiverecord =  $_REQUEST['receiverecord'];
		$entercensus = $_REQUEST['entercensus'];
		$showbed = $_REQUEST['showbed'];
		$informrelative = $_REQUEST['informrelative'];
		$locationcode1=$_REQUEST['locationno'];
		$date1 = $_REQUEST['date1'];
		$time1 = $_REQUEST['time1'];
		$fullcare = $_REQUEST['fullcare'];
		$assistance = $_REQUEST['assistance'];
		$ambulatory = $_REQUEST['ambulatory'];
		$sensoryok = $_REQUEST['sensoryok'];
		$vision = $_REQUEST['vision'];
		$hearing = $_REQUEST['hearing'];
		$comments = $_REQUEST['comments'];
		$preferlanguage = $_REQUEST['preferlanguage'];
		$bowelcontinent = $_REQUEST['bowelcontinent'];
		$continent = $_REQUEST['continent'];
		$incontinent = $_REQUEST['incontinent'];
		$diabetic = $_REQUEST['diabetic'];
		$lowsalt = $_REQUEST['lowsalt'];
	    $dietneeds = $_REQUEST['dietneeds'];
		$examobservation = $_REQUEST['examobservation'];
		$date2 = $_REQUEST['date2'];
		$time2 = $_REQUEST['time2'];
		
	$query7 = "select * from ipclinicalrecord where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums7 = mysqli_num_rows($exec7);
	
	if($nums7 == '0')
	{
		if($patientcode!='' && $visitcode!='')
		{
		
		$clinicalrecordquery1=mysqli_query($GLOBALS["___mysqli_ston"], "insert into ipclinicalrecord(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,welcomerelative,receiverecord,entercensus,showbed,informrelative,date1,time1,fullcare,assistance,ambulatory,sensoryok,vision,hearing,comments,preferlanguage,bowelcontinent,continent,incontinent,diabetic,lowsalt,dietneeds,examobservation,date2,time2,updatetime,locationcode)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$welcomerelative','$receiverecord','$entercensus','$showbed','$informrelative','$date1','$time1','$fullcare','$assistance','$ambulatory','$sensoryok','$vision','$hearing','$comments','$preferlanguage','$bowelcontinent','$continent','$incontinent','$diabetic','$lowsalt','$dietneeds','$examobservation','$date2','$time2','$updatedatetime','$locationcode1')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:inpatientactivity.php");
		exit;
		}
	} 
	
	else
	     {
		   if($patientcode!='' && $visitcode!='')
		    {
		   	$query6 = "update ipclinicalrecord set welcomerelative='$welcomerelative', receiverecord='$receiverecord',entercensus='$entercensus',showbed='$showbed',informrelative='$informrelative',date1='$date1',time1='$time1',fullcare='$fullcare',assistance='$assistance',ambulatory='$ambulatory',sensoryok='$sensoryok',vision='$vision',hearing='$hearing',comments='$comments',preferlanguage='$preferlanguage',bowelcontinent='$bowelcontinent',continent='$continent',incontinent='$incontinent',diabetic='$diabetic',lowsalt='$lowsalt',dietneeds='$dietneeds',examobservation='$examobservation',date2='$date2',time2='$time2',updatetime='$updatedatetime', ipaddress ='$ipaddress', locationname ='$locationname', locationcode ='$locationcode' where patientcode='$patientcode' and visitcode='$visitcode' ";
			
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			header("location:inpatientactivity.php");
			exit;
		    }
		 }		
}

if($visitcode!='' && $patientcode!='')
{
	
	$query8 = "select * from ipclinicalrecord where patientcode='$patientcode' and visitcode='$visitcode' ";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums8 = mysqli_num_rows($exec8);
	if($nums8 > 0)
	{
	$res8 = mysqli_fetch_array($exec8);
	$res8billdate=$res8['billdate'];
	$res8paymentmode = $res8['billtype'];
	$res8patientfullname = $res8['customername'];
	$res8patientcode = $res8['patientcode'];
	$res8visitcode = $res8['visitcode'];
	$res8billtype = $res8['billtypes'];
	$account = $res8['account'];
	$res8welcomerelative =  $res8['welcomerelative'];
	$res8receiverecord =  $res8['receiverecord'];
	$res8entercensus = $res8['entercensus'];
	$res8showbed = $res8['showbed'];
	$res8informrelative = $res8['informrelative'];
	$res8date1 = $res8['date1'];
	$res8time1 = $res8['time1'];
	$res8fullcare = $res8['fullcare'];
	$res8assistance = $res8['assistance'];
	$res8ambulatory = $res8['ambulatory'];
	$res8sensoryok = $res8['sensoryok'];
	$res8vision = $res8['vision'];
	$res8hearing = $res8['hearing'];
	$res8comments = $res8['comments'];
	$res8preferlanguage = $res8['preferlanguage'];
	$res8bowelcontinent = $res8['bowelcontinent'];
	$res8continent = $res8['continent'];
	$res8incontinent = $res8['incontinent'];
	$res8diabetic = $res8['diabetic'];
	$res8lowsalt = $res8['lowsalt'];
	$res8dietneeds = $res8['dietneeds'];
	$res8examobservation = $res8['examobservation'];
	$res8date2 = $res8['date2'];
	$res8time2 = $res8['time2'];
	}
	else
	{
	$res8billdate='';
	$res8paymentmode = '';
	$res8patientfullname = '';
	$res8patientcode = '';
	$res8visitcode = '';
	$res8billtype = '';
	$res8account = '';
	$res8welcomerelative = '';
	$res8receiverecord = '';
	$res8entercensus = '';
	$res8showbed = '';
	$res8informrelative ='';
	$res8date1 = '';
	$res8time1 = '';
	$res8fullcare = '';
	$res8assistance = '';
	$res8ambulatory = '';
	$res8sensoryok = '';
	$res8vision = '';
	$res8hearing = '';
	$res8comments = '';
	$res8preferlanguage = '';
	$res8bowelcontinent = '';
	$res8continent = '';
	$res8incontinent = '';
	$res8diabetic = '';
	$res8lowsalt = '';
	$res8dietneeds = '';
	$res8examobservation = '';
	$res8date2 = '';
	$res8time2 = '';
	}
}


if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
$docnumber=$_REQUEST["docnumber"];
}

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
?>

<?php
$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab=mysqli_fetch_array($Querylab);
$patientage=$execlab['age'];
$patientgender=$execlab['gender'];
$patientname = $execlab['customerfullname'];
$billtype = $execlab['billtype'];
$patienttype=$execlab['maintype'];
$patientaccount=$execlab['accountname'];
$dateofbirth=$execlab['dateofbirth'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysqli_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysqli_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];

$query19=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' ");
$exec19=mysqli_fetch_array($query19);
$res19ward=$exec19['ward'];
$res19bed=$exec19['bed'];

$query30=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_ward where auto_number='$res19ward' ");
$exec30=mysqli_fetch_array($query30);
$res30ward=$exec30['ward'];

$query31 = mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_bed where auto_number='$res19bed' ");
$exec31=mysqli_fetch_array($query31);
$res31bed=$exec31['bed'];

$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$ipdate = $res66['consultationdate'];
?>

<?php
/*$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
	$paynowbillprefix = 'ICR-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipclinicalrecord order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ICR-'.'1';
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
	
	
	$billnumbercode = 'ICR-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}*/
?>

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

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter a whole number");
		return false;
    }
    return true;
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
.bodytext321 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext321 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>

<script src="js/datetimepicker_css.js"></script>
</head>

<body>	
<form name="form1" id="frmsales" method="post" action="ipclinicalrecords.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
        <td width="792"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="11" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
			 <!--<tr>
                <td colspan="14" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>-->
		<tr>
                <td colspan="11" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<tr>
                <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td width="30%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?></td>
                <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patientcode</strong></td>
                <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>
                  
                <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>
                <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" /><?php echo $visitcode; ?></td>
				<!--<td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No&nbsp;&nbsp; </strong>
				  <input type="hidden" name="billno2" id="billno2" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                  <?php echo $billnumbercode; ?> </td>-->
				</tr>       
               
			    <tr>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Age</strong></td>
			      <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?>
                    <input type="hidden" name="age" id="age" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;" size="45"></td>
			      <td align="left" valign="middle" class="bodytext3"><span class="style1">Gender</span></td>
			      <td align="left" valign="middle" class="bodytext3"><?php echo $patientgender; ?></td>
			      <td align="left" valign="middle"  bgcolor="#ecf0f5" class="style1"><strong>Account</strong></td>
			      <td colspan="3" align="left" valign="top" class="bodytext3"><input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />
                    <input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
                    <?php echo $patientaccount1; ?></td>
			      </tr>
			    
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Ward/Bed</strong></td>
				             <td class="bodytext3"><?php echo $res30ward; ?>/<?php echo $res31bed; ?></td>	
                             <td class="bodytext3"><strong>DOB</strong></td>
                             <td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                   <?php echo $dateofbirth; ?> </td>
                 <td align="left" valign="middle" class="bodytext3"><strong>Date</strong></td>
				<td colspan="3" class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                  <?php echo $dateonly; ?> </td>
				  </tr>
				  <tr>
				  <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
				             <td class="bodytext3"><?php echo $locationname; ?></td>	
							 
					<td align="left" valign="middle" class="bodytext3"> <input type="hidden" name="locationno" id="locationno" value="<?php	 echo $locationcode; ?>" ></td>		 
				  </tr>
			<tr>
				<td colspan="11" class="bodytext32"><strong>&nbsp;</strong></td>
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
				   <td colspan="8" align="left" valign="middle"   class="bodytext3"><span class="bodytext32"><strong>INPATIENT CLINICAL RECORDS </strong></span></td>
	              </tr>
				  
				<tr>
				 <td colspan="8" align="left" valign="middle" class="bodytext3"><strong>Ward Admission Checklist </strong></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="welcomerelative" id="instrument4" onClick="return funcpackcheck();" <?php if($res8welcomerelative == '1') echo 'checked'; ?> value="1">
Welcome Patient/Relatives </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="receiverecord" id="receiverecord" onClick="return funcpackcheck();" <?php if($res8receiverecord == '1') echo 'checked'; ?> value="1">
Receive patient's record/medicine and check if corrected </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="entercensus" id="transrefer2" onClick="return funcpackcheck();" <?php if($res8entercensus == '1') echo 'checked'; ?> value="1">
Enter patient's name on the census board and in admission book </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				   <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="showbed" id="transrefer3" onClick="return funcpackcheck();" <?php if($res8showbed == '1') echo 'checked'; ?> value="1">
Show the bed, give hospital clothes </td>
			      </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="informrelative" id="transrefer4" onClick="return funcpackcheck();" <?php if($res8informrelative == '1') echo 'checked'; ?> value="1">
Inform relatives about visit times and phone numbers </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Completed By: </td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="4%" align="left" valign="middle" class="bodytext3">Date:				    </td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input name="date1" id="date1" style="border: 1px solid #001E6A" value="<?php echo $res8date1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('date1')" style="cursor:pointer"/></td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3">Time: <strong>
				    <input name="time1" id="time1" value="<?php echo date('H:i',strtotime($res8time1)); ?>" onKeyDown="return disableEnterKey()" size="10">
				    <span class="bodytext321">(Ex: HH:MM)</span></strong></td>
				  </tr>
				
				<tr>
				  <td colspan="8" align="left" valign="middle" class="style1">Initial Nursing Assessment </td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="style1">Activity Level: </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="fullcare" id="fullcare" onClick="return funcpackcheck();" <?php if($res8fullcare == '1') echo 'checked'; ?> value="1">
Full Care
  <input type="checkbox" name="assistance" id="assistance" onClick="return funcpackcheck();" <?php if($res8assistance == '1') echo 'checked'; ?> value="1">
Assistance
<input type="checkbox" name="ambulatory" id="ambulatory" onClick="return funcpackcheck();" <?php if($res8ambulatory == '1') echo 'checked'; ?> value="1">
Ambulatory </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				      <td align="left" valign="middle" class="bodytext3"><input type="checkbox" name="sensoryok" id="transrefer8" onClick="return funcpackcheck();" <?php if($res8sensoryok == '1') echo 'checked'; ?> value="1">
Sensory Okay
  <input type="checkbox" name="vision" id="transrefer9" onClick="return funcpackcheck();" <?php if($res8vision == '1') echo 'checked'; ?> value="1">
Vision
<input type="checkbox" name="hearing" id="transrefer10" onClick="return funcpackcheck();" <?php if($res8hearing == '1') echo 'checked'; ?> value="1">
Hearing</td>
			          <td colspan="3" align="left" valign="middle" class="bodytext3"><!--<input type="checkbox" name="comments" id="comments" onClick="return funcpackcheck();" <?php //if($instrument1 == '1') echo 'checked'; ?> value="1">
-->
			            Comments:
                      <input name="comments" id="comments" value="<?php echo $res8comments; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
			          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
			          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
			          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				</tr>
				
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3">
Patient's Preferred Language:
  <input name="preferlanguage" id="preferlanguage" value="<?php echo $res8preferlanguage; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="bowelcontinent" id="transrefer13" onClick="return funcpackcheck();" <?php if($res8bowelcontinent == '1') echo 'checked'; ?> value="1">
Bowel Continent </td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3"><strong>Bladder:</strong></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
			      <td colspan="7" align="left" valign="middle" class="bodytext3"><input type="checkbox" name="continent" id="transrefer14" onClick="return funcpackcheck();" <?php  if($res8continent == '1') echo 'checked'; ?> value="1">
Continent
  <input type="checkbox" name="incontinent" id="incontinent" onClick="return funcpackcheck();" <?php if($res8incontinent == '1') echo 'checked'; ?> value="1">
Incontinent </td>
			      </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3"><strong>Diet Needs:</strong></td>
			      </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3"><strong>
				    <input type="checkbox" name="diabetic" id="diabetic" onClick="return funcpackcheck();" <?php if($res8diabetic == '1') echo 'checked'; ?> value="1">
                  </strong> Diabetic
                  <input type="checkbox" name="lowsalt" id="lowsalt" onClick="return funcpackcheck();" <?php if($res8lowsalt == '1') echo 'checked'; ?> value="1">
Low Salt  </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="7" align="left" valign="middle" class="bodytext3">Others
                    <input name="dietneeds" id="dietneeds" value="<?php echo $res8dietneeds; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3"><strong>Exam Observations: 
				    <input name="examobservation" id="examobservation" value="<?php echo $res8examobservation; ?>" onKeyDown="return disableEnterKey()" size="20">
				  </strong></td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Completed By: </td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle" class="bodytext3">Date:</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input name="date2" id="date2" style="border: 1px solid #001E6A" value="<?php echo $res8date2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('date2')" style="cursor:pointer"/></td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3">Time:<strong>
				    <input name="time2" id="time2" value="<?php echo date('H:i',strtotime($res8time2)); ?>" onKeyDown="return disableEnterKey()" size="10">
				    <span class="bodytext321">(Ex: HH:MM)</span></strong></td>
				  </tr>
				<tr>
				  <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				<tr>
				 <td colspan="8" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  </tr>
				
				<tr>
				  <td width="3%" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="30%" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="11%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="3%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="13%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="24%" align="left" valign="middle" class="bodytext3"><input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button"/></td>
				</tr>
		       </tbody>
        </table>		</td></tr>
		
		<tr>
		 <td width="1%" class="bodytext31" align="left">User Name: &nbsp;&nbsp;<input type="hidden" name="username" id="username" value="" class="bal1"><strong><?php echo strtoupper($username); ?></strong></td>		
		</tr>
             
               <tr>
	  <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
	  </tr>
              
            </tbody>
        </table>
	  </td>
	</tr>
     
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>