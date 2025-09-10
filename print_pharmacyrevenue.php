<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];

$colorloopcount = '';
$sno = '';
$snocount = 0;
$total='';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="pharmacyrevenue.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }


?>
</head>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td width="1000">
		  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1231" 
            align="left" border="0">
          <tbody>
		 

		 <tr> <td colspan="6" align="center"><strong><u><h3>PHARMACY REVENUE REPORT</h3></u></strong></td><tr></tr>
		
		  <tr ><td colspan="6" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
		  
	
			
			

			        
		<tr>
              <td width="108"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
              <td width="154" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
              
            </tr>
			
			<?php
				
		 $query661=  "select sum(fxamount) as sumamount from billing_paynowpharmacy where  billdate between '$ADate1' and '$ADate2'";
		  $exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res661 = mysqli_fetch_array($exec661);
		  
		   $amount= $res661['sumamount'];
		  
		  $query6611 = "select sum(fxamount) as sumamount1 from billing_paylaterpharmacy  where billdate between '$ADate1' and '$ADate2'";
		  $exec6611 = mysqli_query($GLOBALS["___mysqli_ston"], $query6611) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6611 = mysqli_fetch_array($exec6611);
		  $amount1 = $res6611['sumamount1'];
		  
		  $totallopamount = $amount + $amount1;
		  
		   $query663 = "select sum(amountuhx) as sumamount2  from billing_ippharmacy where billdate between '$ADate1' and '$ADate2'";
		  $exec663 = mysqli_query($GLOBALS["___mysqli_ston"], $query663) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res663 = mysqli_fetch_array($exec663);
		  $ipamount = $res663['sumamount2'];
		   
		  $query6647 = "select sum(amount) as sumrate from billing_externalpharmacy where billdate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysqli_query($GLOBALS["___mysqli_ston"], $query6647) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6647 = mysqli_fetch_array($exec6647);
		  $externalrate = $res6647['sumrate'];
		  
		  $totalpharmacysales = $totallopamount + $ipamount + $externalrate ;
		 
		  $query665=  "select sum(amount) as sumtransactionamount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2'";
		  $exec665 = mysqli_query($GLOBALS["___mysqli_ston"], $query665) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res665 = mysqli_fetch_array($exec665);
		  
		   $sumtransactionamount= $res665['sumtransactionamount'];
		  
		  $query6651 = "select sum(amount) as sumtransactionamount1 from refund_paylaterpharmacy  where billdate between '$ADate1' and '$ADate2'";
		  $exec6651 = mysqli_query($GLOBALS["___mysqli_ston"], $query6651) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6651 = mysqli_fetch_array($exec6651);
		  $sumtransactionamount1 = $res6651['sumtransactionamount1'];
		  
		  $query667=  "select sum(amount) as sumtransactionamount2 from paylaterpharmareturns where billdate between '$ADate1' and '$ADate2'";
		  $exec667 = mysqli_query($GLOBALS["___mysqli_ston"], $query667) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res667 = mysqli_fetch_array($exec667);
		  
		   $sumtransactionamount2= $res667['sumtransactionamount2'];
		
		  
		  $totallsumtransactionamount = $sumtransactionamount + $sumtransactionamount1;
		  $totallsumtransactionamount2=$totallsumtransactionamount+$sumtransactionamount2;
		  $nettotalamount=$totalpharmacysales - $totallsumtransactionamount2;
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
           <tr >
              <td class="bodytext31" valign="center"  align="left">OP Sales</td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totallopamount,2,'.',','); ?></div></td>
            
             
           </tr>
			<?php
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
			<tr >
              <td class="bodytext31" valign="center"  align="left">IP Sales</td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($ipamount,2,'.',','); ?></div></td>
              
             
           </tr>
		   <?php
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
			<tr >
              <td class="bodytext31" valign="center"  align="left">External Sales</td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($externalrate,2,'.',','); ?></div></td>   
           </tr>
		    <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totalpharmacysales,2,'.',','); ?></strong></div></td>   
           </tr>
		    <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31">OP Returns</td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totallsumtransactionamount,2,'.',','); ?></div></td>   
           </tr>
          <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31">Ext Returns</td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($sumtransactionamount2,2,'.',','); ?></div></td>   
           </tr>
		     <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totallsumtransactionamount2,2,'.',','); ?></strong></div></td>   
           </tr>
		        <?php
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
			<tr >
              <td  align="left" valign="center" class="bodytext31"><strong>Net Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($nettotalamount,2,'.',','); ?></strong></div></td>   
           </tr>
       
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
 			
             
            </tr>
			
            

          </tbody>
        </table>
		</td>
      </tr>
    </table>
</table>
</body>
</html>

