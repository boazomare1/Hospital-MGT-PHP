<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$exclude = '';
//to redirect if there is no entry in masters category or item.
$pkg=isset($_REQUEST['pkg'])?$_REQUEST['pkg']:'no';


if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$itemcode = $_REQUEST["itemcode"];
	$itemcode = strtoupper($itemcode);
	$itemcode = trim($itemcode);
	$itemname = $_REQUEST["itemname"];
	$genericname = $_REQUEST['genericname'];
	$disease = $_REQUEST['disease'];
	$formula = $_REQUEST['formula'];
	$type = $_REQUEST['type'];
	
	$ledgername = $_REQUEST['saccountname'];
	$ledgerautonumber = $_REQUEST['saccountauto'];
	$ledgercode = $_REQUEST['saccountid'];
	
	$incomeledgername = $_REQUEST['iaccountname'];
	$incomeledgerautonumber = $_REQUEST['iaccountauto'];
	$incomeledgercode = $_REQUEST['iaccountid'];	
	
	$inventoryledgername = $_REQUEST['inv_accountname'];
	$inventoryledgerautonumber = $_REQUEST['inv_accountauto'];
	$inventoryledgercode = $_REQUEST['inv_accountid'];
	
	
	//echo $formula;
	$minimumstock = $_REQUEST['minimumstock'];
	$maximumstock = $_REQUEST['maximumstock'];
	//$manufacturername = $_REQUEST['manufactureranum'];
	$rol = $_REQUEST['rol'];
	$roq = $_REQUEST['roq'];
	$ipmarkup = $_REQUEST['ipmarkup'];
	$spmarkup = $_REQUEST['spmarkup'];
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
		$errmsg="Sorry. pharmacy Item Not Added";
		
		header("location:pharmacyitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	
	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["costprice"];
	$rateperunit  = $_REQUEST["rateperunit2"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$itemname_abbreviation = $_REQUEST['packageanum'];
	$taxanum = $_REQUEST["taxanum"];
	$transfertype = $_REQUEST["transfertype"];
	if ($length1<25 && $length2<255)
	{
	$query4 = "select * from master_tax where auto_number = '$taxanum'";// and cstid='$custid' and cstname='$custname'";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res4 = mysqli_fetch_array($exec4);
		$res4taxname = $res4["taxname"];

		$query44 = "select * from master_packagepharmacy where auto_number = '$itemname_abbreviation'";// and cstid='$custid' and cstname='$custname'";
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res44 = mysqli_fetch_array($exec44);
		$res4packagename = $res44["packagename"];
		
		/*$query54 = "select * from master_manufacturerpharmacy where auto_number = '$manufacturername'";// and cstid='$custid' and cstname='$custname'";
		$exec54 = mysql_query($query54) or die ("Error in Query4".mysql_error());
		$res54 = mysql_fetch_array($exec54);
		$res4manufacturername = $res54["manufacturername"];*/

		
		$query2 = "select * from master_medicine where itemcode = '$itemcode'";// or itemname = '$itemname'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_num_rows($exec2);
		if ($res2 == 0)
		{
			$query1 = "insert into master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,ledgername,ledgercode,ledgerautonumber,transfertype,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername) 
			values ('$itemcode', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$ledgername','$ledgercode','$ledgerautonumber','$transfertype','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	        $query2 = "insert into master_itempharmacy (itemcode, itemname, categoryname, unitname_abbreviation, packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, pkg, genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,ledgername,ledgercode,ledgerautonumber,transfertype,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername) 
			values ('$itemcode', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$ledgername','$ledgercode','$ledgerautonumber','$transfertype','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/
	
			$errmsg = "Success. New pharmacy Item Updated.";
			$bgcolorcode = 'success';
			$itemcode = '';
			$itemname = '';
			
			$rateperunit  = '0.00';
			$purchaseprice  = '0.00';
			$description = '';
			$referencevalue = '';

			//$itemcode = '';
			$query1 = "select * from master_medicine order by auto_number desc limit 0, 1";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount1 = mysqli_num_rows($exec1);
			if ($rowcount1 == 0)
			{
				$itemcode = 'PRDA001';
			}
			else
			{
				$res1 = mysqli_fetch_array($exec1);
				$res1itemcode = $res1['auto_number'];
				//$res1itemcode = substr($res1itemcode, 2, 8);
				$res1itemcode = intval($res1itemcode);
				$res1itemcode = $res1itemcode + 1;
			
				$res1itemcode = $res1itemcode;
				if (strlen($res1itemcode) == 2)
				{
					$res1itemcode = '0'.$res1itemcode;
				}
				if (strlen($res1itemcode) == 1)
				{
					$res1itemcode = '00'.$res1itemcode;
				}
				$itemcode = 'PRDA'.$res1itemcode;
			
			}

		}
		else
		{
			$errmsg = "Failed. pharmacy Item Code Already Exists.";
			$bgcolorcode = 'failed';
		}
	}
	else
	{
		$errmsg = "Failed. pharmacy Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
	

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
	 $query1 = "select * from master_medicine order by auto_number desc limit 0,1";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $rowcount1 = mysqli_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		$itemcode = 'PRDA001';
	}
	else
	{
		$res1 = mysqli_fetch_array($exec1);
		 $res1itemcode = $res1['auto_number'];
		//$res1itemcode = substr($res1itemcode, 3, 7);
		$res1itemcode = intval($res1itemcode);
		$res1itemcode = $res1itemcode + 1;
	
		/*
		$maxanum = $res1itemcode;
		if (strlen($maxanum) == 1)
		{
			$maxanum1 = '0000000'.$maxanum;
		}
		else if (strlen($maxanum) == 2)
		{
			$maxanum1 = '000000'.$maxanum;
		}
		else if (strlen($maxanum) == 3)
		{
			$maxanum1 = '00000'.$maxanum;
		}
		else if (strlen($maxanum) == 4)
		{
			$maxanum1 = '0000'.$maxanum;
		}
		else if (strlen($maxanum) == 5)
		{
			$maxanum1 = '000'.$maxanum;
		}
		else if (strlen($maxanum) == 6)
		{
			$maxanum1 = '00'.$maxanum;
		}
		else if (strlen($maxanum) == 7)
		{
			$maxanum1 = '0'.$maxanum;
		}
		else if (strlen($maxanum) == 8)
		{
			$maxanum1 = $maxanum;
		}
		*/
		
		
		if (strlen($res1itemcode) == 2)
		{
			$res1itemcode = '0'.$res1itemcode;
		}
		if (strlen($res1itemcode) == 1)
		{
			$res1itemcode = '00'.$res1itemcode;
		}
		$itemcode = 'PRDA'.$res1itemcode;
	
		//echo $employeecode;
	}
		
	


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query3 = "update master_itempharmacy set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query3 = "update master_itempharmacy set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add pharmacy Item To Proceed For Billing.";
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
.pagination{float:right;}
-->

.ui-menu .ui-menu-item{ zoom:1.3 !important; }
</style>
</head>
<script language="javascript">
//fixed option
function fixed2(){
	var formula = document.getElementById("formula");
	var packageanum = document.getElementById("packageanum");
	if(formula.value=='FIXED'){
		packageanum.value = '14';
		packageanum.onchange = function(){if(packageanum.value !='14' && formula.value=='FIXED'){
		alert("For Fixed formula, package value is 1.");
		packageanum.value = '14';
		}};
	}else{
	packageanum.selectedIndex = '0';
	}	
}

function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter pharmacy Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if(document.form1.inv_accountid.value == "")
	{
		alert ("Please select Inventory ledger");
		document.form1.inv_accountname.focus();
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
				//alert ("Your radiology Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your pharmacy Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter pharmacy Item Name.");
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
	if (document.form1.purchaseprice.value == "")
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
	if (document.form1.taxanum.value == "")
	{	
		alert ("Please Select Applicable Tax.");
		document.form1.taxanum.focus();
		return false;
	}
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.type.value == "")
	{	
		alert ("Please Select Type.");
		document.form1.type.focus();
		return false;
	}
	
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm(' Are You Sure You Want To Continue To Save?'); 
		//alert(fRet);  // true = ok , false = cancel
		if (fRet == false)
		{
			return false;
		}
/*		else if (document.form1.itemname_abbreviation.value == "SR")
		{
			if (document.form1.expiryperiod.value == "")
			{	
				alert ("Please Select Expiry Period.");
				document.form1.expiryperiod.focus();
				return false;
			}
		}
*/	}

	
	
/*	else if (document.form1.itemname_abbreviation.value == "SR")
	{
		if (document.form1.expiryperiod.value == "")
		{	
			alert ("Please Select Expiry Period.");
			document.form1.expiryperiod.focus();
			return false;
		}
	}
*/}

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
			alert ("Your pharmacy Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
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


<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
  <script>

$(function() {

    $('#saccountname').autocomplete({
		
	source:'accountnameajax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#saccountauto').val(saccountauto);	
				$('#saccountid').val(saccountid);	
			}
    });
	
	$('#iaccountname').autocomplete({
		
	source:'accountnameajax1.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#iaccountauto').val(saccountauto);	
				$('#iaccountid').val(saccountid);	
			}
    });
	$('#inv_accountname').autocomplete({
		
	source:'accountnameajax2.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#inv_accountauto').val(saccountauto);	
				$('#inv_accountid').val(saccountid);	
			}
    });
});
</script>

