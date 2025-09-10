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
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><strong>Bed Transfer Charge Details</strong></td>
              <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>            
			
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Transffer Date</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>
            </tr>

        <?php
		
		 $query13 ="SELECT * FROM ip_bedtransfer WHERE visitcode in (select visitcode from `billing_ip`) and recorddate<='$ADate1' and recorddate BETWEEN '$ADate1' and '$ADate2'";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num13=mysqli_num_rows($exec13);
		$totalbedtransfercharges='0.00';
		while($res13= mysqli_fetch_array($exec13))
		{
		$transfferdate=$res13['recorddate'];
		//$dischargeddate=$res13['dischargeddate'];
		$docno=$res13['docno'];
		$visitcode=$res13['visitcode'];
		   $bedtransferanum = $res13['bed'];
		   
		   $sno=$sno+1;
		   
		   $query501 = "select bedcharges from master_bed where auto_number='$bedtransferanum'";
		   $exec501 = mysqli_query($GLOBALS["___mysqli_ston"], $query501) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res501 = mysqli_fetch_array($exec501);
		   $bedcharges = $res501['bedcharges'];
		   
		   $totalbedtransfercharges=$totalbedtransfercharges+$bedcharges;
			
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
                <div class="bodytext31"><?php echo $docno;?></div> </td>
               <td class="bodytext31" valign="center" align="right"><?php echo $transfferdate;?></td>
               <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($bedcharges,2,'.',','); ?></div></td>
           </tr>
	<?php
		}
?>		
         <tr>
              <td colspan="4"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Bed Transfer Charges:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalbedtransfercharges,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		
<tr>
				<td colspan="7" align="left">
			<a href="detailviewipbedtransferchargesxl.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>
			</tr>
          </tbody>
        </table>
        
			