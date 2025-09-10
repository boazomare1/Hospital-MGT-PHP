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
$plannameanum = $_REQUEST['anum'];
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
    $plannameanum = $_REQUEST['plannameanum'];
	$planname = $_REQUEST["planname"];
	$planname = strtoupper($planname);
	$planname = trim($planname);
	$length=strlen($planname);
	$planstatus = $_REQUEST["planstatus"];
	$planstatus = strtoupper($planstatus);
	$planstatus = trim($planstatus);
	$length=strlen($planstatus);
	
	//echo $length;
	$maintype = $_REQUEST["paymenttype"];
	
	$subtype = $_REQUEST["subtype"];
	$query22 = "select subtype_ledger from master_subtype where auto_number = '$subtype'";
	$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res221 = mysqli_fetch_array($exec221);
	$subtype_ledger = $res221['subtype_ledger'];
	
	$query_an = "select auto_number from master_accountname where id = '$subtype_ledger'";
	$exec_an = mysqli_query($GLOBALS["___mysqli_ston"], $query_an) or die ("Error in query_an".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_an = mysqli_fetch_array($exec_an);
	$accountname = $res_an['auto_number'];
	$plancondition = $_REQUEST["plancondition"];
	$planfixedamount = isset($_REQUEST["planfixedamount"])?$_REQUEST["planfixedamount"]:'0.00';
	$planpercentage = isset($_REQUEST["planpercentage"])?$_REQUEST["planpercentage"]:'0.00';
	$planexpirydate = $_REQUEST["planexpirydate"];
	$planstartdate = $_REQUEST["planstartdate"];
	$overalllimitop=isset($_REQUEST["overalllimitop"])?$_REQUEST["overalllimitop"]:'';
	$overalllimitip=isset($_REQUEST["overalllimitip"])?$_REQUEST["overalllimitip"]:'';
	$opvisitlimit=isset($_REQUEST["opvisitlimit"])?$_REQUEST["opvisitlimit"]:'';
	$ipvisitlimit=isset($_REQUEST["ipvisitlimit"])?$_REQUEST["ipvisitlimit"]:'';
	//$smartap = isset($_REQUEST['smart'])?$_REQUEST['smart']:'';
	$smartap = $_REQUEST["smart"];
	$recordstatus = $_REQUEST["recordstatus"];
	$exclusions = addslashes($_REQUEST['exclusions']);
	$dptlimit=isset($_REQUEST["dptlimit"])?$_REQUEST["dptlimit"]:'';
	$pharmacylimit=isset($_REQUEST["pharmacylimit"])?$_REQUEST["pharmacylimit"]:'';
	$lablimit=isset($_REQUEST["lablimit"])?$_REQUEST["lablimit"]:'';
	$radiologylimit=isset($_REQUEST["radiologylimit"])?$_REQUEST["radiologylimit"]:'';
	$serviceslimit=isset($_REQUEST["serviceslimit"])?$_REQUEST["serviceslimit"]:'';
	$forall = isset($_REQUEST['forall'])?$_REQUEST['forall']:'';
	$planapplicable = isset($_REQUEST['planapplicable']) ? $_REQUEST['planapplicable'] : '';
	
	if ($length<=255)
	{
	$query2 = "select * from master_planname where auto_number = '$plannameanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2); 
	if ($res2 != 0)
	{
		 $query201 = "INSERT INTO audit_master_planname (plan_id,maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,
		overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit) SELECT auto_number,maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,
		overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall,planapplicable,departmentlimit,pharmacylimit,lablimit,radiologylimit,serviceslimit FROM master_planname where auto_number = '$plannameanum'";
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201);
		$query1 = "update master_planname set maintype = '$maintype', subtype = '$subtype',accountname = '$accountname',planname = '$planname', planstatus='$planstatus',  plancondition = '$plancondition', planfixedamount = '$planfixedamount',planpercentage = '$planpercentage', smartap = '$smartap',
		planexpirydate = '$planexpirydate',overalllimitop = '$overalllimitop', overalllimitip = '$overalllimitip',opvisitlimit = '$opvisitlimit',ipvisitlimit = '$ipvisitlimit',recordstatus = '$recordstatus',exclusions =  '$exclusions',planstartdate='".$planstartdate."',forall='".$forall."', planapplicable='$planapplicable', departmentlimit='$dptlimit', pharmacylimit='$pharmacylimit', lablimit='$lablimit', radiologylimit='$radiologylimit', serviceslimit='$serviceslimit',recorddate='$updatedatetime',username='$username',ipaddress='$ipaddress' where auto_number = '$plannameanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		//$bgcolorcode = 'success';
		header ("location:addplanname1.php?bgcolorcode=success&&st=changed&&anum=$plannameanum");
	}
	//exit();
	else
	{
		$errmsg = "Failed. Plan Name Already Exists.";
		$bgcolorcode = 'failed';
		header ("location:editplanname1.php?bgcolorcode=success&&st=edit&&anum=$plannameanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editplanname1.php?bgcolorcode=success&&st=edit&&anum=$plannameanum");
	}
}
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_planname set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_planname set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_planname set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query5 = "update master_planname set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_planname set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Plan Name To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_planname where auto_number = '$anum'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	
	$res1autonumber = $res1['auto_number'];
    $res1maintype = $res1["maintype"];
	$res1subtype =  $res1["subtype"];
	$res1accountname =  $res1["accountname"];
	$res1planname =  $res1["planname"];
	$res1plancondition =  $res1["plancondition"];
	
	 $res1forall =  $res1["forall"];
	 $res1planstartdate =  $res1["planstartdate"];
	
	$res1planfixedamount =  $res1["planfixedamount"];
	if ($res1planfixedamount == '0.00') $res1planfixedamount = '';
	
	$res1planpercentage =  $res1["planpercentage"];
	if ($res1planpercentage == '0.00') $res1planpercentage = '';
	$res1planexpirydate = $res1["planexpirydate"];
	$res1overalllimitop =  $res1["overalllimitop"];
	$res1overalllimitip =  $res1["overalllimitip"];
	$res1opvisitlimit =  $res1["opvisitlimit"];
	$res1ipvisitlimit =  $res1["ipvisitlimit"];
    $res1recordstatus =  $res1["recordstatus"];
	$res1exclusions = $res1['exclusions'];
	$res1smartap = $res1['smartap'];
   $res1planstatus = $res1['planstatus'];
	$planapplicable = $res1['planapplicable'];
	$res1dptlimit = $res1['departmentlimit'];
	$res1pharmacylimit = $res1['pharmacylimit'];
	$res1lablimit = $res1['lablimit'];
	$res1radiologylimit = $res1['radiologylimit'];
	$res1serviceslimit = $res1['serviceslimit'];
	$res1serviceslimit = $res1['serviceslimit'];
	$scheme_name = $res1['scheme_name'];
	$scheme_expiry = $res1['scheme_expiry'];
	$scheme_active_status = $res1['scheme_active_status'];
	$scheme_id = $res1['scheme_id'];
	$edited_username = $res1['username'];
	$edited_recorddate = $res1['recorddate'];
}
   
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
	$errmsg = "Success. New Insurance Company Updated.";
}
if ($bgcolorcode == 'failed')
{
	$errmsg = "Failed. Insurance Company Already Exists.";
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
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script type="text/javascript">
function disablecopay(){
	var dptlimit = document.getElementById("dptlimit").checked;
	var limit = document.getElementById("limitstatus").value;
	
	if(dptlimit == true){
		document.getElementById('pharmacylimit').disabled = false;
		document.getElementById('lablimit').disabled = false;
		document.getElementById('radiologylimit').disabled = false;
		document.getElementById('serviceslimit').disabled = false;
		document.getElementById('planpercentage').disabled = true;
		document.getElementById('planpercentage').value = '';
		document.getElementById('forall').disabled = true;
		document.getElementById('forall').checked = false;
	} else {
		document.getElementById('pharmacylimit').disabled = true;
		document.getElementById('pharmacylimit').value = '';
		document.getElementById('lablimit').disabled = true;
		document.getElementById('lablimit').value = '';
		document.getElementById('radiologylimit').disabled = true;
		document.getElementById('radiologylimit').value = '';
		document.getElementById('serviceslimit').disabled = true;
		document.getElementById('serviceslimit').value = '';
		document.getElementById('planpercentage').disabled = false;
		document.getElementById('forall').disabled = false;
		document.getElementById('opvisitlimit').disabled = false;
		document.getElementById('ipvisitlimit').disabled = false;
		document.getElementById('overalllimitop').disabled = false;
		document.getElementById('overalllimitip').disabled = false;
	}
}
</script>
<script language="javascript">
function checking(){
		//alert('ok');
	var vlimit = document.getElementById("vlimit");
	var alllimit = document.getElementById("alllimit");
	var overalllimit = document.getElementById("overalllimit");
	var visitlimit = document.getElementById("visitlimit");
	var limit = document.getElementsByClassName("limit");
	if(vlimit.checked){
		vlimit.checked = true;
		alllimit.checked = false;
		overalllimit.disabled = true;
		overalllimit.value ='';
		visitlimit.disabled = false;	
	}else if(alllimit.checked){
		alllimit.checked = true;
		vlimit.checked = false;
		visitlimit.disabled = true;
		visitlimit.value = '';
		overalllimit.disabled = false;	
	}
	}
function addplanname1process1()
{
	
	if (document.form1.limitstatus.value == "")
	{
		alert ("Please Select Limit status.");
		document.form1.limitstatus.focus();
		return false;
	}
	if(document.getElementById("forall").checked==true && (document.getElementById("planpercentage").value<=0 || document.getElementById("planpercentage").value=='')){
       
	    alert ("Please enter copay percentage.");
		document.form1.planpercentage.focus();
		return false;
     
   }
	if (document.form1.limitstatus.value == "overall")
	{
		if (document.form1.overalllimitop.value == ''){
		alert ("Please Enter Overalllimitop.");
		document.form1.overalllimitop.focus();
		return false;
		}else if(document.form1.overalllimitip.value == ''){
		alert ("Please Enter Overalllimitip.");
		document.form1.overalllimitip.focus();
		return false;
		}
	}else if(document.form1.limitstatus.value == "visit"){
		if (document.form1.opvisitlimit.value == ''){
		alert ("Please Enter opvisitlimit.");
		document.form1.opvisitlimit.focus();
		return false;
		}else if(document.form1.ipvisitlimit.value == ''){
		alert ("Please Enter ipvisitlimit.");
		document.form1.ipvisitlimit.focus();
		return false;
		}
	}
	
	if (document.form1.planstartdate.value == "")
	{
		alert ("Please Select Plan Start Date.");
		document.form1.planstartdate.focus();
		return false;
	}
	if (document.form1.planexpirydate.value == "")
	{
		alert ("Please Select Plan Expiry Date.");
		document.form1.planexpirydate.focus();
		return false;
	}
	if (document.form1.recordstatus.value == "")
	{
		alert ("Please Select Plan Status.");
		document.form1.recordstatus.focus();
		return false;
	}
	
	if ((document.form1.planname.value == "")||(document.form1.planname.value == " "))
	{
		alert ("Please Enter Plan Name.");
		document.form1.planname.focus();
		return false;
	}
	
	if (document.form1.planfixedamount.value != "")
	{
		if (isNaN(document.form1.planfixedamount.value))
		{
			alert ("Plan Fixed Amount Can Only Be Numbers.");
			document.form1.planfixedamount.focus();
			return false;
		}
	}
	if (document.form1.planpercentage.value != "")
	{
		if (isNaN(document.form1.planpercentage.value))
		{
			alert ("Plan Percentage Can Only Be Numbers.");
			document.form1.planpercentage.focus();
			return false;
		}
	}
	/* if (document.form1.visitlimit.value != "")
	{
		if (isNaN(document.form1.visitlimit.value))
		{
			alert ("Plan  Visit Limit Can Only Be Numbers.");
			document.form1.visitlimit.focus();
			return false;
		}
	} */
	if (document.form1.planexpirydate.value == "")
	{
		alert ("Please Enter Plan Expiry Date.");
		document.form1.planexpirydate.focus();
		return false;
	}
	if (document.form1.recordstatus.value == "")
	{
		alert ("Please Select Plan Status.");
		document.form1.recordstatus.focus();
		return false;
	}	
	if (document.form1.scheme_name.value == "")
	{
		alert ("Please Enter Scheme Name.");
		document.form1.scheme_name.focus();
		return false;
	}
$('#paymenttype').attr("disabled", false);
$('#subtype').attr("disabled", false);
$('#scheme_active_status').attr("disabled", false);
    if(confirm("Do You Want To Save The Record? ")==false) 
	{
		return false;
	}
	
}
function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;
  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
  return false;
 }
}
window.onload= function(){
 var limitstatus = document.getElementById("limitstatus");
 if(limitstatus.value=='overall')
 {
		 document.getElementById("ipvisitlimit").disabled=true;
		 document.getElementById("ipvisitlimit").value = '';
		 document.getElementById("opvisitlimit").disabled=true;
		 document.getElementById("opvisitlimit").value= '';
		 document.getElementById("overalllimitip").disabled=false;
		 document.getElementById("overalllimitop").disabled=false;
	}
	else if(limitstatus.value=='visit')
	{
		 document.getElementById("overalllimitip").disabled=true;
		 document.getElementById("overalllimitip").value = '';
		 document.getElementById("overalllimitop").disabled=true;
		 document.getElementById("overalllimitop").value = '';
		 document.getElementById("ipvisitlimit").disabled=false;
		 document.getElementById("opvisitlimit").disabled=false;
	}
	
}
function functionlimit(a)
{
	var limit =a;
	if(limit=='overall')
	{
		 document.getElementById("ipvisitlimit").disabled=true;
		 document.getElementById("ipvisitlimit").value = '';
		 document.getElementById("opvisitlimit").disabled=true;
		 document.getElementById("opvisitlimit").value= '';
		 document.getElementById("overalllimitip").disabled=false;
		 document.getElementById("overalllimitop").disabled=false;
	}
	else if(limit=='visit')
	{
		 document.getElementById("overalllimitip").disabled=true;
		 document.getElementById("overalllimitip").value = '';
		 document.getElementById("overalllimitop").disabled=true;
		 document.getElementById("overalllimitop").value = '';
		 document.getElementById("ipvisitlimit").disabled=false;
		 document.getElementById("opvisitlimit").disabled=false;
	}
	
	return false;
}
function funcPaymentTypeChange1()
{
	<?php 
	$query12 = "select * from master_paymenttype where recordstatus = ''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12paymenttypeanum = $res12['auto_number'];
	$res12paymenttype = $res12["paymenttype"];
	?>
	if(document.getElementById("paymenttype").value=="<?php echo $res12paymenttypeanum; ?>")
	{
		document.getElementById("subtype").options.length=null; 
		var combo = document.getElementById('subtype'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10subtypeanum = $res10['auto_number'];
		$res10subtype = $res10["subtype"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}
function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_subtype where recordstatus = ''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12subtypeanum = $res12["auto_number"];
	$res12subtype = $res12["subtype"];
	?>
	if(document.getElementById("subtype").value=="<?php echo $res12subtypeanum; ?>")
	{
		document.getElementById("accountname").options.length=null; 
		var combo = document.getElementById('accountname'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Account Name", ""); 
		<?php
		$query10 = "select * from master_accountname where subtype = '$res12subtypeanum' and recordstatus = 'ACTIVE'";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10['auto_number'];
		$res10accountname = $res10["accountname"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountname;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}
function funcexpiry()
{
	<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("planexpirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if (expirydate < currentdate)
	{
		alert("Please Select Correct Account Expiry Date");
		document.getElementById("planexpirydate").value = "";
		document.getElementById("planexpirydate").focus();
		return false;
	}
}
</script>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$(function() {
		$('#scheme_name').autocomplete({
			source: 'getSchemename.php',
			minLength: 2,
			delay: 0,
			html: true,
			select: function(event, ui) {
				var scheme_id = ui.item.scheme_id;
				var scheme_expiry = ui.item.scheme_expiry;
				var scheme_active_status = ui.item.scheme_active_status;
				$('#scheme_id').val(scheme_id);
				$('#scheme_expiry').val(scheme_expiry);
				$('#scheme_active_status').val(scheme_active_status);
				$('#scheme_active_status').attr("disabled", true); 
				$('#schm_date').css('display', 'none');
			}
		});
	});
	
	function removeScheme()
	{
		if($('#scheme_id').val()!=''){
		$('#scheme_id').val('');
		$('#scheme_active_status').attr("disabled", false); 
		$('#schm_date').css('display', 'block');
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
              <td><form name="form1" id="form1" method="post" action="editplanname1.php" onSubmit="return addplanname1process1()">
              <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber" style="border-collapse: collapse">
                      <tbody>
                        <tr bgcolor="#011E6A">
                          <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Plan Name Master - Edit</strong></td>
                        </tr>
                        <tr>
                          <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF">
                          
                          <input name="plannameanum" id="plannameanum"  type="hidden" value="<?php echo $plannameanum;?>"/>
                          <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();" disabled>
                            <?php
				if ($res1maintype == '')
				{
					echo '<option value="" selected="selected">Select Type</option>';
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
				$res5paymenttype = $res5["paymenttype"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                          <?php
				}
				?>
                          </select></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><select name="subtype" id="subtype" onChange="return funcSubTypeChange1()" disabled>
                           <?php   	if ($res1subtype == '')
								 {
						   echo '<option value="" selected="selected">Select Sub Type</option>';
					       }
					     else
					     {
						$query4 = "select * from master_subtype where auto_number = '$res1subtype'";
						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res4 = mysqli_fetch_array($exec4);
						$res4subtypeanum = $res4['auto_number'];
						$res4subtypename = $res4['subtype'];
					
						echo '<option value="'.$res4subtypeanum.'" selected="selected">'.$res4subtypename.'</option>';
					      }
					
					$query5 = "select * from master_subtype where recordstatus = '' order by subtype";
					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res5 = mysqli_fetch_array($exec5))
					{
					$res5anum = $res5["auto_number"];
					$res5subtype = $res5["subtype"];
					?>
							  <option value="<?php echo $res5anum; ?>"><?php echo $res5subtype; ?></option>
                          <?php
				}
				?>
                          </select></td>
                        </tr>
                        <tr>
                          <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Name </div></td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><strong>
                            <select name="accountname" id="accountname">
                               <?php
				if ($res1accountname == '')
				{
					echo '<option value="" selected="selected">Select Type</option>';
				}
				else
				{
					$query4 = "select * from master_accountname where auto_number = '$res1accountname'";
					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res4 = mysqli_fetch_array($exec4);
					$res4res1accountnameanum = $res4['auto_number'];
					$res4res1accountname = $res4['accountname'];
				
					echo '<option value="'.$res4res1accountnameanum.'" selected="selected">'.$res4res1accountname.'</option>';
				}
				
				$query5 = "select * from master_accountname where recordstatus = '' order by accountname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5accountname = $res5["accountname"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5accountname; ?></option>
                          <?php
				}
				?>
                            </select>
                          </strong></td>-->
							<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Scheme Name </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF">
						  <input name="scheme_name" id="scheme_name"  readonly size="40" value="<?php echo $scheme_name;?>" onkeypress="return removeScheme();"/>
						  </td>
                          <input type="hidden" name="scheme_id" id="scheme_id" value="<?php echo $scheme_id;?>">
                        </tr>
						 <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Scheme Expiry </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
						  
							<input name="scheme_expiry" id="scheme_expiry"  size="10" value="<?php echo $scheme_expiry ?>" readonly />
                           
                          </strong></td>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Scheme Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                           <select name="scheme_active_status" id="scheme_active_status" disabled>
                             
                              <option <?php if($scheme_active_status=='ACTIVE'){ ?> selected <?php } ?>value="ACTIVE">ACTIVE</option>
                              <option <?php if($scheme_active_status=='DELETED'){ ?> selected <?php } ?> value="DELETED">INACTIVE</option>
                            </select>
                          </strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add Plan Name </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input name="planname" id="planname" value=" <?php echo $res1planname ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
						<input type="hidden" name="plancondition" id="plancondition" value="">
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                            <select name="planstatus" id="planstatus">
                              <option <?php if(($res1planstatus == "OP+IP")||($res1planstatus == "op+ip")){echo "selected";}?> value="op+ip" >OP+IP</option>
                              <option <?php if(($res1planstatus == "OP")||($res1planstatus == "op")){echo "selected";}?> value="op" >OP</option>
                              <option <?php if(($res1planstatus == "IP")||($res1planstatus == "ip")){echo "selected";}?> value="ip" >IP</option>
                            </select>
                          </strong></td>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Limit Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                            <select name="limitstatus" id="limitstatus" onChange="functionlimit(this.value)">
                              <option value="" selected="selected">Select Limit</option>
                              <option <?php if($res1overalllimitop != 0){echo "selected";}?> value="overall" >Overall</option>
                              <option <?php if($res1opvisitlimit !=0){echo "selected";}?> value="visit" >Visit</option>
                            </select>
                          </strong></td>
                        </tr>
                        <!--					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Plan Condition </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                          <select name="plancondition" id="plancondition">
                            <?php
				if ($plancondition == '')
				{
					echo '<option value="" selected="selected">Select Plan Condition</option>';
				}
				else
				{
					$query51 = "select * from master_plancondition where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51plancondition = $res51["plancondition"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51plancondition.'" selected="selected">'.$res51plancondition.'</option>';
				}
				
				$query5 = "select * from master_plancondition where recordstatus = '' order by plancondition";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5plancondition = $res5["plancondition"];
				?>
                            <option value="<?php echo $res5plancondition; ?>"><?php echo $res5plancondition; ?></option>
                            <?php
				}
				?>
                          </select>
                        </strong></td>
                      </tr>
-->
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Copay Amount </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><input name="planfixedamount" id="planfixedamount" style="text-transform:uppercase;" size="10" value="<?php echo $res1planfixedamount;?>" onKeyDown="return numbervaild(event)"/></td>						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">eClaim</div></td>
                           <!--<input type="checkbox" name="smart" <?php if($res1smartap ==1){echo "checked";}?> value="1">-->
						  
						  
						  <td align="left" valign="top"   bgcolor="#FFFFFF"> 
						  <select name="smart" id="smart">
						  <option value="0">Not Applicable</option>
						  <!--<option value="1" <?php //if($res1smartap ==1) echo "selected"; else echo ""; ?>>Smart</option><option value="2" <?php //if($res1smartap ==2) echo "selected"; else echo ""; ?>>Slade</option><option value="3" <?php //if($res1smartap ==3) echo "selected"; else echo ""; ?>>Smart+Slade</option>--></select>
						  </td>
						  
						  
						  </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Copay Percentage </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="planpercentage" id="planpercentage" style="text-transform:uppercase;" size="10"  value="<?php echo $res1planpercentage ?>" onKeyDown="return numbervaild(event)"/></td>
                           <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">All</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF">
                            <input type="checkbox" name="forall" id="forall" <?php if($res1forall =="yes"){echo "checked";}?> value="yes"></td>
                        </tr>
                        <tr>
                        	<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department Limit</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF" colspan="3">
                            <input type="checkbox" name="dptlimit" id="dptlimit" value="yes" <?php if($res1dptlimit == 'yes'){echo "checked";}?> onclick="disablecopay()"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Pharmacy Limit</div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="pharmacylimit" id="pharmacylimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" <?php if($res1dptlimit != 'yes'){echo 'disabled="disabled"';}?> value=<?php if($res1dptlimit == 'yes'){ echo $res1pharmacylimit; } ?> ></td>
                           <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Lab Limit</div></td>
                          	<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="lablimit" id="lablimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" <?php if($res1dptlimit != 'yes'){echo 'disabled="disabled"';}?> value=<?php if($res1dptlimit == 'yes'){ echo $res1lablimit; } ?> ></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Radiology Limit</div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="radiologylimit" id="radiologylimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" <?php if($res1dptlimit != 'yes'){echo 'disabled="disabled"';}?> value=<?php if($res1dptlimit == 'yes'){ echo $res1radiologylimit; } ?> ></td>
                           	<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Services Limit</div></td>
                          	<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="serviceslimit" id="serviceslimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" <?php if($res1dptlimit != 'yes'){echo 'disabled="disabled"';}?> value=<?php if($res1dptlimit == 'yes'){ echo $res1serviceslimit; } ?> ></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall OP Limit </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="overalllimitop" type="text" id="overalllimitop" style="text-transform:uppercase;" size="10" onKeyDown="return numbervaild(event)" value="<?php echo $res1overalllimitop;?>">
                          </label></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall IP Limit </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="overalllimitip" type="text" id="overalllimitip" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $res1overalllimitip;?>">
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit OP Limit </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="opvisitlimit" type="text" id="opvisitlimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $res1opvisitlimit;?>">
                          </label></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="ipvisitlimit" type="text" id="ipvisitlimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $res1ipvisitlimit;?>">
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Family Plan Limits </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input type="checkbox" name="planapplicable" value="1" <?php if($planapplicable == '1'){ echo "checked"; } ?>>
                          </label></td>
                          <td align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">Latest Edited By</td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF">   <input name="edited_username" type="text" id="edited_username" style="text-transform:uppercase;" size="15"  value="<?php echo $edited_username;?>" readonly></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Start Date </div></td>
                          <td align="left" valign="top"  colspan="1" bgcolor="#FFFFFF"><input type="text" name="planstartdate" id="planstartdate" value="<?php echo $res1planstartdate; ?>"  onFocus="return funcexpiry();" readonly >
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planstartdate')" style="cursor:pointer"/></span></strong></td>
							                          <td align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">Latest Edited DateTime</td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF">   <input name="edited_recorddate" type="text" id="edited_recorddate" style="text-transform:uppercase;" size="15"  value="<?php echo $edited_recorddate;?>" readonly></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Validity End </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input type="text" name="planexpirydate" id="planexpirydate" value="<?php echo $res1planexpirydate; ?>"  onFocus="return funcexpiry();" readonly>
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planexpirydate')" style="cursor:pointer"/></span></strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Status </div></td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><label>
                            <select name="recordstatus" id="recordstatus" style="border: 1px solid #001E6A;">
	                       <?php
						if ($res1recordstatus == '')
						{
						echo '<option value="" selected="selected">Select Account Status</option>';
						}
						else
						{
						echo '<option value="'.$res1recordstatus.'" selected="selected">'.$res1recordstatus.'</option>';
						}
						?>
						<option value="ACTIVE">ACTIVE</option>
						<option value="DELETED">INACTIVE</option>
                        </select>
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Exclusions </div></td>
                          <td align="left" valign="top"  colspan="3" bgcolor="#FFFFFF"><label>
                            <textarea name="exclusions" id="exclusions" style="text-transform:uppercase;" value="" rows="3"><?php echo $res1exclusions;?></textarea>
                          </label></td>
                        </tr>
                        <tr>
                          <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                          <td width="58%" align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="submit" name="Submit" value="Submit" /></td>
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