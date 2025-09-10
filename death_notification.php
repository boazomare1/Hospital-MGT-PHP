
<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");//echo $menu_id;include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly = date("Y-m-d");

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];

$errmsg = "";

if (isset($_REQUEST["errmsg"])) { $errmsg = addslashes($_REQUEST["errmsg"]); } else { $errmsg = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = addslashes($_REQUEST["frm1submit1"]); } else { $frm1submit1 = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = trim(addslashes($_REQUEST["patientcode"])); } else { $patientcode = ""; }
 

if (isset($_REQUEST["st"])) { $st = addslashes($_REQUEST["st"]); } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. File Uploaded Successfully.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = addslashes($_REQUEST["cpynum"]); } else { $cpynum = ""; }
	
}
if ($st == 'failed')
{
		$errmsg = "Upload Failed";
}

if ($frm1submit1 == 'frm1submit1')
{   
	$query = "select locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	$locationcode = $res["locationcode"];

	 $query1112 = "select locationname from master_location where locationcode = '$locationcode'";
	 $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $res1112 = mysqli_fetch_array($exec1112);
	 $locationname = $res1112["locationname"];		

	  $query2 = "select gender,dateofbirth,accountname from master_customer where customercode='$patientcode'";
	  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $res2 = mysqli_fetch_array($exec2);
	  
	  $gender = $res2['gender'];	  
	  $dateofbirth = $res2['dateofbirth'];	  
	  $accountname = $res2['accountname'];
	  $age=calculate_age($dateofbirth);
	
	$patientcode = trim(addslashes($_REQUEST['patientcode']));
	$customerfullname = addslashes($_REQUEST['customerfullname']);
	$doctor = addslashes($_REQUEST['doctorname']);
	$doctorcode = addslashes($_REQUEST['doctorcode']);
	$placeofbirth = addslashes($_REQUEST['placeofbirth']);
	$rescity = addslashes($_REQUEST['rescity']);
	$resparish = addslashes($_REQUEST['resparish']);
	$resdistrict = addslashes($_REQUEST['resdistrict']);
	$marrigaestatus = addslashes($_REQUEST['marrigaestatus']);
	if($marrigaestatus != "Never Married" && $marrigaestatus != "Unknown")
	{
	$spousename = addslashes($_REQUEST['spousename']);
	}
	else
	{
	$spousename = '';
	}
	$fathername = addslashes($_REQUEST['fathername']);
	$mothername = addslashes($_REQUEST['mothername']);
	$informantname = addslashes($_REQUEST['informantname']);
	$informantrel = addslashes($_REQUEST['informantrel']);
	$informantadd = addslashes($_REQUEST['informantadd']);
	$deathloc = addslashes($_REQUEST['deathloc']);
	$dateofdeath = new DateTime($_REQUEST['dateofdeath']);
	$dateofdeath = date_format($dateofdeath,'Y-m-d H:i:s');
	$cause1 = addslashes($_REQUEST['cause1']);
	$interval1 = addslashes($_REQUEST['interval1']);
	$cause2 = addslashes($_REQUEST['cause2']);
	$interval2 = addslashes($_REQUEST['interval2']);
	$cause3 = addslashes($_REQUEST['cause3']);
	$interval3 = addslashes($_REQUEST['interval3']);
	$cause4 = addslashes($_REQUEST['cause4']);
	$interval4 = addslashes($_REQUEST['interval4']);
	$autopsy = addslashes($_REQUEST['autopsy']);
	$autopsystatus = addslashes($_REQUEST['autopsystatus']);
	if($gender == 'Female')
	{
	$pregnant = addslashes($_REQUEST['pregnant']);
	}
	else
	{
	$pregnant = '';
	}
	$mannerofdeath = addslashes($_REQUEST['mannerofdeath']);
	$declaration = addslashes($_REQUEST['declaration']);
	
	$docnumber ='1';
	$query = "select docno from death_notification order by auto_number desc limit 0,1";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res = mysqli_fetch_array($exec)){
		$docnumber_n=intval($res['docno']);
		$docnumber =++$docnumber_n;		
	}
	
  
     $query26="insert into death_notification (`docno`,`patientname`,`patientcode`,`locationname`,`locationcode`,`doctor_code`,`doctor_name`,`record_date`,`record_time`,`username`,`gender`,`dateofbirth`,`accountname`,`age`,`birth_place`,`marital_status`,`residence_city`,`residence_parish`,`residence_district`,spousename,father_name,mother_name,informant_name,informant_relation,informant_address,deathloc,datetimeofdeath,cause1,interval1,cause2,interval2,cause3,interval3,cause4,interval4,autopsy_status,autopsy_finding,pregnant_status,manner_death,declaration) values ('$docnumber','$customerfullname','$patientcode','$locationname','$locationcode','$doctorcode','$doctor','$dateonly','$timeonly','$username','$gender','$dateofbirth','$accountname','$age','$placeofbirth','$marrigaestatus','$rescity','$resparish','$resdistrict','$spousename','$fathername','$mothername','$informantname','$informantrel','$informantadd','$deathloc','$dateofdeath','$cause1','$interval1','$cause2','$interval2','$cause3','$interval3','$cause4','$interval4','$autopsy','$autopsystatus','$pregnant','$mannerofdeath','$declaration')";
     $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	 $exec27=mysqli_query($GLOBALS["___mysqli_ston"], "update master_customer set status = 'Deleted' where customercode = '$patientcode'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	 echo "<script>window.open('print_death_notification.php?docno=$docnumber','OriginalWindow','width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');window.location.href='medicalnotification.php';</script>";
	 //header("location:medicalnotification.php");
      exit();
	
}

