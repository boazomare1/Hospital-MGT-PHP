<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

//to redirect if there is no entry in masters category or item.
$loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';

/*$query90 = "select count(auto_number) as masterscount from master_services";
$exec90 = mysql_query($query90) or die ("Error in Query90".mysql_error());
$res90 = mysql_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1services.php?svccount=firstentry");
}
*/

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
	$code = $_REQUEST['itemcode'];
	$sertemplate = $_REQUEST['servicetable'];
	$query78 = "delete from $sertemplate where itemcode='$code'";
	$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	for($i=1; $i<=$loccountloop; $i++)
{
	 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
	 $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';
	 
	 if($loccodeget!='')
	 {

	$itemcode = $_REQUEST["itemcode"];
	$itemcode = strtoupper($itemcode);
	$itemcode = trim($itemcode);
	$itemname = $_REQUEST["itemname"];
	//$itemname = strtoupper($itemname);
	$itemname = trim($itemname);
	//echo "simple";
	$length1=strlen($itemcode);
	$length2=strlen($itemname);
	//! ^ + = [ ] ; , { } | \ < > ? ~
	//if (preg_match ('/[+,|,=,{,},(,)]/', $itemname))
	if (preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname))
	{  
		//echo "inside if";
		$bgcolorcode = 'fail';
		$errmsg="Sorry. services Item Not Added";
		
		header("location:servicename1template.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	
	$categoryname = $_REQUEST["categoryname"];
	//$purchaseprice  = $_REQUEST["purchaseprice"];
	//$rateperunit  = $_REQUEST["rateperunit"];
	//$rate2 = $_REQUEST['rate2'];
	//$rate3 = $_REQUEST['rate3'];
	//$location = $_REQUEST["location"];
	$ipmarkup = $_REQUEST["ipmarkup"];
	//get base values
	 $baseunit = isset($_REQUEST["baseunit"])?$_REQUEST["baseunit"]:'';
	 $slab = isset($_REQUEST["slab"])?$_REQUEST["slab"]:'';
	 $pkg = isset($_REQUEST["pkg"])?$_REQUEST["pkg"]:'no';
	
	 $incrementalqty = $_REQUEST["incrementalqty"];
	 $incrementalrate = $_REQUEST["incrementalrate"];
	 if($slab=='')
	{$baseunit=1;
	$incrementalqty='';
	$incrementalrate='';
	}
	//get base ends here
	
	$expiryperiod = '';
	$description='';
	$referencevalue ='';
	$res4taxname = '';
	//$itemname_abbreviation = $_REQUEST["itemname_abbreviation"];
	//$taxanum = $_REQUEST['taxanum'];
	if ($length1<25 && $length2<255)
	{
		
		
			$query1 = "insert into $sertemplate set itemname='$itemname', categoryname='$categoryname', rateperunit='".$locrateget."', expiryperiod='$expiryperiod', ipaddress='$ipaddress', updatetime='$updatedatetime', description='', ipmarkup='$ipmarkup',itemcode = '$itemcode',locationcode='".$loccodeget."',baseunit='".$baseunit."',incrementalquantity='".$incrementalqty."',incrementalrate='".$incrementalrate."',slab='".$slab."', pkg='$pkg' ";
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/
	
			$errmsg = "Success. New services Item Updated.";
			$bgcolorcode = 'success';
			$itemcode = '';
			$itemname = '';
			$rateperunit  = '0.00';
			$purchaseprice  = '0.00';
			$description = '';
			$referencevalue = '';

			//$itemcode = '';
			header("location:servicename1template.php");

		
	}
	else
	{
		$errmsg = "Failed. services Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
	 }}

}
else
{
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	}
	
	//$itemcode = '';
	if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
	if (isset($_REQUEST["sertemplate"])) { $sertemplate = $_REQUEST["sertemplate"]; } else { $sertemplate = ""; }
		
	$query67 = "select * from $sertemplate where itemcode='$itemcode'";
	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res67 = mysqli_fetch_array($exec67);
	$itemname = $res67['itemname'];
	$rate1 = $res67['rateperunit'];
	$rate2 = $res67['rate2'];
	$rate3 = $res67['rate3'];
	$ipmarkup = $res67['ipmarkup'];
	$location = $res67['location'];
	$incrementalrate = $res67['incrementalrate'];
	$incrementalquantity = $res67['incrementalquantity'];
	$baseunit = $res67['baseunit'];

    $unit = $res67['itemname_abbreviation'];
	$categoryname = $res67['categoryname'];
	$taxanum = $res67['taxanum'];
	
	$taxname= $res67['taxname'];
	$slab= $res67['slab'];
	$pkg1= $res67['pkg'];


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $sertemplate set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $sertemplate set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add services Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }






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
<link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter services Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if (document.form1.itemcode.value != "")
	{	
		var data = document.form1.itemcode.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 
		for (var i = 0; i < data.length; i++) 
		{
			if (iChars.indexOf(data.charAt(i)) != -1) 
			{
				//alert ("Your services Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your services Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter services Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	/*
	if (document.form1.itemname_abbreviation.value == "")
	{
		alert ("Pleae Select Unit Name.");
		document.form1.itemname_abbreviation.focus();
		return false;
	}
	*/
	/*if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm('Rate Per Unit Is 0.00, Are You Sure You Want To Continue To Save?'); 
		//alert(fRet);  // true = ok , false = cancel
		if (fRet == false)
		{
			return false;
		}*/
/*		else if (document.form1.itemname_abbreviation.value == "SR")
		{
			if (document.form1.expiryperiod.value == "")
			{	
				alert ("Please Select Expiry Period.");
				document.form1.expiryperiod.focus();
				return false;
			}
		}
*/	/*}*/
/*	else if (document.form1.itemname_abbreviation.value == "SR")
	{
		if (document.form1.expiryperiod.value == "")
		{	
			alert ("Please Select Expiry Period.");
			document.form1.expiryperiod.focus();
			return false;
		}
	}
*/
if(document.form1.slab.checked==true)
	{
	if (document.form1.baseunit.value == "")
	{	
		alert ("Please Enter Base Unit.");
		document.form1.baseunit.focus();
		return false;
	}
	if (isNaN(document.form1.baseunit.value) == true)
	{	
		alert ("Please Enter Numbers Only.");
		document.form1.baseunit.focus();
		return false;
	}
	if (document.form1.incrementalqty.value == "")
	{	
		alert ("Please Enter Incremental Quantity.");
		document.form1.incrementalqty.focus();
		return false;
	}
	if (isNaN(document.form1.incrementalqty.value) == true)
	{	
		alert ("Please Enter Numbers Only.");
		document.form1.incrementalqty.focus();
		return false;
	}
	if (document.form1.incrementalrate.value == "")
	{	
		alert ("Please Enter Incremental Rate.");
		document.form1.incrementalrate.focus();
		return false;
	}
	
	if (isNaN(document.form1.incrementalrate.value) == true)
	{	
		alert ("Please Enter Numbers Only.");
		document.form1.incrementalrate.focus();
		return false;
	}
	}
	
var ifcount=0;
	var lcheck='lcheck';
	//var lcheckk='lcheck3';
	//alert(document.form1.lcheck.value);
	var lcount=document.form1.locationcount.value;
	
	if(lcount!=0)
	{
		for(var i=1; i<=lcount; i++)
		{
			if(document.form1.elements["lcheck"+i].checked == true)
			{ ifcount=ifcount+1;}
			/*var lname=lcheck+i;
			alert(lname);
			alert(document.form1.elements[lname].value);*/
			//alert(document.getElementById("icheck"+i).value);
		}
		if(ifcount==0)
		{
			alert('Please select atleast one Location');
			return false;
		}
	}
}

/*
function process1()
{
	//alert (document.form1.itemname.value);
	if (document.form1.itemname_abbreviation.value == "SR")
	{
		document.getElementById('expiryperiod').style.visibility = '';
	}
	else
	{
		document.getElementById('expiryperiod').style.visibility = 'hidden';
	}
}
*/
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your services Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}
 
 
function process2()
{
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}

function process1backkeypress1()
{
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

</script>
<body onLoad="return process2()">
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
              <td><form name="form1" id="form1" method="post" action="edititem1servicesmaster.php" onSubmit="return additem1process1()">
                  <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Item Master - Add New </strong></td>
                      </tr>
					  <?php if ($st==1)
					  {?>
					  <tr>
                        <td colspan="4" align="left" valign="middle"   bgcolor="#AAFF00"><font size="2">Sorry Special Characters Are Not Allowed</font></div></td>
                      </tr>
					  <?php }?>
                      <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }else if ($bgcolorcode == 'fail') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?>&nbsp;</div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Category Name  </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="categoryname" name="categoryname" >
                          <?php
						if ($categoryname != '')
						{
						?>
                          <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Category</option>
                          <?php
						}
						$query1 = "select * from master_categoryservices where status <> 'deleted' order by categoryname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1categoryname = $res1["categoryname"];
						?>
                          <option value="<?php echo $res1categoryname; ?>"><?php echo $res1categoryname; ?></option>
                          <?php
						}
						?>
                        </select>
                          <a href="addcategory1services.php"><font  class="bodytext32" color="#000000">(Click Here To Add New Category)</font></a></td>
                      <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Exclude</span></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="exclude"></td>
                          </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <div align="left">New Services Item Code </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20" maxlength="100" />
                          <span class="bodytext32">( Example : PRD1234567890 ) </span>
                          
                          <input type="hidden" name="servicetable" value="<?php echo $sertemplate;?>">
                          </td>
                     <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">IP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A; " value="<?php echo $ipmarkup; ?>"></td>
                     </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Add New Services Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="<?php echo $itemname; ?>" size="60"></td>
                         <?php /*?><!--<td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Location</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="location" style="border: 1px solid #001E6A" value="<?php echo $location; ?>"></td>--><?php */?>
                 </tr>
                 		 <tr>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Slab</div></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="slab" value="1" <?php if($slab=='1'){echo "checked";}?>></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					  </tr>
                       <tr>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Base Unit</div></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="baseunit" value="<?php echo $baseunit;?>" style="border: 1px solid #001E6A"></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					  </tr>
                      <tr>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Incremental Quantity</div></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="incrementalqty"  value="<?php echo $incrementalquantity;?>" style="border: 1px solid #001E6A"></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					  </tr>
                      <tr>
					  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Incremental Rate</div></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="incrementalrate"  value="<?php echo $incrementalrate;?>" style="border: 1px solid #001E6A"></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					  </tr>
                       <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Package</div></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="pkg"  value="yes" <?php if($pkg1=='yes'){ echo "checked='checked'"; } ?>></td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					   <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
					  </tr>
                      <?php /*?><!--<tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Charge  Price  Per Unit </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rateperunit" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rate1; ?>" size="20" />
                        <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" /></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                      </tr>--><?php */?>
                    <?php /*?><!--  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">services Item Reference Value (Optional) </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><textarea  name="referencevalue" cols="60" id="referencevalue" style="border: 1px solid #001E6A"><?php echo $referencevalue; ?></textarea>
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                      </tr>--><?php */?>
                     <?php /*?><!--<tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="taxanum" name="taxanum">
                            <option value="" selected="selected">Select Tax</option>
                    <?php
						if ($taxname != '')
						{
						?>
                    <option value="<?php echo $taxname; ?>" selected="selected"><?php echo $taxname; ?></option>
                    <?php
						}
						else
						{
						?>
                    <option value="" selected="selected">Select Tax</option>
                    <?php
						}
						$query2 = "select * from master_tax where status <> 'deleted' group by taxname order by taxname";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						while ($res2 = mysql_fetch_array($exec2))
						{
						$res1taxname = $res2["taxname"];
						
						?>
                    <option value="<?php echo $res1taxname; ?>"><?php echo $res1taxname; ?></option>
                    <?php
						}
						?>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Rate2 </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rate2" id="rate2" style="border: 1px solid #001E6A" value="<?php echo $rate2; ?>" size="20" />                          </td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                      </tr>
				   <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Rate3 </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rate3" id="rate3" style="border: 1px solid #001E6A" value="<?php echo $rate3; ?>" size="20" />                          </td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                      </tr>--><?php */?>
				  
					  <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
        <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location Rate</strong></td>
	  </tr> 
      <?php $query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$incr=0;
						while ($res1 = mysqli_fetch_array($exec1))
						{
						 $locationcode = $res1["locationcode"];
						$locationname = $res1["locationname"];
						//$res1anum = $res1["auto_number"];
						 $incr=$incr+1;
						 $query13 = "select * from $sertemplate where itemcode='$itemcode' and locationcode = '$locationcode'";
					$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res13 = mysqli_fetch_array($exec13);
					$itemname = $res13['itemname'];
					$rate13 = $res13['rateperunit'];
						?>
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
        <td width="10px" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" ><input type="checkbox" name="lcheck<?php echo $incr;?>" id="lcheck<?php echo $incr;?>" style="float:left" value="<?php echo $locationcode;?>" <?php if($rate13 != '') { ?> checked="checked" <?php } ?>><input type="hidden" name="checklocval" value=<?php echo $locationcode;?>"">
        &nbsp;<span style="width:100px;float:left;line-height:20px"><?php echo $locationname;?></span>&nbsp;<input type="text" name="locrate<?php echo $incr;?>" style="width:90px;" value="<?php echo $rate13;?>"></td>
	  </tr> 
      <?php }?><input type="hidden" name="locationcount" value="<?php echo  $incr;?>">
                      <tr>
                        <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                        <td width="45%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="16%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="19%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Save Services Item" style="border: 1px solid #001E6A" />                        </td>
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

