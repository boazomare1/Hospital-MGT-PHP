<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$snocount = 0;


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ipdrugconsumption_xl.xls"');
header('Cache-Control: max-age=80');

if(isset($_REQUEST["cbfrmflag1"])){ $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; }else{ $cbfrmflag1 = ""; }
if(isset($_REQUEST["ADate1"])){ $reqdatefrom = $_REQUEST["ADate1"]; }else{ $reqdatefrom =  date('Y-m-d'); }
if(isset($_REQUEST["ADate2"])){ $reqdateto = $_REQUEST["ADate2"]; }else{ $reqdateto = date('Y-m-d'); }
if(isset($_REQUEST["maternityward"])){ $maternitywardname = $_REQUEST["maternityward"]; }else{ $maternitywardname =""; }
if(isset($_REQUEST["searchitemname"])){ $searchitemname = $_REQUEST["searchitemname"]; }else{ $searchitemname = ""; }
if(isset($_REQUEST["searchitemcode"])){ $searchitemcode = $_REQUEST["searchitemcode"]; }else{ $searchitemcode = ""; }
if(isset($_REQUEST["radconsumption"])){ $reportytype = $_REQUEST["radconsumption"]; }else{ $reportytype = ""; }
?>
<html>
<head>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
       
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
<body>
  <?php
  if($cbfrmflag1 == "cbfrmflag1")
  {
	  
	  
		$reqdatefrom = $_REQUEST["ADate1"];
	    $reqdateto = $_REQUEST["ADate2"];
	
	    $searchitemname = $_REQUEST["searchitemname"];
		$searchitemcode = $_REQUEST["searchitemcode"];
		
		$maternitywardname = $_REQUEST["maternityward"];
		
		$reportytype = $_REQUEST["radconsumption"];
	
	//DETAILED CONSUMTION REPORT
	if($reportytype == "raddetailed")
	{
		
	?>
       	<table style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" align="left" width="700" border="1">
          <tbody>
           	<tr>
            	<td colspan="6" valign="middle" align="center" class="bodytext33" ><strong>Detailed Drug Consumption</strong></td>
            </tr>
            <tr>
            	<td colspan="4" valign="middle" align="left" class="bodytext33">
              	 <strong>Maternity Ward : </strong><?php echo $maternitywardname;?>
               </td>
               <td colspan="2" valign="middle" align="right" class="bodytext33">
                 From <strong><?php echo $reqdatefrom; ?></strong> To <strong><?php echo $reqdateto; ?></strong>
                </td>
            </tr>
            <tr>
            	<td valign="middle" align="left" class="bodytext33"><strong>S No.</strong></td>
            	<td valign="middle" align="left" class="bodytext33"><strong>Entry Date</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Patient Name</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Reg No</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Visit No</strong></td>
                <td valign="middle" align="left" class="bodytext33"><strong>Qty</strong></td>
            </tr>
            <?php
				$sno = 0;
				$totqnty  = 0;
				$grandtotalqnty = 0;
				
				$qryitemdetails  = "SELECT a.itemcode, a.itemname FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname LIKE '%$searchitemname%' AND a.itemcode LIKE '%$searchitemcode%' AND c.ward='$maternitywardname' GROUP BY a.itemcode ORDER BY a.itemname";
				
				$execitemdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryitemdetails) or die ("Error in qryitemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resitemdetails =  mysqli_fetch_array($execitemdetails))
				{
					$itemcodesearched = $resitemdetails["itemcode"];
					$itemnamesearched =  $resitemdetails["itemname"];
				?>
                <tr>
                	<td colspan="6" valign="middle" align="left" class="bodytext31" ><strong><?php echo $itemnamesearched; ?></strong></td>
                </tr>
                <?php
					
				$qrydetailedreport = "SELECT a.entrydate,a.entrytime,a.patientcode, a.visitcode, a.patientname, a.categoryname, a.itemcode, a.itemname, a.quantity,b.visitcode,b.ward,c.ward FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname = '$itemnamesearched' AND a.itemcode = '$itemcodesearched' AND c.ward='$maternitywardname' GROUP BY b.ward,a.visitcode";
				
				$execdetailedreport  = mysqli_query($GLOBALS["___mysqli_ston"], $qrydetailedreport) or die ("Error in qrydetailedreport".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resdetailedreport =  mysqli_fetch_array($execdetailedreport))
				{
					$entrydate = $resdetailedreport["entrydate"];
					$entrytime = $resdetailedreport["entrytime"];
					$patientname = $resdetailedreport["patientname"];
					$patientcode = $resdetailedreport["patientcode"];
					$visitcode = $resdetailedreport["visitcode"];
					$itemcode = $resdetailedreport["itemcode"];
					$itemname = $resdetailedreport["itemname"];
					$quantity = $resdetailedreport["quantity"];
					$quantity = ceil($quantity);
					
					$totqnty = $totqnty + $quantity;
					
					$grandtotalqnty = $grandtotalqnty + $quantity;
			?>
             <tr>
             	<td valign="middle" align="center" class="bodytext31"><strong><?php echo $sno = $sno + 1;; ?></strong></td>
            	<td valign="middle" align="left" class="bodytext31"><strong><?php echo $entrydate; ?></strong></td>
                <td valign="middle" align="left" class="bodytext31"><strong><?php echo $patientname; ?></strong></td>
                <td valign="middle" align="left" class="bodytext31"><strong><?php echo $patientcode; ?></strong></td>
                <td valign="middle" align="left" class="bodytext31"><strong><?php echo $visitcode; ?></strong></td>
                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $quantity; ?></strong></td>
            </tr>
          <?php
				}//Inner while close
				$sno = 0;
		?>		
			<tr>
            	<td colspan="5" valign="middle" align="right" class="bodytext31"><strong>Total</strong></td>
                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $totqnty;?></strong></td>
            </tr>	
          <?php 
		   $totqnty = 0;
			}//outer while close
				?>
            <tr>
            	<td colspan="5" valign="middle" align="right" class="bodytext31"><strong>Grand Total</strong></td>
                <td valign="middle" align="right" class="bodytext31"><strong><?php echo $grandtotalqnty; ?></strong></td>
            </tr>
          </tbody>
        </table>
      
      <!--ENDS - DISPLAY REPORT-->
    <?php
	}//ENDS DETAILED CONSUMTION REPORT
	?>
    <?php
	//IF REPORT TYPE SUMMARY 
	if($reportytype == "radsummary")
	{
	?>
		
       	<table style="BORDER-COLLAPSE: collapse; margin-top:2" bordercolor="#666666" cellspacing="0" width="1000" cellpadding="4" align="left" border="1">
          <tbody>
           	<tr>
            	<td colspan="3" valign="middle" height="20" align="center" class="bodytext33" >
                <strong>Drug Consumption Summary</strong></td>
            </tr>
            <tr>
            	<td  colspan="2" valign="middle" align="left" class="bodytext33">
              	 <strong>Ward : </strong><?php echo $maternitywardname;?>
               </td>
               <td valign="middle" align="right" class="bodytext33" >
                 <strong><?php echo $reqdatefrom; ?></strong> To <strong><?php echo $reqdateto; ?></strong>
                </td>
            </tr>
            <tr>
            	<td width="30" valign="middle" align="left" class="bodytext33"><strong>SNo.</strong></td>
            	<td width="250" valign="middle" align="left" class="bodytext33"><strong>Item Name</strong></td>
                <td width="200" valign="middle" align="center" class="bodytext33"><strong>Total Qnty</strong></td>
            </tr>
            <?php
				$sno = 0;
				$totqnty  = 0;
				$grandtotalqnty = 0;
				
				$qryitemdetails  = "SELECT a.itemcode, a.itemname FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname LIKE '%$searchitemname%' AND a.itemcode LIKE '%$searchitemcode%' AND c.ward='$maternitywardname' GROUP BY a.itemcode,a.itemname ORDER BY a.itemname";
				
				$execitemdetails = mysqli_query($GLOBALS["___mysqli_ston"], $qryitemdetails) or die ("Error in qryitemdetails".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resitemdetails =  mysqli_fetch_array($execitemdetails))
				{
					$itemcodesearched = $resitemdetails["itemcode"];
					$itemnamesearched =  $resitemdetails["itemname"];
					if($itemcodesearched!='')
					{
				?>
                <tr>
                    <td valign="middle" align="center" class="bodytext31"><?php echo $sno = $sno + 1;?></td>
                	<td valign="middle" align="left" class="bodytext31"><?php echo $itemnamesearched; ?></td>
               
                <?php
					}
				$qrydetailedreport = "SELECT a.quantity FROM pharmacysales_details a JOIN ip_bedallocation b ON (a.visitcode=b.visitcode) JOIN master_ward c ON (b.ward=c.auto_number) WHERE a.entrydate BETWEEN '$reqdatefrom' AND '$reqdateto' AND a.itemname = '$itemnamesearched' AND a.itemcode = '$itemcodesearched' AND c.ward='$maternitywardname' GROUP BY b.ward,a.visitcode";
				
				
				$execdetailedreport  = mysqli_query($GLOBALS["___mysqli_ston"], $qrydetailedreport) or die ("Error in qrydetailedreport".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($resdetailedreport =  mysqli_fetch_array($execdetailedreport))
				{
					//$itemcode = $resdetailedreport["itemcode"];
					//$itemname = $resdetailedreport["itemname"];
					$quantity = $resdetailedreport["quantity"];
					
					$totqnty = $totqnty + $quantity;
					
					$grandtotalqnty = $grandtotalqnty + $quantity;
				}//Inner while close
				
		?>		
          		<td valign="middle" align="center" class="bodytext31"><?php echo $totqnty; ?></td>
            </tr>
	      <?php 
		   $totqnty = 0;
			}//outer while close
				?>
              <tr>
            	<td colspan="2" valign="middle" align="right" class="bodytext31"><strong>Grand Total</strong></td>
                <td valign="middle" align="center" class="bodytext31"><strong><?php echo $grandtotalqnty; ?></strong></td>
            </tr>
          </tbody>
        </table>
      
      <!--ENDS - DISPLAY REPORT-->
 
    <?php
	}//ENDS SUMMARY REPORT
	
	?>
    <?php
	
  
  }//close --if($cbfrmflag1 == "cbfrmflag1")
  ?>


</body>
</html>
