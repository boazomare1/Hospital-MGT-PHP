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

$companycode = $res81['pinnumber'];

$companyname = $res81['employername'];



if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }

if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }

if (isset($_REQUEST["searchdept"])) { $searchdept = $_REQUEST["searchdept"]; } else { $searchdept = ""; }

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }

if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }



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

<!--<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script> -->

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



window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());

  	

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

    <td  valign="top">

	<form name="form1" id="form1" method="post" action="payrolldeptreport1.php" onSubmit="return from1submit1()">

	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody>

	<tr bgcolor="#999999">

	<td colspan="30" align="left" class="bodytext3"><strong>Search Report</strong></td>

	</tr>

	<tr>

	<td width="95" align="left" class="bodytext3">Search Employee</td>

	<td colspan="4" align="left" class="bodytext3">

	<input type="hidden" name="autobuildemployee" id="autobuildemployee">

	<input type="hidden" name="searchemployeecode" id="searchemployeecode">

	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>

	</tr>

	<tr>

	<td width="95" align="left" class="bodytext3">Select Department</td>

	<td colspan="4" align="left" class="bodytext3">

	<select name="searchdept" id="searchdept" style="border:solid 1px #001E6A;">

	<?php if($searchdept != '') { ?>

	<option value="<?php echo $searchdept; ?>"><?php echo $searchdept; ?></option>

	<?php } ?>

	<option value="">ALL</option>

	<?php

  $query5 = "select department from master_payrolldepartment where recordstatus <> 'deleted' group by department order by department";

  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

  while($res5 = mysqli_fetch_array($exec5))

  {

  $departmentname = $res5['department'];

  ?>

  <option value="<?php echo $departmentname; ?>"><?php echo $departmentname; ?></option>

  <?php

  }

  ?>

	</select>

	</tr>

	<tr>

	<td align="left" class="bodytext3">Search Month</td>

	<td width="63" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">

	<?php if($searchmonth != '') { ?>

	<option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>

	<?php } ?>

	<?php

	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

	$monthcount = count($arraymonth);

	for($i=0;$i<$monthcount;$i++)

	{

	?>

	<option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>

	<?php

	}

	?>

	</select></td>

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

	<td width="560" align="left" class="bodytext3">

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

	$totalamount = '0.00';

	if($frmflag1 == 'frmflag1')

	{	

		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }

		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }

		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }

		if (isset($_REQUEST["searchdept"])) { $searchdept = $_REQUEST["searchdept"]; } else { $searchdept = ""; }



		$searchmonthyear = $searchmonth.'-'.$searchyear; 

		

		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchdept=$searchdept";



	?>	

	<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

	<tbody>

	<tr bgcolor="#ecf0f5">

	<td colspan="30" align="left" class="bodytext3"><strong>Department Wise Report</strong></td>

	</tr>

	<tr bgcolor="#FFFFFF">

	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S PIN : <?php echo $companycode; ?></strong></td>

	</tr>

	<tr bgcolor="#FFFFFF">

	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>

	</tr>

	<tr bgcolor="#FFFFFF">

	<td colspan="30" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>

	</tr>

	<tr bgcolor="#ecf0f5">

	<td colspan="30" align="left" class="bodytext3"><strong>&nbsp;</strong></td>

	</tr>

	<tr>

	<td width="25" align="center" bgcolor="#ecf0f5" class="bodytext3"><strong>S.No</strong></td>

	<td width="217" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>

	<td colspan="2" width="105" align="left" bgcolor="#ecf0f5" class="bodytext3"><strong>DEPT NAME</strong></td>

	<td align="right" bgcolor="#ecf0f5" class="bodytext3" width="77"><strong>AMOUNT</strong></td>

	<td align="left" bgcolor="#ecf0f5" class="bodytext3" width="47">&nbsp;</td>

	</tr>

	<?php

	$totalamount = '0.00';

	$query9 = "select departmentname from master_employee where departmentname like '%$searchdept%' group by departmentname order by employeecode";

	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res9 = mysqli_fetch_array($exec9))

	{

	$departmentname = $res9['departmentname'];

	?>

	<tr>

	<td colspan="6" align = "left" class="bodytext3" bgcolor="#FFFFFF"><strong><?php echo $departmentname; ?></strong></td>

	</tr>

	<?php

	$query2 = "select a.employeecode as employeecode, a.employeename as employeename from details_employeepayroll a JOIN master_employee b ON (a.employeecode = b.employeecode) where a.employeename like '%$searchemployee%' and a.paymonth = '$searchmonthyear' and b.departmentname = '$departmentname' and a.status <> 'deleted' and (b.payrollstatus = 'Active' or b.payrollstatus = 'Prorata') group by a.employeecode";

	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res2 = mysqli_fetch_array($exec2))

	{

	$res2employeecode = $res2['employeecode'];

	$res2employeename = $res2['employeename'];

	

	$departmentname = $res9['departmentname'];

	

	if($departmentname != '')

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

	?>

	<tr <?php echo $colorcode; ?>>

	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>

	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>

	<td colspan="2" align="left" class="bodytext3"><?php echo $departmentname; ?></td>

	<?php

	$totaldeduct = 0;

	$totalgrossper = 0;

	$query12 = "select auto_number as ganum, typecode from master_payrollcomponent where recordstatus <> 'deleted'";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res12 = mysqli_fetch_array($exec12))

	{

		$ganum = $res12['ganum']; 

		$typecode = $res12['typecode'];

		

		$querygg = "select `$ganum` as res12value from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";

		$execgg = mysqli_query($GLOBALS["___mysqli_ston"], $querygg) or die ("Error in Querygg".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resgg = mysqli_fetch_array($execgg);

		$res12value = $resgg['res12value'];

		if($typecode == 10){

		$totalgrossper = $totalgrossper + $res12value; }

		else { 

		$totaldeduct = $totaldeduct + $res12value; }

	}

	$nettpay = $totalgrossper - $totaldeduct;

	

	$totalamount = $totalamount + $nettpay;

	?>

	<td align="right" class="bodytext3" width="77"><?php echo number_format($nettpay,0,'.',','); ?></td>

	<td align="right" class="bodytext3" width="47">&nbsp;</td>	

	<?php

	}

	}

	}

	?>

	</tr>

	<tr>

	<td colspan="4" bgcolor="#ecf0f5" align="right" class="bodytext3"><strong>Total :</strong></td>

	<td bgcolor="#ecf0f5" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>

	<td align="left" bgcolor="#ecf0f5" class="bodytext3" width="47">&nbsp;</td>

	</tr>

	<!--<tr>

	<td colspan="6" align="right" class="bodytext3"><a href="print_bankreportxl.php?<?php echo $url; ?>"><img src="images/excel-xls-icon.png" height="40" width="40"></a></td>

	</tr>-->

	</tbody>

	</table> 

	<?php

	}

	?>

	</td>

  	</tr>

    </table>

<?php include ("includes/footer1.php"); ?>
    <!-- Modern JavaScript -->
    <script src="js/payrolldeptreport1-modern.js?v=<?php echo time(); ?>"></script>
</body>

</html>



