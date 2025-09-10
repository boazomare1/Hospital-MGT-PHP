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
header('Content-Disposition: attachment;filename="dispatchreport.xls"');
header('Cache-Control: max-age=80');
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }


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
		  <tr>	  <td width="111" rowspan="4" colspan="2" align="left">

			 <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3showlogo = mysqli_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			
      echo '<img src="logofiles/<?php echo $companyname; ?>.jpg" width="238" height="75" />';
    
			}
	?></td>
		 <tr> <td colspan="4" align="center"><strong><u><h3>DISPATCH REPORT</h3></u></strong></td><tr></tr>
		 <tr> <td colspan="4" align="center"><strong><h4><?php echo $searchsuppliername ?></h4></strong></td>
		  </tr>
		  <tr ><td colspan="6" align="center"><strong>Date From:    <?php echo $ADate1 ?>   To:  <?php echo $ADate2 ?></strong></td></tr>
		  
	
			
			<tr>
				<td width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></td>
				<td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Reg.No</strong></td>
				<td width="16%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Patient</strong></td>
				<td width="15%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Bill No</strong></td>
				<td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Bill Date</strong></td>
				<td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Amount</strong></td>
				</tr>
			
			<?php
			

			        
			$query25 = "select * from master_subtype where subtype = '$searchsuppliername'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$searchsubtypeanum1 = $res25['auto_number'];
			
			$query21 = "select * from master_accountname where subtype = '$searchsubtypeanum1' and recordstatus <> 'DELETED' order by subtype desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select * from billing_paylater where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['accountname'];
			
			$query23 = "select * from billing_ip where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2'"; 
		    $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res23 = mysqli_fetch_array($exec23);
			$res23accountname = $res23['accountname'];
			
			$query24 = "select * from billing_ipcreditapproved where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2'"; 
		    $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res24 = mysqli_fetch_array($exec24);
			$res24accountname = $res24['accountname'];
			
			if( $res22accountname != '' || $res23accountname != '' || $res24accountname != '')
			{
			?>
			<?php
			$query6 = "select * from print_deliverysubtype where accountname = '$res21accountname' and subtype = '$searchsuppliername' and status <> 'deleted'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			
			$res6accountname = $res6['accountname'];
			if($res6accountname != '')
			{
			?>	
			<!--<tr bgcolor="#ecf0f5">
            <td colspan="6"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
            </tr>-->
			<?php
			}
			?>
			<?php
			
		  $query2 = "select * from billing_paylater where accountname = '$res22accountname' and billdate between '$ADate1' and '$ADate2' group by billno order by accountname, billdate desc"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
          $res2totalamount = $res2['totalamount'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  $res2accountname = $res2['accountname'];
		  
		  $query6 = "select * from print_deliverysubtype where accountname = '$res22accountname' and billno = '$res2billno' and subtype = '$searchsuppliername' and status <> 'deleted' group by billno";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
			
		  $res6billnumber = $res6['billno'];
		  
		  if($res6billnumber == $res2billno)
		  {
		  
		  $total = $total + $res2totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
					
			
	
			?>
           <tr >
			  <td height="28"  align="left" valign="center" class="bodytext31"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res2patientcode; ?>">
				<?php echo $res2patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res2patientname; ?>">
				<?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res2billno; ?>">
			  <?php echo $res2billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res2billdate; ?>">
				<?php echo $res2billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res2accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res2totalamount; ?>">
			  <?php echo number_format($res2totalamount,2,'.',','); ?></div></td>
               </tr>
			<?php
			}
			}
			
		  $query3 = "select * from billing_ip where accountname = '$res23accountname' and billdate between '$ADate1' and '$ADate2' group by billno order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];
		
		  $query6 = "select * from print_deliverysubtype where accountname = '$res23accountname' and billno = '$res3billno' and subtype = '$searchsuppliername' and status <> 'deleted' group by billno";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
			
		  $res6billnumber = $res6['billno'];
		  
		  if($res6billnumber == $res3billno)
		  {
		  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
				
			
	
			?>
           <tr >
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">


			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              </tr>
			<?php
			}
			}
			
			
			 $query3 = "select * from billing_ipcreditapproved where accountname = '$res24accountname' and billdate between '$ADate1' and '$ADate2' group by billno order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];

		  $query6 = "select * from print_deliverysubtype where accountname = '$res24accountname' and billno = '$res3billno' and subtype = '$searchsuppliername' and status <> 'deleted' group by billno";
		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res6 = mysqli_fetch_array($exec6);
			
		  $res6billnumber = $res6['billno'];
		  
		  if($res6billnumber == $res3billno)
		  {
		  
		  
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
				
			
			?>
           <tr >
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
             </tr>
			<?php
			}
			}
			}
			}
			
			?>
            <tr>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                ><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                ><div align="left"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
              <?php if($total != 0.00) { ?>	
               <?php } ?>
			  
			</tr>
			<tr>
			</tr>
			<tr>
			</tr>
			<tr>
			 <td><strong>Sign</strong></td>
				</tr>		
			<tr>
              <td colspan="7" class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="subtype" id="subtype" value="<?php echo $searchsuppliername; ?>">
			  <input type="hidden" name="printno" id="printno" value="<?php echo $printnumber; ?>">
		   <?php 
			
			 
           ?>
          </tbody>
        </table>
		</td>
      </tr>
    </table>
</table>
</body>
</html>

