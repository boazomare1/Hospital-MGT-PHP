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
$bedtemplate=isset($_REQUEST['bedtemp'])?$_REQUEST['bedtemp']:'';
$bedtable=$bedtemplate;
$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable='$bedtemplate' order by templatename";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
$res10 = mysqli_fetch_array($exec10);
$bedtemplate = $res10["templatename"];
if($bedtemplate=='')
{
	$bedtable='master_bed';
	$bedtemplate='master_bedcharge';
}
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
	$bedtemplate=$_REQUEST['bedtemplate1'];
	$bedtable=$_REQUEST['bedtable'];
	$bed = $_REQUEST["bed"];
	$bedanum1 = $_REQUEST['bedanum'];
	//$bed = strtoupper($bed);
	$bed = trim($bed);
	
	$length=strlen($bed);
	$ward = $_REQUEST["ward"];
	$threshold = $_REQUEST['threshold'];
	$nursingcharges = $_REQUEST['nursingcharges'];
	$bedcharges = $_REQUEST['bedcharges'];
	$rmocharges = $_REQUEST['rmocharges'];
	$inh_review = $_REQUEST['inh_review'];
	$int_review = $_REQUEST['int_review'];
	$adms_review = $_REQUEST['adms_review'];
	$selectedlocationcode=$_REQUEST["location"];
	$accommodationonly=$_REQUEST["accommodationonly"];
	
	$accommodationcharges = $_REQUEST['accommodationcharges'];
	$cafetariacharges = $_REQUEST['cafetariacharges'];
	
		 $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 =(mysqli_fetch_array($exec31));
	 $selectedlocation = $res31["locationname"];

	 $length;
	
	if ($length<=100)
	{
	$query1 = "update $bedtable set locationname='$selectedlocation',locationcode='$selectedlocationcode',bed='$bed', ward='$ward',threshold='$threshold',bedcharges='$bedcharges',nursingcharges='$nursingcharges',rmocharges='$rmocharges',accommodationcharges='$accommodationcharges',cafetariacharges='$cafetariacharges',inh_review='$inh_review',int_review='$int_review',adms_review='$adms_review',accommodationonly='$accommodationonly' where auto_number='$bedanum1'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// $s="select bed from $bedtemplate where bedanum='$bedanum1' and charge='Bed Charges'";
	 $query7 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Bed Charges'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row7 = mysqli_num_rows($query7);
	if($row7 > 0) {	
	 $query22 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$bedcharges', ward='$ward' where bedanum='$bedanum1' and charge='Bed Charges'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query22 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$bedcharges', bedanum='$bedanum1', charge='Bed Charges', ward='$ward'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query71 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Nursing Charges'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row71 = mysqli_num_rows($query71);
	if($row71 > 0) {	
	$query23 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$nursingcharges', ward='$ward' where bedanum='$bedanum1' and charge='Nursing Charges'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query23 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$nursingcharges', bedanum='$bedanum1', charge='Nursing Charges', ward='$ward'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	 "select bed from $bedtemplate where bedanum='$bedanum1' and (charge='RMO Charges' or charge='Daily Review charge')";
	$query72 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and (charge='RMO Charges' or charge='Daily Review charge')") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row72 = mysqli_num_rows($query72);
	if($row72 > 0) {	
	 $query21 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$rmocharges',charge='Daily Review charge', ward='$ward' where bedanum='$bedanum1' and (charge='RMO Charges' or charge='Daily Review charge')";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else { 
	$query21 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$rmocharges', bedanum='$bedanum1', charge='Daily Review charge', ward='$ward'";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query73 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Accommodation Charges'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row73 = mysqli_num_rows($query73);
	if($row73 > 0) {	
	$query20 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$accommodationcharges', ward='$ward' where bedanum='$bedanum1' and charge='Accommodation Charges'";
	$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query20 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$accommodationcharges', bedanum='$bedanum1', charge='Accommodation Charges', ward='$ward'";
	$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query74 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Cafetaria Charges'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row74 = mysqli_num_rows($query74);
	if($row74 > 0) {	
	$query19 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$cafetariacharges', ward='$ward' where bedanum='$bedanum1' and charge='Cafetaria Charges'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query19 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$cafetariacharges', bedanum='$bedanum1', charge='Cafetaria Charges', ward='$ward'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query75 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and (charge='Inhouse Specialist Review' or charge='Consultant Fee')") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row75 = mysqli_num_rows($query75);
	if($row75 > 0) {	
	$query19 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$inh_review',charge='Consultant Fee', ward='$ward' where bedanum='$bedanum1' and (charge='Inhouse Specialist Review' or charge='Consultant Fee')";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query19 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$inh_review', bedanum='$bedanum1', charge='Consultant Fee', ward='$ward'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query76 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Intensivist Review'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row76 = mysqli_num_rows($query76);
	if($row76 > 0) {	
	$query19 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$int_review', ward='$ward' where bedanum='$bedanum1' and charge='Intensivist Review'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query19 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$int_review', bedanum='$bedanum1', charge='Intensivist Review', ward='$ward'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	$query74 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Admitting Specialist Review'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row74 = mysqli_num_rows($query74);
	if($row74 > 0) {	
	$query19 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$adms_review', ward='$ward' where bedanum='$bedanum1' and charge='Admitting Specialist Review'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query19 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$adms_review', bedanum='$bedanum1', charge='Admitting Specialist Review', ward='$ward'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}

	$query77 = mysqli_query($GLOBALS["___mysqli_ston"], "select bed from $bedtemplate where bedanum='$bedanum1' and charge='Accommodation Only'") or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row77 = mysqli_num_rows($query77);
	if($row77 > 0) {	
	$query19 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$accommodationonly', ward='$ward' where bedanum='$bedanum1' and charge='Accommodation Only'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	} else {
	$query19 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$accommodationonly', bedanum='$bedanum1', charge='Accommodation Only', ward='$ward'";
	$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19)	or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}

		$errmsg = "Success. New bed Updated.";
		$bgcolorcode = 'success';
	
	//exit();
		
		}
	
	
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

$query74 = "select * from $bedtable where auto_number='$anum'";
$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res74 = mysqli_fetch_array($exec74);
$wardanum = $res74['ward'];
$res74locationname = $res74['locationname'];	
$res74locationcode = $res74['locationcode'];
$bed = $res74['bed'];
$threshold = $res74['threshold'];
$threshold = intval($threshold);
$accommodationcharges = $res74['accommodationcharges'];
$cafetariacharges = $res74['cafetariacharges'];
$accommodationonly = $res74['accommodationOnly'];

 $query741 = "select * from $bedtemplate where bed='$bed' and charge='Bed Charges' and ward='$wardanum'";
$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res741 = mysqli_fetch_array($exec741);
$bedcharges = $res741['rate'];

$query742 = "select * from $bedtemplate where bed='$bed' and charge='Nursing Charges' and ward='$wardanum'";
$exec742 = mysqli_query($GLOBALS["___mysqli_ston"], $query742) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res742 = mysqli_fetch_array($exec742);
$nursingcharges = $res742['rate'];

$query743 = "select * from $bedtemplate where bed='$bed' and (charge='Daily Review charge' or charge='RMO Charges') and ward='$wardanum'";
$exec743 = mysqli_query($GLOBALS["___mysqli_ston"], $query743) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res743 = mysqli_fetch_array($exec743);
$rmocharges = $res743['rate'];

$query744 = "select * from $bedtemplate where bed='$bed' and (charge='Consultant Fee' or charge='Inhouse Specialist Review') and ward='$wardanum'";
$exec744 = mysqli_query($GLOBALS["___mysqli_ston"], $query744) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res744 = mysqli_fetch_array($exec744);
$inh_review = $res744['rate'];

$query745 = "select * from $bedtemplate where bed='$bed' and charge='Intensivist Review' and ward='$wardanum'";
$exec745 = mysqli_query($GLOBALS["___mysqli_ston"], $query745) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res745 = mysqli_fetch_array($exec745);
$int_review = $res745['rate'];

$query746 = "select * from $bedtemplate where bed='$bed' and charge='Admitting Specialist Review' and ward='$wardanum'";
$exec746 = mysqli_query($GLOBALS["___mysqli_ston"], $query746) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res746 = mysqli_fetch_array($exec746);
$adms_review = $res746['rate'];

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
	if (document.form1.location.value == "")
	{
		alert ("Location Cannot Be Empty.");
		document.form1.location.focus();
		return false;
	}
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
		if (document.form1.accommodationcharges.value == "")
	{
		alert ("Please Enter Accommodation Charge.");
		document.form1.accommodationcharges.focus();
		return false;
	}
	
	
	if (document.form1.cafetariacharges.value == "")
	{
		alert ("Please Enter Cafetaria Charge.");
		document.form1.cafetariacharges.focus();
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


function keypressdigit(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode;
	      if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57))
            return false;
		else		
			return true;
}

function charges()
{
			var var1=0;
			var var2=0;
		
			if((document.getElementById('accommodationcharges').value).trim()!="")
			 var1=parseFloat(document.getElementById('accommodationcharges').value);
			if((document.getElementById('cafetariacharges').value).trim()!="")
			 var2=parseFloat(document.getElementById('cafetariacharges').value);
			document.getElementById('bedcharges').value=(var1+var2).toFixed(2);
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
                  <table width="600" height="400" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Bed Master - Add New </strong></td>
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3" align="right"><strong>Table: <?= $bedtemplate ?></strong></td>
                      </tr>
                      
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                                            				<tr>
                <td width="14%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange="return funclocationChange1();"  style="border: 1px solid #001E6A;">
                						<option value="<?php echo $res74locationcode;?>"><?php echo $res74locationname;?></option>
                  <?php
						$query1 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                </select>
                </td>
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
                      
  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Non Pharms *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="accommodationcharges" id="accommodationcharges" style="border: 1px solid #001E6A;" size="10" onKeyPress="return keypressdigit(event)" onKeyUp="" value="<?php echo $accommodationcharges; ?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Meals *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="cafetariacharges" id="cafetariacharges" style="border: 1px solid #001E6A;" onKeyPress="return keypressdigit(event)" onKeyUp="" size="10" value="<?php echo $cafetariacharges; ?>" /></td>
                      </tr> 
                                            
                   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Charges</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="bedcharges" id="bedcharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $bedcharges; ?>" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Nursing Care</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="nursingcharges" id="nursingcharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $nursingcharges; ?>"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Daily Review</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="rmocharges" id="rmocharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $rmocharges; ?>"/></td>
                      </tr>
						<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultant Fee</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="inh_review" id="inh_review" style="border: 1px solid #001E6A;" size="10" value="<?php echo $inh_review; ?>" /></td>
                      </tr>
					 <!-- <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Intensivist Review</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="int_review" id="int_review" style="border: 1px solid #001E6A;" size="10" value="<?php echo $int_review; ?>"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Admitting Specialist Review</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="adms_review" id="adms_review" style="border: 1px solid #001E6A;" size="10" value="<?php echo $adms_review; ?>"/></td>
                      </tr>-->

					   <input type="hidden" name="int_review" id="int_review" value="<?php echo $int_review; ?>"/>
					   <input type="hidden" name="adms_review" id="adms_review"   value="<?php echo $adms_review; ?>"/>
            
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accommodation Only</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accommodationonly" id="accommodationonly" style=" background-color:#ecf0f5;" size="10" value="<?php echo $accommodationonly; ?>" readonly/></td>
                      </tr>
				
			          <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Threshold</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="threshold" id="threshold" style="border: 1px solid #001E6A;" size="10" value="<?php echo $threshold; ?>"/><input type="hidden" name="bedtemplate1" id="bedtemplate1" value="<?= $bedtemplate ?>">
                        <input type="hidden" name="bedtable" id="bedtable" value="<?= $bedtable ?>">
                        </td>
                      </tr>
					   <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Grace </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="grace" id="grace" style="border: 1px solid #001E6A;" size="10" value="<?php echo $grace; ?>"/></td>
                      </tr>-->
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

