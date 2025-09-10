<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyname = $_SESSION['companyname'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$errst = '';
//echo $companyname;

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_POST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$date = date('Y-m-d-H-i-s');
	$uploaddir = "logofiles";
	//$final_filename="$companyname.jpg";
	$final_filename = "$companyanum.jpg";
	$uploadfile123 = $uploaddir . "/" . $final_filename;
	$target_path = $uploadfile123;
	$imagepath = $target_path;
	
	if(move_uploaded_file($_FILES['browse1']['tmp_name'], $target_path)) 
	{
		$errmsg = "Success. Logo Upload Completed.";
		
		$query1 = "update master_company set showlogo = 'SHOW LOGO' where auto_number = '$companyanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$errmsg = "Failed. Logo Upload Not Completed.";
	}
}



if ($errst == 1)
{
	$errmsg = "Update Failed. Try Again.";
}
else if ($errst == 2)
{
	$errmsg = "Update Completed.";
}
//echo $errst;

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
<link href="../hospital/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../hospital/js/adddate.js"></script>
<script type="text/javascript" src="../hospital/js/adddate2.js"></script>
<script language="javascript">

function passwordvalidation1()
{
	if (document.getElementById("currentpassword").value == "")
	{
		alert ("Please Enter Current Password.");
		document.getElementById("currentpassword").focus();
		return false;
	}
	else if (document.getElementById("newpassword").value == "")
	{	
		alert ("Please Enter New Password.");
		document.getElementById("newpassword").focus();
		return false;
	}
	else if (document.getElementById("confirmpassword").value == "")
	{	
		alert ("Please Enter Confirm Password.");
		document.getElementById("confirmpassword").focus();
		return false;
	}
	else if (document.getElementById("newpassword").value != document.getElementById("confirmpassword").value)
	{
		alert ("Please Enter The Same New Password In Current Password Box.");
		document.getElementById("currentpassword").focus();
		return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
      <tr>
        <td align="left"><form name="form1" id="form1" method="post" enctype="multipart/form-data" action="uploadlogo1.php">
          <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
               <tbody>
                 <tr bgcolor="#011E6A">
                   <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Upload Logo </strong></td>
                 </tr>
                 <tr>
                   <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg; ?>&nbsp;</td>
                 </tr>
                 <tr>
                   <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Upload Logo </strong></td>
                 </tr>
                 <tr>
                   <td width="18%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Upload 
                    Logo:</td>
                   <td width="82%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><font size="2" face="Verdana">
                   
                     <input type="file" name="browse1" value="" size="20" style="border: 1px solid #001E6A"/>
                     <font size="2" face="Verdana">Click 
                    Browse To Upload Logo File. </font></font></td>
                 </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">* Please Upload Only <strong>JPEG</strong> File. Other Formats Are Not Accepted. </td>
                 </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">* Image File Size Should Be Less Than<strong> 100 KB</strong>. </td>
                 </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><font size="2" face="Verdana">
                   <input type="hidden" name="frmflag1" value="frmflag1"/>
                   <input type="submit" name="b1" value="Upload Logo" >
                   <font size="2" face="Verdana">&nbsp; </font></font></td>
                 </tr>
                 <tr>
                   <td colspan="2" align="middle" >&nbsp;</td>
                 </tr>
               </tbody>
             </table>
        </form>
          </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>

</html>

