<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$bed = $_REQUEST["bed"];
	$bedanum1 = $_REQUEST['bedanum'];
	//$bed = strtoupper($bed);
	$bed = trim($bed);
	
	$query78 = "update master_bedcharge set recordstatus='deleted' where bedanum='$bedanum1'";
    $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$length=strlen($bed);
	$ward = $_REQUEST["ward"];
	$threshold = $_REQUEST['threshold'];
	$grace = $_REQUEST['grace'];

	//echo $length;
	if ($length<=100)
	{
	$query1 = "update master_bed set bed='$bed', ward='$ward',threshold='$threshold',grace='$grace' where auto_number='$bedanum1'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New bed Updated.";
		$bgcolorcode = 'success';
		
		foreach($_POST['charge'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['charge'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
			
		if($pairvar!="")
		{
		$chargequery1="insert into master_bedcharge(bed,bedanum,charge,rate,ipaddress,recorddate,username)values('$bed','$bedanum1','$pairvar','$pairvar1','$ipaddress','$date','$username')";
		$chargeexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $chargequery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		}
		}
		
	}
	//exit();
	
	
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
header("location:addbed.php");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_bed set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_bed set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_bed set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_bed set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_bed set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add bed To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

$query74 = "select * from master_bed where auto_number='$anum'";
$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res74 = mysqli_fetch_array($exec74);
$wardanum = $res74['ward'];
$bed = $res74['bed'];
$threshold = $res74['threshold'];
$threshold = intval($threshold);
$grace = $res74['grace'];
$grace = intval($grace);
$query55 = "select * from master_ward where auto_number='$wardanum'";
						  $exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						  $res55 = mysqli_fetch_array($exec55);
						  $wardfullname = $res55['ward'];
	
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
<script type="text/javascript" src="js/insertnewitembed.js"></script>
<script language="javascript">

function addbedprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.bed.value == "")
	{
		alert ("Please Enter bed Name.");
		document.form1.bed.focus();
		return false;
	}
	if (document.form1.ward.value == "")
	{
		alert ("Please Select ward.");
		document.form1.ward.focus();
		return false;
	}
}
function btnDeleteClick9(delID5)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
		

	
}
function funcDeletebed(varbedAutoNumber)
{
     var varbedAutoNumber = varbedAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this bed Type '+varbedAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("bed Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("bed Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editbed.php" onSubmit="return addbedprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Bed Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">Select Ward </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="ward" id="ward">
                          <option value=""> Select Ward</option>
						  <?php
						if ($wardanum != '')
						{
						?>
                    <option value="<?php echo $wardanum; ?>" selected="selected"><?php echo $wardfullname; ?></option>
                    <?php
						}
						else
						{
						?>
                    <option value="" selected="selected">Select Ward</option>
                    <?php
						}
						$query1 = "select * from master_ward where recordstatus <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1ward = $res1["ward"];
						$res1anum = $res1['auto_number'];
						
						?>
                    <option value="<?php echo $res1anum; ?>"><?php echo $res1ward; ?></option>
                    <?php
						}
						?>
           
                        </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Bed </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="bed" id="bed" style="border: 1px solid #001E6A;" size="40" value="<?php echo $bed; ?>" />
						<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $anum; ?>"></td>
                      </tr>
                       <tr id="radid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				   <table id="presid" width="300" border="0" cellspacing="1" cellpadding="1">
				   <tbody id="insertrow2">
                     <tr>
                      <td width="10" class="bodytext3" align="center">Charge</td>
                       <td class="bodytext3" align="center">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                       
                     </tr>
					 
					 <?php
				$itemcount = "";
				//To populate items already in the bill if in edit mode.
				include ('bed_edit1listing1.php');
				//value to initiate serial number if in edit mode.
				$itemcount = $itemcount;
				?>
				</tbody>
				</table>
				<tr>
				<td colspan="11" bgcolor="#FFFFFF" class="bodytext3">
				 <table border="0" cellspacing="1" cellpadding="1">
				 <tbody>
                    <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="chargecode" id="chargecode" value="">
				   <td width="30" align="center"> <input name="charge[]" id="charge" type="text" size="20" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem7()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					 <input type="hidden" name="h" id="h" value="0">
					 </tbody>
                   </table>				  </td>
			       </tr>
			    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Threshold</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="threshold" id="threshold" style="border: 1px solid #001E6A;" size="10" value="<?php echo $threshold; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Grace </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="grace" id="grace" style="border: 1px solid #001E6A;" size="10" value="<?php echo $grace; ?>"/></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
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

