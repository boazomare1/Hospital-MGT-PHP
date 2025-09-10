<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$snocount = "";
$colorloopcount = "";

if (isset($_REQUEST["locationcode"])) {
$locationcode1 = $_REQUEST["locationcode"];
} else {
$locationcode1 = "";
}
if (isset($_REQUEST["ADate1"])) {
$ADate1 = $_REQUEST["ADate1"];
$paymentreceiveddateto = $ADate1;
} else {
$ADate1 = "";
}
if (isset($_REQUEST["ADate2"])) {
$ADate2 = $_REQUEST["ADate2"];
$paymentreceiveddateto = $ADate2;
} else {
$ADate2 = "";
}
if (isset($_REQUEST["cbfrmflag2"])) {
$cbfrmflag2 = $_REQUEST["cbfrmflag2"];
} else {
$cbfrmflag2 = "";
}
if (isset($_REQUEST["frmflag2"])) {
$frmflag2 = $_REQUEST["frmflag2"];
} else {
$frmflag2 = "";
}
if (isset($_REQUEST["range"])) {
$range = $_REQUEST["range"];
} else {
$range = "";
}
if (isset($_REQUEST["ageinp"])) {
$ageinp = $_REQUEST["ageinp"];
} else {
$ageinp = "";
}
if (isset($_REQUEST["dmy"])) {
$dmy = $_REQUEST["dmy"];
} else {
$dmy = "";
}

$query = "select * from login_locationdetails where username='$username' and docno = '$docno'";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

$locationname = $res["locationname"];
$locationcode = $res["locationcode"];
?>


<style type="text/css">
body {
margin-left: 0px;
margin-top: 0px;
background-color: #ecf0f5;
}

.bodytext3 {
FONT-WEIGHT: normal;
FONT-SIZE: 11px;
COLOR: #3B3B3C;
FONT-FAMILY: Tahoma
}
</style>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<style type="text/css">
.bodytext3 {
FONT-WEIGHT: normal;
FONT-SIZE: 11px;
COLOR: #3b3b3c;
FONT-FAMILY: Tahoma;
text-decoration: none
}

.bodytext31 {
FONT-WEIGHT: normal;
FONT-SIZE: 11px;
COLOR: #3b3b3c;
FONT-FAMILY: Tahoma;
text-decoration: none
}

.bodytext311 {
FONT-WEIGHT: normal;
FONT-SIZE: 11px;
COLOR: #3b3b3c;
FONT-FAMILY: Tahoma;
text-decoration: none
}

.bal {
border-style: none;
background: none;
text-align: right;
}

.bali {
text-align: right;
}
</style>

</head>

<script src="js/datetimepicker_css.js"></script>

<?php //include("includes/header.php");  ?>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td colspan="10" bgcolor="#6487DC"><?php include("includes/alertmessages1.php"); 
?></td>
</tr>
<tr>
<td colspan="10" bgcolor="#8CAAE6"><?php include("includes/title1.php"); 
?></td>
</tr>
<tr>
<td colspan="10" bgcolor="#ecf0f5"><?php include("includes/menu1.php"); 
?></td>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>
<tr>
<td width="1%">&nbsp;</td>
<td width="2%" valign="top"><?php //include ("includes/menu4.php"); 
?>
&nbsp;</td>
<td width="97%" valign="top">
<table width="116%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="860">


<form name="cbform1" method="post" action="moh706.php">
<table width="634" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
<tbody>
<tr bgcolor="#011E6A">
<td align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3">
<strong>Location</strong>
</td>
<td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">
<select name="locationcode">
<?php
$query20 = "select * FROM master_location where locationcode = '$locationcode'";
$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die("Error in Query20" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res20 = mysqli_fetch_array($exec20)) {
echo "<option value=" . $res20['locationcode'] . ">" . $res20['locationname'] . "</option>";
}
?>
</select>
</td>





</tr>
</tr>
<tr>
<td width="10%" align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"> <strong>From
Date</strong> </td>
<td width="30%" align="left" valign="top" bgcolor="#FFFFFF"><span class="bodytext3">
<input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer" /></span></td>
<td width="10%" align="left" valign="middle" bgcolor="#FFFFFF" class="bodytext3"><strong>To
Date</strong> </td>
<td width="30%" align="left" valign="top" bgcolor="#FFFFFF"><span class="bodytext3">
<input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer" /></span></td>
</tr>
<tr>
<td align="left" valign="top" bgcolor="#FFFFFF"></td>
<td colspan="3" align="left" valign="top" bgcolor="#FFFFFF">
<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
<input type="submit" value="Search" name="Submit" class="button" />
<input name="resetbutton" type="reset" id="resetbutton" value="Reset" class="resetbutton" />
</td>
</tr>
</tbody>
</table>
</form>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>
<?php if (isset($_POST['Submit'])) { ?>
<tr>
<td class="bodytext31" valign="center" align="centre">
<a target="_blank" href="xl_moh706.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode=<?php echo $locationcode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
</td>
</tr>

<?php
$newVisitsA1 = 0;
$revisitsA1 = 0;
$totalVisitsA1 = 0;
function generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2)
{

$resultValueClause = "$resultValue";
$itemNameClause = "$itemName";
$referenceNameClause = "$referenceName";
$queryLab = "select count(patientcode) as count7 from resultentry_lab where  $resultValueClause $itemNameClause $referenceNameClause and locationcode='$locationcode' and recorddate between '$ADate1' and '$ADate2' ";

$execLab = mysqli_query($GLOBALS["___mysqli_ston"], $queryLab) or die("Error in QueryLab" . mysqli_error($GLOBALS["___mysqli_ston"]));

while ($resLab = mysqli_fetch_array($execLab)) {
echo $resLab["count7"];

return $resLab["count7"];
}
}






