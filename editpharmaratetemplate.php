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
    $pharmaanum = $_REQUEST['pharmaanum'];
	$location = $_REQUEST["location"];
	$templatename = $_REQUEST["templatename"];
	//$markup = $_REQUEST["markup"];
	if (isset($_POST["markup"])) { $markup = $_POST["markup"]; } else { $markup = 0; }
	//$store = strtoupper($store);
	$templatename = trim($templatename);
	$length=strlen($templatename);
	
	$query6 = "select * from master_location where auto_number = '$location'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$locationcode = $res6['locationcode'];
	$locationname = $res6['locationname'];
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from pharma_rate_template where auto_number = '$pharmaanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
	    $query1 = "update pharma_rate_template set templatename = '$templatename',markup = '$markup',locationcode = '$locationcode',locationname = '$locationname' where auto_number = '$pharmaanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Pharmacy Rate Template Updated.";
		//last insert id
        //$last_id = mysql_insert_id($query1);
        $tempid=$last_id = $pharmaanum;

       // require 'pharmacyratefunction.php';

        //$rate_update = updaterate($last_id,$markup);

		$margin = $markup;
		if($margin > 0){
			//Get all medicine from master_medicine
			$query_med = "SELECT * FROM master_medicine WHERE status <> 'deleted'";
			$exec_med = mysqli_query($GLOBALS["___mysqli_ston"], $query_med) or die ("Error in Query_med".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_med = mysqli_fetch_array($exec_med)){
				$item_id = $res_med['itemcode'];
				$item_price = (float)$res_med['purchaseprice'];

				$var_price = (($margin / 100) * $item_price);
				$new_price = round(($item_price + $var_price),0);

				$date= date("Y-m-d");

				//insert new row in template rate mapping
				$sqlquerymap= "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus, margin, ipaddress) VALUES ('$tempid','$item_id','$new_price','$username','$date','','$margin','$ipaddress')";
				//echo $sqlquerymap.'<br>';
				$exequerymap = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquerymap);

				//check subtypes linked // if any update values
				$array_subtype = array();
				$query_st = "SELECT auto_number FROM master_subtype WHERE pharmtemplate = '$tempid' ";
				$exec_st = mysqli_query($GLOBALS["___mysqli_ston"], $query_st) or die ("Error in Query_st".mysqli_error($GLOBALS["___mysqli_ston"]));
				$count=0;
				$col = "";
				//var_dump($res_st);
				while($res_st = mysqli_fetch_assoc($exec_st)){
					$count++;
					 $subtype = $res_st['auto_number'];

					if($count > 1){
						$col .=',';
					}

					 //$col .= 'subtype_'.$subtype." = ".$new_price;
					 $col= 'subtype_'.$subtype;
				$sqlquery_st_med= "UPDATE master_medicine SET $col='$new_price' WHERE itemcode = '$item_id'";
				//echo $col.'<br>';
				//echo $sqlquery_st_med.'<br>';
			    $exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);
				}
			
				// update master med
				//$sqlquery_st_med= "UPDATE master_medicine SET $col WHERE itemcode = '$item_id'";
				//echo $col.'<br>';
				//echo $sqlquery_st_med.'<br>';
			    //$exequery_st_med = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery_st_med);
			}
		}
			//$bgcolorcode = 'success';
		header ("location:pharmaratetemplate.php?bgcolorcode=success&&st=edit&&anum=$pharmaanum");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Pharmacy Rate Template Already Exists.";
		//$bgcolorcode = 'failed';
	header ("location:editpharmaratetemplate.php?bgcolorcode=failed&&st=edit&&anum=$pharmaanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editpharmaratetemplate.php?bgcolorcode=failed&&st=edit&&anum=$pharmaanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from pharma_rate_template where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
    $res1location = $res1['locationcode'];
    $res1templatename = $res1['templatename'];
	$res1markup = $res1['markup'];
	
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Pharmacy Rate Template Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Pharmacy Rate Already Exists.";
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.templatename.value == "")
	{
		alert ("Pleae Enter Template Name.");
		document.form1.templatename.focus();
		return false;
	}
	if (document.form1.markup.value == "")
	{
		alert ("Pleae Enter Markup.");
		document.form1.markup.focus();
		return false;
	}

	if (document.form1.markup.value == "0")
	{
		alert ("Markup should be greater than 0.");
		document.form1.markup.focus();
		return false;
	}
    
    if (document.form1.markup.value < "0")
	{
		alert ("Markup should be greater than 0.");
		document.form1.markup.focus();
		return false;
	}

	// show loader
	FuncPopup();
	document.form1.submit();
	return true;
}
function funcDeletestore(varstoreAutoNumber)
{
 var varstoreAutoNumber = varstoreAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varstoreAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Store Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Store Entry Delete Not Completed.");
		return false;
	}

}
</script>

<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
<body>
<!-- ajax loader -->
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>

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
              <td><form name="form1" id="form1" method="post" action="editpharmaratetemplate.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Rate Template Master - Edit </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New  Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location"  style="border: 1px solid #001E6A;">
                          <?php
						
						if ($res1location == '')
						{
						echo '<option value="" selected="selected">Select Location</option>';
						}
						else
						{
						$query4 = "select * from master_location where locationcode = '$res1location'";
						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res4 = mysqli_fetch_array($exec4);
						$res4dlocationanum = $res4['auto_number'];
						$res4locationname = $res4['locationname'];
					
						echo '<option value="'.$res4dlocationanum.'" selected="selected">'.$res4locationname.'</option>';
						}
					
						$query5 = "select * from master_location where status = '' order by locationname";
						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res5 = mysqli_fetch_array($exec5))
						{
						$res5anum = $res5["auto_number"];
						$res5location = $res5["locationname"];
						?>
						<option value="<?php echo $res5anum; ?>"><?php echo $res5location; ?></option>
						<?php
						}
						?>
                        </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Edit Template Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="templatename" id="templatename"  value="<?php echo $res1templatename;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      <?php
                        // Select pharmacyformula from master_company
					 		$query_formula = "SELECT pharmacyformula FROM master_company";
							$exec_formula = mysqli_query($GLOBALS["___mysqli_ston"], $query_formula) or die ("Error in Query_formula".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res_formula = mysqli_fetch_array($exec_formula)){
								//
								$pharmacyformula = $res_formula['pharmacyformula'];
							}
							if($pharmacyformula == '2'){
                      ?>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Edit Markup </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="number" name="markup" id="markup"  value="<?php echo $res1markup;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      <?php 
                         } 
					   ?>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="hidden" name="pharmaanum" id="pharmaanum" value="<?php echo $res1autonumber; ?>">
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