<body onLoad="return process2()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="pharmacyitem21.php" onSubmit="return additem1process1()">
                  <table width="1072" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item Master - Add New </strong></td>
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
						$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
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
                          <a href="pharmacycategory1.php"><font  class="bodytext32" color="#000000">(Click Here To Add New Category)</font></a></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Generic Name</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><a href="pharmacycategory1.php"></a><select id="genericname" name="genericname">
						<option value="" selected="selected">Select Generic Name</option>
						<?php
						$query111 = "select * from master_genericname where recordstatus = '' ";
						$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res111 = mysqli_fetch_array($exec111))
						{
						$res111genericname = $res111['genericname'];
						?>
                          <option value="<?php echo $res111genericname; ?>"><?php echo $res111genericname; ?></option>
						  <?php
						  }
						  ?>
                        </select></td>
					    </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> <div align="left">New Pharmacy Item Code </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemcode" readonly value="<?php echo $itemcode; ?>" id="itemcode" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#ecf0f5" size="20" maxlength="100" />
                          <span class="bodytext32">( Example : PRDA1234567890 ) </span></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Exclude</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="exclude"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Add New Pharmacy Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="<?php echo $itemname; ?>" size="60"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Min Stock</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="minimumstock" id="minimumstock" style="border: 1px solid #001E6A"></td>
                      </tr>
                   
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Charge  Price  Per Unit </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input name="rateperunit2" id="rateperunit2" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />
                         </td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Max Stock</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="maximumstock" id="maximumstock" style="border: 1px solid #001E6A"></td>
                      </tr>
                    <!--  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">radiology Item Reference Value (Optional) </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><textarea name="referencevalue" cols="60" id="referencevalue" style="border: 1px solid #001E6A"><?php echo $referencevalue; ?></textarea>
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                      </tr>-->
                      <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">
						<select id="taxanum" name="taxanum">
                            <option value="">Select Tax</option>-->
                          <?php /*?>  <?php
						$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
						$res1anum = $res1["auto_number"];
						?>
                            <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                            <?php
						}
						?><?php */?>
                        </select>										  
