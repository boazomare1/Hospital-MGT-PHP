<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetitme = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$suppdateonly = date("Y-m-d");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$pagename = 'PURCHASE BILL ENTRY';

$titlestr = 'PURCHASE BILL';

include ("login1purchasedataredirect1.php");

//to redirect if there is no entry in masters category or item or customer or settings
$query91 = "select count(auto_number) as masterscount from settings_purchase where companyanum = '$companyanum'";
$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
$res91 = mysqli_fetch_array($exec91);
$res91count = $res91["masterscount"];
if ($res91count == 0)
{
	header ("location:settingspurchase1.php?svccount=firstentry");
	exit;
}


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77['allowed'];


$query88 = "select count(auto_number) as cntanum from master_purchase where lastupdate like '$thismonth%'";
$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
$res88 = mysqli_fetch_array($exec88);
$res88cntanum = $res88['cntanum'];

if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if (isset($_REQUEST["frm1submit25"])) { $frm1submit25 = $_REQUEST["frm1submit25"]; } else { $frm1submit25 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if ($frm1submit25 == 'frm1submit25')
{

}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

?>
<?php include ("includes/pagetitle1.php"); ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.style8 {COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-size: 11px;}
-->
</style>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autosuggestbudgetledger.js"></script>
<script type="text/javascript" src="js/autocomplete_ledger.js"></script>
<script type="text/javascript">
window.onload = function()
{
	var oTextbox = new AutoSuggestControlledger(document.getElementById("ledger"), new StateSuggestions());  
}
</script>
<body>
<form name="budget" id="budget" method="post" action="budgetentryfinalview.php?docno=<?php echo $docno; ?>" onSubmit="return Process1()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<tr>
    <td colspan="9" bgcolor="#ecf0f5">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="1214" border="0" cellspacing="0" cellpadding="0">
      <tr>
       <td width="96%"><table width="98%" border="0" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <tr bgcolor="#011E6A">
		  <td bgcolor="#999999" class="bodytext3" colspan="10"><strong>Budget Entry - Finalized</strong></td>
		  </tr>
		  <tr>
		  <td colspan="10" width="10%" align="left" class="bodytext3">&nbsp; </td>
		  </tr>
		   <?php
		   if(isset($_REQUEST['bview'])) { $bview = $_REQUEST['bview']; } else { $bview = ''; }
		   if(isset($_REQUEST['btype'])) { $btype = $_REQUEST['btype']; } else { $btype = ''; }
		   if(isset($_REQUEST['ledger'])) { $ledger = $_REQUEST['ledger']; } else { $ledger = ''; }
		 
		   $query6 = "select * from budgetentry where budgetno = '$docno' group by budgetno order by budgetyear";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res6 = mysqli_fetch_array($exec6))
		  {
		  $budgetno = $res6['budgetno'];
		  $budgetdate = $res6['budgetdate'];
		  $budgetname = $res6['budgetname'];
		  $budgetyear = $res6['budgetyear'];
		  $budgetby = $res6['username'];
		  $approvedby = $res6['approvedby'];
		  $locationcode = $res6['locationcode'];
		  $locationname = $res6['locationname'];
		  $sno = $sno + 1;
		  
		  $query7 = "select * from budgetentry where budgetno = '$budgetno' group by budgettype order by budgetyear";
		  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $row7 = mysqli_num_rows($exec7);
		  $res7 = mysqli_fetch_array($exec7);
		  $budgettype = $res7['budgettype'];
		  if($row7 == '2')
		  {
		  	$budgettype = 'All';
		  }
		  else
		  {
		  	$budgettype = $budgettype;
		  }
		  }
		  ?>
		   <tr>
		  <td width="7%" align="left" class="bodytext3"><strong>Doc No</strong></td>
		  <td width="9%" align="left" class="bodytext3"><?php echo $budgetno; ?></td>
		 
		  <td width="11%" align="left" class="bodytext3"><strong>Budget Name </strong></td>
		  <td width="19%" align="left" class="bodytext3"><?php echo $budgetname; ?></td>
		 
		  <td width="10%" align="left" class="bodytext3"><strong>Budget Type</strong></td>
		  <td width="13%" align="left" class="bodytext3"><?php echo $budgettype; ?></td>
		  
		  <td width="11%" align="left" class="bodytext3"><strong>Budget Year </strong></td>
		  <td width="20%" align="left" class="bodytext3"><?php echo $budgetyear; ?>
		  <input type="hidden" name="byear" id="byear" value="<?php echo $budgetyear; ?>" /></td>
		 
		  </tr>
		  <tr>
		  <td width="7%" align="left" class="bodytext3"><strong>Initiated By</strong></td>
		  <td width="9%" align="left" class="bodytext3"><?php echo strtoupper($budgetby); ?></td>
		 <td width="7%" align="left" class="bodytext3"><strong>Approved By</strong></td>
		  <td width="9%" align="left" class="bodytext3"><?php echo strtoupper($approvedby); ?></td>
		  <td width="7%" align="left" class="bodytext3"><strong>Location</strong></td>
		  <td width="9%" align="left" class="bodytext3"><?php echo strtoupper($locationname); ?></td>
		  <td colspan="2" width="11%" align="left" class="bodytext3"><strong>&nbsp; </strong></td>
		  </tr>
		  <tr>
		  <td width="7%" align="left" class="bodytext3"><strong>Select Type</strong></td>
		  <td width="9%" align="left" class="bodytext3"><select name="bview" id="bview">
		  <?php if($bview != '') { ?>
		  <option value="<?php echo $bview; ?>"><?php echo $bview; ?></option>
		  <?php } ?>
		  <option value="Yearly">Yearly</option>
		  <option value="Quarterly">Quarterly</option>
		  <option value="Monthly">Monthly</option>
		  </select></td>
		  <td width="7%" align="left" class="bodytext3"><strong>Budget Type</strong></td>
		  <td width="9%" align="left" class="bodytext3"><select name="btype" id="btype">
		  <?php if($btype != '') { ?>
		  <option value="<?php echo $btype; ?>"><?php echo $btype; ?></option>
		  <?php } ?>
		  <option value="">All</option>
		  <option value="Income">Income</option>
		  <option value="Expense">Expense</option>
		  </select></td>
		  <td colspan="5" width="11%" align="left" class="bodytext3"><strong>&nbsp; </strong></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Select Ledger</strong></td>
		  <td colspan="12" width="11%" align="left" class="bodytext3"><input type="text" name="ledger" id="ledger" value="<?php echo $ledger; ?>" autocomplete="off" size="40">
		  <input type="hidden" name="ledgerid" id="ledgerid"><input type="hidden" name="ledgeranum" id="ledgeranum">
		  <input type="hidden" name="autobuildledger" id="autobuildledger"></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">&nbsp; </td>
		  <td colspan="10" width="90%" align="left" class="bodytext3">
		  <input type="hidden" name="frm1submit1" id="frm1submit1" value="frm1submit1">
		  <input type="submit" name="submit" id="submit" value="Budget View" style="border:solid 1px #000033;"/></td>
		  </tr>
		   <tr>
		  <td colspan="10" width="10%" align="left" class="bodytext3">&nbsp; </td>
		   </tr>
          </tbody>
        </table></td>
		</tr>
		</table>
	</td>
		</tr>
		</form>
		<form name="form1" id="form1" method="post" action="budgetentryfinalview.php">
		<tr>
        <td width="4%">&nbsp;</td><td width="96%"><table width="90%" border="1" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <?php
		  if(isset($_REQUEST['frm1submit1'])) { $frm1submit1 = $_REQUEST['frm1submit1']; } else { $frm1submit1 = ''; }
		  if($frm1submit1 == 'frm1submit1')
		  {
		  ?>
		  <tr bgcolor="#0033FF">
			<td width="494" align="left" class="bodytext3" style="color:#FFFFFF"><strong>Account Ledger Name</strong></td>
			<td width="116" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Projection'; ?></strong></td>
			<td width="116" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php if($bview == 'Quarterly') { echo 'Average for Quarterly'; }
			else { echo 'Average Per Month'; }?></strong></td>
			<?php if($bview == 'Monthly')
			  {
			  	  for($i=1;$i<=12;$i++)
				  {
				  $dt = '2015-'.$i.'-01';
				  ?>
				  <td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo date('F',strtotime($dt)); ?></strong></td>
				  <?php
				  }
				  ?>
				  <td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Actual'; ?></strong></td>
			  <?php
			  }
			  ?>
			  <?php if($bview == 'Quarterly')
			  {
			  	  for($i=1;$i<=12;$i++)
				  {
				  $j=$i+2;
				  $dt = '2015-'.$i.'-01';
				  $dt1 = '2015-'.$j.'-01';
				  ?>
				  <td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo date('M',strtotime($dt)).' - '.date('M',strtotime($dt1)); ?></strong></td>
				  <?php
				  $i=$i+2;
				  }
				  ?>
				  <td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Actual'; ?></strong></td>
			  <?php
			  }
			  ?>
			  <?php if($bview == 'Yearly') { ?> 
			<td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Actual'; ?></strong></td>
			<?php } ?>
			<input type="hidden" name="subtotal" id="subtotal" value="0.00">
			<td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Delta'; ?></strong></td>
			<td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Delta %'; ?></strong></td>
			</tr>
		 	<?php
			
			$a_json_row = array();
			function groupleft($a,$year)
			{
			global $a_json_row;
			$ledgeramountsumtotal1=$a_json_row[$year];
			$ledgeramountsumtotal1 = $ledgeramountsumtotal1 + $a;
			return $a_json_row[$year] = $ledgeramountsumtotal1;
			}
			
		    $snocount = "";
			$ledgervalue = '0.00';
			$total1 = "0.00";
			$total2 = "0.00";
			$total3 = "0.00";
			$totaldelta = "0.00";
			$rowtotal1 = "0.00";
			
			$query11 = "select * from budgetentry where budgetno = '$docno' and accountname like '%$ledger%' and budgettype like '%$btype%' group by budgettype";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res11 = mysqli_fetch_array($exec11))
			{ 
			$budgettype = $res11['budgettype'];
			?>
			<tr bgcolor="#FFFFFF">
			<td colspan="20" width="145" align="left" class="bodytext3" style="color:#FF0000;"><strong><?php echo $budgettype; ?></strong></td>
			</tr>
			<?php
			$query1 = "select * from budgetentry where budgetno = '$docno' and accountname like '%$ledger%' and budgettype = '$budgettype' order by auto_number";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			  $anum = $res1['auto_number'];
			  $budgetno = $res1['budgetno'];
			  $accountcode = $res1['accountcode'];
			  $accountname = $res1['accountname'];
			  $markup = $res1['markup'];
			  $projection = $res1['projection'];
			  
			  if($projection != 'aa')
			  {
			  $snocount = $snocount + 1;
			  
			  if($bview == 'Yearly')
			  {
				  $ADate1 = $budgetyear.'-01-01';
				  $ADate2 = $budgetyear.'-12-31';
				  $ledgervalue = ledgervalue($accountcode,$ADate1,$ADate2);
				  if($budgettype == 'Income') {
				  $delta = $ledgervalue - $projection; } else {
				  $delta = $projection - $ledgervalue; }
				  $diff = (($ledgervalue - $projection) / $projection) * 100;
			  }
			 
			  $total1 = $total1 + $ledgervalue;
			  $total2 = $total2 + $projection;
	
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($snocount & 1); 
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
			$average1 = $projection * (12/100);
			if($bview == 'Quarterly') {
			$average1 = $average1 * 3; }
			$total3 = $total3 + $average1;
			$rowtotal1 = $rowtotal1 + $ledgervalue;
			 ?>
			  <tr <?php echo $colorcode; ?>>
			 <td align="left" class="bodytext3"><strong><?php echo $snocount.'. &nbsp;&nbsp;'.$accountname; ?></strong></td>
			 <td align="right" class="bodytext3" style="text-decoration:none"><strong><?php echo number_format($projection,2,'.',','); ?></strong></td>
			 <td align="right" class="bodytext3" style="text-decoration:none"><strong><?php echo number_format($average1,2,'.',','); ?></strong></td>
			<?php  if($bview == 'Monthly')
			  { for($i=1;$i<=12;$i++) { 
			  if($i<10){$i='0'.$i;}else{$i=$i;}
			  $ADate1 = $budgetyear.'-'.$i.'-01';
			  $ADate2 = $budgetyear.'-'.$i.'-31';
			  //$ledgervalue = 0.00;
			  $ledgervalue = ledgervalue($accountcode,$ADate1,$ADate2);
			  groupleft($ledgervalue,$accountcode);
			  //echo $i;
			  groupleft($ledgervalue,$i);
			  $diff = (($ledgervalue - $average1) / $average1) * 100;
			  ?>
		    <td align="right" class="bodytext3" <?php if($budgettype == 'Expense') {
			  if($diff == -100) { echo "bgcolor='#FFFFFF'"; } else if($diff < 0) { echo "bgcolor='#339933'"; } else if(($diff > 0) && ($diff <= 50)) { echo 'bgcolor="#FF9900"'; } else { echo 'bgcolor="#FF0000"'; } }
			  else if($budgettype == 'Income') {
			  if($diff == -100) { echo "bgcolor='#FFFFFF'"; } else if($diff < 0) { echo "bgcolor='#FF0000'"; } else if(($diff > 0) && ($diff <= 50)) { echo 'bgcolor="#FF9900"'; } else { echo 'bgcolor="#339933"'; } }
			  ?> <?php if($diff == -100) { echo "style='color:#000000'"; } else { echo "style='color:#FFFFFF'"; } ?>><strong><?php echo number_format($ledgervalue,2,'.',','); ?></strong></td>
		    <?php } ?>
			<td align="right" class="bodytext3"><strong><?php $rowtotal = groupleft('0',$accountcode); if($budgettype == 'Income') {
				  $delta = $rowtotal - $projection; } else {
				  $delta = $projection - $rowtotal; } echo number_format($rowtotal,2,'.',','); ?></strong></td>
			<?php $rowtotal1 = $rowtotal1 + $rowtotal; ?>
			<?php } else if($bview == 'Yearly') {?>
			<td align="right" class="bodytext3" <?php if($budgettype == 'Expense') {
			  if($diff == -100) { echo "bgcolor='#FFFFFF'"; } else if($diff < 0) { echo "bgcolor='#339933'"; } else if(($diff > 0) && ($diff <= 50)) { echo 'bgcolor="#FF9900"'; } else { echo 'bgcolor="#FF0000"'; } }
			  else if($budgettype == 'Income') {
			  if($diff == -100) { echo "bgcolor='#FFFFFF'"; } else if($diff < 0) { echo "bgcolor='#FF0000'"; } else if(($diff > 0) && ($diff <= 50)) { echo 'bgcolor="#FF9900"'; } else { echo 'bgcolor="#339933"'; } }
			  ?> <?php if($diff == -100) { echo 'style="color:#000000"'; } else { echo 'style="color:#FFFFFF"'; } ?>><strong><?php echo number_format($ledgervalue,2,'.',','); ?></strong></td>
			<?php $rowtotal = $ledgervalue; } else if($bview == 'Quarterly')
			  { $qty = 0;
			  for($i=1;$i<=12;$i++) { 
			  $j=$i+2;
			  $qty = $qty + 1;
			  if($i<10){$i='0'.$i;}else{$i=$i;}
			  if($j<10){$j='0'.$j;}else{$j=$j;}
			  $ADate1 = $budgetyear.'-'.$i.'-01';
			  $ADate2 = $budgetyear.'-'.$j.'-31';
			  //$ledgervalue = 0.00;
			  $ledgervalue = ledgervalue($accountcode,$ADate1,$ADate2);
			  //${"ledgeramountsumtotal1".$accountcode}='0';
			  groupleft($ledgervalue,$accountcode);
			  groupleft($ledgervalue,$qty);
			  
			  $diff = (($ledgervalue - $average1) / $average1) * 100;
			  ?>
			  <td align="right" class="bodytext3" <?php if($budgettype == 'Expense') {
			  if($diff == -100) { echo "bgcolor='#FFFFFF'"; } else if($diff < 0) { echo "bgcolor='#339933'"; } else if(($diff > 0) && ($diff <= 50)) { echo 'bgcolor="#FF9900"'; } else { echo 'bgcolor="#FF0000"'; } }
			  else if($budgettype == 'Income') {
			  if($diff == -100) { echo "bgcolor='#FFFFFF'"; } else if($diff < 0) { echo "bgcolor='#FF0000'"; } else if(($diff > 0) && ($diff <= 50)) { echo 'bgcolor="#FF9900"'; } else { echo 'bgcolor="#339933"'; } }
			  ?> <?php if($diff == -100) { echo "style='color:#000000'"; } else { echo "style='color:#FFFFFF'"; } ?>><strong><?php echo number_format($ledgervalue,2,'.',','); ?></strong></td>
			<?php $i=$i+2;  } ?>
			<td align="right" class="bodytext3"><strong><?php $rowtotal = groupleft('0',$accountcode); if($budgettype == 'Income') {
				  $delta = $rowtotal - $projection; } else {
				  $delta = $projection - $rowtotal; } echo number_format($rowtotal,2,'.',','); ?></strong></td>
			<?php $rowtotal1 = $rowtotal1 + $rowtotal; } ?>
			<td align="right" class="bodytext3"><strong><?php echo number_format($delta,2,'.',','); $totaldelta = $totaldelta + $delta; ?></strong></td>
			<td align="right" class="bodytext3"><strong><?php if($budgettype == 'Income') { $deltaper = (($rowtotal - $projection) / $projection) * 100; }
			else { $deltaper = (($projection - $rowtotal) / $projection) * 100; } echo number_format($deltaper,2,'.',','); ?></strong></td>
			</tr>
			<?php
		    }	
			}
			}
			?>	
			
			<tr bgcolor="#ecf0f5">
			 <td align="left" class="bodytext3"><strong><?php echo 'TOTAL'; ?></strong></td>
			 <td align="right" class="bodytext3" style="text-decoration:none"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>
			 <td align="right" class="bodytext3" style="text-decoration:none"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>
			 <?php
			 if($bview == 'Yearly') { ?>
			 <td align="right" class="bodytext3"><strong><?php echo number_format($rowtotal1,2,'.',','); ?></strong></td>
			 <td align="right" class="bodytext3"><strong><?php echo number_format($totaldelta,2,'.',','); ?></strong></td>
			<?php } ?>
			 <?php
			 if($bview == 'Quarterly')
			  { $qty = 0;
			  for($i=1;$i<=12;$i++) { $qty = $qty + 1; ?>
			<td align="right" class="bodytext3" style="text-decoration:none"><strong><?php $coltotal = groupleft('0',$qty); echo number_format($coltotal,2,'.',','); ?></strong></td>
			<?php $i=$i+2; } ?>
			<td align="right" class="bodytext3" style="text-decoration:none"><strong><?php echo number_format($rowtotal1,2,'.',','); ?></strong></td>
			<td align="right" class="bodytext3"><strong><?php echo number_format($totaldelta,2,'.',','); ?></strong></td>
			<?php } ?>
			 <?php
			 if($bview == 'Monthly')
			  { for($i=1;$i<=12;$i++) { if($i<10){$i='0'.$i;}else{$i=$i;}?>
			<td align="right" class="bodytext3" style="text-decoration:none"><strong><?php $coltotal1 = groupleft('0',$i); echo number_format($coltotal1,2,'.',','); ?></strong></td>
			<?php } ?>
			<td align="right" class="bodytext3" style="text-decoration:none"><strong><?php echo number_format($rowtotal1,2,'.',','); ?></strong></td>
			<td align="right" class="bodytext3"><strong><?php echo number_format($totaldelta,2,'.',','); ?></strong></td>
			<?php } ?>
			<td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			</tr>
			<tr>
			<td colspan="18" align="left" class="bodytext3">&nbsp;</td>
			</tr>
			<?php
			}
			?>
		  </tbody>
		  </table>
		</form>

