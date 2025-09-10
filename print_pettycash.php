<?php
ob_start();
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$colorloopcount = '';
$sno = '';
$pagebreak = '';



if (isset($_REQUEST["transactiondatefrom"])) { $transactiondatefrom = $_REQUEST["transactiondatefrom"]; } else { $transactiondatefrom = ""; }
if (isset($_REQUEST["transactiondateto"])) { $transactiondateto = $_REQUEST["transactiondateto"]; } else { $transactiondateto = ""; }





?>


	<table border="0" cellspacing="0" cellpadding="2">
	
	  <tr>
		  <td colspan="5" align="left" valign="middle" nowrap="nowrap">
		  <table width="710" border="0">
               
                <tr>
                <td colspan="8" align="left" valign="middle"><strong>&nbsp;</strong></td>
                </tr>
                <tr>
                <td colspan="8" align="left" valign="middle"><strong>&nbsp;</strong></td>
                </tr>
                <tr>
                <td colspan="8" align="left" valign="middle"><strong>&nbsp;</strong></td>
                </tr>
                <tr>
                <td colspan="8" align="left" valign="middle"><strong>&nbsp;</strong></td>
                </tr>
                <img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="75" />  
                 <tr align="center">
               <td colspan="8" align="center"><h3 align="center">PETTY CASH</h3>
                </td>
            </tr>
			      <tr>
                <td colspan="8"  align="left" valign="middle"><strong>&nbsp;</strong></td>
                </tr>
              
                
            <tr>
                
				<td width="42" align="right" valign="middle"><strong>No.</strong></td>
				<td width="64" align="right" valign="middle"><strong>Docno.</strong></td>
                
				<td width="143" align="right" valign="middle"><strong>Transaction Date</strong></td>
                <td width="124" align="right" valign="middle"><strong>Ledger Name</strong></td>
				<td width="103" align="right" valign="middle"><strong>Ledger Code</strong></td>
                <td width="98" align="right" valign="middle"><strong>Cr Amount </strong></td>
				<td width="106" align="right" valign="middle"><strong>Dr Amount</strong></td>
                    
			</tr>
           
           <?php 
		     $query32 = "select docno from master_journalentries where docno like 'PCR-%' and entrydate between '$transactiondatefrom' and '$transactiondateto' group by docno  ";
			$exe32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sno=0;
			while($res32 = mysqli_fetch_array($exe32))
			{
		
			 $docno1=$res32['docno']; 
				
                  $query31 = "select username,ledgername,entrydate,ledgerid,creditamount,debitamount,docno from master_journalentries where docno='$docno1' and selecttype='Cr' and entrydate between '$transactiondatefrom' and '$transactiondateto'  ";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($res31 = mysqli_fetch_array($exe31))
			{
					$sno=$sno+1;
				$username = $res31["username"];
			    $res21username = $res31["ledgername"];
			    $entrydate = $res31["entrydate"];
			   $ledgerid = $res31["ledgerid"];
			   $ccreditamount = $res31["creditamount"];
			   $cdebitamount = $res31["debitamount"];
			   ?>
               
			    <tr>
             <td width="42" class="bodytext31" valign="center"  align="right"><?php echo $sno; ?></td>
              <td width="64" class="bodytext31" valign="center"  align="right"><?php  echo $docno1; ?></td>
            
             <td width="143" class="bodytext31" valign="center"  align="right"><?php echo $entrydate; ?></td>
             <td width="124" class="bodytext31" valign="center"  align="right"><?php echo $res21username; ?></td>
             <td width="103"  class="bodytext31" valign="center"  align="right"><?php echo $ledgerid; ?></td>
             <td width="98" class="bodytext31" valign="center"  align="right"><?php echo number_format($ccreditamount,2,'.',','); ?></td>
             <td width="106" class="bodytext31" valign="center"  align="right"><?php echo number_format($cdebitamount,2,'.',','); ?></td>
             </tr>
             <?php
			}
			$query33 = "select username,ledgername,entrydate,ledgerid,creditamount,debitamount,docno from master_journalentries where docno='$docno1' and selecttype='Dr' and entrydate between '$transactiondatefrom' and '$transactiondateto'  ";
			$exe33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($res33 = mysqli_fetch_array($exe33))
			{
					$sno=$sno+1;
				  $docno = $res31["docno"];
				 $username = $res33["username"];
			     $res21username = $res33["ledgername"];
			    $entrydate = $res33["entrydate"];
			   $ledgerid = $res33["ledgerid"];
			   $dcreditamount = $res33["creditamount"];
			   $ddebitamount = $res33["debitamount"];
			    ?>
                
			<tr>
               <td width="42"  class="bodytext31" valign="center"  align="right"><?php echo $sno; ?></td>
               <td  width="64"  class="bodytext31" valign="center"  align="right"><?php echo $docno1; ?></td>
            
             <td  width="143"  class="bodytext31" valign="center"  align="right"><?php echo $entrydate; ?></td>
             <td  width="124"  class="bodytext31" valign="center"  align="right"><?php echo $res21username; ?></td>
             <td  width="103"  class="bodytext31" valign="center"  align="right"><?php echo $ledgerid; ?></td>
             <td  width="98"  class="bodytext31" valign="center"  align="right"><?php echo number_format($dcreditamount,2,'.',','); ?></td>
             <td  width="106"  class="bodytext31" valign="center"  align="right"><?php echo number_format($ddebitamount,2,'.',','); ?></td>
             
              </tr>
			  <?php  }
			 ?>
                
			
				<?php   } ?> 
           <tr>
           <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
           </tr>
             <tr>
           <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
           </tr>  
		<tr>
        <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
        <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		<td colspan="" class="bodytext31" valign="center"  align="right">&nbsp;</td>
	    <td colspan="2" class="bodytext31" valign="center"  align="right"><strong>Grand Total :</strong> </td>
        <?php $total=$ccreditamount - $ddebitamount; ?>
		<td class="bodytext31" valign="center"  align="right"><?php echo number_format($total,2,'.',','); ?></td>
  	    </tr>
         <tr>
           <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
           </tr>
            <tr>
           <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
           </tr>
            <tr>
           <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
           </tr>	
            <tr>
            <td align="left" colspan="3" valign="middle"><strong>Sign : .............................................</strong></td>
            <td align="left" valign="middle"><strong></strong></td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="left" colspan="3" valign="middle"><strong>Printed On : <?php echo $indiandatetime; ?></strong></td>
            </tr>
        </table></td>
		   
	
				
	  </tr>
	
	
</table>

		<!--<tr>
			<td align="left" valign="middle" class="bodytext32">Results Posted By:
			<input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><strong><?php //echo strtoupper($_SESSION['username']); ?></strong></td>
		</tr>-->
	
<?php
    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('LabResultsFull.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
