<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rate Template Management</title>
<!-- Modern CSS -->
<link href="css/ratetemplate-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/ratetemplate-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php

//echo $menu_id;
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$currentdate = date("Y-m-d");

$errmsg='';

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }







if($frm1submit1 == 'frm1submit1')

{
	if(isset($_REQUEST['labcheck']))
	{
		$labname = 'lab_'.$_REQUEST['labname'];
		$query1 = "create TABLE $labname like master_lab";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);	
         $query5 ="CREATE TRIGGER `audit_$labname` AFTER INSERT ON `$labname` FOR EACH ROW BEGIN INSERT INTO `audit_master_lab`(`itemcode`,`itemname`,`shortcode`,`displayname`,`categoryname`,`sampletype`,`itemname_abbreviation`,`referencename`,`referenceunit`,`referencerange`,`criticallow`,`criticalhigh`, `rateperunit`,`rate2`,`rate3`,`expiryperiod`,`taxanum`,`taxname`,`externallab`,`externalrate`,`exclude`,`status`,`ipaddress`,`updatetime`,`description`,`purchaseprice`,`referencevalue`,`ipmarkup`,`location`,`locationname`,`pkg`,`radiology`,`username`,`ledgercode`,`auditstatus`,`from_table`)VALUES(NEW.itemcode,NEW.itemname,NEW.shortcode,NEW.displayname,NEW.categoryname, NEW.sampletype, NEW.itemname_abbreviation, NEW.referencename,NEW.referenceunit, NEW.referencerange, NEW.criticallow, NEW.criticalhigh, NEW.rateperunit, NEW.rate2, NEW.rate3, NEW.expiryperiod, NEW.taxanum,NEW.taxname,NEW.externallab,NEW.externalrate,NEW.exclude,NEW.status,NEW.ipaddress,NEW.updatetime,NEW.description,NEW.purchaseprice,NEW.referencevalue, NEW.ipmarkup,NEW.location,NEW.locationname,NEW.pkg,NEW.radiology,NEW.username,NEW.ledgercode,'i','$labname'); END";  
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query6 ="CREATE TRIGGER `audit_update_$labname` AFTER UPDATE ON `$labname` FOR EACH ROW BEGIN DECLARE auditstatus varchar(10); IF(NEW.status = 'deleted') THEN SET auditstatus = 'd'; ELSEIF(NEW.status = '') THEN SET auditstatus = 'e'; END IF; INSERT INTO `audit_master_lab` (`itemcode`, `itemname`, `shortcode`, `displayname`, `categoryname`, `sampletype`, `itemname_abbreviation`, `referencename`, `referenceunit`, `referencerange`, `criticallow`, `criticalhigh`, `rateperunit`, `rate2`, `rate3`, `expiryperiod`, `taxanum`, `taxname`, `externallab`, `externalrate`, `exclude`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`, `locationname`, `pkg`, `radiology` , `ledgercode`, `auditstatus`,`username`,`from_table`) VALUES (NEW.itemcode ,NEW.itemname,NEW.shortcode,NEW.displayname,NEW.categoryname, NEW.sampletype, NEW.itemname_abbreviation, NEW.referencename,NEW.referenceunit, NEW.referencerange, NEW.criticallow, NEW.criticalhigh, NEW.rateperunit, NEW.rate2, NEW.rate3, NEW.expiryperiod,NEW.taxanum,NEW.taxname,NEW.externallab,NEW.externalrate,NEW.exclude,NEW.status,NEW.ipaddress,NEW.updatetime,NEW.description,NEW.purchaseprice,NEW.referencevalue,NEW.ipmarkup,NEW.location,NEW.locationname,NEW.pkg,NEW.radiology,NEW.ledgercode,auditstatus,NEW.username,'$labname'); END";  
	  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	    $query2 = "INSERT INTO $labname SELECT * FROM master_lab";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
		$labnamereference = $labname.'_reference';
		$query101 = "create TABLE $labnamereference like master_labreference";
		$exec101 = mysqli_query($GLOBALS["___mysqli_ston"], $query101);
		$query201 = "INSERT INTO $labnamereference SELECT * FROM master_labreference";
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201);
		$query9 = "INSERT INTO master_testtemplate (templatename,testname,referencetable,ipaddress,username,recorddatetime,companyanum,companyname) values('$labname','lab','$labnamereference','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	if(isset($_REQUEST['radcheck']))

	{
		$radname = 'radiology_'.$_REQUEST['radname'];
		$query3 = "create TABLE $radname like master_radiology";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3);		
		$query5 =" CREATE TRIGGER `audit_$radname` AFTER INSERT ON `$radname` FOR EACH ROW BEGIN DECLARE reccount decimal(13,2) DEFAULT 0; SET reccount = (SELECT count(*) FROM `audit_master_radiology` WHERE itemcode = NEW.itemcode AND auditstatus = 'i'); IF (reccount > 0 ) THEN INSERT INTO `audit_master_radiology` (`itemcode`, `itemname`, `categoryname`, `itemname_abbreviation`, `rateperunit`, `rate2`, `expiryperiod`, `taxanum`, `taxname`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`,`rate3`,`locationname`,`locationcode`,`pkg`,`externalshare`,`radtime`,`ledger_name`,`ledger_code`,`groupid`,`discount`,`username`,`auditstatus`,`from_table`) VALUES (NEW.itemcode, NEW.itemname, NEW.categoryname, NEW.itemname_abbreviation, NEW.rateperunit, NEW.rate2, NEW.expiryperiod, NEW.taxanum, NEW.taxname, NEW.status, NEW.ipaddress, NEW.updatetime,  NEW.description, NEW.purchaseprice, NEW.referencevalue, NEW.ipmarkup,NEW.location,NEW.rate3,NEW.locationname, NEW.locationcode, NEW.pkg,NEW.externalshare,NEW.radtime,NEW.ledger_name,NEW.ledger_code,NEW.groupid,NEW.discount,NEW.username,'e','$radname'); ELSE INSERT INTO `audit_master_radiology` (`itemcode`, `itemname`, `categoryname`, `itemname_abbreviation`, `rateperunit`, `rate2`, `expiryperiod`, `taxanum`, `taxname`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`, `rate3`, `locationname`, `locationcode`, `pkg`,`externalshare`,`radtime`,`ledger_name`,`ledger_code`,`groupid`,`discount`,`username`,`auditstatus`,`from_table`) VALUES (NEW.itemcode, NEW.itemname, NEW.categoryname, NEW.itemname_abbreviation, NEW.rateperunit, NEW.rate2, NEW.expiryperiod, NEW.taxanum, NEW.taxname, NEW.status, NEW.ipaddress, NEW.updatetime,  NEW.description, NEW.purchaseprice, NEW.referencevalue, NEW.ipmarkup,NEW.location,NEW.rate3,  NEW.locationname, NEW.locationcode, NEW.pkg,NEW.externalshare,NEW.radtime,NEW.ledger_name,NEW.ledger_code,NEW.groupid,NEW.discount,NEW.username,'i','radname'); END IF; END";
        $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	   $query6 ="CREATE TRIGGER `audit_update_$radname` AFTER UPDATE ON `$radname` FOR EACH ROW BEGIN DECLARE auditstatus varchar(10); IF(NEW.status = 'deleted') THEN SET auditstatus = 'd'; ELSEIF(NEW.status = '') THEN SET auditstatus = 'e'; END IF; INSERT INTO `audit_master_radiology` (`itemcode`, `itemname`, `categoryname`, `itemname_abbreviation`, `rateperunit`, `rate2`, `expiryperiod`, `taxanum`, `taxname`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`,`rate3`,`locationname`,`locationcode`,`pkg`,`externalshare`,`radtime`,`ledger_name`,`ledger_code`,`groupid`,`discount`,`username`,`auditstatus`,`from_table`) VALUES (NEW.itemcode, NEW.itemname, NEW.categoryname, NEW.itemname_abbreviation, NEW.rateperunit, NEW.rate2, NEW.expiryperiod, NEW.taxanum, NEW.taxname, NEW.status, NEW.ipaddress, NEW.updatetime,  NEW.description, NEW.purchaseprice, NEW.referencevalue, NEW.ipmarkup,NEW.location,NEW.rate3,NEW.locationname, NEW.locationcode, NEW.pkg,NEW.externalshare,NEW.radtime,NEW.ledger_name,NEW.ledger_code,NEW.groupid,NEW.discount,NEW.username,auditstatus,'$radname'); END";  
        $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$query4 = "INSERT INTO $radname SELECT * FROM master_radiology";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4);
		$query10 = "INSERT INTO master_testtemplate (templatename,testname,ipaddress,username,recorddatetime,companyanum,companyname) values('$radname','radiology','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	if(isset($_REQUEST['sercheck']))

	{
		$sername = 'services_'.$_REQUEST['sername'];
		$query5 = "create TABLE $sername like master_services";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5);		
		$query51 ="CREATE TRIGGER `audit_$sername` AFTER INSERT ON `$sername` FOR EACH ROW BEGIN DECLARE reccount decimal(13,2) DEFAULT 0; SET reccount = (SELECT count(*) FROM `audit_master_services` WHERE itemcode = NEW.itemcode AND auditstatus = 'i'); IF (reccount > 0 ) THEN INSERT INTO `audit_master_services` (`itemcode`, `itemname`, `categoryname`, `itemname_abbreviation`, `rateperunit`, `rate2`, `expiryperiod`, `taxanum`, `taxname`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`, `incrementalrate`, `baseunit`, `incrementalquantity`, `rate3`, `locationname`, `locationcode`, `slab`, `pkg`,`ledgername`,`ledgerid`,`username`,`wellnesspkg`,`groupid`,`auditstatus`,`from_table`) VALUES (NEW.itemcode, NEW.itemname, NEW.categoryname, NEW.itemname_abbreviation,  NEW.rateperunit, NEW.rate2, NEW.expiryperiod, NEW.taxanum, NEW.taxname, NEW.status, NEW.ipaddress, NEW.updatetime,  NEW.description,  NEW.purchaseprice, NEW.referencevalue, NEW.ipmarkup, NEW.location, NEW.incrementalrate, NEW.baseunit, NEW.incrementalquantity, NEW.rate3, NEW.locationname, NEW.locationcode, NEW.slab, NEW.pkg,NEW.ledgername,NEW.ledgerid,NEW.username,NEW.wellnesspkg,NEW.groupid,'e','$sername'); ELSE  INSERT INTO `audit_master_services` (`itemcode`, `itemname`, `categoryname`, `itemname_abbreviation`, `rateperunit`, `rate2`, `expiryperiod`, `taxanum`, `taxname`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`, `incrementalrate`, `baseunit`, `incrementalquantity`, `rate3`, `locationname`, `locationcode`, `slab`, `pkg`,`ledgername`,`ledgerid`,`username`,`wellnesspkg`,`groupid`,`auditstatus`,`from_table`) VALUES (NEW.itemcode, NEW.itemname, NEW.categoryname, NEW.itemname_abbreviation,  NEW.rateperunit, NEW.rate2, NEW.expiryperiod, NEW.taxanum, NEW.taxname, NEW.status, NEW.ipaddress, NEW.updatetime,  NEW.description,  NEW.purchaseprice, NEW.referencevalue, NEW.ipmarkup, NEW.location, NEW.incrementalrate, NEW.baseunit, NEW.incrementalquantity, NEW.rate3, NEW.locationname, NEW.locationcode, NEW.slab, NEW.pkg,NEW.ledgername,NEW.ledgerid,NEW.username,NEW.wellnesspkg,NEW.groupid,'i','$sername'); END IF; END";
        $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
	   $query61 ="CREATE TRIGGER `audit_update_$sername` AFTER UPDATE ON `$sername` FOR EACH ROW BEGIN DECLARE auditstatus varchar(10); IF(NEW.status = 'deleted') THEN SET auditstatus = 'd'; ELSEIF(NEW.status = '') THEN SET auditstatus = 'e'; END IF; INSERT INTO `audit_master_services` (`itemcode`, `itemname`, `categoryname`, `itemname_abbreviation`, `rateperunit`, `rate2`, `expiryperiod`, `taxanum`, `taxname`, `status`, `ipaddress`, `updatetime`, `description`, `purchaseprice`, `referencevalue`, `ipmarkup`, `location`, `incrementalrate`, `baseunit`, `incrementalquantity`, `rate3`, `locationname`, `locationcode`, `slab`, `pkg`,`ledgername`,`ledgerid`,`username`,`wellnesspkg`,`groupid`,`auditstatus`,`from_table`) VALUES (NEW.itemcode, NEW.itemname, NEW.categoryname, NEW.itemname_abbreviation,  NEW.rateperunit, NEW.rate2, NEW.expiryperiod, NEW.taxanum, NEW.taxname, NEW.status, NEW.ipaddress, NEW.updatetime,  NEW.description,  NEW.purchaseprice, NEW.referencevalue, NEW.ipmarkup, NEW.location, NEW.incrementalrate, NEW.baseunit, NEW.incrementalquantity, NEW.rate3, NEW.locationname, NEW.locationcode, NEW.slab, NEW.pkg,NEW.ledgername,NEW.ledgerid,NEW.username,NEW.wellnesspkg,NEW.groupid,auditstatus,'$sername'); END";  
        $exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
		$query6 = "INSERT INTO $sername SELECT * FROM master_services";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6);
		$query11 = "INSERT INTO master_testtemplate (templatename,testname,ipaddress,username,recorddatetime,companyanum,companyname) values('$sername','services','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	}

	if(isset($_REQUEST['ipcheck']))

	{

		$ipname = 'package_'.$_REQUEST['ipname'];

		$query7 = "create TABLE $ipname like master_ippackage";

		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7);

		$query8 = "INSERT INTO $ipname SELECT * FROM master_ippackage";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);

		$query12 = "INSERT INTO master_testtemplate (templatename,testname,ipaddress,username,recorddatetime,companyanum,companyname) values('$ipname','ippackage','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";

		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

	}

	if(isset($_REQUEST['bedcheck']))

	{

		$bed = 'bed_'.$_REQUEST['bed'];

		$query8 = "create TABLE $bed like master_bed";

		$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8);

		$query9 = "INSERT INTO $bed SELECT * FROM master_bed";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9);

		

		$bedchargereference = $bed.'_charge';

		$query10 = "create TABLE $bedchargereference like master_bedcharge";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10);

		$query11 = "INSERT INTO $bedchargereference SELECT * FROM master_bedcharge";

		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11);

		

	 	$query122 = "INSERT INTO master_testtemplate (templatename,testname,referencetable,ipaddress,username,recorddatetime,companyanum,companyname) values('$bedchargereference','bedcharge','$bed','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";   

		$exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"])); 

		

	}

	header ("location:ratetemplate.php?st=success");

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == 'success')

