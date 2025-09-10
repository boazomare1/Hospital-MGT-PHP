<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
if(isset($_POST['sub']))
{
	$visitcode=$_REQUEST['visit'];
	mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set medicineissue='completed' where visitcode='$visitcode'");
}
?>
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

</style>

<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frmsales" id="frmsales" method="post" action="pharmacy1.php" onKeyDown="return disableEnterKey(event)">
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
  <tr>
       <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine Name</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Quantity</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
               </tr>
<?php
$query1 = "select * from master_consultationpharm where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res1 = mysqli_fetch_array($exec1))
{
$res1medicinename = $res1["medicinename"];
$res1dose = $res1["dose"];
$res1frequency = $res1["frequencynumber"];
$res1days = $res1["days"];
$res1quantity = $res1["quantity"];
$res1rate = $res1["rate"];
$res1amount = $res1["amount"];
//echo '<br>'. $res1medicinename;
//echo '<br>'. $res1dose;
//echo '<br>'.$res1frequency;
//echo '<br>'.$res1days;
?>
<tr>
<td><textarea name="medicinename" id="medicinename" readonly="readonly"><?php echo $res1medicinename;?></textarea></td>
<td><input name="dose" type="text" id="dose"  readonly="readonly" value="<?php echo $res1dose;?>" size="10" maxlength="10" /></td>
<td><input name="quantity" type="text" id="quantity" readonly="readonly" value="<?php echo $res1quantity;?>" size="10" maxlength="10"/></td>
<td><input name="rate" type="text" id="rate" readonly="readonly" value="<?php echo $res1rate;?>" size="10" maxlength="10"/> </td>
<td colspan="2"><input name="amount" type="text" readonly="readonly" id="amount"  value="<?php echo $res1amount;?>" size="10" maxlength="10" />
<input type="hidden" name="visit" value="<?php echo $visitcode;?>" /></td>
<?php 
}?>
</tr>
<tr>
<td></td>
</tr>
<tr>
</tr>
</table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>