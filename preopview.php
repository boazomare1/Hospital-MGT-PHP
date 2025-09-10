<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');
$errmsg = "";

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }

if($visitcode!='' && $patientcode!='')
{
	$query1 = "select * from ip_otrequest where patientvisitcode='$visitcode' and patientcode='$patientcode' and docno = '$docno'";
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
	
	$query6 = "select * from preop where patientcode='$patientcode' and visitcode='$visitcode' and docno = '$docno'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$nums6 = mysqli_num_rows($exec6);
	if($nums6 > 0)
	{
		$res6 = mysqli_fetch_array($exec6);
		$opconsentward = $res6["opconsentward"];
		$opconsenttheatre = $res6["opconsenttheatre"];
		$spconsentward = $res6["spconsentward"];
		$spconsentnot = $res6["spconsentnot"];
		$spconsenttheatre = $res6["spconsenttheatre"];
		$spconsenttheatrenot = $res6["spconsenttheatrenot"];
		$filenotesward = $res6["filenotesward"];
		$filenotestheatre = $res6["filenotestheatre"];
		$tpbpchartward = $res6["tpbpchartward"];
		$tpbpcharttheatre = $res6["tpbpcharttheatre"];
		$treatmentsheetward = $res6["treatmentsheetward"];
		$treatmentsheettheatre = $res6["treatmentsheettheatre"];
		$allergiesward = $res6["allergiesward"];
		$allergiestheatre = $res6["allergiestheatre"];
		$xrayward = $res6["xrayward"];
		$xraywardnot = $res6["xraywardnot"];
		$xraytheatre = $res6["xraytheatre"];
		$haemoglobinward = $res6["haemoglobinward"];
		$haemoglobinwardnot = $res6["haemoglobinwardnot"];
		$haemoglobintheatre = $res6["haemoglobintheatre"];
		$bloodsugarward = $res6["bloodsugarward"];
		$bloodsugarwardnot = $res6["bloodsugarwardnot"];
		$bloodsugartheatre = $res6["bloodsugartheatre"];
		$ucrossmatchward = $res6["ucrossmatchward"];
		$ucrossmatchwardnot = $res6["ucrossmatchwardnot"];
		$ucrossmatchtheatre = $res6["ucrossmatchtheatre"];
		$ucrossmatchtheatrenot = $res6["ucrossmatchtheatrenot"];
		$idbandward = $res6["idbandward"];
		$idbandtheatre = $res6["idbandtheatre"];
		$gownward = $res6["gownward"];
		$gowntheatre = $res6["gowntheatre"];	
		$underclothward = $res6["underclothward"];
		$underclothnot = $res6["underclothnot"];
		$undercloththeatre = $res6["undercloththeatre"];
		$dentureward = $res6["dentureward"];
		$denturenot = $res6["denturenot"];
		$denturetheatre = $res6["denturetheatre"];
		$wighairward = $res6["wighairward"];
		$wighairwardnot = $res6["wighairwardnot"];
		$wighairtheatre = $res6["wighairtheatre"];
		$lensward = $res6["lensward"];
		$lenswardnot = $res6["lenswardnot"];
		$lenstheatre = $res6["lenstheatre"];
		$jewelward = $res6["jewelward"];
		$jewelwardnot = $res6["jewelwardnot"];
		$jeweltheatre = $res6["jeweltheatre"];
		$makeupnailward = $res6["makeupnailward"];
		$makeupnailwardnot = $res6["makeupnailwardnot"];
		$makeupnailtheatre = $res6["makeupnailtheatre"];
		$shavingward = $res6["shavingward"];
		$shavingwardnot = $res6["shavingwardnot"];
		$shavingtheatre = $res6["shavingtheatre"];
		$skinward = $res6["skinward"];
		$skinwardnot = $res6["skinwardnot"];
		$skintheatre = $res6["skintheatre"];
		$intradipward = $res6["intradipward"];
		$intradipwardnot = $res6["intradipwardnot"];
		$intradiptheatre = $res6["intradiptheatre"];
		$nasotubeward = $res6["nasotubeward"];
		$nasotubewardnot = $res6["nasotubewardnot"];
		$nasotubewardtheatre = $res6["nasotubewardtheatre"];
		$catheterward = $res6["catheterward"];
		$catheterwardnot = $res6["catheterwardnot"];
		$cathetertheatre = $res6["cathetertheatre"];	
		$lastvoidward = $res6["lastvoidward"];
		$lastvoidtheatre = $res6["lastvoidtheatre"];
		$temp = $res6["temp"];
		$c = $res6["c"];
		$p = $res6["p"];
		$r = $res6["r"];
		$bp = $res6["bp"];
		$dipstickward = $res6["dipstickward"];
		$lastfeedward = $res6["lastfeedward"];
		$premedward = $res6["premedward"];
		$timeward = $res6["timeward"];
		$hivwardpos = $res6["hivwardpos"];
		$hivwardneg = $res6["hivwardneg"];
		$hivwardnot = $res6["hivwardnot"];
		$anaesthetist = $res6["anaesthetist"];
		$reviewnotes = $res6["reviewnotes"];
		$username = $res6["username"];
	}
	else
	{
		$opconsentward = '';
		$opconsenttheatre = '';
		$spconsentward = '';
		$spconsentnot = '';
		$spconsenttheatre = '';
		$spconsenttheatrenot = '';
		$filenotesward = '';
		$filenotestheatre = '';
		$tpbpchartward = '';
		$tpbpcharttheatre = '';
		$treatmentsheetward = '';
		$treatmentsheettheatre = '';
		$allergiesward = '';
		$allergiestheatre = '';
		$xrayward = '';
		$xraywardnot = '';
		$xraytheatre = '';
		$haemoglobinward = '';
		$haemoglobinwardnot = '';
		$haemoglobintheatre = '';
		$bloodsugarward = '';
		$bloodsugarwardnot = '';
		$bloodsugartheatre = '';
		$ucrossmatchward = '';
		$ucrossmatchwardnot = '';
		$ucrossmatchtheatre = '';
		$ucrossmatchtheatrenot = '';
		$idbandward = '';
		$idbandtheatre = '';
		$gownward = '';
		$gowntheatre = '';	
		$underclothward = '';
		$underclothnot = '';
		$undercloththeatre = '';
		$dentureward = '';
		$denturenot = '';
		$denturetheatre = '';
		$wighairward = '';
		$wighairwardnot = '';
		$wighairtheatre = '';
		$lensward = '';
		$lenswardnot = '';
		$lenstheatre = '';
		$jewelward = '';
		$jewelwardnot = '';
		$jeweltheatre = '';
		$makeupnailward = '';
		$makeupnailwardnot = '';
		$makeupnailtheatre = '';
		$shavingward = '';
		$shavingwardnot = '';
		$shavingtheatre = '';
		$skinward = '';
		$skinwardnot = '';
		$skintheatre = '';
		$intradipward = '';
		$intradipwardnot = '';
		$intradiptheatre = '';
		$nasotubeward = '';
		$nasotubewardnot = '';
		$nasotubewardtheatre = '';
		$catheterward = '';
		$catheterwardnot = '';
		$cathetertheatre = '';	
		$lastvoidward = '';
		$lastvoidtheatre = '';
		$temp = '';
		$c = '';
		$p = '';
		$r = '';
		$bp = '';
		$dipstickward = '';
		$lastfeedward = '';
		$premedward = '';
		$timeward = '';
		$hivwardpos = '';
		$hivwardneg = '';
		$hivwardnot = '';
		$anaesthetist = '';
		$reviewnotes = '';
		$username = '';
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
          <td width="26%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $transactiondatefrom; ?>
           </td>
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


      <form name="form1" id="form1" method="post" action="preop.php?anum=<?php echo $companyanum; ?>" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="848" height="282" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="8"><strong>Pre-Operative Check </strong></td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="14" align="left" valign="middle">&nbsp;</td>
              </tr>
              
              
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PRE-OPERATIVE CHECK </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>CHECK THE APPROPRIATE RESPONSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
				<tr>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>FORMS, CHARTS, E.T.C. PRESENT </strong></td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"><strong>WARD NURSE </strong></span></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>THEATRE NURSE </strong></td>
				  </tr>
				<tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Operation Consent </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="opconsentward" onClick="return false" id="opconsentward" <?php if($opconsentward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" onClick="return false" name="opconsenttheatre" id="opconsenttheatre" <?php if($opconsenttheatre == '1') echo 'checked'; ?> value="1"></td>
                </tr>
				  <tr>
			  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Parent/Guardian spouse's consent </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="spconsentward" onClick="return false" id="spconsentward" <?php if($spconsentward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="spconsentnot" onClick="return false" id="spconsentnot" <?php if($spconsentnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" onClick="return false" name="spconsenttheatre" id="spconsenttheatre" <?php if($spconsenttheatre == '1') echo 'checked'; ?> value="1"></td>
                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" onClick="return false" name="spconsenttheatrenot" id="spconsenttheatrenot" <?php if($spconsenttheatrenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
				  </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">File with complete notes </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" onClick="return false" name="filenotesward" id="filenotesward" <?php if($filenotesward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="filenotestheatre" id="filenotestheatre" value="<?php echo $filenotestheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
             
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">TPR and BPChart </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="tpbpchartward" id="tpbpchartward" onClick="return false" <?php if($tpbpchartward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly  name="tpbpcharttheatre" id="tpbpcharttheatre" value="<?php echo $tpbpcharttheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
               <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Treatment Sheet </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="treatmentsheetward" id="treatmentsheetward" onClick="return false" <?php if($treatmentsheetward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="treatmentsheettheatre" id="treatmentsheettheatre" value="<?php echo $treatmentsheettheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
                
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Allergies Noted </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="allergiesward" id="allergiesward" onClick="return false" <?php if($allergiesward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="allergiestheatre" id="allergiestheatre" value="<?php echo $allergiestheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">X-Rays</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="xrayward" id="xrayward" onClick="return false" <?php if($xrayward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="xraywardnot" id="xraywardnot" onClick="return false" <?php if($xraywardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="xraytheatre" id="xraytheatre" value="<?php echo $xraytheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Haemoglobin Results </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input name="haemoglobinward" id="haemoglobinward" value="<?php echo $haemoglobinward; ?>" readonly onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="haemoglobinwardnot" id="haemoglobinwardnot" onClick="return false" <?php if($haemoglobinwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="haemoglobintheatre" id="haemoglobintheatre" value="<?php echo $haemoglobintheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Blood Sugar Results </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="bloodsugarward" id="bloodsugarward" value="<?php echo $bloodsugarward; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input type="checkbox" name="bloodsugarwardnot" id="bloodsugarwardnot" <?php if($bloodsugarwardnot == '1') echo 'checked'; ?> onClick="return false" value="1">
</span><span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="bloodsugartheatre" id="bloodsugartheatre" value="<?php echo $bloodsugartheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">No. of Units Cross-Matched</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="ucrossmatchward" id="ucrossmatchward" value="<?php echo $ucrossmatchward; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="ucrossmatchwardnot" id="ucrossmatchwardnot" onClick="return false" <?php if($ucrossmatchwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="ucrossmatchtheatre" id="ucrossmatchtheatre" value="<?php echo $ucrossmatchtheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="ucrossmatchtheatrenot" id="ucrossmatchtheatrenot" onClick="return false" <?php if($ucrossmatchtheatrenot == '1') echo 'checked'; ?> value="1">
                  N/R</td>
              </tr>
              
			   <tr>
			     <td colspan="10" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PATIENT PREPARATION COMPLETED </strong></td>
			     </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Identification band </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="idbandward" id="idbandward" onClick="return false" <?php if($idbandward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="checkbox" name="idbandtheatre" id="idbandtheatre" onClick="return false" <?php if($idbandtheatre == '1') echo 'checked'; ?> value="1"></td>
                </tr>
				
				   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Theatre Gown </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="gownward" id="gownward" onClick="return false" <?php if($gownward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="gowntheatre" id="gowntheatre" value="<?php echo $gowntheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Personal Items Removed or Absent </td>
                <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                </tr>
				 <tr>
                <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td width="22%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Underclothes</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="underclothward" id="underclothward" onClick="return false" <?php if($underclothward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="underclothnot" id="underclothnot" onClick="return false" <?php if($underclothnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="undercloththeatre" id="undercloththeatre" value="<?php echo $undercloththeatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
			   <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Dentures</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="dentureward" id="dentureward" onClick="return false" <?php if($dentureward == '1') echo 'checked'; ?> value="1"></td>
				
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="denturenot" id="denturenot" onClick="return false" <?php if($denturenot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="denturetheatre" id="denturetheatre" value="<?php echo $denturetheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
                </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Wig and Hairpins </td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="wighairward" id="wighairward" onClick="return false" <?php if($wighairward == '1') echo 'checked'; ?> value="1"></td>
				    <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="wighairwardnot" id="wighairwardnot" onClick="return false" <?php if($wighairwardnot == '1') echo 'checked'; ?> value="1">
                            <span class="bodytext3">N/R </span></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="wighairtheatre" id="wighairtheatre" value="<?php echo $wighairtheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
             </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Contact Lenses</td>
                  <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="lensward" id="lensward" onClick="return false" <?php if($lensward == '1') echo 'checked'; ?> value="1"></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="lenswardnot" id="lenswardnot" onClick="return false" <?php if($lenswardnot == '1') echo 'checked'; ?> value="1">
					      <span class="bodytext3">N/R</span></td>
						  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="lenstheatre" id="lenstheatre" value="<?php echo $lenstheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
             </tr>
				
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Jewellery</td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="jewelward" id="jewelward" onClick="return false" <?php if($jewelward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="jewelwardnot" id="jewelwardnot" onClick="return false" <?php if($jewelwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="jeweltheatre" id="jeweltheatre" value="<?php echo $jeweltheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Make Up and Nail Varnish </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="makeupnailward" id="makeupnailward" onClick="return false" <?php if($makeupnailward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="makeupnailwardnot" id="makeupnailwardnot" onClick="return false" <?php if($makeupnailwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="makeupnailtheatre" id="makeupnailtheatre" value="<?php echo $makeupnailtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
              
              <tr>
                <td colspan="2" align="middle"  bgcolor="#ecf0f5"><div align="left"><span class="bodytext3">Shaving</span></div></td>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5">
				  <div align="left">
				    <input type="checkbox" name="shavingward" id="shavingward" onClick="return false" <?php if($shavingward == '1') echo 'checked'; ?> value="1">
				  </div></td>
                <td colspan="2" align="middle"  bgcolor="#ecf0f5"><div align="left">
                  <input type="checkbox" name="shavingwardnot" id="shavingwardnot" onClick="return false" <?php if($shavingwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></div></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="shavingtheatre" id="shavingtheatre" value="<?php echo $shavingtheatre; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
               </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Skin Preparation </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="skinward" id="skinward" onClick="return false" <?php if($skinward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="skinwardnot" id="skinwardnot" onClick="return false" <?php if($skinwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R </span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="skintheatre" id="skintheatre" value="<?php echo $skintheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
			   <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Intravenous Drip In Place </td>
                <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="intradipward" id="intradipward" onClick="return false" <?php if($intradipward == '1') echo 'checked'; ?> value="1"></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="intradipwardnot" id="intradipwardnot" onClick="return false" <?php if($intradipwardnot == '1') echo 'checked'; ?> value="1">
                  <span class="bodytext3">N/R</span></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
                  <input readonly name="intradiptheatre" id="intradiptheatre" value="<?php echo $intradiptheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
                </span></td>
                </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Naso-Gastric Tube In Place </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nasotubeward" id="nasotubeward" onClick="return false" <?php if($nasotubeward == '1') echo 'checked'; ?> value="1"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="nasotubewardnot" id="nasotubewardnot" onClick="return false" <?php if($nasotubewardnot == '1') echo 'checked'; ?> value="1">
			       <span class="bodytext3">N/R</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="nasotubewardtheatre" id="nasotubewardtheatre" value="<?php echo $nasotubewardtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Catheter In Place </td>
			     <td colspan="4" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="catheterward" id="catheterward" onClick="return false" <?php if($catheterward == '1') echo 'checked'; ?> value="1"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="catheterwardnot" id="catheterwardnot" onClick="return false" <?php if($catheterwardnot == '1') echo 'checked'; ?> value="1">
			       <span class="bodytext3">N/R </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="cathetertheatre" id="cathetertheatre" value="<?php echo $cathetertheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time of Last Void </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="lastvoidward" id="lastvoidward" value="<?php echo $lastvoidward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="lastvoidtheatre" id="lastvoidtheatre" value="<?php echo $lastvoidtheatre; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Vital Signs </td>
			     <td width="5%" align="left" valign="middle"  bgcolor="#ecf0f5"><spanp class="bodytext3">
			       <span class="bodytext3">Temp</span></span></td>
			     <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly  name="temp" id="temp" value="<?php echo $temp; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="3%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">C
                     
			     </span></td>
			     <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly  name="c" id="c" value="<?php echo $c; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     <td width="2%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3"> R                 </span></td>
			     <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="r" id="r" value="<?php echo $r; ?>" onKeyDown="return disableEnterKey()" size="5">
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
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Dipstick Urinalysis Result </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly name="dipstickward" id="dipstickward" value="<?php echo $dipstickward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time Of Last Feed </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly  name="lastfeedward" id="lastfeedward" value="<?php echo $lastfeedward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Time Pre-Medication Given </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input readonly  name="premedward" id="premedward" value="<?php echo $premedward; ?>" onKeyDown="return disableEnterKey()" size="20">
			     </span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">TIME:
			       <input readonly name="timeward" id="timeward" value="<?php echo $timeward; ?>" onKeyDown="return disableEnterKey()" size="5">
			     </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><p><strong>INFECTION PRECAUTIONS</strong></p></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     <td colspan="2" rowspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">HIV TEST</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input type="checkbox" name="hivwardpos" id="hivwardpos" onClick="return false;" <?php if($hivwardpos == '1') echo 'checked'; ?> value="1">
			     +ve</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="hivwardneg" id="hivwardneg" onClick="return false" <?php if($hivwardneg == '1') echo 'checked'; ?> value="1">
			       <span class="bodytext3">-ve</span></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext3">
			       <input type="checkbox" name="hivwardnot" id="hivwardnot" onClick="return false" <?php if($hivwardnot == '1') echo 'checked'; ?> value="1">
			       Not Done </span></td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">ANAESTHETIST </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">REVIEW NOTES </td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="anaesthetist" id="anaesthetist" value="<?php echo $anaesthetist; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input readonly name="reviewnotes" id="reviewnotes" value="<?php echo $reviewnotes; ?>" onKeyDown="return disableEnterKey()" size="20"></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
			     </tr>
			   <tr>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>CHECKED BY:</strong> <?php echo $username; ?> </td>
			     <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><a target="_blank" href="print_preopview.php?cbfrmflag1=cbfrmflag1&&visitcode=<?php echo $visitcode; ?>&&patientcode=<?php echo $patientcode; ?>&&docno=<?php echo $docno; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>
			   
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