?>


<?php
function calculate_age($birthday)
{
 
 if($birthday=="0000-00-00")
 {
  return "0 Days";
 }
 
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>
<!--<script>
function textareacontentcheck()
{
if(document.getElementById("consultation").value == '')
	{
	alert("Enter content");
	document.getElementById("consultation").focus();
	return false;
	}
}

</script>
-->
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>

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
.ui-menu .ui-menu-item{ zoom:1 !important; }
input[type="radio"] {
    -webkit-appearance: checkbox; /* Chrome, Safari, Opera */
    -moz-appearance: checkbox;    /* Firefox */
    -ms-appearance: checkbox;     /* not currently supported */
}
</style>

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script>
$(document).ready(function(){

$('#doctorname').autocomplete({
		
	source:'ajaxdoctornewsearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var doctorname = ui.item.doctorname;
			var doctorcode = ui.item.doctorcode;
			$('#doctorname').val(doctorname);
			$('#doctorcode').val(doctorcode);
			
			},
    });

});

function validCheck(){
if($("#placeofbirth").val()==""){
	alert('Please Enter the place of birth')
	$("#placeofbirth").focus();
	return false;
}
else if($("#rescity").val()==""){
	alert('Please Enter the residence city.')
	$("#rescity").focus();
	return false;
}
else if($("#resparish").val()==""){
	alert('Please Enter the residence parish.')
	$("#resparish").focus();
	return false;
}
else if($("#resdistrict").val()==""){
	alert('Please Enter the residence district.')
	$("#resdistrict").focus();
	return false;
}
else if($("input:radio[name='marrigaestatus']:checked").length == 0)
  {
	alert('Please select the Marital status from the list.')
	$("#marrigaestatus1").focus();
	return false;
}
else if(($("input:radio[name='marrigaestatus']:checked").val()!="Never Married")&&($("input:radio[name='marrigaestatus']:checked").val()!="Unknown")&&($("#spousename").val()=="")){
	alert('Please Enter the spouse name.')
	$("#spousename").focus();
	return false;
}
else if($("#fathername").val()==""){
	alert("Please Enter the Father's Name.")
	$("#fathername").focus();
	return false;
}
else if($("#mothername").val()==""){
	alert("Please Enter the Mother's Name.")
	$("#mothername").focus();
	return false;
}
else if($("#informantname").val()==""){
	alert("Please Enter the Informant's Name.")
	$("#informantname").focus();
	return false;
}
else if($("#informantrel").val()==""){
	alert("Please Enter the Informant's Relationship with the Decendent.")
	$("#informantrel").focus();
	return false;
}
else if($("#informantadd").val()==""){
	alert("Please Enter the Informant's Address.")
	$("#informantadd").focus();
	return false;
}
else if($("input:radio[name='deathloc']:checked").length == 0)
  {
	alert('Please select the Location of Death from the list.')
	$("#deathloc1").focus();
	return false;
}
else if($("#cause1").val()==""){
	alert("Please Enter atleast one cause.")
	$("#cause1").focus();
	return false;
}
else if($("#gender").val=='Female' && $("input:radio[name='pregnant']:checked").length == 0)
  {
	alert('Please select the Pregnancy details from the list.')
	$("#pregnant1").focus();
	return false;
}
else if($("input:radio[name='mannerofdeath']:checked").length == 0)
  {
	alert('Please select the Manner of Death from the list.')
	$("#mannerofdeath1").focus();
	return false;
}
else if($("#doctorcode").val()==""){
	alert('Please select the doctor from the list.')
	$("#doctor").focus();
	return false;
}
else if($("input:radio[name='declaration']:checked").length == 0)
  {
	alert('Please select the Declaration type from the list.')
	$("#declaration1").focus();
	return false;
}
return true;
}