<?php include ("includes/footer1.php"); ?>
<?php
function ledgervalue($parentid,$ADate1,$ADate2)
{
$orderid1 = '';
$lid = '';
$colorloopcount = '';
$totalamount12 = "0.00";
$sumopeningbalance = "0.00";
$sumbalance = '0.00';

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
	
	$query92 = "select * from master_accountname where id = '$parentid'";
	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num92 = mysqli_num_rows($exec92);
	while($res92 = mysqli_fetch_array($exec92))
	{  
		$accountsmain2 = $res92['accountname'];
		$orderid1 = $orderid1 + 1;
		$parentid2 = $res92['auto_number'];
		$ledgeranum = $parentid2;
		$id = $res92['id'];
		
		$ledgerid = $id;
		$group = $res92['accountssub'];
		$query1 = "select * from master_accountssub where recordstatus <> 'deleted' and auto_number = '$group' order by accountsmain ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1); 
		$accountsmain = $res1['accountsmain'];
		
		$query1 = "select * from master_accountsmain where recordstatus <> 'deleted' and auto_number = '$accountsmain' order by accountsmain ";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res1 = mysqli_fetch_array($exec1); 
		$section = $res1['section'];
		
		if($section == 'I')
		{
		$accountbank = 0;
		$i = 0;
		$opendr = 0;
		$opencr = 0;
		$accountdr = 0;
		$accountcr = 0;
		$i = 0;
		
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem not like 'yes'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem not like 'yes'
						UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ippharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrateuhx`) as income FROM `billing_ipservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem not like 'yes'
						UNION ALL SELECT SUM(`transactionamount`) as income FROM `receiptsub_details` WHERE transactionmode <> 'ADJUSTMENT' AND transactiondate BETWEEN '$ADate1' AND '$ADate2' and receiptcoa = '$id'
						UNION ALL SELECT SUM(`creditamount`) as income FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		/*
		
		 */
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`amount`) as incomedebit FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT SUM(`serviceamount`) as incomedebit FROM `refund_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `refund_paylaterpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
		
		UNION ALL SELECT SUM(`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
		
		UNION ALL SELECT SUM(`debitamount`) as incomedebit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
		if($id == '01-7002')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`pharmacyfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'";
		}
		
		if($id == '01-2-PRI')
		{
		$querydr1in .= " UNION ALL SELECT SUM(`servicesfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
		UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'";
		}
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		
		switch($id)
		{
	case '01-1015-01':
		$consdepartment = "IN('1')";
		break;	
	case '01-1015-02':
		$consdepartment = "IN('2')";
		break;
	case '01-1015-03':
		$consdepartment = "IN('3')";
		break;
	case '01-1015-04':
		$consdepartment = "IN('4')";
		break;	
	case '01-1015-05':
		$consdepartment = "IN('5')";
		break;
	case '01-1015-06':
		$consdepartment = "IN('6')";
		break;
	case '01-1015-07':
		$consdepartment = "IN('7')";
		break;	
	case '01-1015-08':
		$consdepartment = "IN('8')";
		break;
	case '01-1015-09':
		$consdepartment = "IN('9')";
		break;
	case '01-1015-10':
		$consdepartment = "IN('10')";
		break;	
	case '01-1015-11':
		$consdepartment = "IN('11')";
		break;
	case '01-1015-12':
		$consdepartment = "IN('12')";
		break;
	case '01-1015-11':
		$consdepartment = "IN('13')";
		break;	
	case '01-1015-14':
		$consdepartment = "IN('14')";
		break;
	case '01-1015-15':
		$consdepartment = "IN('15')";
		break;
	case '01-1015-16':
		$consdepartment = "IN('16')";
		break;	
	case '01-1015-17':
		$consdepartment = "IN('17')";
		break;
	case '01-1015-18':
		$consdepartment = "IN('18')";
		break;
	case '01-1015-19':
		$consdepartment = "IN('19')";
		break;	
	case '01-1015-20':
		$consdepartment = "IN('20')";
		break;
	case '01-1015-21':
		$consdepartment = "IN('21')";
		break;
	case '01-1015-22':
		$consdepartment = "IN('22')";
		break;	
	case '01-1015-23':
		$consdepartment = "IN('23')";
		break;
	case '01-1015-24':
		$consdepartment = "IN('24')";
		break;
	case '01-1015-25':
		$consdepartment = "IN('25')";
		break;	
	case '01-1015-26':
		$consdepartment = "IN('26')";
		break;
	case '01-1015-27':
		$consdepartment = "IN('27')";
		break;
	case '01-1015-28':
		$consdepartment = "IN('28')";
		break;	
	case '01-1015-29':
		$consdepartment = "IN('29')";
		break;
	case '01-1015-30':
		$consdepartment = "IN('30')";
		break;
	case '01-1015-31':
		$consdepartment = "IN('31')";
		break;	
	case '01-1015-32':
		$consdepartment = "IN('32')";
		break;
	case '01-1015-33':
		$consdepartment = "IN('33')";
		break;
	case '01-1015-34':
		$consdepartment = "IN('34')";
		break;	
	case '01-1015-35':
		$consdepartment = "IN('35')";
		break;
	case '01-1015-36':
		$consdepartment = "IN('36')";
		break;
	case '01-1015-37':
		$consdepartment = "IN('37')";
		break;	
	case '01-1015-38':
		$consdepartment = "IN('38')";
		break;
	case '01-1015-39':
		$consdepartment = "IN('39')";
		break;
	case '01-1015-40':
		$consdepartment = "IN('40')";
		break;
	default:
		$consdepartment = "IN('0')";
		break;		
	}
	
	    $i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`consultation`) as income FROM `billing_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paylaterconsultation` AS a JOIN `master_visitentry` AS b ON (a.visitcode = b.visitcode) WHERE b.department $consdepartment AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT SUM(-1*a.`consultation`) as income FROM `refund_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.billdate BETWEEN '$ADate1' AND '$ADate2'
					   UNION ALL SELECT SUM(-1*a.`consultation`) as income FROM `refund_paylaterconsultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment AND a.billdate BETWEEN '$ADate1' AND '$ADate2'"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
	
		$j = 0;
		$drresult1 = array();
				
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
							
		if($id=='01-1009')
		{
		$i = 0;
			$crresult1 = array();
			$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
							UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
							UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
							UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			
			
			/*
			
			 */
			
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`labitemrate`) as incomedebit FROM `refund_paynowlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 
			UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterlab` as a WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
					
			$querydr1in .= " UNION ALL SELECT SUM(`labfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
			UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		}
		
		
		$i = 0;
			$crresult1 = array();
			$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
							UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
							UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id' 
							UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`radiologyitemrate`) as incomedebit FROM `refund_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'
			UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `refund_paylaterradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'";
			
			
			if($id == '01-1014-08')
			{
			$querydr1in .= " UNION ALL SELECT SUM(`radiologyfxamount`) as incomedebit FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2'
			UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'";
			}
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		
		/* 
		*/
		if($id == '01-1001')
		{
		$i = 0;
			$crresult1 = array();
			$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		}
		if($id == '01-1024-IN')
		{
		$i = 0;
			$crresult1 = array();
			$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Bed Charges')"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Bed Charges')";
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		}
		if($id == '01-1019')
		{
		$i = 0;
			$crresult1 = array();
			$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('Nursing Charges')"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('Nursing Charges')";
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		}
		if($id == '01-1020')
		{
		$i = 0;
			$crresult1 = array();
			$querycr1in = "select SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and description IN ('RMO Charges')"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`fxamount`) as incomedebit FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` IN ('RMO Charges')";
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		}
		if($id == '01-1008')
		{
		
		$i = 0;
			$crresult1 = array();
			$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult1[$i] = $rescr1['income'];
			}
			
			
			$j = 0;
			$drresult1 = array();
			$querydr1in = "SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
			UNION ALL SELECT SUM(`referalrate`) as incomedebit FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
			
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$j = $j+1;
			$drresult1[$j] = $resdr1['incomedebit'];
			}
			
			$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
		
		}
		//UNION ALL 
		if($id == '01-1002')
		{
			$i = 0;
			$crresult = array();
			$querycr1in = "SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'		
							UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'"; 
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$i = $i+1;
			$crresult[$i] = $rescr1['income'];
			}
			
			$j = 0;
			$drresult = array();
			
			
			$sumbalance = $sumbalance + array_sum($crresult) - array_sum($drresult);
		}
		}
		else
		{
			$i = 0;
			$result = array();
			$querydr1 = "SELECT SUM(`debitamount`) as expenses FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`totalamount`) as expenses FROM `purchase_details` WHERE `expensecode` = '$id' AND billnumber NOT LIKE 'SUPO%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
					UNION ALL SELECT SUM(a.`totalamount`) as expenses FROM `purchase_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.billnumber NOT LIKE 'SUPO%' AND a.suppliername <> 'OPENINGSTOCK' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted' and b.type <> 'assets' 
					UNION ALL SELECT SUM(`transactionamount`) as expenses FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(a.`amount`) as expenses FROM `master_stock_transfer` AS a WHERE a.tostore = '$id' AND a.tostore NOT LIKE 'STO%' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(a.`totalcp`) as expenses FROM `pharmacysalesreturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
					 UNION ALL SELECT SUM(`openbalanceamount`) as expenses FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(a.`totalcp`) as expenses FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.incomeledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($resdr1 = mysqli_fetch_array($execdr1))
			{
			$i = $i+1;
			$result[$i] = $resdr1['expenses'];
			}
			
			$j = 0;
			$crresult = array();
			$querycr1inv = "SELECT SUM(`creditamount`) as stockcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(a.`totalamount`) as stockcredit FROM `purchasereturn_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'
							UNION ALL SELECT SUM(`totalamount`) as stockcredit FROM `purchasereturn_details` WHERE expensecode = '$id' AND entrydate BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
							UNION ALL SELECT SUM(a.`totalcp`) as stockcredit FROM `pharmacysales_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT SUM(`openbalanceamount`) as stockcredit FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and payablestatus ='0'
							UNION ALL SELECT SUM(a.`amount`) as stockcredit FROM `master_stock_transfer` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.tostore NOT LIKE 'STO%'  AND a.`entrydate` BETWEEN '$ADate1' AND '$ADate2'";
			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1inv) or die ("Error in querycr1inv".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($rescr1 = mysqli_fetch_array($execcr1))
			{
			$j = $j+1;
			$crresult[$j] = $rescr1['stockcredit'];
			}
						
			$balance = array_sum($result) - array_sum($crresult);
					
			$sumbalance = $sumbalance + $balance;		
		}
	}
	
	return $sumbalance;
}
?>
</body>
</html>