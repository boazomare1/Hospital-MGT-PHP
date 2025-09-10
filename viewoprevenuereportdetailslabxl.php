<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="opipreport.xls"');
header('Cache-Control: max-age=80');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '';
$nettotal = '0.00';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';
$res3labitemratereturn = '';
$accountname = '';
$radiologyitemrate1  = '';

 

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

/*if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$ADate1 = $_REQUEST['ADate1'];
	$ADate2 = $_REQUEST['ADate2'];
}
else
{
	$ADate1 = date('Y-m-d', strtotime('-1 month'));
	$ADate2 = date('Y-m-d');
}
*/
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="593" 
            align="left" border="0">
          <tbody>
		  <?php
			
			
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
            <tr>
              <td width="10%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="#FFFFFF" class="bodytext31"><strong>Lab from <?php echo $ADate1; ?> to <?php echo $ADate2; ?></strong></td>
              <td colspan="6" bgcolor="#FFFFFF" class="bodytext31">            
			
                <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>No.</strong></td>
              <td width="16%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="16%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="16%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">visitcode</td>
              <td width="32%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Name</td>
              <td width="10%" align="right" valign="center" bgcolor="#FFFFFF" class="style3">Value</td>
            </tr>
			<?php
			$netamount='';
			$totalconsultationamount='';
			$totalrefundamount='';
			$totallabamount='';
			$totallabrefundamount='';
			$totalradiologyamount='';
			$totalradiologyrefundamount='';
			$totalservicesamount='';
			$totalservicesrefundamount='';
			$totalpharmacyamount='';
			$totalpharmacyrefundamount='';
			$totalreferalamount='';
			$totalreferalrefundamount='';
			$totalexternalpharmacy='';
			$totalexternallab='';
			$totalexternalradiology='';
			$totalexternalservices='';
			$total6='0.00';
			
			$query1 = "select * from billing_paynowlab where billdate between '$ADate1' and '$ADate2'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1)){
			$billdate= $res1['billdate'];
			$billno= $res1['billnumber'];
			$visitcode= $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$res1consultationamount = $res1['fxamount'];
			$total6 = $total6 + $res1consultationamount;
			//$totalconsultationamount=$res1consultationamount;
			//$netamount=$netamount+$res1consultationamount;
			
			 $snocount = $snocount + 1;
			 $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
		   <?php
			
/*			$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$ADate1' and '$ADate2'";
			$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
*/	
			
		   ?>
             
            
            <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $snocount; ?></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $billdate; ?></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $billno; ?></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $visitcode; ?></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><?php echo $patientfullname; ?></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="right"><?php echo number_format($res1consultationamount,2,'.',','); ?></td>
              
           </tr>
            <?php }?>
         <tr>
              <td colspan="5"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong>Net Revenue:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td></tr>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		
          
        </table>
	   

