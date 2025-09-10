<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";


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


?>

<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

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

<script>



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}

function funcvalidation()
{
//alert('h');
if(document.getElementById("readytodischarge").checked == false)
{
alert("Please Click on Ready To Discharge");
return false;
}

}
</script>


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

<body>
<form name="form1" id="form1" method="post" action="ipinteriminvoice.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
						  <td colspan="7" class="bodytext31" bgcolor="#ecf0f5"><strong>IP Interim Invoice</strong></td>
						</tr>
            <tr>
              
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		
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
             
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="6" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
        <td>&nbsp;</td>
		</tr>
	<tr>
	
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td width="60%">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
			 
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
		
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
			$totalop=$consultationfee;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
				
           	</tr>
				
			<?php 
			$totalbedallocationamount = 0;
			$packageamount = 0;
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$ward = $res18['ward'];
			$allocateward = $res18['ward'];
			
			$bed = $res18['bed'];
			$refno = $res18['docno'];
			$date = $res18['recorddate'];
			$bedallocateddate = $res18['recorddate'];
			$packagedate = $res18['recorddate'];
			$newdate = $res18['recorddate'];
			
			
			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from master_bed where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			$query91 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num91 = mysqli_num_rows($exec91);
			while($res91 = mysqli_fetch_array($exec91))
		   {
		   $charge = $res91['charge'];
		   $rate = $res91['rate'];
		   
		   if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
		    $query181 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode' and recordstatus='transfered'";
			$exec181 = mysqli_query($GLOBALS["___mysqli_ston"], $query181) or die ("Error in Query181".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num181 = mysqli_num_rows($exec181);
			if($num181 > 0)
			{
			$query79 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res79 = mysqli_fetch_array($exec79);
			$date1 = $res79['recorddate'];
			$diff = abs(strtotime($date1) - strtotime($date));
			}
			else
			{		
		    $diff = abs(strtotime($date) - strtotime($updatedate));
			}
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$allocatedate = $date;
			$allocate1date = $date;
		
		if($days <= $packdays)
			{
			
			$quantity = $days + 1;
			}
			
			if($days > $packdays)
			{
		
			$days = $days - $packdays;

		   $quantity = $days + 1;
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			 
			 }
			 if($packdays == 0)
			 {
			 if($days == 0)
			 {
			 

		   $quantity = $days + 1;
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			 }
			 }
			 }
			  ?>
			  <?php
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			$packageamount = $res741['rate'];
			
			if($packageanum1 != 0)
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
			  ?>
			   <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			  <?php 
			  $snno =0;
			 
			  $totalbedtransferamount = 0;
			  $diff5 = 0;
			  $newdate = '';
				
			 
			$query128 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num128 = mysqli_num_rows($exec128);
			while($res128 = mysqli_fetch_array($exec128))
			{
			$snno = $snno + 1;
			$ward = $res128['ward'];
			$bed = $res128['bed'];
			$refno = $res128['docno'];
			$date = $res128['recorddate'];
			
			$newdate = $res128['recorddate'];
			$transferanum = $res128['auto_number'];
			
		    $datediff = abs(strtotime($bedallocateddate) - strtotime($date));
			$years5 = floor($datediff / (365*60*60*24));
			$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
			$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			
			$newpackdays = $packdays - $days5;
			if($newpackdays > 0)
			{
		    $date = date('Y-m-d',strtotime($date) + (24*3600*$newpackdays));
			}
		
			
			   $query512 = "select * from master_bed where auto_number='$bed'";
			   $exec512 = mysqli_query($GLOBALS["___mysqli_ston"], $query512) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			   $res512 = mysqli_fetch_array($exec512);
			   $bedname = $res512['bed'];
			   $threshold = $res512['threshold'];
			   $thresholdvalue = $threshold/100;
			   
			$query912 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec912 = mysqli_query($GLOBALS["___mysqli_ston"], $query912) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num912 = mysqli_num_rows($exec912);
			while($res912 = mysqli_fetch_array($exec912))
		    {
		    $charge = $res912['charge'];
		    $rate = $res912['rate'];
		   
		  	 if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
			$query66 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and auto_number > '$transferanum' order by auto_number asc limit 0,1";
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res66 = mysqli_fetch_array($exec66);
			$date1 = $res66['recorddate'];
			
		    $diff = abs(strtotime($date1) - strtotime($date));
			
			if($num128 == $snno)
			{
			$query81 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num81 = mysqli_num_rows($exec81);
			if($num81 > 0)
			{
			$res81 = mysqli_fetch_array($exec81);
			$date1 = $res81['recorddate'];
			
			$diff = abs(strtotime($date1) - strtotime($date));
		
			}else
			{
		 	$diff = abs(strtotime($updatedate) - strtotime($date));
			
			}
			}
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$query811 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec811 = mysqli_query($GLOBALS["___mysqli_ston"], $query811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num811 = mysqli_num_rows($exec811);
		
			if($num811 > 0)
			{
			$date12 = $res811['recorddate'];
				if($packageanum1 != 0)
			{
			$diff5 = abs(strtotime($date12) - strtotime($packagedate));
			}
			}
			else
			{
					if($packageanum1 != 0)
			{
		    $diff5 = abs(strtotime($updatedate) - strtotime($packagedate));
			}
			}
			$years5 = floor($diff5 / (365*60*60*24));
			$months5 = floor(($diff5 - $years5 * 365*60*60*24) / (30*60*60*24));
			$days5 = floor(($diff5 - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			if(($days5 > $packdays))
			{
			if($allocateward == $ward)
			{
			if($allocatedate != '')
			{
				if($allocatedate == $allocate1date)
			{
			 $quantity = $quantity - 1;
			 if($packageanum1 != 0)
			 {
			 $quantity = $quantity + $packdays;
			 }
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 }
				if($transdate == $newdate)
		{
		$days = $days - 1;
		}
		}
		   $quantity = $days + 1;
		   
		   if($quantity != 0)
		   {
		  
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $newdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			if($packageanum1 == 0)
			{
			 if($days5 == 0)
			 {
			 			if($allocateward == $ward)
			{
			if($allocatedate != '')
			{
			if($allocatedate == $allocate1date)
			{
			 $quantity = $quantity - 1;
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 }
			
		if($transdate == $newdate)
		{
		$days = $days - 1;
		}
		}
		   $quantity = $days + 1;
		   
		   if($quantity != 0)
		   {
		  
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $newdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			}
			 }
			$allocatedate = $newdate;
			$allocateward = $ward;
			 }
			  ?>
			 
			   <?php 
			$totalpharm=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$refno = $res23['ipdocno'];
			 $query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
						
			$phaamount=number_format($phaamount,2,'.','');
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
			$totalpharm=$totalpharm+$phaamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $phaamount; ?></div></td>
		     
			  
			  <?php }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
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
			$totallab=$totallab+$labrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
		       
			  
			  <?php }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> ''";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
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
			$totalrad=$totalrad+$radrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			  ?>
			  	    <?php 
					
					$totalser=0;
			  $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
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
			$totalser=$totalser+$serrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			  ?>
			
			  <?php 
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			  ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong></strong></td>
			 </tr>
          </tbody>
        </table>		</td>
	</tr>
	<tr>
	  <td colspan="3" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
		
	<?php
	
	if($billtype == 'PAY NOW')
	{
	$query11 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$depositamount = $res11['transactionamount'];
	$docno = $res11['docno'];
	$transactionmode = $res11['transactionmode'];
	if($transactionmode == '')
	{
	$transactionmode = 'CASH';
	}
	?>
      <tr>
	  <td colspan="3" class="bodytext31" align="right"><strong> Less Deposit( Ref No: <?php echo $docno; ?>) By <?php echo $transactionmode; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($depositamount,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
       <?php
	   }
	   ?>
	   <?php
	   $netamount = $overalltotal - $depositamount;
	   ?>
	   <tr>
	  <td colspan="3" class="bodytext31" align="right"><strong>Net&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($netamount,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="31%" align="center" valign="center" class="bodytext311">         
        <a href="ipbilling.php"><input type="button" value="Back" style="border: 1px solid #001E6A"/></a></td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

