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

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
$reslocationname = $res["locationname"];
$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where locationname='$reslocationname'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$locationcode = $res3['locationcode'];
$locationname = $res3['locationname'];
$location = $locationcode;

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

if (isset($_REQUEST["ycompare"])) { $ycompare = $_REQUEST["ycompare"]; } else { $ycompare = ""; }
if (isset($_REQUEST["byear"])) { $byear = $_REQUEST["byear"]; } else { $byear = date('Y'); }
if (isset($_REQUEST["btype"])) { $btype = $_REQUEST["btype"]; } else { $btype = ""; }
if (isset($_REQUEST["percent"])) { $percent = $_REQUEST["percent"]; } else { $percent = ""; }
if (isset($_REQUEST["budgetdate"])) {$budgetdate = $_REQUEST['ADate1']; } else { $budgetdate = date('Y-m-d'); }
if (isset($_REQUEST["budgetname"])) {$budgetname = $_REQUEST['budgetname']; } else { $budgetname = ''; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frm1submit25"])) { $frm1submit25 = $_REQUEST["frm1submit25"]; } else { $frm1submit25 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if ($frm1submit25 == 'frm1submit25')
{

$paynowbillprefix = 'BN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from budgetentry order by auto_number desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $res2billnumber = $res2["budgetno"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='BN-'.'1';
	$openingbalance = '0.00';
}
else
{
	$res2billnumber = $res2["budgetno"];
	$billnumbercode = substr($res2billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumber = 'BN-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}	
	$budgetno = $billnumber;
	$budgetname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['budgetname']);
	$budgettype = $_REQUEST['btype'];
	$budgetyear = $_REQUEST['byear'];
	$budgetdate = $_REQUEST['ADate1'];
	$locationcode = $_REQUEST['locationcode'];
	$locationname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['locationname']);
	$k = $budgetyear - 1;
	
	for($i=1;$i<=200;$i++)
	{
		if(isset($_REQUEST['budgettype'.$i]))
		{	
			$ledgerid = $_REQUEST['ledgerid'.$i];
			if($ledgerid != '')
			{
				$budgettype = $_REQUEST['budgettype'.$i];
				$ledger = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['ledger'.$i]);
				$ledgervalue = $_REQUEST['L|'.$k.'|'.$i]; 
				$ledgervalue = str_replace(',','',$ledgervalue);
				$percent = $_REQUEST['P|'.$i];
				$projection = $_REQUEST['LV|'.$i];
				$projection = str_replace(',','',$projection);
				
				$query4 = "INSERT INTO `budgetentry`(`budgetno`, `budgetdate`, `budgetname`, `budgettype`, `budgetyear`, `accountcode`, `accountname`, `ledgervalue`, `markup`, `projection`, `recordstatus`, `username`, `ipaddress`, `updatedatetime`, `locationcode`, `locationname`) 
				VALUES ('$budgetno', '$budgetdate', '$budgetname', '$budgettype', '$budgetyear', '$ledgerid', '$ledger', '$ledgervalue', '$percent', '$projection', '', '$username', '$ipaddress', '$updatedatetime', '$locationcode', '$locationname')";
				//echo $query4;exit;
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
	
	header("location:budgetentry.php?st=success");
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

$paynowbillprefix = 'BN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from budgetentry order by auto_number desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $res2billnumber = $res2["budgetno"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='BN-'.'1';
	$openingbalance = '0.00';
}
else
{
	$res2billnumber = $res2["budgetno"];
	$billnumbercode = substr($res2billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumber = 'BN-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
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
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript">
function Calc(id)
{		
	var Total1 = "0.00";
	var idsplit = id.split('|');
	var Year = document.getElementById('byear').value;
	var Anum = idsplit[1];
	var IYear = parseFloat(Year) - 1;
	var amt2total = 0;
	//alert(Anum+'---'+IYear);
	if(document.getElementById(id)!=null)
	{	
		var Percent = document.getElementById(id).value;
		if(Percent == '') { Percent = "0.00"; }
		var LAmount = document.getElementById('L|'+IYear+'|'+Anum).value;
		LAmount=LAmount.replace(/,/g,'');
		var Calcamt = parseFloat(LAmount) * (parseFloat(Percent) / 100);
		var Final = parseFloat(LAmount) + parseFloat(Calcamt);
		Final = parseFloat(Final).toFixed(2);
		Finaltot = parseFloat(Final).toFixed(2);
		Final = Final.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById('LV|'+Anum).value = Final;
	}
	for(var i=0;i<=1000;i++)
	{
		if(document.getElementById('LV|'+i)!=null)
		{
			var Total2 = document.getElementById('LV|'+i).value;
			Total2=Total2.replace(/,/g,'');
			Total1=Total1.replace(/,/g,'');
			var Total1 = parseFloat(Total1) + parseFloat(Total2);
			Total1 = parseFloat(Total1).toFixed(2);
			Total1 = Total1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			if(document.getElementById('total')!=null)
			{
			document.getElementById('total').value = Total1;
			}
		}
	}
	
	var clssattr = document.getElementById(id).getAttribute("cval");
	var cvalstr = clssattr.split('_');
	var cval = cvalstr[0];
	$('.hasamt2_'+cval).find("input:text").each(function() {
 	 		
         amt2total = parseFloat(amt2total) + parseFloat(this.value);    
    });	
    var amt2total_new = amt2total.toFixed(2);
    var amt2total_final = amt2total_new.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	$('#amt2total_'+cval).text(amt2total_final);
}

function Process1()
{
	if(document.getElementById('budgetname').value == "")
	{
		alert("Enter Budget Name");
		document.getElementById('budgetname').focus();
		return false;
	}
}
$(document).ready(function(){

	
	var i=0;
	var j=0;
	
		$( ".parentPercent" ).keyup(function(e) {

			var amt1total = 0;
			var amt2total = 0;
 	 		
 	 		var This_id = $(this).attr("id");
 	 		
 	 		var idsplit = This_id.split('_');
			var id = idsplit[1];
			
 	 		var percent = $(this).val();
 	 		$('.has_'+id).find("input:text").each(function() {
 	 		
	            //inputName = $(this).attr("name");

	            $(this).val(percent);
	            $(this).keyup();
            
        	});

 	 		$('.hasamt2_'+id).find("input:text").each(function() {
 	 		
	            //inputName = $(this).attr("name");
	            amt2total = parseFloat(amt2total) + parseFloat(this.value);
        	});

 	 		var amt2totalfinal = amt2total.toFixed(2); 
 	 		var amt2totalfinal = amt2totalfinal.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        	$('#amt2total_'+id).text(amt2totalfinal);

        	var LVtotal = 0;
        	for(var i=0;i<=1000;i++)
			{
				if(document.getElementById('LV|'+i)!=null)
				{
					var lvvalue = document.getElementById('LV|'+i).value;
					
					LVtotal = parseFloat(LVtotal) + parseFloat(lvvalue);
					
				}
			}
			var LVfinal = LVtotal.toFixed(2);
			var LVfinal = LVfinal.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			$('#total').val(LVfinal);	

			var ledgertotal = 0;
			
			
		});

		
})
</script>
<body>
<form name="budget" id="budget" method="post" action="budgetentry.php" onSubmit="return Process1()">
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
		  <td bgcolor="#ecf0f5" class="bodytext3" align="left"><strong>Budget Entry </strong></td>
		  <td bgcolor="#ecf0f5" class="bodytext3" align="right"><strong><?php echo $locationname; ?>&nbsp;&nbsp;</strong></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">&nbsp; </td>
		  <td width="90%" align="left" class="bodytext3">&nbsp;</td>
		  </tr>
		   <tr>
		  <td width="10%" align="left" class="bodytext3">Budget Number </td>
		  <td width="90%" align="left" class="bodytext3"><input type="text" name="budgetno" id="budgetno" size="10" readonly value="<?php echo $billnumber; ?>"/></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">Budget Name </td>
		  <td width="90%" align="left" class="bodytext3"><input type="text" name="budgetname" id="budgetname" size="30" value="<?php echo $budgetname; ?>"/></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">Select Type</td>
		  <td width="90%" align="left" class="bodytext3"><select name="btype" id="btype">
		  <?php if($btype != '') { ?>
		  <option value="<?php echo $btype; ?>"><?php echo $btype; ?></option>
		  <?php } ?>
		  <option value="All">All</option>
		  <option value="Expense">Expense</option>
		  <option value="Income">Income</option>
		  </select>
		  </td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">Select Year </td>
		  <td width="90%" align="left" class="bodytext3"><select name="byear" id="byear">
		  <?php for($i=date('Y',strtotime('-2 Years'));$i<=date('Y',strtotime('+3 Years'));$i++) { ?>
		  <option value="<?php echo $i; ?>" <?php if($byear == $i) { echo "Selected"; } ?>><?php echo $i; ?></option>
		  <?php } ?>
		  </select></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">Years for Comparison </td>
		  <td width="90%" align="left" class="bodytext3"><select name="ycompare" id="ycompare">
		   <?php for($j=1;$j<=5;$j++) { ?>
		  <option value="<?php echo $j; ?>" <?php if($ycompare == $j) { echo "Selected"; } ?>><?php echo $j; ?></option>
		  <?php } ?>
		  </select></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">Apply Percentage </td>
		  <td width="90%" align="left" class="bodytext3"><input type="text" name="percent" id="percent" size="10" value="<?php echo $percent; ?>" /></td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">Budget Date</td>
		  <td width="90%" align="left" class="bodytext3"><input type="text" name="ADate1" id="ADate1" size="10" value="<?php echo $budgetdate; ?>" readonly/>
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
		  </tr>
		  <tr>
		  <td width="10%" align="left" class="bodytext3">&nbsp; </td>
		  <td width="90%" align="left" class="bodytext3">
		  <input type="hidden" name="location" id="location" value="<?php echo $location; ?>">
		  <input type="hidden" name="frm1submit1" id="frm1submit1" value="frm1submit1">
		  <input type="submit" name="submit" id="submit" value="Initiate" style="border:solid 1px #000033;"/></td>
		  </tr>
		   <tr>
		  <td width="10%" align="left" class="bodytext3">&nbsp; </td>
		  <td width="90%" align="left" class="bodytext3">&nbsp;</td>
		  </tr>
          </tbody>
        </table></td>
		</tr>
		</table>
	</td>
		</tr>
		</form>
		<form name="form1" id="form1" method="post" action="budgetentry.php">
		<tr>
        <td width="4%">&nbsp;</td><td width="96%"><table width="90%" border="1" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <input type="hidden" name="budgetname" id="budgetname" value="<?php echo $budgetname; ?>" size="10"/>
		  <input type="hidden" name="ADate1" id="ADate1" value="<?php echo $budgetdate; ?>" size="10"/>
		  <input type="hidden" name="btype" id="btype" value="<?php echo $btype; ?>" size="10"/>
		  <input type="hidden" name="byear" id="byear" value="<?php echo $byear; ?>" size="10"/>
		  <input type="hidden" name="percent" id="percent" value="<?php echo $percent; ?>" size="10"/>
		  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" />
		  <input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" />
		  <?php
			function subgroup1($parentid,$orderid,$sid)
			{	
				$colorloopcount = '';
				$ledgeramount = "0.00";
				$ledgeramountsum = "0.00";
				$ledgeramountsum1 = "0.00";
				$sid = 0;
				
				if (isset($_REQUEST["ycompare"])) { $ycompare = $_REQUEST["ycompare"]; } else { $ycompare = ""; }
				if (isset($_REQUEST["byear"])) { $byear = $_REQUEST["byear"]; } else { $byear = ""; }
				if (isset($_REQUEST["percent"])) { $percent = $_REQUEST["percent"]; } else { $percent = ""; }
				$query2 = "select * from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountssub'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$sid = $sid + 1;
					
					$colorloopcount = $colorloopcount + 1;
					$showcolor = ($colorloopcount & 1); 
					if ($showcolor == 0)
					{
						//echo "if";
						$colorcode = 'bgcolor="#FFFFFF"';
					}
					else
					{
						//echo "else";
						$colorcode = 'bgcolor="#FFFFCC"';
					}
					
					?>
					
		
					<?php
					$queryledger22 = "select * from master_accountname where accountssub = '$parentid2' and recordstatus <> 'deleted'";
					$execledger22 = mysqli_query($GLOBALS["___mysqli_ston"], $queryledger22) or die ("Error in queryledger22".mysqli_error($GLOBALS["___mysqli_ston"]));
					$numledger22= mysqli_num_rows($execledger22);
					if($numledger22>0){ ?>

						<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td colspan="2" width="494" align="left" class="bodytext3" style="text-decoration:none">
					
					&nbsp;<strong><?php echo $accountsmain2; ?></strong></td>
					
						<td align="right" class="bodytext3"><input type="text" class="parentPercent" name="ph[]; ?>" id="ph_<?php echo $parentid2; ?>" style="text-align:right;font-weight:bold;"></td><td>&nbsp;</td>
					
					</tr>

						<?php subledger1($parentid2); 


					}
					
				}
				?>
				<?php
				
				//groupleft($ledgeramountsum);
			}
			$tt = 0;
			function subledger1($parentid)
			{
			$ledgerbuild = '';
			$orderid = 0;
			$lid = 0;
			$sid = 0;
			$ledgeramttotal = 0;
				global $tt;
				$colorloopcount = '';
				$ledgeramountsum = '0.00';
				if (isset($_REQUEST["ycompare"])) { $ycompare = $_REQUEST["ycompare"]; } else { $ycompare = ""; }
				if (isset($_REQUEST["byear"])) { $byear = $_REQUEST["byear"]; } else { $byear = ""; }
				if (isset($_REQUEST["percent"])) { $percent = $_REQUEST["percent"]; } else { $percent = ""; }
				
				$query2 = "select * from master_accountname where accountssub = '$parentid' and recordstatus <> 'deleted'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res2 = mysqli_fetch_array($exec2))
				{  
					$accountsmain2 = $res2['accountname'];
					$orderid1 = $orderid + 1;
					$parentid2 = $res2['auto_number'];
					$id2 = $res2['id'];
					$lid = $lid + 1;
					$sid = $sid + 1;
					$tt = $tt + 1;
					
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
					if($parentid == '1')
					{
						$type1 = "Revenue";
					}
					else
					{
						$type1 = "Expense";
					}
					$aaa = '';
					//$ledgeramount = 0.00;
					//$ledgeramount = ledgervalue($parentid2,$ADate1,$ADate2);
					?>
					<tr style="display" id="<?php echo $sid; ?>" <?php echo $colorcode; ?>> 
					<td width="494" align="left" class="bodytext3" style="text-decoration:none"><strong>
					<?php for($i=0;$i<$orderid1;$i++)
					{
						echo '&nbsp;&nbsp;&nbsp;'.$tt.'. &nbsp;';
					}
					?>
					<input type="hidden" name="budgettype<?php echo $tt; ?>" id="budgettype<?php echo $tt; ?>" value="<?php echo $type1; ?>" size="5" readonly style="text-align:left; font-weight:bold; background-color:transparent; border:none;" />
					<input type="text" name="ledgerid<?php echo $tt; ?>" id="ledgerid<?php echo $tt; ?>" value="<?php echo $id2; ?>" size="5" readonly style="text-align:left; font-weight:bold; background-color:transparent; border:none;" />
					<input type="text" name="ledger<?php echo $tt; ?>" id="ledger<?php echo $tt; ?>" value="<?php echo $accountsmain2; ?>" size="35" readonly style="text-align:left; font-weight:bold; background-color:transparent; border:none;" />
					</strong></td>
					<?php
					for($k=$byear-$ycompare;$k<$byear;$k++)
					{
					$SADate1 = $k.'-01-01';
					$SADate2 = $k.'-12-31';
					$ledgeramount = ledgervalue($parentid2,$SADate1,$SADate2);
					$ledgeramttotal = $ledgeramttotal + $ledgeramount;
					${"ledgeramountsumtotal1".$year}='0';
					groupleft($ledgeramount,$k);
				    //$ledgeramount = '0.00';
					?>
					<td align="right" class="bodytext3 hasamt1_<?php echo $parentid;?>" style="text-decoration:none"><input type="text" name="<?php echo 'L|'.$k.'|'.$tt; ?>" id="<?php echo 'L|'.$k.'|'.$tt; ?>" value="<?php echo number_format($ledgeramount,2,'.',','); ?>" class="ledgerinput" size="10" style="text-align:right; font-weight:bold; background-color:transparent; border:none;" readonly /></strong>
					</td>
					
					<?php
					}
					?>
					<td align="right" class="bodytext3 has_<?php echo $parentid;?>" style="color:#FFFFFF"><strong><input type="text" name="<?php echo 'P|'.$tt; ?>" cval="<?php echo $parentid.'_'.$tt; ?>" id="<?php echo 'P|'.$tt; ?>" size="10" value="<?php echo $percent; ?>" onKeyUp="return Calc(this.id)" style="text-align:right;font-weight:bold;" autocomplete="off"></strong></td>
					<td align="right" class="bodytext3 hasamt2_<?php echo $parentid;?>" style="color:#FFFFFF"><strong><input type="text" name="<?php echo 'LV|'.$tt; ?>" id="<?php echo 'LV|'.$tt; ?>" value="0.00" size="15" readonly style="text-align:right;font-weight:bold;background-color:transparent; border:none;"></strong></td>
					</tr>
					
					<script type="text/javascript">
					<?php $g = $byear; ?>
					Calc('<?php echo 'P|'.$tt; ?>');
					</script>
					<?php
				
				}

				if($ledgeramttotal > 0){
				?>
				<tr><td></td><td id="amt1total_<?php echo $parentid; ?>" style="text-align:right; font-weight:bold; background-color:transparent; border:none;"><?php  echo number_format($ledgeramttotal,2,'.',','); ?></td><td></td><td id="amt2total_<?php echo $parentid; ?>" style="text-align:right; font-weight:bold; background-color:transparent; border:none;"> </td></tr>
				<?php
			     }
			}
			
			$a_json_row = array();
			function groupleft($a,$year)
			{
			global $a_json_row;
			$ledgeramountsumtotal1=$a_json_row[$year];
		
			$ledgeramountsumtotal1 = $ledgeramountsumtotal1 + $a;
			return $a_json_row[$year] = $ledgeramountsumtotal1;
			
			}
			?>
			
		  <?php
		  if(isset($_REQUEST['frm1submit1'])) { $frm1submit1 = $_REQUEST['frm1submit1']; } else { $frm1submit1 = ''; }
		  if($frm1submit1 == 'frm1submit1')
		  {
		  ?>
		  <tr bgcolor="#0033FF">
			<td width="494" align="left" class="bodytext3" style="color:#FFFFFF"><strong>Account Ledger Name</strong></td>
		  <?php
			for($k=$byear-$ycompare;$k<$byear;$k++)
			{
			?>
			<td width="123" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo $k; ?></strong></td>
			<?php
			}
			?>
			<td width="116" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Markup'; ?></strong></td>
			<td width="145" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Projection for '.$byear; ?></strong>
			<input type="hidden" name="subtotal" id="subtotal" value="0.00"></td>
			</tr>
		  <?php
		    $snocount = "";
			if($btype == 'All') { $cond = "'Revenue','Expenses'"; }
			else if($btype == 'Expense') { $cond = "'Expenses'"; }
			else if($btype == 'Income') { $cond = "'Revenue'"; }
			$query1 = "select * from master_accountsmain where recordstatus <> 'deleted' and accountsmain IN ($cond) order by accountsmain ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			$accountsmain = $res1['accountsmain'];
			$parentid = $res1['auto_number'];
			$orderid = 1;
			//$orderid = $res1['orderid'];
			$type = substr($accountsmain,0,1);
	
			?>
			<tr bgcolor="#999999">
			<td width="494" align="left" class="bodytext3"><strong><?php echo $accountsmain; ?></strong></td>
			<td colspan="10" align="right" class="bodytext3">&nbsp;</td>
			</tr>
			<?php		
			$querygroup2 = "select * from master_accountssub where accountsmain = '$parentid' and recordstatus <> 'deleted'";
			$execgroup2 = mysqli_query($GLOBALS["___mysqli_ston"], $querygroup2) or die ("Error in Querygroup2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numgroup2= mysqli_num_rows($execgroup2); 
			if($numgroup2>0){ subgroup1($parentid,$orderid,$parentid.'10000'); 
			}
		   }	
			?>
			<tr style="display" bgcolor="#ecf0f5"> 
			<td width="494" align="left" class="bodytext3" style="text-decoration:none">
			<strong><?php echo 'TOTAL'; ?></strong></td>
			<?php
			for($k=$byear-$ycompare;$k<$byear;$k++)
			{
			?>
			<td align="right" class="bodytext3" style="text-decoration:none;"><strong><?php $aa = groupleft(0,$k); ?>
			<input type="text" name="" id="ledgertotal" value="<?php echo number_format($aa,2,'.',','); ?>" size="10" style="text-align:right; font-weight:bold; background-color:transparent; border:none;" readonly /></strong></td>
			<?php
			}
			?>
			<td align="right" class="bodytext3" style="color:#FFFFFF">&nbsp;</td>
			<td align="right" class="bodytext3" style="color:#FFFFFF">
			<input type="text" name="total" id="total" value="0.00" size="10" style="text-align:right; font-weight:bold; background-color:transparent; border:none;" readonly /></td>
			</tr>
			<script type="text/javascript">
			<?php $g = $byear; ?>
			Calc('<?php echo 'P|'.$g.'|'.'0'.'|'.'0'; ?>');	
			</script>
			
			<tr>
			<td colspan="10" align="left" class="bodytext3">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="10" align="left" class="bodytext3">
			<input type="hidden" name="frm1submit25" id="frm1submit25" value="frm1submit25">
			<input type="submit" name="submit23" value="Save Budget" style="border:solid 1px #000066;"></td>
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
	
	$query92 = "select * from master_accountname where auto_number = '$parentid'";
	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num92 = mysqli_num_rows($exec92);
	while($res92 = mysqli_fetch_array($exec92))
	{  
		$accountsmain2 = $res92['accountname'];
		$orderid1 = $orderid1 + 1;
		$parentid2 = $res92['auto_number'];
		$ledgeranum = $parentid2;
		$id2 = $res92['id'];
		$lid = $lid + 1;
		$ledgerid = $id2;
		$group = $res92['accountssub'];
		
		include('include_ledgervalue.php');
		
		$sumbalance = $sumbalance + $balance;
		
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
		
	}
	
	return $sumbalance;
}
?>


</body>
</html>