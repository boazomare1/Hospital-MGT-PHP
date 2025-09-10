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

$multicostcenters = array();

if ($frmflag1 == 'frmflag1')

{

	$accountnameanum = $_REQUEST['accountnameanum'];

	$accountname = $_REQUEST["accountname"];

	$accountname = strtoupper($accountname);

	$accountname = trim($accountname);

	$length=strlen($accountname);

	$paymenttype = $_REQUEST['paymenttype'];

	$subtype = $_REQUEST['subtype'];

	$expirydate = $_REQUEST['expirydate'];

	$recordstatus = $_REQUEST['recordstatus'];

	$address = $_REQUEST['address'];

	 $accountsmaintype = $_REQUEST['accountsmain'];

	$accountssub = $_REQUEST['accountssub'];

	$openingbalancecreditnew = $_REQUEST['openingbalancecredit'];

	$openingbalancedebitnew = $_REQUEST['openingbalancedebit'];
	$is_receivable = $_REQUEST['is_receivable'];

	$id = $_REQUEST['id'];

	$contact = $_REQUEST['contact'];

	$phone = trim($_REQUEST['phone']);

	$locationcode = $_REQUEST['location'];

	$currency = $_REQUEST['currency'];

	$fxrate = $_REQUEST['fxrate'];

	$misreport = $_REQUEST['misreport'];
	
	//exit;

	$iscapitation = $_REQUEST['iscapitation'];
	if(isset($_REQUEST['grnbackdate']))
	    $grnbackdate=$_REQUEST['grnbackdate'];
	else
		$grnbackdate='';
	/* if($accountsmaintype !=6){
		$cc_name = $_REQUEST['cc_name'];
	}
	else
	{
		
		$cc_name = "";
		if(isset($_REQUEST['costcenter']))
		{
			$costcenters_selected = $_REQUEST['costcenter'];
			
			if(count($costcenters_selected) > 0)
			{
				$cc_name = implode(',', $costcenters_selected);
			}
		}
	} */
	
	
	$capitationservicename = $_REQUEST['capitationservicename'];

	if($iscapitation!=0){ $capitationservicecode = $_REQUEST['capitationservicecode']; } else { $capitationservice = ""; }



	if($accountsmaintype =='' || $accountssub =='')

	{

	$errmsg = "Failed. Account Main and Account Sub Not selected properly.";

		header ("location:editaccountname1.php?bgcolorcode=success&&st=edit&&anum=$accountnameanum");

	}

	else

	{

	$query8 = "select * from master_location where locationcode = '$locationcode'";

	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res8 = mysqli_fetch_array($exec8);

	$locationname = $res8['locationname'];

	

	if ($length<=500)

	{

	$query2 = "select * from master_accountname where auto_number = '$accountnameanum'";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res2 = mysqli_num_rows($exec2);

	if ($res2 != 0)

	{

		//$query1 = "insert into master_accountname (accountname,recordstatus, paymenttype, subtype, expirydate, ipaddress, recorddate, username) 

		//values ('$accountname', '$recordstatus','$paymenttype', '$subtype', '$expirydate','$ipaddress', '$updatedatetime', '$username')";

		$query201 = "INSERT INTO audit_master_accountname ( `accountid`, `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `address`, `v1oldcode`, `misreport`, `mcc`, `iscapitation`, `serviceitemcode`, `phone`, `is_receivable`, `cost_center`) SELECT auto_number, `accountname`, `id`, `legacy_code`, `paymenttype`, `subtype`, `accountsmain`, `accountssub`, `openingbalancecredit`, `openingbalancedebit`, `currency`, `fxrate`, `recordstatus`, `expirydate`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `contact`, `username`, `address`, `v1oldcode`, `misreport`, `mcc`, `iscapitation`, `serviceitemcode`, `phone`, `is_receivable`, `cost_center`,`grn_backdate` FROM master_accountname where auto_number = '$accountnameanum'";
		$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201);

		

    	$query1 = "update master_accountname set accountname = '$accountname', recordstatus = '$recordstatus', 

		paymenttype = '$paymenttype', subtype = '$subtype', misreport = '$misreport', expirydate = '$expirydate', ipaddress = '$ipaddress', 

		recorddate = '$updatedatetime', username = '$username',address = '$address',openingbalancecredit = '$openingbalancecreditnew',openingbalancedebit = '$openingbalancedebitnew',accountsmain='$accountsmaintype',accountssub='$accountssub',id='$id', contact='$contact', locationcode='$locationcode', locationname='$locationname', currency='$currency', fxrate='$fxrate', iscapitation='$iscapitation', serviceitemcode='$capitationservicecode',phone='$phone', is_receivable='$is_receivable' , cost_center='$cc_name',grn_backdate='$grnbackdate' where auto_number = '$accountnameanum'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$errmsg = "Success. Account Name Updated.";

		//$bgcolorcode = 'success';

		header ("location:addaccountname1.php");

	}

	//exit();

	else

	{

		$errmsg = "Failed. Account Name Update Failed.";

		//$bgcolorcode = 'failed';

		header ("location:editaccountname1.php?bgcolorcode=success&&st=edit&&anum=$accountnameanum");

	}

	}

	else

	{

		$errmsg = "Failed. Only 500 Characters Are Allowed.";

		//$bgcolorcode = 'failed';

		header ("location:editaccountname1.php?bgcolorcode=success&&st=edit&&anum=$accountnameanum");

	}

}

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_accountname set recordstatus = 'DELETED' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'activate')

