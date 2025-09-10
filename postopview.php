<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$errmsg = "";

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if($visitcode!='' && $patientcode!='')
{
	$query1 = "select * from ip_otrequest where patientvisitcode='$visitcode' and patientcode='$patientcode'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1 = mysqli_num_rows($exec1);
	$res1 = mysqli_fetch_array($exec1);
	$patientname = $res1['patientname'];
	$patientcode = $res1['patientcode'];
	$visitcode = $res1['patientvisitcode'];
	$accoutname = $res1['accountname'];
	$operation = $res1['surgeryname'];
	$docno = $res1['docno'];
	$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$ward=$res2['ward'];
	$query3 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$wardname = $res3['ward'];
	$query4 = "select * from master_customer where customercode='$patientcode'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$age=$res4['age'];
	$gender=$res4['gender'];
	$query6 = "select * from postop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums6 = mysqli_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysqli_fetch_array($exec6);
		$oprecordtheatre = $res6["oprecordtheatre"];
		$oprecordward = $res6["oprecordward"];
		$ivtheatre = $res6["ivtheatre"];
		$ivward = $res6["ivward"];
		$intrafluidtheatre = $res6["intrafluidtheatre"];
		$intrafluidtheatrenot = $res6["intrafluidtheatrenot"];
		$intrafluidward = $res6["intrafluidward"];
		$postopdrugtheatre = $res6["postopdrugtheatre"];
		$postopdrugtheatrenot = $res6["postopdrugtheatrenot"];
		$postopdrugward = $res6["postopdrugward"];
		$nasotubetheatre = $res6["nasotubetheatre"];
		$nasotubetheatrenot = $res6["nasotubetheatrenot"];
		$nasotubeward = $res6["nasotubeward"];
		$roomobstheatre = $res6["roomobstheatre"];
		$roomobsward = $res6["roomobsward"];
		$preopfilmtheatre = $res6["preopfilmtheatre"];
		$preopfilmtheatrenot = $res6["preopfilmtheatrenot"];
		$preopfilmward = $res6["preopfilmward"];
		$xraytheatre = $res6["xraytheatre"];
		$xraytheatrenot = $res6["xraytheatrenot"];
		$xrayward = $res6["xrayward"];
		$drainstheatre = $res6["drainstheatre"];
		$drainsward = $res6["drainsward"];
		$dressingtheatre = $res6["dressingtheatre"];
		$dressingward = $res6["dressingward"];
		$dressingwardnot = $res6["dressingwardnot"];
		$forleytheatre = $res6["forleytheatre"];
		$forleyward = $res6["forleyward"];
		$nospecimentheatre = $res6["nospecimentheatre"];
		$nospecimenward = $res6["nospecimenward"];
		$specimentypetheatre = $res6["specimentypetheatre"];
		$specimentypeward = $res6["specimentypeward"];
		$investigationtheatre = $res6["investigationtheatre"];
		$investigationward = $res6["investigationward"];
		$username = $res6["username"];

		$temp = $res6["temp"];
		$c = $res6["c"];
		$p = $res6["p"];
		$r = $res6["r"];
		$bp = $res6["bp"];
	}
	else
	{
		$oprecordtheatre = '';
		$oprecordward = '';
		$ivtheatre = '';
		$ivward = '';
		$intrafluidtheatre = '';
		$intrafluidtheatrenot = '';
		$intrafluidward = '';
		$postopdrugtheatre = '';
		$postopdrugtheatrenot = '';
		$postopdrugward = '';
		$nasotubetheatre = '';
		$nasotubetheatrenot = '';
		$nasotubeward = '';
		$roomobstheatre = '';
		$roomobsward = '';
		$preopfilmtheatre = '';
		$preopfilmtheatrenot = '';
		$preopfilmward = '';
		$xraytheatre = '';
		$xraytheatrenot = '';
		$xrayward = '';
		$drainstheatre = '';
		$drainsward = '';
		$dressingtheatre = '';
		$dressingward = '';
		$dressingwardnot = '';
		$forleytheatre = '';
		$forleyward = '';
		$nospecimentheatre = '';
		$nospecimenward = '';
		$specimentypetheatre = '';
		$specimentypeward = '';
		$investigationtheatre = '';
		$investigationward = '';
		$temp = '';
		$c = '';
		$p = '';
		$r = '';
		$bp = '';
	}
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">

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
</script>
<script src="js/datetimepicker_css.js"></script>
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
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="61%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#ecf0f5" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#ecf0f5">
          <td class="bodytext3" bgcolor="#ecf0f5"><strong>Patient  * </strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" bgcolor="#ecf0f5"><?php echo $patientname; ?></td>
          <td bgcolor="#ecf0f5" class="bodytext3"><strong>Date </strong></td>
          <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $transactiondatefrom; ?></td>
          <td width="11%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="21%" align="left" valign="middle" class="bodytext3"><?php echo $wardname; ?></td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Code</strong></td>
          <td width="20%" class="bodytext3" align="left" valign="middle" ><?php echo $patientcode; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code </strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?></td>
          <td align="left" valign="top" class="bodytext3"><strong>Operation</strong></td>
          <td align="left" valign="top" class="bodytext3"><?php echo $operation; ?></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
          <td align="left" valign="middle" class="bodytext3"><?php echo $age; ?> & <?php echo $gender; ?></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Ref. Dr. </strong></td>
          <td colspan="1" align="left" valign="top" class="bodytext3">&nbsp;</td>
          <td colspan="1" align="left" valign="top" class="bodytext3"><strong>Doc no</strong></td>
		  <td colspan="1" align="left" valign="top" class="bodytext3"><?php echo $docno; ?></td>
        </tr>
        <tr>
          <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
        </tr>
      </tbody>
    </table>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top">


      <form name="form1" id="form1" method="post" action="postopview.php">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="886" height="282" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>Post-Operative Check </strong></td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="14" align="left" valign="middle">&nbsp;</td>
              </tr>
              
              
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>POST-OPERATIVE CHECK </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>CHECK THE APPROPRIATE RESPONSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>CHARTS, RECORDS, E.T.C. PRESENT </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong> THEATRE NURSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>WARD NURSE</strong></td>
				  </tr>
				<tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Operation Record </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="oprecordtheatre" id="oprecordtheatre" onClick="return false" <?php if($oprecordtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="oprecordward" id="oprecordward" onClick="return false" <?php if($oprecordward == '1') echo 'checked'; ?> value="1"></td>
                </tr>
				  <tr>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">IV Fluids and Transfussions Record </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="ivtheatre" id="ivtheatre" onClick="return false" <?php if($ivtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="ivward" id="ivward" onClick="return false" <?php if($ivward == '1') echo 'checked'; ?> value="1"></td>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Nursing Instructions For: </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
              <tr>
                <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td width="22%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Intravenous Fluids </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="intrafluidtheatre" id="intrafluidtheatre" onClick="return false" <?php if($intrafluidtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="intrafluidtheatrenot" id="intrafluidtheatrenot" onClick="return false" <?php if($intrafluidtheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="intrafluidward" id="intrafluidward" onClick="return false" <?php if($intrafluidward == '1') echo 'checked'; ?> value="1"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Post-Operative Drugs </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="postopdrugtheatre" id="postopdrugtheatre" onClick="return false" <?php if($postopdrugtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="postopdrugtheatrenot" id="postopdrugtheatrenot" onClick="return false" <?php if($postopdrugtheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="postopdrugward" id="postopdrugward" onClick="return false" <?php if($postopdrugward == '1') echo 'checked'; ?> value="1"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Naso-Gastric Tube </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nasotubetheatre" id="nasotubetheatre" onClick="return false" <?php if($nasotubetheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nasotubetheatrenot" id="nasotubetheatrenot" onClick="return false" <?php if($nasotubetheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="nasotubeward" id="nasotubeward" onClick="return false" <?php if($nasotubeward == '1') echo 'checked'; ?> value="1"></td>
              </tr>
             
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Recovery Room Observations </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="roomobstheatre" id="roomobstheatre" value="<?php echo $roomobstheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="roomobsward" id="roomobsward" value="<?php echo $roomobsward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
               <tr>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">X-Rays</td>
                 <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
               </tr>
               <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Pre-Operative Films </td>
                <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="preopfilmtheatre" id="preopfilmtheatre" onClick="return false" <?php if($preopfilmtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="preopfilmtheatrenot" id="preopfilmtheatrenot" onClick="return false" <?php if($preopfilmtheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="preopfilmward" id="preopfilmward" onClick="return false" <?php if($preopfilmward == '1') echo 'checked'; ?> value="1"></td>
                </tr>
               <tr>
                 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                 <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">X-Ray Card For Post-Operative Films </td>
                 <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="xraytheatre" id="xraytheatre" onClick="return false" <?php if($xraytheatre == '1') echo 'checked'; ?> value="1"></td>
                 <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="xraytheatrenot" id="xraytheatrenot" onClick="return false" <?php if($xraytheatrenot == '1') echo 'checked'; ?> value="1">
                   <span class="bodytext3">N/R</span></td>
                 <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="xrayward" id="xrayward" onClick="return false" <?php if($xrayward == '1') echo 'checked'; ?> value="1"></td>
               </tr>
                
              <tr>
                <td colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DRAINS, DRESSING, E.T.C. PRESENT </strong></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Drains (indicate number) </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="drainstheatre" id="drainstheatre" onClick="return false" <?php if($drainstheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="drainsward" id="drainsward" value="<?php echo $drainsward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Dressings Dry And Intact </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="dressingtheatre" id="dressingtheatre" onClick="return false" <?php if($dressingtheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="dressingward" id="dressingward" onClick="return false" <?php if($dressingward == '1') echo 'checked'; ?> value="1"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="dressingwardnot" id="dressingwardnot" onClick="return false" <?php if($dressingwardnot == '1') echo 'checked'; ?> value="1">
                  N/R</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Forley Catheter </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="forleytheatre" id="forleytheatre" onClick="return false" <?php if($forleytheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="forleyward" id="forleyward" onClick="return false" <?php if($forleyward == '1') echo 'checked'; ?> value="1"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>OTHER</strong></td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              </tr>
              
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>IF SPECIMEN TO GO WITH PATIENT </strong></td>
			     </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Number Of Specimen (s) </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nospecimentheatre" id="nospecimentheatre" onClick="return false" <?php if($nospecimentheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="nospecimenward" id="nospecimenward" value="<?php echo $nospecimenward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
				
				   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type Of Specimen (s)</td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="specimentypetheatre" id="specimentypetheatre" onClick="return false" <?php if($specimentypetheatre == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="specimentypeward" id="specimentypeward" value="<?php echo $specimentypeward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Investigations Ordered </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonlyname="investigationtheatre" id="investigationtheatre" value="<?php echo $investigationtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="investigationward" id="investigationward" value="<?php echo $investigationward; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
				 
			   <tr>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Vital Signs </td>
			     <td width="4%" align="left" valign="middle"  bgcolor="#ecf0f5"><spanp class="bodytext3">
			       <span class="bodytext3">Temp</span></span></td>
			     <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="temp" id="temp" value="<?php echo $temp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">C
                     
			     </span></td>
			     <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="c" id="c" value="<?php echo $c; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"> R                 </span></td>
			     <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly cname="r" id="r" value="<?php echo $r; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">BP                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="bp" id="bp" value="<?php echo $bp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"> P                 </span></td>
			     <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="p" id="p" value="<?php echo $p; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>CHECKED BY:</strong> <?php echo $username; ?></td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
			     
                 <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><a target="_blank" href="print_postopview.php?cbfrmflag1=cbfrmflag1&&visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&docno=<?php echo $docno; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
			   
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

