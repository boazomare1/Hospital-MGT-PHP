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
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext31"><strong>Pharmacy Return  Details</strong></td>
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
			$totalpharmacysaleamount=0;
			$totalquantity = 0;
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
		//$ADate1='2015-01-31';
		//$ADate2='2015-02-28';
		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2' and accountname = '$acc_id'";
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
		
			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			 $phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$quantity=$res23['quantity'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$amount=$pharate*$quantity;
			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
   			$quantity=$phaquantity;
			$amount=$pharate*$quantity;
			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res331 = mysqli_fetch_array($exec331);
			
			$quantity1=$res331['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			
			
			$resquantity = $quantity1;
			$resamount = $amount;
						
			$resamount=number_format($resamount,2,'.','');
			//if($resquantity != 0)
			{
			if($pharmfree =='No')
			{
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
			
			$resamount=$resquantity*($pharate/$fxrate);
			$totalpharm=$totalpharm+$resamount;
			
			 $resamountuhx = $pharate*$resquantity;
			 $resamountreturnuhx = $pharate*$quantity1;
		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;
			$totalpharmacysaleamount = $totalpharmacysaleamount + $resamountuhx;
			
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
                <div class="bodytext31"><?php echo $refno;?></div> </td>
               <td class="bodytext31" valign="center" align="right"><?php echo $phadate;?></td>
               <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31">-<?php echo number_format($resamountuhx,2,'.',','); ?></div></td>
           </tr>
	<?php
		}
		}
			  }
			  }
?>		
         <tr>
              <td colspan="4"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Pharmacy Return Amount</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong>-<?php echo number_format($totalpharmacysaleamount,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		<!--<tr>
				<td colspan="7" align="left">
			<a href="ipunfinalpharmacyreturnxl.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>
			</tr>-->
          </tbody>
        </table>
        
			