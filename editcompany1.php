<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
//Variable Declaration
$errmsg = "";

if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if ($companyanum == '') header ("location:addcompany1.php");

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == "frmflag1")
{
	
	//get dispensing here
	$dispensing=isset($_REQUEST['dispensing'])?$_REQUEST['dispensing']:'';
	//get dispensing ends here
	$companycode = $_REQUEST["companycode"];
	$companyname = $_REQUEST["companyname"];
	$employername = $_REQUEST["employername"];
	//$companyname = strtoupper($companyname);
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$nssfnumber = $_REQUEST["nssfnumber"];
	$nhifnumber  = $_REQUEST["nhifnumber"];
	$city  = $_REQUEST["city"];
	$state = $_REQUEST["state"];
	$country = $_REQUEST["country"];
	$pincode = $_REQUEST["pincode"];
	$pinnumber = $_REQUEST["pinnumber"];
	$helbnumber = $_REQUEST["helbnumber"];
	$registrationfees = $_REQUEST["registrationfees"];
	
	//$companystatus  = $_REQUEST["companystatus"];
	$companystatus = 'Active'; 
	/*$currencyname = $_REQUEST["currencyname"];
	$currencydecimalname = $_REQUEST["currencydecimalname"];
	$currencycode = $_REQUEST["currencycode"];
	$patientcodeprefix = $_REQUEST["patientcodeprefix"];
	$patientcodeprefix = strtoupper($patientcodeprefix);
	$visitcodeprefix = $_REQUEST["visitcodeprefix"];
	$visitcodeprefix = strtoupper($visitcodeprefix);
	$pharmbillnumberprefix = $_REQUEST["pharmbillprefix"];
	$pharmbillnumberprefix = strtoupper($pharmbillnumberprefix);
	 $radbillnumberprefix = $_REQUEST["radiologybillprefix"];
	  $radbillnumberprefix = strtoupper( $radbillnumberprefix);
	 $labbillnumberprefix = $_REQUEST["labbilleprefix"];
	  $labbillnumberprefix = strtoupper( $labbillnumberprefix);
	  $serbillnumberprefix = $_REQUEST["servicebillprefix"];
	  $serbillnumberprefix = strtoupper($serbillnumberprefix);
	 $refbillnumberprefix = $_REQUEST["referalbillprefix"];
	 $refbillnumberprefix = strtoupper($refbillnumberprefix);
	  $paylaterbillprefix=$_REQUEST['paylaterbillprefix'];
	 $paylaterbillprefix=strtoupper($paylaterbillprefix);
	 $labrefnoprefix=$_REQUEST['labrefprefix'];
	 $labrefnoprefix=strtoupper($labrefnoprefix);
	 $radrefnumber=$_REQUEST['radrefprefix'];
	 $radrefnumber=strtoupper($radrefnumber);
	 $serrefnumber=$_REQUEST['serrefprefix'];
	 $serrefnumber=strtoupper($serrefnumber);
	  $refrefnumber=$_REQUEST['refrefprefix'];
	 $refrefnumber=strtoupper($refrefnumber);
$pharefnumber=$_REQUEST['pharefprefix'];
	 $pharefnumber=strtoupper($pharefnumber);
$paynowprefix=$_REQUEST['paynowprefix'];
$paynowprefix=strtoupper($paynowprefix);
$paynowrefundprefix=$_REQUEST['paynowrefundprefix'];
$paynowrefundprefix=strtoupper($paynowrefundprefix);*/
	$showlogo = $_REQUEST["showlogo"];
	$pharmacyformula = $_REQUEST["pharmacyformula"];
	$store = $_REQUEST["store"];
	$ip_req_store = $_REQUEST["ip_req_store"];


	$nhifrebates = $_REQUEST["nhifrebate"];
	$nhifrebates2 = $_REQUEST["nhifrebate2"];
	$nhifrebates3 = $_REQUEST["nhifrebate3"];
	$nhifrebates4 = $_REQUEST["nhifrebate4"];
	$ipadmissionfees = $_REQUEST['ipadmissionfees'];
		$ipvisitcodeprefix = $_REQUEST['ipvisitcodeprefix'];
		$creditipadmissionfees = $_REQUEST['creditipadmissionfees'];
		$incometax = $_REQUEST['incometax'];
		$shownostockitems = isset($_POST["nostock"])? 'Yes' : 'NO';
	$dateposted = $updatedatetime;
	    
		$resetPsw = $_REQUEST['resetPsw'];

		 $query201 = "INSERT INTO audit_master_company (`companycode`, `companyname`, `address1`, `address2`, `area`, `city`, `state`, `country`, `pincode`, `phonenumber1`, `phonenumber2`, `nssfnumber`, `nhifnumber`, `emailid1`, `emailid2`, `pinnumber`, `helbnumber`, `dateposted`, `companystatus`, `currencyname`, `currencydecimalname`, `currencycode`, `stockmanagement`, `patientcodeprefix`, `visitcodeprefix`, `pharmacyprefix`, `labprefix`, `radiologyprefix`, `serviceprefix`, `referalprefix`, `consultationprefix`, `paylaterbillprefix`, `labrefnoprefix`, `radrefnoprefix`, `serrefnoprefix`, `refrefnoprefix`, `pharefnoprefix`, `paynowbillnoprefix`, `paynowrefundprefix`, `dispensing`, `showlogo`, `nhifrebate`, `nhifrebate2`, `nhifrebate3`, `nhifrebate4`, `ipadmissionfees`, `creditipadmissionfees`, `ipvisitcodeprefix`, `incometax`, `shownostockitems`, `locationname`, `locationcode`, `registrationfees`, `pharmacyformula`, `store`, `ip_req_store`, `pswResetDays`, `mpesa_integration`, `mpesa_url`, `mpesa_secret`, `barclayscard_integration`, `barclayscard_url`, `barclays_secret`, `retainedearning_ledger`, `lastupdate_time`, `lastupdate_user`, `lastupdate_ip`)  SELECT `companycode`, `companyname`, `address1`, `address2`, `area`, `city`, `state`, `country`, `pincode`, `phonenumber1`, `phonenumber2`, `nssfnumber`, `nhifnumber`, `emailid1`, `emailid2`, `pinnumber`, `helbnumber`, `dateposted`, `companystatus`, `currencyname`, `currencydecimalname`, `currencycode`, `stockmanagement`, `patientcodeprefix`, `visitcodeprefix`, `pharmacyprefix`, `labprefix`, `radiologyprefix`, `serviceprefix`, `referalprefix`, `consultationprefix`, `paylaterbillprefix`, `labrefnoprefix`, `radrefnoprefix`, `serrefnoprefix`, `refrefnoprefix`, `pharefnoprefix`, `paynowbillnoprefix`, `paynowrefundprefix`, `dispensing`, `showlogo`, `nhifrebate`, `nhifrebate2`, `nhifrebate3`, `nhifrebate4`, `ipadmissionfees`, `creditipadmissionfees`, `ipvisitcodeprefix`, `incometax`, `shownostockitems`, `locationname`, `locationcode`, `registrationfees`, `pharmacyformula`, `store`, `ip_req_store`, `pswResetDays`, `mpesa_integration`, `mpesa_url`, `mpesa_secret`, `barclayscard_integration`, `barclayscard_url`, `barclays_secret`, `retainedearning_ledger`, `lastupdate_time`, `lastupdate_user`, `lastupdate_ip` FROM master_company where auto_number = '$companyanum'";
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201);

		$query1 = "UPDATE master_company set dispensing='".$dispensing."', companyname = '$companyname', employername='$employername', shownostockitems = '$shownostockitems',
		phonenumber1 = '$phonenumber1', phonenumber2 = '$phonenumber2', emailid1 = '$emailid1', 
		emailid2 = '$emailid2', nssfnumber = '$nssfnumber', nhifnumber = '$nhifnumber', 
		address1 = '$address1', address2 = '$address2', area = '$area', city = '$city', state = '$state',  pharmacyformula = '$pharmacyformula',store = '$store', ip_req_store='$ip_req_store', pincode = '$pincode', 
		companystatus = '$companystatus', pinnumber = '$pinnumber', helbnumber = '$helbnumber', 
		showlogo = '$showlogo',nhifrebate='$nhifrebates',nhifrebate2='$nhifrebates2',nhifrebate3='$nhifrebates3',nhifrebate4='$nhifrebates4',ipadmissionfees='$ipadmissionfees',registrationfees = '$registrationfees',ipvisitcodeprefix='$ipvisitcodeprefix',creditipadmissionfees='$creditipadmissionfees',incometax='$incometax',pswResetDays='$resetPsw',lastupdate_ip='$ipaddress',lastupdate_time='$updatedatetime',lastupdate_user='$username' where auto_number = '$companyanum'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		/* $query78 = "update master_location set locationname = '$companyname', address1 = '$address1', address2 = '$address2',phone = '$phonenumber1', email = '$emailid1' where locationcode = 'LTC-1'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"])); */
			
		$errmsg = "Success. Hospital Details Updated.";

		//header('location: editcompany1.php?anum=1');
		
		$companycode = $_REQUEST["companycode"];
		$companyname = $_REQUEST["companyname"];
		$employername = $_REQUEST["employername"];
		//$companyname = strtoupper($companyname);
		$address1 = $_REQUEST["address1"];
		$address2 = $_REQUEST["address2"];
		$area = $_REQUEST["area"];
		$phonenumber1 = $_REQUEST["phonenumber1"];
		$phonenumber2 = $_REQUEST["phonenumber2"];
		$emailid1  = $_REQUEST["emailid1"];
		$emailid2 = $_REQUEST["emailid2"];
		$nssfnumber = $_REQUEST["nssfnumber"];
		$nhifnumber  = $_REQUEST["nhifnumber"];
		$city  = $_REQUEST["city"];
		$state = $_REQUEST["state"];
		$country = $_REQUEST["country"];
		$pincode = $_REQUEST["pincode"];
		$pinnumber = $_REQUEST["pinnumber"];
		$helbnumber = $_REQUEST["helbnumber"];
		$dateposted = $updatedatetime;
		/*$currencyname = $_REQUEST["currencyname"];
		$currencydecimalname = $_REQUEST["currencydecimalname"];
		$currencycode = $_REQUEST["currencycode"];
		$patientcodeprefix = $_REQUEST["patientcodeprefix"];
		$visitcodeprefix = $_REQUEST["visitcodeprefix"];
		$showlogo = $_REQUEST["showlogo"];
		$radrefnoprefix=$_REQUEST['radrefprefix'];
		$serrefnoprefix=$_REQUEST['serrefprefix'];
		$refrefnoprefix=$_REQUEST['refrefprefix'];
		$pharefnoprefix=$_REQUEST['pharefprefix'];
		$paylaterbillnumberprefix=$_REQUEST['paylaterbillprefix'];
		$paynowbillnoprefix=$_REQUEST['paynowprefix'];
		$paynowrefundprefix=$_REQUEST['paynowrefundprefix'];*/
		$nhifrebate = $_REQUEST['nhifrebate'];
		$nhifrebate2 = number_format($_REQUEST['nhifrebate2'],2,'.','');
		$nhifrebate3 = number_format($_REQUEST['nhifrebate3'],2,'.','');
		$nhifrebate4 = number_format($_REQUEST['nhifrebate4'],2,'.','');
		$ipadmissionfees = $_REQUEST['ipadmissionfees'];
			$ipvisitcodeprefix = $_REQUEST['ipvisitcodeprefix'];
		$showcity = $city;
		$creditipadmissionfees = $_REQUEST['creditipadmissionfees'];
		$registrationfees = $_REQUEST['registrationfees'];
		$incometax = $_REQUEST['incometax'];
		$stocks = isset($_POST["nostock"])? 'Yes' : 'NO';
		$pswResetDays= $_REQUEST['resetPsw'];

}
else
{
	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	
	$companycode = $res6["companycode"];
	$companyname = $res6["companyname"];
	$employername = $res6["employername"];
	
	//$companyname = strtoupper($companyname);
	$address1 = $res6["address1"];
	$address2 = $res6["address2"];
	$area = $res6["area"];
	$phonenumber1 = $res6["phonenumber1"];
	$phonenumber2 = $res6["phonenumber2"];
	$emailid1  = $res6["emailid1"];
	$emailid2 = $res6["emailid2"];
	$nssfnumber = $res6["nssfnumber"];
	$nhifnumber  = $res6["nhifnumber"];
	$city  = $res6["city"];
	$state = $res6["state"];
	$country = $res6["country"];
	$pincode = $res6["pincode"];
	$pinnumber = $res6["pinnumber"];
	$helbnumber = $res6["helbnumber"];
	$companystatus  = $res6["companystatus"];
	$dateposted = $res6["dateposted"];
	$currencyname = $res6["currencyname"];
	$currencydecimalname = $res6["currencydecimalname"];
	$currencycode = $res6["currencycode"];
	$stockmanagement = $res6["stockmanagement"];
	$patientcodeprefix = $res6['patientcodeprefix'];
	$visitcodeprefix = $res6['visitcodeprefix'];
	$pharmbillnumberprefix=$res6['pharmacyprefix'];
	 $radbillnumberprefix=$res6['radiologyprefix'];
	 $labbillnumberprefix=$res6['labprefix'];
	 $serbillnumberprefix=$res6['serviceprefix'];
	 $refbillnumberprefix=$res6['referalprefix'];
	 $paylaterbillnumberprefix=$res6['paylaterbillprefix'];
	 $labrefnoprefix=$res6['labrefnoprefix'];
	 $radrefnoprefix=$res6['radrefnoprefix'];
	 $serrefnoprefix=$res6['serrefnoprefix'];
	  $refrefnoprefix=$res6['refrefnoprefix'];
	  $pharefnoprefix=$res6['pharefnoprefix'];
	  $paynowbillnoprefix=$res6['paynowbillnoprefix'];
	  $paynowrefundprefix=$res6['paynowrefundprefix'];
	$showlogo = $res6['showlogo'];
	$pharmacyformula = $res6['pharmacyformula'];
	$store_fetch = $res6['store'];
	$ip_req_store_fetch = $res6['ip_req_store'];

	$nhifrebate = $res6['nhifrebate'];
	$nhifrebate2 = $res6['nhifrebate2'];
	$nhifrebate3 = $res6['nhifrebate3'];
	$nhifrebate4 = $res6['nhifrebate4'];
	$ipadmissionfees = $res6['ipadmissionfees'];
	$ipvisitcodeprefix = $res6['ipvisitcodeprefix'];
	$creditipadmissionfees = $res6['creditipadmissionfees'];
	$registrationfees = $res6['registrationfees'];
	$showcity = $city;
	$incometax = $res6['incometax'];
	$stocks = $res6['shownostockitems'];
	$dispensing=$res6['dispensing'];

	$pswResetDays=$res6['pswResetDays'];
	
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
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">



</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="css/autocomplete.css" rel="stylesheet"/>
</head>
<script language="javascript">
$(document).ready(function(){
	
	$('.allowdecimal').keypress(function (event) {
	    return isNumber(event, this)
	});

});
function isNumber(evt, element) {

    var charCode = (evt.which) ? evt.which : event.keyCode

    if (
        //(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
        (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
        (charCode < 48 || charCode > 57))
        return false;

    return true;
} 
function disableEnterKey()
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


function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
	<?php
	$query11 = "select * from master_state group by state order by state";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$statename = $res11["state"];
	?>
		if(document.form1.state.value=="<?php echo $statename; ?>")
		{
		document.getElementById("city").options.length=null; 
		var combo = document.getElementById('city'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select City", ""); 
		<?php
		$query10="select * from master_city where state = '$statename' group by city order by city asc";
		$exec10=mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10=mysqli_fetch_array($exec10))
		{
		$loopcount=$loopcount+1;
		$city1=$res10["city"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $city;?>", "<?php echo $city;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
}


function from1submit1()
{

	if (document.form1.companyname.value == "")
	{
		alert ("Hospital Name Cannot Be Empty.");
		document.form1.companyname.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		//alert ("City Cannot Be Empty.");
		//document.form1.city.focus();
		//return false;
	}
	else if (document.form1.state.value == "")
	{
		//alert ("State Cannot Be Empty.");
		//document.form1.state.focus();
		//return false;
	}
	else if (document.form1.pharmacyformula.value == "")
	{
		alert ("Pharmacy Formula Cannot Be Empty.");
		document.form1.pharmacyformula.focus();
		return false;
	}
	else if (document.form1.patientcodeprefix.value == "") 
	{
		alert ("Please Enter Patient Code Prefix.");
		document.form1.patientcodeprefix.focus();
		return false;
	}
	else if (document.form1.visitcodeprefix.value == "") 
	{
		alert ("Please Enter Visit Number Prefix.");
		document.form1.visitcodeprefix.focus();
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
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

</script>
<SCRIPT LANGUAGE="Javascript" SRC="js/ColorPicker2.js"></SCRIPT>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top">


      <form name="form1" id="form1" method="post" action="editcompany1.php?anum=<?php echo $companyanum; ?>" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Hospital - Update </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <tr>
                <td width="21%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Hospital Name   *</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="companyname" id="companyname" value="<?php echo $companyname; ?>" onKeyDown="return disableEnterKey()" size="60"></td>
              </tr>
              <tr>
                <td width="21%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Employer Name   *</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="employername" id="employername" value="<?php echo $employername; ?>" onKeyDown="return disableEnterKey()" size="60"></td>
              </tr>              
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 1 </td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="address1" id="address1" value="<?php echo $address1; ?>" onKeyDown="return disableEnterKey()" size="60" /></td>
              </tr>
				<tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Address 2 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="address2" id="address2" value="<?php echo $address2; ?>" onKeyDown="return disableEnterKey()" size="40" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Area / Location </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="area" id="area" value="<?php echo $area; ?>" size="20" /></td>
				</tr><tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">County * </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="state" id="state" value="<?php echo $state; ?>" size="20" />			</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">City * </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="city" id="city" value="<?php echo $city; ?>" size="20" />			</td>
                </tr>
				  <tr>
			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Post Box  </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="pincode" id="pincode" value="<?php echo $pincode; ?>" onKeyDown="return disableEnterKey()" size="30" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Country </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="country" id="country" value="<?php echo $country; ?>" size="20" />				</td>
				  </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 1 </td>
                <td width="31%" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" onKeyDown="return disableEnterKey()" size="20" />                </td>
                <td width="20%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone Number 2 </td>
                <td width="28%" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
              </tr>
             
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NSSF Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="nssfnumber" id="nssfnumber" value="<?php echo $nssfnumber; ?>" onKeyDown="return disableEnterKey()" size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="nhifnumber" id="nhifnumber" value="<?php echo $nhifnumber; ?>" onKeyDown="return disableEnterKey()" size="20" /></td>
              </tr>
               <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 1 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Email Id 2 </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
              </tr>
                
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">PIN Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="pinnumber" id="pinnumber" value="<?php echo $pinnumber; ?>" size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">HELB Number </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="helbnumber" id="helbnumber" value="<?php echo $helbnumber; ?>" size="20" /></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <!--<tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Currency  Name </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="currencyname" id="currencyname" value="<?php echo $currencyname; ?>" size="10" />
                    <span class="bodytext3">* Ex: Rupees</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Currency  Decimal Name </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="currencydecimalname" id="currencydecimalname" value="<?php echo $currencydecimalname; ?>" size="10" />
                    <span class="bodytext3">* Ex: Paise / Cent </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Currency  Code </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="currencycode" id="currencycode" value="<?php echo $currencycode; ?>" style="text-transform: uppercase;"  size="10" />
                    <span class="bodytext3">* Ex: INR</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Code Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="patientcodeprefix" id="patientcodeprefix" value="<?php echo $patientcodeprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Paylater Bill No Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="paylaterbillprefix" id="paylaterbillprefix" value="<?php echo  $paylaterbillnumberprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Visit Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="visitcodeprefix" id="visitcodeprefix" value="<?php echo $visitcodeprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Lab Ref No Prefix</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="labrefprefix" id="labrefprefix" value="<?php echo $labrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Pharmacy Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="pharmbillprefix" id="pharmbillprefix" value="<?php echo $pharmbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
				
				   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Radiology Ref No Prefix</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="radrefprefix" id="radrefprefix" value="<?php echo $radrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Radiology Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="radiologybillprefix" id="radiologybillprefix" value="<?php echo $radbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Service Ref No Prefix</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="serrefprefix" id="serrefprefix" value="<?php echo $serrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Lab Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="labbilleprefix" id="labbillprefix" value="<?php echo $labbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
				 <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Referal Ref No</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
					<input name="refrefprefix" id="refrefprefix" value="<?php echo $refrefnoprefix; ?>" size="10" />
				 <span class="bodytext3">* Ex: ABC </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Service Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="servicebillprefix" id="servicebillprefix" value="<?php echo $serbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Pharmacy Ref No</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="pharefprefix" id="pharefprefix" value="<?php echo  $pharefnoprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
				
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Referal Bill Number Prefix </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="referalbillprefix" id="referalbillprefix" value="<?php echo $refbillnumberprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
              </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">PayNow Bill No Prefix</td>
             <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="paynowprefix" id="paynowprefix" value="<?php echo  $paynowbillnoprefix; ?>" size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">PayNow Refund Bill Number Prefix</td>
             <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="paynowrefundprefix" id="paynowrefundprefix" value="<?php echo  $paynowrefundprefix; ?>"  size="10" />
                    <span class="bodytext3">* Ex: ABC </span></td>
		
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Show Medicines if No Stock</td>
             <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input type="checkbox" name="nostock" id="nostock" size="10" <?php if($stocks == 'Yes') echo "checked" ?>/>
                    <span class="bodytext3"></span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Dispensing Fee</td>
             <td align="left" valign="middle"  bgcolor="#ecf0f5">
             <input type="text" name="dispensing" onKeyDown="return numbervaild(event)" value="<?php echo $dispensing;?>">
				</td>
		
				</tr>-->
				
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Date Last Updated </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="dateposted" id="dateposted" value="<?php echo $dateposted; ?>" onKeyDown="return disableEnterKey()"size="20"  readonly="readonly" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Hospital Code   *</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="companycode" id="companycode" value="<?php echo $companycode; ?>" readonly style="text-transform: uppercase;" size="20"></td>
              </tr>
              
              <tr>
                <td align="middle"  bgcolor="#ecf0f5"><div align="left"><span class="bodytext3">Show Logo </span></div></td>
                <td align="middle"  bgcolor="#ecf0f5">
				  <div align="left">
				    <select name="showlogo" id="showlogo" >
				      <?php
					if ($showlogo != '')
					{
					?>
				      <option value="<?php echo $showlogo; ?>" selected="selected"><?php echo $showlogo; ?></option>
				      <?php
					}
					else
					{
					?>
				      <option value="HIDE LOGO" selected="selected">HIDE LOGO</option>
				      <?php
					}
					?>
				      <option value="SHOW LOGO">SHOW LOGO</option>
				      <option value="HIDE LOGO">HIDE LOGO</option>
				      </select>
				      </div></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate</td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input class="allowdecimal" type="text" name="nhifrebate" id="nhifrebate" value="<?php echo $nhifrebate; ?>"> </td>
                
              </tr>
              <tr><td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate2</td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" class="allowdecimal" name="nhifrebate2" id="nhifrebate2" value="<?php echo $nhifrebate2; ?>"> </td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate3</td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input class="allowdecimal" type="text" name="nhifrebate3" id="nhifrebate3" value="<?php echo $nhifrebate3; ?>"> </td>

                
           </tr>
           <tr>
           	<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate4</td>
               <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input class="allowdecimal" type="text" name="nhifrebate4" id="nhifrebate4" value="<?php echo $nhifrebate4; ?>"> </td>
           </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">IP Admission Fees </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="ipadmissionfees" id="ipadmissionfees" value="<?php echo $ipadmissionfees; ?>" size="20"/></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">IP Visit Code Prefix</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="ipvisitcodeprefix" id="ipvisitcodeprefix" value="<?php echo $ipvisitcodeprefix; ?>"></td>
              </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> Registration Fees</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="registrationfees" id="registrationfees" value="<?php echo number_format($registrationfees,2,'.','');?>" size="20"/> </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Credit IP Admn Fees </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="creditipadmissionfees" id="creditipadmissionfees" value="<?php echo $creditipadmissionfees; ?>" size="20"/></td>
              </tr>
			  
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Income Tax</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="incometax" id="incometax" value="<?php echo $incometax; ?>"></td>
				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Force Reset Psw </td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5">
				    <?php
					$exp_day = array("0","1","2","3","5","7","10","15","20","30","60","90","120","365");
					?>
                     <select name="resetPsw" id="resetPsw" >
					  <?php
					  foreach($exp_day as $keys) {
					  ?>
					   <option value="<?php echo $keys ; ?>" <?php if($pswResetDays==$keys) { ?>selected="selected" <?php } ?>><?php echo $keys ; ?></option> 
					  <?php } ?>
					 </select> &nbsp; <span class="bodytext3"> Days (0 - No Expiry) </span>
                </td>
				
              </tr>
			  
			  <tr>
			  	<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">Pharmacy Formula *</span></td>
			  	<td align="left" valign="middle"  bgcolor="#ecf0f5">
			  		<span class="bodytext3">
			  			<select name="pharmacyformula" id="pharmacyformula" >
							  <option value="" <?php if($pharmacyformula != '1' && $pharmacyformula != '2'){echo 'selected="selected"';}?>>Select Pharmacy Formula</option>
						      <option value="1" <?php if($pharmacyformula == '1'){echo 'selected="selected"';}?>>Fixed</option>
						      <option value="2" <?php if($pharmacyformula == '2'){echo 'selected="selected"';}?>>Margin</option>
					      </select>
			  		</span>
			  	</td>

			  	<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">GRN Default Store*</span></td>
			  	<td align="left" valign="middle"  bgcolor="#ecf0f5">
			  		<span class="bodytext3">
			  			<select name="store" id="Store" >
							 <option value=""> Select Store</option>
                 <?php
				$query5 = "SELECT * from master_store order by store asc ";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$storeanum = $res5['auto_number'];
				$store = $res5["store"];
				$storecode = $res5['storecode'];
				?>
                  <option value="<?php echo $storeanum; ?>"  <?php if($store_fetch == $storeanum){echo 'selected="selected"';}?>><?php echo $store; ?></option>
                  <?php
				}
				?>
			  		</span>
			  	</td>
                <!-- <td colspan="2" align="middle"  bgcolor="#ecf0f5">&nbsp;</td> -->
              </tr>

              <tr>

			  	<td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">IP Med Request Store*</span></td>
			  	<td align="left" valign="middle"  bgcolor="#ecf0f5">
			  		<span class="bodytext3">
			  			<select name="ip_req_store" id="ip_req_store" >
							 <option value=""> Select Store</option>
                 <?php
				$query5 = "SELECT * from master_store order by store asc ";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$storeanum = $res5['auto_number'];
				$store = $res5["store"];
				$storecode = $res5['storecode'];
				?>
                  <option value="<?php echo $storecode; ?>"  <?php if($ip_req_store_fetch == $storecode){echo 'selected="selected"';}?>><?php echo $store; ?></option>
                  <?php
				}
				?>
			  		</span>
			  	</td>
                <td colspan="2" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>

              <tr>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
                  <input name="Submit222" type="submit"  value="Save Hospital" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