</script>

</head>     
<body>

<?php
	 $query2 = "select customercode,customername,customermiddlename,customerlastname,gender,dateofbirth from master_customer where customercode='$patientcode'";
	  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $res2 = mysqli_fetch_array($exec2);
	   $res2customercode = $res2['customercode'];
	  $customerfirstname = $res2['customername'];
	  $customermiddlename = $res2['customermiddlename'];
	  $customerlastname = $res2['customerlastname'];
	  $customergender =$res2['gender'];
	  $customerdob =$res2['dateofbirth'];
	  $customerage = calculate_age($customerdob);
	 $query32 = "select docno from death_notification where patientcode ='$patientcode'";
	 $exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	 $deadflag = mysqli_num_rows($exec32);
	 if($deadflag >0)
	 {
	 $res32 = mysqli_fetch_assoc($exec32);
	 $docno = $res32['docno'];
	 echo "<script>alert('A record for the patient already exist. so you will be redirected to the print page');window.location.href='print_death_notification.php?docno=$docno';</script>";
	 }
?>

<form name="frmsales" id="frmsales" method="post" action="death_notification.php" onSubmit="return validCheck()" enctype="multipart/form-data">
<table width="99%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top">
	<table width="1200" border="1" cellspacing="0" cellpadding="5">
	<tr bgcolor="#ccc">
			  <td colspan='4'  align="left" valign="middle" ><strong>Add Death Notification</strong></td>
    </tr>
    <tr>
        <td height="24" colspan='4' align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
    </tr>
	<tr>
		<td colspan='3' width="1000" align="left" valign="middle"  bgcolor="#ecf0f5">
		1. DECENDENT'S LEGAL NAME <strong> <?php echo strtoupper($customerfirstname.' '.$customermiddlename.' '.$customerlastname);?></strong>
		</td>
		<input type="hidden" name="customerfullname" id="customerfullnmae" value="<?php echo strtoupper($customerfirstname.' '.$customermiddlename.' '.$customerlastname);?>">
		<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode;?>">
		<td  align="left" valign="middle"  bgcolor="#ecf0f5">
		2. SEX <strong><?php echo strtoupper($customergender);?></strong>
		<input type="hidden" name="gender" id="gender" value="<?php echo $customergender;?>">
		</td>
	 </tr>
	 <tr>
		<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
		3. AGE <strong> <?php echo strtoupper($customerage);?></strong>
		</td>
		<td width="300" align="left" valign="middle"  bgcolor="#ecf0f5">
		4. DATE OF BIRTH <strong><?php $customerdob=date_create($customerdob); echo date_format($customerdob,'d - M - Y');?></strong>
		</td>
		<td width="300" align="left" valign="middle"  bgcolor="#ecf0f5">
		5. PLACE OF BIRTH <input type="text" name="placeofbirth" id="placeofbirth" >
		</td>
	 </tr>
	 <tr>
		<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
		6a. RESIDENCE- CITY <input type="text" name="rescity" id="rescity" >
		</td>
		<td width="300" align="left" valign="middle"  bgcolor="#ecf0f5">
		6b. PARISH  <input type="text" name="resparish" id="resparish" >
		</td>
		<td width="300" align="left" valign="middle"  bgcolor="#ecf0f5">
		6c. DISTRICT <input type="text" name="resdistrict" id="resdistrict" >
		</td>
	 </tr>
	 <tr>
	<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
	7. MARITAL STATUS AT TIME OF DEATH 
	<input type="radio" name="marrigaestatus" id="marrigaestatus1" value='Married' >Married
	<input type="radio" name="marrigaestatus" id="marrigaestatus2" value='Married, but Sepereated' >Married, but Sepereated
	<input type="radio" name="marrigaestatus" id="marrigaestatus3" value='Widowed' >Widowed
	<input type="radio" name="marrigaestatus" id="marrigaestatus4" value='Divorced' >Divorced
	<input type="radio" name="marrigaestatus" id="marrigaestatus5" value='Never Married' >Never Married
	<input type="radio" name="marrigaestatus" id="marrigaestatus6" value='Unknown' >Unknown
	</td>
	<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
	
	8. SURVIVING SPOUSE'S NAME (If wife, give name prior to first marriage) <input type="text" name="spousename" id="spousename" >
	</td>
	 </tr>
	  <tr>
	<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
	9. FATHER'S NAME (First, Middle, Last) 
		<input type="text" name="fathername" id="fathername" >
	</td>
	<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
	
	10. MOTHER'S NAME  PRIOR TO FIRST MARRIAGE (First, Middle, Last) <input type="text" name="mothername" id="mothername" >
	</td>
	 </tr>
	 <tr>
	<td colspan="2" width="400" align="left" valign="middle"  bgcolor="#ecf0f5">
	11a. INFORMANT'S NAME (First, Middle, Last) 
		<input type="text" name="informantname" id="informantname" >
	</td>
	<td width="400" align="left" valign="middle"  bgcolor="#ecf0f5">
	
	11b. RELATIONSHIP TO DECENDENT <input type="text" name="informantrel" id="informantrel" >
	</td>
	<td width="400" align="left" valign="middle"  bgcolor="#ecf0f5">
	
	11c. ADDRESS <input type="text" name="informantadd" id="informantadd" size="40" >
	</td>
	 </tr>
	 <tr>
	<td colspan="2" width="400" align="left" valign="middle"  bgcolor="#ecf0f5">
	12a. IF DEATH occurred IN A HOSPITAL
		<input type="radio" name="deathloc" id="deathloc1" value='In patient' >In patient
	<input type="radio" name="deathloc" id="deathloc2" value='Emergency Room/ Out patient' >Emergency Room/ Out patient
	<input type="radio" name="deathloc" id="deathloc3" value='Dead on Arrival' >Dead on Arrival
	</td>
	<td width="400" align="left" valign="middle"  bgcolor="#ecf0f5">
	13. FACILITY NAME <input type="text" name="facility" id="facility" size="25" value = '<?php echo $locationname;?>' readonly>
	</td>
	<td width="400" align="left" valign="middle"  bgcolor="#ecf0f5">
	14. CITY <input type="text" name="facilitycity" id="facilitycity"  value="">
	</td>
	 </tr>
	 <tr>
	<td colspan="2" width="800" align="left" valign="middle"  bgcolor="#ecf0f5">
	15. DISTRICT AND PARISH OF DEATH<input type="text" name="facilitydistrict" id="facilitydistrict" value = '' >
		
	</td>
	<td colspan="2" width="600" align="left" valign="middle"  bgcolor="#ecf0f5">
	16. DATE AND TIME PRONOUNCED DEAD <input type="text" name="dateofdeath" id="dateofdeath" value = '<?php echo date('d-M-Y h:i:s A'); ?>' readonly>
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofdeath','ddMMMyyyy','dropdown',true,'12',true,'past')" style="cursor:pointer"/>
	</td>
	 </tr>
      <tr>
	<td colspan="3" width="1000" valign="middle">
	<strong style="text-align:center"> 17. CAUSE OF DEATH (See instructions on the examples)</strong><br>
	<span style="text-align:left"><strong> PART 1.</strong> Enter the chain of events - diseases, injuries, or complaints - that directly caused the death. DO NOT enter terminal events such as cardic arrest, respiratory arrest or ventricular fibrillation without showing the etiology. DO NOT ABBREVIATE. Enter only one cause on a line.</span>
	</td>
	<td  width="200" align="left">
	Approximate interval: Onset to death
	</td>
	</tr>
	<tr>
	<td width="300" rowspan="4" align="left">
	IMMEDIATE CAUSE (Final disease or condition resulting in death) sequentially list conditions, if any leading to the cause listed on the line a.
	Enter the <strong>UNDERLYING CAUSE</strong>(disease on injury that initiated the events resulting in death) <strong>LAST</strong>
	</td>
	<td colspan="2" width="700" align="left">
	a. <input type="text" name="cause1" id="cause1" size='65'>
	</td>
	<td align="center" width="200">
	<input type="text" name="interval1" id="interval1" size="15">
	</td>
	</tr>
	<tr>
	<td colspan="2" width="700" align="left">
	b. <input type="text" name="cause2" id="cause2" size='65'>
	</td>
	<td align="center" width="200">
	<input type="text" name="interval2" id="interval2" size="15">
	</td>
	</tr>
	<tr>
	<td colspan="2" width="700" align="left">
	c. <input type="text" name="cause3" id="cause3" size='65'>
	</td>
	<td align="center" width="200">
	<input type="text" name="interval3" id="interval3" size="15">
	</td>
	</tr>
	<tr>
	<td colspan="2" width="700" align="left">
	d. <input type="text" name="cause4" id="cause4" size='65'>
	</td>
	<td align="center" width="200">
	<input type="text" name="interval4" id="interval4" size="15">
	</td>
	</tr>
	<tr>
	  <td rowspan="2" colspan="3" width="600" align="center"><strong>PART 2.</strong>Enter other <u>signaficant conditions contributing to death</u> but not <u>resulting in the underlying cause in <strong>PART 1</strong></u>  </td>
	 <td  width="600" align="left">
	18. WAS AN AUTOPSY PERFORMED? 
	<input type="radio" name="autopsy" id="autopsy1" value='Yes' ><label for="autopsy1"><strong>Yes</strong></label>
	<input type="radio" name="autopsy" id="autopsy2" value='No' ><label for="autopsy2"><strong>No</strong></label>
	</td>
	</tr>
	<tr>
	<td  width="600" align="left">
	19. WERE AUTOPSY FINDINGS AVAILABLE TO COMPLETE THE CAUSE OF DEATH? 
	<input type="radio" name="autopsystatus" id="autopsystatus1" value='Yes' ><label for="autopsystatus1"><strong>Yes</strong></label>
	<input type="radio" name="autopsystatus" id="autopsystatus2" value='No' ><label for="autopsystatus2"><strong>No</strong></label>
	</td>
	</tr>
	<tr>
	<td colspan="3" width="600" align="left">
	20. IF FEMALE: <br>
	<input type="radio" name="pregnant" id="pregnant1" value='Not Pregnant' ><label for="pregnant1">Not Pregnant</label><br>
	<input type="radio" name="pregnant" id="pregnant2" value='Pregnant at time of death' ><label for="pregnant2">Pregnant at time of death</label><br>
	<input type="radio" name="pregnant" id="pregnant3" value='Not Pregnant, but pregnant within 42days of death.' ><label for="pregnant3">Not Pregnant, but pregnant within 42days of death.</label><br>
	<input type="radio" name="pregnant" id="pregnant4" value='Not Pregnant, but pregnant  43days to 1 year before death.' ><label for="pregnant4">Not Pregnant, but pregnant  43days to 1 year before death.</label><br>
	<input type="radio" name="pregnant" id="pregnant5" value='Unknowkn if Pregnant within the past year' ><label for="pregnant4">Unknowkn if Pregnant within the past year</label>
	</td>
	<td width="600" align="left">
	21. MANNER OF DEATH <br>
	<input type="radio" name="mannerofdeath" id="mannerofdeath1" value='Nature' ><label for="mannerofdeath1"><strong>Nature</strong></label>
	<input type="radio" name="mannerofdeath" id="mannerofdeath2" value='Homicide' ><label for="mannerofdeath2"><strong>Homicide</strong></label><br>
	<input type="radio" name="mannerofdeath" id="mannerofdeath3" value='Accident' ><label for="mannerofdeath3"><strong>Accident</strong></label>
	<input type="radio" name="mannerofdeath" id="mannerofdeath4" value='Pending Investigation' ><label for="mannerofdeath4"><strong>Pending Investigation</strong></label><br>
	<input type="radio" name="mannerofdeath" id="mannerofdeath5" value='Suicide' ><label for="mannerofdeath5"><strong>Suicide</strong></label>
	<input type="radio" name="mannerofdeath" id="mannerofdeath6" value='Could not be determined' ><label for="mannerofdeath6"><strong>Could not be determined</strong></label>
	</td>
	</tr>
	<tr>
	<td colspan="4">
	22.DECLARATION<br>
	<p> I, &nbsp; <input name="doctorname" id="doctorname" type="text" autocomplete='off' placeholder="Search the doctor" size="40">
	<input name="doctorcode" id="doctorcode" type="hidden" autocomplete='off'>
	</p>
	<input type="radio" name="declaration" id="declaration1" value='Certifying physician - To the best of my knowledge, death occurred due to the cause(s) and manner stated above.' ><label for="declaration1"><strong>Certifying physician - To the best of my knowledge, death occurred due to the cause(s) and manner stated above.</strong></label><br>
	<input type="radio" name="declaration" id="declaration2" value='Pronouncing & Certifying physician - To the best of my knowledge, death occurred at the time, date and place, and due to the cause(s) and manner stated above.' ><label for="declaration2"><strong>Pronouncing & Certifying physician - To the best of my knowledge, death occurred at the time, date and place, and due to the cause(s) and manner stated above.</strong></label><br>
	<input type="radio" name="declaration" id="declaration3" value='Medical Examine / Coroner - On the basis of examination. and/or investigation, in my opinion, death ocurred at the time, date and place and due to the cause(s) and manner stated above.' ><label for="declaration3"><strong>Medical Examine / Coroner - On the basis of examination. and/or investigation, in my opinion, death ocurred at the time, date and place and due to the cause(s) and manner stated above. </strong></label>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	<tr>
	<td colspan="10">&nbsp;
	 	
	</td>
	</tr>
	<tr>
	<td colspan="2" width="1200" align="right">
	<input type="submit" name="saveform" id="saveform" value="save" style="width: 60px; height:25px; margin-right:100" accesskey="s">
	<input type="hidden" name="frm1submit1" id="frm1submit1" value="frm1submit1">
	
	</td>
	</tr>
	<tr>
	<td colspan="10">&nbsp;
	 	
	</td>
	</tr>
	<tr>
	<td colspan="10">&nbsp;
	 	
	</td>
	</tr>
	<tr>
	<td colspan="10" height="100">&nbsp;
	 	
	</td>
	</tr>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>