<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$transactiondatefrom = date('Y-m-d', strtotime('-1 day'));
$transactiondateto = date('Y-m-d');
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$colorloopcount = '';
$sno = '';
$totalintake = '';
$totaloutput = '';
$totaliv ='';
$totalalimentary = '';
$totaloutput='';
$totalvomit=''; 
$totalstool ='';
$totalngast ='';
$totalothers='';
$totalurine = '';
$totalbalance = '';
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docno"];
?>

<?php
if (isset($_REQUEST["viewstatus"])) { $viewstatus = $_REQUEST["viewstatus"]; } else { $errcode = ""; }
if($viewstatus == 'viewed')
{
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
	   $query26="update ip_vitalio set viewstatus ='$viewstatus' where patientcode='$patientcode' and visitcode='$visitcode' and docno='$docnumber' ";
	    $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>
<script>
function popup()
{
  NewWindow=window.open('vitalinputchart1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>','newWin','width=700,height=400,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
  //NewWindow.focus();
}
</script>

<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcrange('<?php echo $sn; ?>')">
<form name="frm" id="frmsales" method="post" action="viewfluidbalance.php" onKeyDown="return disableEnterKey(event)">
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
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top"><table width="743" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>INTAKE</strong></td>
        <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><a href="" onclick='popup();'></a></td>
      </tr>
      <tr>
        <td class="bodytext366" valign="center"  align="center" 
                >&nbsp;</td>
        <td colspan="3"  align="center" valign="center" 
                class="style1">Intravenous</td>
        <td colspan="3"  align="center" valign="center" 
                class="style1">Alimentary</td>
        <td  align="center" valign="center" 
				bgcolor="#ecf0f5" class="bodytext366">&nbsp;</td>
      </tr>
      <tr>
        <td width="12%" class="bodytext366" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
        <td width="7%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Time</strong></td>
        <td width="19%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Type</strong></td>
        <td width="14%"  align="center" valign="center" 
                bgcolor="#ffffff" class="style1">Bottle</td>
        <td width="9%"  align="center" valign="center" 
                bgcolor="#ffffff" class="style1">Infused</td>
        <td width="25%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Type</strong></td>
        <td width="11%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Amount</strong></td>
        <td width="3%"  align="center" valign="center" 
				bgcolor="#ecf0f5" class="bodytext366">&nbsp;</td>
      </tr>
      <?php
      $query31="select * from fluidbalance where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc";
	  $exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
	  $num=mysqli_num_rows($exec31);
	  while($res31=mysqli_fetch_array($exec31))
	  { 
       $res31recorddate=$res31['recorddate'];
	   $res31recordtime=$res31['recordtime'];
	   $res31intravenoustype=$res31['intravenoustype'];
	   $res31alimentarytype=$res31['alimentarytype'];
	   $res31bottle=$res31['bottle'];
	   $totalbottle = $totalbottle + $res31bottle;
	   $res31infused=$res31['infused'];
	   $totalinfused = $totalinfused + $res31infused;
	   $res31amount=$res31['amount'];
	   $totalamount = $totalamount+ $res31amount;
	   
	   $totalalimentary = $totalalimentary + $res31alimentary;
	   $res31username=$res31['username'];	  
        if($res31iv!='0' || $res31alimentary!='0')
	     {
	        $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
      <tr <?php echo $colorcode; ?>>
        <td height="25" width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31recorddate; ?></td>
        <td width="7%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31recordtime; ?></td>
        <td width="19%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31intravenoustype; ?></td>
        <td width="14%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31bottle; ?></td>
        <td width="9%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31infused; ?></td>
        <td width="25%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31alimentarytype; ?></td>
        <td width="11%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res31amount; ?></td>
        </tr>
      <?php
		 }
		 }
		 ?>
      <tr>
        <td height="25" bgcolor="#ecf0f5" width="12%" class="bodytext3" valign="center"  align="center">&nbsp;</td>
        <td width="7%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center">&nbsp;</td>
        <td width="19%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center">&nbsp;</td>
        <td width="14%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalbottle; ?></strong></td>
        <td width="9%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalinfused; ?></strong></td>
        <td width="25%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center">&nbsp;</td>
        <td width="11%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalamount; ?></strong></td>
        </tr>
    </table></td>
    <td valign="top"><table width="588" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><strong>OUTPUT</strong></td>
        <td align="center" valign="middle"  bgcolor="#ecf0f5" class="bodytext365"><a href="" onclick='popup();'></a></td>
      </tr>
      <tr>
        <td width="12%" class="bodytext366" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
        <td width="12%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Time</strong></td>
        <td width="12%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Vomit</strong></td>
        <td width="12%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>Stool</strong></td>
        <td width="13%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext366"><strong>N/Gast</strong></td>
        <td width="13%"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext366"><strong>Others</strong></td>
        <td width="21%"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext366"><strong>Urine</strong></td>
        <td width="5%"  align="center" valign="center" 
				bgcolor="#ecf0f5" class="bodytext366">&nbsp;</td>
      </tr>
      <?php
      $query32="select * from fluidbalance where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc";
	  $exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32);
	  $num=mysqli_num_rows($exec32);
	  while($res32=mysqli_fetch_array($exec32))
	  { 
       $res32recorddate=$res32['recorddate'];
	   $res32recordtime=$res32['recordtime'];
	   $res32vomitus=$res32['vomitus'];
	   $totalvomit = $totalvomit + $res32vomitus;
       $res32stool=$res32['stool'];
	   $totalstool = $totalstool + $res32stool;
	   $res32ngast=$res32['ngast'];
	   $totalngast = $totalngast + $res32ngast;
	   $res32others=$res32['others'];
	   $totalothers = $totalothers + $res32others;
	   $res32urine=$res32['urine'];
	   $totalurine = $totalurine+ $res32urine;

       $res32username=$res32['username'];	  
   
        if($res32vomitus!='0' || $res32stool!='0' || $res32ngast!='0' || $res32others!='0' || $res32urine!='0')
	   {
	        $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
      <tr <?php echo $colorcode; ?>>
        <td height="25" width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res32recorddate; ?></td>
        <td width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res32recordtime; ?></td>
        <td width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res32vomitus; ?></td>
        <td width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res32stool; ?></td>
        <td width="13%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $res32ngast; ?></td>
        <td width="13%"  align="center" valign="center" 
				class="bodytext366"><?php echo $res32others; ?></td>
        <td width="21%"  align="center" valign="center" 
				class="bodytext366"><?php echo $res32urine; ?></td>
      </tr>
      <?php
		 }
		 }
		 ?>
      <tr>
        <td width="12%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center">&nbsp;</td>
        <td width="12%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center">&nbsp;</td>
        <td width="12%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalvomit; ?></strong></td>
        <td width="12%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalstool; ?></strong></td>
        <td width="13%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalngast; ?></strong></td>
        <td width="13%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalothers; ?></strong></td>
        <td width="21%" bgcolor="#ecf0f5" class="bodytext3" valign="center"  align="center"><strong><?php echo $totalurine; ?></strong></td>
      </tr>
	  
    </table></td>
  </tr>
  <?php $totalintake = $totalbottle + $totalinfused + $totalamount; ?>
  <?php $totaloutput = $totalvomit + $totalstool + $totalngast + $totalothers + $totalurine; ?>
  <?php $totalbalance = $totalintake - $totaloutput; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bodytext32" colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bodytext32" colspan="2" valign="top"><strong>Total Intake: <?php echo $totalintake; ?></strong></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bodytext32" colspan="2" valign="top"><strong>Total Output: <?php echo $totaloutput; ?></strong></td>
    </tr>
	<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="bodytext32" colspan="2" valign="top"><strong>Total Balance: <?php echo $totalbalance; ?></strong></td>
    </tr> 
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
    <td width="0%">&nbsp;</td>
	<td width="0%">&nbsp;</td>
    <td width="60%" valign="top"><span class="bodytext32">User Name:
        <input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $res31username; ?>" readonly="readonly">
        <?php echo strtoupper($res31username); ?></span></td>
    <td width="40%" valign="top">&nbsp;</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>