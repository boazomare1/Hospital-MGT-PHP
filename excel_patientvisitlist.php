<?php

//include ("includes/loginverify.php");

include ("db/db_connect.php");
ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Patient Visit Status Report.xls"');
header('Cache-Control: max-age=80');

//$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');
$username = '';
$companyanum = '';
$companyname = '';
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d',  strtotime('-1 month')); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; if($code == '0'){ $code = "";} } else { $code = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = " "; }
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["ageinp"])) { $ageinp = $_REQUEST["ageinp"]; } else { $ageinp = ""; }
if (isset($_REQUEST["gender"])) { $gender = $_REQUEST["gender"]; } else { $gender = " "; }
if (isset($_REQUEST["dmy"])) { $dmy = $_REQUEST["dmy"]; } else { $dmy = ""; }
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
?>
<table width="78%" height="80" border="0" 

            align="left" cellpadding="2" cellspacing="0" 

            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >

          <tbody>

            <tr>

              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">

                <div align="left"><strong>Patient List </strong></div></td>

			    </tr>

	

            <tr>

			  <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>

              <td width="23%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>

				 <td width="11%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registration No</strong></div></td>

				<td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>

				<td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>

				<td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">Gender</td>

				<td width="18%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Date</strong></div></td>

              <td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
                
                 <td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Refferal</strong></div></td>
				<td width="12%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Type</strong></div></td>

			  <td width="10%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>

           </tr>

			<?php

			

			$colorloopcount = '';
			$sno = 1;

			if($gender != ''){
				
				$gendercondition = " AND gender = '$gender'";
			}
			else{
				$gendercondition = '';
				
			}

			if($department != ''){
				
				$depcondition = " AND departmentname like '$department'";
			}
			else{
				$depcondition = '';
				
			}

			 if($code ==0){		
			$query1 = "select * from master_visitentry where locationcode='$locationcode' and consultationdate between '$ADate1' and '$ADate2' $depcondition $gendercondition order by consultationdate,consultationtime desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			elseif($code == 1){		
			$query1 = "select * from master_visitentry where locationcode='$locationcode' and consultationdate between '$ADate1' and '$ADate2' and visitcount = '1' $depcondition $gendercondition order by consultationdate,consultationtime desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
			$query1 = "select * from master_visitentry where locationcode='$locationcode' and consultationdate between '$ADate1' and '$ADate2' and visitcount NOT IN (1)  $depcondition $gendercondition order by consultationdate,consultationtime desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}

			while ($res1 = mysqli_fetch_array($exec1))

			{

			$patientname = $res1['patientfullname'];

			$registrationno = $res1['patientcode'];

			$visitno = $res1['visitcode'];

			$visitdate =$res1['consultationdate']." ".$res1['consultationtime'];

			$department = $res1['departmentname'];

			$visitcount = $res1['visitcount'];

			$gender = $res1['gender'];
			
			$refferal = $res1['refferal'];
			
			$billtype = $res1['billtype'];

			if($billtype=='PAY NOW'){
				$visittype='Cash';
			}else{
				$visittype='Credit';
			}



			$query751 = "select * from master_customer where customercode = '$registrationno'";
			$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res751 = mysqli_fetch_array($exec751);
			$dob = $res751['dateofbirth'];

			

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
					$age= $diff->y . ' Years';
					$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
					$age =$diff->m . ' Months';
					$monthsdayscondition = 'monthsordays';
				}
				else
				{
					$age =$diff->d . ' Days';
					$monthsdayscondition = 'monthsordays';

				}
					

			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";

			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

			//$res2 = mysql_fetch_array($exec2);

			//$consultingdoctorname  = $res2['doctorname'];

			

			if($visitcount <= 1){$visitcount = 'New';}else{$visitcount = 'Revisit';}

			



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
		if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
				if($execution == 'true'){

					
				?>
				<tr>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>   
				<?php } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
				?>
				  <tr>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>
				<?php } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				?>
				  <tr >

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>

				  

				<?php
				}
				}
			}
			else{
				?>
				  <tr>

				   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $sno++; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $age; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
                 
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refferal;?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visittype;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>

				  </tr>
				<?php				
			}
			}
			
			

			 

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

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