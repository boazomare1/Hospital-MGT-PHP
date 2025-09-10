<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="IPradio.xls"');
header('Cache-Control: max-age=80');


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
            $colorloopcount ='';
			$netamount='';
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			
		//$ADate1='2015-02-01';
		//$ADate2='2015-02-28';
		?>


        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="#FFFFFF" class="bodytext31"><strong>Radiology Charge Details</strong></td>
              <td width="10%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
              </tr>            
			
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Date</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>
            </tr>

        <?php
		$totallabcharges = 0;
		$totalradiologycharges = 0;
		$query66 = "SELECT * FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res66 = mysqli_fetch_array($exec66))
		{
			$patientcode = $res66['patientcode'];
			$visitcode = $res66['patientvisitcode'];
			$consultationdate = $res66['billdate'];
		
		   $sno=$sno+1;
		  
				$totalradiologyitemrate =$res66['radiologyitemrateuhx'];
			  
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
			
		   
		   $totalradiologycharges=$totalradiologycharges+$totalradiologyitemrate;
			
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
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode;?></div> </td>
               <td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
               <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div></td>
           </tr>
	<?php
		}
?>		
         <tr>
              <td colspan="4"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Total Lab Charges:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalradiologycharges,2,'.',','); ?></strong></td>
<!--				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                
			    <?php 
				}?>
-->		
		
          </tbody>
        </table>
        
			