{

	$delanum = $_REQUEST["anum"];

	$query3 = "update master_accountname set recordstatus = 'ACTIVE' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'default')

{

	$delanum = $_REQUEST["anum"];

	$query4 = "update master_accountname set defaultstatus = '' where cstid='$custid' and cstname='$custname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));



	$query5 = "update master_accountname set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";

	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

}

if ($st == 'removedefault')

{

	$delanum = $_REQUEST["anum"];

	$query6 = "update master_accountname set defaultstatus = '' where auto_number = '$delanum'";

	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

}





if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }

if ($svccount == 'firstentry')

{

	$errmsg = "Please Add Account Name To Proceed For Billing.";

	$bgcolorcode = 'failed';

}



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

if ($st == 'edit' && $anum != '')

{

	$query1 = "select * from master_accountname where auto_number = '$anum'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1 = mysqli_fetch_array($exec1);

	$res1autonumber = $res1['auto_number'];

	$res1paymenttype = $res1['paymenttype'];

	$res1subtype = $res1['subtype'];

	$res1accountname = $res1['accountname'];

	$res1recordstatus = $res1['recordstatus'];

	$res1misreport = $res1['misreport'];

	$res1expirydate = $res1['expirydate'];

	$address = $res1['address'];

	$res1accountsmain = $res1['accountsmain'];

	$res1accountssub = $res1['accountssub'];

	$openingbalancecredit = $res1['openingbalancecredit'];

	$openingbalancedebit = $res1['openingbalancedebit'];

	$id = $res1['id'];

	$contact = $res1['contact'];

	$phone = $res1['phone'];

	$locationcode1 = $res1['locationcode'];

	$locationname1 = $res1['locationname'];

	$rescurrency = $res1['currency'];

	$fxrate = $res1['fxrate'];

	$editrecorddate = $res1['recorddate'];

	$editusername = $res1['username'];

	$editipaddress = $res1['ipaddress'];

	$iscapitation1 = $res1['iscapitation'];

	$serviceitemcode1 = $res1['serviceitemcode'];
	$is_receivable1 = $res1['is_receivable'];
	$grnbackdate1 = $res1['grn_backdate'];
	
	//$res1cost_center = $res1['cost_center'];

/* 
$query612 = "select * from master_costcenter where auto_number = '$res1cost_center' and recordstatus <> 'deleted'";

		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res612 = mysqli_fetch_array($exec612);

		$cost_center = $res612['name'];
 */



	if($res1accountssub == '16' || $res1accountssub == '17' || $res1accountssub == '18')

	{

		$classdis = "";

	}

	else

	{

		$classdis = "readonly";

	}

}





   

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }

if ($bgcolorcode == 'success')

{

		$errmsg = "Success. Account Name Updated.";

}

if ($bgcolorcode == 'failed')

{

		$errmsg = "Failed. Account Name Update Failed.";

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

</script>



<script src="js/datetimepicker_css.js"></script>



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

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

</head>

<script language="javascript">







function funcPaymentTypeChange1()

{

	<?php 

	$query12 = "select * from master_paymenttype where recordstatus = ''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12paymenttypeanum = $res12["auto_number"];

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





function funcexpiry()

{

	<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 

	$currentdate = date("Y/m/d",$date);

	?>

	var currentdate = "<?php echo $currentdate; ?>";

	var expirydate = document.getElementById("expirydate").value; 

	var currentdate = Date.parse(currentdate);

	var expirydate = Date.parse(expirydate);

	

	if (expirydate < currentdate)

	{

		alert("Please Select Correct Account Expiry Date");

		document.getElementById("expirydate").value = "";

		document.getElementById("expirydate").focus();

		return false;

	}

}



function funcAccountsMainTypeChange1()

{

	/*if(document.getElementById("paymenttype").value == "1")

	{

		alert("You Cannot Add Account For CASH Type");

		document.getElementById("paymenttype").focus();

		return false;

	}*/

	<?php 

	$query12 = "select * from master_accountsmain where recordstatus = ''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12accountsmainanum = $res12["auto_number"];

	$res12accountsmain = $res12["accountsmain"];

	?>

	if(document.getElementById("accountsmain").value=="<?php echo $res12accountsmainanum; ?>")

	{

		document.getElementById("accountssub").options.length=null; 

		var combo = document.getElementById('accountssub'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 

		<?php

		$query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10accountssubanum = $res10['auto_number'];

		$res10accountssub = $res10["accountssub"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 

		<?php 

		}

		?>

	}

	

	<?php

	}

	?>	

	if(document.getElementById("accountsmain").value == 6)
	{
		$('#non_multicc').hide();
		$('#multicc').show();
	}
	else
	{
		$('#non_multicc').show();
		$('#multicc').hide();
		$('#cc_name').val('');

	}
}



function SelCurrency(val)

{

	var val = val;

	<?php 

	$query1sub = "select * from master_subtype where recordstatus = ''";

	$exec1sub = mysqli_query($GLOBALS["___mysqli_ston"], $query1sub) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res1sub = mysqli_fetch_array($exec1sub))

	{

	$res1subanum = $res1sub["auto_number"];

	$res1subcurrency = $res1sub["currency"];

	$res1subfxrate = $res1sub["fxrate"];

	?>

	if(val =="<?php echo $res1subanum; ?>")

	{

		document.getElementById("currency").value = "<?php echo $res1subcurrency; ?>";

		document.getElementById("fxrate").value = "<?php echo $res1subfxrate; ?>";

	}

	<?php

	}

	?>

}



function funcDeleteAccountName1(varAccountNameAutoNumber)

{

	var varAccountNameAutoNumber = varAccountNameAutoNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete this account name '+varAccountNameAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Account Name Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Account Name Entry Delete Not Completed.");

		return false;

	}

	//return false;

}



function displayService() {

  // Get the checkbox

  var checkBox = document.getElementById("iscapitation");

  // Get the output text

  var text1 = document.getElementById("servtext");

  var text2 = document.getElementById("capitationservice");



  // If the checkbox is checked, display the output text

  if (checkBox.checked == true){

    text1.style.display = "block";

    text2.style.display = "block";

  } else {

    text1.style.display = "none";

    text2.style.display = "none";

  }

}



