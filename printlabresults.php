<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';

ob_start();
?>

<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
?>
<?php
  if($patientcode != 'walkin') 
   {
 $query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));
$res65=mysqli_fetch_array($exec65);
$Patientname=$res65['patientfullname'];   
   }
  else
  {
$query165= "select * from resultentry_lab where docnumber= '$docnumber' ";
$exec165=mysqli_query($GLOBALS["___mysqli_ston"], $query165) or die("error in query165".mysqli_error($GLOBALS["___mysqli_ston"]));
$res165=mysqli_fetch_array($exec165);
$Patientname=$res165['patientname'];
  }

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);
$res70=mysqli_fetch_array($exec70);
$accountname=$res70['accountname'];
?>

	<table width="59%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="5"><div align="center"><?php echo $companyname; ?>
			<?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
			</div></td>
		</tr>
		<tr>
			<td colspan="5"><div align="center"><?php echo $address1; ?>
			<?php
			$address2 = $area.' '.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			</div></td>
		</tr>
		<tr>
			<td colspan="5">
			<div align="center">
			<?php echo $address2; ?>
			<?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
			</div></td>       
		</tr>
	
		<tr >
		  <td>&nbsp;</td>
		  <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
		  <td >&nbsp;</td>
		  <td >&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr >
			<input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
			<td><strong>Patient* </strong></td>
			<td width="9%" align="left" valign="middle" nowrap="nowrap">
			<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?></td>
			<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">&nbsp;</td>
			
			<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
			<td width="68%"><?php echo $dateonly1; ?>				
			<input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" /></td>
		</tr>
		<?php if($patientcode != 'walkin') { ?>
		<tr>
					
					 <td width="11%" align="left" valign="middle" nowrap="nowrap"><strong>Patient Code</strong></td>
					<td align="left" valign="top" >
					<input name="customercode" type="hidden" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?></td>
					<td width="12%" ><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5">&nbsp;</td>
					<td align="left" valign="top" ><strong>Account</strong></td>                
					<td align="left" valign="top" ><input name="account" type="hidden" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				  <?php echo $accountname; ?></td>	
	  </tr> 
	  <?php }  ?>
	</table>
				  
					
		<table width="569" border="0" cellspacing="0" cellpadding="2">
		<tr>
				<td align="left" valign="middle"   ><strong>&nbsp;</strong></td>
		  </tr>	
			<tr>
				<td width="200" class="bodytext366" valign="center"  align="left">
			    Test</td>
				
				<td width="200" class="bodytext366" valign="center"  align="left" 
				bgcolor="#ffffff">Reference</td>
				<td width="200" class="bodytext366" valign="center"  align="left">Results</td>
			</tr>
				<?php
				$query31="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber='$docnumber' ";
				$exec31=mysqli_query($GLOBALS["___mysqli_ston"], $query31);
				$num=mysqli_num_rows($exec31);
				$item=1;
				while($res31=mysqli_fetch_array($exec31))
				{ 
				$labname1=$res31['itemname'];
				$itemcode2=$res31['itemcode'];
				
				$itemname=$res31['itemname'];
				
				$referencename=$res31['referencename'];
				$referencerange=$res31['referencerange'];
				$resultvalue=$res31['resultvalue'];
				?>		  
</table>
			
			
			<table width="568" border="0" cellspacing="0" cellpadding="2">
		         <tr>
				   <td width="200" class="bodytext366" valign="center"  align="left" 
					bgcolor="#ffffff" nowrap="nowrap"><strong><?php if($item==1) echo $itemname;  $item++; ?></strong></td>             
				</tr>
</table>
			
			<table width="200" border="1" cellspacing="0" cellpadding="2">
	         <tr> 
			   <td width="200" class="bodytext366" valign="center"  align="left" 
				bgcolor="#ffffff"><?php echo $referencename; ?></td>             
				<td width="200" class="bodytext366" valign="center"  align="left" 
				bgcolor="#ffffff"><?php echo $referencerange; ?></td>             
				<td width="100" class="bodytext31" valign="center"  align="left"><?php echo $resultvalue; ?></td>              
			 </tr>
		
			 <?php
			 }
			 ?>
</table>
					<table width="200" border="0" cellspacing="0" cellpadding="2">
				 <tr>
				 <td>&nbsp;</td>
				 </tr>	

		         <tr>
					<td align="left" valign="middle" class="bodytext32">Results Posted By:
					<input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><strong><?php echo strtoupper($_SESSION['username']); ?></strong></td>
				</tr>
</table>
	
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
        $html2pdf->Output('printlabresult.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>