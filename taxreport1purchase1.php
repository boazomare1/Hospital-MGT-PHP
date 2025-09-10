<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$taxtype = '';
$colorloopcount = '';
$showfinaltaxamount = '0.00';
$showfinalnettamount = '0.00';
$finalsubtotal = '0.00';
$totaltaxsubamount = '';
$res2loopcount = '';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
//$transactiondatefrom = date('Y-m-d');//, strtotime('-1 day'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	if (isset($_REQUEST["cbsuppliername"])) { $cbsuppliername = $_REQUEST["cbsuppliername"]; } else { $cbsuppliername = ""; }
	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	if (isset($_REQUEST["suppliername"])) { $suppliername = $_REQUEST["suppliername"]; } else { $suppliername = ""; }
	//$suppliername = $_REQUEST['cbsuppliername'];
	
	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
	//$cbbillnumber = $_REQUEST['cbbillnumber'];
	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
	//$cbbillstatus = $_REQUEST['cbbillstatus'];
	
	if (isset($_REQUEST["transactiondatefrom"])) { $transactiondatefrom = $_REQUEST["transactiondatefrom"]; } else { $transactiondatefrom = ""; }
	//$transactiondatefrom = $_REQUEST['ADate1'];
	if (isset($_REQUEST["transactiondateto"])) { $transactiondateto = $_REQUEST["transactiondateto"]; } else { $transactiondateto = ""; }
	//$transactiondateto = $_REQUEST['ADate2'];
	
	if (isset($_REQUEST["taxtype"])) { $taxtype = $_REQUEST["taxtype"]; } else { $taxtype = ""; }
	//$taxtype = $_REQUEST['taxtype'];
	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }
	//$billstatus = $_REQUEST['billstatus'];

	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];

}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function loadprintpage1(banum)
{
	var varbanum = banum;
	//alert (varqanum);
	window.open("print_bill1.php?billautonumber="+varbanum+"","Window"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function funcRedirectWindow1()
{
	window.location = "taxreport1purchase1.php";
}


</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<script language="javascript">

function process1()
{
	if (document.getElementById("taxtype").value == "")
	{
		//alert ("Please Select Tax Type.");
		//document.getElementById("taxtype").focus();
		//return false;
	}
}

</script>

<body>
<table width="1176" border="0" cellspacing="0" cellpadding="2">
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
    <td colspan="9"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="99%" valign="top"><table width="1894" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1894">
		
              <form name="cbform1" method="get" action="taxreport1purchase1.php" onSubmit="return process1()">
		<table width="867" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Tax Report - By Purchase</strong></td>
              <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
            </tr>
            <tr>
              <td width="11%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><!--Tax Type--> </td>
              <td width="24%" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="taxtype" id="taxtype" value="">
<!--			  
			  <select name="taxtype" id="taxtype">
                  <option value="">Select Tax Name</option>
                  <?php
					$query1billtype = "select * from master_tax where status <> 'deleted'";
					$exec1billtype = mysqli_query($GLOBALS["___mysqli_ston"], $query1billtype) or die ("Error in Query1billtype".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1billtype = mysqli_fetch_array($exec1billtype))
					{
					$taxname = $res1billtype['taxname'];
					$taxanum = $res1billtype['auto_number'];
					?>
                  <option value="<?php echo $taxname; ?>"><?php echo $taxname; ?></option>
                  <?php
					}
					?>
                </select>              
-->				</td>
                <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date From </td>
                <td width="15%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
				</span></td>
                <td width="7%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                <td width="15%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                  <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
				</span></td>
                <td width="20%" colspan="2" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="hidden" name="cbfrmflag12" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input onClick="return funcRedirectWindow1()" name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
                <input type="hidden" name="cbfrmflag1" id="cbfrmflag1" value="cbfrmflag1">
            </tr>
          </tbody>
        </table>
          </form>		</td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="12%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <?php
			  $query1tax = "select * from master_tax where status <> 'deleted'";// where auto_number like '%$taxtype%'";
			  $exec1tax = mysqli_query($GLOBALS["___mysqli_ston"], $query1tax) or die ("Error in Query1tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res1tax = mysqli_fetch_array($exec1tax))
			  {
			  $res1taxauto_number = $res1tax['auto_number'];
			  $res1taxtaxpercent = $res1tax['taxpercent'];
			  if ($res1taxauto_number != '')
			  {
			  ?>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <?php
			  $query2tax = "select * from master_taxsub where taxparentanum = '$res1taxauto_number'";//taxparentanum = '$taxtype'";
			  $exec2tax = mysqli_query($GLOBALS["___mysqli_ston"], $query2tax) or die ("Error in Query2tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2tax = mysqli_fetch_array($exec2tax))
			  {
				  $res2taxauto_number = $res2tax['auto_number'];
				  $taxsubpercent = $res2tax['taxsubpercent'];
				  if ($res2taxauto_number != '')
				  {
					echo '<td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>';
				  }
			  }
			  }
			  }
			  ?>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Tax</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No. </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Supplier </strong></td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>SubTotal</strong></div></td>
			  <?php
			  $query1tax = "select * from master_tax where status <> 'deleted'";// where auto_number like '%$taxtype%'";
			  $exec1tax = mysqli_query($GLOBALS["___mysqli_ston"], $query1tax) or die ("Error in Query1tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res1tax = mysqli_fetch_array($exec1tax))
			  {
			  $res1taxauto_number = $res1tax['auto_number'];
			  $res1taxtaxpercent = $res1tax['taxpercent'];
			  if ($res1taxauto_number != '')
			  {
			  ?>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Tax <?php echo round($res1taxtaxpercent, 2).' %'; ?>&nbsp;</strong></div></td>
              <?php
			  $query2tax = "select * from master_taxsub where taxparentanum = '$res1taxauto_number'";//taxparentanum = '$taxtype'";
			  $exec2tax = mysqli_query($GLOBALS["___mysqli_ston"], $query2tax) or die ("Error in Query2tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2tax = mysqli_fetch_array($exec2tax))
			  {
				  $res2taxauto_number = $res2tax['auto_number'];
				  $taxsubpercent = $res2tax['taxsubpercent'];
				  if ($res2taxauto_number != '')
				  {
					echo '<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">
					<div align="right"><strong>SubTax '.round($taxsubpercent, 2).' %'.'</strong></div></td>';
				  }
			  }
			  }
			  }
			  ?>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>TaxTotal</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Nett</strong></div></td>
              </tr>
<?php
if ($cbfrmflag1 == 'cbfrmflag1')
{

$dotarray = explode("-", $transactiondateto);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear));

$query4 = "select * from master_tax where status <> 'deleted'";// where auto_number = '$taxtype'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res4 = mysqli_fetch_array($exec4)) //while1
{
	$res4taxpercent = $res4['taxpercent'];
	$res4taxanum = $res4['auto_number'];
	
	//$query2 = "select sum(itemtaxamount) as sumitemtaxamount, sum(subtotal) as sumsubtotal, 
	//bill_autonumber, itemtaxpercentage from purchase_details 
	//where itemtaxpercentage = '$res4taxpercent' and companyanum = '$companyanum' 
	//group by billnumber, itemtaxpercentage order by billnumber desc";
	$query2 = "select sum(taxamount) as sumitemtaxamount, 
	bill_autonumber from purchase_tax 
	where tax_autonumber = '$res4taxanum' and taxtype = 'main' and companyanum = '$companyanum' 
	and billdate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' 
	group by billnumber order by billnumber desc";
	
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
		$billautonumber = $res2['bill_autonumber'];
		$totaltaxamount = $res2['sumitemtaxamount'];
		
		$query3 = "select * from master_purchase where auto_number = '$billautonumber' and 
		billdate between '$transactiondatefrom' and '$transactiondateto'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 > 0) //if1
		{
			$billdate = $res3['billdate'];
			$billnumber = $res3['billnumber'];
			$suppliername = $res3['suppliername'];
			
			//$sumsubtotal = $res3['subtotal'];
			$sumsubtotal = $res3['subtotalafterdiscount'];
			$finalsubtotal = $finalsubtotal + $sumsubtotal;
			$finalsubtotal = number_format($finalsubtotal, 2, '.', '');
			$nettamount = $totaltaxamount + $sumsubtotal;	
			$nettamount = number_format($nettamount, 2, '.', '');
			
			$res2loopcount = $res2loopcount+1;
			
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
			<td class="bodytext31" valign="center"  align="left">
			<?php echo $res2loopcount; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo number_format($res4taxpercent, 2, '.', '');; ?></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $billnumber; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left">
			<?php 
			/*
			//echo $billdate; 
			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$dbdateday = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
			$billdate2 = $dbdateday;
			echo $billdate2;
			*/
			$billtime = substr($billdate, 11, 8);
			$billdateonly = substr($billdate, 0, 10);
			$dotarray = explode("-", $billdateonly);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$dbdateday = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
			$billdate2 = $dbdateday;
			echo $billdate2;
			
			
			?>
			</div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">
			<?php echo $suppliername; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="right"> <?php echo $sumsubtotal; ?>&nbsp;</div></td>
			<?php
			//echo '<br>'.$query1tax = "select * from master_tax where auto_number like '%$taxtype%'";
			$query1tax = "select * from master_tax where status <> 'deleted'";// where auto_number = '$taxtype'";
			$exec1tax = mysqli_query($GLOBALS["___mysqli_ston"], $query1tax) or die ("Error in Query1tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1tax = mysqli_fetch_array($exec1tax))
			{
				$res1taxauto_number = $res1tax['auto_number'];
				$res1taxtaxpercent = $res1tax['taxpercent'];
				//if ($res1taxauto_number != '')
				if ($res1taxauto_number == $res4taxanum)
				{
					?>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo $totaltaxamount; ?></div></td>
					<?php
					$query2tax = "select * from master_taxsub where taxparentanum = '$res1taxauto_number'";
					$exec2tax = mysqli_query($GLOBALS["___mysqli_ston"], $query2tax) or die ("Error in Query2tax".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res2tax = mysqli_fetch_array($exec2tax))
					{
						$res2taxauto_number = $res2tax['auto_number'];
						$taxsubpercent = $res2tax['taxsubpercent'];
						
						$taxsubamount = $totaltaxamount * $taxsubpercent;
						$taxsubamount = $taxsubamount / 100;
						$taxsubamount = number_format($taxsubamount, 2, '.', '');
						
						if ($res2taxauto_number != '')
						{
							echo '<td class="bodytext31" valign="center"  align="left">
							<div align="right">'.$taxsubamount.'&nbsp;</div></td>';
							$totaltaxsubamount = $totaltaxsubamount + $taxsubamount;
						}
					}
				}
				else
				{
					?>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo '0.00'; ?></div></td>
					<?php
					$query2tax = "select * from master_taxsub where taxparentanum = '$res1taxauto_number'";
					$exec2tax = mysqli_query($GLOBALS["___mysqli_ston"], $query2tax) or die ("Error in Query2tax".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res2tax = mysqli_fetch_array($exec2tax))
					{
						$res2taxauto_number = $res2tax['auto_number'];
						$taxsubpercent = $res2tax['taxsubpercent'];
						
						$taxsubamount = $totaltaxamount * $taxsubpercent;
						$taxsubamount = $taxsubamount / 100;
						$taxsubamount = number_format($taxsubamount, 2, '.', '');
						
						if ($res2taxauto_number != '')
						{
							echo '<td class="bodytext31" valign="center"  align="left">
							<div align="right">0.00&nbsp;</div></td>';
							//$totaltaxsubamount = $totaltaxsubamount + $taxsubamount;
						}
					}
				}
				$showtotaltaxamount = $totaltaxamount + $totaltaxsubamount;
				$showtotaltaxamount = number_format($showtotaltaxamount, 2, '.', '');
				
				$shownettamount = $nettamount + $totaltaxsubamount;
				$shownettamount = number_format($shownettamount, 2, '.', '');
			}
			?>
			<td class="bodytext31" valign="center"  align="left"><div align="right"> 
			<?php echo $showtotaltaxamount; ?>&nbsp;</div></td>
			<td class="bodytext31" valign="center"  align="left">
			<div align="right">
			<?php echo $shownettamount; ?>&nbsp;</div></td>
			<?php
			$nettamount = '';
			$totaltaxamount = '';
			$totaltaxsubamount = '';
			$showfinaltaxamount = $showfinaltaxamount + $showtotaltaxamount;
			$showfinalnettamount = $showfinalnettamount + $shownettamount;
			}
		} //if1
		
	} //while1
			
	$showfinaltaxamount = number_format($showfinaltaxamount, 2, '.', '');
	$showfinalnettamount = number_format($showfinalnettamount, 2, '.', '');
		
?>
</tr>
<?php
} //cbfrmflag

?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>Total : </strong></div></td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> <?php echo $finalsubtotal; ?>&nbsp;</strong></div></td>
			  <?php
			  $query1tax = "select * from master_tax where status <> 'deleted'";// where auto_number like '%$taxtype%'";
			  $exec1tax = mysqli_query($GLOBALS["___mysqli_ston"], $query1tax) or die ("Error in Query1tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res1tax = mysqli_fetch_array($exec1tax))
			  {
			  $res1taxauto_number = $res1tax['auto_number'];
			  $res1taxtaxpercent = $res1tax['taxpercent'];
			  if ($res1taxauto_number != '')
			  {
			  ?>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
			  <?php
			  $query2tax = "select * from master_taxsub where taxparentanum = '$res1taxauto_number'";//taxparentanum = '$taxtype'";
			  $exec2tax = mysqli_query($GLOBALS["___mysqli_ston"], $query2tax) or die ("Error in Query2tax".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2tax = mysqli_fetch_array($exec2tax))
			  {
				  $res2taxauto_number = $res2tax['auto_number'];
				  $taxsubpercent = $res2tax['taxsubpercent'];
				  if ($res2taxauto_number != '')
				  {
					echo '<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">
					<div align="right"><strong>&nbsp;</strong></div></td>';
				  }
			  }
			  }
			  }
			  ?>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> <?php echo $showfinaltaxamount; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong> <?php echo $showfinalnettamount; ?>&nbsp;</strong></div></td>
              </tr>
          </tbody>
        </table>		</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

