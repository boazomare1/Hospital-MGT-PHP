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
$amount1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'edit')
{

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
<script type="text/javascript" src="js/autobasiccalculation1.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.amount.value == "")
	{
		alert ("Pleae Enter Amount.");
		document.form1.amount.focus();
		return false;
	}
	if(isNaN(document.getElementById("amount").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("amount").focus();
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
              <td><form name="form1" id="form1" method="post" action="reversecalculation1.php" onSubmit="return addward1process1()">
                  <table width="50%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Reverse Calculation</strong></td>
                      </tr>
					  <tr>
                        <td colspan="3" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td width="29%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"><strong>GROSS PAY </strong></div></td>
                        <td width="33%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amount" id="amount" value="" style="border: 1px solid #001E6A;" size="20" onKeyUp="return BasicCalculation1(this.value)" /></td>
                        <td width="38%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <input type="hidden" name="Submit" value="Calculate" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
                      </tr>
 
                      <tr bgcolor="#FFFFFF">
                        <td align="right" class="bodytext3"><strong>BASIC</strong></td>
						<td colspan="2" align="left" class="bodytext3"><input type="text" name="basic" id="basic" readonly="readonly" disabled="disabled" style="text-align:right;"></td>
					  </tr>	
						<tr bgcolor="#FFFFFF">
                        <td align="right" class="bodytext3"><strong>NSSF</strong></td>
						<td colspan="2" align="left" class="bodytext3"><input type="text" name="nssf" id="nssf" readonly="readonly" disabled="disabled" style="text-align:right;"></td>
					  </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td align="right" class="bodytext3"><strong>NHIF</strong></td>
						<td colspan="2" align="left" class="bodytext3"><input type="text" name="nhif" id="nhif" readonly="readonly" disabled="disabled" style="text-align:right;"></td>
					  </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td align="right" class="bodytext3"><strong>PAYE</strong></td>
						<td colspan="2" align="left" class="bodytext3"><input type="text" name="paye" id="paye" readonly="readonly" disabled="disabled" style="text-align:right;"></td>
					  </tr>	
					  <tr>
                        <td align="right" class="bodytext3">&nbsp;</td>
						<td colspan="2" align="left" class="bodytext3">&nbsp;</td>
					  </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td align="right" class="bodytext3"><strong>DEDUCTIONS</strong></td>
						<td colspan="2" align="left" class="bodytext3"><input type="text" name="deductions" id="deductions" readonly="readonly" disabled="disabled" style="text-align:right;"></td>
					  </tr>	
					  <tr bgcolor="#FFFFFF">
                        <td align="right" class="bodytext3"><strong>NETT PAY</strong></td>
						<td colspan="2" align="left" class="bodytext3"><input type="text" name="nettpay" id="nettpay" readonly="readonly" disabled="disabled" style="text-align:right;"></td>
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
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

