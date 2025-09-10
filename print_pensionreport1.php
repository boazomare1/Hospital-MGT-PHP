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
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

ob_start();

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = date('Y'); }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];


?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }
#footer .page:after { content: counter(page, upper-roman); }

.page { page-break-after:always; }
</style>
<?php include("a4pdfpayrollheader1.php"); ?>	

	<?php
	if($frmflag1 == 'frmflag1')
	{
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>	
	<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="left" class="bodytext3"><strong>PENSION REPORT</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchyear.'-'.date('m',strtotime($searchmonth)); ?></strong></td>
	</tr>
	<tr>
	<td width="1" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="4" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>PAYROLL NO</strong></td>
	<td width="16" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE'S NAME</strong></td>
	<td width="5" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>NSSF NO</strong></td>
	<td width="5" align="right" bgcolor="#FFFFFF" class="bodytext3"><strong>Total Gross</strong></td>
	<td width="2" align="right" bgcolor="#FFFFFF" class="bodytext3"><strong>Employee Amount</strong></td>
	<td width="2" align="right" bgcolor="#FFFFFF" class="bodytext3"><strong>Employer Amount</strong></td>
	<td width="10" align="right" bgcolor="#FFFFFF" class="bodytext3"><strong>Total Standard Amount</strong></td>
	<td width="1" align="left" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
	<td width="5" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>ID NO</strong></td>
	<td width="1" align="left" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
	</tr>
	<?php 
	$totalnssf = '0.00';
	$totalamount = '0.00';
	$totalstdamount = '0.00';
	$totalvolamount = '0.00';
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query778 = mysql_query("select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysql_error());
	$row778 = mysql_num_rows($query778);
	if($row778 > 0)
	{
	
	$query6 = "select passportnumber,nssf,payrollno from master_employeeinfo where employeecode = '$res2employeecode' ORDER BY employeecode";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$nssf = $res6['nssf'];
	$payrollno = $res6['payrollno'];
	
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
	<tr>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $nssf; ?></td>
	<?php 
	$totalgrossper = 0;
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '25' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
	$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
	while($res12 = mysql_fetch_array($exec12))
	{
		$ganum = $res12['ganum'];
		
		$querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$execgg = mysql_query($querygg) or die ("Error in Querygg".mysql_error());
		$resgg = mysql_fetch_array($execgg);
		$res12value = $resgg['res12value'];
		$totalgrossper = $totalgrossper + $res12value;
	}
	$grosspay = $totalgrossper;
	
	$stdamount = 1 * $componentamount;
	$volamount = 3 * $componentamount;
	$totamount = $stdamount + $volamount;
	
	$totalstdamount = $totalstdamount + $stdamount;
	$totalvolamount = $totalvolamount + $volamount;
	
	$totalnssf = $totalnssf + $totamount;
	?>
	<td align="right" class="bodytext3"><?php echo number_format($grosspay,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($stdamount,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($volamount,3,'.',','); ?></td>
	<td align="right" class="bodytext3"><?php echo number_format($totamount,3,'.',','); ?></td>
	<td align="right" class="bodytext3">&nbsp;</td>
	<td align="left" class="bodytext3"><?php echo $passportnumber; ?></td>
	<td align="right" class="bodytext3">&nbsp;</td>	
	<?php
	}
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="5" bgcolor="#FFFFFF" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#FFFFFF" align="right" class="bodytext3"><strong><?php echo number_format($totalstdamount,3,'.',','); ?></strong></td>
	<td bgcolor="#FFFFFF" align="right" class="bodytext3"><strong><?php echo number_format($totalvolamount,3,'.',','); ?></strong></td>
	<td bgcolor="#FFFFFF" align="right" class="bodytext3"><strong><?php echo number_format($totalnssf,3,'.',','); ?></strong></td>
	<td colspan="3" align="left" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
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
$dompdf->stream("PensionReport.pdf", array("Attachment" => 0)); 
?>