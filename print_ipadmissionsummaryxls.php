<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ipadmissionsummary_report.xls"');
header('Cache-Control: max-age=80'); 
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('d/m/Y H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$locationcode1 = isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$fromdate = isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
$todate = isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';
$srwardanum = isset($_REQUEST['ward'])?$_REQUEST['ward']:'';
$includezeroballeg = isset($_REQUEST['includezeroballeg'])?$_REQUEST['includezeroballeg']:'';
$snocount = '';
$sno = 0;
$total_hours='00';
$total_minutes='00';
if($locationcode1=='All'){
$locationcodenew= "locationcode like '%%'";
}else{
$locationcodenew= "locationcode = '$locationcode1'";
}   
$res1locationname='All';
$query18 = "select * from master_location where locationcode = '$locationcode1'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
$row = array();
while($row[] = mysqli_fetch_array($exec18)){
$res1locationname = $row[0]['locationname'];
}
?>
<table cellspacing="3" cellpadding="0" align="left" border="0" style="border-collapse:collapse;" width="100%">
	<tbody>
		<tr>
			<td colspan="9"><br></td>
		</tr>
		<tr>
			<td class="bodytext31" valign="middle" align="left" colspan="9"><strong><?php echo strtoupper($res1locationname); ?></strong></td>
		</tr>
		<tr>
			<td class="bodytext31" colspan="9" valign="middle" align="left" ><strong>Admission Summary Report From <?php echo date("d/m/Y", strtotime($fromdate)); ?> to <?php echo date("d/m/Y", strtotime($todate)); ?> Printed On <?php echo $updatedatetime; ?></strong></td>  
		</tr>
		<tr>
			<td colspan="9"><br></td>
		</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
  	<tr>
     	<col width="20"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>No.</strong></td>
     	<col width="80"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Location</strong></td>
		<col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Patient Name</strong></td>
		<col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Reg. No.</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Gender</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Age</strong></td>
         <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Scheme</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Provider</strong></td>
		<col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Visit Code</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>IP Date</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>DOA</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Ward</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge Status</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge Date</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>Type</strong></td>
        <col width="90"><td align="center" valign="middle" bgcolor="#ecf0f5" class="bodytext31"><strong>TAT</strong></td>
        
     </tr>
	<?php
		$valuesArray=array();
		if($locationcode1=='All'){
		$locationcodenew= "locationcode like '%%'";
		}else{
		$locationcodenew= "locationcode = '$locationcode1'";
		}   
		if($srwardanum == '')
		{
		$query1 = "select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from(select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from ip_bedallocation where $locationcodenew  and recorddate between '$fromdate' and '$todate' and recordstatus in ('discharged','')
					union all select a.patientname,a.patientcode,a.visitcode,a.recorddate,a.docno,b.ward,b.recordstatus,b.leavingdate,null as recordtime from ip_bedallocation as a join ip_bedtransfer as b on( a.patientcode = b.patientcode and a.visitcode = b.visitcode) where   a.recorddate between '$fromdate' and '$todate' and a.recordstatus not in ('discharged','') and b.recordstatus in ('discharged','') and a.$locationcodenew ) as e order by recorddate asc";
		}
		else{
		$query1 = "select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from(select patientname,patientcode,visitcode,recorddate,docno,ward,recordstatus,leavingdate,recordtime from ip_bedallocation where $locationcodenew and recorddate between '$fromdate' and '$todate' and recordstatus in ('discharged','') and ward = '$srwardanum'
					union all select a.patientname,a.patientcode,a.visitcode,a.recorddate,a.docno,b.ward,b.recordstatus,b.leavingdate,null as recordtime from ip_bedallocation as a join ip_bedtransfer as b on( a.patientcode = b.patientcode and a.visitcode = b.visitcode) where a.$locationcodenew and a.recorddate between '$fromdate' and '$todate' and a.recordstatus not in ('discharged','') and b.recordstatus in ('discharged','') and b.ward = '$srwardanum' ) as e order by recorddate asc";	
		}
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['recorddate'];
	    $docnumber=$res1['docno'];
	    $ward=$res1['ward'];
	    $status=$res1['recordstatus'];
		$iptime=$res1['recordtime'];
		$ipdate=$res1['recorddate'];
		if($status== 'discharged')
		{
	    $leavingdate=$res1['leavingdate'];
		}else{
			$status = "not yet discharged";
			$leavingdate='--';
		}
		
		$query12 = "select * from master_ward where auto_number='$ward' ";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res12 = mysqli_fetch_array($exec12);
		$wardname=$res12['ward'];
		
		$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
		
		$execlab=mysqli_fetch_array($Querylab);
		
		$patientage=$execlab['age'];
		
		$patientgender=$execlab['gender'];
		
        $query2 = "select * from master_ipvisitentry where  patientcode='$patientcode' and visitcode='$visitcode' ";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$registrationdate=$res2['registrationdate'];
		$consultationtime=$res2['consultationtime'];
		$locationcode = $res2['locationcode'];
		$account = $res2['accountname'];
		$scheme_id= $res2['scheme_id'];
		
		$query4 = "select * from master_accountname where auto_number = '$account'"; 
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"])); 
		$res4 = mysqli_fetch_array($exec4);
		$accountnameanum = $res4['auto_number'];
		$accountname = $res4['accountname'];
		
		$query41 = "select scheme_name from master_planname where scheme_id = '$scheme_id'"; 
		$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"])); 
		$res41 = mysqli_fetch_array($exec41);
		$scheme_name = $res41['scheme_name'];
		
			  if($ipdate!='') {

				  $diff = intval((strtotime($ipdate.' '.$iptime) - strtotime($registrationdate.' '.$consultationtime))/60);

                  //$hoursstay = $diff / ( 60 * 60 );

				   $hoursstay = intval($diff/60);

                  $minutesstay = $diff%60;
				  
				  $hoursstay=abs($hoursstay);
				  $minutesstay=abs($minutesstay);
				  
				   $los=$hoursstay.':'.$minutesstay;
				  
					if($hoursstay>='24')
					{
					// Split the time into hours and minutes
					list($hours, $minutes) = explode(':', $los);
					
					// Convert hours and minutes to seconds
					$total_seconds = ($hours * 3600) + ($minutes * 60);
					
					// Calculate days, hours, and minutes
					$days = floor($total_seconds / (60 * 60 * 24));
					$hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
					$minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
					$hours=abs($hours);
					$minutes=abs($minutes);
					//$total_time=$days ":Days".$hours: $minutes;
					$los=$days." Days ".$hours.":".$minutes;
					}

				 
				  
				  $total_hours=$total_hours+$hoursstay;
				  $total_minutes=$total_minutes+$minutesstay;

			  }

			  else

				  $los= '';
		 
		$searchValue = $patientcode;

		// Check if the value is present in the array
		if (in_array($searchValue, $valuesArray)) {
			// If present, bring two
			$result = 'Revisit';
		} else {
			// If not present, bring one
			$result = 'visit';
		}
		
		$valuesArray[] = $patientcode;
		 
		 $query211 = "select locationname from master_location where locationcode='$locationcode' ";
			$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res211 = mysqli_fetch_array($exec211);
			$locationname = $res211['locationname'];
		
		
        $snocount1 = $snocount + 1;
        $colorcode = 'bgcolor="#ffffff"';   
		if($wardname!='RENAL' || $includezeroballeg!='1'){
    ?>
	<tr <?php echo $colorcode; ?>>
		<td class="bodytext31" valign="middle" align="center"><?php echo $sno = $sno + 1; ?></td>
		<td class="bodytext31" valign="middle" align="left"><?php echo $locationname; ?></td>
		<td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo $patientcode; ?></td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $patientgender; ?></td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $patientage; ?></td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $accountname; ?></td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $scheme_name; ?></td>
 		<td class="bodytext31" valign="middle" align="center"><?php echo $visitcode; ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo $registrationdate; ?><?php echo $consultationtime; ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo $ipdate; ?><?php echo $iptime; ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo $wardname; ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo ucwords($status); ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo $leavingdate; ?></td>
		<td class="bodytext31" valign="middle" align="center"><?php echo $result; ?></td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $los; ?></td>
	</tr>
	<?php 
		}
	}
	 $total_minutes = ($total_hours * 60) + $total_minutes;

