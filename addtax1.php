<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$taxname = $_REQUEST["taxname"];
	$taxname = strtoupper($taxname);
	$taxpercent = $_REQUEST["taxpercent"];
	$query10="select * from master_tax";
	$exec10=mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10=mysqli_num_rows($exec10);
	if ($res10==0)
	{
	$query2 = "select * from master_tax where taxname = '$taxname'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_tax (taxname, ipaddress, updatetime, taxpercent,defaulttax) 
		values ('$taxname', '$ipaddress', '$updatedatetime', '$taxpercent','default')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Tax Updated.";
	}
	else
	{
		$errmsg = "Failed. Tax Name Already Exists.";
	}
	}
	else
{
    $query2 = "select * from master_tax where taxname = '$taxname'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_tax (taxname, ipaddress, updatetime, taxpercent) 
		values ('$taxname', '$ipaddress', '$updatedatetime', '$taxpercent')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Tax Updated.";
	}
	else
	{
		$errmsg = "Failed. Tax Name Already Exists.";
	}
	//}

}

}


if (isset($_REQUEST["frmflag3"])) { $frmflag3 = $_REQUEST["frmflag3"]; } else { $frmflag3 = ""; }
if ($frmflag3 == 'defaulttax')
{
	if (isset($_REQUEST["defaulttax"])) { $dftaxanum = $_REQUEST["defaulttax"]; } else { $fdftaxanumrmflag3 = ""; }
	
	$query6 = "update master_tax set defaulttax = 'default' where auto_number = '$dftaxanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$errmsg = "Default Tax Settings Updated.";

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	if (isset($_REQUEST["anum"])) { $delanum = $_REQUEST["anum"]; } else { $delanum = ""; }
	
	$query7 = "select * from master_tax where auto_number = '$delanum'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$res7default = $res7["defaulttax"];
	if ($res7default == 'default')
	{
			$errmsg = "Failed. You Are Trying To Delete Default Tax. Delete Failed.";
	}
	else
	{
		$query4 = "select * from master_item where taxanum = '$delanum'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount4 = mysqli_num_rows($exec4);
		if ($rowcount4 == 0)
		{
			$query3 = "update master_tax set status = 'deleted' where auto_number = '$delanum'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
			$errmsg = "Failed. Selected Tax Applies To One Or More Of Active Service / Item. Delete Failed.";
		}
	}
}
if ($st == 'activate')
{
	if (isset($_REQUEST["anum"])) { $delanum = $_REQUEST["anum"]; } else { $delanum = ""; }
	$query3 = "update master_tax set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
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
<script language="javascript">

function addtax1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.taxname.value == "")
	{
		alert ("Please Enter Tax Name.");
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
//}
 //function spl()
//{
//var data=document.form1.taxpercent.value ;
////alert(data);
//  var iChars = "!%^&*()+=[];,.{}|\:<>?~"; 
//   for (var i = 0; i < data.length; i++) {
//   
//  	if (iChars.indexOf(data.charAt(i)) != -1) {
//	
//  	  alert ("Your ServiceName Has Special Characters.\nThese are not allowed.");
//  	return false;
//  	}
//	}
//	}
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
			  
			  <form name="form1" id="form1" method="post" action="addtax1.php" onSubmit="return addtax1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Master - Add New </strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="left" valign="middle"   bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">New Tax  Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="taxname" id="taxname" style="border: 1px solid #001E6A" size="20" />
                        <font  class="bodytext3">( Ex: VAT 4.0 % )</font></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">New Tax  Percentage </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="taxpercent" id="taxpercent" style="border: 1px solid #001E6A" size="20"/>
                        % <font  class="bodytext3">( Ex:  4.0 )</font></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" />                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </form>
							  
							  
							  


                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax  Master - Existing List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="8%" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><strong>Delete</strong></div></td>
                        <td width="8%" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
                        <td width="39%" bgcolor="#FFFFFF" class="bodytext3"><strong>Tax   Name </strong></td>
                        <td width="28%" bgcolor="#FFFFFF" class="bodytext3"><strong>Tax   Percent % </strong></td>
                        <td width="17%" bgcolor="#FFFFFF" class="bodytext3"><strong>Status</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_tax where status <> 'deleted' order by taxname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$taxname = $res1["taxname"];
		$auto_number = $res1["auto_number"];
		$taxpercent = $res1["taxpercent"];
		$taxdefault = $res1["defaulttax"];
		
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
                        <td align="left" valign="top"  class="bodytext3"><div align="center">
						<a href="addtax1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top" >
						<a href="edittax1.php?st=edit&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Edit</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3">
						<?php echo $taxname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						  <div align="right"><?php echo $taxpercent; ?> </div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php //echo strtoupper($taxdefault); ?></td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <br>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax   Master - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td width="11%" bgcolor="#FFFFFF" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>
                        <td width="46%" bgcolor="#FFFFFF" class="bodytext3"><strong>Tax   Name </strong></td>
                        <td width="27%" bgcolor="#FFFFFF" class="bodytext3"><strong>Tax   Percent % </strong></td>
                        <td width="16%" bgcolor="#FFFFFF" class="bodytext3"><strong>Status</strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_tax where status = 'deleted' order by taxname ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$taxname = $res1["taxname"];
		$auto_number = $res1["auto_number"];
		$taxpercent = $res1["taxpercent"];
		
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
                        <td align="left" valign="top" >
						<a href="addtax1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $taxname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $taxpercent; ?></div></td>
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

