<?php
require_once('html2pdf/html2pdf.class.php');
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

$E3 = '0.00';
$F = '0.00';
$J = '0.00'; 
ob_start();

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }

$querycomp = "SELECT companycode,companyname,pincode,city,pinnumber,employername FROM master_company WHERE auto_number = '$companyanum'";
$execcomp = mysqli_query($GLOBALS["___mysqli_ston"], $querycomp) or die ("Error in querycomp".mysqli_error($GLOBALS["___mysqli_ston"]));
$rescomp = mysqli_fetch_array($execcomp);
$companycode = $rescomp['companycode'];
$companyname = $rescomp['employername'];	
$companypin = '';	
$employerpin = $rescomp['pinnumber'];
$pincode = $rescomp["pincode"];
$city = $rescomp["city"];

$address = "P O Box: ".$pincode.', '.$city;
$strlen3 = strlen($address);
$totalcharacterlength3 = 35;
$totalblankspace3 = 35 - $strlen3;
$splitblankspace3 = $totalblankspace3 / 2;
for($i=1;$i<=$splitblankspace3;$i++)
{
$address = ' '.$address;
}
	
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
<style>
body {
    font-family: 'Arial'; font-size:7px;	 
}
.borderbottom{border-bottom:1px #0000000;}
th{text-align:center; vertical-align:middle;font-size:12px;}
td{text-align:left; vertical-align:middle;font-size:12px;}
table{
	table-layout: fixed;
	border-collapse: collapse;
}
.payroll tbody td{text-align: right; font-family:Arial, Helvetica, sans-serif;}
.month{text-align: left;}
.logo tr td{
	text-transform:uppercase;
	font-size:16px;
	font-weight:bold;
	text-align:center;
}
.info tr td{
	font-size:14px;
	vertical-align:text-bottom;
}
.foot_head{font-weight: bold; font-size:12px;}
</style>
<page pagegroup="new" backtop="8mm" backbottom="8mm" backleft="1mm" backright="1mm">
 <page_footer>
                <div class="page_footer" style="width: 100%; text-align: right">
                    Page [[page_cu]] of [[page_nb]]
                </div>
    </page_footer>
    <table width="1050" align="center">
     <tr>
	  <td align="left" width="525" class="foot_head">APPENDIX 1A</td><td  width="525" align="right">KRA Approval Number: CDTD/1037/2008/4</td>
	 </tr>
    </table>
    <table align="center" class="logo">
     <tr><td>KENYA REVENUE AUTHORITY</td></tr>
    <tr><td>INCOME TAX DEPARTMENT</td></tr>
    <tr><td>TAX DEDUCTION CARD YEAR <?php echo $searchyear;?></td></tr>
    </table>
<p>&nbsp;</p>
<table width="1080" class="info" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<td width="160">Employer's Name:</td>
        <td width="390" class="borderbottom"><?php echo $companyname;?></td>
        <td width="30">&nbsp;</td>
        <td width="120">Employer's PIN:</td>
        <td width="380" class="borderbottom"><?php echo $employerpin;?></td>
    </tr>
    <tr>
    	<td width="160">Employee's Main Name:</td>
        <td width="390" class="borderbottom"><?php echo $employeename; ?></td>
        <td width="30">&nbsp;</td>
        <td width="120">Employee's PIN:</td>
        <td width="380" class="borderbottom"><?php echo $employeepin; ?></td>
    </tr>
    <tr>
    	<td width="160">Employee's Other Names:</td>
        <td width="390" class="borderbottom"><?php //echo $employeelastname; ?></td>
        <td width="30">&nbsp;</td>
        <td width="120">Employee's Payroll:</td>
        <td width="380" class="borderbottom"><?php echo $payrollno; ?></td>
    </tr>
    <tr>
	    <td width="1080" colspan="5">&nbsp;</td>
    </tr>
</table>
  <table width="1035" border="1" align="center" cellpadding="" cellspacing="" bordercolor="#666666" class="payroll" >
    <thead>
        <tr>
            <th width="60">MONTH</th>
            <th width="66">Basic Salary<br> Kshs.</th>
            <th width="66">Benefits Non Cash<br> Kshs.</th>
            <th width="66">Values of Quarters<br> Kshs.</th>
            <th width="66">Total Gross Pay<br> Kshs.</th>
            <th colspan="3">Defined Contribution Retirement Scheme<br> Kshs.</th>
            <th width="100">Owner Occupied Interest<br> Kshs.</th>
            <th width="91">Retirement Contribution & Owner Occupied Interest</th>
            <th width="66">Chargeable Pay<br> Kshs.</th>
            <th width="66">Tax Charged<br> Kshs.</th>
            <th width="66">Personal Relief<br> Kshs.</th>
            <th width="66">Insurance Relief<br> Kshs.</th>
        	<th width="66">PAYE Tax (J-K)<br> Kshs.</th>
        </tr>
        <tr>
            <th width="60" rowspan="2">&nbsp;</th>
            <th width="66" rowspan="2">A</th>
            <th width="66" rowspan="2">B</th>
            <th width="66" rowspan="2">C</th>
            <th width="66" rowspan="2">D</th>
            <th colspan="3">E</th>
            <th width="100" rowspan="2">F<br> Amount of Interest</th>
            <th width="91" rowspan="2">G<br> The lowest of E<br/> added to F</th>
            <th width="66" rowspan="2">H</th>
            <th width="66" rowspan="2">I</th>
            <th width="66">J</th>
            <th width="66">K</th>
        	<th width="66" rowspan="2">L</th>
        </tr>
        <tr>
       	  <th width="67">E1 <?php echo $res11e1; ?>% of A</th>
          <th width="67">E2 Actual</th>
          <th width="67">E3 Fixed</th>
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
	$res2r['componentamount']=0;
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
	
//	$query78 = "select `24` as componentamount from details_employeepayroll where paymonth = '$searchmonthyear' and status <> 'deleted' and employeecode = '$employeecode'";
//	$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
//	$res78 = mysqli_fetch_array($exec78);
	$res78['componentamount']= 0;
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
<table width="1080" align="center" class="footer">
	<tr><td width="1080" colspan="5" align="center" class="foot_head">TOTAL TAX (COL.L)Kshs. <?php echo number_format($totall,2,'.',','); ?></td></tr>
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
<p>&nbsp;</p>
<p>
  <!-----------------------------------------------------------------Unwanted---------------------------------------------------------->
  
</p>
</page>

<page orientation="portrait" pagegroup="new" backtop="8mm" backbottom="8mm" backleft="1mm" backright="1mm">
 <page_footer>
                <div class="page_footer" style="width: 100%; text-align: right">
                    Page [[page_cu]] of [[page_nb]]
                </div>
    </page_footer>
	<table width="600" align="center" border="0">
	 <tr>
	  <td width="270" align="left"><strong>APPENDIX 1B</strong></td>
	  <td width="50" align="right">&nbsp;</td>
	  <td width="200" align="right">Payroll No:</td>
	  <td width="200" align="right">&nbsp;</td>
	 </tr>
	 <tr>
    	<td width="620" colspan="4">INFORMATION REQUIRED FROM EMPLOYER AT END OF YEAR</td>
    </tr>
	<tr>
	  <td width="270" align="left">(1) Date Employee commenced if during year</td>
	  <td width="50" align="left"><strong>: N.A.</strong></td>
	  <td width="200" align="left">Name and address of old employer:</td>
	  <td width="200" align="left"><strong>: N.A.</strong></td>
	 </tr>
	 
	 <tr>
	  <td width="270" align="left">(2) Date Employee Left if during year</td>
	  <td width="50" align="left"><strong>: N.A.</strong></td>
	  <td width="200" align="left">Name and address of new employer:</td>
	  <td width="200" align="right">:&nbsp;</td>
	 </tr>
	 <tr>
	  <td width="620" colspan="4" align="left">(3) Where housing is provided. State monthly rent charged Kshs. per month.</td>
	 </tr>
	 <tr>
	  <td width="620" colspan="4" align="left">(4) Where any of the pay relates to a period other than this year, e.g. gratuity. Give details of Amount, Year and Tax.</td>
	 </tr>
	 <tr>
	  <td width="600" colspan="4" align="right">
	   <table align="right" class="logo" border="1" bordercolor="#666666">
		  <tr>
		    <th width="120"><strong>Year</strong></th>
		    <th width="120"><strong>Amount</strong></th>
		    <th width="120"><strong>Amount Sh</strong></th>
		  </tr>
		  <tr>
		    <td width="120" align="left">20</td>
		    <td width="120" align="left">&nbsp;</td>
		    <td width="120" align="left">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="120" align="left">20</td>
		    <td width="120" align="left">&nbsp;</td>
		    <td width="120" align="left">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="120" align="left">20</td>
		    <td width="120" align="left">&nbsp;</td>
		    <td width="120" align="left">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="120" align="left">20</td>
		    <td width="120" align="left">&nbsp;</td>
		    <td width="120" align="left">&nbsp;</td>
		  </tr>
		 </table>
	  </td>
	 </tr>
	<tr>
    	<td width="600" colspan="4">FOR MONTHLY RATES OF BENEFITS PLEASE REFER TO EMPLOYERS GUIDE TO P.A.Y.E. SYSTEM-P7</td>
    </tr>
	<tr>
    	<td width="600" colspan="4" align="center"><strong>CALCULATION OF TAX ON BENEFITS</strong></td>
    </tr>
	<tr>
    	<td width="600" colspan="4" align="center">
		 <table width="700" border="0" align="center" cellpadding="" cellspacing="" bordercolor="#666666" class="payroll">
    <thead>
    	
        <tr>
            <th width="300" align="left"><u>BENEFIT</u></th>
            <th width="100" align="left"><u>NO.</u></th>
            <th width="100" align="left"><u>RATE</u></th>
            <th width="100" align="center"><u>NO. OF MONTHS</u></th>
            <th width="100" align="right"><u>TOTAL AMOUNT</u></th>
        </tr>
        <tr>
            <th width="300" align="left">&nbsp;</th>
            <th width="100" align="left">&nbsp;</th>
            <th width="100" align="left">&nbsp;</th>
            <th width="100" align="left">&nbsp;</th>
            <th width="100" align="center">Kshs</th>
        </tr>
    </thead>
    <tbody>
		<tr>
			<td width="300" align="left">COOK/HOUSE SERVANT</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">GARDENER</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">AYAH</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">WATCHMAN(D)</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">WATCHMAN(N)</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">FURNITURE</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">WATER</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">TELEPHONE</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">ELECTRICITY</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">SEC. SYST</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
    </tbody>
</table>
		</td>
    </tr>
	<tr>
	 <td width="600" colspan="4" align="left">Where actual cost is higher than given monthly rates of benefits then the actual cost is brought to charge in full.</td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="left"><strong>LOW INTEREST RATE BELOW PRESCRIBED RATE OF INTEREST.</strong></td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="left">EMPLOYERS LOAN = Kshs. @ % RATE</td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="left">RATE DIFFERENCE = (PRESCRIBED - EMPLOYERS RATE) =  %</td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="left">MONTHLY BENEFIT (RATE DIFFERENCE x LOAN) = % X Kshs. =</td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="left">MOTOR CARS</td>
	</tr>
	<tr>
    	<td width="600" colspan="4" align="center">
		 <table width="700" border="0" align="center" cellpadding="" cellspacing="" bordercolor="#666666" class="payroll">
    <tr>
			<td width="300" align="left">Up to 1500 c.c. </td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
	</tr>
		<tr>
			<td width="300" align="left"> 1501 c.c. - 1750 c.c. </td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">1751 c.c - 2000 c.c. </td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">2001 c.c - 3000 c.c </td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">Over 3000 c.c. </td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
		<tr>
			<td width="300" align="left">Total Benefit in Year</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">X</td>
			<td width="100" align="center">&nbsp;</td>
			<td width="100" align="left">=</td>
		</tr>
       </table>
	 </td>
	</tr>
	<tr>
	 <td width="600" colspan="4">If this amount does not agree with total of Col. B overleaf, attach explanation. </td>
	</tr>
	<tr>
	 <td width="600" colspan="4">&nbsp;</td>
	</tr>
	<tr>
	 <td width="600" colspan="4">FOR PICK-UPS, PANEL VANS AND LAND-ROVERS REFER TO APPENDIX 5 OF EMPLOYER'S GUIDE</td>
	</tr>
	<tr>
	 <td width="600" colspan="4">CAR BENEFIT - The higher amount of the fixed monthly rate or the prescribed rate of benefits is to be brought to charge:</td>
	</tr>
	<tr>
	 <td width="600" colspan="4">PRESCRIBED RATE: 1996-1% per month of the intial cost of vehicle., 1997-1.5% per month of the initial cost of vehicle.</td>
	</tr>
	<tr>
	 <td width="600" colspan="4">1997-2% per month of the initial cost of vehicle.</td>
	</tr>
	<tr>
	 <td width="600" colspan="4">&nbsp;</td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="center">EMPLOYERS CERTIFICATE OF PAY AND TAX</td>
	</tr>
	<tr>
	 <td width="600" colspan="4">&nbsp;</td>
	</tr>
	<tr>
    	<td width="600" colspan="4" align="left">
		 <table width="740" border="0" align="left" bordercolor="#666666"  class="payroll">
          <tr>
			<td width="60" align="left" valign="bottom">NAME:</td>
			<td width="340" align="left" valign="bottom" class="borderbottom">&nbsp;<strong><?php echo trim($companyname); ?></strong></td>
			<td width="100" align="left" valign="bottom">&nbsp;SIGNATURE:</td>
			<td width="240" align="left" valign="bottom" class="borderbottom">&nbsp;</td>
	     </tr>
         <tr>
            <td width="60" align="left" valign="bottom">&nbsp;</td>
            <td width="340" align="left" valign="bottom">&nbsp;</td>
            <td width="100" align="left" valign="bottom">&nbsp;</td>
            <td width="240" align="left" valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td width="60" align="left" valign="bottom">&nbsp;</td>
            <td width="340" align="left" valign="bottom">&nbsp;</td>
            <td width="100" align="left" valign="bottom">&nbsp;</td>
            <td width="240" align="left" valign="bottom">&nbsp;</td>
         </tr>
		 <tr>
            <td width="60" align="left" valign="bottom">&nbsp;</td>
            <td width="340" align="left" valign="bottom">&nbsp;</td>
            <td width="100" align="left" valign="bottom">&nbsp;</td>
            <td width="240" align="left" valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td width="60" align="left" valign="bottom">&nbsp;</td>
            <td width="340" align="left" valign="bottom">&nbsp;</td>
            <td width="100" align="left" valign="bottom">&nbsp;</td>
            <td width="240" align="left" valign="bottom">&nbsp;</td>
         </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">ADDRESS:</td>
			<td width="340" align="left" valign="bottom" class="borderbottom">&nbsp;<strong><?php echo trim($address); ?></strong></td>
			<td width="100" align="left" valign="bottom">&nbsp;DATE & STAMP:</td>
			<td width="240" align="left" valign="bottom" class="borderbottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
		 <tr>
			<td width="60" align="left" valign="bottom">&nbsp;</td>
			<td width="340" align="left" valign="bottom">&nbsp;</td>
			<td width="100" align="left" valign="bottom">&nbsp;</td>
			<td width="240" align="left" valign="bottom">&nbsp;</td>
		 </tr>
       </table>
	 </td>
	</tr>
	<tr>
	 <td width="600" colspan="4" align="left"><strong>NOTE: Employer's certificate to be signed by the person who prepares and submits to the PAYE End of Year Returns and Copy of the P9A be issued to the employee in January.</strong></td>
	</tr>
  </table>
</page>
	
<?php	
require_once('html2pdf/html2pdf.class.php');
$content = ob_get_clean();
try
    {	
        $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('times');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('EmployeePayReport.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>



