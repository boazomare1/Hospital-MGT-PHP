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
			if (isset($_REQUEST["acc_id"])) { $acc_id = $_REQUEST["acc_id"]; } else { $acc_id = ""; }
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="686" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31"><strong>Private Doctor Charge Details</strong></td>
              <td width="21%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>            
			
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Date</td>
              <td width="15%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
              <td width="38%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doctor</td>
              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>
            </tr>

        <?php
		
		 $query4 = "SELECT * FROM billing_ipprivatedoctor WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in(select visitcode from master_ipvisitentry where accountname ='$acc_id')";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$totalprivatedoctorcharges='0.00';
		while($res4 = mysqli_fetch_array($exec4))
		{
		$totalprivatedoctoramount=$res4['amountuhx'];
		
		$transfferdate=$res4['recorddate'];
		//$dischargeddate=$res13['dischargeddate'];
		$docno=$res4['docno'];
		$visitcode=$res4['visitcode'];
		$doctorname=$res4['doctorname'];
		$doctorname=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $doctorname);
		  // $bedtransferanum = $res13['bed'];
		   
		   $sno=$sno+1;
		   
		   
		   $totalprivatedoctorcharges=$totalprivatedoctorcharges+$totalprivatedoctoramount;
			
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
               <td class="bodytext31" valign="center" align="left"><?php echo $transfferdate;?></td>
               <td class="bodytext31" valign="center" align="left"><?php echo $visitcode;?></td>
               <td class="bodytext31" valign="center" align="left"><?php echo $doctorname;?></td>
               
            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>
           </tr>
	<?php
		}
?>		
         <tr>
              <td colspan="5"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Private Doctor Charges:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalprivatedoctorcharges,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		<!--<tr>
				<td colspan="7" align="left">
			<a href="detailsipprivatedoctorxl.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>
			</tr>-->
          </tbody>
        </table>
        
			