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

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = isset($_POST["frmflag1"]);
if ($frmflag1 == 'frmflag1')
{
for ($p=1;$p<=21;$p++)
		{	
$field = $_REQUEST['labpaynow'.$p];
$paynowlabcoa = $_REQUEST['paynowlabcoa'.$p];
$paynowlabsel = $_REQUEST['paynowlabsel'.$p];
$paynowlabtype = $_REQUEST['paynowlabtype'.$p];
$paynowlabcode = $_REQUEST['paynowlabcode'.$p];

if($paynowlabcoa != '')
{
$query33 = "insert into master_financialintegration(field,coa,selectstatus,type,code,ipaddress,recorddate,username)values('$field','$paynowlabcoa','$paynowlabsel','$paynowlabtype','$paynowlabcode','$ipaddress','$updatedatetime','$username')";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
}
header("location:financialintegration.php");
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = isset($_REQUEST["st"]);
if ($st == 1)
{
	$errmsg = "Login Failed. Please Try Again With Proper User Id and Password.";
}

?>
<?php
$query76 = "select * from master_financialintegration where field='labip'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$labcoa = $res76['code'];
$labcoaname = $res76['coa'];
$labtype = $res76['type'];
$labselect = $res76['selectstatus'];

$query761 = "select * from master_financialintegration where field='radiologyexternal'";
$exec761 = mysqli_query($GLOBALS["___mysqli_ston"], $query761) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res761 = mysqli_fetch_array($exec761);

$radiologycoa = $res761['code'];
$radiologycoaname = $res761['coa'];
$radiologytype = $res761['type'];
$radiologyselect = $res761['selectstatus'];

$query762 = "select * from master_financialintegration where field='serviceexternal'";
$exec762 = mysqli_query($GLOBALS["___mysqli_ston"], $query762) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res762 = mysqli_fetch_array($exec762);

$servicecoa = $res762['code'];
$servicecoaname = $res762['coa'];
$servicetype = $res762['type'];
$serviceselect = $res762['selectstatus'];

$query763 = "select * from master_financialintegration where field='referalexternal'";
$exec763 = mysqli_query($GLOBALS["___mysqli_ston"], $query763) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res763 = mysqli_fetch_array($exec763);

$referalcoa = $res763['code'];
$referalcoaname = $res763['coa'];
$referaltype = $res763['type'];
$referalselect = $res763['selectstatus'];

$query7641 = "select * from master_financialintegration where field='pharmacyexternal'";
$exec7641 = mysqli_query($GLOBALS["___mysqli_ston"], $query7641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res7641 = mysqli_fetch_array($exec7641);

$pharmacycoa = $res7641['code'];
$pharmacycoaname = $res7641['coa'];
$pharmacytype = $res7641['type'];
$pharmacyselect = $res7641['selectstatus'];

$query764 = "select * from master_financialintegration where field='ipdeposits'";
$exec764 = mysqli_query($GLOBALS["___mysqli_ston"], $query764) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res764 = mysqli_fetch_array($exec764);

$ipdepositscoa = $res764['code'];
$ipdepositscoaname = $res764['coa'];
$ipdepositstype = $res764['type'];
$ipdepositsselect = $res764['selectstatus'];

$query765 = "select * from master_financialintegration where field='cashipdeposits'";
$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res765= mysqli_fetch_array($exec765);

$cashcoa = $res765['code'];
$cashcoaname = $res765['coa'];
$cashtype = $res765['type'];
$cashselect = $res765['selectstatus'];

$query766 = "select * from master_financialintegration where field='chequeipdeposits'";
$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res766 = mysqli_fetch_array($exec766);

$chequecoa = $res766['code'];
$chequecoaname = $res766['coa'];
$chequetype = $res766['type'];
$chequeselect = $res766['selectstatus'];

$query767 = "select * from master_financialintegration where field='mpesaipdeposits'";
$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res767 = mysqli_fetch_array($exec767);

$mpesacoa = $res767['code'];
$mpesacoaname = $res767['coa'];
$mpesatype = $res767['type'];
$mpesaselect = $res767['selectstatus'];

$query768 = "select * from master_financialintegration where field='cardipdeposits'";
$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res768 = mysqli_fetch_array($exec768);

$cardcoa = $res768['code'];
$cardcoaname = $res768['coa'];
$cardtype = $res768['type'];
$cardselect = $res768['selectstatus'];

$query769 = "select * from master_financialintegration where field='onlineipdeposits'";
$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res769 = mysqli_fetch_array($exec769);

$onlinecoa = $res769['code'];
$onlinecoaname = $res769['coa'];
$onlinetype = $res769['type'];
$onlineselect = $res769['selectstatus'];
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5; 
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
.bodytext5 {	FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
-->
</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popupcoasearchipfinal.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
</head>

<body onLoad="return setFocus()">
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		  	  	<form id="form1" name="form1" method="post" action="editipfinalbillcoaintegration.php" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><table width="950" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; ">
              <tbody>
			              <tr>
    <td>&nbsp;</td>
 </tr>     
                 <tr bgcolor="#011E6A">
                        <td colspan="10" bgcolor="#ecf0f5" class="bodytext3"><strong> Edit IP Final Bill </strong></td>
                  </tr>
					   <tr>
                        <td width="248" align="left" valign="top"  class="bodytext3"><strong>Field</strong></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><strong>Select COA</strong></td>
                        <td width="117" align="left" valign="top"  class="bodytext3"><strong>Select</strong></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><strong>Type</strong></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
				  </tr>
				 
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Lab <input type="hidden" name="labpaynow1" value="labipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa1" id="paynowlabcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('1')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel1" id="paynowlabsel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype1" id="paynowlabtype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode1" id="paynowlabcode" size="10"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Radiology <input type="hidden" name="labpaynow2" value="radiologyipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa2" id="paynowradiologycoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('2')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel2" id="paynowradiologysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype2" id="paynowradiologytype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode2" id="paynowradiologycode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Service <input type="hidden" name="labpaynow3" value="serviceipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa3" id="paynowservicecoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('3')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel3" id="paynowservicesel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype3" id="paynowservicetype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode3" id="paynowservicecode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Referral <input type="hidden" name="labpaynow4" value="referalipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa4" id="paynowreferalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('4')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel4" id="paynowreferalsel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype4" id="paynowreferaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode4" id="paynowreferalcode" size="10"/></td>
				  </tr>
				    <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Pharmacy <input type="hidden" name="labpaynow5" value="pharmacyipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa5" id="paynowpharmacycoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('5')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel5" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype5" id="paynowpharmacytype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode5" id="paynowpharmacycode" size="10"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Bed Charges <input type="hidden" name="labpaynow6" value="bedchargesipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa6" id="bedchargesipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('6')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel6" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype6" id="bedchargesipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode6" id="bedchargesipfinalcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">RMO <input type="hidden" name="labpaynow7" value="rmoipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa7" id="rmoipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('7')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel7" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype7" id="rmoipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode7" id="rmoipfinalcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Nursing <input type="hidden" name="labpaynow8" value="nursingipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa8" id="nursingipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('8')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel8" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype8" id="nursingipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode8" id="nursingipfinalcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Private Doctor <input type="hidden" name="labpaynow9" value="privatedoctoripfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa9" id="privatedoctoripfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('9')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel9" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype9" id="privatedoctoripfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode9" id="privatedoctoripfinalcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Ambulance  <input type="hidden" name="labpaynow10" value="ambulanceipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa10" id="ambulanceipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('10')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel10" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype10" id="ambulanceipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode10" id="ambulanceipfinalcode" size="10"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">NHIF  <input type="hidden" name="labpaynow11" value="nhifipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa11" id="nhifipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('11')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel11" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype11" id="nhifipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode11" id="nhifipfinalcode" size="10"/></td>
				  </tr>
				    <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">OT Billing  <input type="hidden" name="labpaynow12" value="otbillingipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa12" id="otbillingipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('12')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel12" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype12" id="otbillingipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode12" id="otbillingipfinalcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Misc Billing  <input type="hidden" name="labpaynow13" value="miscbillingipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa13" id="miscbillingipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('13')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel13" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype13" id="miscbillingipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode13" id="miscbillingipfinalcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5"> Admission Charge  <input type="hidden" name="labpaynow14" value="admissionchargeipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa14" id="admissionchargeipfinalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('14')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel14" id="paynowpharmacysel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype14" id="admissionchargeipfinaltype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode14" id="admissionchargeipfinalcode" size="10"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Cash <input type="hidden" name="labpaynow15" value="cashipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa15" id="paynowcashcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('15')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel15" id="paynowcashsel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype15" id="paynowcashtype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode15" id="paynowcashcode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Cheque <input type="hidden" name="labpaynow16" value="chequeipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa16" id="paynowchequecoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('16')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel16" id="paynowchequesel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype16" id="paynowchequetype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode16" id="paynowchequecode" size="10"/></td>
				  </tr>
				   <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Mpesa <input type="hidden" name="labpaynow17" value="mpesaipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa17" id="paynowmpesacoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('17')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel17" id="paynowmpesasel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype17" id="paynowmpesatype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode17" id="paynowmpesacode" size="10"/></td>
				  </tr>
				     <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Card <input type="hidden" name="labpaynow18" value="cardipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa18" id="paynowcardcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('18')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel18" id="paynowcardsel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype18" id="paynowcardtype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode18" id="paynowcardcode" size="10"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Online <input type="hidden" name="labpaynow19" value="onlineipfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa19" id="paynowonlinecoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('19')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel19" id="paynowonlinesel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype19" id="paynowonlinetype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode19" id="paynowonlinecode" size="10"/></td>
				  </tr>
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Deposits <input type="hidden" name="labpaynow20" value="ipdepositsfinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa20" id="ipdepositscoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('20')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel20" id="ipdepositssel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype20" id="ipdepositstype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode20" id="ipdepositscode" size="10"/></td>
				  </tr>
				  
				  <tr>
				  <td width="248" align="left" valign="top"  class="bodytext5">Package <input type="hidden" name="labpaynow21" value="ippackagefinal" /></td>
                        <td width="332" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa21" id="ippackagecoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('21')" value="Map" accesskey="m" style="border: 1px solid #001E6A"></td>
                        <td width="117" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel21" id="ippackagesel">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
						</select></td>
                        <td width="110" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype21" id="ippackagetype" size="10"/></td>
                        <td width="103" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode21" id="ippackagecode" size="10"/></td>
				  </tr>
                <tr>
                 
                  <td align="middle" valign="top" colspan="7"><div align="right">
                      <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
                      <input type="submit" name="Submit" value="Save" style="border: 1px solid #001E6A" />
                      
                  </div></td>
                </tr>
              </tbody>
            </table>
           
        </td>
        </tr>
      </table>
	</form>
    </td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

