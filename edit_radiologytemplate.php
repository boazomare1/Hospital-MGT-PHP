<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";



if(isset($_POST['update'])){
	$templatename=$_POST['templatename'];
	 $anum = $_GET["anum"]; 
 $query1 = "update `master_radiologytemplate` set `templatename`='$templatename' where `auto_number`='$anum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $errmsg = "Success.  Name Updated.";
		// //$bgcolorcode = 'success';
		header ("location:addradiologytemplate.php?anum=229");

}



// if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
// if ($frmflag1 == 'frmflag1')
// {
// 	// $departmentanum = $_REQUEST['departmentanum'];
// 	// $department = $_REQUEST["department"];
// 	// $recordstatus = $_REQUEST["recordstatus"];
// 	// $ipaddress = $_REQUEST["ipaddress"];
// 	// $recorddate = $_REQUEST["recorddate"];
// 	// //$department = strtoupper($department);
// 	// $department = trim($department);
// 	// $length=strlen($department);
// 	// $rate1 = $_REQUEST['rate1'];
// 	// $rate2 = $_REQUEST['rate2'];
	
// 	// $skiptriage = isset($_REQUEST['skiptriage'])?'1':'0';
// 	//echo $length;
// 	$department=$_POST['templatename'];
//  		$length=strlen($department);
// 	 $departmentanum = $_REQUEST["anum"];
// 	if ($length<=100)
// 	{
// 	$query2 = "select * from master_radiologytemplate where auto_number = '$departmentanum'";
// 	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
// 	$res2 = mysql_num_rows($exec2);
// 	if ($res2 != 0)
// 	{
// 		$query1 = "update master_radiologytemplate set templatename = '$templatename' where auto_number = '$departmentanum'";
// 		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
// 		$errmsg = "Success.  Name Updated.";
// 		//$bgcolorcode = 'success';
// 		header ("location:edit_radiologytemplate.php?bgcolorcode=success&&st=edit&&anum=$departmentanum");
// 	}
// 	//exit();
// 	else
// 	{
// 		$errmsg = "Failed. Name Already Exists.";
// 		//$bgcolorcode = 'failed';
// 		header ("location:edit_radiologytemplate.php?bgcolorcode=failed&&st=edit&&anum=$departmentanum");
// 	}
// 	}
// 	else
// 	{
// 		$errmsg = "Failed. Only 100 Characters Are Allowed.";
// 		//$bgcolorcode = 'failed';
// 		header ("location:edit_radiologytemplate.php?bgcolorcode=failed&&st=edit&&anum=$departmentanum");
// 	}

// }

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($anum != '')
{
    $query1 = "select * from master_radiologytemplate where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$templatename = $res1['templatename'];
	
}

   
// if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
// if ($bgcolorcode == 'success')
// {
// 		$errmsg = "Success. Name was Updated.";
// }
// if ($bgcolorcode == 'failed')
// {
// 		$errmsg = "Failed. Name Already Exists.";
// }


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
              <td>
              	<form  method="POST">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Template - Name Change </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Change Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="templatename" id="templatename" value="<?php echo $templatename; ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
					  
					  
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<!-- <input type="hidden" name="frmflag" value="addnew" /> -->
                            <!-- <input type="hidden" name="frmflag1" value="frmflag1" /> -->
							<!-- <input type="hidden" name="departmentanum" id="departmentanum" value="<?php echo $res1autonumber; ?>"> -->
                          <input type="submit" name="update" value="Submit" style="border: 1px solid #001E6A" /></td>
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

