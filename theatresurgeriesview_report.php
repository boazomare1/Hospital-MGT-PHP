<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["surgeon_id"])) { $surgeon_id = $_REQUEST["surgeon_id"]; } else { $surgeon_id = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script src="js/datetimepicker_css.js"></script>
<body>
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
    <td width="99%" valign="top">
      <table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" align="left" border="0">
          <tbody>
            <td colspan="13" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Report &nbsp; From &nbsp;<?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>
			<tr>
              <td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
			  <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode</strong></div></td>
			  <td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
			  <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Theatre</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Category</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Procedure Type</strong></div></td>	
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Surgery Date</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Surgeon</strong></div></td> 
            </tr>
			
			<?php
			$colorloopcount = '';
					$snocount=0;
			 $querycr1in = " SELECT a.auto_number,a.category,b.surgeon_id,a.patientcode,a.proceduretype,a.theatrecode,a.ward,a.surgerydatetime FROM `master_theatre_booking` as a join `theatre_booking_surgeons` as b on b.booking_id=a.auto_number WHERE date(a.starttime) BETWEEN '$ADate1' AND '$ADate2' and a.starttime <>'0000-00-00 00:00:00' and b.surgeon_id='$surgeon_id' ";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($res = mysqli_fetch_array($execcr1))
			 {
			 $bookingid = $res['auto_number'];
			 $category=$res['category'];
			 $surgeon_id=$res['surgeon_id'];
			 $patientcode=$res['patientcode'];
			 $proceduretype=$res['proceduretype'];
			 $theatrecode = $res['theatrecode'];
			 $ward = $res['ward'];
			 $surgerydatetime = $res['surgerydatetime'];
			 
			 
			  $query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surgeon_id'";
			  $exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res_t = mysqli_fetch_assoc($exec_t);  
			  $newdoctorname=$res_t['doctorname'];
			  
			$query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			
			  $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
			  
			 $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			  
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
			
			 <tr  <?php echo $colorcode; ?>>
              <td width=""  align="left" valign="center"  class="bodytext31"><?php echo $colorloopcount; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo $patientcode; ?></td>
			  <td width=""  align="left" valign="center"   class="bodytext31"><?php echo $patientname; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"> <?php echo $theatrename; ?> </td>
			 
			  <td width=""  align="left" valign="center"  class="bodytext31"><?php echo $ward_name; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo strtoupper($category); ?></td>
			  <td width=""  align="left" valign="center"   class="bodytext31"><?php echo strtoupper($proceduretype); ?></td>
			  <td width=""  align="left" valign="center"   class="bodytext31"><?php echo $surgerydatetime; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"> <?php echo $newdoctorname; ?> </td>
            </tr>
			
			 
			<?php
			} 
		
			 ?>
			
			
			
		</tbody>
	 </table>
	 </td>
	 </tr>
			 	
			
			
			
			
			