{

		$errmsg = "Success. New Template Updated.";

}

else if ($st == 'failed')

{

		$errmsg = "Failed. Employee Already Exists.";

}

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

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

}

-->

</style>



<!-- Modern CSS -->
<link href="ratetemplate.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

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

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}

function validation()

{

	var re = /[a-zA-Z0-9_]$/;

	if((!document.getElementById("labcheck").checked) && (!document.getElementById("radcheck").checked) && (!document.getElementById("sercheck").checked) && (!document.getElementById("ipcheck").checked)&& (!document.getElementById("bedcheck").checked))

	{

		alert("Please Select Any Check Box");

		return false;

	}

	if(document.getElementById("labcheck").checked)

	{

	 if(document.getElementById("labname").value=='')

	 {

		alert("Enter the lab template name");

		return false;

	 }	 

     else if (!re.test(document.getElementById("labname").value))

    {

        alert ("Special Characters are not allowed except the _");

        return false;

    }

	 

	}

	if(document.getElementById("radcheck").checked)

	{

	 if(document.getElementById("radname").value=='')

	 {

		alert("Enter the radiology template name");

		return false;

	 }

	 else if (!re.test(document.getElementById("radname").value))

    {

        alert ("Special Characters are not allowed except the _");

        return false;

    }

	}

	if(document.getElementById("sercheck").checked)

	{

	 if(document.getElementById("sername").value=='')

	 {

		alert("Enter the service template name");

		return false;

	 }

	  else if (!re.test(document.getElementById("sername").value))

    {

        alert ("Special Characters are not allowed except the _");

        return false;

    }

	}

	if(document.getElementById("ipcheck").checked)

	{

	 if(document.getElementById("ipname").value=='')

	 {

		alert("Enter the ip package template name");

		return false;

	 }

	  else if (!re.test(document.getElementById("ipname").value))

    {

        alert ("Special Characters are not allowed except the _");

        return false;

    }

	}

	if(document.getElementById("bedcheck").checked)

	{

	  if(document.getElementById("bed").value=='')

	 {

		alert("Enter the Bed template name");

		return false;

	 }

	  else if (!re.test(document.getElementById("bed").value))

    {

        alert ("Special Characters are not allowed except the _");

        return false;

    }

	}



	//return false;

}

