<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="iplengthofstay.xls"');
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
$snocount = '';
$sno = 0;

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
			<td class="bodytext31" colspan="9" valign="middle" align="left" ><strong>Length Of Stay Report From <?php echo date("d/m/Y", strtotime($fromdate)); ?> to <?php echo date("d/m/Y", strtotime($todate)); ?> Printed On <?php echo $updatedatetime; ?></strong></td>  
		</tr>
		<tr>
			<td colspan="9"><br></td>
		</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
	<tr>
    	<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>No.</strong></td>
		<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Patient Name</strong></td>
		<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Reg. No.</strong></td>
		<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Visit Code</strong></td>
     	<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Age</strong></td>
		<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Gender</strong></td>				<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Bed</strong></td>				<td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Ward</strong></td>
        <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>IP Admission Date</strong></td>
        <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>IP Discharge Date</strong></td>
        <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>Total Days</strong></td>
     </tr>
	<?php
		$query1 = "select * from ip_discharge where locationcode='$locationcode1' and recorddate between '$fromdate' and '$todate' order by auto_number desc";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$res2consultationdate=$res1['recorddate'];
		$res2consultationtime=$res1['recordtime'];
	    $docnumber=$res1['docno'];		$res2bed=$res1['bed'];	    $res2ward=$res1['ward'];		$query21 = "select * from master_ward where  auto_number='$res2ward'  ";		$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));		$num21=mysqli_num_rows($exec21);		$res21 = mysqli_fetch_array($exec21);		$res21ward=$res21['ward'];				$query212 = "select * from master_bed where  auto_number='$res2bed'  ";		$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query212".mysqli_error($GLOBALS["___mysqli_ston"]));		$num212=mysqli_num_rows($exec212);		$res212 = mysqli_fetch_array($exec212);		$res212bed=$res212['bed'];
		
        $query2 = "select * from master_ipvisitentry where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode'  ";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num2=mysqli_num_rows($exec2);
		$res2 = mysqli_fetch_array($exec2);
		$res2registrationdate=$res2['registrationdate'];
		$gender=$res2['gender'];
		
		$query751 = "select * from master_customer where locationcode='$locationcode1' and customercode = '$patientcode'";
		$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res751 = mysqli_fetch_array($exec751);
		$dob = $res751['dateofbirth'];
			
		$today = new DateTime();
		$diff = $today->diff(new DateTime($dob));
		
		if ($diff->y)
		{
		$age= $diff->y . ' Years';
		}
		elseif ($diff->m)
		{
		$age =$diff->m . ' Months';
		}
		else
		{
		$age =$diff->d . ' Days';
		}
		
		$query3 = "select * from ip_bedallocation where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num3=mysqli_num_rows($exec3);
		$res3 = mysqli_fetch_array($exec3);
		$res3recorddate=$res3['recorddate'];
		$res3recordtime=$res3['recordtime'];

		$res2consultationtime = date('H:i',strtotime($res2consultationtime));
		$res3recordtime = date('H:i',strtotime($res3recordtime));
        
		$consultationdate = strtotime($res2consultationdate);
        $registrationdate   = strtotime($res3recorddate);
        $totaldays = ceil(($consultationdate - $registrationdate) / 86400);
		if($totaldays == 0)
		{
		$totaldays = 1;
		}

        $snocount1 = $snocount + 1;
        $colorcode = 'bgcolor="#ffffff"';   
    ?>
	<tr <?php echo $colorcode; ?>>
      	<td class="bodytext31" valign="center" align="left"><?php echo $sno = $sno + 1; ?></td>
	  	<td class="bodytext31" valign="center" align="left"><?php echo $patientname; ?></td>
	  	<td class="bodytext31" valign="center" align="left"><?php echo $patientcode; ?></td>
		<td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>
		<td class="bodytext31" valign="center" align="left"><?php echo $age; ?></td>
		<td class="bodytext31" valign="center" align="left"><?php echo $gender; ?></td>				<td class="bodytext31" valign="center" align="left"><?php echo $res212bed; ?></td>		<td class="bodytext31" valign="center" align="left"><?php echo $res21ward; ?></td>		
       	<td class="bodytext31" valign="center" align="left"><?php echo $res3recorddate." ".$res3recordtime; ?></td>
        <td class="bodytext31" valign="center" align="left"><?php echo $res2consultationdate." ".$res2consultationtime; ?></td>
		<td class="bodytext31" valign="center" align="left"><?php if($res2consultationdate = '') { echo $todate; } else { echo $totaldays; }?></td>
      </tr>
	<?php 
	}
	?>
</table>