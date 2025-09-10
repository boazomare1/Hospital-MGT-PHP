<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$ledgeramountsumtotal='0';
$errmsg = "";
$ttlamt = '0.00';
$banum = "1";
$gran =0;
$totalnum2 = 0 ;
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$totalamount3 = "0.00";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-1 year')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript">
function subgroupview(id)
{
var id = id;
var idl = id;
var idlimit = parseFloat(idl) + parseFloat(50000);
var ledger = parseFloat(idl) + parseFloat(50000);
var ledgerlimit = parseFloat(ledger) + parseFloat(30000);
var ids = parseFloat(idl) + parseFloat(1);
var ldsi = parseFloat(ledger) + parseFloat(1);

for(var i=ids;i<=idlimit;i++)
{
if(document.getElementById(i) != null){
if(document.getElementById(i).style.display == "none") {
document.getElementById(i).style.display = "";
document.getElementById("arrmain"+id).innerHTML = "&#9660;";}else{
document.getElementById(i).style.display = "none";
document.getElementById("arrmain"+id).innerHTML = "&#9658;";}
}
}
for(var j=ldsi;j<=ledgerlimit;j++)
{
if(document.getElementById(j) != null){
if(document.getElementById(j).style.display == "none") {
document.getElementById(j).style.display = "";
document.getElementById(idl).style.display = "";
document.getElementById("arrmain"+id).innerHTML = "&#9660;";}else{
document.getElementById(j).style.display = "none";
document.getElementById(idl).style.display = "none";
document.getElementById("arrmain"+id).innerHTML = "&#9658;";}
}
}
}

function FuncCreateTD(id)
{
var id = id;
//alert(id);
var m = id;
	
var tr = document.createElement ('TR');
tr.id = "idTR"+m+"";

var td1 = document.createElement ('td');
td1.id = "ledger"+m+"";

td1.valign = "top";
td1.style.backgroundColor = "#FFFFFF";
td1.style.border = "0px solid #001E6A";

var text1 = document.createElement ('input');
text1.id = "ledger"+m+"";
text1.name = "ledger"+m+"";
text1.type = "text";
text1.size = "25";
text1.value = "";
text1.style.backgroundColor = "#FFFFFF";
text1.style.border = "0px solid #001E6A";
text1.style.textAlign = "left";
td1.appendChild (text1);
tr.appendChild (td1);

document.getElementById (id).appendChild (tr);
	
}

function Ledgerbuild(id)
{	
	var id = id;
	//alert(id);
	document.getElementById("ledgerid").value = id;
	var oTextbox = new AutoSuggestControl(document.getElementById("ledgerid"), new StateSuggestions2()); 
	//alert(oTextbox);
}