// Ensure minutes are within 0-59 range (handle overflow)
$minutes = $total_minutes % 60;
if ($minutes < 0) {
  $minutes += 60; // Correct for negative values
  $total_hours--;  // Decrement hours if minutes go below 0
}

// Calculate hours from remaining minutes
$hours = floor($total_minutes / 60);

// Format the output as H:i
$total_time = sprintf("%d:%02d", $hours, $minutes);

if($hours>='24')
{
// Split the time into hours and minutes
list($hours, $minutes) = explode(':', $total_time);

// Convert hours and minutes to seconds
$total_seconds = ($hours * 3600) + ($minutes * 60);

// Calculate days, hours, and minutes
$days = floor($total_seconds / (60 * 60 * 24));
$hours = floor(($total_seconds - ($days * 60 * 60 * 24)) / 3600);
$minutes = floor(($total_seconds - ($days * 60 * 60 * 24) - ($hours * 3600)) / 60);
//$total_time=$days ":Days".$hours: $minutes;
$total_time=$days." Days ".$hours.":".$minutes;
}
	?>
    <tr <?php echo $colorcode; ?>>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="left">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="left">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
 		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">Total</td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $total_time;?></td>
	</tr>
      <?php
	  // Example values
$finaltime = $hours.":".$minutes; // Example time format: "2 hours and 30 minutes"
$nofovisits = $sno;

// Split the time into hours and minutes
list($hours, $minutes) = explode(":", $finaltime);


// Convert the time into minutes
$total_minutes = ($hours * 60) + $minutes;

// Calculate the average time per visit
$average_time_minutes = $total_minutes / $nofovisits;
// Convert the average time back into hours and minutes
$average_hours = floor($average_time_minutes / 60);
$average_minutes = $average_time_minutes % 60;

// Format the average time
$average_time = sprintf("%d:%02d", $average_hours, $average_minutes);


	  ?>
       <tr <?php echo $colorcode; ?>>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="left">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="left">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
        <td class="bodytext31" valign="middle" align="center">&nbsp;</td>
 		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">&nbsp;</td>
		<td class="bodytext31" valign="middle" align="center">Total</td>
        <td class="bodytext31" valign="middle" align="center"><?php echo $average_time;?></td>
	</tr>
</table>