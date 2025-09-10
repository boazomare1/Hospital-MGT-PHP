<?php
session_start();
//error_reporting(0);
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

ob_start();

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = date('Y'); }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.num {
  mso-number-format:General;
}
.text{
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;
  mso-number-format:"\@";/*force text*/
}
-->
</style>

	<?php
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
	     $searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>
	<table width="530" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>BANK Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>MONTH OF PAY : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="7" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr>
	<td width="10" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="100" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="95" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>ACCOUNT NO</strong></td>
	<td width="101" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>BANK NAME</strong></td>
	<td width="80" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>BRANCH NAME</strong></td>
	<td align="right" bgcolor="#FFFFFF" class="bodytext3" width="20"><strong>AMOUNT</strong></td>
	<td align="left" bgcolor="#FFFFFF" class="bodytext3" width="20"><strong>BANK CODE</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query9 = "select * from master_employeeinfo where bankname like '%$searchbank%' and bankname <> '' group by bankname order by bankname";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	while($res9 = mysql_fetch_array($exec9))
	{
	$res9bankname = $res9['bankname'];
	?>
	<?php
	$query2 = "select * from payroll_assign where employeename like '%$searchemployee%' and status <> 'deleted' group by employeename";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' and bankname = '$res9bankname'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$bankbranch = $res6['bankbranch'];
	$bankname = $res6['bankname'];
	$bankcode = $res6['bankcode'];
	$accountnumber = $res6['accountnumber'];
	
	if($accountnumber != '')
	{ 

	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	} 
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="text" ><?php echo $accountnumber; ?></td>
	<td align="left" class="bodytext3"><?php echo $bankname; ?></td>
	<td align="left" class="bodytext3"><?php echo $bankbranch; ?></td>
	<?php
	$totalbenefit = '';
	$query3 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentname = 'NETTPAY' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];
	$componentanum = $res3['componentanum'];
	$componentname = $res3['componentname'];
	$componentamount = $res3['componentamount'];
	
	$query912 = "select * from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec912 = mysql_query($query912) or die ("Error in Query912".mysql_error());
	while($res912 = mysql_fetch_array($exec912))
	{
	$benefitanum = $res912['auto_number'];
	$query911 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '$benefitanum' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec911 = mysql_query($query911) or die ("Error in Query911".mysql_error());
	$res911 = mysql_fetch_array($exec911);
	$res911benefits = $res911['componentamount'];
	$totalbenefit = $totalbenefit + $res911benefits;
	}
	
	$nettpay = $componentamount - $totalbenefit;
	$totalamount = $totalamount + $nettpay;
	?>
	<td align="right" class="bodytext3" width="70"><?php echo number_format($nettpay,0,'.',''); ?></td>
	<td align="left" class="text" width="60"><?php echo $bankcode; ?></td>	
	<?php
	}
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="5" bgcolor="#FFFFFF" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#FFFFFF" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
	<td align="left" bgcolor="#FFFFFF" class="bodytext3" width="14">&nbsp;</td>
	</tr>
	</tbody>
	</table> 
	<?php
	}
	?>	
	
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Bankreport.pdf", array("Attachment" => 0)); 
?>	