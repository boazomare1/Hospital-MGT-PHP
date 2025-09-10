<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$packageanum1="";
$ipunfinalizeamount='';
$ipfinalizedamount='0';
$labtotal = "0.00";
$totalradiologyitemrate = "0.00";
$totalservicesitemrate = "0.00";
$totalprivatedoctoramount = "0.00";
$totalpharmacysaleamount = "0.00";
$totalpharmacysalereturnamount = "0.00";
$totalambulanceamount = "0.00";
$totalipmis = "0.00";
$totaldiscountrate = "0.00";
$totalnhifamount = "0.00";
$totalipdepositamount = "0.00";
$totalbedcharges = "0.00";
$totalbedtransfercharges = "0.00";
$totalpackage = "0.00";
$totalprivatedoctorfees= "0.00";
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



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
           <?php
            $colorloopcount ='';
			$netamount='';
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			if (isset($_REQUEST["acc_id"])) { $acc_id = $_REQUEST["acc_id"]; } else { $acc_id = ""; }
			$j = 0;
	$crresultphar = array();
	$querycr1phar = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE  a.billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
	$execcrphar1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1phar) or die ("Error in querycr1phar".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescrphar1 = mysqli_fetch_array($execcrphar1))
	{
	$j = $j+1;
	$crresultphar[$j] = $rescrphar1['income'];
	}
	$totalpharmacysaleamount = array_sum($crresultphar);
						$j = 0;
						$crresultlab = array();
						$querycr1lab = "SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
									   //UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
						$execcrlab1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1lab) or die ("Error in querycr1lab".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrlab1 = mysqli_fetch_array($execcrlab1))
						{
						$j = $j+1;
						$crresultlab[$j] = $rescrlab1['income'];
						}	
						$labtotal = array_sum($crresultlab);
			  $j = 0;
						$crresultrad = array();
						$querycr1rad = "SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
									   //UNION ALL SELECT SUM(`fxamount`) as incomedebit FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'";
						$execcrrad1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1rad) or die ("Error in querycr1rad".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrrad1 = mysqli_fetch_array($execcrrad1))
						{
						$j = $j+1;
						$crresultrad[$j] = $rescrrad1['income'];
						}	
						$totalradiologyitemrate = array_sum($crresultrad);
			  					
					$j = 0;
						$crresultser = array();
						$querycr1ser = "SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id') ";
									   //UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'";
						$execcrser1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1ser) or die ("Error in querycr1ser".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrser1 = mysqli_fetch_array($execcrser1))
						{
						$j = $j+1;
						$crresultser[$j] = $rescrser1['income'];
						}
						$totalservicesitemrate = array_sum($crresultser);
		
		$j = 0;
						$crresultin = array();
						$querycr1adm = "SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
						$execcrin1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1adm) or die ("Error in querycr1adm".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrin1 = mysqli_fetch_array($execcrin1))
						{
						$j = $j+1;
						$crresultin[$j] = $rescrin1['income'];
						}
						$totaladmncharges=array_sum($crresultin);
						$crresultin = array();
								$querycr1amb = "SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
								$execcrin1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1amb) or die ("Error in querycr1amb".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrin1 = mysqli_fetch_array($execcrin1))
						{
						$j = $j+1;
						$crresultin[$j] = $rescrin1['income'];
						}
						$totalambulanceamount=array_sum($crresultin);
						$crresultin = array();
								$querycr1bed = "SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
								$execcrin1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1bed) or die ("Error in querycr1bed".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrin1 = mysqli_fetch_array($execcrin1))
						{
						$j = $j+1;
						$crresultin[$j] = $rescrin1['income'];
						}
						$totalbedcharges=array_sum($crresultin);
						$crresultin = array();
								$querycr1mis = "SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
						$execcrin1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1mis) or die ("Error in querycr1mis".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($rescrin1 = mysqli_fetch_array($execcrin1))
						{
						$j = $j+1;
						$crresultin[$j] = $rescrin1['income'];
						}
						$totalipmis=array_sum($crresultin);
						$i=0;
			$crresultdis = array();
		$querycr1dis = "SELECT SUM(`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber) and patientvisitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')
						UNION ALL SELECT SUM(`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno) and patientvisitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
		$execcrdis1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1dis) or die ("Error in querycr1dis".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($rescrdis1 = mysqli_fetch_array($execcrdis1))
		{
		$i = $i+1;
		$crresultdis[$i] = $rescrdis1['income'];
		}
		  
		$balance = array_sum($crresultdis);
		$totaldiscountrate = $totaldiscountrate + $balance;		  
		
				
			$ipunfinalizeamount=$totaladmncharges+$labtotal+$totalradiologyitemrate+$totalservicesitemrate+$totalprivatedoctoramount+$totalpharmacysaleamount+$totalambulanceamount+$totalipmis-$totaldiscountrate+$totalbedcharges+$totalbedtransfercharges+$totalpackage;
		
	 $ipfinalizedamount = $ipunfinalizeamount;
?>	
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
	
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31">            
			
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>No.</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="style3">Head</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="style3">Value</td>
              <td width="21%" align="right" valign="center" bgcolor="#ecf0f5" class="style3">&nbsp;</td>
            </tr>
			<tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '1'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailviewipadmission1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Admission Charges</a></div>    </td>
            <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totaladmncharges,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
           
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '2'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailviewipbedcharges1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Bed Charges</a></div>              </td>
            <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalbedcharges,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>

           
           <!--<tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '3'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsippackagecharges.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Package Charges</a></div></td>
            <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpackage,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>-->

           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '3'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailiplab1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Lab</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($labtotal,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '4'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
                <div class="bodytext31"><a target="_blank" href="detailipradiology1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Radiology</a></div>              </td>
               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '5'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailipservices1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Service</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '6'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsipprivatedoctor1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Private Doctor</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
		   <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '7'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsipprivatedoctor1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Private Doctor Fees</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalprivatedoctorfees,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '8'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsippharmacysaler1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Pharmacy</a></div>              </td>
               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpharmacysaleamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>
           <!--<tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left"><?php echo '9'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsippharmacyreturn.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Pharmacy Return</a></div>              </td>
               <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalpharmacysalereturnamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>
           </tr>-->
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '9'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsipambulance1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">Ambulance</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalambulanceamount,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '10'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsipmisc1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">IPMISC</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalipmis,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '11'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31"><a target="_blank" href="detailsipdiscount1.php?acc_id=<?php echo $acc_id; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">IP Discount</a></div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totaldiscountrate,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
<!--           <tr>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '13'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31">NHIF</div>              </td>
           <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalnhifamount,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
           <tr>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo '14'; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31">Total Deposit</div>              </td>
           <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format('-'.$totalipdepositamount,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
           </tr>
-->           
         <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Net Revenue:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($ipfinalizedamount,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		
          </tbody>
        </table>
			