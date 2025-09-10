<?php
session_start();
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

$E3 = '0.00';
$F = '0.00';
$J = '0.00'; 

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
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
	if(document.getElementById("searchemployee").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="102%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php  include ("includes/alertmessages1.php");  ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php  include ("includes/title1.php");  ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	 include ("includes/menu1.php"); 
	 //include ("includes/menu2.php"); 
	?></td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<form action="employeep9report.php" method="post" name="form1" onSubmit="return from1submit1()">  
  <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode" value="<?php echo $searchemployeecode; ?>">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php  echo $searchemployee;  ?>" size="50" style="border:solid 1px #001E6A;"></td>
    <td align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<tr>
	<td width="74" align="left" class="bodytext3">Search Year</td>
	<td width="56" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
	<?php  if($searchyear != '') {  ?>
	<option value="<?php  echo $searchyear;  ?>"><?php  echo $searchyear;  ?></option>
	<?php  }  ?>
	<?php 
	for($j=2016;$j<=date('Y');$j++)
	{
	 ?>
	<option value="<?php  echo $j;  ?>"><?php  echo $j;  ?></option>
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
	</tbody>
	</table>
  </form>
  </td>
  </tr> 
  <?php if($frmflag1 == 'frmflag1')	{ ?>
  <tr>
  <td>&nbsp;</td>
   <td align="left" valign="top">
   <a href="print_p9.php?searchemployeecode=<?php echo $searchemployeecode; ?>&&searchyear=<?php echo $searchyear; ?>" target="_blank"><img src="images/pdfdownload.jpg" width="30" height="30" /></a>
   <a href="print_p9xl.php?searchemployeecode=<?php echo $searchemployeecode; ?>&&searchyear=<?php echo $searchyear; ?>" target="_blank"><img src="images/excel-xls-icon.png" width="30" height="30" /></a>
   </td>
  </tr> 
  <?php } ?>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<?php 
	
	
	if($frmflag1 == 'frmflag1')
	{
	if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
	if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
	
	$querycomp = "SELECT companycode,companyname, pinnumber,employername FROM master_company WHERE auto_number = '$companyanum'";
	$execcomp = mysqli_query($GLOBALS["___mysqli_ston"], $querycomp) or die ("Error in querycomp".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rescomp = mysqli_fetch_array($execcomp);
	$companycode = $rescomp['companycode'];
	$companyname = $rescomp['employername'];	
	$companypin = $rescomp['pinnumber'];
	$employerpin = $rescomp['pinnumber'];
	
	$queryemp = "SELECT employeecode,employeename,pinno,payrollno FROM master_employeeinfo WHERE employeecode='$searchemployeecode'";
	$execemp = mysqli_query($GLOBALS["___mysqli_ston"], $queryemp) or die ("Error in queryemp".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resemp = mysqli_fetch_array($execemp);
	$employeecode = $resemp['employeecode'];
	$employeename = $resemp['employeename'];
	$employeepin = $resemp['pinno'];	
	
	$payrollno = $resemp['payrollno'];	
	$res11e1= '30';
	$E3= '20000.00';
	$F= '0.00';
	
	$query9 = "select amount from master_taxrelief where type='Monthly' and status='' and tyear = '$searchyear'";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res9 = mysqli_fetch_array($exec9);
	$J= $res9['amount'];
	?>
<table width="1087" align="left" style="background-color:#FFFFFF; float: left;">
<tr><td align="left" width="518" class="foot_head">P9A</td><td  width="564" align="right">&nbsp;</td></tr>
</table>
<table width="1086" align="left" class="logo" border="0" style="background-color:#FFFFFF; float: left;">
  <tr><td width="1081" align="center"><strong>KENYA REVENUE AUTHORITY</strong></td></tr>
    <tr><td align="center"><strong>INCOME TAX DEPARTMENT</strong></td></tr>
    <tr><td align="center"><strong>TAX DEDUCTION CARD YEAR<?php echo $searchyear;?></strong></td></tr>
	<tr><td align="center">&nbsp;</td></tr>
</table>
<table width="1087" class="info" align="left" cellpadding="" cellspacing="0" style="background-color:#FFFFFF; float: left;">
    <tr>
    	<td width="203">Employer's Name:</td>
        <td width="430" class="borderbottom"><?php echo $companyname;?></td>
        <td width="19">&nbsp;</td>
        <td width="158">Employer's PIN:</td>
        <td width="281" class="borderbottom"><?php echo $employerpin;?></td>
    </tr>
    <tr>
    	<td>Employee's Main Name:</td>
        <td class="borderbottom"><?php echo $employeename; ?></td>
        <td>&nbsp;</td>
        <td>Employee's PIN:</td>
        <td class="borderbottom"><?php echo $employeepin; ?></td>
    </tr>
    <tr>
    	<td>Employee's Other Names:</td>
        <td class="borderbottom"><?php //echo $employeelastname; ?></td>
        <td>&nbsp;</td>
        <td>Employee's Payroll:</td>
        <td class="borderbottom"><?php echo $payrollno; ?></td>
    </tr>
    <tr><td colspan="5">&nbsp;</td>
    </tr>
</table>
<table width="1088" border="1" align="left" cellpadding="" cellspacing="" bordercolor="#666666" class="payroll" style="border-collapse:collapse; background-color:#FFFFFF; float: left;">
    <thead>
        <tr>
            <th width="62">MONTH</th>
            <th width="51">Basic Salary<br> 
            Kshs.</th>
            <th width="60">Benefits Non Cash<br> 
            Kshs.</th>
            <th width="60">Values of Quarters<br> 
            Kshs.</th>
            <th width="51">Total Gross Pay<br> 
            Kshs.</th>
            <th colspan="3">Defined Contribution Retirement Scheme<br> Kshs.</th>
            <th width="103">Owner Occupied Interest<br> Kshs.</th>
            <th width="96">Retirement Contribution & Owner Occupied Interest</th>
            <th width="81">Chargeable Pay<br> 
            Kshs.</th>
            <th width="58">Tax Charged<br> 
            Kshs.</th>
            <th width="62">Personal Relief<br> 
            Kshs.</th>
            <th width="70">Insurance Relief<br> 
            Kshs.</th>
        	<th width="94">PAYE Tax (J-K)<br> 
       	    Kshs.</th>
        </tr>
        <tr>
            <th rowspan="2">&nbsp;</th>
            <th rowspan="2">A</th>
            <th rowspan="2">B</th>
            <th rowspan="2">C</th>
            <th rowspan="2">D</th>
            <th colspan="3">E</th>
            <th rowspan="2">F<br> Amount of Interest</th>
            <th rowspan="2">G<br> The lowest of E<br/> added to F</th>
            <th rowspan="2">H</th>
            <th rowspan="2">I</th>
            <th>J</th>
            <th>K</th>
        	<th rowspan="2">L</th>
        </tr>
        <tr>
       	  <th width="65">E1 <?php echo $res11e1; ?>% of A</th>
          <th width="73">E2 Actual</th>
          <th width="70">E3 Fixed</th>
          <th colspan="2">Total Kshs. <?php echo number_format($J); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
	$totala = '0.00';
	$totalb = '0.00';
	$totalc = '0.00';
	$totald = '0.00';
	$totale1 = '0.00';
	$totale2 = '0.00';
	$totale3 = '0.00';
	$totalf = '0.00';
	$totalg = '0.00';
	$totalh = '0.00';
	$totali = '0.00';
	$totalj = '0.00';
	$totalk = '0.00';
	$totall = '0.00';
	
	$monthnum='';
	$arraymonth = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	$monthnum=$i+1;
	$searchmonthyear = $arraymonth[$i].'-'.$searchyear;
	//date('F',strtotime($arraymonth[$i]));
	$E3= '20000.00';
	
	$query9 = "select amount from master_taxrelief where type='Monthly' and status='' and tyear = '$searchyear'";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res9 = mysqli_fetch_array($exec9);
	$J= $res9['amount'];
	
	//$query2r = "select `62` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode' group by employeecode";
	//$exec2r = mysqli_query($GLOBALS["___mysqli_ston"], $query2r) or die ("Error in Query2r".mysqli_error($GLOBALS["___mysqli_ston"]));
	//$res2r = mysqli_fetch_array($exec2r);
	$res2r['componentamount'] = 0; 
	$J = $J + $res2r['componentamount'];
	
	$query2i = "select `insurancerelief` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode' group by employeecode";
	$exec2i = mysqli_query($GLOBALS["___mysqli_ston"], $query2i) or die ("Error in Query2i".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2i = mysqli_fetch_array($exec2i);
	$K = $res2i['componentamount'];
	
	$query2 = "select `1` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode' group by employeecode";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$res2basic = $res2['componentamount'];
	$res2basic = number_format($res2basic,2,'.','');
	if($res2basic == '0.00')
	{
		$E3 = '0.00';
		$J = '0.00';
	}
	
	$B = '0.00';
	$C = '0.00';
	$D = '0.00';
	$E1 = '0.00';
	$E2 = '0.00';
	$G = '0.00';
	$H = '0.00';
	$I = '0.00';
	$L = '0.00'; 
	$otherearn = '0.00';
	
	$query3 = "select auto_number from master_payrollcomponent where notional='YES'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res3 = mysqli_fetch_array($exec3))
	{
	 $res3auto_number = $res3['auto_number'];
	
	 $query4 = "select `$res3auto_number` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	 $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $res4 = mysqli_fetch_array($exec4);
	 $res4componentamount = $res4['componentamount'];
	 $B=$B+$res4componentamount;   //B
	}
	
	$res5componentamount = 0;   
	
	$res15absent = 0;
	
	$query26 = "select componentname, auto_number from master_payrollcomponent where type = 'Earning' and componentname='OTHER EARN' and recordstatus=''";
	$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query26".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res26 = mysqli_fetch_array($exec26))
	{
	 $res26componentanum = $res26['auto_number'];
	
	$query16 = "select `$res26componentanum` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res16 = mysqli_fetch_array($exec16);
	$res16componentamount = $res16['componentamount'];
    $otherearn=$otherearn+$res16componentamount;
	}
	//$basic=($res2basic+$res5componentamount+$otherearn)-$res15absent;  //A
	
	$D = 0;
	$query36 = "select auto_number, componentname from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted' and notional = 'No' order by order_no";
	$exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die ("Error in Query36".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res36 = mysqli_fetch_array($exec36))
	{
		$res3componentanum = $res36['auto_number'];
		$query6 = "select `$res3componentanum` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res6 = mysqli_fetch_array($exec6);
		$D = $D + $res6['componentamount']; 
	}//D
	$basic=$D;
	//$D = $basic+$B+$C;      //D
	
	$E1 = ($res11e1*$basic)/100;
	
	$query7 = "select `3` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$E2a= $res7['componentamount'];
	
	//$query78 = "select `24` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	//$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
	//$res78 = mysqli_fetch_array($exec78);
	$res78['componentamount'] = 0;
	$E2b= $res78['componentamount'];
	
	$E2 = $E2a + $E2b;

	$G=(min($E1,$E2,$E3)+$F);  
	$H=$D-$G;
	
	$query8 = "select `4` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
	$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res8 = mysqli_fetch_array($exec8);
	$res8componentamount = $res8['componentamount'];
	
	$I=$res8componentamount+$J;
	
	$L=$I-$J;

	$totala=$totala+$basic;
	$totalb=$totalb+$B;
	$totalc=$totalc+$C;
	$totald=$totald+$D;
	$totale1=$totale1+$E1;
	$totale2=$totale2+$E2;
	$totale3=$totale3+$E3;
	$totalf=$totalf+$F;
	$totalg=$totalg+$G;
	$totalh=$totalh+$H;
	$totali=$totali+$I;
	$totalj=$totalj+$J;
	$totalk=$totalk+$K;
	$totall=$totall+$L;
	?>
     <tr>
		<td class="month"><?php echo date('F',mktime(0,0,0,$monthnum,10)); ?></td>
		<td align="right"><?php echo number_format($basic,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($B,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($C,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($D,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($E1,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($E2,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($E3,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($F,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($G,2,'.',',');  ?></td>
		<td align="right"><?php echo number_format($H,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($I,2,'.',','); ?></td>  
		<td align="right"><?php echo number_format($J,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($K,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($L,2,'.',','); ?></td>
	</tr>
	<?php
	}
	?>
    <tr>
		<td align="left">TOTALS</td>
		<td align="right"><?php echo number_format($totala,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalb,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalc,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totald,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totale1,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totale2,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totale3,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalf,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalg,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalh,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totali,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalj,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totalk,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totall,2,'.',','); ?></td>
	</tr>
   </tbody>
</table>
<table width="1089" align="left" class="footer" style="background-color:#FFFFFF; float: left;">
	<tr><td colspan="5" align="center" class="foot_head">TOTAL TAX (COL.L)Kshs. <?php echo number_format($totall,2,'.',','); ?></td></tr>
    <tr><td colspan="5" align="center" class="foot_head">&nbsp;</td></tr>
    <tr><td colspan="5" align="left">To be completed by Employer at end of year</td></tr>
    <tr>
    	<td colspan="2" class="foot_head">TOTAL CHARGEABLE PAY (COL.H)Kshs. <?php echo number_format($totalh,2,'.',','); ?></td>
        <td width="14" colspan="">(b)</td>
        <td colspan="2"> Attach</td>
    </tr>
    <tr>
    	<td colspan="2"><strong><u>IMPORTANT</u></strong></td>
        <td colspan="">&nbsp;</td>
        <td colspan="2">(i) Photostat copy of interest certificate and statement of account from  then Financial Institution</td>
    </tr>
    <tr>
    	<td width="56" colspan="">1. Use P9A </td>
        <td width="506" colspan="">(a) For all liable employees and where director/employee received Benefits in addition to cash emoluments</td>
        <td colspan="">&nbsp;</td>
        <td colspan="2">(ii) The DECLARATION duly signed by the employee</td>
    </tr>
    <tr>
    	<td colspan="">&nbsp;</td>
        <td colspan="">(b) Where an employee is eligible to deduction on owner occupied interest</td>
        <td colspan="">&nbsp;</td>
        <td colspan="2" class="foot_head">NAMES OF FINANCIAL INSTITUTION ADVANCING MORTGATE LOAN</td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
        <td colspan="">&nbsp;</td>
        <td colspan="2" class="borderbottom"></td>
    </tr>
    <tr>
    	<td colspan="2">2. Deductible interest in respect of any month must not exceed Kshs.8333/-</td>
        <td colspan="">&nbsp;</td>
         <td width="250" colspan="" class="foot_head">L.R NO OF OWNER OCCUPIED PROPERTY:</td>
        <td width="200" colspan="" class="borderbottom"></td>
    </tr>
    <tr>
    	<td colspan="2"><strong>(see back of this card for further information required by the Department) <i>P.9A</i></strong></td>
        <td colspan="">&nbsp;</td>
         <td colspan="" class="foot_head">DATE OF OCCUPATION OF HOUSE:</td>
        <td colspan="" class="borderbottom"></td>
    </tr>
</table>
	<?php 
	}
	 ?>
	</td>
  	</tr>
    </table>
<?php  include ("includes/footer1.php");  ?>
</body>
</html>

