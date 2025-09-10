<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];

$financialyearsettings1errmsg = '';

if (isset($_REQUEST["errno"])) { $errno = $_REQUEST["errno"]; } else { $errno = ""; }
//$errno = $_REQUEST['errno'];
if (isset($_REQUEST["errmodule"])) { $errmodule = $_REQUEST["errmodule"]; } else { $errmodule = ""; }
//$errmodule = $_REQUEST['errmodule'];
if ($errno == 1)
{
	if ($errmodule == 'financialyearsettings1')
	{
		$financialyearsettings1errmsg = "* Financial Year Settings Update Completed.";
	}
	if ($errmodule == 'defaultcountrysettings1')
	{
		$defaultcountrysettings1errmsg = "* Default Country Settings Update Completed.";
	}
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
.bodytext31 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
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
  </tr><tr>
    <td width="1%" valign="top">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
	
	
   	  <form id="financialyearsettings1" name="financialyearsettings1" method="post" action="settingsmaster2.php">
	<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#011E6A">
          <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Current Financial Year Settings - Select The Current Financial Year To Make It Default Year </strong></td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="middle"  
		  bgcolor="<?php if ($financialyearsettings1errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $financialyearsettings1errmsg; ?>&nbsp;</td>
          </tr>
        <tr>
          <td width="35%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Current Financial Year Settings </strong></td>
          <td width="65%" align="left" valign="top"  bgcolor="#FFFFFF">
			<select name="settingsvalue" id="settingsvalue">
			<?php
			$query1 = "select * from master_settings where modulename = 'SETTINGS' and settingsname = 'CURRENT_FINANCIAL_YEAR' 
			and status <> 'deleted' and companyanum = '$companyanum' and companycode = '$companycode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1settingsvalue = $res1['settingsvalue'];
			?>
			<option value="<?php echo $res1settingsvalue; ?>" selected="selected">FINANCIAL YEAR - <?php echo $res1settingsvalue; ?></option>
			<?php
			}
			?>
			<option value="2012">FINANCIAL YEAR - 2012</option>
			<option value="2013">FINANCIAL YEAR - 2013</option>
			<option value="2014">FINANCIAL YEAR - 2014</option>
			<option value="2015">FINANCIAL YEAR - 2015</option>
			<option value="2016">FINANCIAL YEAR - 2016</option>
			<option value="2017">FINANCIAL YEAR - 2017</option>
			<option value="2018">FINANCIAL YEAR - 2018</option>
			<option value="2019">FINANCIAL YEAR - 2019</option>
			<option value="2020">FINANCIAL YEAR - 2020</option>
			</select>
            <input type="hidden" name="financialyearsettings1" id="financialyearsettings1" value="financialyearsettings1" />
          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" />		  </td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* Bill Number Will Be Reset To Number One For Every New Financial Year. </td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* To Have Continuous Bill Number, Do Not Update Financial Year.  </td>
        </tr>
        <tr>
          <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* Bill Number Update Will Be Effective Only For Sales Entry. Not Applicable To Purchase Or Other Entries. </td>
        </tr>
      </tbody>
    </table>  
      </form>	  </td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><form id="defaultcountrysettings1" name="defaultcountrysettings1" method="post" action="settingsmaster2.php">
        <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Default Country  Settings - Select Default Country To Appear On Patient Registration </strong></td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="middle"  
		  bgcolor="<?php if ($financialyearsettings1errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $financialyearsettings1errmsg; ?>&nbsp;</td>
            </tr>
            <tr>
              <td width="35%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Current Default Country </strong></td>
              <td width="65%" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="settingsvalue" id="settingsvalue">
            <?php
			$query1 = "select * from master_settings where modulename = 'SETTINGS' and settingsname = 'DEFAULT_COUNTRY_SETTING' 
			and status <> 'deleted' and companyanum = '$companyanum' and companycode = '$companycode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1settingsvalue = $res1['settingsvalue'];
			?>
            <option value="<?php echo $res1settingsvalue; ?>" selected="selected"><?php echo $res1settingsvalue; ?></option>
            <?php
			}
			$query2 = "select * from master_country where status = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2country = $res2['country'];
			$res2country = strtoupper($res2country);
			?>
            <option value="<?php echo $res2country; ?>"><?php echo $res2country; ?></option>
			<?php
			}
			?>
                </select>
                  <input type="hidden" name="defaultcountrysettings1" id="defaultcountrysettings1" value="defaultcountrysettings1" />
                  <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" />              </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* Bill Number Will Be Reset To Number One For Every New Financial Year. </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* To Have Continuous Bill Number, Do Not Update Financial Year. </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* Bill Number Update Will Be Effective Only For Sales Entry. Not Applicable To Purchase Or Other Entries. </td>
            </tr>
          </tbody>
        </table>
    </form></td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><form id="defaultcountrysettings1" name="defaultcountrysettings1" method="post" action="settingsmaster2.php">
        <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Default Country  Settings - Select Default Country To Appear On Patient Registration </strong></td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="middle"  
		  bgcolor="<?php if ($financialyearsettings1errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $financialyearsettings1errmsg; ?>&nbsp;</td>
            </tr>
            <tr>
              <td width="35%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Current Default Country </strong></td>
              <td width="65%" align="left" valign="top"  bgcolor="#FFFFFF"><select name="settingsvalue" id="settingsvalue">
                  <?php
			$query1 = "select * from master_settings where modulename = 'SETTINGS' and settingsname = 'DEFAULT_COUNTRY_SETTING' 
			and status <> 'deleted' and companyanum = '$companyanum' and companycode = '$companycode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$res1settingsvalue = $res1['settingsvalue'];
			?>
                  <option value="<?php echo $res1settingsvalue; ?>" selected="selected"><?php echo $res1settingsvalue; ?></option>
                  <?php
			}
			$query2 = "select * from master_country where status = ''";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2country = $res2['country'];
			$res2country = strtoupper($res2country);
			?>
                  <option value="<?php echo $res2country; ?>"><?php echo $res2country; ?></option>
                  <?php
			}
			?>
                </select>
                  <input type="hidden" name="defaultcountrysettings1" id="defaultcountrysettings1" value="defaultcountrysettings1" />
                  <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" />
              </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* Bill Number Will Be Reset To Number One For Every New Financial Year. </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* To Have Continuous Bill Number, Do Not Update Financial Year. </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">* Bill Number Update Will Be Effective Only For Sales Entry. Not Applicable To Purchase Or Other Entries. </td>
            </tr>
          </tbody>
        </table>
    </form></td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>