function enabletextbox()

{

	if(document.getElementById("labcheck").checked)

	{

	 document.getElementById("labname").disabled='';

	}

	else if(!document.getElementById("labcheck").checked)

	{

	 document.getElementById("labname").disabled='true';

	}

	

	if(document.getElementById("radcheck").checked)

	{

	 document.getElementById("radname").disabled='';

	}

	else if(!document.getElementById("radcheck").checked)

	{

	 document.getElementById("radname").disabled='true';

	}

	

	if(document.getElementById("sercheck").checked)

	{

	 document.getElementById("sername").disabled='';

	}

	else if(!document.getElementById("sercheck").checked)

	{

	 document.getElementById("sername").disabled='true';

	}

	

	if(document.getElementById("ipcheck").checked)

	{

	 document.getElementById("ipname").disabled='';

	}

	else if(!document.getElementById("ipcheck").checked)

	{

	 document.getElementById("ipname").disabled='true';

	}

if(document.getElementById("bedcheck").checked)

	{

	 document.getElementById("bed").disabled='';

	}

	else if(!document.getElementById("bedcheck").checked)

	{

	 document.getElementById("bed").disabled='true';

	}

}



</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<!-- Modern JavaScript -->
<script type="text/javascript" src="ratetemplate.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<body>



<form name="form1" id="form1" method="post" onSubmit="return validation();">