?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" align="left" border="1">
<tbody>

<tr>
<td align="center" valign="center" bgcolor="#CCCCCC" class="bodytext31" colspan="4">
<strong>LABORATORY TESTS DATA SUMMARY REPORT FORM.</strong>
</td>
</tr>
<tr bgcolor="#011E6A">
<td bgcolor="#CCCCCC" colspan="4" valign="center" align="center" bgcolor="#ffffff" class="bodytext3"><strong>MOH 706</strong></td>

</tr>






<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
1. URINE ANALYSIS</strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td width="20%" align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Details</strong>
</td>
<td width="3%" align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Total Exam</strong>
</td>
<td width="6%" align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>
</td>

</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> 1.1 Urine
Chemistry</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php


				  $itemName = "itemname like '%urin%' and ";
				  $referenceName = "referencename like '%chem%'";
				  $resultValue = "";

				  generateLabSpecifics($itemName, $resultValue, $referenceName, $locationcode, $ADate1, $ADate2);

				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$resultValue = "resultvalue LIKE '%positive%' and";
$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%chem%'";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>

<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.2
Glucose</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php


				  $itemName = "itemname like '%glucose%'";
				  $resultValue = "";
				  $referenceName = "";
				  generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);



				  ?></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$resultValue = "resultvalue >=8.0 and";
$itemName = "itemname like '%glucose%'";
$referenceName = "";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.3
Ketones</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$resultValue = "";
$itemName = "itemname like '%urine%' and";
$referenceName = " referencename like '%Ketones%'";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$resultValue = "resultvalue like '+' and ";
$itemName = "itemname like '%urine%' and ";
$referenceName = " referencename like '%Ketones%'";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.4
Proteins</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$resultValue = "";
$itemName = "itemname like '%urine%' and ";
$referenceName = "referencename like '%protei%'";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);

?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$resultValue = "resultvalue like '%positive%' and";
$itemName = "itemname like '%urine%' and ";
$referenceName = "referencename like '%protein%'";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);

?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.5 Urine
Microscopy</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%micro%' ";
$resultValue = "";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);


?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$resultValue = "resultvalue LIKE '%positive%' and";
$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%micro%'";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);


?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.6 Pus
Cell</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%pus%'";
$resultValue = "";
generateLabSpecifics($resultValue, $itemName, $referenceName, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%pus%' and";
$resultValue = "resultvalue >5";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.7
S.haematobium</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%haema%' ";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2); ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%urin%' and ";
$referenceName = "referencename like '%haema%' and";
$resultValue = "resultvalue >5";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2); ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.8
Vaginalis</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "";
$referenceName = "referencename like '%vagina%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2); ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%HVS%' and ";
$referenceName = "referencename like '%vagina%' and";
$resultValue = "resultvalue = 'present'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2); ?>
</td>

</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.9 Yeast
Cells</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%hvs%' and";
$referenceName = "referencename like '%yeast%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%hvs%' and";
$referenceName = "referencename like '%yeast%'and ";
$resultValue = "resultvalue like '%present%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2); ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">1.10
Bacteria</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Bacteria%' and";
$referenceName = "referencename like '%Bacteria%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Bacteria%' and";
$referenceName = "referencename like '%Bacteria%'and ";
$resultValue = "resultvalue like '%present%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
2.
BLOOD CHEMISTRY</strong></td>
</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Blood Sugar Test</strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam</strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Low</strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
High</strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.1 Blood
Sugar</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Blood
Sugar%' and";
$referenceName = "referencename like '%Blood
Sugar%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Blood
Sugar%' and";
$referenceName = "referencename like '%Blood
Sugar%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Blood
Sugar%' and";
$referenceName = "referencename like '%Blood
Sugar%'and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.2 OGTT
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%OGTT%' and";
$referenceName = "referencename like '%OGTT%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%OGTT%' and";
$referenceName = "referencename like '%OGTT%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%OGTT%' and";
$referenceName = "referencename like '%OGTT%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.3 Renal
Function Test</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Function Test%' and";
$referenceName = "referencename like '%Function Test%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Function Test%' and";
$referenceName = "referencename like '%Function Test%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Function Test%' and";
$referenceName = "referencename like '%Function Test%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.4
Creatinine</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%CREATININE%' and";
$referenceName = "referencename like '%CREATININE%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%CREATININE%' and";
$referenceName = "referencename like '%CREATININE%' and";
$resultValue = "resultvalue < 70";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%CREATININE%' and";
$referenceName = "referencename like '%CREATININE%' and";
$resultValue = "resultvalue > 70";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.5 Urea
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%urea%' and";
$referenceName = "referencename like '%urea%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%urea%' and";
$referenceName = "referencename like '%urea%'and";
$resultValue = "resultvalue <7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%urea%' and";
$referenceName = "referencename like '%urea%' and ";
$resultValue = "resultvalue >7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.6
Sodium</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%sodium%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%sodium%'and";
				  $resultValue = "resultvalue < 135";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%sodium%' and";
				  $resultValue = "resultvalue > 135";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.7
