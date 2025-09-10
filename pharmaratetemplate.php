<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$locationcode = $_REQUEST["location"];
	$templatename = $_REQUEST["templatename"];
	//$markup = $_REQUEST['markup'];
	if (isset($_POST["markup"])) { $markup = $_POST["markup"]; } else { $markup = 0; }
	//$store = strtoupper($store);
	$templatename = trim($templatename);
	$length=strlen($templatename);
	
	$query6 = "select * from master_location where locationcode = '$locationcode'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$location = $res6['auto_number'];
	$locationname = $res6['locationname'];
	$locationcode = $res6['locationcode'];
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from pharma_rate_template where templatename = '$templatename' and locationcode = '$locationcode'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into pharma_rate_template (templatename,markup,username,locationname,locationcode,date,recordstatus) 
		values ('$templatename','$markup','$username','$locationname','$locationcode','$updatedatetime','')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Pharmacy Template Saved.";
		$bgcolorcode = 'success';
        
        //last insert id
        $last_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		
		require 'pharmacyratefunction.php';

        $rate_update = updaterate($last_id,$markup);


		/*$margin = $markup;

		if($margin > 0){
			//Get all medicine from master_medicine
			$query_med = "SELECT * FROM master_medicine WHERE status <> 'deleted'";
			$exec_med = mysql_query($query_med) or die ("Error in Query_med".mysql_error());
			while($res_med = mysql_fetch_array($exec_med)){
				$item_id = $res_med['itemcode'];
				$item_price = (float)$res_med['purchaseprice'];

				$var_price = (($margin / 100) * $item_price);
				$new_price = ($item_price + $var_price);

				$date= date("Y-m-d");

				//insert new row in template rate mapping
				$sqlquerymap= "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus) VALUES ('$last_id','$item_id','$new_price','$username','$date','')";
				$exequerymap = mysql_query($sqlquerymap);

				//check subtypes linked // if any update values
				$query_st = "SELECT * FROM master_subtype WHERE pharmtemplate = '$last_id'";
				$exec_st = mysql_query($query_st) or die ("Error in Query_st".mysql_error());
				while($res_st = mysql_fetch_array($exec_st)){
					$subtype = $res_st['auto_number'];
					$col = 'subtype_'.$subtype;
					//update master med
					$sqlquery_st_med= "UPDATE master_medicine SET $col = '$new_price' WHERE itemcode = '$item_id')";
					$exequery_st_med = mysql_query($sqlquery_st_med);
				}
			}
		} */
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Pharmacy Template Already Exists.";
		$bgcolorcode = 'failed';
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update pharma_rate_template set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update pharma_rate_template set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
/*
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update pharma_rate_template set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update pharma_rate_template defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_store set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}*/


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Store To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


/*
$query5 = "select storecode from master_store where 1 order by auto_number desc";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	$res=mysql_fetch_array($exec5);
	 $storecode=$res['storecode'];
	 $storecode=$res['storecode'];
	 $stotemp=substr($storecode,3,9);
	 $storecode=$stotemp+1;*/
	

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

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.templatename.value == "")
	{
		alert ("Please Enter Pharma Template Name.");
		document.form1.templatename.focus();
		return false;
	}

	if (document.form1.markup.value == "")
	{
		alert ("Please Enter Pharma Template markup.");
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


function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

function funcDeletestore(varstoreAutoNumber)
{
 var varstoreAutoNumber = varstoreAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this '+varstoreAutoNumber+'?');
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
              <td><form name="form1" id="form1" method="post" action="pharmaratetemplate.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Rate Template - Add New </strong></td>
                         <td width="10%" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						?>
						
						
                  
                  </td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);"   style="border: 1px solid #001E6A;">
						
                          <?php
							$query5 = "select * from master_location where status = '' order by locationname";
							$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res5 = mysqli_fetch_array($exec5))
							{
							$locationcode = $res5["locationcode"];
							$res5location = $res5["locationname"];
							?>
			                          <option value="<?php echo $locationcode; ?>"><?php echo $res5location; ?></option>
			                          <?php
							}
							?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Template Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="templatename" id="templatename" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
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
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Markup </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="number" name="markup" id="markup" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="" /></td>
                      </tr>
                      <?php 
                         } 
					   ?>
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
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Rate Template  - Existing List </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Location </strong></td>
                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Template Name </strong></td>
                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Markup </strong></td>
                        <td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
					    $query1 = "select * from pharma_rate_template where recordstatus <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationanum = $res1['locationcode'];
						$templatename = $res1["templatename"];
						$markup = $res1["markup"];
						$auto_number = $res1["auto_number"];
						//$defaultstatus = $res1["defaultstatus"];
						
						$query2 = "select * from master_location where locationcode = '$locationanum'";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$location = $res2['locationname'];
					
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
					    <a href="pharmaratetemplate.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeletestore('<?php echo $store;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $templatename; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $markup; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editpharmaratetemplate.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>
						</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Rate Master - Deleted </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                      </tr>
                      <?php
		
					    $query1 = "select * from pharma_rate_template where recordstatus = 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationanum = $res1['locationcode'];
						$templatename = $res1["templatename"];
						$markup = $res1["markup"];
						$auto_number = $res1["auto_number"];
						//$defaultstatus = $res1["defaultstatus"];
						
						$query2 = "select * from master_location where locationcode = '$locationanum'";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$location = $res2['locationname'];
					
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
	                        <td width="11%" align="left" valign="top"  class="bodytext3">
							<a href="pharmaratetemplate.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
	                          <div align="center" class="bodytext3">Activate</div>
	                        </a></td>
	                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>
	                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $templatename; ?></td>
	                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $markup; ?></td>
				        </tr>
				        <?php
						}
						?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
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

