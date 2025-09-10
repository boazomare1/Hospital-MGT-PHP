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
    $subtypeanum = $_REQUEST['subtypeanum'];
	//echo $subtypeanum;
	$maintype = $_REQUEST["maintype"];
	$subtype = $_REQUEST["subtype"];
	//this is for currency and fxrate
	$currency = $_REQUEST["currency"];
	$fxrate = $_REQUEST["fxrate"];
	
	$subtype = strtoupper($subtype);
	$subtype = trim($subtype);
	$length=strlen($subtype);
	$bedcharge1=$_REQUEST["bedcharge"];
	
	$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable='$bedcharge1' order by templatename";
	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res10 = mysqli_fetch_array($exec10);
	$bedcharge1 = $res10["templatename"];
	
	$labtemplate = $_REQUEST["labtemplate"];
	$pharmtemplate = $_REQUEST["pharmtemplate"];
	$radtemplate = $_REQUEST["radtemplate"];
	$sertemplate = $_REQUEST["sertemplate"];
	$ippactemplate = $_REQUEST["ippactemplate"];
	$is_savannah = isset($_REQUEST['is_savannah']) ? $_REQUEST['is_savannah'] : '';
	$slade_payer_code = $_REQUEST["slade_payer_code"];
	
	$approvalrequired = isset($_REQUEST['approvalrequired']) ? $_REQUEST['approvalrequired'] : '';
	$preauthrequired = isset($_REQUEST['preauthrequired']) ? $_REQUEST['preauthrequired'] : '';
	$loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';
	$get_loc='';
	$excluded_loc='';
	for($i=1; $i<=$loccountloop; $i++)
		{
		 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
		if($get_loc=='')
		{
			$get_loc="'".$loccodeget."'";
		}
		else
		{ 
		    if($loccodeget!='')
			{
			$get_loc=$get_loc.','."'".$loccodeget."'";
			}
		}
	
		}
		//echo $get_loc;
		if($get_loc!='')
		{
		 $query101 = "select locationcode from master_location where locationcode Not IN ($get_loc) and status=''";
		$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101) or die ("Error in Query101".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res101 = mysqli_fetch_array($exec101))
		{
		$locationcode2 = $res101["locationcode"];
		if($excluded_loc=='')
		{
			$excluded_loc=$locationcode2;
		}
		else
		{
			$excluded_loc=$excluded_loc.','.$locationcode2;
		}
		}
		//echo $excluded_loc;
		}

	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_subtype where auto_number = '$subtypeanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
		$query201 = "INSERT INTO audit_master_subtype (subtypeid,maintype, subtype, ipaddress, recorddate, username,labtemplate,radtemplate,sertemplate,ippactemplate,bedtemplate,currency,fxrate,is_savannah,approvalrequired,pharmtemplate,slade_payer_code,preauthrequired) SELECT auto_number,maintype, subtype, ipaddress, recorddate, username,labtemplate,radtemplate,sertemplate,ippactemplate,bedtemplate,currency,fxrate,is_savannah,approvalrequired,pharmtemplate,slade_payer_code,preauthrequired FROM master_subtype where auto_number = '$subtypeanum'";
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201);

	    $query1 = "update master_subtype set maintype = '$maintype',subtype = '$subtype',currency='".$currency."',fxrate='".$fxrate."',labtemplate='$labtemplate',pharmtemplate='$pharmtemplate',radtemplate='$radtemplate',sertemplate='$sertemplate',ippactemplate='$ippactemplate', bedtemplate='$bedcharge1' ,is_savannah='$is_savannah'  , approvalrequired='$approvalrequired',slade_payer_code='$slade_payer_code',preauthrequired='$preauthrequired',username='$username',ipaddress='$ipaddress',recorddate='$updatedatetime',exclude_location='$excluded_loc'   where auto_number = '$subtypeanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Sub Type Updated.";
		//$bgcolorcode = 'success';
		
		if($exec1){
				$lastid = $subtypeanum;
				$columnname = "subtype_".$lastid ;
						
						$sqlresult=mysqli_query($GLOBALS["___mysqli_ston"], 'SELECT DATABASE()');
						$row=mysqli_fetch_row($sqlresult);
						$active_db=$row[0];
						//echo "Active Database :<b> $active_db</b> ";
							
						//$query = "SHOW COLUMNS FROM `master_medicine` WHERE FIELD LIKE 'subtype_%'";
						$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = '$columnname' AND TABLE_SCHEMA = '".$active_db."' AND TABLE_NAME = 'master_medicine'";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$numeows = mysqli_num_rows($exec);
			if($numeows =='0'){
				$altersql = "ALTER TABLE master_medicine ADD `$columnname` decimal(13,2) NOT NULL ";
				mysqli_query($GLOBALS["___mysqli_ston"], $altersql) or die ("Error in AlterSql".mysqli_error($GLOBALS["___mysqli_ston"]));			
			}
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
		
		$query14 = "update master_accountname set currency='".$currency."',fxrate='".$fxrate."' where subtype = '".$subtypeanum."'";
		$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header ("location:addsubtype1.php?bgcolorcode=success&&st=edit&&anum=$subtypeanum");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Sub Type Already Exists.";
		//$bgcolorcode = 'failed';
	header ("location:addsubtype1.php?bgcolorcode=failed&&st=edit&&anum=$subtypeanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:addsubtype1.php?bgcolorcode=failed&&st=edit&&anum=$subtypeanum");
	}

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

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_subtype where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
    $res1maintype = $res1['maintype'];
    $res1subtype = $res1['subtype'];
		$res1labtemplate = $res1["labtemplate"];
		$res1pharmtemplate = $res1["pharmtemplate"];
	$res1radtemplate = $res1["radtemplate"];
	$res1sertemplate = $res1["sertemplate"];
	$res1ippactemplate = $res1["ippactemplate"];
	$bedcharge=$res1["bedtemplate"];
	
		$approvalrequired=$res1["approvalrequired"];
		
		$preauthrequired=$res1["preauthrequired"];

			$is_savannah=$res1["is_savannah"];
			
			$slade_payer_code=$res1["slade_payer_code"];

	$currency = $res1["currency"];
	$fxrate = $res1["fxrate"];
	 $exclude_location_main= $res1["exclude_location"];
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Sub Type Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Visit Sub Already Exists.";
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

