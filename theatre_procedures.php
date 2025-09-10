<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
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
	$speaciality_id = $_REQUEST["speaciality"];
	$procedure_name = $_REQUEST["procedure"];
	//$store = strtoupper($store);
	$templatename = trim($procedure_name);
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
	$query2 = "select * from master_theatrespeaciality_subtype where speaciality_id = '$speaciality_id' and speaciality_subtype_name = '$procedure_name'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "INSERT INTO `master_theatrespeaciality_subtype`(`speaciality_id`, `speaciality_subtype_name`, `created_at`, `updated_at`, `record_status`, `user_id`, `ip_address`, `location_code`) VALUES ('$speaciality_id','$procedure_name','$updatedatetime','$updatedatetime','','$username','$ipaddress','locationcode')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Theatre Procedure Saved.";
		$bgcolorcode = 'success';
        		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Procedure Already Exists.";
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
	$query3 = "update master_theatrespeaciality_subtype set record_status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_theatrespeaciality_subtype set record_status = '' where auto_number = '$delanum'";
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
	overflow-y: scroll;
	overflow-x: scroll;
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
	if (document.form1.procedure.value == "")
	{
		alert ("Please Enter Procedure Name.");
		document.form1.procedure.focus();
		return false;
	}

	if (document.form1.speaciality.value == "")
	{
		alert ("Please Select Speaciality.");
		document.form1.speaciality.focus();
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
              <td><form name="form1" id="form1" method="post" action="theatre_procedures.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Procedures - Add New </strong></td>
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
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Procedure Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="procedure" id="procedure" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Speaciality </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select style="border: 1px solid #001E6A; text-transform:uppercase;" name="speaciality" id="speaciality">
							<option value="">Select Speaciality</option>
							<?php
							  // get speacialities
							     $query_speac= "SELECT * FROM master_theatrespeaciality WHERE record_status <> 'deleted'";
								 $exec_speac= mysqli_query($GLOBALS["___mysqli_ston"], $query_speac) or die ("Error in Query_speac".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while($res_speac = mysqli_fetch_array($exec_speac)){
									//
									$speaciality_id = $res_speac['auto_number'];
									$speaciality_name = $res_speac['speaciality_name'];
							?>
							<option value="<?php echo $speaciality_id;?>"><?php echo $speaciality_name;?></option>
							<?php	
							 }
							?>
						</select>
					    </td>
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
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Procedures  - Existing List </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3">No.</td>
                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Procedure</strong></td>
                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Speaciality </strong></td>
                        <td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
					    $query1 = "SELECT * FROM `master_theatrespeaciality_subtype` WHERE record_status <> 'deleted' order by auto_number";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sid= 0;
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$sid = $sid +1;
						$locationanum = $res1['location_code'];
						$procedurename = $res1["speaciality_subtype_name"];
						$speaciality_id = $res1["speaciality_id"];
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
					    <a href="theatre_procedures.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeletestore('<?php echo $store;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $sid; ?> </td>
                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $procedurename; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
                        	<?php
                        	 $query11 = "SELECT * FROM `master_theatrespeaciality` WHERE auto_number= '$speaciality_id' order by auto_number";
							 $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
							 while ($res11 = mysqli_fetch_array($exec11))
							 {
                        	     $speaciality_name = $res11['speaciality_name'];
                        	     echo $speaciality_name;
                        	  }
                        	 ?> 
                        </td>
                        <!--<td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>-->
                        <td align="left" valign="top"  class="bodytext3">
						<a href="edittheatre_procedure.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>
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
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Procedures - Deleted </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
                      </tr>
                      <?php
		
					    $query1 = "SELECT * FROM `master_theatrespeaciality_subtype` WHERE record_status = 'deleted' order by auto_number";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$sid=0;
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$sid = $sid +1;
						$locationanum = $res1['location_code'];
						$procedurename = $res1["speaciality_subtype_name"];
						$speaciality_id = $res1["speaciality_id"];
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
							<a href="theatre_procedures.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
	                          <div align="center" class="bodytext3">Activate</div>
	                        </a></td>
	                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $sid; ?></td>
	                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $procedurename; ?></td>
	                        <td width="52%" align="left" valign="top"  class="bodytext3">
	                        	<?php
		                        	 $query111 = "SELECT * FROM `master_theatrespeaciality` WHERE auto_number= '$speaciality_id' order by auto_number";
									 $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
									 while ($res111 = mysqli_fetch_array($exec111))
									 {
		                        	     $speaciality_name = $res111['speaciality_name'];
		                        	     echo $speaciality_name;
		                        	  }
		                         ?> 	
	                        </td>
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