Chlorides</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%Chloride%' ";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%Chloride%'and";
				  $resultValue = "resultvalue < 103";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%Chloride%' and";
				  $resultValue = "resultvalue >= 103";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.8 Liver
Function Test</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%'";
				  $referenceName = "";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%'and";
				  $referenceName = "";
				  $resultValue = "resultvalue <50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "";
				  $resultValue = "resultvalue >=50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.9 Direct
Billrubin</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%direct BILIRUBIN%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%DIRECT BILIRUBIN%' and";
				  $resultValue = "resultvalue <7";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%DIRECT BILIRUBIN%' and";
				  $resultValue = "resultvalue >=7";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.10 Total
Billrubin</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
$referenceName = "referencename like '%BILIRUBIN TOTAL%' ";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%BILIRUBIN TOTAL%' and";
				  $resultValue = "resultvalue <7";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%BILIRUBIN TOTAL%' and";
				  $resultValue = "resultvalue >=7";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.11 ASAT
(SGOT)</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%SGOT%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%SGOT%' and";
				  $resultValue = "resultvalue <50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%SGOT%' and";
				  $resultValue = "resultvalue >=50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.12 ASAT
(SGPT)</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%SGPT%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%SGPT%' and";
				  $resultValue = "resultvalue <50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%SGPT%' and";
				  $resultValue = "resultvalue >=50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.13 Serum
Protein</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%blood%' and";
				  $referenceName = "referencename like '%serum%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%blood%' and";
				  $referenceName = "referencename like '%serum%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%serum%' and";
				  $referenceName = "referencename like '%serum%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.14
Albumin</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%ALBUMIN%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%ALBUMIN%' and";
				  $resultValue = "resultvalue < 50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
				  $referenceName = "referencename like '%ALBUMIN%' and";
				  $resultValue = "resultvalue >=50";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.15
Alkaline Phosphatase</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%ALKALINE PHOSPHATASE%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%ALKALINE PHOSPHATASE%' and";
				  $resultValue = "resultvalue < 100";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%ALKALINE PHOSPHATASE%' and";
				  $resultValue = "resultvalue >= 100";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.16 Lipid
Profile</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%'";
				  $referenceName = "";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "";
				  $resultValue = "resultvalue < 3.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE - FASTING LIPID PROFILE%' and";
				  $referenceName = "";
				  $resultValue = "resultvalue >= 3.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.17 Total
Cholestrol</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%CHOLESTROL%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%CHOLESTROL%' and";
				  $resultValue = "resultvalue < 5.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%CHOLESTROL%' and";
				  $resultValue = "resultvalue >=5.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.18
Trigylcerides</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%TRIGLYCERIDE%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%TRIGLYCERIDE%' and";
				  $resultValue = "resultvalue < 3.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%TRIGLYCERIDE%'and";
				  $resultValue = "resultvalue >= 3.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.19 LDL
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%LDL CHOLESTROL%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%LDL CHOLESTROL%' and";
				  $resultValue = "resultvalue < 3.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%LIPID PROFILE%' and";
				  $referenceName = "referencename like '%LDL CHOLESTROL%'and";
				  $resultValue = "resultvalue >3.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Hormonal Test </strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam </strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Low </strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
High </strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.21 TRIIODTHYRONINE / T3
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%TRIIODTHYRONINE / T3%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%TRIIODTHYRONINE / T3%' and ";
				  $resultValue = "resultvalue < 5.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%TRIIODTHYRONINE / T3%' and";
				  $resultValue = "resultvalue >=5.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.22 T4
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%FREE T4%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%FREE T4%' and";
				  $resultValue = "resultvalue < 7.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "";
				  $referenceName = "referencename like '%FREE T4%' and";
				  $resultValue = "resultvalue >= 7.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.23 PSA
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%PROSTATE SPECIFIC ANTIGEN%' and";
				  $referenceName = "referencename like '%PSA TOTAL%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%PROSTATE SPECIFIC ANTIGEN%' and";
				  $referenceName = "referencename like '%PSA TOTAL%' and ";
				  $resultValue = "resultvalue <7.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
				  $itemName = "itemname like '%PROSTATE SPECIFIC ANTIGEN%' and";
				  $referenceName = "referencename like '%PSA TOTAL%' and";
				  $resultValue = "resultvalue >= 7.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Tumor Markers </strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam </strong></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.24 CEA
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
					$itemName = "itemname like '%CARCINO EMBRYONIC ANTIGEN%' and";
					$referenceName = "referencename like '%CARCINO EMBRYONIC ANTIGEN%'";
					$resultValue = "";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
								$itemName = "itemname like '%CARCINO EMBRYONIC ANTIGEN%' and";
								$referenceName = "referencename like '%CARCINO EMBRYONIC ANTIGEN%' and";
								$resultValue = "resultvalue >= 7";
								generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
								?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.25 C15-3
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
					$itemName = "itemname like '%C15%' and";
					$referenceName = "referencename like '%C15%'";
					$resultValue = "";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
								$itemName = "itemname like '%C15%' and";
								$referenceName = "referencename like '%C15%' and";
								$resultValue = "resultvalue >= 7.0";
								generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
								?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
