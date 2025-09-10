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
$errmsg = "";

if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
 

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. File Uploaded Successfully.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
	
}
if ($st == 'failed')
{
		$errmsg = "Upload Failed";
}

if ($frm1submit1 == 'frm1submit1')
{
//echo "insertion started";
$regnumber = $_REQUEST["rno"]; 
$sex = $_REQUEST["sex"];
if (isset($_REQUEST["mnin_ain"])) { $mnin_ain = $_REQUEST["mnin_ain"]; } else { $mnin_ain = ""; }
if (isset($_REQUEST["fnin_ain"])) { $fnin_ain = $_REQUEST["fnin_ain"]; } else { $fnin_ain = ""; }
$child_dob = new DateTime($_REQUEST["ADate1"]);
$child_dob = date_format($child_dob,'Y-m-d H:i:s');
if (isset($_REQUEST["cname"])) { $cname = $_REQUEST["cname"]; } else { $cname = ""; }
if (isset($_REQUEST["weight"])) { $weight = $_REQUEST["weight"]; } else { $weight = ""; }
$doctor = $_REQUEST["doctor"];
$doctorcode = $_REQUEST["doctorcode"];
$mname = $_REQUEST["mname"];
if (isset($_REQUEST["maddress"])) { $maddress = $_REQUEST["maddress"]; } else { $maddress = ""; }
if (isset($_REQUEST["faddress"])) { $faddress = $_REQUEST["faddress"]; } else { $faddress = ""; }
if (isset($_REQUEST["mdistrict"])) { $mdistrict = $_REQUEST["mdistrict"]; } else { $mdistrict = ""; }
if (isset($_REQUEST["fdistrict"])) { $fdistrict = $_REQUEST["fdistrict"]; } else { $fdistrict = ""; }
if (isset($_REQUEST["moccupation"])) { $moccupation = $_REQUEST["moccupation"]; } else { $moccupation = ""; }
if (isset($_REQUEST["foccupation"])) { $foccupation = $_REQUEST["foccupation"]; } else { $foccupation = ""; }
$mnationality = $_REQUEST["mnationality"];
$fnationality = $_REQUEST["fnationality"];
$fname = $_REQUEST["fname"];
if (isset($_REQUEST["incharge"])) { $incharge = $_REQUEST["incharge"]; } else { $incharge = ""; }
$query = "select locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res = mysqli_fetch_array($exec);
	$locationcode = $res["locationcode"];

	 $query1112 = "select locationname from master_location where locationcode = '$locationcode'";
	 $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $res1112 = mysqli_fetch_array($exec1112);
	 $locationname = $res1112["locationname"];		

	  $query2 = "select gender,dateofbirth,accountname from master_customer where customercode='$regnumber'";
	  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $res2 = mysqli_fetch_array($exec2);
	  
	  $gender = $res2['gender'];	  
	  $dateofbirth = $res2['dateofbirth'];	  
	  $accountname = $res2['accountname'];
	  $age=calculate_age($dateofbirth);
	//$locationname = $_REQUEST['locationname'];

	$docnumber ='1';
	$query = "select docno from birth_notification order by auto_number desc limit 0,1";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res = mysqli_fetch_array($exec)){
		 $docnumber_n=$res['docno'];
		 $docnumber =++$docnumber_n;		
	}
	
	
 $query26="insert into birth_notification(docno,patientname,patientcode,locationname,locationcode,address,doctor_name,doctor_code,record_date,record_time,username,gender,dateofbirth,accountname,age,child_name,father_name,father_nationality,mother_nationality,weight,baby_birth,child_gender)values('$docnumber','$mname','$regnumber','$locationname','$locationcode','$maddress','$doctor','$doctorcode','$dateonly','$timeonly','$username','$gender','$dateofbirth','$accountname','$age','$cname','$fname','$fnationality','$mnationality','$weight','$child_dob','$sex')";
    $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<script>window.open('print_birthnotification.php?docno=$docnumber','OriginalWindow','width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');window.location.href='medicalnotification.php';</script>";
	 
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

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

</style>

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){

$('#doctor').autocomplete({
		
	source:'ajaxdoctornewsearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var doctorname = ui.item.doctorname;
			var doctorcode = ui.item.doctorcode;
			$('#doctor').val(doctorname);
			$('#doctorcode').val(doctorcode);
			
			},
    });
	$('#weight').keyup(function(){
	$('#weight').val($('#weight').val().replace(/[^\d.]/g, ''));
	});
	$('#weight').blur(function(){
	//alert();
	$('#weight').val(parseFloat($('#weight').val()).toFixed(3));
	});

});

