<?php 
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companycode = $_SESSION['companycode'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = '';
$month = date('M-Y');

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "";
}
else if ($st == 'failed')
{
		$errmsg = "";
}
?>
<?php
$docno = $_SESSION['docno'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];
$colorloopcount = 0;
$transactiondate = date('Y-m-d');

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
$searchmonthyear = $searchmonth.'-'.$searchyear;
$totalearning = 0;
$totaldeduction = 0;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if($cbfrmflag2 == 'cbfrmflag2')
{
	$paymonth = $_REQUEST['paymonth'];
	$frmcount = $_REQUEST['frmcount'];
	$updatedate = date('Y-m-t', strtotime($paymonth));

	for($i=0;$i<=$frmcount;$i++)
	{
		if(isset($_REQUEST['componentname'.$i]))
		{
			if($_REQUEST['componentname'.$i] != '')
			{
				$anum = $_REQUEST['anum'.$i];
				$typecode = $_REQUEST['typecode'.$i];
				$componentname = $_REQUEST['componentname'.$i];
				$amount = $_REQUEST['amount'.$i];
				$ledgercode = $_REQUEST['ledgercode'.$i];
				$ledgername = $_REQUEST['ledgername'.$i];
				
				//echo '<br>'.$anum.$typecode.$componentname.$amount.$ledgercode.$ledgername;
				$query78 = "select auto_number from master_transactionpayroll where componentanum = '$anum' and paymonth = '$paymonth'";
				$exec78 = mysqli_query($GLOBALS["___mysqli_ston"],$query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows = mysqli_num_rows($exec78);
				if($rows == 0)
				{
					$query79 = "INSERT INTO `master_transactionpayroll`(`transactiondate`, `docno`, `componentanum`, `componentname`, `typecode`, `accountname`, `accountcode`, `transactionamount`, `paymonth`, `ipaddress`, `updatedate`, `companyanum`, `companyname`, `locationname`, `locationcode`, transactiontype) 
								VALUES ('$transactiondate','$paymonth','$anum','$componentname','$typecode','$ledgername','$ledgercode','$amount','$paymonth','$ipaddress','$updatedate','$companyanum','$companyname','$locationname','$locationcode','PROCESS')";
					$exec79 = mysqli_query($GLOBALS["___mysqli_ston"],$query79) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));							
				}				
			}
		}
	}
	
	header("location:payrolltransaction.php?st=success");
}
?>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
<script language="javascript">

function process1backkeypress1() 
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

</script>

<script language="javascript">

function captureEscapeKey1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		//alert ("Escape Key Press.");
		//event.keyCode=0; 
		//return event.keyCode 
		//return false;
	}
}

