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
if (isset($_REQUEST["proceduretype"])) { $proceduretype = $_REQUEST["proceduretype"]; } else { $proceduretype = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["category"])) { $category = $_REQUEST["category"]; } else { $category = ""; }
if (isset($_REQUEST["procedrype_wise"])) { $procedrype_wise = $_REQUEST["procedrype_wise"]; } else { $procedrype_wise = ""; }
if (isset($_REQUEST["speaciality"])) { $speaciality = $_REQUEST["speaciality"]; } else { $speaciality = ""; }
if (isset($_REQUEST["anesthesiatype"])) { $anesthesiatype = $_REQUEST["anesthesiatype"]; } else { $anesthesiatype = ""; }
if (isset($_REQUEST["theatrecode"])) { $theatrecode = $_REQUEST["theatrecode"]; } else { $theatrecode = ""; }
if (isset($_REQUEST["surgeontype"])) { $surgeontype = $_REQUEST["surgeontype"]; } else { $surgeontype = ""; }


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
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Procedure</strong></div></td>	
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Surgeon</strong></div></td>
			    <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Scrub Nurses</strong></div></td>
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Circulating nurses</strong></div></td>	
			   <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Technician</strong></div></td>
			  
			 
            </tr>
			 <?php
			    if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$colorloopcount = '';
					$snocount=0;
					if($procedrype_wise=='proced_wise'){
					?>
				
					<?php
			$querycr1in = "SELECT * FROM `master_theatre_booking` WHERE  proceduretype='$proceduretype' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' ";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($rescr1 = mysqli_fetch_array($execcr1))
			 {
			 $patientcode=$rescr1['patientcode'];
			 $proceduretype=$rescr1['proceduretype'];
			 $theatrecode = $rescr1['theatrecode'];
			 $ward = $rescr1['ward'];
			 $surgerydatetime = $rescr1['surgerydatetime'];
			 $bookingid = $rescr1['auto_number'];
			 $category=$rescr1['category'];
			   $cancelreason=$rescr1['cancel_reason'];
			 
			 
			 
			 $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			 
			 
			 
			 $query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			
			$query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
			  $stringname='';
			  $query781 = "select b.employeename from theatre_panel_circulating_nurse as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.circulatingnurse_id COLLATE latin1_general_ci)  where a.booking_id='$bookingid'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res781 = mysqli_fetch_array($exec781)){
			  $employeename = $res781['employeename'];
			  if($stringname=='')
				{
				$stringname= $employeename;
				}else
				{
				$stringname= $stringname.','.$employeename;
				}
				}
			  $stringnametech='';
			  $query78 = "select  b.employeename from theatre_panel_technician as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.technician_id COLLATE latin1_general_ci)   where a.booking_id='$bookingid'";
			  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res78 = mysqli_fetch_array($exec78)){
			  $res78employeename = $res78['employeename'];
			  if($stringnametech=='')
				{
				$stringnametech= $res78employeename;
				}else
				{
				$stringnametech= $stringnametech.','.$res78employeename;
				}
				} 
			  $stringnamscrube='';
			  $query71 = "select b.employeename from theatre_panel_scrubnurses as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.scrubnurse_id COLLATE latin1_general_ci)    where a.booking_id='$bookingid'";
			  $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res71 = mysqli_fetch_array($exec71)){
			  $res71employeename = $res71['employeename'];
			  if($stringnamscrube=='')
				{
				$stringnamscrube= $res71employeename;
				}else
				{
				$stringnamscrube= $stringnamscrube.','.$res71employeename;
				}
				}
			  
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
				$stringbigname='';
				$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$procedure_id = $res3_012['proceduretype_id'];
				//$proceduretype_anum= $res3_012['proceduretype_anum'];
				
				//$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$proceduretype_anum'";
				//$exec3_013 = mysql_query($query3_013) or die ("Error in Query3_013".mysql_error());
				//$res3_013 = mysql_fetch_array($exec3_013);
				//$procedure = $res3_013['speaciality_subtype_name'];			
				if($stringbigname=='')
				{
				$stringbigname= $procedure_id;
				}else
				{
				$stringbigname= $stringbigname.','.$procedure_id;
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
			 
			 <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $patientcode; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $patientname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $theatrename; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $ward_name; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($category); ?></td>	   
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($proceduretype); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $surgerydatetime; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname1; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnamscrube; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnametech; ?></td>
			  </tr>
			 
			 <?php
			 }
			 }
			 
			        if($procedrype_wise=='category_wise'){
					?>
									<?php
			 $querycr1in = "SELECT * FROM `master_theatre_booking` WHERE  category='$category' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' ";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($rescr1 = mysqli_fetch_array($execcr1))
			 {
			 $patientcode=$rescr1['patientcode'];
			 $category=$rescr1['category'];
			 $theatrecode = $rescr1['theatrecode'];
			 $ward = $rescr1['ward'];
			 $surgerydatetime = $rescr1['surgerydatetime'];
			 $bookingid = $rescr1['auto_number'];
			  $proceduretype=$rescr1['proceduretype'];
			  $cancelreason=$rescr1['cancel_reason'];
			 
			 $query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			
			 $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			 
			$query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
			  
			  
			   $stringname='';
			  $query781 = "select b.employeename from theatre_panel_circulating_nurse as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.circulatingnurse_id COLLATE latin1_general_ci) where a.booking_id='$bookingid'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res781 = mysqli_fetch_array($exec781)){
			  $employeename = $res781['employeename'];
			  if($stringname=='')
				{
				$stringname= $employeename;
				}else
				{
				$stringname= $stringname.','.$employeename;
				}
				}
			  $stringnametech='';
			  $query78 = "select  b.employeename from theatre_panel_technician as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.technician_id COLLATE latin1_general_ci) where a.booking_id='$bookingid'";
			  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res78 = mysqli_fetch_array($exec78)){
			  $res78employeename = $res78['employeename'];
			  if($stringnametech=='')
				{
				$stringnametech= $res78employeename;
				}else
				{
				$stringnametech= $stringnametech.','.$res78employeename;
				}
				} 
			  $stringnamscrube='';
			  $query71 = "select b.employeename from theatre_panel_scrubnurses as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.scrubnurse_id COLLATE latin1_general_ci) where a.booking_id='$bookingid'";
			  $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res71 = mysqli_fetch_array($exec71)){
			  $res71employeename = $res71['employeename'];
			  if($stringnamscrube=='')
				{
				$stringnamscrube= $res71employeename;
				}else
				{
				$stringnamscrube= $stringnamscrube.','.$res71employeename;
				}
				}
			  
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
				$stringbigname='';
				$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$procedure_id = $res3_012['proceduretype_id'];
				$proceduretype_anum= $res3_012['proceduretype_anum'];
				$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$proceduretype_anum'";
				$exec3_013 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_013) or die ("Error in Query3_013".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3_013 = mysqli_fetch_array($exec3_013);
				$procedure = $res3_013['speaciality_subtype_name'];			
				if($stringbigname=='')
				{
				$stringbigname= $procedure;
				}else
				{
				$stringbigname= $stringbigname.','.$procedure;
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
			 
			 <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $theatrename; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $ward_name; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($category); ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($proceduretype); ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $surgerydatetime; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname1; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnamscrube; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnametech; ?></td>
			  
			  </tr>
			 
			 <?php
			 }
			  
			 }
			 
			        if($procedrype_wise=='speca_wise'){ ?>
			
			  <?php
			  
			  $query1 = "SELECT a.booking_id,a.proceduretype_anum,b.speaciality_id,c.patientcode,c.theatrecode,c.ward,a.proceduretype_id,c.category,c.proceduretype,c.surgerydatetime,c.cancel_reason FROM `theatre_booking_proceduretypes` as a Left Join master_theatrespeaciality_subtype As b on(b.auto_number=a.proceduretype_anum) Left Join master_theatre_booking As c on(c.auto_number=a.booking_id) WHERE b.speaciality_id like '%$speaciality%' and c.starttime <>'0000-00-00 00:00:00' and date(c.starttime) BETWEEN '$ADate1' AND '$ADate2' ";
			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 while ($res1 = mysqli_fetch_array($exec1))
			 {
			 $count='';
			 $booking_id = $res1['booking_id'];
			 $category=$res1['category'];
			 $proceduretype_anum = $res1['proceduretype_anum'];
			 $speaciality_id = $res1['speaciality_id'];
			 $surgerydatetime = $res1['surgerydatetime'];
			 $proceduretype=$res1['proceduretype'];
			  $cancelreason=$res1['cancel_reason'];
			 
			 $patientcode=$res1['patientcode'];
			 $theatrecode = $res1['theatrecode'];
			 $ward = $res1['ward'];
			 $proceduretype_id = $res1['proceduretype_id'];
			 
			 $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			 
			 $stringname='';
			  $query781 = "select b.employeename from theatre_panel_circulating_nurse as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.circulatingnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res781 = mysqli_fetch_array($exec781)){
			  $employeename = $res781['employeename'];
			  if($stringname=='')
				{
				$stringname= $employeename;
				}else
				{
				$stringname= $stringname.','.$employeename;
				}
				}
			  $stringnametech='';
			  $query78 = "select  b.employeename from theatre_panel_technician as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.technician_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res78 = mysqli_fetch_array($exec78)){
			  $res78employeename = $res78['employeename'];
			  if($stringnametech=='')
				{
				$stringnametech= $res78employeename;
				}else
				{
				$stringnametech= $stringnametech.','.$res78employeename;
				}
				} 
			  $stringnamscrube='';
			  $query71 = "select b.employeename from theatre_panel_scrubnurses as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.scrubnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res71 = mysqli_fetch_array($exec71)){
			  $res71employeename = $res71['employeename'];
			  if($stringnamscrube=='')
				{
				$stringnamscrube= $res71employeename;
				}else
				{
				$stringnamscrube= $stringnamscrube.','.$res71employeename;
				}
				}
			 
			  $query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			 
			 $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
			 
			  $query11 = "SELECT * FROM `master_theatrespeaciality` WHERE auto_number= '$speaciality_id' order by auto_number";
			 $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res11 = mysqli_fetch_array($exec11);
             $res11speaciality_name = $res11['speaciality_name'];
			 
			 
			 $stringbigname1='';
				 $query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$booking_id'";
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
			<tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $theatrename; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $ward_name; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($category); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($proceduretype); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $surgerydatetime; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $proceduretype_id; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnamscrube; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnametech; ?></td>
			  
			  </tr>
		
			 <?php
			 }
			  }
			 
			 		if($procedrype_wise=='anesthesia_wise'){   ?>
			<?php
			//$rows_cnt='0';
			   $querycr1in = "SELECT * FROM `master_theatre_booking` WHERE  anesthesiatype like '%$anesthesiatype%' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' order by anesthesiatype ";
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
			 $anesthesiatype = $resccr1['anesthesiatype']; 
			 $booking_id = $resccr1['auto_number'];
			 $category=$resccr1['category'];
			 $surgerydatetime = $resccr1['surgerydatetime'];
			 $proceduretype=$resccr1['proceduretype'];
			 $cancelreason=$resccr1['cancel_reason'];
			  $patientcode=$resccr1['patientcode'];
			 $theatrecode = $resccr1['theatrecode'];
			 $ward = $resccr1['ward'];
			 
			  $stringname='';
			  $query781 = "select b.employeename from theatre_panel_circulating_nurse as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.circulatingnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res781 = mysqli_fetch_array($exec781)){
			  $employeename = $res781['employeename'];
			  if($stringname=='')
				{
				$stringname= $employeename;
				}else
				{
				$stringname= $stringname.','.$employeename;
				}
				}
			  $stringnametech='';
			  $query78 = "select  b.employeename from theatre_panel_technician as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.technician_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res78 = mysqli_fetch_array($exec78)){
			  $res78employeename = $res78['employeename'];
			  if($stringnametech=='')
				{
				$stringnametech= $res78employeename;
				}else
				{
				$stringnametech= $stringnametech.','.$res78employeename;
				}
				} 
			  $stringnamscrube='';
			  $query71 = "select b.employeename from theatre_panel_scrubnurses as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.scrubnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res71 = mysqli_fetch_array($exec71)){
			  $res71employeename = $res71['employeename'];
			  if($stringnamscrube=='')
				{
				$stringnamscrube= $res71employeename;
				}else
				{
				$stringnamscrube= $stringnamscrube.','.$res71employeename;
				}
				}
			 
			 
			 
			 
			 $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			 
			$query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			 
			 $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			 $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res7811 = mysqli_fetch_array($exec7811);
			 $theatrename = $res7811['theatrename'];
			 
			 $stringbigname1='';
				 $query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$booking_id'";
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
			 
			 
			 $stringbigname='';
				$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$booking_id'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$procedure_id = $res3_012['proceduretype_id'];
				$proceduretype_anum= $res3_012['proceduretype_anum'];
				$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$proceduretype_anum'";
				$exec3_013 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_013) or die ("Error in Query3_013".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3_013 = mysqli_fetch_array($exec3_013);
				$procedure = $res3_013['speaciality_subtype_name'];			
				if($stringbigname=='')
				{
				$stringbigname= $procedure;
				}else
				{
				$stringbigname= $stringbigname.','.$procedure;
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
			  
			<tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $theatrename; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $ward_name; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($category); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($proceduretype); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $surgerydatetime; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname1; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnamscrube; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnametech; ?></td>
			  
			  </tr>
			 
			<?php
			}
			
			 
			   }
			 
			 		if($procedrype_wise=='theatre_wise'){   ?>
			
			
			<?php
			//$rows_cnt='0';
			   $querycr1in = "SELECT *  FROM `master_theatre_booking` WHERE  theatrecode like '%$theatrecode%' and  starttime <>'0000-00-00 00:00:00' and  date(starttime)  BETWEEN '$ADate1' AND '$ADate2' order by theatrecode ";
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
		  	 $anesthesiatype = $resccr1['anesthesiatype']; 
			 $booking_id = $resccr1['auto_number'];
			 $category=$resccr1['category'];
			 $surgerydatetime = $resccr1['surgerydatetime'];
			 $proceduretype=$resccr1['proceduretype'];
			 $cancelreason=$resccr1['cancel_reason'];
			 $patientcode=$resccr1['patientcode'];
			 $theatrecode = $resccr1['theatrecode'];
			 $ward = $resccr1['ward'];
			 
		     $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			 
			$query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			 
			 $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			 $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res7811 = mysqli_fetch_array($exec7811);
			 $theatrename = $res7811['theatrename'];
			 
			 
			  $stringname='';
			  $query781 = "select b.employeename from theatre_panel_circulating_nurse as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.circulatingnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res781 = mysqli_fetch_array($exec781)){
			  $employeename = $res781['employeename'];
			  if($stringname=='')
				{
				$stringname= $employeename;
				}else
				{
				$stringname= $stringname.','.$employeename;
				}
				}
			  $stringnametech='';
			  $query78 = "select  b.employeename from theatre_panel_technician as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.technician_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res78 = mysqli_fetch_array($exec78)){
			  $res78employeename = $res78['employeename'];
			  if($stringnametech=='')
				{
				$stringnametech= $res78employeename;
				}else
				{
				$stringnametech= $stringnametech.','.$res78employeename;
				}
				} 
			  $stringnamscrube='';
			  $query71 = "select b.employeename from theatre_panel_scrubnurses as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.scrubnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res71 = mysqli_fetch_array($exec71)){
			  $res71employeename = $res71['employeename'];
			  if($stringnamscrube=='')
				{
				$stringnamscrube= $res71employeename;
				}else
				{
				$stringnamscrube= $stringnamscrube.','.$res71employeename;
				}
				}
			 
			 
			 
			     $stringbigname1='';
				 $query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$booking_id'";
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
			 
			 
			    $stringbigname='';
				$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$booking_id'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$procedure_id = $res3_012['proceduretype_id'];
				$proceduretype_anum= $res3_012['proceduretype_anum'];
				$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$proceduretype_anum'";
				$exec3_013 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_013) or die ("Error in Query3_013".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3_013 = mysqli_fetch_array($exec3_013);
				$procedure = $res3_013['speaciality_subtype_name'];			
				if($stringbigname=='')
				{
				$stringbigname= $procedure;
				}else
				{
				$stringbigname= $stringbigname.','.$procedure;
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
			  
			 
			<tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $theatrename; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $ward_name; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($category); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($proceduretype); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $surgerydatetime; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnamscrube; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnametech; ?></td>
			  
			  </tr>
			 
			<?php
			}
			    }
			   		
					if($procedrype_wise=='surgeon_wise'){  
		
			   ?>
			
			<?php
			//$rows_cnt='0';
			
			     $querycr1in = "SELECT a.surgeon_id,b.anesthesiatype,b.auto_number,b.category,b.surgerydatetime,b.proceduretype ,b.cancel_reason,b.theatrecode,b.ward,b.patientcode  FROM `theatre_booking_surgeons` as a join `master_theatre_booking` as b on (b.auto_number=a.booking_id)  WHERE  a.surgeon_id like '%$surgeontype%' and  b.starttime <>'0000-00-00 00:00:00' and  date(b.starttime)  BETWEEN '$ADate1' AND '$ADate2' order by a.surgeon_id ";
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			  while ($resccr1 = mysqli_fetch_array($execcr1))
			 {
			 $surgeon_id = $resccr1['surgeon_id'];
			 $anesthesiatype = $resccr1['anesthesiatype']; 
			 $booking_id = $resccr1['auto_number'];
			 $category=$resccr1['category'];
			 $surgerydatetime = $resccr1['surgerydatetime'];
			 $proceduretype=$resccr1['proceduretype'];
			 $cancelreason=$resccr1['cancel_reason'];
			 $patientcode=$resccr1['patientcode'];
			 $theatrecode = $resccr1['theatrecode'];
			 $ward = $resccr1['ward'];
			 
				   $query3_0121 = "select * from master_ward where auto_number = '$ward'";
			 $exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res3_0121 = mysqli_fetch_array($exec3_0121);
			 $ward_name = $res3_0121['ward'];
			 
			$query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			 
			 $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			 $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			 $res7811 = mysqli_fetch_array($exec7811);
			 $theatrename = $res7811['theatrename'];
			 
			 
			 $stringname='';
			  $query781 = "select b.employeename from theatre_panel_circulating_nurse as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.circulatingnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec781 = mysqli_query($GLOBALS["___mysqli_ston"], $query781) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res781 = mysqli_fetch_array($exec781)){
			  $employeename = $res781['employeename'];
			  if($stringname=='')
				{
				$stringname= $employeename;
				}else
				{
				$stringname= $stringname.','.$employeename;
				}
				}
			  $stringnametech='';
			  $query78 = "select  b.employeename from theatre_panel_technician as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.technician_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res78 = mysqli_fetch_array($exec78)){
			  $res78employeename = $res78['employeename'];
			  if($stringnametech=='')
				{
				$stringnametech= $res78employeename;
				}else
				{
				$stringnametech= $stringnametech.','.$res78employeename;
				}
				} 
			  $stringnamscrube='';
			  $query71 = "select b.employeename from theatre_panel_scrubnurses as a join `master_employee` as b on (b.employeecode COLLATE latin1_general_ci=a.scrubnurse_id COLLATE latin1_general_ci) where a.booking_id='$booking_id'";
			  $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res71 = mysqli_fetch_array($exec71)){
			  $res71employeename = $res71['employeename'];
			  if($stringnamscrube=='')
				{
				$stringnamscrube= $res71employeename;
				}else
				{
				$stringnamscrube= $stringnamscrube.','.$res71employeename;
				}
				}
			 
			 
			 $query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surgeon_id'";
				$exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_t = mysqli_fetch_assoc($exec_t);
			    $newdoctorname=$res_t['doctorname'];
			 
			    $stringbigname='';
				$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$booking_id'";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res3_012 = mysqli_fetch_array($exec3_012)){
				$procedure_id = $res3_012['proceduretype_id'];
				$proceduretype_anum= $res3_012['proceduretype_anum'];
				$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$proceduretype_anum'";
				$exec3_013 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_013) or die ("Error in Query3_013".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res3_013 = mysqli_fetch_array($exec3_013);
				$procedure = $res3_013['speaciality_subtype_name'];			
				if($stringbigname=='')
				{
				$stringbigname= $procedure;
				}else
				{
				$stringbigname= $stringbigname.','.$procedure;
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
			<tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $patientname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $theatrename; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $ward_name; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($category); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo strtoupper($proceduretype); ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $surgerydatetime; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $stringbigname; ?></td>
			  <td class="bodytext31" valign="center"  align="left"> <?php echo $newdoctorname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnamscrube; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringname; ?></td>
			   <td class="bodytext31" valign="center"  align="left"> <?php echo $stringnametech; ?></td>
			  
			  </tr>
			 
			<?php
			}
			
			   
			      }
			
				}
			    ?>
			 
	 </tbody>
	 </table>
	 </td>
	 </tr>
			 
			
			
			
			
			