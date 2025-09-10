<html>
<?php include ("db/db_connect.php"); ?>
<?php
$timeonly = date('H:i:s');
$updatedatetime = date('Y-m-d H:i:s');

?>
<style>
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="660" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong> MCH Consultation List</strong> </td>
			  <td bgcolor="#ecf0f5" class="bodytext31"></td>
              </tr>
            <tr>
              <!--<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>-->
				 <td width="10%"  align="left" valign="center" colspan="3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date </strong></div></td>
				<!--<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient code </strong></div></td>
					<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit code </strong></div></td>-->
              <td width="20%"  align="left" valign="center" colspan="3" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name </strong></div></td>
              <!--<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulting Doctor </strong></div></td>-->
             
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Status</strong></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
	
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
			$query1 = "select * from master_visitentry where department='3' and doctorconsultation <> 'completed' and paymentstatus = 'completed' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$query32="select * from master_doctor where auto_number='$consultingdoctorname'";
			$exec32=mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res32=mysqli_fetch_array($exec32);
			$doctorname=$res32['doctorname'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];
			$consultationtime = $res1['consultationtime']; 
			$consultationfees = $res1['consultationfees'];
			$accountname=$res1['accountname'];	
			$query33="select * from master_accountname where auto_number='$accountname'";
			$exec33=mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res33=mysqli_fetch_array($exec33);
			$accname=$res33['accountname'];
		
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
              <!--<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>-->
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $consultationdate; ?></div></td>
				 <!--<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>-->
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname.'('.$patientcode.','.$visitcode.')'; ?></div></td>
              <!--<td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $doctorname;?>			      </div></td>-->
             
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="mchconsultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Consult</strong></a></div></td>
              </tr>
			<?php
			}    
			?>
			<?php
				$query11 = "select * from master_visitentry where referalconsultation <> 'completed' and paymentstatus = 'completed' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res11 = mysqli_fetch_array($exec11))
			{
			$patientcode1 = $res11['patientcode'];
			$visitcode1 = $res11['visitcode'];
			$patientfirstname1 = $res11['patientfirstname'];
			$patientmiddlename1=$res11['patientmiddlename'];
			$patientlastname1 = $res11['patientlastname'];
			$consultingdoctorname1 = $res11['consultingdoctor'];
			$billtype = $res11['billtype'];
			$referalbill = $res11['referalbill'];
			$query321="select * from master_doctor where auto_number='$consultingdoctorname1'";
			$exec321=mysqli_query($GLOBALS["___mysqli_ston"], $query321) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res321=mysqli_fetch_array($exec321);
			$doctorname1=$res321['doctorname'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate1 = $res11['consultationdate'];
			$consultationtime1 = $res11['consultationtime']; 
			$consultationfees1 = $res11['consultationfees'];
			$accountname1=$res11['accountname'];	
			$query331="select * from master_accountname where auto_number='$accountname1'";
			$exec331=mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res331=mysqli_fetch_array($exec331);
			$accname1=$res331['accountname'];
			
			if($billtype == 'PAY NOW')
			{
			if($referalbill == 'completed')
			{
			
			$query12 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode1' and referalcode = '3'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
		
		if($num12 > 0)
		{
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
             <!-- <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>-->
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $consultationdate1; ?></div></td>
				 <!--<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode1; ?></div></td>-->
              <td class="bodytext31" valign="center"  align="left" colspan="3">
			  <div class="bodytext31"><?php echo $patientfirstname1.' '.$patientmiddlename1.' '.$patientlastname1.'('.$patientcode.','.$visitcode.')'; ?></div></td>
              <!--<td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $doctorname1;?>			      </div></td>-->
             
              <td class="bodytext31" valign="center"  align="left" colspan="3">
			    <div align="left"><?php echo $accname1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="mchconsultationform.php?patientcode=<?php echo $patientcode1; ?>&&visitcode=<?php echo $visitcode1; ?>"><strong>Consult</strong></a></div></td>
              </tr>
			<?php
			}
			}
			}    
			if($billtype == 'PAY LATER')
			{
			if($referalbill == '')
			{
			
			$query12 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode1' and referalcode = '3'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
		
		if($num12 > 0)
		{
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
              <!--<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>-->
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $consultationdate1; ?></div></td>
				<!-- <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode1; ?></div></td>-->
              <td class="bodytext31" valign="center"  align="left" colspan="3">
			  <div class="bodytext31"><?php echo $patientfirstname1.' '.$patientmiddlename1.' '.$patientlastname1.'('.$patientcode.','.$visitcode.')'; ?></div></td>
              <!--<td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $doctorname1;?>			      </div></td>-->
             
              <td class="bodytext31" valign="center"  align="left" colspan="3">
			    <div align="left"><?php echo $accname1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="mchconsultationform.php?patientcode=<?php echo $patientcode1; ?>&&visitcode=<?php echo $visitcode1; ?>"><strong>Consult</strong></a></div></td>
              </tr>
			<?php
			}
			}
			}    
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              </tr>
          </tbody>
        </table>
    
</body>
</html>