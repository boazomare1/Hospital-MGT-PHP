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
$colorloopcount='';
$sno='';

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
			
		//$ADate1='2015-02-01';
		//$ADate2='2015-02-28';
		?>
<table width="auto" border="0" cellspacing="0" cellpadding="2">
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
        <td width="auto">

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><strong>Service Charge Details</strong></td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>            
			
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Date</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>
            </tr>

        <?php
            $colorloopcount ='';
			$netamount='';
			$sno=0;
			$totalradiologyitemrate =0;
			
			$totalservicesitemrate =0;
			$totalquantity = 0;
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			if (isset($_REQUEST["acc_id"])) { $acc_id = $_REQUEST["acc_id"]; } else { $acc_id = ""; }
		//$ADate1='2015-01-31';
		//$ADate2='2015-02-28';
		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2' AND accountname ='$acc_id'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['visitcode'];
			$sno = $sno + 1;
			$querymenu = "select * from master_customer where customercode='$patientcode'";
			$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$nummenu=mysqli_num_rows($execmenu);
			$resmenu = mysqli_fetch_array($execmenu);
			$menusub=$resmenu['subtype'];
			
			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$menusub'");
			$execsubtype=mysqli_fetch_array($querysubtype);
			$patientsubtype1=$execsubtype['subtype'];
			$bedtemplate=$execsubtype['bedtemplate'];
			$labtemplate=$execsubtype['labtemplate'];
			$radtemplate=$execsubtype['radtemplate'];
			$sertemplate=$execsubtype['sertemplate'];
			$fxrate = $execsubtype['fxrate'];
			
			$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$numtt32 = mysqli_num_rows($exectt32);
			$exectt=mysqli_fetch_array($exectt32);
			$sertable=$exectt['templatename'];
			if($sertable=='')
			{
				$sertable='master_services';
			}
			$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mastervalue = mysqli_fetch_array($exec32);
			$currency=$mastervalue['currency'];
			$fxrate=$mastervalue['fxrate'];
			$subtype=$mastervalue['subtype'];
		
			$totalser=0;
					$totalseruhx=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and wellnessitem <> '1' group by servicesitemname,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$servicesdoctorname = $res21['doctorname'];
			$sercode=$res21['servicesitemcode'];
			$serviceledgercode=$res21['incomeledgercode'];
			$serviceledgername=$res21['incomeledgername'];
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and wellnessitem <> '1'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$res211 = mysqli_fetch_array($exec2111);
			$serqty=$res21['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			
			if($servicesfree == 'No')
			{	
			$totserrate=$res21['amount'];
			 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			/*$totserrate=$serrate*$numrow2111;*/
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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
				$totserrate=($serqty*$serrate);
			$totalser=$totalser+$totserrate;
			
			 $totserrateuhx = ($serrate*$fxrate)*$serqty;
		   $totalseruhx = $totalseruhx + $totserrateuhx;
		   $totalservicesitemrate = $totalservicesitemrate + $totserrateuhx;
			
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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $serref;?></div> </td>
               <td class="bodytext31" valign="center" align="right"><?php echo $serdate;?></td>
               <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($totalseruhx,2,'.',','); ?></div></td>
           </tr>
	<?php
		}
		}
		}
?>		
         <tr>
              <td colspan="4"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Services Charges:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalservicesitemrate,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		<!--<tr>
				<td colspan="7" align="left">
			<a href="ipunfinalservicexl.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>
			</tr>-->
          </tbody>
        </table>
        
			