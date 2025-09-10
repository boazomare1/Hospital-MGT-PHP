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
if (isset($_REQUEST["cancel_reason"])) { $cancel_reason = $_REQUEST["cancel_reason"]; } else { $cancel_reason = ""; }
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
          <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" align="left" border="0">
          <tbody>
            <td colspan="13" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Report &nbsp; From &nbsp;<?php echo $ADate1; ?> To <?php echo $ADate2; ?></strong></td>
			<tr>
              <td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
			  <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reason</strong></div></td>
			  <td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Surgeon</strong></div></td>
			  <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Anaesthetist</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Surgery</strong></div></td>
            </tr>
			
			<?php
			$colorloopcount = '';
			$snocount=0;
			 $querycr1in = " SELECT * FROM `master_theatre_booking`  WHERE date(date) BETWEEN '$ADate1' AND '$ADate2'  and cancel_reason = '$cancel_reason' ";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($res = mysqli_fetch_array($execcr1))
			 {
			 $bookingid = $res['auto_number'];
			 $category=$res['category'];
			 $cancel_reason=$res['cancel_reason'];
			  $anesthesia = $res['anesthesia'];
			  $ward = $res['ward'];
			  $proceduretype=$res['proceduretype'];
			  
			   $query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$anesthesia'";
			  $exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res_t = mysqli_fetch_assoc($exec_t);  
			  $newdoctorname=$res_t['doctorname'];
			  
			  
			   $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			  
			  $stringbigname1='';
				 $query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$bookingid'";
				 $exec_surg_doc = mysqli_query($GLOBALS["___mysqli_ston"], $query_surg_doc) or die ("Error in query_surg_doc".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res_surg_doc = mysqli_fetch_array($exec_surg_doc)){
				 $surg_id = $res_surg_doc['surgeon_id'];
				 $query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surg_id'";
				 $exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
				 
				while ($res_t = mysqli_fetch_assoc($exec_t))
				{  
				$newdoctorname=$res_t['doctorname'];
				if($stringbigname1=='')
				{
				$stringbigname1= $newdoctorname;
				}else
				{
				$stringbigname1= $stringbigname1.','.$newdoctorname;
				}
				}
				}
			  
			  
			  
			  
			  
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
              <td width=""  align="left" valign="center"  class="bodytext31"><?php echo $cancel_reason; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo $stringbigname1; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo $newdoctorname; ?> </td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo $ward_name; ?> </td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo strtoupper($proceduretype); ?> </td>
			  
			  
			 
            </tr>
			
			 
			<?php
			} 
			 ?>
			
			
			
		</tbody>
	 </table>
	 </td>
	 </tr>
			 	
			
			
			
			
			