function totalsum()
{
	var debit = document.getElementById("debit").value;
	var credit = document.getElementById("credit").value;
	
	var diff = parseFloat(credit) - parseFloat(debit);
	var diff = parseFloat(diff);
	if(diff > 0)
	{
	debit = parseFloat(debit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	//var diff = diff.substr(diff.length - 6);
	document.getElementById("suspenseleft").value = diff;
	document.getElementById("suspenseright").value = "0.00";
	}
	else
	{
	diff = Math.abs(diff);
	credit = parseFloat(credit) + parseFloat(diff);
	diff = parseFloat(diff).toFixed(2);
	diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	//var diff = diff.substr(diff.length - 6);
	document.getElementById("suspenseright").value = diff;
	document.getElementById("suspenseleft").value = "0.00";
	}
	debit = parseFloat(debit).toFixed(2);
	debit = debit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	credit = parseFloat(credit).toFixed(2);
	credit = credit.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	document.getElementById("debit").value = debit;
	document.getElementById("credit").value = credit;
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
    <td colspan="2" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" width="46%">
		
		
              <form name="cbform1" method="post" action="">
		<table width="1202" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong> Trial Balance</strong></td>
              </tr>
             <tr>
                      <td width="9%"  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> From Date </td>
                      <td width="20%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
					    <input type="text" name="ADate1" id="ADate1" readonly style="border: 1px solid #001E6A" value="<?php echo $ADate1; ?>"  size="10" onKeyDown="return disableEnterKey()" />
<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </span></td>
						<td width="8%"  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> To Date </td>
                      <td width="63%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" readonly style="border: 1px solid #001E6A" value="<?php echo $ADate2; ?>"  size="10" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                       
                </tr>	
				<tr>
              <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="location" id="location">
			  <?php 
			  $query33 = "select * from master_location where status <> 'deleted'";
			  $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res33 = mysqli_fetch_array($exec33))
			  {
			  ?>
			  <option value="<?= $res33['locationcode']; ?>"><?= $res33['locationname']; ?></option>
			  <?php
			  }
			  ?>
			  </select>
			  </td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Submit" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td valign="top"><table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
			function subgroup1($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = "0.00";
				$ledgeramountsum = "0.00";
				$ledgeramountsum1 = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub,auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					$tbclosing = $res2['tbclosing'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude,$tbclosing);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					echo $parentid2;
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</a></strong>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong>
					<?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
				}
				if($parentid == '6')
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
					$unrealized =0;
					//include 'accounts/tb_unrealized.php';
					$ledgeramountsum = $ledgeramountsum + $unrealized;
				?>
				
				<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
				<?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;99';?><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong><strong style="color:#0000CC; font-size:11px">UNREALIZED REVENUE</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($unrealized,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ledgeramountsum,2,'.',','); $GLOBALS['$ledgeramountsumtotal'] = $ledgeramountsum; + $GLOBALS['$ledgeramountsumtotal'];?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				
				groupleft($ledgeramountsum);
			}
			function groupleft($a)
			{
			static $ledgeramountsumtotal1='0';
			$ledgeramountsumtotal1 = $ledgeramountsumtotal1 + $a;
			return $ledgeramountsumtotal1;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('A','E') order by section, auto_number, accountsmain";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			//$orderid = $res1['orderid'];
			$type = substr($accountsmain,0,1);
	
			?>
			<tr bgcolor="#0033FF">
			<td width="695" align="left" class="bodytext3" style="color:#FFFFFF"><strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid.'10000';?>')" class="bodytext44" style="color:#FFFFFF"><!--<span id="arrmain<?php echo $parentid.'10000';?>">&#9658;</span>--></a>&nbsp;<?php echo $accountsmain; ?></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#FFFFFF"><strong><?php //echo number_format($totalamount12,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup1($parentid,$orderid,$parentid.'10000',$section); }
			//$ledgeramountsum = subgroup1();
			?>
			<!--<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ttlamt,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>-->
			<?php
			}
			
			}
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><?php echo 'SUSPENSE ACCOUNT'; ?></a></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseleft" value="" readonly style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupleft12 = groupleft('0'); //echo number_format($groupleft12,2,'.',','); ?></strong>
			<input type="text" id="debit" value="<?php echo number_format($groupleft12,2,'.',''); ?>" readonly style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
</table>
</td>
 <td width="54%" valign="top"><table width="600" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
            <?php
			function subgroup12($parentid,$orderid,$sid,$section)
			{	
				$colorloopcount = '';
				$ledgeramount = '0.00';
				$ledgeramountsum = "0.00";
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
				$query2 = "select accountssub, auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' order by accountssub";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					$tbinclude = $res2['tbinclude'];
					$tbledgerview = $res2['tbledgerview'];
					$tbclosing = $res2['tbclosing'];
					
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
					$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2,$tbinclude,$tbclosing);
					$ledgeramountsum = $ledgeramountsum + $ledgeramount;
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="695" align="left" class="bodytext3" style="text-decoration:none">
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;';
					}
					echo $parentid2;
					?>
					<strong>&nbsp;<a href="javascript:subgroupview('<?php echo $parentid2.'10000';?>')" class="bodytext44"><!--<span id="arrmain<?php echo $parentid2.'10000';?>">&#9658;</span>-->&nbsp;</a></strong>
					<a href="<?= $tbledgerview; ?>?groupid=<?php echo $parentid2; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&location=<?php echo $location; ?>" target="_blank"><strong><?php echo $accountsmain2; ?></strong></a></td>
					<td width="100" align="right" class="bodytext3"><strong><?php echo number_format($ledgeramount,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
					</tr>
					<?php
					
				}
				?>
				<tr bgcolor="#ecf0f5">
				<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
				<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php echo number_format($ledgeramountsum,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
				</tr>
				<?php
				groupright($ledgeramountsum);
			}
			
			function groupright($b)
			{
				static $ledgeramountsumtotal5 = '0';
				$ledgeramountsumtotal5 = $ledgeramountsumtotal5 + $b;
				return $ledgeramountsumtotal5;
			}
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			//echo $ADate1;
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			//echo $ADate2;

		  
			  $snocount = "";
			$query1 = "select accountsmain,auto_number,section from master_accountsmain where recordstatus <> 'deleted' and section IN ('I','L') order by section, auto_number desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			$section = $res1['section'];
			$type = substr($accountsmain,'0','1');
			//$orderid = $res1['orderid'];
			?>
			<tr bgcolor="#009900">
			<td width="695" align="left" class="bodytext3" style="color:#FFFFFF"><strong>&nbsp;&nbsp;<?php echo $accountsmain; ?></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#FFFFFF"><strong><?php //echo number_format($totalamount12,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup12($parentid,$orderid,$parentid.'10000',$section); }
			
			}
			
			}
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr bgcolor="#ecf0f5">
			<td width="695" align="left" class="bodytext3" style="color:;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><?php echo 'SUSPENSE ACCOUNT'; ?></a></strong></td>
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseright" value="" readonly style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupright12 = groupright(0); //echo number_format($groupright12,2,'.',','); ?></strong>
			<input type="text" id="credit" value="<?php echo number_format($groupright12,2,'.',''); ?>" readonly style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
			<tr>
			<td colspan="2" align="right"><a href="trialbalancexl.php?ADate1=<?php echo '2014-01-01'; ?>&&ADate2=<?php echo $ADate2; ?>" target="_blank"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			</tr>
			<script type="text/javascript">
			totalsum();
			</script>
			<?php
			}
			?>
