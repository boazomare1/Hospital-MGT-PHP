<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$totalamount="0.00";

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
$adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res40 = mysqli_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}

include ("autocompletebuild_customeripbilling.php");
?>


 	  
<style>
.bodytext311{FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; text-decoration:none
}
</style>
		
<?php
	$colorloopcount=0;
	$sno=0;
	
	$patientcode = $_REQUEST['patientcode'];
	$visitcode = $_REQUEST['visitcode'];
    $docnumber = $_REQUEST['docnumber'];
	
	$query39 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res39 = mysqli_fetch_array($exec39);
           $res39visitcode = $res39['visitcode'];
		   $res39patientname = $res39['patientname'];
	
		
?>
      <table cellspacing="0" cellpadding="4" width="687" align="center" border="0">
		<tr>
		  <td  colspan="9" align="center" class="bodytext311">&nbsp;</td>
		</tr>
		<tr>
		  <td  colspan="9" align="center" class="bodytext311">&nbsp;</td>
		</tr>
       <tr>
			<?php 
				$query2 = "select * from master_company where auto_number = '$companyanum'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2 = mysqli_fetch_array($exec2);
				$companyname = $res2["companyname"];
				$address1 = $res2["address1"];
				$address2 = $res2["address2"];
				$area = $res2["area"];
				$city = $res2["city"];
				$pincode = $res2["pincode"];
				$phonenumber1 = $res2["phonenumber1"];
				$phonenumber2 = $res2["phonenumber2"];
				$tinnumber1 = $res2["tinnumber"];
				$cstnumber1 = $res2["cstnumber"];
			?>
			<td colspan="9" class="bodytext311">
			  <div align="center">
			    <?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>			
	        </div></td>
        </tr>
		<tr>
			<td colspan="9" class="bodytext311"><div align="center"><?php echo $companyname; ?> 
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
			<td colspan="9" class="bodytext311"><div align="center"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
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
			<td colspan="9" class="bodytext311">
			
			  <div align="center"><?php echo $address2; ?>
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
		    <tr>
		      <td  colspan="9" align="center" class="bodytext311">&nbsp;</td>
        </tr>
		    <tr>
      <td  colspan="9" align="center" class="bodytext311"><strong><?php echo $res39patientname;  ?>-<?php echo $patientcode; ?>-<?php echo $res39visitcode; ?></strong></td>
    </tr>
    
            <tr>
              <td colspan="9"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext311">&nbsp;</td>
            </tr>
        <tr>
		  <td width="6%" class="bodytext311" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>S.No.</strong></td>
		  <td width="9%" class="bodytext311" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>Date</strong></td>
		  <td width="10%" class="bodytext311" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>Ref No</strong></td>
		  <td width="16%" class="bodytext311" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>Medicine</strong></td>
		  <td width="9%" class="bodytext311" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>Issues</strong></td>
					<td width="9%" class="bodytext311" valign="center"  align="left" 
					bgcolor="#ffffff"><strong>Returns</strong></td>
		  <td width="10%"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext311"><strong>Rate</strong></td>
		  <td width="20%"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext311"><strong>Free</strong></td>
		  <td width="11%"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext311"><strong>Amount </strong></td>
    </tr>
	
	 <?php
		   $query34 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $itemname = $res34['itemname'];
		   $quantity = $res34['quantity'];
		   $docno = $res34['docno'];
		   $res34date = $res34['date'];
		   $rateperunit = $res34['rateperunit'];
		   $totalrate = $res34['totalrate'];
		   $freestatus = $res34['freestatus'];
		   $totalamount = $totalamount + $totalrate;
		   

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
		  <td class="bodytext311" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo  date("d/m/Y", strtotime($res34date)); ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo $docno; ?></td>
		  <td width="16%" class="bodytext311" valign="center"  align="left"><?php echo $itemname; ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo intval($quantity); ?></td>
		  <td class="bodytext311" valign="center"  align="left">&nbsp;</td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo $rateperunit; ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo $freestatus; ?></td>
		  <td  align="left" valign="center" class="bodytext311"><?php echo number_format($totalrate,2,'.',','); ?></td>
	 </tr>
      <?php } ?>
	  	 <?php
		  
		 
           $query341 = "select * from pharmacysalesreturn_details where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res341 = mysqli_fetch_array($exec341))
		   {
		  
		   $patientcode = $res341['patientcode'];
		   $visitcode = $res341['visitcode'];
		   $itemname = $res341['itemname'];
		   $docno = $res341['billnumber'];
		   $quantity = $res341['quantity'];
		   $res34date = $res341['entrydate'];
		   $rateperunit = $res341['rate'];
		   $totalrate = $res341['totalamount'];
		   
		   $totalamount = $totalamount - $totalrate;
		   

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
		  <td class="bodytext311" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo  date("d/m/Y", strtotime($res34date)); ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo $docno; ?></td>
		  <td width="16%" class="bodytext311" valign="center"  align="left"><?php echo $itemname; ?></td>
		  <td class="bodytext311" valign="center"  align="left">&nbsp;</td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo intval($quantity); ?></td>
		  <td class="bodytext311" valign="center"  align="left"><?php echo $rateperunit; ?></td>
		  <td class="bodytext311" valign="center"  align="left">&nbsp;</td>
		  <td  align="left" valign="center" class="bodytext311">-<?php echo number_format($totalrate,2,'.',','); ?></td>
	 </tr>

			<?php } ?>			



      <tr>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
        <td class="bodytext3111" valign="center">&nbsp;</td>
      </tr>
      <tr>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center"><strong>Total</strong></td>
      <td class="bodytext3111" valign="center">&nbsp;</td>
      <td class="bodytext3111" valign="center"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
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
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printipdrugstatement.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