<!--                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">radiology Item Period </div></td>
                        <td valign="top" align="left" >
						<select class="box" id="expiryperiod" 
                  style="BORDER-RIGHT: #001e6a 1px solid; BORDER-TOP: #001e6a 1px solid; BORDER-LEFT: #001e6a 1px solid; BORDER-BOTTOM: #001e6a 1px solid" 
                  name="expiryperiod">
                            <option value="0" selected="selected">No Renewal</option>
							<?php
							for ($i=1;$i<=60;$i++)
							{
							?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> Months</option>
							<?php
							}
							?>
                        </select></td>
                      </tr>
-->					  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Formula</div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="formula" name="formula" onChange="fixed2()">
                          <option value="">Select Formula</option>
                           <option value="CONSTANT">Constant</option>
                           <option value="FIXED">Fixed</option>
						    <option value="INCREMENT">Increment</option>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">ROL</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="rol" style="border: 1px solid #001E6A"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Pharmacy Package </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="packageanum" name="packageanum">
                          <option value="">Select Pack</option>
                          <?php
						$query1 = "select * from master_packagepharmacy where status <> 'deleted' order by packagename";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1anum = $res1['auto_number'];
						$res1packagename = $res1["packagename"];
						$res1packagename = stripslashes($res1packagename);
						$quantityperpackage = $res1["quantityperpackage"];
						$quantityperpackage = round($quantityperpackage);
						?>
                          <option value="<?php echo $res1anum; ?>"><?php echo $res1packagename.' ( '.$quantityperpackage.' ) '; ?></option>
                          <?php
						}
						?>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"><strong>Volume (for CONSTANT item)</strong></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="roq" style="border: 1px solid #001E6A"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select id="taxanum" name="taxanum">
                          <option value="">Select Tax</option>
                          <?php
						$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
						$res1anum = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                          <?php
						}
						?>
                        </select>
                          <input name="rateperunit" type="hidden" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />
                          <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" />
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="50">
                          <input type="hidden" name="unitname_abbreviation" id="unitname_abbreviation" value="NOS"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">IP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Cost Price</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="costprice" id="costprice" style="border: 1px solid #001E6A"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">SP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="spmarkup" id="spmarkup" style="border: 1px solid #001E6A"></td>
                      </tr>
					   <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Disease</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="text" name="disease" id="disease" style="border: 1px solid #001E6A"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">
                        <select name="type" id="type" >
							<option value="" selected="selected">Select Type</option>
							<option value="Assets">Assets</option>
						    <option value="General Purchases">General Purchases</option>
						    <option value="IT Assets">IT Assets</option>
						    <option value="Linen">Linen</option>
						    <option value="Maintenance">Maintenance</option>
                            <option value="Stationery & Printing">Stationery & Printing</option>
                            </select>  
						</td>
                      </tr>
                     
                      <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Package</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><input type="checkbox" name="pkg" value="yes"></td>
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">Income Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                        <input type="text" name="saccountname" id="saccountname" size="30" />
                        <input type="hidden" name="saccountauto" id="saccountauto" />
                        <input type="hidden" name="saccountid" id="saccountid" />
                         </td>
                      </tr>
                      
                      <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">Transfer Type</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"><select name="transfertype" id="transfertype" >
                          <option value="">Select</option>
                          <option value="0">Transfer</option>
                          <option value="1">Consumable</option>
							</select>  </td>
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">COGS Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                        <input type="text" name="iaccountname" id="iaccountname" size="30" />
                        <input type="hidden" name="iaccountauto" id="iaccountauto" />
                        <input type="hidden" name="iaccountid" id="iaccountid" />
                         </td>
                      </tr>
					  <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5"  class="bodytext3">Inventory Ledger</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"> 
                        <input type="text" name="inv_accountname" id="inv_accountname" size="30" value=""  />
                        <input type="hidden" name="inv_accountauto" id="inv_accountauto" value=""  />
                        <input type="hidden" name="inv_accountid" id="inv_accountid" value="" />
                         </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3"></td>
                        <td align="left" valign="top"  bgcolor="#ecf0f5"></td>
                        <td width="13%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="hidden" name="frmflag" value="addnew" />
                          <input type="submit" name="Submit" value="Save Pharmacy Item" style="border: 1px solid #001E6A" /></td>
                      </tr>
                    </tbody>
                  </table>
				  </form>
				  <form>
                <table width="1200" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Pharmacy Item Master - Existing List - Latest 100 pharmacy Items </strong></span></td>
						<td bgcolor="#ecf0f5" colspan="3" class="bodytext3"><span class="bodytext32">
						<?php //error_reporting(0);
						if($searchflag1 != 'searchflag1'){
							$tbl_name="master_medicine";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from $tbl_name where status <> 'deleted' and type in ('Assets','General Purchases','IT Assets','Linen','Maintenance','Stationery & Printing')";
							$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res111 = mysqli_fetch_array($exec111);
							$total_pages = mysqli_num_rows($exec111);
												
							/*$query = "SELECT * FROM $tbl_name";
							$total_pages = mysql_fetch_array(mysql_query($query));
							echo $numrow = mysql_num_rows($total_pages);*/
							
							/* Setup vars for query. */
							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)
							$limit = 50; 								//how many items to show per page
							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
							if($page) 
								$start = ($page - 1) * $limit; 			//first item to display on this page
							else
								$start = 0;								//if no page var is given, set start to 0
							
							/* Setup page vars for display. */
							if ($page == 0) $page = 1;					//if no page var is given, default to 1.
							$prev = $page - 1;							//previous page is page - 1
							$next = $page + 1;							//next page is page + 1
							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;						//last page minus 1
							
							/* 
								Now we apply our rules and draw the pagination object. 
								We're actually saving the code to a variable in case we want to draw it more than once.
							*/
							$pagination = "";
							if($lastpage > 1)
							{	
								$pagination .= "<div class=\"pagination\">";
								//previous button
								if ($page > 1) 
									$pagination.= "<a href=\"$targetpage?page=$prev\" style='color:#3b3b3c;'>previous</a>";
								else
									$pagination.= "<span class=\"disabled\">previous</span>";	
								
								//pages	
								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
								{	
									for ($counter = 1; $counter <= $lastpage; $counter++)
									{
										if ($counter == $page)
											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
										else
											$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
									}
								}
								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
								{
									//close to beginning; only hide later pages
									if($page < 1 + ($adjacents * 2))		
									{
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						?></span>
						</td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="20" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>
                        </tr>
                      <tr bgcolor="#011E6A">
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Delete</strong></div></td>
						  <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
                        <td width="8%" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item</strong></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>                          <div align="center"><strong><!--Purchase--></strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
						<td width="11%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Formula</strong></div></td>
						<td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Tax</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Cost price</strong></div></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Disease</strong></div></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Generic</strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Type</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Min Stock</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Max Stock</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>ROL</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Strength</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>SP Markup</strong></div></td>
                       </tr>
                      <?php
	  if ($searchflag1 == 'searchflag1')
	  {
					  
		$search1 = $_REQUEST["search1"];			  
	    $query1 = "select * from master_medicine where  type in ('Assets','General Purchases','IT Assets','Linen','Maintenance','Stationery & Printing') and ( itemname like '%$search1%' or categoryname = '$search1') and  status <> 'deleted'  order by auto_number desc ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["packagename"];
		$taxname = $res1["taxname"];
		$manufacturername = $res1["manufacturername"];
		$formula = $res1['formula'];
		$genericname = $res1["genericname"];
		$minimumstock = $res1["minimumstock"];
		$maximumstock = $res1["maximumstock"];
		$rol = $res1["rol"];
		$roq = $res1["roq"];
		$type = $res1["type"];
		$ipmarkup = $res1["ipmarkup"];
		$spmarkup = $res1["spmarkup"];
		$disease = $res1["disease"];
		
		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
	 /*?>	
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */
		
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="pharmacyitem21.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><a href="editpharmacyitem21.php?itemcode=<?php echo $itemcode; ?>">Edit</a></td>
					    <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3">    <?php echo $formula; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $taxname; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">  <div align="right">  <?php echo $purchaseprice; ?>    </div>              </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $disease; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">    <?php echo $genericname; ?>                  </td> 
                        <td align="left" valign="top"  class="bodytext3">    <?php echo $type; ?>                  </td>   
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $minimumstock; ?>   </div>               </td>
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $maximumstock; ?>     </div>             </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $rol; ?>  </div>                </td>
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $roq; ?> </div>                </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $ipmarkup; ?>    </div></td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $spmarkup; ?>   </div></td>  </tr>
						<?php
		}
	}
	else
	{
	$query1 = "select * from master_medicine where status <> 'deleted' and type in ('Assets','General Purchases','IT Assets','Linen','Maintenance','Stationery & Printing') order by auto_number desc LIMIT $start, $limit";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["packagename"];
		$taxname = $res1["taxname"];
		$manufacturername = $res1["manufacturername"];
		$formula = $res1['formula'];
		$genericname = $res1["genericname"];
		$minimumstock = $res1["minimumstock"];
		$maximumstock = $res1["maximumstock"];
		$rol = $res1["rol"];
		$roq = $res1["roq"];
		$type = $res1["type"];
		$ipmarkup = $res1["ipmarkup"];
		$spmarkup = $res1["spmarkup"];
		$disease = $res1["disease"];
		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		 /*?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];<?php */
		
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="pharmacyitem21.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                         <td align="left" valign="top"  class="bodytext3"><a href="editpharmacyitem21.php?itemcode=<?php echo $itemcode; ?>">Edit</a></td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
                      <td align="left" valign="top"  class="bodytext3">    <?php echo $formula; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $taxname; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $purchaseprice; ?>  </div>                </td>
							<td align="left" valign="top"  class="bodytext3">    <?php echo $disease; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">    <?php echo $genericname; ?>                  </td>
                        <td align="left" valign="top"  class="bodytext3">    <?php echo $type; ?>      </td>  
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $minimumstock; ?>    </div>              </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $maximumstock; ?>     </div>             </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $rol; ?>           </div>       </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $roq; ?>   </div>               </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $ipmarkup; ?>    </div></td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $spmarkup; ?>     </div></td> </tr>
						
						 
                      <?php
		}
	}
		?>
                    </tbody>
                  </table>
				  </form>
				  <br>
				  
 				  <form>
                <table width="1200" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="18" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item Master - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="18" bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">
                          <input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>">
                          <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
                          <input type="submit" name="Submit22" value="Search" style="border: 1px solid #001E6A" />
                        </span></td>
                        </tr>
                      <tr bgcolor="#011E6A">
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>
                       <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
                        <td width="8%" bgcolor="#ecf0f5" class="bodytext3"><strong>Pharmacy Item</strong></td>
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>                          <div align="center"><strong><!--Purchase--></strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
						<td width="11%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Formula</strong></div></td>
						<td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Tax</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Cost price</strong></div></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Disease</strong></div></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Generic</strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Type</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Min Stock</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Max Stock</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>ROL</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>ROQ</strong></div></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
						<td width="7%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>SP Markup</strong></div></td>
               </tr>
                      <?php
		if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
	  if ($searchflag2 == 'searchflag2')
	  {
					  
		$search2 = $_REQUEST["search2"];			  
	    $query1 = "select * from master_medicine where  type in ('Assets','General Purchases','IT Assets','Linen','Maintenance','Stationery & Printing') and (itemname like '%$search2%' or categoryname = '$search2') and status = 'deleted' order by auto_number desc LIMIT 100";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query120".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["packagename"];
		$taxname = $res1["taxname"];
		$manufacturername = $res1["manufacturername"];
		$formula = $res1['formula'];
		$genericname = $res1["genericname"];
		$minimumstock = $res1["minimumstock"];
		$maximumstock = $res1["maximumstock"];
		$rol = $res1["rol"];
		$roq = $res1["roq"];
		$type = $res1["type"];
		$ipmarkup = $res1["ipmarkup"];
		$spmarkup = $res1["spmarkup"];
		$disease = $res1["disease"];
		

		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
						<a href="pharmacyitem21.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
						  <td align="left" valign="top"  class="bodytext3">    <?php echo $formula; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $taxname; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $purchaseprice; ?>  </div>                </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $disease; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">    <?php echo $genericname; ?>                  </td>  
                        <td align="left" valign="top"  class="bodytext3">    <?php echo $type; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $minimumstock; ?>    </div>              </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $maximumstock; ?>     </div>             </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $rol; ?>           </div>       </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $roq; ?>   </div>               </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $ipmarkup; ?>    </div></td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $spmarkup; ?>     </div></td> </tr>
				
                     
                      <?php
		}
	}
	else
	{
		
	    $query1 = "select * from master_medicine where type in ('Assets','General Purchases','IT Assets','Linen','Maintenance','Stationery & Printing') and status = 'deleted' order by auto_number desc LIMIT 100";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];

		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["packagename"];
		$taxname = $res1["taxname"];
		$manufacturername = $res1["manufacturername"];
		$formula = $res1['formula'];
		$genericname = $res1["genericname"];
		$minimumstock = $res1["minimumstock"];
		$maximumstock = $res1["maximumstock"];
		$rol = $res1["rol"];
		$roq = $res1["roq"];
		$type = $res1["type"];
		$ipmarkup = $res1["ipmarkup"];
		$spmarkup = $res1["spmarkup"];
		$disease = $res1["disease"];

		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		/*<?php ?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		<?php ?>*/
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
						<a href="pharmacyitem21.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
						  <td align="left" valign="top"  class="bodytext3">    <?php echo $formula; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $taxname; ?>                  </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $purchaseprice; ?>  </div>                </td>
						<td align="left" valign="top"  class="bodytext3">    <?php echo $disease; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">    <?php echo $genericname; ?>                  </td>  
                         <td align="left" valign="top"  class="bodytext3">    <?php echo $type; ?>                  </td>  
						<td align="left" valign="top"  class="bodytext3">  <div align="center">  <?php echo $minimumstock; ?>    </div>              </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $maximumstock; ?>     </div>             </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $rol; ?>           </div>       </td>
						<td align="left" valign="top"  class="bodytext3">   <div align="center"> <?php echo $roq; ?>   </div>               </td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $ipmarkup; ?>    </div></td>
						<td align="left" valign="top"  class="bodytext3">    <div align="right"><?php echo $spmarkup; ?>     </div></td> </tr>
				
                      
                      <?php
		}
	}
		?>
                      <tr>
                        <td colspan="6" align="middle" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
              </form>                </td>
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