$(document).ready(function(){
	
	$('.earningledger').autocomplete({
	source:"ajaxpayrollledger.php?type=10",
	//alert(source);
	minLength:0,
	html: true, 
		select: function(event,ui){
				
			var code = ui.item.id;
			var billwise = ui.item.billwise;
			if(code != '') {
				var textid = $(this).attr('id');
				var res = textid.split("ledgername");
				var textid1 = res[0];
				var ressno = res[1];
				
				$("#ledgercode"+ressno).val(code);
				
			}
			},
    });
	
	$('.deductionledger').autocomplete({
	source:"ajaxpayrollledger.php?type=20",
	//alert(source);
	minLength:0,
	html: true, 
		select: function(event,ui){
				
			var code = ui.item.id;
			var billwise = ui.item.billwise;
			if(code != '') {
				var textid = $(this).attr('id');
				var res = textid.split("ledgername");
				var textid1 = res[0];
				var ressno = res[1];
				
				$("#ledgercode"+ressno).val(code);
				
			}
			},
    });
})
</script>
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
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
</style>
</head>
<script src="js/datetimepicker1_css.js"></script>
<script type="text/javascript">
function from1submit1()
{
	var count = document.getElementById('frmcount').value;
	for(var i=0;i<=count;i++)
	{
		if(document.getElementById('ledgercode'+i) != null)
		{
			if(document.getElementById('ledgercode'+i).value == '')
			{
				alert("Select ledgername to proceed.");
				document.getElementById('ledgername'+i).focus();
				return false;
			}
		}
	}
}
</script>
<body>
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php eval(base64_decode('IA0KCQ0KCQlpbmNsdWRlICgiaW5jbHVkZXMvbWVudTEucGhwIik7IA0KCQ0KCS8vCWluY2x1ZGUgKCJpbmNsdWRlcy9tZW51Mi5waHAiKTsgDQoJDQoJ')); ?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="99%" valign="top">
	<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<form name="form1" id="form1" method="get" action="payrolltransaction.php">
	<tbody>
	<tr bgcolor="#CCC">
	<td colspan="3" align="left" class="bodytext3"><strong>Payroll Transaction</strong>
	<td colspan="3" align="right" class="bodytext3"><strong><?php echo 'Location : '.$locationname; ?></strong>
	</td>
	</tr>
	<tr>
	<td width="133" align="left" class="bodytext3">Search Month</td>
	<td width="127" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
	<?php
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	?>
	<option value="<?php echo $arraymonth[$i]; ?>" <?php if($searchmonth == $arraymonth[$i]) { echo "selected"; } ?>><?php echo $arraymonth[$i]; ?></option>
	<?php
	}
	?>
	</select></td>
	<td colspan="2" align="left" class="bodytext3">Search Year &nbsp;&nbsp;
	<select name="searchyear" id="searchyear">
	<?php
	for($j=2010;$j<=date('Y');$j++)
	{
	?>
	<option value="<?php echo $j; ?>" <?php if($searchyear == $j) { echo "selected"; } ?>><?php echo $j; ?></option>
	<?php
	}
	?>
	</select></td>
	<td width="283" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">&nbsp;</td>
	<td colspan="2" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;">
	</td>
	</tr>
	<tr bgcolor="#CCC">
	<td colspan="5" align="left" class="bodytext3" style="">&nbsp;</td>
	</tr>
	</form>
	<?php
	if($frmflag1 == 'frmflag1') 
	{
	?>
	<form name="form2" id="form2" method="post" action="payrolltransaction.php" onSubmit="return from1submit1()">
	<tr>
	<td colspan="3" align="left" valign="top" class="bodytext3">
	<div style="overflow:auto;border:solid 1px #ecf0f5;">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr bgcolor="#ecf0f5">
	<td width="52%" align="left" class="bodytext3">
	<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>">
	<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
	<input type="hidden" name="paymonth" id="paymonth" value="<?php echo $searchmonthyear; ?>">
	<strong>Earnings</strong></td>
	<td width="15%" align="right" class="bodytext3"><strong>Amount</strong></td>
	<td width="33%" align="center" class="bodytext3"><strong>Ledgername</strong></td>
	</tr>
	</thead>
	<?php
	$sno=0;
	$query1 = "select auto_number, componentname, typecode, ledger, ledgercode from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"],$query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$anum1 = $res1['auto_number'];
	$componentname = $res1['componentname'];
	$typecode = $res1['typecode'];
	$ledger = $res1['ledger'];
	$ledgercode = $res1['ledgercode'];
	
	$query23 = "select SUM(`$anum1`) as componentamount from details_employeepayroll where paymonth = '$searchmonthyear'";
	$exec23 = mysqli_query($GLOBALS["___mysqli_ston"],$query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res23 = mysqli_fetch_array($exec23);
	$componentamount = $res23['componentamount'];
	$totalearning = $totalearning + $componentamount;
	$sno = $sno + 1;
	
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
	<td align="left" class="bodytext31"><?php echo $sno.'. '.$componentname; ?></td>
	<td align="right" class="bodytext31"><?php echo number_format($componentamount,2); ?></td>
	<td align="right" class="bodytext31">
	<input type="hidden" name="anum<?= $sno; ?>" id="anum<?= $sno; ?>" value="<?php echo $anum1; ?>">
	<input type="hidden" name="typecode<?= $sno; ?>" id="typecode<?= $sno; ?>" value="<?= $typecode; ?>">
	<input type="hidden" name="componentname<?= $sno; ?>" id="componentname<?= $sno; ?>" value="<?php echo $componentname; ?>">
	<input type="hidden" name="amount<?= $sno; ?>" id="amount<?= $sno; ?>" value="<?php echo $componentamount; ?>">
	<input type="text" class="earningledger" name="ledgername<?= $sno; ?>" id="ledgername<?= $sno; ?>" value="<?= $ledger; ?>" size="25">
	<input type="hidden" name="ledgercode<?= $sno; ?>" id="ledgercode<?= $sno; ?>" value="<?= $ledgercode; ?>" size="5"></td>
	</tr>
	<?php
	}
	?>
	<tr bgcolor="#CCC">
	<td align="left" class="bodytext31"><strong><?php echo 'TOTAL :'; ?></strong></td>
	<td align="right" class="bodytext31"><strong><?php echo number_format($totalearning,2); ?></strong></td>
	<td align="right" class="bodytext31">&nbsp;</td>
	</tr>
	</table>
	</div>
	</td>
	<td colspan="3" align="left" valign="top" class="bodytext3">
	<div style="overflow:auto;border:solid 1px #ecf0f5;">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<thead>
	<tr bgcolor="#ecf0f5">
	<td width="53%" align="left" class="bodytext3"><strong>Deductions</strong></td>
	<td width="14%" align="right" class="bodytext3"><strong>Amount</strong></td>
	<td width="33%" align="center" class="bodytext3"><strong>Ledgername</strong></td>
	</tr>
	</thead>
	<?php
	$query2 = "select auto_number, componentname, typecode, ledgercode, ledger from master_payrollcomponent where typecode = '20' and recordstatus <> 'deleted'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"],$query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$anum2 = $res2['auto_number'];
	$componentname2 = $res2['componentname'];
	$typecode2 = $res2['typecode'];
	$ledgercode2 = $res2['ledgercode'];
	$ledger2 = $res2['ledger'];
	
	$query24 = "select SUM(`$anum2`) as componentamount from details_employeepayroll where paymonth = '$searchmonthyear'";
	$exec24 = mysqli_query($GLOBALS["___mysqli_ston"],$query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res24 = mysqli_fetch_array($exec24);
	$componentamount2 = $res24['componentamount'];
	$totaldeduction = $totaldeduction + $componentamount2;
	
	$sno = $sno + 1;
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
	<td align="left" class="bodytext31"><?php echo $sno.'. '.$componentname2; ?></td>
	<td align="right" class="bodytext31"><?php echo number_format($componentamount2,2); ?></td>
	<td align="right" class="bodytext31">
	<input type="hidden" name="anum<?= $sno; ?>" id="anum<?= $sno; ?>" value="<?php echo $anum2; ?>">
	<input type="hidden" name="typecode<?= $sno; ?>" id="typecode<?= $sno; ?>" value="<?= $typecode2; ?>">
	<input type="hidden" name="componentname<?= $sno; ?>" id="componentname<?= $sno; ?>" value="<?php echo $componentname2; ?>">
	<input type="hidden" name="amount<?= $sno; ?>" id="amount<?= $sno; ?>" value="<?php echo $componentamount2; ?>">
	<input type="text" class="deductionledger" name="ledgername<?= $sno; ?>" id="ledgername<?= $sno; ?>" value="<?= $ledger2; ?>" size="25">
	<input type="hidden" name="ledgercode<?= $sno; ?>" id="ledgercode<?= $sno; ?>" value="<?= $ledgercode2; ?>" size="5"></td>
	</tr>
	<?php
	}
	$netpay = $totalearning - $totaldeduction;
	$totaldeduction = $totaldeduction + $netpay;
	$sno = $sno + 1;
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
	<td align="left" class="bodytext31"><?php echo $sno.'. '.'NET PAY'; ?></td>
	<td align="right" class="bodytext31"><?php echo number_format($netpay,2); ?></td>
	<td align="right" class="bodytext31">
	<input type="hidden" name="anum<?= $sno; ?>" id="anum<?= $sno; ?>" value="<?php echo '0'; ?>">
	<input type="hidden" name="typecode<?= $sno; ?>" id="typecode<?= $sno; ?>" value="20">
	<input type="hidden" name="componentname<?= $sno; ?>" id="componentname<?= $sno; ?>" value="<?php echo 'NET PAY'; ?>">
	<input type="hidden" name="amount<?= $sno; ?>" id="amount<?= $sno; ?>" value="<?php echo $netpay; ?>">
	<input type="text" class="deductionledger" name="ledgername<?= $sno; ?>" id="ledgername<?= $sno; ?>" size="25">
	<input type="hidden" name="ledgercode<?= $sno; ?>" id="ledgercode<?= $sno; ?>" size="5"></td>
	</tr>
	<tr bgcolor="#CCC">
	<td align="left" class="bodytext31"><strong><?php echo 'TOTAL :'; ?></strong></td>
	<td align="right" class="bodytext31"><strong><?php echo number_format($totaldeduction,2); ?></strong></td>
	<td align="right" class="bodytext31">&nbsp;</td>
	</tr>
	</table>
	</div>
	</td>
	</tr>
	<tr bgcolor="#CCC">
	<td colspan="6" align="right" class="bodytext3">
	<input type="hidden" name="frmcount" id="frmcount" value="<?= $sno; ?>">
	<input type="hidden" name="cbfrmflag2" id="cbfrmflag2" value="cbfrmflag2">
	<input type="submit" name="Search23" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	</form>
	<?php 
	}
	?>
	</tbody>
	</table> 
	</td>
  	</tr>
    </table>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