</script>

<script type="text/javascript">

function Process()

{

	/* if(document.getElementById("location").value=="")

	{

		alert('Select Location');

		document.getElementById("location").focus();

		return false;

	} */
	
	if(document.getElementById("accountsmain").value=="")

	{

		alert('Select Accounts Main');

		document.getElementById("accountsmain").focus();

		return false;

	}

	

	if(document.getElementById("accountssub").value=="")

	{

		alert('Select Accounts Sub');

		document.getElementById("accountssub").focus();

		return false;

	}
	
	
	if(document.getElementById("accountssub").value=="2")
	{

		
	
	if(document.getElementById("misreport").value=="0")

	 {

	 	alert('Select MIS Report');

	 	document.getElementById("misreport").focus();

	 	return false;

	 }
	 var checkBox = document.getElementById("iscapitation");

  // Get the output text

 //var text2 = document.getElementById("capitationservice");



  // If the checkbox is checked, display the output text

  if (checkBox.checked == true){

   if(document.getElementById("capitationservice").value=="")

	 {

	 	alert('Select Service');

	 	document.getElementById("capitationservice").focus();

	 	return false;

	 }

  } 
	}


	if(document.getElementById("id").value=="")

	{

		alert('Select Accounts');

		document.getElementById("id").focus();

		return false;

	}

	if(document.getElementById("accountname").value=="")

	{

		alert('Enter Accountname');

		document.getElementById("accountname").focus();

		return false;

	}

	// if(document.getElementById("misreport").value=="" || document.getElementById("misreport").value=="0")

	// {

	// 	alert('Select MIS Report');

	// 	document.getElementById("misreport").focus();

	// 	return false;

	// }
	
	if(confirm("Do You Want To Save The Record?")==false){
	   
		return false;
}

}

</script>



<script src="js/datetimepicker_css.js"></script>

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 



<script type="text/javascript">

	$(document).ready(function(e) {

	$('#capitationservice').autocomplete({

		

	source:"autosearchservices.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var itemname=ui.item.itemname;

			var itemcode=ui.item.itemcode;

			$("#capitationservicecode").val(itemcode);

			$("#capitationservicename").val(itemname);

			},

	});	

});

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

              <td><form name="form1" id="form1" method="post" action="editaccountname1.php" onSubmit="return Process()">

                  <table width="864" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Account Name Master - Edit </strong></td>

                      </tr>

					  <tr>

                        <td colspan="4" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Location</div></td>

                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF"><strong>

						<select name="location" id="location">

						<?php if($locationcode1 != '') { ?>

						<option value="<?php echo $locationcode1; ?>"><?php echo $locationname1; ?></option>

						<?php } ?>

						<option value="">Select Location</option>

						<?php

						$query50 = "select * from master_location where status <> 'deleted' order by locationname";

						$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res50 = mysqli_fetch_array($exec50))

						{

						$locationname = $res50["locationname"];

						$locationcode = $res50["locationcode"];

						?>

						<option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>

						<?php

						}

						?>

						</select>

                        </strong></td>

                        <td width="20%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">&nbsp;</div></td>

                        <td width="23%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Main Type </div></td>

                        <td width="31%" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                        <input type="hidden" name="accountsmain" id="accountsmain" value="<?php echo $res1accountsmain; ?>">
						<select name="accountsmain" id="accountsmain" disabled onChange="return funcAccountsMainTypeChange1()">

						<?php

						//*

						if ($res1accountsmain == '')

						{

						echo '<option value="" selected="selected">Select</option>';

						}

						else

						{

						$query4 = "select * from master_accountsmain where auto_number = '$res1accountsmain'";

						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res4 = mysqli_fetch_array($exec4);

						$res4accountsmain = $res4['auto_number'];

						$res4accountsmainname = $res4['accountsmain'];

					

						echo '<option value="'.$res4accountsmain.'" selected="selected">'.$res4accountsmainname.'</option>';

						}

						?>

						

						<?php

						$query5 = "select * from master_accountsmain where recordstatus = '' order by accountsmain";

						$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res5 = mysqli_fetch_array($exec5))

						{

						$res5anum = $res5["auto_number"];

						$res5accountsmain = $res5["accountsmain"];

						?>

						<option value="<?php echo $res5anum; ?>"><?php echo $res5accountsmain; ?></option>

						<?php

						}

						?>

						</select>

                        </strong></td>

                        <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>

                        <td width="20%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>
                        <input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $res1paymenttype; ?>">
						<select name="paymenttype" id="paymenttype" disabled onChange="return funcPaymentTypeChange1()">

						<?php

						//*

						if ($res1paymenttype == '')

						{

						echo '<option value="" selected="selected">Select Type</option>';

						}

						else

						{

						$query4 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";

						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res4 = mysqli_fetch_array($exec4);

						$res4dmaintypeanum = $res4['auto_number'];

						$res4maintypename = $res4['paymenttype'];

					

						echo '<option value="'.$res4dmaintypeanum.'" selected="selected">'.$res4maintypename.'</option>';

						}

					?>

					<option value="">Select Type</option>

					

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

                        </strong></td>

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Sub Type </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
<input type="hidden" name="accountssub" id="accountssub" value="<?php echo $res1accountssub; ?>">
                          <select name="accountssub" id="accountssub" disabled>

						<?php

						//*

						if ($res1accountssub == '')

						{

						echo '<option value="" selected="selected">Select </option>';

						}

						else

						{

						$query4 = "select * from master_accountssub where auto_number = '$res1accountssub'";

						$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res4 = mysqli_fetch_array($exec4);

						$res4accountssubanum = $res4['auto_number'];

						$res4accountssubname = $res4['accountssub'];

					

						echo '<option value="'.$res4accountssubanum.'" selected="selected">'.$res4accountssubname.'</option>';

						}

						//*/

						?>

                          </select>

                        </strong></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>
