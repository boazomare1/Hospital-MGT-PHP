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
					    <input type="text" name="ADate1" id="ADate1" readonly="readonly" style="border: 1px solid #001E6A" value="<?php echo $ADate1; ?>"  size="10" onKeyDown="return disableEnterKey()" />
<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </span></td>
						<td width="8%"  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> To Date </td>
                      <td width="63%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" readonly="readonly" style="border: 1px solid #001E6A" value="<?php echo $ADate2; ?>"  size="10" onKeyDown="return disableEnterKey()" />
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
				$query2 = "select accountssub,auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' and parentid ='0' order by accountssub";
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
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' and parentid ='0'";
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
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseleft" value="" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupleft12 = groupleft('0'); //echo number_format($groupleft12,2,'.',','); ?></strong>
			<input type="text" id="debit" value="<?php echo number_format($groupleft12,2,'.',''); ?>" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
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
				$query2 = "select accountssub, auto_number,tbinclude,tbledgerview,tbclosing from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' and parentid ='0' order by accountssub";
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
			$querygroup2 = "select accountsmain from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted' and parentid ='0'";
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
			<td width="100" align="right" class="bodytext3" style="color:;"><input type="text" id="suspenseright" value="" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
			</tr>
			<?php
			}
			?>
			<tr bgcolor="#999999">
			<td width="695" align="left" class="bodytext3" style="color:#000000"><strong>Total :</strong></td>
			<td width="100" align="right" class="bodytext3" style="color:#000000"><strong><?php $groupright12 = groupright(0); //echo number_format($groupright12,2,'.',','); ?></strong>
			<input type="text" id="credit" value="<?php echo number_format($groupright12,2,'.',''); ?>" readonly="readonly" style="text-align:right;border:none;background:transparent; font-weight:bold;"></td>
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
		if($tbinclude == 'tb_accountbank.php'|| $tbinclude == 'tb_accountincome.php' || $tbinclude == 'tb_accountincomeser.php' || $tbinclude == 'tb_accountar.php') // 
		{
		
		
		if($tbinclude == 'tb_accountbank.php') // 
		{
		
$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res267 = mysqli_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	$accountbank = 0;
	$i = 0;
	$opendr = 0;
	$opencr = 0;
	$accountdr = 0;
	$accountcr = 0;
$type=mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT transactionmode FROM financialaccount WHERE ledgercode = '".$id."'"))[0];
			
			switch($type){
			case 'CREDITCARD':
				$col= 'cardamount';
				break;
			case 'MPESA':
				$col= 'creditamount';
				break;
			case 'CHEQUE':
				$col= 'chequeamount';
				break;
			case 'ONLINE':
				$col= 'onlineamount';
				break;
			case 'CASH':
				$col= 'cashamount';
				break;
			default :
				$col = 'transactionamount';
				break;	
			}
	/**/
	$drresult = array();
	$querydr1bnk = "SELECT SUM(`$col`) as bankamount FROM `master_transactionpaynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id' or `transactionmode` = 'SPLIT') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` LIKE 'OPC%' AND '$id' in (select ledgercode from financialaccount)
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionexternal` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`$col`) as bankamount FROM `billing_consultation` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id' or `transactionmode` = 'SPLIT') and billtype='PAY NOW' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND '$id' in (select ledgercode from financialaccount)
					";
	$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1bnk) or die ("Error in querydr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($resdr1 = mysqli_fetch_array($execdr1))
	{
	$i = $i+1;
	$drresult[$i] = $resdr1['bankamount'];
	}
	
	/* 
	*/
	
	$j = 0;
	$crresult = array();
	$querycr1bnk = "SELECT SUM(`transactionamount`) as bankcredit FROM `refund_paynow` WHERE (`bankcode` = '$id' or `cashcode` = '$id' or `mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					";
	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bnk) or die ("Error in querycr1bnk".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{
	$j = $j+1;
	$crresult[$j] = $rescr1['bankcredit'];
	}
	
	$accountbank = array_sum($drresult) - array_sum($crresult);
	
	$sumbalance = $sumbalance + $accountbank;
}
	
			
			
		}
		
		
		
		if($tbinclude == 'tb_accountincome.php') // 
		{
	
$journal = 0;
$external_services_add=0;
			
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{ 
	$accountsmain2 = $res267['accountname'];
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	$accountbank = 0;
	$i = 0;
	$opendr = 0;
	$opencr = 0;
	$accountdr = 0;
	$accountcr = 0;
	$i = 0;
	
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem <> '1'
						UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and ledgercode = '$id'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						"; 
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
		UNION ALL SELECT SUM(`serviceamount`) as incomedebit FROM `refund_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'";
		
	
	
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
	case '01-1015-13':
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
		$querycr1in = "SELECT SUM(a.`consultation`) as income FROM `billing_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment  and a.billtype='PAY NOW' AND a.`billdate` BETWEEN '$ADate1' AND '$ADate2'
					  
					   UNION ALL SELECT SUM(-1*a.`consultation`) as income FROM `refund_consultation` AS a JOIN `master_visitentry` AS b ON (a.patientvisitcode = b.visitcode) WHERE b.department $consdepartment and a.billtype='PAY NOW'  AND a.billdate BETWEEN '$ADate1' AND '$ADate2'
					  "; 
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
						"; 
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
		";
				
		
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
						"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`radiologyitemrate`) as incomedebit FROM `refund_paynowradiology` as a join master_radiology as b on (a.radiologyitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledger_code = '$id'
		";
		
		
		
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	

	if($id == '01-1008')
	{
	
	$i = 0;
		$crresult1 = array();
		$querycr1in = "SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
						"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		
		
		$j = 0;
		$drresult1 = array();
		$querydr1in = "SELECT SUM(`referalrate`) as incomedebit FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
		";
		
		$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($resdr1 = mysqli_fetch_array($execdr1))
		{
		$j = $j+1;
		$drresult1[$j] = $resdr1['incomedebit'];
		}
		
		$sumbalance = $sumbalance + array_sum($crresult1) - array_sum($drresult1);
	
	}
	//UNION ALL 

	
}
				
				$sumbalance;
					
			
		}
		
		
		if($tbinclude == 'tb_accountincomeser.php') // 
		{
			
		
				$query267 = "select id,accountssub,auto_number from master_accountssub where parentid = '$parentid'";
				$exec267 = mysqli_query($GLOBALS["___mysqli_ston"], $query267) or die ("Error in Query267".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res267 = mysqli_fetch_array($exec267))
				{
				$id = $res267['id'];
				$i = 0;
	
		$crresult1 = array();
		$querycr1in = "SELECT SUM(a.`fxamount`) as income FROM `billing_paynowservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id' and a.wellnessitem not like 'yes'
						UNION ALL SELECT SUM(a.`servicesitemrate`) as income FROM `billing_externalservices` as a join master_services as b on (a.servicesitemcode = b.itemcode) WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and b.ledgerid = '$id'
						"; 
		$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescr1 = mysqli_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult1[$i] = $rescr1['income'];
		}
		$journal=0;
		$query2671 = "select id,accountssub,auto_number from master_accountssub where parentid = '$id'";
				$exec2671 = mysqli_query($GLOBALS["___mysqli_ston"], $query2671) or die ("Error in Query2671".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2671 = mysqli_fetch_array($exec2671))
				{
					$id1 = $res2671['id'];
		$queryjndr = "SELECT SUM(`debitamount`) as debit FROM `master_journalentries` WHERE `ledgerid` = '$id1' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjndr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjndr) or die ("Error in queryjndr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjndr = mysqli_fetch_array($execjndr);
					$jndebit = $resjndr['debit'];
					
					$queryjncr = "SELECT SUM(`creditamount`) as credit FROM `master_journalentries` WHERE `ledgerid` = '$id1' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execjncr = mysqli_query($GLOBALS["___mysqli_ston"], $queryjncr) or die ("Error in queryjncr".mysqli_error($GLOBALS["___mysqli_ston"]));
					$resjncr = mysqli_fetch_array($execjncr);
					$jncredit = $resjncr['credit'];
					
					//$journal += $jncredit - $jndebit;
				}	
				$sumbalance = $sumbalance + array_sum($crresult1)+$journal;
		}
		$sumbalance = $sumbalance;
					
			
		}
		
		
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		return $sumbalance;
		}	
	}
	else
	{
		return $sumbalance;
	}
}
?>
</body>
</html>