CFS Chemistry </strong></td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam </strong></td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Low</strong>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>High</strong>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.26
Proteins
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
					$itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
					$referenceName = "referencename like '%PROTEINS TOTAL%'";
					$resultValue = "";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
					$itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
					$referenceName = "referencename like '%PROTEINS TOTAL%' and";
					$resultValue = "resultvalue <82";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php
					$itemName = "itemname like '%LIVER FUNCTION TESTS%' and";
					$referenceName = "referencename like '%PROTEINS TOTAL%' and";
					$resultValue = "resultvalue >=82";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">2.27
Glucose</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%GLUCOSE TOLERANCE TEST%' and";
				  $referenceName = "referencename like '%GLUCOSE%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%GLUCOSE TOLERANCE TEST%' and";
				  $referenceName = "referencename like '%GLUCOSE%' and";
				  $resultValue = "resultvalue < 9.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%GLUCOSE TOLERANCE TEST%' and";
				  $referenceName = "referencename like '%GLUCOSE%' and";
				  $resultValue = "resultvalue >=9.0";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>


</tr>
<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
3. PARASITOLOGY </strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Malaria Test </strong></td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam
</strong>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number Positive
</strong>
</td>


<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
3.1 Malaria </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%MALARIA%' and";
$referenceName = "referencename like '%MALARIA %'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%MALARIA %' and";
$referenceName = "referencename like '%MALARIA %' and";
$resultValue = "resultvalue like '%POSITIVE%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);


?>

</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
3.2 Malaria Rapid Diagnostic Tests</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%malaria rapid diagnotics%' and";
				  $referenceName = "referencename like '%malaria rapid diagnotics%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);


				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%malaria rapid diagnotics%' and";
							  $referenceName = "referencename like '%malaria rapid diagnotics%' and";
							  $resultValue = "resultvalue like '%POSITIVE%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);


							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Stool Examination </strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam
</strong>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number Positive
</strong>
</td>


<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">3.4 Taenia
Spp</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%teania%' and";
$referenceName = "referencename like '%teania%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);



?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%teania%' and";
$referenceName = "referencename like '%teania%' and";
$resultValue = "resultvalue = 'positive'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);


?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
3.5 Hymenolepis nana</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%Hymenolepis nana%' and";
$referenceName = "referencename like '%Hymenolepis nana%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%Hymenolepis nana%' and";
$referenceName = "referencename like '%Hymenolepis nana%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">3.5
Hookworms</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%hookworms%' and";
$referenceName = "referencename like '%hookworms%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%hookworms%' and";
$referenceName = "referencename like '%hookworms%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
3.7 Roundworms</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%Roundworms%' and";
$referenceName = "referencename like '%Roundworms%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php

$itemName = "itemname like '%Roundworms%' and";
$referenceName = "referencename like '%Roundworms%' and";
$resultValue = "resultvalue = '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);

?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">3.9
Trichuris trichura</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php


$itemName = "itemname like '%Trichu%' and";
$referenceName = "referencename like '%Trichu%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);




?></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">

<?php $itemName = "itemname like '%Trichu%' and";
$referenceName = "referencename like '%Trichu%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
3.10 Amoeba</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Amoeba%' and";
$referenceName = "referencename like '%Amoeba%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Amoeba%' and";
$referenceName = "referencename like '%Amoeba%'and";
$resultValue = "resultvalue < 7.0";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Amoeba%' and";
$referenceName = "referencename like '%Amoeba%' and";
$resultValue = "resultvalue >= 7.0";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>

<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>4. HAEMATOLOGY </strong>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <strong>
Haematology Test </strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam</strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
HB < 5 g/dl </strong>
</td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
HB between 5 and 10 g/dl </strong></td>
</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.1 Full Blood Count</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%TOTAL BLOOD COUNT%'";
$referenceName = "";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%TOTAL BLOOD COUNT%' and";
$referenceName = "";
$resultValue = "resultvalue < 5";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%TOTAL BLOOD COUNT%' and";
$referenceName = "";
$resultValue = "resultvalue >= 5";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.2 HB Estimation Tests (Other Techniques)</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%HB Estimation %' and";
$referenceName = "referencename like '%HB Estimation %'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%HB Estimation %' and";
$referenceName = "referencename like '%HB Estimation %' and";
$resultValue = "resultvalue < 5";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%HB Estimation %' and";
$referenceName = "referencename like '%HB Estimation %' and";
$resultValue = "resultvalue >= 5";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <strong>
</strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam</strong></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number < 500 </strong>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.3 CD4 Count</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%CD4 Count%' and";
				  $referenceName = "referencename like '%CD4 Count%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%CD4 Count%' and";
				  $referenceName = "referencename like '%CD4 Count%' and";
				  $resultValue = "resultvalue < 5";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%CD4 Count%' and";
				  $referenceName = "referencename like '%CD4 Count%' and";
				  $resultValue = "resultvalue >= 5";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <strong>
Other Haematology Tests</strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam</strong></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number Positive </strong></td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.4 Sickling Test</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Sickling Test%' and";
				  $referenceName = "referencename like '%Sickling Test%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Sickling Test%' and";
				  $referenceName = "referencename like '%Sickling Test%' and";
				  $resultValue = "resultvalue < 7";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Sickling Test%' and";
				  $referenceName = "referencename like '%Sickling Test%' and";
				  $resultValue = "resultvalue >= 7";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.5 Peripheral Blood Films </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Peripheral%' and";
