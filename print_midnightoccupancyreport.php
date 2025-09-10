<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
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
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 10.5px; COLOR: #3b3b3c; text-decoration:none
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
		<td class="bodytext31"  valign="middle"  align="left" ><strong><?php echo strtoupper($res1locationname); ?></strong></td>
	</tr>
	<tr>
		<td class="bodytext31"  valign="middle"  align="left" ><strong>MIDNIGHT OCCUPANCY AS ON <?php echo date("d/m/Y", strtotime($ADate1)); ?> PRINTED ON <?php echo $currentdate; ?></strong></td>  
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	</tbody>
</table>
<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1400" align="left" border="1">
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
            <tr>
            <td colspan="10" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res24['ward']; ?></strong></td>
            </tr>
          	<tr>
	          	<col width="80"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admission Date</strong></td>
	          	<col width="80"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Ip Number</strong></td>
	          	<col width="180"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
	          	<col width="50"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Gender</strong></td>
	          	<col width="60"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
	          	<col width="120"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
	          	<col width="120"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Consulting Doctor</strong></td>
	          	<col width="180"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Company Name</strong></td>
	          	<col width="60"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Bed No</strong></td>
	          	<col width="80"><td align="center" valign="middle"  
	            	bgcolor="#ffffff" class="bodytext31"><strong>Discharge Date</strong></td> 
	        </tr>
         	
         	<?php
            if($wardcode == '0'){
              $querynw1 = "select visitcode,patientcode,recorddate,ward,bed,accountname from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
            } else {
            $querynw1 = "select visitcode,patientcode,recorddate,ward,bed,accountname from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
            }
              $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
              //$resnw1 = mysql_num_rows($execnw1);

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
                  
                  $query233 = "select ward from master_ward where auto_number = '$wardcode'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $wardname = $res233['ward'];
                  
                  $query233 = "select bed from master_bed where auto_number = '$bed1'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $bedname = $res233['bed'];

                  $query02="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
                  $exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
                  $res02=mysqli_fetch_array($exec02);
      
                  $patientname=$res02['patientfullname'];
                  $gender=$res02['gender'];
                  $accountname = $res02['accountfullname'];
                  $admissiondoctor = $res02['opadmissiondoctor'];
                  $consultingdoctor = $res02['consultingdoctor'];
    
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

                  $query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
                  $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $num311=mysqli_num_rows($exec311);
                  $res311 = mysqli_fetch_array($exec311);
                  
                  $res311recorddate = $res311['recorddate'];
                  $dischargedate = $res311['recorddate'];
                  $sno = $sno + 1;

                  $snocount1 = $snocount + 1;
                
                  $colorcode = 'bgcolor="#ffffff"';
          ?>    
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
          <?php 
          }
        }
        ?>

        <?php
        if($wardcode == '0'){
          $querynw1 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        } else {
          $querynw1 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate between '$ADate1' and '$ADate2'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }

        $execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
        //$resnw1 = mysql_num_rows($execnw1);

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
            
            $query233 = "select ward from master_ward where auto_number = '$wardcode'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
            $getrd=mysqli_fetch_array($query1);
            
            $res2consultationdate=$getmw['recorddate'];
            $admissiondate = $getmw['recorddate'];
        
            $query02="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
            $res02=mysqli_fetch_array($exec02);
          
            $patientname=$res02['patientfullname'];
            $gender=$res02['gender'];
            $accountname = $res02['accountfullname'];
            $admissiondoctor = $res02['opadmissiondoctor'];
            $consultingdoctor = $res02['consultingdoctor'];

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

            $query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num3=mysqli_num_rows($exec3);
            $res3 = mysqli_fetch_array($exec3);
            
            $res3recorddate=$res3['recorddate'];
            $dischargedate = $res3['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
          $querynw2 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge')";
        } else {
          $querynw2 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }
        $execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw2=mysqli_num_rows($execnw2);
          
        $formvar='';
        $i1=0;      
        while($getmw2=mysqli_fetch_array($execnw2))
        { 
          if($wardautonumber == $getmw2['ward']){
            $patientcode=$getmw2['patientcode'];
            $visitcode=$getmw2['visitcode'];
            $res2consultationdate=$getmw2['recorddate'];
            $admissiondate = $getmw2['recorddate'];
            $ward1 = $getmw2['ward'];
            $bed1 = $getmw2['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num31=mysqli_num_rows($exec31);
            $res31 = mysqli_fetch_array($exec31);
            
            $res31recorddate=$res31['recorddate'];
            $dischargedate = $res31['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
         $querynw2 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge')";
        } else {
        $querynw2 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate between '$ADate1' and '$ADate2' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }
        $execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw2=mysqli_num_rows($execnw2);
          
        $formvar='';
        $i1=0;      
        while($getmw2=mysqli_fetch_array($execnw2))
        { 
          if($wardautonumber == $getmw2['ward']){
            $patientcode=$getmw2['patientcode'];
            $visitcode=$getmw2['visitcode'];
            $res2consultationdate=$getmw2['recorddate'];
            $admissiondate = $getmw2['recorddate'];
            $ward1 = $getmw2['ward'];
            $bed1 = $getmw2['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num31=mysqli_num_rows($exec31);
            $res31 = mysqli_fetch_array($exec31);
            
            $res31recorddate=$res31['recorddate'];
            $dischargedate = $res31['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
         $querynw8 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge')";
        } else {
        $querynw8 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }
        $execnw8 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw8) or die ("Error in Querynw8".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw8=mysqli_num_rows($execnw8);
          
        $formvar='';
        $i1=0;      
        while($getmw8=mysqli_fetch_array($execnw8))
        { 
          if($wardautonumber == $getmw8['ward']){
            $patientcode=$getmw8['patientcode'];
            $visitcode=$getmw8['visitcode'];
            $res2consultationdate=$getmw8['recorddate'];
            $admissiondate = $getmw8['recorddate'];
            $ward1 = $getmw8['ward'];
            $bed1 = $getmw8['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num33=mysqli_num_rows($exec33);
            $res33 = mysqli_fetch_array($exec33);
            
            $res33recorddate=$res33['recorddate'];
            $dischargedate = $res33['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
         $querynw8 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge')";
        } else {
        $querynw8 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate < '$ADate1' and visitcode IN (select visitcode from ip_discharge where recorddate > '$ADate2' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }
        $execnw8 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw8) or die ("Error in Querynw8".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw8=mysqli_num_rows($execnw8);
          
        $formvar='';
        $i1=0;      
        while($getmw8=mysqli_fetch_array($execnw8))
        { 
          if($wardautonumber == $getmw8['ward']){
            $patientcode=$getmw8['patientcode'];
            $visitcode=$getmw8['visitcode'];
            $res2consultationdate=$getmw8['recorddate'];
            $admissiondate = $getmw8['recorddate'];
            $ward1 = $getmw8['ward'];
            $bed1 = $getmw8['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num33=mysqli_num_rows($exec33);
            $res33 = mysqli_fetch_array($exec33);
            
            $res33recorddate=$res33['recorddate'];
            $dischargedate = $res33['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
         $querynw3 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
        } else {
        $querynw3 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }
        $execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw3=mysqli_num_rows($execnw3);
          
        $formvar='';
        $i1=0;      
        while($getmw3=mysqli_fetch_array($execnw3))
        { 
          if($wardautonumber == $getmw3['ward']){
            $patientcode=$getmw3['patientcode'];
            $visitcode=$getmw3['visitcode'];
            $res2consultationdate=$getmw3['recorddate'];
            $admissiondate = $getmw3['recorddate'];
            $ward1 = $getmw3['ward'];
            $bed1 = $getmw3['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num311=mysqli_num_rows($exec311);
            $res311 = mysqli_fetch_array($exec311);
            
            $res311recorddate=$res311['recorddate'];
            $dischargedate = $res311['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
         $querynw3 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus = 'transfered' and recorddate between '$ADate1' and '$ADate2'";
        } else {
        $querynw3 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedallocation where locationcode='$locationcode1' and recordstatus = 'transfered' and ward = '$wardcode' and recorddate between '$ADate1' and '$ADate2'";
        }
        $execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw3=mysqli_num_rows($execnw3);
          
        $formvar='';
        $i1=0;      
        while($getmw3=mysqli_fetch_array($execnw3))
        { 
          if($wardautonumber == $getmw3['ward']){
            $patientcode=$getmw3['patientcode'];
            $visitcode=$getmw3['visitcode'];
            $res2consultationdate=$getmw3['recorddate'];
            $admissiondate = $getmw3['recorddate'];
            $ward1 = $getmw3['ward'];
            $bed1 = $getmw3['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query311 = "select recorddate from ip_bedtransfer where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
            $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num311=mysqli_num_rows($exec311);
            $res311 = mysqli_fetch_array($exec311);
            
            $res311recorddate=$res311['recorddate'];
            $dischargedate = $res311['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>

    <?php
        if($wardcode == '0'){
          $querynw3 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
        } else {
          $querynw3 = "select visitcode,patientcode,recorddate,ward,bed from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$wardcode' and recorddate < '$ADate1' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
        }
        $execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnw3=mysqli_num_rows($execnw3);
          
        $formvar='';
        $i1=0;      
        while($getmw3=mysqli_fetch_array($execnw3))
        { 
          if($wardautonumber == $getmw3['ward']){
            $patientcode=$getmw3['patientcode'];
            $visitcode=$getmw3['visitcode'];
            $res2consultationdate=$getmw3['recorddate'];
            $admissiondate = $getmw3['recorddate'];
            $ward1 = $getmw3['ward'];
            $bed1 = $getmw3['bed'];
            
            $query233 = "select ward from master_ward where auto_number = '$ward1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $wardname = $res233['ward'];
            $query233 = "select bed from master_bed where auto_number = '$bed1'";
            $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
            $res233 = mysqli_fetch_array($exec233);
            $bedname = $res233['bed'];

            $query022="select patientfullname,gender,accountfullname, opadmissiondoctor, consultingdoctor from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
            $exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
            $res022=mysqli_fetch_array($exec022);
      
            $patientname=$res022['patientfullname'];
            $gender=$res022['gender'];
            $accountname = $res022['accountfullname'];
            $admissiondoctor = $res022['opadmissiondoctor'];
            $consultingdoctor = $res022['consultingdoctor'];
    
            $query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
            $exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $res753 = mysqli_fetch_array($exec753);
            $dob = $res753['dateofbirth'];
            
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
            
            $query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
            $exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
            $num311=mysqli_num_rows($exec311);
            $res311 = mysqli_fetch_array($exec311);
            
            $res311recorddate=$res311['recorddate'];
            $dischargedate = $res311['recorddate'];
            $sno = $sno + 1;

            $colorcode = 'bgcolor="#ffffff"';
            
            ?>

            <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="middle" align="left"><?php echo $admissiondate; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $visitcode; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $patientname; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $gender; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $age; ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($admissiondoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($consultingdoctor); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($accountname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo strtoupper($bedname); ?></td>
            <td class="bodytext31" valign="middle" align="left"><?php echo $dischargedate; ?></td>
          </tr>
    <?php 
      } 
      } 
    ?>
    <?php 
     }
    ?>
    <tr bgcolor="#ecf0f5">
      <td class="bodytext31" colspan="10" valign="center" align="left"><strong><?php echo "TOTAL OCCUPANCY:". $sno; ?></strong></td>
    </tr>
</table>


<?php

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_midnightoccupancy.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>