<input type="hidden" name="subtype" id="subtype" value="<?php echo $res1subtype; ?>">
                          <select name="subtype" id="subtype" disabled onChange="return SelCurrency(this.value);">

						<?php

						//*

						if ($res1subtype == '')

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

						

						?>

							<option value="">Select Sub Type</option>

                          </select>

                        </strong></td>

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ID</div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="id" id="id" value="<?php echo $id; ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>

                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Opg.Bal Dr</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" style="border: 1px solid #001E6A;" name="openingbalancedebit" id="openingbalancedebit" value="<?php echo $openingbalancedebit; ?>"></td>

                      </tr>

                      

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Account Name </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input name="accountname" id="accountname" value="<?php echo $res1accountname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>

                     <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Opg.Bal Cr</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" style="border: 1px solid #001E6A;" name="openingbalancecredit" id="openingbalancecredit" value="<?php echo $openingbalancecredit; ?>"></td>

                        </tr>

                      

                      <tr>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Status </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>

                          <select name="recordstatus" id="recordstatus" style="border: 1px solid #001E6A; text-transform:uppercase">

						<?php

						//*

						if ($res1recordstatus == '')

						{

						echo '<option value="" selected="selected">Select Account Status</option>';

						}

						else

						{

						echo '<option value="'.$res1recordstatus.'" selected="selected">'.$res1recordstatus.'</option>';

						}

						//*/

						?>

                            <option value="ACTIVE">ACTIVE</option>

                            <option value="DELETED">INACTIVE</option>

                          </select>

                        </label></td>

                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Currency</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
                          <select name="currency" id="currency">
						
						<?php 

						  	$query10 = "select * from master_currency where recordstatus != 'deleted'";

						  	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

						  	while($res10 = mysqli_fetch_array($exec10)){

						  		$currencyid = $res10['auto_number'];

						  		$currency = $res10['currency'];

						  	?>

						  	<option value="<?php echo $currency; ?>"  <?php
							
								if($rescurrency == $currency){
								echo 'selected="selected"'; } ?>
							><?php echo $currency; ?></option>

						  	<?php

						  	}

						  	?>

                      </select>
						</td>

                      </tr>

                      <tr>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Validity End Date </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

                          <input type="text" name="expirydate" id="expirydate" value="<?php echo $res1expirydate; ?>"   onFocus="return funcexpiry();" readonly  style="border: 1px solid #001E6A;">

						   <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('expirydate')" style="cursor:pointer"/> </span></strong></td>

						<td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Fx Rate</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="fxrate" id="fxrate" value="<?php echo $fxrate; ?>" <?php echo $classdis; ?> style="border: 1px solid #001E6A; text-transform:uppercase"></td>   

                      </tr>

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Address </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<textarea name="address" id="address" style="border: 1px solid #001E6A; text-transform:uppercase" rows="3" cols="20"><?php echo $address; ?></textarea></td>

                        <td align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">Last Edit Username <br><br> Last Edit IPaddress</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="editusername" id="editusername" value="<?php echo $editusername; ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase">

                        <br><br>

                        <input type="text" name="editipaddress" id="editipaddress" value="<?php echo $editipaddress; ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase"></td>  

                      </tr>

					   <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Contact </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" name="contact" id="contact" value="<?php echo $contact; ?>" style="border: 1px solid #001E6A;text-transform:uppercase" size="30"></td>

                      <td align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">Last Edit Datetime</td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="editrecorddate" id="editrecorddate" value="<?php if($editrecorddate != '0000-00-00 00:00:00') { echo $editrecorddate; } ?>" readonly style="border: 1px solid #001E6A; text-transform:uppercase"></td>  

                      </tr>

                       <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Phone </div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" style="border: 1px solid #001E6A;text-transform:uppercase" size="30"></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">MIS Report</div></td>

                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><label>

                          <select name="misreport" id="misreport" <?php if($res1accountssub!='2')
	{ echo "disabled"; } ?> style="border: 1px solid #001E6A;">

						<?php

						//*

						if ($res1misreport == '' OR $res1misreport == '0')

						{

						echo '<option value="" selected="selected">--Select MIS Report--</option>';

						}

						else

						{

							$query10 = "select * from mis_types where recordstatus != 'deleted'";

						  	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

						  	while($res10 = mysqli_fetch_array($exec10)){

						  		$misid = $res10['auto_number'];

						  		$mistype = $res10['type'];



								if($res1misreport == $misid){

									$res1misreportshow = $mistype;

								}

							}

						echo '<option value="'.$res1misreport.'" selected="selected">'.$res1misreportshow.'</option>';

						}

						//*/

						?>

                            <?php 

						  	$query10 = "select * from mis_types where recordstatus != 'deleted'";

						  	$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

						  	while($res10 = mysqli_fetch_array($exec10)){

						  		$misid = $res10['auto_number'];

						  		$mistype = $res10['type'];

						  	?>

						  	<option value="<?php echo $misid; ?>"><?php echo $mistype; ?></option>

						  	<?php

						  	}

						  	?>

                          </select>

                        </label></td>

                      </tr>

                     

                      <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Is Capitation</div></td>

                        <td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">

                        <?php

                        	if($iscapitation1 == 0){

                        ?>

                        	<input type="checkbox" name="iscapitation" id="iscapitation" value="1" <?php if($res1accountssub!='2')
	{ echo "disabled"; } ?> onClick="displayService()"></td>

                        <?php

                        	} else {

                        ?>

							<input type="checkbox" name="iscapitation" id="iscapitation" value="1" checked="checked" onClick="displayService()"></td>

						<?php

						}

						?>
					
						 <td   align="left" valign="middle"   bgcolor="#FFFFFF" class="bodytext3"></td>
						 
                        <td id="non_multicc" align="left" valign="top"  bgcolor="#FFFFFF"><!--<select id="cc_name" name="cc_name" >
                          <?php
						if ($cost_center != '')
						{
						?>
                          <option value="<?php echo $cost_center; ?>" selected="selected"><?php echo $cost_center; ?></option>
                          <option value="" >Select Cost Center</option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Cost Center</option>
                          <?php
						}
						$query1 = "select * from master_costcenter where recordstatus <> 'deleted' order by name";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1name = $res1["name"];
						$res1auto_number = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1auto_number; ?>"><?php echo $res1name; ?></option>
                        <?php
						}
						?>
                        </select>
						-->
                         </td>
                         <?php /*}

                         else {*/

                         	
                         	

                         	?>

                      </tr >

					  <tr>

					  	<?php

                        	if($iscapitation1 == 0){

                        ?>

                        	<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" id="servtext" style="display: none;">Select service</div></td>

							<td align="left" valign="top" bgcolor="#FFFFFF">

							<input type="text" name="capitationservice" id="capitationservice" size="40" style="border: 1px solid #001E6A; display: none;"></td>

							<td align="left" valign="top" bgcolor="#FFFFFF">

							<input type="hidden" name="capitationservicecode" id="capitationservicecode" style="border: 1px solid #001E6A;"></td>

							<td align="left" valign="top" bgcolor="#FFFFFF">

							<input type="hidden" name="capitationservicename" id="capitationservicename" style="border: 1px solid #001E6A;"></td>

                        <?php

                        	} else {

                        		$query40 = "select itemname, itemcode from master_services where itemcode = '$serviceitemcode1'";

                        		$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

                        		$res40 = mysqli_fetch_array($exec40);

                        		$capservicename = $res40['itemname'];

                        		$capservicecode = $res40['itemcode'];

                        ?>

							<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" id="servtext">Select service</div></td>

                        	<td align="left" valign="top" bgcolor="#FFFFFF">

							<input type="text" name="capitationservice" id="capitationservice" value="<?php echo $capservicename ." || ".$capservicecode; ?>" size="40" style="border: 1px solid #001E6A;"></td>

							<td align="left" valign="top" bgcolor="#FFFFFF">

							<input type="hidden" name="capitationservicecode" id="capitationservicecode" value="<?php echo $capservicecode; ?>" style="border: 1px solid #001E6A;"></td>

							<td align="left" valign="top" bgcolor="#FFFFFF">

							<input type="hidden" name="capitationservicename" id="capitationservicename" value="<?php echo $capservicename; ?>" style="border: 1px solid #001E6A;"></td>

						<?php

						}

						?>

                      </tr>

                          <tr>

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Is Receivable</div></td>
                        <td  align="left" valign="top"  bgcolor="#FFFFFF">
                        <?php if($is_receivable1 == 0){ ?>
                        	<input type="checkbox" name="is_receivable" id="is_receivable" value="1" <?php if($res1accountssub!='2')
	{ echo "disabled"; } ?>></td>
                        <?php } else { ?>
							<input type="checkbox" name="is_receivable" id="is_receivable" value="1" checked="checked" ></td>
						<?php } ?>

						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">GRN Back Date</div></td>
                        <td  align="left" valign="top"  bgcolor="#FFFFFF">
                        <?php if($grnbackdate1 == 0){ ?>
                        	<input type="checkbox" name="grnbackdate" id="grnbackdate" value="1"></td>
                        <?php } else { ?>
							<input type="checkbox" name="grnbackdate" id="grnbackdate" value="1" checked="checked" ></td>
						<?php } ?>
                      </tr>



                      <tr>

                        <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

						<input type="hidden" name="frmflag" value="addnew" />

                            <input type="hidden" name="frmflag1" value="frmflag1" />

							<input type="hidden" name="accountnameanum" id="accountnameanum" value="<?php echo $res1autonumber; ?>">

                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>

                      </tr>

                      <tr>

                        <td align="middle" colspan="4" >&nbsp;</td>

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



