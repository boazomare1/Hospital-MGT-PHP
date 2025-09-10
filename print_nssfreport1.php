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
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];
$employername = $res81['employername'];
$nssfnumber = $res81['nssfnumber'];

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
	<table width="500" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="left" class="bodytext3"><strong>NSSF REPORT</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td colspan="10" align="left" class="bodytext3"><strong>EMPLOYER'S NSSF NUMBER : <?php echo $nssfnumber; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $employername; ?></strong></td>
	</tr>	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchyear.'-'.date('m',strtotime($searchmonth)); ?></strong></td>
	</tr>
	<tr>
	<td width="62" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>PAYROLL NUMBER</strong></td>
	<td width="90" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>SURNAME</strong></td>
	<td width="150" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>OTHER NAMES</strong></td>
	<td width="75" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>ID NO</strong></td>
	<td width="75" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>KRA PIN</strong></td>
	<td width="75" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>NSSF NO</strong></td>
	<td width="75" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>GROSS PAY</strong></td>
	<td width="75" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong>VOLUNTARY</strong></td>
	</tr>
	<?php 
	$totalnssf = '0.00';
	$totalamount = '0.00';
	$totalstdamount = '0.00';
	$totalvolamount = '0.00';
	$totalgrossamount = '0.00';
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];

	$name = trim(preg_replace('/[^A-Za-z0-9 ]/', '', $res2employeename));

    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );

	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row778 = mysqli_num_rows($query778);
	if($row778 > 0)
	{
	
	$query6 = "select pinno,passportnumber,nssf,payrollno from master_employeeinfo where employeecode = '$res2employeecode' ORDER BY employeecode";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$nssf = $res6['nssf'];
	$pinno = $res6['pinno'];
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
	<tr >
	<td align="left" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $payrollno); ?></td>
	<td align="left" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $last_name); ?></td>
	<td align="left" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $first_name); ?></td>
	<td align="left" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $passportnumber); ?></td>
	<td align="left" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $pinno); ?></td>
	<td align="left" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $nssf); ?></td>
	<?php 
	$totalgrossper = 0;
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '3' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	$query12 = "select auto_number as ganum from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res12 = mysqli_fetch_array($exec12))
	{
		$ganum = $res12['ganum'];
		
		$querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resgg = mysqli_fetch_array($execgg);
		$res12value = $resgg['res12value'];
		$totalgrossper = $totalgrossper + $res12value;
	}
	$grosspay = $totalgrossper;
	
	$stdamount = 1 * $componentamount;
	$volamount = 1 * $componentamount;
	$totamount = $stdamount + $volamount;
	
	$totalgrossamount = $totalgrossamount + $grosspay;
	$totalvolamount = $totalvolamount + $volamount;
	
	$totalnssf = $totalnssf + $totamount;
	 ?>
	<td align="right" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $grosspay); ?></td>
	<td align="right" class="bodytext3"><?php echo preg_replace('/[^A-Za-z0-9 ]/', '', $volamount); ?></td></tr>
	<?php }
	}
	}
	 ?>
	
	<tr>
	<td colspan="6" bgcolor="#ecf0f5" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalgrossamount,3,'.',','); ?></strong></td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalvolamount,3,'.',','); ?></strong></td>
	</tr>
	</tbody>
	</table>
	<?php
	}
	?>
	<?php

require_once('html2pdf/html2pdf.class.php');

    $content = ob_get_clean();

    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('helbreport.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>
