<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
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
	$bedtemplate = $_REQUEST["bedtemplate"];
	$maintype = $_REQUEST["maintype"];
	$subtype = $_REQUEST["subtype"];
	$labtemplate = $_REQUEST["labtemplate"];
	$pharmtemplate = $_REQUEST["pharmtemplate"];
	$radtemplate = $_REQUEST["radtemplate"];
	$sertemplate = $_REQUEST["sertemplate"];
	$ippactemplate = $_REQUEST["ippactemplate"];
	$is_savannah = isset($_REQUEST['is_savannah']) ? $_REQUEST['is_savannah'] : '';
	$approvalrequired = isset($_REQUEST['approvalrequired']) ? $_REQUEST['approvalrequired'] : '';
	$slade_payer_code = $_REQUEST["slade_payer_code"];
	$preauthrequired = isset($_REQUEST['preauthrequired']) ? $_REQUEST['preauthrequired'] : '';
	
	
	$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable='$bedtemplate' order by templatename";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$bedtemplate = $res10["templatename"];
	//this is for currency and fxrate
	$currency = $_REQUEST["currency"];
	$fxrate = $_REQUEST["fxrate"];
	
	$subtype = strtoupper($subtype);
	$subtype = trim($subtype);
	$length=strlen($subtype);
	//echo $length;
	if ($length<=100)
	{
		$query1 = "insert into master_subtype (maintype, subtype, ipaddress, recorddate, username,labtemplate,radtemplate,sertemplate,ippactemplate,bedtemplate,currency,fxrate,is_savannah,approvalrequired,pharmtemplate,slade_payer_code,preauthrequired) 
		values ('$maintype', '$subtype', '$ipaddress', '$updatedatetime', '$username','$labtemplate','$radtemplate','$sertemplate','$ippactemplate','$bedtemplate','".$currency."','".$fxrate."','$is_savannah','$approvalrequired','$pharmtemplate','$slade_payer_code','$preauthrequired')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Sub Type Updated.";
		$bgcolorcode = 'success';
		if($exec1){
			$lastid = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
			$columnname = "subtype_".$lastid ;
			$altersql = "ALTER TABLE master_medicine ADD `$columnname` decimal(13,2) NOT NULL ";
			mysqli_query($GLOBALS["___mysqli_ston"], $altersql) or die ("Error in AlterSql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$altersql1 = "ALTER TABLE audit_master_medicine ADD `$columnname` decimal(13,2) NOT NULL ";
			mysqli_query($GLOBALS["___mysqli_ston"], $altersql1) or die ("Error in AlterSql1".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            // select  all medicine rows
            $medsql = "SELECT * from master_medicine WHERE status <> 'deleted'";
            $execmed = mysqli_query($GLOBALS["___mysqli_ston"], $medsql) or die ("Error in Querymedsql".mysqli_error($GLOBALS["___mysqli_ston"]));
            //$count = mysql_num_rows($execmed);
            while ($resmed = mysqli_fetch_assoc($execmed))
			{ 				
				$item_code = $resmed['itemcode'];
				//echo $item_code;
				// update all all columnname values with the pharmacy rate selected
				//$arr_rates = array();
				$ratesql1 = "SELECT * from pharma_template_map WHERE templateid ='$pharmtemplate' AND productcode='$item_code' ORDER BY auto_number DESC LIMIT 1";
				$execrt1 = mysqli_query($GLOBALS["___mysqli_ston"], $ratesql1) or die ("Error in Queryratesql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$count_rate = mysqli_num_rows($execrt1);
				while ($resrt1 = mysqli_fetch_assoc($execrt1))
				{   
					$prod_id=$resrt1['productcode'];
					$rate= $resrt1['rate'];
					
					if ($rate == ''){
						$rt = '0.00';
					}else{
						$rt = $rate;
					}
                    // update rate
                    $ratesql2 = "UPDATE master_medicine SET $columnname = '$rt' WHERE itemcode='$item_code'";
				    $execrt12 = mysqli_query($GLOBALS["___mysqli_ston"], $ratesql2) or die ("Error in Queryratesql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			    }
			}   	

		}
		
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
	
	header("location:addsubtype1.php");
exit();
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_subtype set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_subtype set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_subtype set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_subtype set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_subtype set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Sub Type To Proceed For Billing.";
	$bgcolorcode = 'failed';
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

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.subtype.value == "")
	{
		alert ("Pleae Enter Sub Type Name.");
		document.form1.subtype.focus();
		return false;
	}
	
	if (document.form1.currency.value == "")
	{
		alert ("Pleae Enter Currency.");
		document.form1.currency.focus();
		return false;
	}
	if (document.form1.fxrate.value == "")
	{
		alert ("Pleae Enter FXRate.");
		document.form1.fxrate.focus();
		return false;
	}
	
	if (document.form1.labtemplate.value == "")
	{
		alert ("Pleae Enter Lab Template Name.");
		document.form1.labtemplate.focus();
		return false;
	}
	if (document.form1.pharmtemplate.value == "")
	{
		alert ("Pleae Enter Pharmacy Rate Template Name.");
		document.form1.pharmtemplate.focus();
		return false;
	}
	if (document.form1.radtemplate.value == "")
	{
		alert ("Pleae Enter Radiology Template Type Name.");
		document.form1.radtemplate.focus();
		return false;
	}
	if (document.form1.sertemplate.value == "")
	{
		alert ("Pleae Enter Service Template Type Name.");
		document.form1.sertemplate.focus();
		return false;
	}
	if (document.form1.ippactemplate.value == "")
	{
		alert ("Pleae Enter Ip Package Template Type Name.");
		document.form1.ippactemplate.focus();
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

function funcDeleteSubType(varSubTypeAutoNumber)
{
 var varSubTypeAutoNumber = varSubTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varSubTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Sub Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Sub Type Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="addsubtype1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody style="display:none">
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Sub Type Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New  Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="maintype" id="maintype"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Type</option>
                          <?php
				$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["paymenttype"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="subtype" id="subtype" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Currency</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="currency" id="currency" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" /></td>
                      </tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fxrate </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fxrate" id="fxrate" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" /></td>
                      </tr>
                      
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Lab Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="labtemplate" id="labtemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Lab</option>
						<option value="master_lab" >master_lab</option>						
                          <?php
							$query10 = "select * from master_testtemplate where testname = 'lab' order by templatename";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res10 = mysqli_fetch_array($exec10))
							{
							
							$templatename = $res10["templatename"];
							?>
			                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
			                          <?php
							}
							?>
                        </select>
						</td>
                      </tr>

                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Pharmacy Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="pharmtemplate" id="pharmtemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Pharmacy Template</option>					
                          <?php
							$query100 = "select * from pharma_rate_template where recordstatus <> 'deleted' order by auto_number";
							$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res100 = mysqli_fetch_array($exec100))
							{
							
							$templatename = $res100["templatename"];
							$templateid = $res100["auto_number"];
							?>
			                          <option value="<?php echo $templateid; ?>"><?php echo $templatename; ?></option>
			                          <?php
							}
							?>
                        </select>
						</td>
                      </tr>

					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Radiology Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="radtemplate" id="radtemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Radiology</option>
						<option value="master_radiology" >master_radiology</option>	
                          <?php
				$query11 = "select * from master_testtemplate where testname = 'radiology' order by templatename";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res11 = mysqli_fetch_array($exec11))
				{
				
				$templatename = $res11["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Services Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="sertemplate" id="sertemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Services</option>
						<option value="master_services" >master_services</option>	
                          <?php
				$query12 = "select * from master_testtemplate where testname = 'services' order by templatename";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res12 = mysqli_fetch_array($exec12))
				{
				
				$templatename = $res12["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">IP Package Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="ippactemplate" id="ippactemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Template</option>
						<option value="master_ippackage" >master_ippackage</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'ippackage' order by templatename";
				$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res13 = mysqli_fetch_array($exec13))
				{
				
				$templatename = $res13["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="bedtemplate" id="bedtemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Template</option>
						<option value="master_bed" >master_bed</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!='' order by templatename";
				$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res13 = mysqli_fetch_array($exec13))
				{
				
				$templatename = $res13["referencetable"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  
					   <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Approval Required</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="approvalrequired" value="1">
                          </label></td>
                          
                        </tr>
						   <!--<tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Is Savannah</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="is_savannah" value="1">
                          </label></td>
                        </tr>-->
						
						<tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Pre-Auth Required</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="preauthrequired" value="1">
                          </label></td>
                          
                        </tr>
						
						<tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Slade_payer_code</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="text" name="slade_payer_code" id="slade_payer_code" style="border: 1px solid #001E6A; text-transform:uppercase" size="40">
                          </label></td>
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
                <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#ecf0f5" class="bodytext3"><strong>SubType /Providers - Link to Rate Templates</strong></td>
                      </tr>
                      <tr> 
                        <td align="left" valign="top" bgcolor="#cccccc"  class="bodytext3">&nbsp;</td>
                        <td width="10%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Main Type </strong></td>
                        <td width="20%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Sub Type </strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Lab </strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Pharmacy</strong></td>
						<td width="15%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Radiology</strong></td>
						<td width="15%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Service</strong></td>
						<td width="15%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>IP Package </strong></td>
                        <td width="15%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Bed </strong></td>
                        <td width="5%" align="left" valign="top" bgcolor="#cccccc"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_subtype where recordstatus <> 'deleted' order by maintype ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$maintypeanum = $res1['maintype'];
		$subtype = $res1["subtype"];
		$auto_number = $res1["auto_number"];
		$labtemplate = $res1["labtemplate"];
		$pharmtemplate = $res1["pharmtemplate"];
		$radtemplate = $res1["radtemplate"];
		$sertemplate = $res1["sertemplate"];
		$ippactemplate = $res1["ippactemplate"];
		$bedtemp=$res1["bedtemplate"];
		if($bedtemp==''){ 
		//$bedtemp='master_bed';
		}
		if($labtemplate==''){
			//$labtemplate='master_lab';
		}
		if($radtemplate==''){
			//$radtemplate='master_radiology';
		}
		if($sertemplate==''){
			//$sertemplate='master_services';
		}
		if($ippactemplate==''){
			//$ippactemplate='master_ippackage';
		}
		$query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$maintype = $res2['paymenttype'];
	
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
					    <a href="addsubtype1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteSubType('<?php echo $subtype;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maintype; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subtype; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $labtemplate; ?> </td>
						<td align="left" valign="top"  class="bodytext3">
							<?php 
							    //get phram template name
								$query1000 = "select templatename from pharma_rate_template where auto_number='$pharmtemplate'";
								$exec1000 = mysqli_query($GLOBALS["___mysqli_ston"], $query1000) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($res1000 = mysqli_fetch_array($exec1000))
								{
								    echo  $res1000["templatename"];
								}
							 ?> 
						</td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $radtemplate; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $sertemplate; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $ippactemplate; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $bedtemp; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editsubtype1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>
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
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Deleted Provider Templates </strong></td>
                        <td bgcolor="#ecf0f5" class="bodytext3"><strong>Providers </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_subtype where recordstatus = 'deleted' order by maintype ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$maintypeanum = $res1['maintype'];
		$subtype = $res1["subtype"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		
		$query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$maintype = $res2['paymenttype'];
	
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
						<a href="addsubtype1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $maintype; ?></td>
                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $subtype; ?></td>
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

