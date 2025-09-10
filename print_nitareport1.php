<?php
ob_start();

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
$helbnumber = $res81['helbnumber'];
$employername = $res81['employername'];

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
	<table width="100%" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="left" class="bodytext3"><strong>MONTHLY PAYROLL RETURN TO NITA</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="left" class="bodytext3"><strong>EMPLOYER'S HELB CODE : <?php echo $helbnumber; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $employername; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchyear.'-'.date('m',strtotime($searchmonth)); ?></strong></td>
	</tr>
<tr>
	<td width="84" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>ID NO</strong></td>
	<td width="100" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>NAME</strong></td>
	<td width="80" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>PIN NO</strong></td>
	<td align="right" bgcolor="#ecf0f5" class="bodytext3" width="73"><strong>AMOUNT</strong></td>
	</tr>
	<?php 
	$totalamount = '0.00';
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
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$pinno = $res6['pinno'];
	
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
	<td align="left" class="bodytext3"><?php echo $passportnumber; ?></td>
	<td align="left" class="bodytext3"><?php echo $first_name.' '.$last_name; ?></td>
	<td align="left" class="bodytext3"><?php echo $pinno; ?></td>
	<td align="left" class="bodytext3">50</td>
	</tr>
	<?php $totalamount += 50;
	}
	} 
	 ?>
	
	<tr>
	<td colspan="3" bgcolor="#ecf0f5" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,3,'.',','); ?></strong></td>
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

        $html2pdf->Output('HELBReport.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>