</table>
</td>
</tr>
</table>

<?php include ("includes/footer1.php"); ?>
<?php
function ledgervalue($parentid,$ADate1,$ADate2,$tbinclude,$tbclosing)
{
	$orderid1 = 0;
	$lid = 0;
	$sumbalance = 0;
	$allid = '';
	
	if($parentid != '' && $tbinclude != '')
	{
		if($tbinclude == 'tb_accountexpense.php')
		{
		$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					if($id != '')
					{
						/* */
						$i = 0;
						$result = array();
						$querydr1 = "SELECT SUM(`totalamount`) as expenses FROM `purchase_details` WHERE `expensecode` = '$id' AND billnumber NOT LIKE 'SOP%' AND suppliername <> 'OPENINGSTOCK' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
								UNION ALL SELECT SUM(a.`totalamount`) as expenses FROM `purchase_details` AS a JOIN master_medicine AS b ON (a.itemcode = b.itemcode) WHERE b.inventoryledgercode = '$id' AND a.billnumber NOT LIKE 'SOP%' AND a.suppliername <> 'OPENINGSTOCK' AND a.entrydate BETWEEN '$ADate1' AND '$ADate2' and a.recordstatus <> 'deleted'";
						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1) or die ("Error in Querydr1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resdr1 = mysqli_fetch_array($execdr1))
						{
						$i = $i+1;
						$result[$i] = $resdr1['expenses'];
						}
						
						$j = 0;
						$crresult = array();
						
						
					}
					else
					{
						$result = array();
						$crresult = array();
					}
					
					$balance = array_sum($result) - array_sum($crresult);
					
					$sumbalance = $sumbalance + $balance;
					
				}
		}
		elseif($tbinclude == 'tb_accountap.php')
		{
		$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res267 = mysqli_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$orderid1 = $orderid1 + 1;
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	$lid = $lid + 1;
	$i = 0;
	$opening = 0;
	
	/* */
	$i = 0;
	$result = array();
	/*$querydr1 = "SELECT SUM(`transactionamount`) as payablesdr FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND (`docno` LIKE 'SP%' or `docno` LIKE 'SPE%') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
	$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
	while($resdr1 = mysql_fetch_array($execdr1))
	{
	$i = $i+1;
	$result[$i] = $resdr1['payablesdr'];
	}*/
	
 
	$j = 0;
	$crresult = array();
	$querycr1 = "SELECT SUM(`transactionamount`) as payables FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SOP%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in Querycr1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{
	$j = $j+1;
	$crresult[$j] = $rescr1['payables'];
	}
	
	$balance = array_sum($crresult) - array_sum($result) + $opening;
	$sumbalance = $sumbalance + $balance;
}
		}
		
		return $sumbalance;
	}
}
?>
</body>
</html>
