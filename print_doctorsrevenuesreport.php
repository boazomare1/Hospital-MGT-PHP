<?php
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

$colorloopcount=0;
$sno=0;
$description = '';

if (isset($_GET["ADate1"])) { $ADate1 = $_GET["ADate1"]; } else { $ADate1 = ""; }
if (isset($_GET["ADate2"])) { $ADate2 = $_GET["ADate2"]; } else { $ADate2 = ""; }
 $location=isset($_GET['location'])?$_GET['location']:'';

if ($ADate1 != '' && $ADate2 != '')
{
	$datefrom = $_GET['ADate1'];
	$dateto = $_GET['ADate2'];
}
else
{
	$datefrom = date('Y-m-d', strtotime('-1 month'));
	$dateto = date('Y-m-d');
}
$locationname = '';
$query1 = "select locationname from master_location where locationcode='".$location."'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						while($res1 = mysqli_fetch_array($exec1)){
							$locationname = $res1["locationname"];
						}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DoctorsRevenues.xls"');
header('Cache-Control: max-age=80');
?>
<table width="101%" border="1" cellspacing="0" cellpadding="2">
          <tbody>
             <tr>
			 <td colspan="13" class="bodytext31" align="left" valign="middle"><strong>Doctors Revenues Report </strong><br/><?php echo $locationname; ?>[<?php echo $datefrom.' - '.$dateto; ?>]</td>
			 </tr>
			  <tr>
				  <td width="67" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td>
				  	<td width="262"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Doctor's Name </strong></td>	
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Patients Count </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Lab </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Radiology </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Service </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>Total </strong></td>
                    <td width="127"  align="right" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><strong>APR </strong></td>
			  </tr>					
           <?php
		$total_pharmacy = 0; $total_lab = 0; $total_radiology = 0; $total_service = 0; $_total = 0; $_number=0;
	    $description=trim($description);
		if($datefrom!="" && $dateto!="" &&$location!="" ){
		$query1 = "SELECT `employeename`, `username` FROM `master_employee` WHERE `username` != ''"; 

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$res1employeename =$res1['employeename'];
		$res1username =$res1['username'];

		$queryc = "SELECT COUNT(patientcode) AS number FROM `consultation_lab` where `resultentry`='completed' AND `username`='".$res1username."'"; 
		if($datefrom!=""){$queryc .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryc .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryc .= " AND locationcode <= '".$location."'";}
		
		$number = 0;
		$execc = mysqli_query($GLOBALS["___mysqli_ston"], $queryc) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numc=mysqli_num_rows($execc);
		while($resc = mysqli_fetch_array($execc))
		{
		$number =$resc['number'];
		}

		$querylab = "SELECT SUM(`consultation_lab`.`labitemrate`) AS labrate  FROM `consultation_lab` where `resultentry`='completed' AND `username`='".$res1username."'"; 
		if($datefrom!=""){$querylab .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$querylab .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$querylab .= " AND locationcode <= '".$location."'";}

		$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $querylab) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numlab=mysqli_num_rows($execlab);
		while($reslab = mysqli_fetch_array($execlab))
		{
		$res1labrate =$reslab['labrate'];
		}

		$queryrad = "SELECT SUM(`consultation_radiology`.`radiologyitemrate`) AS amount FROM `consultation_radiology` where `consultation_radiology`.`paymentstatus`='completed' AND `consultation_radiology`.`username`='".$res1username."'"; 
		if($datefrom!=""){$queryrad .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryrad .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryrad .= " AND locationcode <= '".$location."'";}

		$execrad = mysqli_query($GLOBALS["___mysqli_ston"], $queryrad) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numrad=mysqli_num_rows($execrad);
		while($resrad = mysqli_fetch_array($execrad))
		{
		$consultation_radiology =$resrad['amount'];
		}

		$queryser = "SELECT SUM(`consultation_services`.`amount`) AS amount FROM `consultation_services` where `consultation_services`.`paymentstatus`='completed' AND `consultation_services`.`username`='".$res1username."'"; 
		if($datefrom!=""){$queryser .= " AND consultationdate >= '".$datefrom."'";}
		if($dateto!=""){$queryser .= " AND consultationdate <= '".$dateto."'";}
		if($location!=""){$queryser .= " AND locationcode <= '".$location."'";}

		$execser = mysqli_query($GLOBALS["___mysqli_ston"], $queryser) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numlab=mysqli_num_rows($execser);
		while($resser = mysqli_fetch_array($execser))
		{
		$consultation_service =$resser['amount'];
		}
		
		$querypharm= "SELECT SUM(quantity*rate) AS amount FROM `master_consultationpharm` where `recordstatus`='completed' AND `consultingdoctor`='".$res1username."'"; 
		if($datefrom!=""){$querypharm .= " AND recorddate >= '".$datefrom."'";}
		if($dateto!=""){$querypharm .= " AND recorddate <= '".$dateto."'";}
		if($location!=""){$querypharm .= " AND locationcode <= '".$location."'";}

		$execpharm = mysqli_query($GLOBALS["___mysqli_ston"], $querypharm) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$numpharm=mysqli_num_rows($execpharm);
		while($respharm = mysqli_fetch_array($execpharm))
		{
		$consultation_pharmacy =$respharm['amount'];
		}
		
			if($consultation_pharmacy==0 && $res1labrate == 0 && $consultation_radiology == 0 && $consultation_service==0){ continue;}
		$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = '';
			}
			else
			{
				//echo "else";
				$colorcode = '';
			}
			
		 
		 
		 ?>
		 	<tr <?php echo $colorcode; ?>>
				<td width="13" align="center" valign="center" class="bodytext31"><?php echo $sno=$sno + 1; ?></td>
				<td width="262"  align="left" valign="center" class="bodytext31"><?php echo $res1employeename;  ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($number,2,'.',','); $_number+=$number; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($consultation_pharmacy,2,'.',','); $total_pharmacy += $consultation_pharmacy; ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$consultation_pharmacy_apr = 0;
				if($consultation_pharmacy!=0 && $number!=0){
				$consultation_pharmacy_apr = $consultation_pharmacy/$number;}
				echo number_format($consultation_pharmacy_apr,2,'.',','); ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1labrate,2,'.',','); $total_lab += $res1labrate;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$res1labrate_apr = 0;
				if($res1labrate!=0 && $number!=0){
				$res1labrate_apr = $res1labrate/$number;}
				echo number_format($res1labrate_apr,2,'.',',');?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($consultation_radiology,2,'.',','); $total_radiology += $consultation_radiology;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$consultation_radiology_apr = 0;
				if($consultation_radiology!=0 && $number!=0){
				$consultation_radiology_apr = $consultation_radiology/$number;}
				echo number_format($consultation_radiology_apr,2,'.',','); ?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php echo number_format($consultation_service,2,'.',',');  $total_service += $consultation_service;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php 
				$consultation_service_apr = 0;
				if($consultation_service!=0 && $number!=0){
				$consultation_service_apr = $consultation_service/$number;}
				echo number_format($consultation_service_apr,2,'.',',');?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php
				$total = $res1labrate+$consultation_pharmacy+$consultation_radiology+$consultation_service;
				 echo number_format($total,2,'.',',');  $_total += $total;?></td>
			    <td width="127"  align="right" valign="center" class="bodytext31"><?php
				$total_apr = 0;
				if($total!=0 && $number!=0){
				$total_apr = $total/$number;}
				 echo number_format($total_apr,2,'.',','); ?></td>
			</tr>	
		<?php
		}	 }
		?>	
        
            <tr>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_number,2,'.',','); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_pharmacy,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_lab,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_radiology,2,'.',','); ?></strong></div></td>
 				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_service,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($_total,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
            </tbody>
        </table>

	