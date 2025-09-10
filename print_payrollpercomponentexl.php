<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$colorloopcount = "";

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
$res81 = mysqli_fetch_array($exec81);
$companycode = $res81['pinnumber'];
$companyname = $res81['employername'];

		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
		


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="print_payrollpercomponentexl.xls"');
header('Cache-Control: max-age=80');

		
?>
<style><!--
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 10px;padding: 2px;}
table{table-layout:fixed;
width:95%;
display:table;
border-collapse:collapse;} -->

</style>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height:150px; }
#footer .page:after { content: counter(page, upper-roman); }
td{{height: 30px;padding: 2px;}
.page { page-break-after:always; }
</style>

	<?php
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchcomponent"])) { $searchcomponent1 = $_REQUEST["searchcomponent"]; } else { $searchcomponent1 = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		$searchmonthyear = $searchmonth.'-'.$searchyear;
		$previous = $searchyear.'-'.$searchmonth.'-01';
		$previous1 = date("d M Y",strtotime($previous));
		
		$prevmonth = date("M-Y",mktime(0,0,0,date("m", strtotime($previous1))-1,1,date("Y", strtotime($previous1))));
		//echo $prevmonth;
		
	?>	
	
	<table width="600" border="0" align="left" cellpadding="4" cellspacing="2" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<thead>
	<tr >
	<td colspan="6" align="center" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	
	<tr >
	<td colspan="6" align="center" class="bodytext3"><strong> <?php echo $companyname; ?> </strong></td>
	</tr>
	<tr >
	<td colspan="6" align="center" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr >
	<td colspan="6" align="center" class="bodytext3"><strong> PAYROLL SYSTEM </strong></td>
	</tr>
	
	<tr >
	<td colspan="6" align="center" class="bodytext3"><strong>ED Changes Per Component </strong></td>
	</tr>
	<tr >
		<td colspan="3" align="left" class="bodytext3"><strong>PER : <?php echo $searchmonthyear; ?> </strong> </td>
		<td colspan="3" align="right" class="bodytext3"><strong>REPORT DATE : <?php echo date('d/m/Y'); ?> </strong></td>
		
	</tr>
	<?php
	
		if($searchcomponent1 !=''){
			$query134 = "select auto_number,componentname from master_payrollcomponent where auto_number= '$searchcomponent1' AND recordstatus <> 'deleted'";
		}else{
			$query134 = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' order by auto_number ASC";
		}
		$exec134 = mysqli_query($GLOBALS["___mysqli_ston"], $query134) or die ("Error in Query134".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res134 = mysqli_fetch_array($exec134)){
		
			$componentname4 = $res134['componentname'];
			$searchcomponent = $res134['auto_number'];
			$srno = 0;
	?>
	<tr >
	<td colspan="6" align="center" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	
	<tr>
	<td align="left" class="bodytext3" colspan="3" ><strong> ED : <?php echo $searchcomponent." &nbsp;".$componentname4; ?></strong></td>
	<td width="130" align="right" class="bodytext3"><strong>PREVIOUS PERIOD</strong></td>
	<td width="120" align="right" class="bodytext3"><strong>CURRENT PERIOD</strong></td>
	<td width="100" align="right" class="bodytext3">&nbsp;</td>
	</tr>

	<tr>
	<td width="20" align="left" class="bodytext3"><strong>DPT</strong></td>
	<td width="50" align="left" class="bodytext3"><strong>EMP NO</strong></td>
	<td width="217" align="left" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="130" align="right" class="bodytext3"><strong>EARNINGS DEDUCTIONS</strong></td>
	<td width="120" align="right" class="bodytext3"><strong>EARNINGS DEDUCTIONS</strong></td>
	<td width="100" align="right" class="bodytext3"><strong>CUM BALANCE</strong></td>
	</tr>
	
	</thead>
	<tbody>

	<?php
	$totalamount = '0.00';
	$dep = '';
	
	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and a.status <> 'deleted' group by a.employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeecode from master_employee where employeecode = '$res2employeecode' and (payrollstatus = 'Active' or payrollstatus = 'Prorata')") or die ("Error in Query778".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row778 = mysqli_num_rows($query778);
	if($row778 > 0)
	{
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$pinno = $res6['pinno']; 
	$payrollno = $res6['payrollno'];
	$payrollno = $res6['payrollno'];
	
	$departmentunit = $res6['departmentunit'];
	$departmentname = $res6['departmentname'];
	
	$query5 = "select auto_number from master_payrolldepartment where department = '$departmentname' AND recordstatus <> 'deleted' ";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res5 = mysqli_fetch_array($exec5);
	 $dep = $res5['auto_number'];
	
	
	
	$query312 = "select `$searchcomponent` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$prevmonth' and status <> 'deleted'";
	$exec312 = mysqli_query($GLOBALS["___mysqli_ston"], $query312) or die ("Error in Query312".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res312 = mysqli_fetch_array($exec312);
	$previousamount = $res312['componentamount'];
	
	$query3 = "select `$searchcomponent` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	if($componentamount != $previousamount){
		
	$totalamount = $totalamount + $componentamount;
	if(true)
	{
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
	$srno = $srno+1;
	?>
	<tr >
	<td align="left" class="bodytext3"><?php echo $dep; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td width="77" align="right" class="bodytext3" ><?php echo number_format($previousamount,0,'.',','); ?></td>
	<td width="77" align="right" class="bodytext3" ><?php echo number_format($componentamount,0,'.',','); ?></td>
	<td width="47" align="right" class="bodytext3" >&nbsp;</td>
	</tr>	
	<?php
	}
	}
	}
	}
	if($srno == '0')
	{
	?>
	<tr>
	<td colspan="6" align="center" valign="middle" class="bodytext3" style="color:red;"><strong> ..................... No Records Found ..................... </strong></td>
	</tr>
	<?php
	}
	?>
	<tr>
	<td colspan="4" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td align="right" class="bodytext3"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
	<td align="left" class="bodytext3" width="47">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="6" align="right" class="bodytext3">&nbsp;</td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table> 
	<?php
	}
	?>