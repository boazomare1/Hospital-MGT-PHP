<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="report_midnightoccupancy.xls"');
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
$wardname1 = "";
$totalcount = 0;
$totalcount2 = 0;
if (isset($_REQUEST["wardcode"])) { $wardcode = $_REQUEST["wardcode"]; } else { $wardcode = ""; }
if (isset($_REQUEST["locationcode1"])) { $locationcode1 = $_REQUEST["locationcode1"]; } else { $locationcode1 = ""; }
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
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 10.5px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext31 {
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 10.5px; COLOR: #3b3b3c;  text-decoration:none
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
		<td class="bodytext31"  valign="middle"  align="left" colspan="8" ><strong><?php echo strtoupper($res1locationname); ?></strong></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left" colspan="8"><strong>MIDNIGHT OCCUPANCY AS ON <?php echo date("d/m/Y", strtotime($ADate1)); ?> PRINTED ON <?php echo $currentdate; ?></strong></td>  
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
    <tr>
        <col width="80"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>No.</strong></td>
        <col width="80"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Ward</strong></td>
        <col width="80"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Admission Date</strong></td>
        <col width="80"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Ip Number</strong></td>
        <col width="180"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Patient Name</strong></td>
        <col width="50"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Gender</strong></td>
        <col width="60"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Age</strong></td>
        <col width="120"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Admitting Doctor</strong></td>
        <col width="120"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Consulting Doctor</strong></td>
        <col width="180"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Company Name</strong></td>
        <col width="60"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Bed No</strong></td>
        <col width="80"><td align="center" valign="middle"  
          bgcolor="#ecf0f5" class="bodytext31"><strong>Discharge Date</strong></td> 
    </tr>
		<?php
			$sno = 0;
          if($wardcode == '0'){
            $query24 = "select * from master_ward";
          } else {
            $query24 = "select * from master_ward where auto_number = '$wardcode'";
          }
          $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
          while ($res24 = mysqli_fetch_array($exec24)){
            $wardautonumber = $res24['auto_number'];
            ?>
            <?php
              if($wardcode == '0'){
                $querynw1 = "select visitcode, patientcode, patientname, ward, bed, accountname, recorddate, recordstatus from ip_bedallocation where recorddate <= '$ADate1' and locationcode = '$locationcode1' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1')";
              } else {
                $querynw1 = "select visitcode, patientcode, patientname, ward, bed, accountname, recorddate, recordstatus from ip_bedallocation where recorddate <= '$ADate1' and ward = '$wardcode' and locationcode = '$locationcode1' and recordstatus <> 'transfered' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1')";
              }
              $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
              $totalcount = mysqli_num_rows($execnw1);
              $formvar='';
              $i1=0;      
              while($getmw = mysqli_fetch_array($execnw1))
              { 
                if($wardautonumber == $getmw['ward']){
                  $patientcode = $getmw['patientcode'];
                  $visitcode = $getmw['visitcode'];
                  $res2consultationdate = $getmw['recorddate'];
                  $admissiondate = $getmw['recorddate'];
                  $ward1 = $getmw['ward'];
                  $bed1 = $getmw['bed'];
                  
                  $query233 = "select ward from master_ward where auto_number = '$wardautonumber'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $wardname1 = $res233['ward'];
                  
                  $query233 = "select bed from master_bed where auto_number = '$bed1'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $bedname = $res233['bed'];
                  $query02="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctorName from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
                  $exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                  $res02=mysqli_fetch_array($exec02);
      
                  $patientname=$res02['patientfullname'];
                  $gender=$res02['gender'];
                  $accountname = $res02['accountfullname'];
                  $admissiondoctor = $res02['opadmissiondoctor'];
                  $consultingdoctor = $res02['consultingdoctorName'];
    
                  $query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
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
                  $query311 = "select billdate as recorddate from billing_ip where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' ";
                  $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num311=mysqli_num_rows($exec311);
                  $res311 = mysqli_fetch_array($exec311);
                  
                  $res311recorddate = $res311['recorddate'];
                  $dischargedate = $res311['recorddate'];
                  $sno = $sno + 1;
                  $snocount1 = $snocount + 1;
                
                  //echo $cashamount;
                  $colorloopcount = $colorloopcount + 1;
                  $showcolor = ($colorloopcount & 1); 
                  if ($showcolor == 0)
                  {
                    //echo "if";
                    $colorcode = 'bgcolor="#ffffff"';
                  }
                  else
                  {
                    //echo "else";
                    $colorcode = 'bgcolor="#ffffff"';
                  }
          ?>    
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="center" align="center"><div align="center"><?php echo $sno; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $wardname1; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $admissiondate; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $visitcode; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $patientname; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $gender; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $age; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $admissiondoctor; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo strtoupper($consultingdoctor); ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $accountname; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $bedname; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $dischargedate; ?></div></td>
          </tr>
          <?php 
          }
        }
        ?>
        <?php
              if($wardcode == '0'){
                $querynw2 = "select visitcode, patientcode, patientname, ward, bed, accountname, recorddate, recordstatus from ip_bedtransfer where recorddate <= '$ADate1' and locationcode = '$locationcode1' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1') and recordstatus <> 'transfered'";
              } else {
                $querynw2 = "select visitcode, patientcode, patientname, ward, bed, accountname, recorddate, recordstatus from ip_bedtransfer where recorddate <= '$ADate1' and ward = '$wardcode' and locationcode = '$locationcode1' and visitcode not in (SELECT visitcode FROM ip_discharge Where recorddate <= '$ADate1') and recordstatus <> 'transfered'";
              }
              $execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
              $totalcount2 = mysqli_num_rows($execnw2);
              $formvar='';
              $i1=0;      
              while($getmw = mysqli_fetch_array($execnw2))
              { 
                if($wardautonumber == $getmw['ward']){
                  $patientcode = $getmw['patientcode'];
                  $visitcode = $getmw['visitcode'];
                  $res2consultationdate = $getmw['recorddate'];
                  $admissiondate = $getmw['recorddate'];
                  $ward1 = $getmw['ward'];
                  $bed1 = $getmw['bed'];
                  
                  $query233 = "select ward from master_ward where auto_number = '$wardautonumber'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $wardname1 = $res233['ward'];
                  
                  $query233 = "select bed from master_bed where auto_number = '$bed1'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $bedname = $res233['bed'];
                  $query02="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctorName from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
                  $exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                  $res02=mysqli_fetch_array($exec02);
      
                  $patientname=$res02['patientfullname'];
                  $gender=$res02['gender'];
                  $accountname = $res02['accountfullname'];
                  $admissiondoctor = $res02['opadmissiondoctor'];
                  $consultingdoctor = $res02['consultingdoctorName'];
    
                  $query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
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
                  $query311 = "select billdate as recorddate from billing_ip where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' ";
                  $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num311=mysqli_num_rows($exec311);
                  $res311 = mysqli_fetch_array($exec311);
                  
                  $res311recorddate = $res311['recorddate'];
                  $dischargedate = $res311['recorddate'];
                  $sno = $sno + 1;
                  $snocount1 = $snocount + 1;
                
                  //echo $cashamount;
                  $colorloopcount = $colorloopcount + 1;
                  $showcolor = ($colorloopcount & 1); 
                  if ($showcolor == 0)
                  {
                    //echo "if";
                    $colorcode = 'bgcolor="#ffffff"';
                  }
                  else
                  {
                    //echo "else";
                    $colorcode = 'bgcolor="#ffffff"';
                  }
          ?>    
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="center" align="center"><div align="center"><?php echo $sno; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $wardname1; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $admissiondate; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $visitcode; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $patientname; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $gender; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $age; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $admissiondoctor; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo strtoupper($consultingdoctor); ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $accountname; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $bedname; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $dischargedate; ?></div></td>
          </tr>
          <?php 
          }
        }
        ?>
    <?php
      }
    ?>
    <tr>
      <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="2"><strong>TOTAL COUNT</strong></td>
      <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5" colspan="9"><strong><?php echo $totalcount + $totalcount2; ?></strong></td>
    </tr>	
</table>
