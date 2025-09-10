<?php

//include ("includes/loginverify.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$colorloopcount = '';

$sno = '';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="consultationfees_report.xls"');

header('Cache-Control: max-age=80');



if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

if (isset($_REQUEST["visitcode"])) { $cbvisitcode = $_REQUEST["visitcode"]; } else { $cbvisitcode = ""; }

if (isset($_REQUEST["cbpatientcode"])) { $cbpatientcode = $_REQUEST["cbpatientcode"]; } else { $cbpatientcode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if($cbfrmflag1 == 'cbfrmflag1'){
?>

<table  border="1" cellspacing="0" cellpadding="2">

<tr>

<td>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%"  align="left" border="1">

          <tbody>


			<tr>

			 <td class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><strong>No.</strong></td>

			 <td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>

			 <td width="" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong> Reg No. </strong></td>

			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Visit Code </strong></td>
			
			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Consultating Doctor </strong></td>

			<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Department </strong></td>

			<td width="" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong> Doctor Consultation </strong></td>
			
			<td width="" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong> Consultation Type</strong></td>

			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Diagnosis </strong></div></td>

						<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Created By </strong></div></td>

			
			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcount </strong></div></td>

			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Time Visit</strong></div></td>
			
			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Last Visit</strong></div></td>
			
			<td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Diff(Hrs)</strong></div></td>

			</tr>


<?php  
			
			$query1 = "select * from master_visitentry where consultationdate between '$ADate1' and '$ADate2' and patientfullname like '%$cbcustomername%' and visitcode like '%$cbvisitcode%' and consultationfees = '0' and patientcode like '%$cbpatientcode%' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$visitcode = $res1['visitcode'];
				$patientcode = $res1['patientcode'];
				$patientfullname = $res1['patientfullname'];
				$departmentname = $res1['departmentname'];
				$doctorconsultation = $res1['doctorconsultation'];
				$visitcount = $res1['visitcount'];
				$consultationtype = $res1['consultationtype'];
				$consultingdoctor = $res1['consultingdoctor'];
				$consultationdate = $res1['consultationdate'];
				$consultationtime = $res1['consultationtime'];
				$res1vistdatetime = $consultationdate.' '.$consultationtime;
				$autonumber=$res1['auto_number'];
				$username=$res1['username'];
			
					$query5 = "select * from consultation_icd where patientvisitcode = '$visitcode'";
					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res5 = mysqli_fetch_array($exec5);
					$primarydiag = $res5['primarydiag'];
					
					
					$query58 = "select * from master_consultationtype where auto_number = '$consultationtype'";
					$exec58 = mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die ("Error in Query58".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res58 = mysqli_fetch_array($exec58);
					$res58consultationtype = $res58['consultationtype'];
					
					
					 $query51 = "select * from master_visitentry where patientcode = '$patientcode' and visitcode !='$visitcode' and auto_number <'$autonumber' order by auto_number desc limit 0,1";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num51 = mysqli_num_rows($exec51);
					$res51 = mysqli_fetch_array($exec51);
					$res51consultationdate= $res51['consultationdate'];
					$res51consultationtime= $res51['consultationtime'];
					if($num51>0){
					$res51lastvistdatetime = $res51consultationdate.' '.$res51consultationtime;
					
					$diff = strtotime($res1vistdatetime) - strtotime($res51lastvistdatetime);
					$days_diff = round($diff/3600);

					} else {
						$res51consultationdate='0000-00-00';
						$res51lastvistdatetime='0000-00-00';
						$days_diff='0';
					}
					//$diff = abs(strtotime($consultationdate) - strtotime($res51consultationdate));
			
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
			<tr >
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $sno = $sno + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientfullname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $patientcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $visitcode; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $consultingdoctor; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $departmentname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $doctorconsultation; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res58consultationtype; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $primarydiag; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $username; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $visitcount; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res1vistdatetime; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res51lastvistdatetime; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $days_diff; ?></div></td>
			</tr>
			
			<?php
			}
			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"   bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"   bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

            

             

              </tr>

          </tbody>

        </table>
		
		</td>
		</tr>
		</table>

<?php } ?>