$referenceName = "referencename like '%Peripheral%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Peripheral%' and";
$referenceName = "referencename like '%Peripheral%' and";
$resultValue = "resultvalue >= 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.6 BMA </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%BMA%' and";
$referenceName = "referencename like '%BMA%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%BMA%' and";
$referenceName = "referencename like '%BMA%' and";
$resultValue = "resultvalue < 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%BMA%' and";
$referenceName = "referencename like '%BMA%' and";
$resultValue = "resultvalue >=7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.7 Coagulation Profile </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Coagulation%' ";
$referenceName = "";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Coagulation%' and";
$referenceName = "";
$resultValue = "resultvalue < 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Coagulation%' and";
$referenceName = "";
$resultValue = "resultvalue >= 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.8 Reticulocyte Count </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Reticulocyte%' and";
$referenceName = "referencename like '%Reticulocyte%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Reticulocyte%' and";
$referenceName = "referencename like '%Reticulocyte%' and";
$resultValue = "resultvalue < 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Reticulocyte%' and";
$referenceName = "referencename like '%Reticulocyte%' and";
$resultValue = "resultvalue >= 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Blood Grouping</strong></td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number</strong></td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.10 Total Blood Group Tests </td>
<td align="center" colspan=3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%BLOOD GROUP%' and";
$referenceName = "referencename like '%BLOOD GROUP%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.11 Blood Units Grouped </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%BLOOD GROUP%' and";
								$referenceName = "referencename like '%BLOOD GROUP%'";
								$resultValue = "";
								generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
								?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Blood Safety</strong>
</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number </strong>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.12 Blood Units recieved from blood transfusion centers</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%blood transfusion %' and";
							  $referenceName = "referencename like '%blood transfusion %'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.13 Blood Units collected at facility</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Blood Units collected%' and";
							  $referenceName = "referencename like '%Blood Units collected%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.14 Blood Units transfused </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Blood Units transfused%' and";
$referenceName = "referencename like '%Blood Units transfused%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.15 Transfusion reactions reported and investigated </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Transfusion reactions%' and";
$referenceName = "referencename like '%Transfusion reactions%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.16 Blood cross matched</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%cross matched%' and";
$referenceName = "referencename like '%cross matched%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.17 Blood Units discarded </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Blood Units discarded%' and";
$referenceName = "referencename like '%Blood Units discarded%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Blood Screening at Facility</strong>
</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.18 HIV </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%C002-HIV%' and";
$referenceName = "referencename like '%C002-HIV%' and";
$resultValue = "resultvalue like '%positive%' ";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.19 Hepatitis B </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%HEPATITIS B%' and";
$referenceName = "referencename like '%HEPATITIS B%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
4.19 Syphilis </td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Syphilis%' and";
$referenceName = "referencename like '%Syphilis%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>


<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%hvs%' and";
$referenceName = "referencename like '%yeast%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
<strong>5. BACTERIOLOGY </strong>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Bacteriology Sample</strong>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Total Exam</strong>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Total Cultures</strong>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>No. Culture Positive</strong>
</td>
</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.1 Urine </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Urine%' and";
$referenceName = "referencename like '%Urine%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Urine%' and";
$referenceName = "referencename like '%Urine%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Urine%' and";
$referenceName = "referencename like '%Urine%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.2 Pus Swabs</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Pus Swabs%' and";
$referenceName = "referencename like '%Pus Swabs%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Pus Swabs%' and";
$referenceName = "referencename like '%Pus Swabs%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Pus Swabs%' and";
$referenceName = "referencename like '%Pus Swabs%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.3 High Vaginal Swabs</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Vaginal Swabs%' and";
$referenceName = "referencename like '%Vaginal Swabs%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Vaginal Swabs%' and";
$referenceName = "referencename like '%Vaginal Swabs%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Vaginal Swabs%' and";
$referenceName = "referencename like '%Vaginal Swabs%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.4 Throat Swab</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Throat Swab%' and";
				  $referenceName = "referencename like '%Throat Swab%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Throat Swab%' and";
				  $referenceName = "referencename like '%Throat Swab%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Throat Swab%' and";
$referenceName = "referencename like '%Throat Swab%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.5 Rectal Swab</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Rectal Swab%' and";
$referenceName = "referencename like '%Rectal Swab%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Rectal Swab%' and";
$referenceName = "referencename like '%Rectal Swab%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Rectal Swab%' and";
$referenceName = "referencename like '%Rectal Swab%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.6 Blood </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Blood%' and";
$referenceName = "referencename like '%Blood%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Blood%' and";
$referenceName = "referencename like '%Blood%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Blood%' and";
$referenceName = "referencename like '%Blood%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.7 Water </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Water%' and";
$referenceName = "referencename like '%Water%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Water%' and";
$referenceName = "referencename like '%Water%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Water%' and";
$referenceName = "referencename like '%Water%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.8 Food </td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Food%' and";
$referenceName = "referencename like '%Food%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Food%' and";
$referenceName = "referencename like '%Food%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Food%' and";
$referenceName = "referencename like '%Food%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.9 Urethral Swabs</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Urethral Swabs%' and";
$referenceName = "referencename like '%Urethral Swabs%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Urethral Swabs%' and";
$referenceName = "referencename like '%Urethral Swabs%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Urethral Swabs%' and";
$referenceName = "referencename like '%Urethral Swabs%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Bacterial enteric pathogens</strong>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Total Exam</strong>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>
</td>

</tr>


