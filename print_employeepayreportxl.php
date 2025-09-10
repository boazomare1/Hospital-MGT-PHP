<?php

session_start();
error_reporting(0);
include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$currentdate = date("Y-m-d");

$colorloopcount = '';

$totalbenefit = "0.00";

$nettotalbenefit = "0.00";



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Employeepayreport.xls"');

header('Cache-Control: max-age=80');



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }

if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }





?>

<style>

body {

    font-family: 'Arial'; font-size:11px;	 

}

#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }

#footer .page:after { content: counter(page, upper-roman); }



.page { page-break-after:always; }

</style>

<?php //include("a4pdfheader1.php"); ?>	





	<?php

	if($frmflag1 == 'frmflag1')

	{

		

	?>

	<table width="510" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody>

	<tr bgcolor="#FFFFFF">

	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Employee Report - <?php echo $searchyear; ?></strong></td>

	</tr>

	<tr bgcolor="#FFFFFF">

	<td colspan="30" align="left" class="bodytext3"><strong>Name : <?php echo $searchemployee; ?></strong></td>

	</tr>

	<tr>

	<td width="50" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>

	<td width="80" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>MONTH</strong></td>

	<?php

	$totalamount = '0.00';

	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res1 = mysqli_fetch_array($exec1))

	{

	$componentanum = $res1['auto_number'];

	$componentname = $res1['componentname'];

	?>

	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="120"><strong><?php echo $componentname; ?></strong></td>

	<?php

	}

	?>

	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>GROSS PAY</strong></td>

	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>DEDUCTIONS</strong></td>

	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>NOTIONAL BENEFIT</strong></td>	

	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>NETT PAY</strong></td>

	</tr>

	<?php

	$totalamount = '0.00';

	

	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

	$monthcount = count($arraymonth);

	for($i=0;$i<$monthcount;$i++)

	{

		$searchmonthyear = $arraymonth[$i].'-'.$searchyear;

	

	$query2 = "select * from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res2 = mysqli_fetch_array($exec2))

	{

	$res2employeecode = $res2['employeecode'];

	$res2employeename = $res2['employeename'];

	

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

	<td align="left" class="bodytext3"><?php echo date('F',strtotime($arraymonth[$i])); ?></td>	

	<?php

	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res1 = mysqli_fetch_array($exec1))

	{

	$componentanum = $res1['auto_number'];



	$query3 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '$componentanum' and paymonth = '$searchmonthyear' and status <> 'deleted'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res3 = mysqli_fetch_array($exec3);

	

	$employeecode = $res3['employeecode'];

	$employeename = $res3['employeename'];

	$componentanum = $res3['componentanum'];

	$componentname = $res3['componentname'];

	$componentamount = $res3['componentamount'];



	?>

	<td align="right" class="bodytext3" width="10"><?php if($componentamount > 0) { echo number_format($componentamount,2,'.',','); } ?></td>	

	<?php

	}

	$query9 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '0' and componentname = 'GROSSPAY' and paymonth = '$searchmonthyear' and status <> 'deleted'";

	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res9 = mysqli_fetch_array($exec9);

	$res9grosspay = $res9['componentamount'];

	?>

	<td align="right" class="bodytext3"><?php if($res9grosspay > 0) { echo number_format($res9grosspay,2,'.',','); } ?></td>	

	<?php

	$query91 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '0' and componentname = 'TOTALDEDUCTIONS' and paymonth = '$searchmonthyear' and status <> 'deleted'";

	$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res91 = mysqli_fetch_array($exec91);

	$res91deduction = $res91['componentamount'];

	?>

	<td align="right" class="bodytext3"><?php if($res91deduction > 0) { echo number_format($res91deduction,2,'.',','); } ?></td>	

	<?php

	$totalbenefit = '';

	$query912 = "select * from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";

	$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die ("Error in Query912".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res912 = mysqli_fetch_array($exec912))

	{

	$benefitanum = $res912['auto_number'];

	$query911 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '$benefitanum' and paymonth = '$searchmonthyear' and status <> 'deleted'";

	$exec911 = mysqli_query($GLOBALS["___mysqli_ston"], $query911) or die ("Error in Query911".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res911 = mysqli_fetch_array($exec911);

	$res911benefits = $res911['componentamount'];

	$totalbenefit = $totalbenefit + $res911benefits;

	}

	?>

	<td align="right" class="bodytext3"><?php if($totalbenefit > 0) { echo number_format($totalbenefit,0,'.',','); } ?></td>	

	<?php

	$query92 = "select * from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '0' and componentname = 'NETTPAY' and paymonth = '$searchmonthyear' and status <> 'deleted'";

	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res92 = mysqli_fetch_array($exec92);

	$res92nettpay = $res92['componentamount'];

	?>

	<td align="right" class="bodytext3"><?php if($res92nettpay > 0) { echo number_format($res92nettpay-$totalbenefit,2,'.',','); } ?></td>	

	<?php

	}

	}

	?>

	</tr>

	<tr bgcolor="#FFFFFF">

	<td colspan="2" align="right" class="bodytext3"><strong>Total :</strong></td>

	<?php

	$totalamount = '0.00';

	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res1 = mysqli_fetch_array($exec1))

	{

	$componentanum = $res1['auto_number'];

	$totalamount = '0.00';

	

		$query3 = "select * from details_employeepayroll where employeename like '%$searchemployee%' and componentanum = '$componentanum' and status <> 'deleted'";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res3 = mysqli_fetch_array($exec3))

		{

		$totalcomponentamount = $res3['componentamount'];

		$totalamount = $totalamount + $totalcomponentamount;

		}

	?>

	<td align="right" class="bodytext3" width="26"><strong><?php if($totalamount > 0) { echo number_format($totalamount,2,'.',','); } ?></strong></td>	

	<?php

	}

	?>

	<?php

	$query60 = "select sum(componentamount) as totalgross from details_employeepayroll where employeename like '%$searchemployee%' and componentname = 'GROSSPAY' and status <> 'deleted'";

	$exec60 = mysqli_query($GLOBALS["___mysqli_ston"], $query60) or die ("Error in Query60".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res60 = mysqli_fetch_array($exec60);

	$res60grosspay = $res60['totalgross'];

	?>

	<td align="right" class="bodytext3" width="26"><strong><?php if($res60grosspay > 0) { echo number_format($res60grosspay,2,'.',','); } ?></strong></td>	

	<?php

	$query61 = "select sum(componentamount) as totaldeduct from details_employeepayroll where employeename like '%$searchemployee%' and componentname = 'TOTALDEDUCTIONS' and status <> 'deleted'";

	$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res61 = mysqli_fetch_array($exec61);

	$res61totaldeduct = $res61['totaldeduct'];

	?>

	<td align="right" class="bodytext3" width="26"><strong><?php if($res61totaldeduct > 0) { echo number_format($res61totaldeduct,2,'.',','); } ?></strong></td>	

	<?php

	$query912 = "select * from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";

	$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die ("Error in Query912".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res912 = mysqli_fetch_array($exec912))

	{

	$benefitanum = $res912['auto_number'];

	$query611 = "select sum(componentamount) as totalbenefits from details_employeepayroll where employeecode = '$res2employeecode' and componentanum = '$benefitanum' and status <> 'deleted'";

	$exec611 = mysqli_query($GLOBALS["___mysqli_ston"], $query611) or die ("Error in Query611".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res611 = mysqli_fetch_array($exec611);

	$res611benefits = $res611['totalbenefits'];

	$nettotalbenefit = $nettotalbenefit + $res611benefits;

	}

	?>

	<td align="right" class="bodytext3"><strong><?php if($nettotalbenefit > 0) { echo number_format($nettotalbenefit,0,'.',','); } ?></strong></td>	

	<?php

	$query62 = "select sum(componentamount) as totalnett from details_employeepayroll where employeename like '%$searchemployee%' and componentname = 'NETTPAY' and status <> 'deleted'";

	$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die ("Error in Query62".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res62 = mysqli_fetch_array($exec62);

	$res62totalnett = $res62['totalnett'];

	?>

	<td align="right" class="bodytext3" width="26"><strong><?php if($res62totalnett > 0) { echo number_format($res62totalnett-$nettotalbenefit,2,'.',','); } ?></strong></td>	

	</tr>

	</tbody>

	</table> 

	<?php

	}

	?>