function validCheck(){
if($("#doctorcode").val()==""){
	alert('Please select the doctor from the list.')
	$("#doctor").focus();
	return false;
}
else if($("#maddress").val()==""){
	 alert('Please enter the Medical Records Officer.')
	$("#maddress").focus();
	return false;
}
else if($("#weight").val()==""){
	 alert('Please enter the Weight of Baby.')
	$("#weight").focus();
	return false;
}
else if($("#mnationality").val()==""){
	 alert('Please enter the nationality of mother.')
	$("#mnationality").focus();
	return false;
}
else if($("#fnationality").val()==""){
	alert('Please enter the nationality of father.')
	$("#fnationality").focus();
	return false;
}
else if($("#fname").val()==""){
	alert('Please enter the name of father.')
	$("#fname").focus();
	return false;
}
else if($("#ADate1").val()==""){
	alert('Please enter the date.')
	$("#ADate1").focus();
	return false;
}

return true;
}

</script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>

<?php
	  $query2 = "select customercode,customerfullname from master_customer where customercode='$patientcode'";
	  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	  $res2 = mysqli_fetch_array($exec2);
	  
	  $res2customercode = $res2['customercode'];
	  $customerfullname = $res2['customerfullname'];	
?>

<form name="frmsales" id="frmsales" method="post" action="birth_notification.php" onSubmit="return validCheck()" enctype="multipart/form-data">
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
        <td height="24" colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
    </tr>
      <tr>
        <td><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
			  <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Add Birth Notification</strong></td>
                </tr>
				  <tr bgcolor="#011E6A">
		<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Sex</strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
						
					 
					    
              <select name="sex" id="sex">
			  <?php if($sex != '') { ?>
			  <option value="<?php echo $sex; ?>"><?php echo $sex; ?></option>
			  <?php } ?>
			  <option value="MALE">MALE</option>
			  <option value="FEMALE">FEMALE</option>
		
			  </select>
              </span></td>
						
		       			<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date and Time</strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
 <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','ddMMMyyyy','dropdown',true,'12',true,'past')" style="cursor:pointer"/>									
		            </td>
			  							

                </tr>
				 <tr bgcolor="#011E6A">
			  				

                </tr>
				
				 <tr bgcolor="#011E6A">
			  		<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Name of child if any </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
<input type="text"  name="cname" id="cname" >									
		            </td>
			  			<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Weight of the Child </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 	<input type="text" value="" name="weight" id="weight" size="15" autocomplete='off' >KGs
					 	
					</td>			

                </tr>	
				
					 <tr bgcolor="#011E6A">
			  		<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Reg no </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
<input type="text" value="<?php echo $patientcode; ?>" name="rno" id="rno" readonly="<?php echo $patientcode; ?>" >									
		            </td>
					
						<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 	<input type="text" value="" name="doctor" id="doctor" size="30" autocomplete='off' onKeyUp="javascript:document.getElementById('doctorcode').value='';" >
					 	<input type="hidden" value="" name="doctorcode" id="doctorcode" >
					</td>
					</tr>
										 <tr bgcolor="#011E6A">

			  		<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>mother's name </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text" value="<?php echo $customerfullname; ?>"  name="mname" id="mname" >
					</td>						
					<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Medical Records Officer</strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text"  name="maddress" id="maddress" size="30" >
					</td>
                </tr>
				<tr>
				<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Nationality </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text"  name="mnationality" id="mnationality" >
					</td>
	 <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Mother NIN/AIN </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text"  name="mnin_ain" id="mnin_ain" >
					</td>

	  
  </tr>
			    <tr bgcolor="#011E6A">
			  	
			  								

                </tr>
					 <tr bgcolor="#011E6A">
			  										
		    			  		<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Father's name </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text"  name="fname" id="fname" >
					</td>						
<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Nationality </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text"  name="fnationality" id="fnationality" >
					</td>	
                </tr>
				<tr>
	 <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Father NIN/AIN </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 		<input type="text"  name="fnin_ain" id="fnin_ain" >
					</td>

  </tr>
				    <tr bgcolor="#011E6A">
			  		
			  							


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
         
<tr></tr>
                

			<?php 
		?>
<!--			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				  
               </tr>
-->          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
			  
			  <br> <br>
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return textareacontentcheck()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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