<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.10 Stool Cultures</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Stool Cultures%' and";
$referenceName = "referencename like '%Stool Cultures%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Stool Cultures%' and";
$referenceName = "referencename like '%Stool Cultures%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.11 Salmonella Typhi</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Salmonella Typhi%' and";
$referenceName = "referencename like '%Salmonella Typhi%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%Salmonella Typhi%' and";
$referenceName = "referencename like '%Salmonella Typhi%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.12 Shigella - dysenteriee</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%dysenteriee%' and";
$referenceName = "referencename like '%dysenteriee%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%dysenteriee%' and";
$referenceName = "referencename like '%dysenteriee%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.13 E coli O 157:H7</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%E coli%' and";
$referenceName = "referencename like '%E coli%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%E coli%' and";
$referenceName = "referencename like '%E coli%' and";
$resultValue = "resultvalue like '%+%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.14 V.cholerae O1</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%V.cholerae%' and";
					$referenceName = "referencename like '%V.cholerae%'";
					$resultValue = "";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%V.cholerae%' and";
								$referenceName = "referencename like '%V.cholerae%'";
								$resultValue = "";
								generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
								?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.15 V.Cholerae O139</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Cholerae O139%' and";
					$referenceName = "referencename like '%Cholerae O139%'";
					$resultValue = "";
					generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
					?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <?php $itemName = "itemname like '%Cholerae O139%' and";
								$referenceName = "referencename like '%Cholerae O139%'";
								$resultValue = "";
								generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
								?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Bacterial Meningitis </strong>
</td>
</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <strong>
Bacterial Menengitis <strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam<strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number Positive<strong></td>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Number Contaminated<strong></td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.16 CSF</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%CSF%' and";
$referenceName = "referencename like '%CSF%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php $itemName = "itemname like '%CSF%' and";
$referenceName = "referencename like '%CSF%' and";
$resultValue = "resultvalue > 7";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?></td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%CSF%' and";
$referenceName = "referencename  < 5 ";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <strong>
Bacterial Menengitis Serotype</strong></td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.17 Neisserie Meningitis A</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%meningitis A%' and";
							  $referenceName = "referencename like '%meningitis A%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.18 Neisserie Meningitis B</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%meningitis B%' and";
							  $referenceName = "referencename like '%meningitis B%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.19 Neisserie Meningitis C</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%meningitis B%' and";
							  $referenceName = "referencename like '%yeast B%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.20 Neisserie Meningitis W135</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%meningitis W135 %' and";
							  $referenceName = "referencename like '%Meningitis W135%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.21 Neisserie Meningitis X</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Meningitis X%' and";
							  $referenceName = "referencename like '%Meningitis X%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.22 Neisserie Meningitis Y</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Meningitis Y%' and";
							  $referenceName = "referencename like '%Meningitis Y%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.23 Neisserie Meningitis (indeterminate)</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Meningitis (indeterminate)%' and";
							  $referenceName = "referencename like '%Meningitis (indeterminate)%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.24 Streptoccus pneumoniae</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Streptoccus pneumoniae%' and";
							  $referenceName = "referencename like '%Streptoccus pneumoniae%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.25 Haemophilus Influenzae (type b)</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Influenzae (type b%' and";
							  $referenceName = "referencename like '%Influenzae (type b) %' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.26 Cryptococcal Meningitis</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Cryptococcal Meningitis%' and";
							  $referenceName = "referencename like '%Cryptococcal Meningitis%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Bacterial Pathogens from other type of specimen</strong>
</td>

</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.27 B.entrac is</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%entrac is%' and";
							  $referenceName = "referencename like '%entrac is%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.28 Y. pestis</td>
<td align="center" colspan="3" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%hvs%' and";
							  $referenceName = "referencename like '%yeast%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>SPUTUM</strong>
</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Total Exam</strong>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.29 Total TB smears</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%TB smears%' and";
$referenceName = "referencename like '%TB smears%'";
$resultValue = "";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<?php
$itemName = "itemname like '%TB smears%' and";
$referenceName = "referencename like '%TB smears%' and";
$resultValue = "resultvalue like '%positive%'";
generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.30 TB new suspects</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%new suspects%' and";
				  $referenceName = "referencename like '%new suspects%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%new suspects%' and";
							  $referenceName = "referencename like '%new suspects%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.31 TB FOllow Up</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%TB FOllow Up%' and";
				  $referenceName = "referencename like '%TB FOllow Up%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%TB FOllow Up%' and";
							  $referenceName = "referencename like '%TB FOllow Up%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.32 GeneXpert</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%GeneXpert%' and";
				  $referenceName = "referencename like '%GeneXpert%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%GeneXpert%' and";
							  $referenceName = "referencename like '%GeneXpert%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
5.33 MDR TB</td>
<td align="right" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%MDR TB%' and";
				  $referenceName = "referencename like '%MDR TB%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="right" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%MDR TB%' and";
							  $referenceName = "referencename like '%MDR TB%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>6. HISTOLOGY AND CYTOLOGY </strong>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"> <strong>
Smear <strong></td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Total Exam<strong></td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Malignant<strong></td>

