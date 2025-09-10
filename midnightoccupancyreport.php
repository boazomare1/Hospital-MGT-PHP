<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
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
$locationcode = "";
$totalcount = 0;
$totalcount2 = 0;
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");
if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }
if (isset($_REQUEST["locationcode1"])) { $locationcode1 = $_REQUEST["locationcode1"]; } else { $locationcode1 = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
?>
<style type="text/css">
.bodytext31:hover { font-size:14px; }
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
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>
<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="midnightoccupancyreport.php">
		<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Midnight Occupancy Report</strong></td>
             </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
              <select name="locationcode1">
                <?php 
                  $query10 = "select * FROM master_location";
                  $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10". mysqli_error($GLOBALS["___mysqli_ston"]));
                  while ($row10 = mysqli_fetch_array($exec10)){
                    echo "<option value=".$row10['locationcode'].">" .$row10['locationname']. "</option>";
                  }
                ?>
              </select></td>
           </tr>
           	<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Ward</td>
              <td width="82%" align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="wardcode1" id="wardcode1"  >
                <option value="0">All</option>  
                <?php 
                $query201="select auto_number,ward from master_ward";
                $exc201=mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res201=mysqli_fetch_array($exc201))
                { ?>
                  <option value="<?php echo $res201['auto_number'] ?>"><?php echo $res201['ward']; ?> </option>    
                <?php 
                }
                ?>    
               </select></span></td>
           </tr>
		   
			     <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"> Date </td>
              <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </span></td>
              <!-- <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
              <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td> -->
                  </tr>	
                  <tr>
	              <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
	              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
	                  <input type="submit" value="Search" name="Submit" />
	                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            	</tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1286" 
            align="left" border="0">
          <tbody>
        <tr>
          <td class="bodytext31" valign="center"  align="left"> 
           <!-- <a target="_blank" href="print_midnightoccupancyreport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>&&locationcode1=<?php echo $locationcode1; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a> -->
           <a href="print_midnightoccupancyreportxls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&wardcode=<?php echo $wardcode; ?>&&locationcode1=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
          </td>
        </tr>
        <tr>
          <td width="3%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No</strong></div></td>
          <td width="8%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Admission Date</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ip Number</strong></div></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><strong>Admitting Doctor</strong></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulting Doctor</strong></div></td>
          <td width="15%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Company Name</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bed No</strong></div></td>
          <td width="6%" align="left" valign="center"  
            bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Discharge Date</strong></div></td> 
        </tr>
        <?php
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
            <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"><strong><?php echo $res24['ward']; ?></strong></span></td>
            </td>
            <td colspan="3" bgcolor="#ecf0f5" class="bodytext31" valign="center" align="right"><span class="bodytext311"><strong>
              <?php
                $query451 = "select * from `master_location`";
                $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $row2 = array();
                while ($row2[] = mysqli_fetch_assoc($exec451)){
                  $locationcode = $row2[0]['auto_number'];
                  echo "Location: " . $row2[0]['locationname'];
                }
              ?> </strong></span>
            </td> 
          </tr>
          
        <?php
            $sno=0;
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
                  
                  $query233 = "select ward from master_ward where auto_number = '$wardcode'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $wardname = $res233['ward'];
                  
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
                    $colorcode = 'bgcolor="#CBDBFA"';
                  }
                  else
                  {
                    //echo "else";
                    $colorcode = 'bgcolor="#ecf0f5"';
                  }
          ?>    
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="center" align="center"><div align="center"><?php echo $sno; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $admissiondate; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a></div></td>
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
                  
                  $query233 = "select ward from master_ward where auto_number = '$wardcode'";
                  $exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in Query233".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res233 = mysqli_fetch_array($exec233);
                  $wardname = $res233['ward'];
                  
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
                    $colorcode = 'bgcolor="#CBDBFA"';
                  }
                  else
                  {
                    //echo "else";
                    $colorcode = 'bgcolor="#ecf0f5"';
                  }
          ?>    
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="center" align="center"><div align="center"><?php echo $sno; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><?php echo $admissiondate; ?></div></td>
            <td class="bodytext31" valign="center" align="left"><div align="left"><a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a></div></td>
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
        <tr>
          <td></td>
        </tr>
    <?php
      }
    ?>
    <tr>
      <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="2"><strong>TOTAL COUNT</strong></td>
      <td class="bodytext31" valign="center" align="left" bgcolor="#ecf0f5"><strong><?php echo $totalcount + $totalcount2; ?></strong></td>
      <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="8">&nbsp;</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
