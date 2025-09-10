<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$user=$profileid;
	$date=date('ymd');
	$uploaddir="tab_file_dump";
	$final_filename=$username."_tabdump.txt";
	$photodate = date('y-m-d');
	$photoid = $user.$date;
	
	$fileformat = basename( $_FILES['uploadedfile']['name']);
	$fileformat = substr($fileformat, -3, 3);
	if ($fileformat == 'txt') // || $fileformat == 'peg') // || $fileformat == 'gif')
	{
		//echo "inside if";
		$uploadfile123 = $uploaddir . "/" . $final_filename;
		$target_path = $uploadfile123;
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
		{
			header ("location:chartaccountsdataimport1.php?upload=success");
		}
		else
		{
			header ("location:chartaccountsdataimport.php?upload=failed");
		}
	
	} 
	else
	{
			header ("location:chartaccountsdataimport.php?upload=failed");
	}
	
}

if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }
//$upload = $_REQUEST['upload'];
//echo $upload;
if ($upload == 'success')
{
	$errmsg = "File Upload Completed.";
	$bgcolorcode = 'success';
}
if ($upload == 'failed')
{
	$errmsg = "File Upload Failed. Make Sure You Are Uploading TAB Delimited File.";
	$bgcolorcode = 'failed';
}


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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none;
}
-->
</style>
</head>
<script language="javascript">

function dataimport1verify()
{
	if (document.getElementById("uploadedfile").value == "")
	{
		alert ("Please Select The TAB Delimited File To Proceed.");
		return false;
	}
}

</script>
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form action="chartaccountsdataimport.php" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return dataimport1verify()">
                  <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Accounts Data Import From TAB Delimited File </strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Please Note: </strong></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Only TAB Delimited Files Are Accepted. </strong></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Please Do Not Try To Import Any Other File Format. </strong></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<span class="bodytext3"><strong>Download The Sample File Here.</strong></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3"><strong>Open Sample File, Populate Date, Save as TAB File. Import Here. </strong></span></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><a href="tab_file_dump/sample_import_file1.xls" class="bodytext3"><span class="bodytext3"><strong>Sample Download File Click Here...</strong></span></a></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Select TAB Delimited File To Import Data: </td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="uploadedfile" id="uploadedfile" type="file" size="50" style="border: 1px solid #001E6A"></td>
                      </tr>
                      <tr>
                        <td width="36%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="64%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Proceed To Data Import" style="border: 1px solid #001E6A" />                        </td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				  </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

