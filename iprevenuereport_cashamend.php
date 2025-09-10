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

$sub_array=array();
$main_array_1=array();
$main_array=array();
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
<script src="js/datetimepicker_css.js"></script>

<?php
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }
if (isset($_REQUEST["ward"])) {$ward = $_REQUEST["ward"]; } else { $ward = ""; }
$type = 'cash';
$type1 = 'credit';
$type2 = 'note';
?>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
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
        <td width="860"><?php  ?>
        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" align="left" border="0">
          <tbody>
            <td colspan="11" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Revenue &nbsp; From &nbsp;<?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>
  
           <tr <?php //echo $colorcode; ?>>
              <td width="3%" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
			  
			  <td width="8%" class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Bill Number</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Code</td>
			  <td width="20%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Name</td>
              <td width="10%" align="center" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>
              <td width="10%" align="center" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Date</td>
			  <td  width="20%" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doctor Name / Remarks</td>
			  <td  width="7%" valign="center" bgcolor="#FFFFFF" class="bodytext31">Bill Amt</td>
			  <td width="3%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Dr.Share(%)</td>
			  <td width="7%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Dr.Share</td>
			  <td width="7%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Hosp.Share</td>
              <!-- <td width="" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td> -->
            </tr>
			<?php
			
			
			
		  // $chk = "accountnameano = '47'";
		  
		  $main_array_1 =array('cash');
					
			foreach($main_array_1 as $name_1){

              
			if($name_1 =='cash')		
		    {

		   $chk = "accountnameano = '47'";

               if($ward=='')

				{

				     $query1 = "select visitcode,'billing' as type from billing_ip where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47'  UNION ALL SELECT visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and  locationcode='$locationcode1' and accountnameano = '47' ";

				}

				else {



                  $query1 = "select visitcode,'billing' as type from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')



				   UNION  select visitcode,'creditapproved' as type from ip_bedallocation where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')



				   UNION  select visitcode,'billing' as type from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')	

				   

				   UNION  select visitcode,'creditapproved' as type from ip_bedtransfer where ward = '$ward'  and locationcode='$locationcode1' and recordstatus !='transfered' and visitcode in (SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '47'  and  locationcode='$locationcode1')	

				   ";

				}



	   }
	       
	        $total_bill_amt = 0;
		    $tot_doctor_share_amount = 0;
		    $tot_hospital_share_amount =0;
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1=mysqli_num_rows($exec1);
			$totaladmncharges = 0;
			if($num1>0)
			{
			   while($res1 = mysqli_fetch_array($exec1))
			   {
			   $visitcode=$res1['visitcode'];
				   
				$main_array =array('admission','bed','package','nursing','mo','consultant','lab','rad','pharma','services','ambulance','homecare','pvtdr','misc','discount','others','rebate');
					
			    foreach($main_array as $name)
				{
				
				   if($name=='admission') 
				   {
					   $query66 = "select  patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber  from billing_ipadmissioncharge where locationcode='$locationcode1' and visitcode='$visitcode' and recorddate between '$ADate1' and '$ADate2'  ";	
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  }
				   elseif($name=='bed') 
				   {
					   
		
							 $query66 = "SELECT patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE description = 'Bed Charges' AND recorddate BETWEEN '$ADate1' AND '$ADate2'   and visitcode='$visitcode'  
		
							UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Bed Charges' and patientvisitcode='$visitcode'
		
							";
		
					
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='package') 
				   {
					   	if($res1['type']=='billing') {
		
							$query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 
		
						  UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";
		
						}else{
		
						   $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description NOT IN  ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2'
		
						   UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and patientvisitcode='$visitcode'
		
						   ";
						   
		
						}
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='nursing') 
				   {
					   
							if($res1['type']=='billing') {
		
							   $query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 
		
							  UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'";
		
							}
							else{
		
								$query66 = "select patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber from billing_ipbedcharges where locationcode='$locationcode1' and  description='Ward Dispensing Charges' and  visitcode='$visitcode'  and recorddate between '$ADate1' and '$ADate2' 
		
							   UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description='Ward Dispensing Charges' and patientvisitcode='$visitcode'  ";
		
							}
		
						
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='mo') 
				   {
					  
		
							if($res1['type']=='billing') {
		
							  $query66 = "SELECT patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE (description = 'RMO Charges' or description ='Daily Review charge') AND recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode='$visitcode'
		
							  UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'RMO Charges' and patientvisitcode='$visitcode'";
		
							}else{
		
							   $query66 = "SELECT  patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE (description = 'Resident Doctor Charges') AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode='$visitcode' ";
		
							}
		
						
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='consultant') 
				   {
					  
							 $query66 = "SELECT patientcode,recorddate,visitcode,amountuhx,patientname,docno as billnumber FROM `billing_ipbedcharges` WHERE description = 'Consultant Fee' AND recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";
		
						
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='lab') 
				   {
					 	
							$query66 = "SELECT billdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rateuhx as amountuhx,billnumber as billnumber FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'
		
							UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Lab' and patientvisitcode='$visitcode'
		
							";
		
						
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='pharma') 
				   {
					 	
		
							$query66 = "SELECT patientcode,patientname,patientvisitcode as visitcode,billdate as recorddate,amountuhx as amountuhx,billnumber as billnumber FROM `billing_ippharmacy`  WHERE   billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'";
		
						
		
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='ambulance') 
				   {
					 	$query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode, amountuhx,docno as billnumber FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";
		
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='misc') 
				   {
					 	 $query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode,amountuhx,docno as billnumber FROM billing_ipmiscbilling WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";
		
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='discount') 
				   {
					 	 $query66 = "SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate as amountuhx,docno as billnumber FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE $chk and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber) and patientvisitcode ='$visitcode'
		
						 UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,rate as amountuhx,docno as billnumber FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE $chk and billdate BETWEEN '$ADate1' AND '$ADate2' group by billno) and patientvisitcode ='$visitcode'";
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='rebate') 
				   {
					 	
		
							$query66 = "SELECT recorddate,patientcode,patientname,visitcode,amount as amountuhx,docno as billnumber FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'  and visitcode ='$visitcode' and accountname = 'CASH - HOSPITAL'";
		
							
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='services') 
				   {
					 	
							$query66 = "SELECT billdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,servicesitemrateuhx as amountuhx,servicesitemname,billnumber as billnumber,sharingamount FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'
		
							UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,'' as servicesitemname,docno as billnumber,'' as sharingamount  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Service' and patientvisitcode='$visitcode'";
		
							
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						 
						 if($name=='services')
						{ 
						$sharingamount = $res66['sharingamount'];
						$consultationfee = $consultationfee-$sharingamount;
						}
						 
						 
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						$servicesitemname = $res66['servicesitemname'];
		
							$billnumber = $res66['billnumber'];
							
							?>
							 <tr <?php echo $colorcode; ?>>
						  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
						  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
						   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
							<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
							 <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
						   <td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
							<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $servicesitemname;  ?></div></td>
						<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
						<td class="bodytext31" valign="center" colspan="3"  align="left"><div class="bodytext31"></div></td>
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }	
				   elseif($name=='pvtdr') 
				   {
					$query66 = "SELECT *,docno as billnumber FROM billing_ipprivatedoctor WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";	
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					 $num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];	
						$visitcode = $res66['visitcode'];	
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];	
						$billnumber=$res66['billnumber'];					
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						$sno=$sno+1;					
						$totaladmncharges=$totaladmncharges+$consultationfee;		
						$colorloopcount = $colorloopcount + 1;		
						$showcolor = ($colorloopcount & 1); 	
						if ($showcolor == 0)		
						{	
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
					    	if($res66['visittype'] =="IP")
							{
								if($res66['coa'] !="")
								$billamt = $res66['transactionamount'];
								else
								$billamt = $res66['original_amt'];
							}
							else
							{
								$billamt = $res66['original_amt'];
							}
							
							$total_bill_amt = $total_bill_amt + $billamt;
							$hospital_share = $billamt - $res66['sharingamount'];
							$tot_hospital_share_amount = $tot_hospital_share_amount + $hospital_share;
							$doctor_share_amt = $res66['sharingamount'];
							$tot_doctor_share_amount = $tot_doctor_share_amount + $doctor_share_amt;
							?>
						<tr <?php echo $colorcode; ?>>
						  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
						  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
						   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
							<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
							<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
							<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
							<td class="bodytext31" valign="center" align=""><?php echo $res66['description'];?></td>
							<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($billamt,2,'.',','); ?></div></td>
							<td class="bodytext31" valign="center" align="right"><?php echo $res66['pvtdr_percentage'];?></td>
							<td class="bodytext31" valign="center" align="right"><?php echo number_format($res66['sharingamount'],2,'.',',');?></td>
							<td class="bodytext31" valign="center" align="right"><?php echo number_format($hospital_share,2,'.',',');?></td>		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='rad') 
				   {
					 			
							$query66 = "SELECT billdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,radiologyitemrateuhx as amountuhx,billnumber as billnumber FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and patientvisitcode ='$visitcode'
		
							UNION ALL SELECT consultationdate as recorddate,patientcode,patientname,patientvisitcode as visitcode,fxamount as amountuhx,docno as billnumber FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Radiology' and patientvisitcode='$visitcode'";
		
						
		
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];
						$visitcode = $res66['visitcode'];
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];
						$billnumber=$res66['billnumber'];
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						 $sno=$sno+1;
						$totaladmncharges=$totaladmncharges+$consultationfee;
						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
						
						?>
		
					   <tr <?php echo $colorcode; ?>>
		
					<td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
					
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
					
					<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
		
					<td class="bodytext31" valign="center"  align="left"><div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
							
					<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo $consultationfee; ?></div></td>
						
					<td align="right" valign="center" colspan="3"  class="bodytext31"><div class="bodytext31"></div></td>
		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				   elseif($name=='homecare') 
				   {
					
					$query66 = "SELECT recorddate,patientcode,patientname,visitcode as visitcode,amount as amountuhx,docno as billnumber FROM billing_iphomecare WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode ='$visitcode'";	
					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
					 $num66=mysqli_num_rows($exec66);
					while($res66 = mysqli_fetch_array($exec66))
					{
						$patientcode = $res66['patientcode'];
						$consultationdate = $res66['recorddate'];	
						$visitcode = $res66['visitcode'];	
						$consultationfee = $res66['amountuhx'];
						$patientname=$res66['patientname'];	
						$billnumber=$res66['billnumber'];					
						
					$query6405 = "select * from ip_discount where locationcode='$locationcode1' and patientcode='$patientcode' and patientvisitcode='$visitcode' order by consultationdate";
					$exec6405 = mysqli_query($GLOBALS["___mysqli_ston"], $query6405) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num_ipdiscount05 = mysqli_num_rows($exec6405);
					$res6405 = mysqli_fetch_array($exec6405);
					$discount= $res6405['description'];
					$authorizedby = $res6405['authorizedby'];
						$sno=$sno+1;					
						$totaladmncharges=$totaladmncharges+$consultationfee;		
						$colorloopcount = $colorloopcount + 1;		
						$showcolor = ($colorloopcount & 1); 	
						if ($showcolor == 0)		
						{	
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}
					    	if($res66['visittype'] =="IP")
							{
								if($res66['coa'] !="")
								$billamt = $res66['transactionamount'];
								else
								$billamt = $res66['original_amt'];
							}
							else
							{
								$billamt = $res66['original_amt'];
							}
							
							$total_bill_amt = $total_bill_amt + $billamt;
							$hospital_share = $billamt - $res66['sharingamount'];
							$tot_hospital_share_amount = $tot_hospital_share_amount + $hospital_share;
							$doctor_share_amt = $res66['sharingamount'];
							$tot_doctor_share_amount = $tot_doctor_share_amount + $doctor_share_amt;
							?>
						<tr <?php echo $colorcode; ?>>
						  <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
						  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $billnumber;?></div> </td>
						   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode;?></div> </td>
							<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientname;?></div> </td>
							<td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>
							<td class="bodytext31" valign="center" align="right"><?php echo $consultationdate;?></td>
							<td class="bodytext31" valign="center" align=""><?php echo $res66['description'];?></td>
							<td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($billamt,2,'.',','); ?></div></td>
							<td class="bodytext31" valign="center" align="right"><?php echo $res66['pvtdr_percentage'];?></td>
							<td class="bodytext31" valign="center" align="right"><?php echo number_format($res66['sharingamount'],2,'.',',');?></td>
							<td class="bodytext31" valign="center" align="right"><?php echo number_format($hospital_share,2,'.',',');?></td>		
					   </tr>
		<?php
						
				  }
				  
				  
				  
				  }
				  
				}
			   }
		}
			
	}
	        ?>
			
     </tbody>
	 </table>
	 </td>
	 </tr>
</table>  
  