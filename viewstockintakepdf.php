<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}


  $docno=isset($_REQUEST['docno'])?$_REQUEST['docno']:'';
	
		
$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1emailid1= $res1['emailid1'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];

ob_start();

?>
<style>
body {
    font-family: 'Arial'; font-size:14px;	 
}
#footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height:150px; }
#footer .page:after { content: counter(page, upper-roman); }

.page { page-break-after:always; }
</style>
<?php //include("a4pdfheader1.php"); ?>	
	
	<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr>
    <td colspan="2" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">
	
	<?php
	$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
	$exec3showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query3showlogo) or die ("Error in Query3showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3showlogo = mysqli_fetch_array($exec3showlogo);
	$showlogo = $res3showlogo['showlogo'];
	if ($showlogo == 'SHOW LOGO')
	{
	?>
		
	<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
	
	<?php
	}
	?>	</td>
			
	<td align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td colspan="3" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32"><?php
	echo '<strong class="bodytext33">'.$res1companyname.'</strong>';
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($res1phonenumber1 != '')
	 {
	echo '<br><strong class="bodytext34">PHONE : '.$res1phonenumber1.'</strong>';
	 }
	echo '<br><strong class="bodytext35">E-Mail : '.$res1emailid1.'</strong>'; 
	?></td>
    <td width="6" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="761" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan='4' class="bodytext31">
              
               
                <div align="left"><strong>View Blood Issues</strong></div></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.No.</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
              <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date </strong></div></td>
              <td width="46%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User</strong></div></td>
                           
               </tr>
			<?php
			
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			
			$query1 = "select * from bloodstock where  docno='$docno'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$username = $res1['username'];
			$consultationdate = $res1['transactiondate'];
			
			
			
			?>
            <tr >
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $docno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $consultationdate;?> </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $username; ?></div></td>
        
                 </tr>
			<?php
			}    
			?>
            
           
		
            
          </tbody>
        </table></td>
      </tr>
    </table>
	</td>
	</tr>
	
  </table>
  
  <?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Viewbloodissues.pdf", array("Attachment" => 0)); 
?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

