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
$reslocationcode = $res3['locationcode'];

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
if (isset($_REQUEST["docno"])) {$docno = $_REQUEST['docno']; } else { $docno = ''; }
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frm1submit25"])) { $frm1submit25 = $_REQUEST["frm1submit25"]; } else { $frm1submit25 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if ($frm1submit25 == 'frm1submit25')
{
	$docno = $_REQUEST['docno'];
	$xlexport = $_REQUEST['xlexport'];
	$approvedby = $_REQUEST['approvedby'];
	
	$query7 = "UPDATE budgetentry SET approvedby = '$approvedby' WHERE budgetno = '$docno'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	for($i=1;$i<=2000;$i++)
	{
		if(isset($_REQUEST['chk'.$i]))
		{	
			$chk = $_REQUEST['chk'.$i];
			if($chk != '')
			{
				$percent = $_REQUEST['P|'.$i];
				$percent = str_replace(',','',$percent);
				$percentamount = $_REQUEST['PA|'.$i];
				$percentamount = str_replace(',','',$percentamount);
				$projection = $_REQUEST['LV|'.$i];
				$projection = str_replace(',','',$projection);
				
				$query4 = "UPDATE `budgetentry` SET `markup` = '$percent', `markupamount` = '$percentamount', `projection` = '$projection' WHERE `auto_number` = '$chk'";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	}
	
	if($xlexport == '')
	{
	header("location:budgetentryview.php?st=view&&docno=$docno");
	}
	else
	{
	header("location:budgetentryview.php?st=view&&et=excel&&docno=$docno");
	}
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["et"])) { $et = $_REQUEST["et"]; } else { $et = ""; }
//$banum = $_REQUEST["banum"];

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
<script type="text/javascript">
var Et = "<?php echo $et; ?>";
var Doc = "<?php echo $docno; ?>";
if(Et == 'excel')
{
	window.open ("budgetentryviewxl.php?docno="+Doc+"");
}
</script>
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
<script type="text/javascript">
function Calc(id)
{		
	var Total1 = "0.00";
	var idsplit = id.split('|');
	var Year = document.getElementById('byear').value;
	var Anum = idsplit[1];
	document.getElementById('PA|'+Anum).disabled = true;
	document.getElementById('PA|'+Anum).value = "0.00";
	var IYear = parseFloat(Year);
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
}

function Calc1(id)
{		
	var Total1 = "0.00";
	var idsplit = id.split('|');
	var Year = document.getElementById('byear').value;
	var Anum = idsplit[1];
	document.getElementById('P|'+Anum).disabled = true;
	document.getElementById('P|'+Anum).value = "0.00";
	var IYear = parseFloat(Year);
	//alert(Anum+'---'+IYear);
	if(document.getElementById(id)!=null)
	{	
		var Percent = document.getElementById(id).value;
		if(Percent == '') { Percent = "0.00"; }
		var LAmount = document.getElementById('L|'+IYear+'|'+Anum).value;
		LAmount=LAmount.replace(/,/g,'');
		var Calcamt = (parseFloat(Percent));
		var Final = parseFloat(Calcamt);
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
}

function Check(id)
{
	var chk = document.getElementById(id).checked;
	if(chk == true)
	{
		document.getElementById('P|'+id).disabled = false;
		document.getElementById('PA|'+id).disabled = false;
	}
	else
	{
		document.getElementById('P|'+id).disabled = true;
		document.getElementById('PA|'+id).disabled = true;
	}
}
</script>
<body>
<form name="budget" id="budget" method="post" action="budgetentryview.php">
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
       <td width="96%"><table width="78%" border="0" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <tr bgcolor="#011E6A">
		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="5" align="left"><strong>Budget Entries - Initiated</strong></td>
		  <td bgcolor="#ecf0f5" class="bodytext3" colspan="5" align="right"><strong><?php echo $reslocationname; ?></strong></td>
		  </tr>
		  <tr>
		  <td colspan="10" align="left" class="bodytext3">&nbsp; </td>
		  </tr>
		  <?php
		   $query6 = "select * from budgetentry where budgetno = '$docno' group by budgetno order by budgetyear";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res6 = mysqli_fetch_array($exec6))
		  {
		  $budgetno = $res6['budgetno'];
		  $budgetdate = $res6['budgetdate'];
		  $budgetname = $res6['budgetname'];
		  $budgetyear = $res6['budgetyear'];
		  $budgetby = $res6['username'];
		  $quarterly = $res6['quarterly'];
		  $sno = $sno + 1;
		  
		  switch($quarterly){
			case('1'):
			$desc = "Jan - Mar";
			$premonth = "Oct - Dec";
			break;
			case('2'):
			$desc = "Apr - Jun";
			$premonth = "Jan - Mar";
			break;
			case('3'):
			$desc = "Jul - Sep";
			$premonth = "Apr - Jun";
			break;
			case('4'):
			$desc = "Oct - Dec";
			$premonth = "Jul - Sep";
			break;
			default:
			$desc = "";
			break;		
		}
		  
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
		  <td colspan="10" align="left">&nbsp;</td>
		  </tr>
          </tbody>
        </table></td>
		</tr>
		</table>
	</td>
		</tr>
		</form>
		<form name="form1" id="form1" method="post" action="budgetentryview.php">
		<tr>
        <td width="4%">&nbsp;</td><td width="96%"><table width="73%" border="1" align="left" cellpadding="4" cellspacing="4" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		
		  <tr bgcolor="#0033FF">
		    <td width="38" align="left" class="bodytext3" style="color:#FFFFFF"><strong>S.No</strong></td>
			<td width="38" align="left" class="bodytext3" style="color:#FFFFFF"><strong>Select</strong></td>
			<td width="74" align="left" class="bodytext3" style="color:#FFFFFF"><strong>Ledger Code</strong></td>
			<td width="274" align="left" class="bodytext3" style="color:#FFFFFF"><strong>Ledger Name</strong></td>
			<td width="160" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo $premonth; ?></strong></td>
			<td width="208" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Markup %'; ?></strong></td>
            <td width="208" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Markup Amt'; ?></strong></td>
			<td width="125" align="center" class="bodytext3" style="color:#FFFFFF"><strong><?php echo 'Projection for '.$desc.' '.$budgetyear; ?></strong>
			<input type="hidden" name="subtotal" id="subtotal" value="0.00">
			<input type="hidden" name="docno" value="<?php echo $docno; ?>" /></td>
			</tr>
		  <?php
		    $snocount = "";
			$total1 = "0.00";
			$total2 = "0.00";
			$query1 = "select * from budgetentry where budgetno = '$docno' order by auto_number";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			{  
			  $anum = $res1['auto_number'];
			  $budgetno = $res1['budgetno'];
			  $accountcode = $res1['accountcode'];
			  $accountname = $res1['accountname'];
			  $ledgervalue = $res1['ledgervalue'];
			  $markup = $res1['markup'];
			  $markupamount = $res1['markupamount'];
			  $projection = $res1['projection'];
			  $snocount = $snocount + 1;
			  
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
			 ?>
			  <tr <?php echo $colorcode; ?>>
			  <td align="left" class="bodytext3"><strong><?php echo $snocount; ?></strong></td>
			  <td align="center" class="bodytext3"><strong><input type="checkbox" name="chk<?php echo $snocount; ?>" id="<?php echo $snocount; ?>" value="<?php echo $anum; ?>" onClick="return Check(this.id)"></strong></td>
			  <td align="left" class="bodytext3"><strong><?php echo $accountcode; ?></strong></td>
			  <td align="left" class="bodytext3"><strong><?php echo $accountname; ?></strong></td>
			 <td align="right" class="bodytext3" style="text-decoration:none"><input type="text" name="<?php echo 'L|'.$budgetyear.'|'.$snocount; ?>" id="<?php echo 'L|'.$budgetyear.'|'.$snocount; ?>" value="<?php echo number_format($ledgervalue,2,'.',','); ?>" size="10" style="text-align:right; font-weight:bold; background-color:transparent; border:none;" readonly /></strong>
			</td>
			<td align="right" class="bodytext3" style="color:#FFFFFF"><strong><input type="text" disabled="disabled" name="<?php echo 'P|'.$snocount; ?>" id="<?php echo 'P|'.$snocount; ?>" size="10" value="<?php echo $markup; ?>" onKeyUp="return Calc(this.id)" style="text-align:right;font-weight:bold;" autocomplete="off"></strong></td>
			<td align="right" class="bodytext3" style="color:#FFFFFF"><strong><input type="text" disabled="disabled" name="<?php echo 'PA|'.$snocount; ?>" id="<?php echo 'PA|'.$snocount; ?>" size="10" value="<?php echo $markupamount; ?>" onKeyUp="return Calc1(this.id)" style="text-align:right;font-weight:bold;" autocomplete="off"></strong></td>
            <td align="right" class="bodytext3" style="color:#FFFFFF"><strong><input type="text" name="<?php echo 'LV|'.$snocount; ?>" id="<?php echo 'LV|'.$snocount; ?>" value="<?php echo number_format($projection,2,'.',','); ?>" size="15" readonly style="text-align:right;font-weight:bold;background-color:transparent; border:none;"></strong></td>
			</tr>
			<?php
		    }	
			?>	
			<tr bgcolor="#ecf0f5">
			  <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			  <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			   <td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
			  <td align="left" class="bodytext3"><strong>TOTAL</strong></td>
			 <td align="right" class="bodytext3" style="text-decoration:none"><strong><input type="text" name="" id="" value="<?php echo number_format($total1,2,'.',','); ?>" size="15" readonly style="text-align:right;font-weight:bold;background-color:transparent; border:none;"></strong></td>
			<td align="right" class="bodytext3" style="color:#FFFFFF">&nbsp;</td>
            <td align="right" class="bodytext3" style="color:#FFFFFF">&nbsp;</td>
			<td align="right" class="bodytext3" style="color:#FFFFFF"><strong><input type="text" name="total" id="total" value="<?php echo number_format($total2,2,'.',','); ?>" size="15" readonly style="text-align:right;font-weight:bold;background-color:transparent; border:none;"></strong></td>
			</tr>		
			<tr>
			<td colspan="10" align="left" class="bodytext3">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="4" align="left" class="bodytext3">
			<input type="hidden" name="approvedby" id="approvedby" value="<?php echo $username; ?>">
			<strong>Approved By : &nbsp;<?php echo strtoupper($username); ?></strong>
			<input type="hidden" name="frm1submit25" id="frm1submit25" value="frm1submit25">
			</td>
			<td colspan="4" align="right" class="bodytext3">
			<input type="hidden" name="xlexport" id="xlexport" value="">
			<input type="submit" name="submit23" value="Update Budget" style="border:solid 1px #000066;">&nbsp;&nbsp;&nbsp;
			<input type="submit" name="excel" value="Update & Export Excel" style="border:solid 1px #000066;" onClick="javascript: document.getElementById('xlexport').value='Excel';"></td>
			</tr>
			
		  </tbody>
		  </table>
		</form>

<?php include ("includes/footer1.php"); ?>

</body>
</html>