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

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{  
    $module = $_REQUEST["module"];
	$emailto = $_REQUEST["emailto"];
	$emailcc = $_REQUEST['emailcc'];
	$anum = $_REQUEST['anum'];

	    $query1 = "update master_email set module = '$module',emailto = '$emailto',emailcc = '$emailcc' where auto_number = '$anum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New E-Mail Updated.";

	header ("location:addemail.php?bgcolorcode=success&&st=edit&&anum=$anum");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select auto_number,module,emailto,emailcc from master_email where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$res1module = $res1['module'];
	$res1emailto = $res1['emailto'];
    $res1emailcc= $res1['emailcc'];
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New E-Mail Updated.";
}
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
<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">
function addemailprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.module.value == "")
	{
		alert ("Pleae Select Module Name.");
		document.form1.module.focus();
		return false;
	}
   
   toredirect();
}
function toredirect()
{ 
var content = CKEDITOR.instances.editor1.getData();

document.getElementById("getdata").value = content;

//alert(content);
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
              <td><form name="form1" id="form1" method="post" action="editemail.php" onKeyDown="return disableEnterKey(event)" onSubmit="return addemailprocess1()">
                  <table width="806" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>E-Mail Master - Edit </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Module</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="module" id="module"  >
                        <?php
						if ($res1module == '')
						{
						echo '<option value="" selected="selected">Select Location</option>';
						}
                        ?>
						   <option value="<?php echo $res1module; ?>"><?php echo $res1module; ?></option>
                           <option value="Automatic PI">Automatic PI</option>
						   <option value="Purchase Indent">Purchase Indent</option>
						   <option value="Budget Approval">Budget Approval</option>
						   <option value="Finance Approval">Finance Approval</option>
						   <option value="CEO Approval">CEO Approval</option>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">To:</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="emailto" id="emailto"  value="<?php echo $res1emailto;?>" size="40" /></td>
                      </tr>
					   <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cc:</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="emailcc" id="emailcc" type="emailcc" value="<?php echo $res1emailcc; ?>" size="40" /></td>
                      </tr>
					  <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Body</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<textarea id="editor1"><?php echo $res1emailbody; ?></textarea>		
					<script>
						CKEDITOR.replace( 'editor1',
						null,
						''
						);
					</script>
						</td>
                      </tr>-->
                      <tr>
                        <td width="12%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="88%" align="left" valign="top"  bgcolor="#FFFFFF"><br>
                        <!--<input type="hidden" name="getdata" id="getdata" value="">-->
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="hidden" name="anum" id="anum" value="<?php echo $res1autonumber; ?>">
                        <input type="submit" name="Submit" value="Submit"/></td>
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

