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
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
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

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
}

</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{

}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td valign="top">
	<form name="form1" id="form1" method="post" action="employeenettreport.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td width="74" align="left" class="bodytext3">Search Year</td>
	<td width="56" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
	<?php if($searchyear != '') { ?>
	<option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
	<?php } ?>
	<?php
	for($j=2010;$j<=date('Y');$j++)
	{
	?>
	<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
	<?php
	}
	?>
	</select></td>
	<td colspan="3" width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</td>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<?php
	if ($frmflag1 == 'frmflag1')
	{	
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee";
	?>
	<table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#ecf0f5">
	<td colspan="5" align="left" class="bodytext3"><strong>P.A.Y.E SUPPORTING LIST</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="left" class="bodytext3"><strong>YEAR : <?php echo $searchyear; ?></strong></td>
	</tr>
	<!--<tr>
	<td colspan="30" align="left" class="bodytext3"><a href="print_payrollmonthwisereport.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" height="40" width="40"></a></td>
	</tr>-->
	<tr>
	<td width="26" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>
	<td width="101" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE'S PIN</strong></td>
	<td width="99" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE'S NAME</strong></td>
	<td align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>TOTAL EMOLUMENTS </strong></td>
	<td align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>TOTAL DEDUCTED </strong></td>
	</tr>
		<?php
		$finalearnings = '0.00';
		$finaldeductions = '0.00';
		$totalearnings = '0.00';
		$totaldeductions = '0.00';
		$nettpay = '0.00';
		$grosspay = '0.00';
		$totalnotionalbenefit = '0.00';
		$res5componentamount = '0.00';
		$res51componentamount = '0.00';
		
		$query11 = "select * from payroll_assign where employeename like '%$searchemployee%' and status <> 'deleted' group by employeecode order by employeename";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res11 = mysqli_fetch_array($exec11))
		{
		$res11employeecode = $res11['employeecode'];
		
		$query67 = "select * from master_employeeinfo where employeecode = '$res11employeecode'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die ("Error in Query67".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res67 = mysqli_fetch_array($exec67);
		$employeename = $res67['employeename'];
		$pinno = $res67['pinno'];
		
		$totalearnings = '0.00';
		$totaldeductions = '0.00';
		$nettpay = '0.00';
		$grosspay = '0.00';
		$totalnotionalbenefit = '0.00';
		$res5componentamount = '0.00';
		$res51componentamount = '0.00';

		$query3 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res3 = mysqli_fetch_array($exec3))
		{
			$res3componentanum = $res3['componentanum'];
			
			$query6 = "select * from master_payrollcomponent where auto_number = '$res3componentanum' and recordstatus <> 'deleted' and notional = 'No'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6componentname = $res6['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res3['componentname'];
				$res3componentrate = $res3['componentrate'];
				$res3componentunit = $res3['componentunit'];
				$res3componentamount = $res3['componentamount'];
				
				$totalearnings = $totalearnings + $res3componentamount;			
		?>
		
		<?php
		}
		}
		?>
		
		<?php
		$query7 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res7 = mysqli_fetch_array($exec7))
		{
			$res7componentanum = $res7['componentanum'];
			
			$query8 = "select * from master_payrollcomponent where auto_number = '$res7componentanum' and recordstatus <> 'deleted' and notional = 'Yes'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8componentname = $res8['componentname'];
			if($res8componentname != '')
			{
				$res7componentname = $res7['componentname'];
				$res7componentrate = $res7['componentrate'];
				$res7componentunit = $res7['componentunit'];
				$res7componentamount = $res7['componentamount'];
				
				$totalnotionalbenefit = $totalnotionalbenefit + $res7componentamount;
				
				$totalearnings = $totalearnings + $res7componentamount;			
		?>
		
		<?php
		}
		}
		?>
		<?php
		$query81 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and componentanum = '0' and typecode = '10' and status <> 'deleted'";
		$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res81 = mysqli_fetch_array($exec81);
		$res81componentname = $res81['componentname'];
		if($res81componentname != '')
		{
			$res81componentname = $res81['componentname'];
			$res81componentrate = $res81['componentrate'];
			$res81componentunit = $res81['componentunit'];
			$res81componentamount = $res81['componentamount'];
			
			$totalnotionalbenefit = $totalnotionalbenefit + $res81componentamount;
			
			$totalearnings = $totalearnings + $res81componentamount;			
		?>
		
		<?php
		}
		?>
		
		<?php
		$query5 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and componentanum = '5' and status <> 'deleted'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res5 = mysqli_fetch_array($exec5);
		$res5componentname = $res5['componentname'];
		$res5componentrate = $res5['componentrate'];
		$res5componentunit = $res5['componentunit'];
		$res5componentamount = $res5['componentamount'];
		if($res5componentname != '')
		{
		?>
		
		<?php
		}
		$taxablepay = $totalearnings - $res5componentamount;
		
		?>
		<?php
		$query51 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and componentanum = '7' and status <> 'deleted'";
		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res51 = mysqli_fetch_array($exec51);
		$res51componentname = $res51['componentname'];
		$res51componentrate = $res51['componentrate'];
		$res51componentunit = $res51['componentunit'];
		$res51componentamount = $res51['componentamount'];
		if($res51componentname != '')
		{
		?>
		
		<?php
		}
		$taxablepay = $taxablepay - $res51componentamount;
		
		?>
		
		<?php
		$query52 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and componentanum = '8' and status <> 'deleted'";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res52 = mysqli_fetch_array($exec52);
		$res52componentname = $res52['componentname'];
		$res52componentrate = $res52['componentrate'];
		$res52componentunit = $res52['componentunit'];
		$res52componentamount = $res52['componentamount'];
		if($res52componentname != '')
		{
			$query53 = "select * from master_taxrelief where status <> 'deleted'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die ("Error in Query53".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$res53amount = $res53['finalamount'];
			
			$taxcharged = $res53amount + $res52componentamount;
		?>
		
		<?php
		}
		?>
		
		<?php
		$query4 = "select * from details_employeepayroll where employeecode = '$res11employeecode' and typecode = '20' and status <> 'deleted' order by auto_number";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res4 = mysqli_fetch_array($exec4))
		{
			$res4componentanum = $res4['componentanum'];
			$res4componentname = $res4['componentname'];
			$res4componentrate = $res4['componentrate'];
			$res4componentunit = $res4['componentunit'];
			$res4componentamount = $res4['componentamount'];
			
			$totaldeductions = $totaldeductions + $res4componentamount;
			
			
		?>
		
		<?php
		}
		
		$grosspay = $totalearnings - $totalnotionalbenefit;
		$nettpay = $grosspay - $totaldeductions;
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		?>
		<tr <?php echo $colorcode; ?>>
		  <td align="center" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $colorloopcount; ?></td>
		  <td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $pinno; ?></td>
		  <td align="left" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo $employeename; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($grosspay,2,'.',','); ?>&nbsp;&nbsp;</td>
       	  <td align="right" valign="middle" nowrap="nowrap" class="bodytext3"><?php echo number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		
		$finalearnings = $finalearnings + $grosspay;
		$finaldeductions = $finaldeductions + $totaldeductions;
		
		}
		?>
		<tr bgcolor="#ecf0f5">
		<td colspan="3" align="right" valign="middle" class="bodytext3"><strong>Total : </strong></td>
		<td align="right" valign="middle" class="bodytext3"><strong><?php echo number_format($finalearnings,2,'.',','); ?></strong></td>
		<td align="right" valign="middle" class="bodytext3"><strong><?php echo number_format($finaldeductions,2,'.',','); ?></strong></td>
		</tr>
		</tbody>
		</table>
		<?php
		}
		?>
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

