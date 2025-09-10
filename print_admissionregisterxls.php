<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="report_admissionregister.xls"');
header('Cache-Control: max-age=80');

session_start();
include ("db/db_connect.php");
error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');


$snocount = "";
$colorloopcount="";
$range = "";
$admissiondate = "";
$ipnumber = "";
$patientname = "";
$gender = "";
$admissiondoc = "";
$consultingdoc = "";
$companyname = "";
$bedno = "";
$dischargedate = "";
$wardcode = "";

if (isset($_REQUEST["wardcode"])) { $wardcode = $_REQUEST["wardcode"]; } else { $wardcode = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

$query18 = "select * from master_location";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
$row = array();
while($row[] = mysqli_fetch_array($exec18)){
$res1locationname = $row[0]['locationname'];
}

$query2 = "select * from master_ward where auto_number = '$wardcode'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2wardnamename = $res2['ward'];

$currentdate = date('d/m/Y H:i:s');

?>
<style type="text/css">
<!--
.bodytext3 {
}
.bodytext31 {
}
.bodytext311 {
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


<table cellspacing="3" cellpadding="0" align="left" border="0" style="border-collapse:collapse;" width="100%">
	<tbody>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left" colspan="11"><strong><?php echo strtoupper($res1locationname); ?></strong></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle" colspan="7" align="left" ><strong>Admission Register From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
		<?php 
		if($wardcode == "0"){
			$query24 = "select * from master_ward";
         	$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
          	
          	while ($res24 = mysqli_fetch_array($exec24)){
            	$wardautonumber = $res24['auto_number'];
            ?>
            <tr>
            <td colspan="12" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res24['ward']; ?></strong></td>
            </tr>
          	<tr>
	          	<col width="20"><td align="center" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Sno.</strong></td>
	          	<col width="80"><td align="center" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admission Date</strong></td>
	          	<col width="80"><td align="center" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Ip Visit</strong></td>											<col width="80"><td align="center" valign="center"  	            	bgcolor="#ffffff" class="bodytext31"><strong>Type</strong></td>
	          	<col width="180"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
	          	<col width="50"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Gender</strong></td>
	          	<col width="60"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
	          	<col width="120"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
	          	<col width="120"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Consulting Doctor</strong></td>
	          	<col width="180"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Company Name</strong></td>
	          	<col width="60"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Bed No</strong></td>
	          	<col width="80"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Discharge Date</strong></td> 
	        </tr>
          
        <?php
          
          $query1 = "select * from ip_bedallocation where ward = '$wardautonumber' and (recorddate between '$ADate1' and '$ADate2')";
          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
          $nums1 = mysqli_num_rows($exec1);

          while ($res1 = mysqli_fetch_array($exec1)){
              $admissiondate = $res1['recorddate'];
              $ipnumber = $res1['visitcode'];
              $patientname = $res1['patientname'];
              $patientcode = $res1['patientcode'];
              $visitcode = $res1['visitcode'];
              $companyname = $res1['accountname'];
              $res2bed = $res1['bed'];

              $query11 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
              $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res11 = mysqli_fetch_array($exec11);

              $gender = $res11['gender'];
              $age = $res11['age'];
              $admissiondoc = $res11['opadmissiondoctor'];
              $consultingdoc = $res11['consultingdoctorName'];
              $type = $res11['type'];
              $query111 = "select * from master_bed where auto_number = '$res2bed'";
              $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res111 = mysqli_fetch_array($exec111);

              $bedno = $res111['bed'];

              $query112 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode' and req_status = 'discharge'";
              $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112". mysqli_error($GLOBALS["___mysqli_ston"]));
              $res112 = mysqli_fetch_array($exec112);

              $dischargedate = $res112['recorddate'];

              $snocount = $snocount + 1;
            
              $colorcode = 'bgcolor="#ffffff"';
	          ?>
	          <tr <?php echo $colorcode; ?>>
	           	<td width="8%" class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
	           	<td width="8%" class="bodytext31" valign="center" align="left"><?php echo $admissiondate; ?></td>
	          	<td width="6%" align="left" valign="center" class="bodytext31"><?php echo strtoupper($ipnumber); ?></td>								<td width="6%" align="left" valign="center" class="bodytext31"><?php echo strtoupper($type); ?></td>
	            <td width="15%" class="bodytext31" valign="center" align="left"><?php echo strtoupper($patientname); ?></td>
	            <td width="6%" class="bodytext31" valign="center"  align="left"><?php echo strtoupper($gender); ?></td>
	            <td width="6%" class="bodytext31" valign="center"  align="left"><?php echo $age ." YEARS";?></td>
	            <td width="15%" class="bodytext31" valign="center"  align="left"><?php $doc = explode(".", $admissiondoc); foreach($doc as $item){ echo (strtoupper($item)." "); } ?></td>
	            <td width="15%" class="bodytext31" valign="center"  align="left"><?php echo strtoupper($consultingdoc); ?></td>
	            <td width="15%"class="bodytext31" valign="center"  align="left"><?php echo strtoupper($companyname); ?></td>
	            <td width="6%" class="bodytext31" valign="center"  align="left"><?php echo strtoupper($bedno); ?></td>
	            <td width="6%" class="bodytext31" valign="center"  align="left"><?php echo $dischargedate; ?></td>
	          </tr>
		<?php
				}
			}
		} else {
			$query23 = "select * from master_ward where auto_number = '$wardcode'";
            $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            
            while ($res23 = mysqli_fetch_array($exec23)){
            ?>
            <tr>
				<td colspan="12" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res23['ward']; ?></strong></td>
			</tr>
			<tr>
	          	<col width="20"><td align="center" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admission Date</strong></td>
	          	<col width="80"><td align="center" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admission Date</strong></td>
	          	<col width="80"><td align="center" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Ip Visit</strong></td>											<col width="80"><td align="center" valign="center"  	            	bgcolor="#ffffff" class="bodytext31"><strong>Type</strong></td>
	          	<col width="180"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
	          	<col width="50"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Gender</strong></td>
	          	<col width="60"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
	          	<col width="120"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
	          	<col width="120"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Consulting Doctor</strong></td>
	          	<col width="180"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Company Name</strong></td>
	          	<col width="60"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Bed No</strong></td>
	          	<col width="80"><td align="left" valign="center"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Discharge Date</strong></td> 
	        </tr>

	        <?php
				  $query2 = "select * from ip_bedallocation where ward = '$wardcode' AND (recorddate between '$ADate1' and '$ADate2')";
		          $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		          $nums = mysqli_num_rows($exec2);
		          while ($res2 = mysqli_fetch_array($exec2))
		          {
		              $admissiondate = $res2['recorddate'];
		              $ipnumber= $res2['visitcode'];
		              $patientname = $res2['patientname'];
		              $patientcode = $res2['patientcode'];
		              $visitcode = $res2['visitcode'];
		              $companyname = $res2['accountname'];
		              $res2bed = $res2['bed'];
		          
		              $query3 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
		              $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3". mysqli_error($GLOBALS["___mysqli_ston"]));
		              $res3= mysqli_fetch_array($exec3);
		              
		              $gender = $res3['gender'];
		              $age = $res3['age'];
		              $admissiondoc = $res3['opadmissiondoctor'];
		              $consultingdoc = $res3['consultingdoctorName'];
                     $type = $res3['type'];
		              $query4 = "select * from master_bed where auto_number = '$res2bed'";
		              $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4". mysqli_error($GLOBALS["___mysqli_ston"]));
		              $res4 = mysqli_fetch_array($exec4);

		              $bedno = $res4['bed'];

		              $query5 = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode' and req_status = 'discharge'";
		              $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5". mysqli_error($GLOBALS["___mysqli_ston"]));
		              $res5 = mysqli_fetch_array($exec5);

		              $dischargedate = $res5['recorddate'];

		              $snocount = $snocount + 1;
		            
		              $colorcode = 'bgcolor="#ffffff"';
			?>	
	          <tr <?php echo $colorcode; ?>>
	           	<td width="8%" class="bodytext31" valign="middle" align="center"><?php echo $snocount; ?></td>
	           	<td width="8%" class="bodytext31" valign="middle" align="center"><?php echo $admissiondate; ?></td>
	          	<td width="6%" align="center" valign="middle" class="bodytext31"><?php echo strtoupper($ipnumber); ?></td>								<td width="6%" align="left" valign="center" class="bodytext31"><?php echo strtoupper($type); ?></td>
	            <td width="15%" class="bodytext31" valign="middle" align="center"><?php echo strtoupper($patientname); ?></td>
	            <td width="6%" class="bodytext31" valign="middle"  align="center"><?php echo strtoupper($gender); ?></td>
	            <td width="6%" class="bodytext31" valign="middle"  align="center"><?php echo $age ." YEARS";?></td>
	            <td width="15%" class="bodytext31" valign="middle"  align="center"><?php $doc = explode(".", $admissiondoc); foreach($doc as $item){ echo (strtoupper($item)." "); } ?></td>
	            <td width="15%" class="bodytext31" valign="middle"  align="center"><?php echo strtoupper($consultingdoc); ?></td>
	            <td width="15%"class="bodytext31" valign="middle"  align="center"><?php echo strtoupper($companyname); ?></td>
	            <td width="6%" class="bodytext31" valign="middle"  align="center"><?php echo strtoupper($bedno); ?></td>
	            <td width="6%" class="bodytext31" valign="middle"  align="center"><?php echo $dischargedate; ?></td>
	          </tr>
            <?php
        		}
			}
		}
		?>
</table>