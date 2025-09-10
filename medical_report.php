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

$locationquery="select locationcode from login_locationdetails where username='$username'  and docno='$docno'";
$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $locationquery);
$resloc=mysqli_fetch_array($exeloc);
$locationcode=$loginlocation=$resloc['locationcode'];

$logindetail="select * from master_location where locationcode='$loginlocation'";
$exeloc1=mysqli_query($GLOBALS["___mysqli_ston"], $logindetail);
$resloc1=mysqli_fetch_array($exeloc1);
$locationname=$resloc1['locationname'];
 $address=$resloc1['address1'];
 $phonenumber1 = $resloc1["phone"];
$phoneno=$resloc1['phone'];
$email=$resloc1['email'];


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
	
	$patientcode = $_REQUEST['patientcode'];
	$customerfullname = $_REQUEST['customerfullname'];
	$body_content = $_REQUEST['body_content'];
	$address = $_REQUEST['address'];
	$doctor = $_REQUEST['doctor'];
	$doctorcode = $_REQUEST['doctorcode'];
	//$locationname = $_REQUEST['locationname'];

	$docnumber ='1';
	$query = "select docno from medical_report order by auto_number desc limit 0,1";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if($res = mysqli_fetch_array($exec)){
		 $docnumber_n=$res['docno'];
		$docnumber =++$docnumber_n;		
	}
	
   if($body_content != '') 
     {  
     $query26="insert into medical_report(docno,patientname,patientcode,locationname,locationcode,address,body_content,doctor_code,doctor_name,record_date,record_time,username,gender,dateofbirth,accountname,age)values('$docnumber','$customerfullname','$patientcode','$locationname','$locationcode','$address','$body_content','$doctorcode','$doctor','$dateonly','$timeonly','$username','$gender','$dateofbirth','$accountname','$age')";
     $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	  header("location:medicalnotification.php");
      exit();
	 }
	 else
	{
		header ("location:medical_report.php?patientcode=$patientcode&&st=failed");
	}
   
 
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

});

function validCheck(){
if($("#address").val()==""){
	alert('Please Enter the Address')
	$("#address").focus();
	return false;
}
else if($("#doctorcode").val()==""){
	alert('Please select the doctor from the list.')
	$("#doctor").focus();
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

<form name="frmsales" id="frmsales" method="post" action="medical_report.php" onSubmit="return validCheck()" enctype="multipart/form-data">
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
			  <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Add Medical Report</strong></td>
                </tr>
			    <tr bgcolor="#011E6A">
			  		<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
						
					 	<input type="hidden" value="<?= $patientcode ?>" name="patientcode" id="patientcode" >
					 	<input type="hidden" value="<?= $customerfullname ?>" name="customerfullname" id="customerfullname" >
					 	<textarea id="address" name="address" rows="4" cols="40"><?php echo $locationname."\n".$address."\n".$phoneno."\n".$email; ?> </textarea>
						
		            </td>
			  		<td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor </strong></td>
					 <td width="46%" align="left" valign="middle"  bgcolor="#ecf0f5">
					 	<input type="text" value="" name="doctor" id="doctor" size="30" autocomplete='off' onKeyUp="javascript:document.getElementById('doctorcode').value='';" >
					 	<input type="hidden" value="" name="doctorcode" id="doctorcode" >
					</td>						

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
                 <tr>
                    <textarea id="body_content" cols='50' rows='15' class="ckeditor" name="body_content"></textarea>
				</tr>


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