</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.1 PAP Smear </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "";
				  $referenceName = "referencename like '%PAP Smear%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "";
							  $referenceName = "referencename like '%PAP Smear%' and";
							  $resultValue = " resultvalue != 'To follow'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.2 Touch Preparations </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "";
				  $referenceName = "referencename like '%Touch Preparations%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "";
							  $referenceName = "referencename like '%Touch Preparations%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.3 Tissue Impressions </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Tissue Impressions %' and";
				  $referenceName = "referencename like '%Tissue Impressions %'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Tissue Impressions %' and";
							  $referenceName = "referencename like '%Tissue Impressions %' AND";
							  $resultValue = " resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.4 Thyroid </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%THYROID%' and";
				  $referenceName = "referencename like '%THYROID%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%THYROID%' and";
							  $referenceName = "referencename like '%THYROID%' and";
							  $resultValue = "resultvalue > 9.0";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.5 Lymph Nodes </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Lymph Nodes%' and";
				  $referenceName = "referencename like '%Lymph Nodes%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Lymph Nodes%' and";
							  $referenceName = "referencename like '%Lymph Nodes%' and";
							  $resultValue = "resultvalue > 10.0";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>


<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.6 Liver </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
				  $referenceName = "referencename like '%LIVER FUNCTION TESTS (LFT)%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%LIVER FUNCTION TESTS (LFT)%' and";
							  $referenceName = "referencename like '%LIVER FUNCTION TESTS (LFT)%' and";
							  $resultValue = "resultvalue > 60.0";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.7 Breast </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Breast%' and";
				  $referenceName = "referencename like '%Breast%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Breast%' and";
							  $referenceName = "referencename like '%Breast%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.8 Soft Tissues masses </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Tissues masses%' and";
				  $referenceName = "referencename like '%Tissues masses%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Tissues masses%' and";
							  $referenceName = "referencename like '%Tissues masses%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
Fluid Cytology </strong> </td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.9 Ascitic Fluid </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Ascitic Fluid%' and";
				  $referenceName = "referencename like '%Ascitic Fluid%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Ascitic Fluid%' and";
							  $referenceName = "referencename like '%Ascitic Fluid%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.10 CSF </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%CSF%' and";
				  $referenceName = "referencename like '%CSF%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%CSF%' and";
							  $referenceName = "referencename like '%CSF%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.11 Pleural fluid </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Pleural fluid%' and";
				  $referenceName = "referencename like '%Pleural fluid%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Pleural fluid%' and";
							  $referenceName = "referencename like '%Pleural fluid%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.12 Urine </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Urine%' and";
				  $referenceName = "referencename like '%Urine%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Urine%' and";
							  $referenceName = "referencename like '%Urine%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Tissue Histology</strong>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.13 Cervix </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Cervix%' and";
				  $referenceName = "referencename like '%Cervix%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Cervix%' and";
							  $referenceName = "referencename like '%Cervix%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>


</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.14 Prostrate </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Prostrate%' and";
				  $referenceName = "referencename like '%Prostrate%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Prostrate%' and";
							  $referenceName = "referencename like '%Prostrate%'and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.15 Breast tissue </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Breast tissue%' and";
				  $referenceName = "referencename like '%Breast tissue%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Breast tissue%' and";
							  $referenceName = "referencename like '%Breast tissue%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.16 Ovary </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Ovary%' and";
				  $referenceName = "referencename like '%Ovary%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Ovary%' and";
							  $referenceName = "referencename like '%Ovary%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.17 Uterus </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Uterus%' and";
				  $referenceName = "referencename like '%Uterus%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Uterus%' and";
							  $referenceName = "referencename like '%Uterus%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.18 Skin </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Skin%' and";
				  $referenceName = "referencename like '%Skin%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Skin%' and";
							  $referenceName = "referencename like '%Skin%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.19 Head and Neck </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Head and Neck%' and";
				  $referenceName = "referencename like '%Head and Neck%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Head and Neck%' and";
							  $referenceName = "referencename like '%Head and Neck%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.20 Dental </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Dental%' and";
				  $referenceName = "referencename like '%Dental%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Dental%' and";
							  $referenceName = "referencename like '%Dental%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.21 GIT </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%GIT%' and";
				  $referenceName = "referencename like '%GIT%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%GIT%' and";
							  $referenceName = "referencename like '%GIT%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.22 Lymphs nodes tissue </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%nodes tissue%' and";
				  $referenceName = "referencename like '%nodes tissue%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%nodes tissue%' and";
							  $referenceName = "referencename like '%nodes tissue%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Bone Marrow Studies</strong>
</td>


</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.23 Bone Marrow aspirate </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Marrow aspirate%' and";
				  $referenceName = "referencename like '%Marrow aspirate%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Marrow aspirate%' and";
							  $referenceName = "referencename like '%Marrow aspirate%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
6.24 Trephine Biopsy </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Trephine Biopsy%' and";
				  $referenceName = "referencename like '%Trephine Biopsy%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Trephine Biopsy%' and";
							  $referenceName = "referencename like '%Trephine Biopsy%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>