<div class="page-header">
  <h1 class="page-title">Rate Template Management</h1>
  <p class="page-subtitle">Create and manage rate templates for different service categories</p>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" class="alert-container"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" class="title-container"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" class="menu-container"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top">
    
    <div class="form-container">
    <form name="frmsales" id="frmsales" method="post" action="ratetemplate.php" class="modern-form">
    <table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>
        <table id="AutoNumber3" class="modern-table" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="300" 

            align="left" border="0">

          <tbody>

		   <tr>

                <td colspan="8" align="left" valign="middle"  

				bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>

              </tr>

            <tr>

             

              <td colspan="9"  class="bodytext31">

                

                <div align="left"><strong>Rate Tempalate</strong></div></td>

              </tr>

			  

						

            <tr>

              <td class="bodytext31" valign="center"  align="left" width="5%" 

><div align="center"><strong>Select</strong></div></td>				 

				<td width="20%"  align="left" valign="center" 

 class="bodytext31"><div align="center"><strong>Description</strong></div></td>

              	<td width="20%"  align="left" valign="center" 

 class="bodytext31"><div align="center"><strong>Template Name</strong></div></td>             

              </tr>

			  

			  <tr bgcolor="#CBDBFA">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="labcheck" id="labcheck" onChange="enabletextbox();" /></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center">Lab</div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><input type="text" name="labname" id="labname" disabled="disabled"/></div></td>

				</tr>

				

				<tr >

              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="radcheck" id="radcheck" onChange="enabletextbox();"/></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center">Radiology</div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><input type="text" name="radname" id="radname" disabled="disabled"/></div></td>

				</tr>

				

				<tr bgcolor="#CBDBFA">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="sercheck" id="sercheck" onChange="enabletextbox();"/></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center">Services</div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><input type="text" name="sername" id="sername" disabled="disabled"/></div></td>

				</tr>

				

				<tr >

              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="ipcheck" id="ipcheck" onChange="enabletextbox();"/></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center">IP Package</div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><input type="text" name="ipname" id="ipname" disabled="disabled"/></div></td>

				</tr>

			   

                <tr bgcolor="#CBDBFA">

              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="bedcheck" id="bedcheck" onChange="enabletextbox();"/></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center">Bed Charges</div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><input type="text" name="bed" id="bed" disabled="disabled"/></div></td>

				</tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

>

				<input type="hidden" name="frm1submit1" id="frm1submit1" value="frm1submit1" />

				<input type="submit" name="save" id="save" value="Save" />

				

				</td>

              <td class="bodytext31" valign="center"  align="left" 

>&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

>&nbsp;</td>

              

            

              </tr>

			  

          </tbody>

        </table></td>

      </tr>

	  <tr>

	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

	  </tr>

	  

    </table>

</table>



<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</form>

</body>

</html>