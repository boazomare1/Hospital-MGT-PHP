<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	include ("backupsoftwarefoldercode1.php");
	
	header ("location:backupsoftwarefolder1.php?st=success&&foldername=$backupfoldername");
	exit;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	
	$query3 = "select * from master_backupsoftware where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$deletefilename = $res3['backupfilename'];
	
	unlink('zbackupsoftwarefiles/'.$deletefilename.'');

	$query3 = "delete from master_backupsoftware where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	header ("location:backupsoftware1.php?st=deleted");
	exit;
}
if ($st == 'success')
{
	$errmsg = "Success. Software Backup Completed. Please Download & Save File From List Given Below For Future Reference.";
	$bgcolorcode = 'success';
}
if ($st == 'deleted')
{
	$errmsg = "Success. Software Delete Completed.";
	$bgcolorcode = 'success';
}

if (isset($_REQUEST["foldername"])) { $foldername = $_REQUEST["foldername"]; } else { $foldername = ""; }


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function funcTakeBackup1()
{
	var fRet;
	fRet = confirm('Are You Sure Want To Take Software Backup Now?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Proceeding To Take Software Backup. Please Wait A Moment.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Software Backup Not Completed.");
		return false;
	}
	//return false;
}

function funcDeleteBackup1(varDeleteFileName)
{
	var varDeleteFileName = varDeleteFileName;
	var fRet;
	fRet = confirm('Are You Sure Want To Delete Software Backup File '+varDeleteFileName+' ?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Success. Software Backup Delete Completed");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Failed. Software Backup Delete Not Completed.");
		return false;
	}
	//return false;
}

/*
function funcDownloadBackup1(varDownloadFileName)
{
	var varDownloadFileName = varDownloadFileName;
	window.location = "zbackupsoftwarefiles/"+varDownloadFileName+"";
}
*/

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
              <td><form name="form1" id="form1" method="post" action="backupsoftwarefolder1.php">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Software Backup (Offline) - Click Button To Take Backup of Software </strong></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
                            <div align="center">
                              <input type="hidden" name="frmflag1" value="frmflag1" />
                              <input type="submit" name="Submit" onClick="return funcTakeBackup1()" value="Click To Take Software Backup Now" style="border: 1px solid #001E6A" />
                            </div></td>
                        </tr>
                      <tr>
                        <td align="middle" >&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="middle" ><span class="bodytext3"><strong>*Please Note : Backup Folder Will Be Saved At Location Drive C:/ </strong></span></td>
                      </tr>
                      <tr>
                        <td align="middle" >&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="middle" ><span class="bodytext3">
						<?php
						if ($foldername != '')
						{
						?>
						<strong>*Folder Name : <?php echo $foldername; ?></strong>
						<?php
						}
						?>
						</span></td>
                      </tr>
                      <tr>
                        <td align="middle" >&nbsp;</td>
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