7. SEROLOGY </strong></td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>Serological
Test</strong>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>Total
Exam</strong>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Number Positive</strong>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.1 VDRL </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%VDRL%' and";
				  $referenceName = "referencename like '%VDRL%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%VDRL%' and";
							  $referenceName = "referencename like '%VDRL%'and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.2 TPHA </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%TPHA%' and";
				  $referenceName = "referencename like '%TPHA%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%TPHA%' and";
							  $referenceName = "referencename like '%TPHA%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.3 ASOT </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%ASOT%' and";
				  $referenceName = "referencename like '%ASOT%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%ASOT%' and";
							  $referenceName = "referencename like '%ASOT%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.4 HIV </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%HIV%' and";
				  $referenceName = "referencename like '%HIV%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%HIV%' and";
							  $referenceName = "referencename like '%HIV%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.5 Brucella </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Brucella%' and";
				  $referenceName = "referencename like '%Brucella%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Brucella%' and";
							  $referenceName = "referencename like '%Brucella%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.6 Rheumatoid Factor </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Rheumatoid Factor%' and";
				  $referenceName = "referencename like '%Rheumatoid Factor%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Rheumatoid Factor%' and";
							  $referenceName = "referencename like '%Rheumatoid Factor%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.7 Helicobacter Pylori</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Pylori%' and";
				  $referenceName = "referencename like '%Pylori%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Pylori%' and";
							  $referenceName = "referencename like '%Pylori%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.8 Hepatitis A Test </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Hepatitis A%' and";
				  $referenceName = "referencename like '%Hepatitis A%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Hepatitis A%' and";
							  $referenceName = "referencename like '%Hepatitis A%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.9 Hepatitis B Test </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Hepatitis B%' and";
				  $referenceName = "referencename like '%Hepatitis B%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Hepatitis B%' and";
							  $referenceName = "referencename like '%Hepatitis B%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.10 Hepatitis C Test </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Hepatitis C%' and";
				  $referenceName = "referencename like '%Hepatitis C%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Hepatitis C%' and";
							  $referenceName = "referencename like '%Hepatitis C%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.11 HCG </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%HCG%' and";
				  $referenceName = "referencename like '%HCG%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%HCG%' and";
							  $referenceName = "referencename like '%HCG%' and";
							  $resultValue = "resultvalue like '%positive%'";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
7.12 CRAG Test </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%CRAG Test%' and";
				  $referenceName = "referencename like '%CRAG Test%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%CRAG Test%' and";
							  $referenceName = "referencename like '%CRAG Test%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>
</tr>
<tr>
<td colspan="4" valign="center" align="center" bgcolor="#666666"></strong></td>
</tr>

<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="center" colspan="4" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>8. SPECIMEN REFERRALTO HIGHER LEVELS</strong>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>

<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>Specimen Referral</strong>
</td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31">
<strong>No of Specimens</strong>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><strong>No
of Results Recieved</strong>
</td>


</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.1 CD4 </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%CD4%' and";
				  $referenceName = "referencename like '%CD4%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%CD4%' and";
							  $referenceName = "referencename like '%CD4%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.2 Viral Load </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Viral Load%' and";
				  $referenceName = "referencename like '%Viral Load%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Viral Load%' and";
							  $referenceName = "referencename like '%Viral Load%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.3 EID </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%EID%' and";
				  $referenceName = "referencename like '%EID%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%EID%' and";
							  $referenceName = "referencename like '%EID%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.4 Discordant/Discrepant </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Discordant%' and";
				  $referenceName = "referencename like '%Discordant%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Discordant%' and";
							  $referenceName = "referencename like '%Discordant%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.5 TB Culture </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%TB Culture%' and";
				  $referenceName = "referencename like '%TB Culture%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%TB Culture%' and";
							  $referenceName = "referencename like '%TB Culture%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.6 Virological </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Virological%' and";
				  $referenceName = "referencename like '%Virological%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Virological%' and";
							  $referenceName = "referencename like '%Virological%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.7 Clinical Chemistry </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Clinical Chemistry%' and";
				  $referenceName = "referencename like '%Clinical Chemistry%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Clinical Chemistry%' and";
							  $referenceName = "referencename like '%Clinical Chemistry%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.8 Histology/Cytology </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Histology%' and";
				  $referenceName = "referencename like '%Histology%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Histology%' and";
							  $referenceName = "referencename like '%Histology%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.9 Haematological </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Haematological%' and";
				  $referenceName = "referencename like '%Haematological%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Haematological%' and";
							  $referenceName = "referencename like '%Haematological%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.10 Parasitology </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Parasitology%' and";
				  $referenceName = "referencename like '%Parasitology%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Parasitology%' and";
							  $referenceName = "referencename like '%Parasitology%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>
<?php
$snocount = $snocount + 1;
$colorloopcount = $colorloopcount + 1;
$showcolor = ($colorloopcount & 1);

if ($showcolor == 0) {
$colorcode = 'bgcolor="#CBDBFA"';
} else {
$colorcode = 'bgcolor="#ecf0f5"';
}
?>
<tr>
<td align="left" valign="center" <?php echo $colorcode; ?> class="bodytext31">
8.11 Blood Samples For Transfusion Screening </td>
<td align="center" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
				  $itemName = "itemname like '%Transfusion Screening%' and";
				  $referenceName = "referencename like '%Transfusion Screening%'";
				  $resultValue = "";
				  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
				  ?>
</td>
<td align="center" colspan="2" valign="center" <?php echo $colorcode; ?> class="bodytext31"><?php
							  $itemName = "itemname like '%Transfusion Screening%' and";
							  $referenceName = "referencename like '%Transfusion Screening%'";
							  $resultValue = "";
							  generateLabSpecifics($itemName, $referenceName, $resultValue, $locationcode, $ADate1, $ADate2);
							  ?>
</td>

</tr>


<?php } ?>
</tbody>
</table>
</td>
</tr>
</table>
</table>
<?php include("includes/footer1.php"); ?>
</body>

</html>