//window.onload = function(){ document.getElementById("loading").style.display = "none" }
</script>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
document.onreadystatechange = () => {
  if (document.readyState === 'complete') {
    // document ready
    //console.log("document loaded success");
    document.getElementById("loading").style.display = "none"
  }
};
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
              <td><form name="form1" id="form1" method="post" action="editsubtype1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
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
                          <?php
						
						if ($res1maintype == '')
						{
						echo '<option value="" selected="selected">Select Payment Type</option>';
						}
						else
						{
						$query4 = "select * from master_paymenttype where auto_number = '$res1maintype'";
						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res4 = mysqli_fetch_array($exec4);
						$res4dmaintypeanum = $res4['auto_number'];
						$res4maintypename = $res4['paymenttype'];
					
						echo '<option value="'.$res4dmaintypeanum.'" selected="selected">'.$res4maintypename.'</option>';
						}
					
						$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res5 = mysqli_fetch_array($exec5))
						{
						$res5anum = $res5["auto_number"];
						$res5maintype = $res5["paymenttype"];
						
						
						?>
						<option value="<?php echo $res5anum; ?>"><?php echo $res5maintype; ?></option>
						<?php
						}
						?>
                        </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="subtype" id="subtype"  value="<?php echo $res1subtype;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Currency</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="currency" id="currency" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" value="<?php echo $currency?>"  /></td>
                      </tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fxrate </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fxrate" id="fxrate" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" value="<?php echo $fxrate?>" /></td>
                      </tr>
                      
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Lab Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="labtemplate" id="labtemplate"  style="border: 1px solid #001E6A;">
						<!--<option value="" selected="selected">Select Lab</option> -->
						<option value="master_lab" >master_lab</option>						
                          <?php
							$query10 = "select * from master_testtemplate where testname = 'lab' order by templatename";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res10 = mysqli_fetch_array($exec10))
							{
							
							$templatename = $res10["templatename"];
							?>
			                          <option value="<?php echo $templatename; ?>"  <?php if($res1labtemplate==$templatename){ echo "selected";} ?>><?php echo $templatename; ?></option>
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
			                          <option value="<?php echo $templateid; ?>" <?php if($res1pharmtemplate==$templateid){ echo "selected";} ?>><?php echo $templatename; ?></option>
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
					<!--	<option value="" selected="selected">Select Radiology</option> -->
						<option value="master_radiology" >master_radiology</option>	
                          <?php
				$query11 = "select * from master_testtemplate where testname = 'radiology' order by templatename";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res11 = mysqli_fetch_array($exec11))
				{
				
				$templatename = $res11["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($res1radtemplate==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
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
						<!-- <option value="" selected="selected">Select Services</option> -->
						<option value="master_services" >master_services</option>	
                          <?php
				$query12 = "select * from master_testtemplate where testname = 'services' order by templatename";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res12 = mysqli_fetch_array($exec12))
				{
				
				$templatename = $res12["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($res1sertemplate==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
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
						<!-- <option value="" selected="selected">Select Template</option> -->
						<option value="master_ippackage" >master_ippackage</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'ippackage' order by templatename";
				$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res13 = mysqli_fetch_array($exec13))
				{
				
				$templatename = $res13["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($res1ippactemplate==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        <select name="bedcharge" id="bedcharge"  style="border: 1px solid #001E6A;">
						<!-- <option value="" selected="selected">Select Template</option> -->
						<option value="master_bed" >master_bed</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!=''  order by templatename";
				$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res13 = mysqli_fetch_array($exec13))
				{
				$referencetable = $res13['referencetable'];
				$templatename = $res13["templatename"];
				?>
                          <option value="<?php echo $referencetable; ?>" <?php if($bedcharge==$templatename){ echo "selected";} ?> ><?php echo $referencetable; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  
					     <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Approval Required</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="approvalrequired" value="1"  <?php if($approvalrequired == '1'){ echo "checked"; } ?>>
                          </label></td>
                          
                        </tr>
						  <!-- <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Is Savannah</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="is_savannah" value="1"   <?php if($is_savannah == '1'){ echo "checked"; } ?>>
                          </label></td>
                          
                        </tr>-->
						
						  <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Pre-Auth Required</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="preauthrequired" value="1"  <?php if($preauthrequired == '1'){ echo "checked"; } ?>>
                          </label></td>
                          
						  
						  
                        </tr>
						
						<tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Slade_payer_code</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="text" name="slade_payer_code" id="slade_payer_code" value="<?php echo $slade_payer_code ;?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40">
                          </label></td>
                        </tr>
		
                   

<?php
$traits = explode( ',' , $exclude_location_main );
//print_r($traits);
$incr=0;


$query = "select locationname,locationcode from master_location where status = ''";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res = mysqli_fetch_array($exec))
{
$check_checkbox='checked';
$locationname1  = $res["locationname"];
$locationcode1  = $res["locationcode"];
$incr=$incr+1;

foreach($traits as $val)
{

if($locationcode1==$val)
{
	$check_checkbox='';
}
} 
						?>
						
						
						
      <tr>
	   <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
	   <input type="checkbox" name="lcheck<?php echo $incr;?>" id="lcheck<?php echo $incr;?>" style="float:left" value="<?php echo $locationcode1;?>"  <?php echo $check_checkbox;?> ><input type="hidden" name="checklocval" value="<?php echo $locationcode1;?>">
	  <span style="width:100px;float:left;line-height:20px"><?php echo $locationname1;?></span>
	  </td>
        <td width="10px" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" >
		
       </td>
	  </tr> 
      <?php } ?><input type="hidden" name="locationcount" id="locationcount" value="<?php echo  $incr;?>">
      
         <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="hidden" name="subtypeanum" id="subtypeanum" value="<?php echo $res1autonumber; ?>">
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
      
      
      
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

