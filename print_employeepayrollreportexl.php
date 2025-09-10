<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="print_employeepayrollreport.xls"');
header('Cache-Control: max-age=80');

?>
<style type="text/css">
<!--
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
-->
.bodytext31 {FONT-SIZE: 12px; vertical-align:text-bottom; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}



.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.border{border-top:1px #000000; border-bottom:1px #000000;}


body{margin:auto; width:100%}

#test {
   width: 16em; 
    word-wrap: break-word;
}
.page_footer
{
	font-family: Times;
	text-align:center;
	font-weight:bold;
	margin-bottom:25px;
	
}

</style>

<?php
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["companycode"])) { $companycode = $_REQUEST["companycode"]; } else { $companycode = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
		
	if($frmflag1 == 'frmflag1')
	{
		//$searchmonthyear = $searchmonth.'-'.$searchyear; 
		
		
	 ?>
	<table width="712" border="0" cellspacing="2" cellpadding="0" bordercolor="#666666" align="center" style="border-collapse: collapse">
	<tbody>
	<tr >
		<td colspan="14" align="center" class="bodytext31"><strong>&nbsp;</strong></td>
	</tr>
	<tr >
		<td colspan="14" align="center" class="bodytext34"><strong>Payroll Employee Report</strong></td>
		<!--<td colspan="2" align="center" class="bodytext31"><strong>&nbsp;</strong></td>-->
	</tr>
	<tr >
		<td colspan="14" align="center" class="bodytext31"><strong>&nbsp;</strong></td>
	</tr>
	<tr >
		<td colspan="14" align="left" class="bodytext31"><strong>EMPLOYER'S CODE : </strong><?php eval(base64_decode('IGVjaG8gJGNvbXBhbnljb2RlOyA=')); ?></td>
	</tr>
	<tr >
		<td colspan="14" align="left" class="bodytext31"><strong>EMPLOYER'S NAME : </strong><?php eval(base64_decode('IGVjaG8gJGNvbXBhbnluYW1lOyA=')); ?></td>
	</tr>
	<tr >
		<td colspan="14" align="left" class="bodytext31"><strong>EMPLOYEE'S NAME : </strong><?php eval(base64_decode('IGVjaG8gJHNlYXJjaGVtcGxveWVlOyA=')); ?></td>
	</tr>
	<tr >
	<td align="left" class="bodytext31 border" width="120" ><strong>ED Description </strong></td>
	<?php 
	$totalamount = '0.00';
	$arraymonth1 = ["0","0","0","0","0","0","0","0","0","0","0","0"];
	$arraymonth2 = ["0","0","0","0","0","0","0","0","0","0","0","0"];

	$arraymonth1 = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount1 = count($arraymonth1);
	for($i1=1;$i1<=$monthcount1;$i1++)
	{
		if($i1 < 10){
			$mno = '0'.$i1;
		}else{
			$mno = $i1;
		}
		
	?>
	<td align="center" class="bodytext31 border" width="66" ><strong>PER  <?= $mno; ?></strong></td>
	<?php 
	}
	 ?>
	<td align="left" class="bodytext31 border" width="66" ><strong>Y-T-D TOT </strong></td>
	</tr>
	<?php 
	$query2 = "select employeecode, employeename from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename ORDER BY employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res2 = mysqli_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res1 = mysqli_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number']; 
	$componentname = $res1['componentname'];
	$typecode = $res1['typecode'];
	
	?>
	<tr >
	<td align="left" class="bodytext31" width="120" > <?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?> </td>
	
	<?php
	
	$ytdtot = '0';
	
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
		$searchmonthyear = $arraymonth[$i].'-'.$searchyear;
		$totalgrossper = 0;
		$totaldeduct = 0;
	$query3 = "select `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	if($componentamount > 0) {
		$ytdtot = $ytdtot + $componentamount;
	}
	if($typecode == 10){
		$totalgrossper = $totalgrossper + $componentamount; 
			$arraymonth1[$i] = $arraymonth1[$i]+$componentamount;

	}else{ 
		$totaldeduct = $totaldeduct + $componentamount;
			$arraymonth2[$i] = $arraymonth2[$i]+$componentamount;

	}
	$res9grosspay = $totalgrossper;
	?>
	<td align="right" class="bodytext31" width="66" > <?php  if($componentamount > 0) { echo number_format($componentamount,2,'.',','); }  ?> </td>
	<?php
	}
	?>
		<td align="right" class="bodytext31" width="66" ><strong><?= number_format($ytdtot,2,'.',',');?> </strong></td>
	</tr>

	<?php
	}
	?>
	<tr>
		<td align="left"class="bodytext31" width="120" ><strong>GROSS PAY</strong></td>
		<?php
		for($j=0;$j<count($arraymonth1);$j++){
		?>
		<td align="right"class="bodytext31" width="66" ><?= number_format($arraymonth1[$j],2,'.',',');?></td>
		<?php
		}
		?>
		<td align="right"class="bodytext31"width="66"  ><strong><?= number_format(array_sum($arraymonth1),2,'.',',');?></strong></td>
	</tr>
	<tr>
		<td align="left"class="bodytext31" width="120" ><strong>DEDUCTION</strong></td>
		<?php
		for($k=0;$k<count($arraymonth2);$k++){
		?>
		<td align="right"class="bodytext31" width="66" ><?= number_format($arraymonth2[$k],2,'.',',');?></td>
		<?php
		}
		?>
		<td align="right"class="bodytext31" width="66" ><strong><?= number_format(array_sum($arraymonth2),2,'.',',');?></strong></td>
	</tr>
	<tr>
		<td align="left" class="bodytext31 border" width="120" ><strong>NET PAY</strong></td>
		<?php
		for($l=0;$l<count($arraymonth1);$l++){
			
			$netpay = $arraymonth1[$l] - $arraymonth2[$l];
		?>
		<td align="right"class="bodytext31 border" width="66" ><?= number_format($netpay,2,'.',',');?></td>
		<?php
		}
		$totnetpay = ((array_sum($arraymonth1)) - (array_sum($arraymonth2)));
		?>
		<td align="right"class="bodytext31 border" width="66" ><strong><?= number_format($totnetpay,2,'.',',');?></strong></td>
	</tr>
	<?php
	}
	 ?>
	</tbody>
	</table> 
	<?php 
	}
	?>