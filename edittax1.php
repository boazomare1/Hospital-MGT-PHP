<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{

	$taxname = $_REQUEST["taxname"];
	$taxname = strtoupper($taxname);
	$taxpercent = $_REQUEST["taxpercent"];
	$taxanum = $_REQUEST["anum"];
	
	$query1 = "update master_tax set taxname = '$taxname', taxpercent = '$taxpercent', 
	ipaddress = '$ipaddress', updatetime = '$updatedatetime' where auto_number = '$taxanum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query2 = "update master_taxsub set taxparentname = '$taxname' where taxparentanum = '$taxanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$errmsg = "Success. Tax Updated.";
	
	//header ("location:addtax1.php");

}


if (isset($_REQUEST["anum"])) { $taxanum = $_REQUEST["anum"]; } else { $taxanum = ""; }
$query1 = "select * from master_tax where auto_number = '$taxanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$taxname = $res1["taxname"];
$auto_number = $res1["auto_number"];
$taxpercent = $res1["taxpercent"];


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

function addtax1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.taxname.value == "")
	{
		alert ("Pleae Enter Tax Name.");
		document.form1.taxname.focus();
		return false;
	}
	else if (document.form1.taxpercent.value == "")
	{
		alert ("Please Enter Tax Percent.");
		document.form1.taxpercent.focus();
		return false;
	}
	else if (isNaN(document.form1.taxpercent.value) == true)
	{	
		alert ("Please Enter Tax Percent In Numbers.");
		document.form1.taxpercent.focus();
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
              <td><form name="form1" id="form1" method="post" action="edittax1.php?anum=<?php echo $taxanum; ?>" onSubmit="return addtax1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Master Update </strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Update Tax  Name </div></td>
                        <td valign="top" align="left" ><input name="taxname" value="<?php echo $taxname; ?>" id="taxname" style="border: 1px solid #001E6A" size="20" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Update Tax  Percentage </div></td>
                        <td valign="top" align="left" ><input name="taxpercent" value="<?php echo $taxpercent; ?>" id="taxpercent" style="border: 1px solid #001E6A" size="20" />
                        %</td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  class="bodytext3">&nbsp;</td>
                        <td valign="top" align="left" width="58%" ><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag2" value="frmflag2" />
                            <input type="submit" name="Submit" value="Update Tax" style="border: 1px solid #001E6A" />                        </td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				  
				  
				  
				  
				  
				  
				  
<!--                <table width="57%" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax  Master - Existing List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="6%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                        <td width="40%" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Name </strong></td>
                        <td width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Percent % </strong></td>
                        <td width="26%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
	    $query1 = "select * from master_tax where status <> 'deleted' order by taxname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$taxname = $res1["taxname"];
		$auto_number = $res1["auto_number"];
		$taxpercent = $res1["taxpercent"];
		?>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center">
						<a href="addtax1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3">
						<?php echo $taxname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<?php echo $taxpercent; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="57%" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Master - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="11%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                        <td width="35%" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Name </strong></td>
                        <td width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Percent % </strong></td>
                        <td width="26%" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_tax where status = 'deleted' order by taxname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$taxname = $res1["taxname"];
		$auto_number = $res1["auto_number"];
		$taxpercent = $res1["taxpercent"];
		?>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><a href="addtax1.php?st=activate&&anum=<?php echo $auto_number; ?>">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $taxname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $taxpercent; ?></td>
                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
-->				  
				  
				  
				  
				  
				  
				  
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

