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

	$query2 = "select module from master_email where module = '$module'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_email(module,emailto,emailcc,ipaddress,recorddatetime,username) 
		values ('$module','$emailto','$emailcc','$ipaddress','$updatedatetime','$username')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. Mail Details Inserted.";
		$bgcolorcode = 'success';
	}
	else
	{
		$errmsg = "Failed. Module E-Mail Id Already Exists.";
		$bgcolorcode = 'failed';
	}
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_email set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_email set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>
<!DOCTYPE html>
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
	if (document.form1.emailto.value == "")
	{
		alert ("Pleae enter E-Mail To.");
		document.form1.emailto.focus();
		return false;
	}
	if (document.form1.emailcc.value == "")
	{
		alert ("Pleae Enter E-Mail Cc.");
		document.form1.emailcc.focus();
		return false;
	}
   toredirect();
}
function funcDeleteemail(varemailAutoNumber)
{
 var varemailAutoNumber = varemailAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this email'+varemailAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("E-Mail ID Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("E-Mail ID Delete Not Completed.");
		return false;
	}

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
              <td><form name="form1" id="form1" method="post" action="addemail.php" autocomplete="off" onKeyDown="return disableEnterKey(event)" onSubmit="return addemailprocess1()">
                  <table width="776" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>E-Mail Master - Add New</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#AAFF00'; } else if ($bgcolorcode == 'failed') { echo '#FFBF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle" bgcolor="#FFFFFF" class="bodytext3">Module</td>
                        <td align="left" valign="top" bgcolor="#FFFFFF">
						<select name="module" id="module">
						  <option value="" selected="selected">Select Module</option>
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
						<!--<input type="text" style="display:none" />-->
						<input name="emailto" type="text" id="emailto" size="40"/></td>
                      </tr>
					  <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cc:</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="emailcc" type="text" id="emailcc" size="40"/></td>
                      </tr>
					  <!-- <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Password</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="password" type="password" id="password" style="border: 1px solid #001E6A;" size="40"/></td>
                      </tr>-->
					   <!--<tr>
					     <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Body</div></td>
					     <td align="left" valign="top"  bgcolor="#FFFFFF">
					       <textarea id="editor1">&nbsp;</textarea>		
					<script>
						CKEDITOR.replace( 'editor1',
						null,
						''
						);
					</script>
					     </td>
				        </tr>-->
                      <tr>
                        <td width="6%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="94%" align="left" valign="top"  bgcolor="#FFFFFF">
						  <!--<input type="hidden" name="getdata" id="getdata" value="">-->
                          <input type="hidden" name="frmflag1" value="frmflag1"/>
                          <input type="submit" name="Submit" value="Submit"/></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="778" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>E-Mail Master - Existing List</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Module</strong></td>
                        <td width="25%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>To</strong></td>
                        <td width="42%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Cc</strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select module,emailto,emailcc,auto_number from master_email where recordstatus <> 'deleted' order by auto_number desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$module = $res1['module'];
		$emailto = $res1["emailto"];
		$emailcc = $res1["emailcc"];
		$auto_number = $res1["auto_number"];
	
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		  
		?>
                      <tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
					    <a href="addemail.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteemail('<?php echo $fromemail;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="17%" align="left" valign="top"  class="bodytext3"><?php echo $module; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $emailto; ?></td>
						<td width="42%" align="left" valign="top"  class="bodytext3"><?php echo $emailcc; ?></td>
						<td align="left" valign="top"  class="bodytext3">
						<a href="editemail.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="778" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>E-Mail Master - Deleted</strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>To</strong></td>
						<td bgcolor="#ecf0f5" class="bodytext3"><strong>Cc</strong></td>
                        </tr>
                      <?php
		
	    $query1 = "select module,emailto,emailcc,auto_number from master_email where recordstatus = 'deleted' order by auto_number desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$module = $res1['module'];
		$emailto = $res1["emailto"];
		$emailcc = $res1["emailcc"];
		$auto_number = $res1["auto_number"];

		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		?>
        <tr <?php echo $colorcode; ?>>
                        <td width="9%" align="left" valign="top"  class="bodytext3">
						<a href="addemail.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="18%" align="left" valign="top"  class="bodytext3"><?php echo $module; ?></td>
                        <td width="28%" align="left" valign="top"  class="bodytext3"><?php echo $emailto; ?></td>
						<td width="45%" align="left" valign="top"  class="bodytext3"><?php echo $emailcc; ?></td>
						</tr>
                      <?php
		}
		?>
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

