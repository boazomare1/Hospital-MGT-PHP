<?php
session_start();
include ("db/db_connect.php");
ob_start();
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="TheatreRegisterReport.xls"');
header('Cache-Control: max-age=80');
?>

<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> View Theatre Booking Report</strong></td>
             
     
              
              </tr>
</table>

<table width="980" border="0" cellspacing="0" cellpadding="0" style="margin:30px;">
	<tr>
	    <td colspan="2" align="left">&nbsp;</td>
	</tr>
	
</table>
<table width="116%" border="0" cellspacing="0" cellpadding="0">
	
		
		<tr>
		<td>
	    <!-- start loop -->
	    <?php
	    	$query10 = "select * from master_theatre where recordstatus <> 'deleted'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		    while($res10 = mysqli_fetch_array($exec10)){
		    	//print_r($res10);
		    	$theatre_anum = $res10['auto_number'];
		    	$theatre_nm = $res10['theatrename'];
		    
	    ?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
          	<tr>
              <td colspan="15" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong><?php echo $theatre_nm;?></strong></div></td>
              </tr>
            <tr>
              
				 <td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
           
				 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code</strong></div></td>
				 <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Procedure type</strong></div></td>
                <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Specialty</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Surgery Date</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Surgeon</strong></div></td>
                <!-- <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Anaesthesist</strong></div></td> -->
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Anaesthisia type</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Estimated time</strong></div></td>
                <!--<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>-->
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cancel reason</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient status</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Procedure</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Anaesthesist</strong></div></td>
                <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
                
              </tr>
            <?php
		        $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1location = $res1["locationname"]; 
				$res1locationcode = $res1["locationcode"];
				$patientlocationcode = $res1locationcode;

				// var_dump($res1location);		
		   ?>
           <?php
            $colorloopcount ='';
            
			//$query2 = "select * from master_ipvisitentry where locationcode='$res1locationcode' and discharge='completed'";
			$from_date_new = date('Y-m-d H:i:s', strtotime($fromdate));
			$to_date_new = date('Y-m-d 23:59:59', strtotime($todate));

			$query2 = "select * from master_theatre_booking where theatrecode = '$theatre_anum' and locationcode='$patientlocationcode' and approvalstatus = 'Pending'  and date between '$from_date_new' and '$to_date_new' order by auto_number desc";

			//echo $query2;
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
			
			while($res2 = mysqli_fetch_array($exec2))
			{
			
			$bookingid= $res2['auto_number'];
			$patientcode=$res2['patientcode'];
			$visitcode = $res2['patientvisitcode'];
			$theatrecode = $res2['theatrecode'];
		    $procedure_type = $res2['proceduretype'];
		    $category = $res2['category'];
		    $speaciality = $res2['speaciality'];
		    $surgerydatetime = $res2['surgerydatetime'];
		    $estimatedtime = $res2['estimatedtime'];
		    $approvalstatus = $res2['approvalstatus'];
		    $start_time = $res2['starttime'];
		    $stop_time = $res2['endtime'];
		    $surgeon = $res2['surgeon'];
		    $anesthesia = $res2['anesthesia'];
		    $anesthesiatype=$res2['anesthesiatype'];
		    $cancelreason=$res2['cancel_reason'];
		    $patientstatus=$res2['patientstatus'];
		    $ward = $res2['ward'];
            
            if($surgeon != ''){
		  	    	$query_sg_10 = "
		  		 SELECT doctorname,doctorcode FROM master_doctor 
		  		 WHERE doctorcode = '$surgeon' ";
		  		 //
		  		 $exec_sg_10 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sg_10) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				 while ($res_sg_10 = mysqli_fetch_array($exec_sg_10))
				 {
					$doccode0 = $res_sg_10["doctorcode"]; 
					$docname0 = $res_sg_10["doctorname"];
					$doctitle0 = $res_sg_10["doctorname"];
				}
			}else{
				$docname0 = '--';
			}

			if($anesthesia != ''){
	  	    	$query_sg_12 = "
		  		 SELECT doctorname, doctorcode FROM master_doctor 
		  		 WHERE doctorcode = '$anesthesia'";
		  		 //
		  		 $exec_sg_12 = mysqli_query($GLOBALS["___mysqli_ston"], $query_sg_12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
				 while ($res_sg_12 = mysqli_fetch_array($exec_sg_12))
				 {
					$doccode2 = $res_sg_12["doctorcode"]; 
					$docname2 = $res_sg_12["doctorname"];
					$doctitle2 = $res_sg_12["doctorname"]; 
				}
			}else{
				$docname2 = '--';
			}
            // get patient details
            // get age and gender
            $query67 = "select * from master_customer where customercode='$patientcode'";
			$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
			$res67 = mysqli_fetch_array($exec67);
			$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
			//$gender = $res67['gender'];
			//$age = $res67['age'];

		    // get 
              $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
			  
			  $query50 = "select * from master_department where auto_number='$speaciality'";
              $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res50 = mysqli_fetch_array($exec50);
			  $speacialityname = $res50['department'];


				$query56="select * from master_theatrespeaciality";
				$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res56= mysqli_fetch_array($exec56);

				$speacialityname=$res56['speaciality_name'];

				$query58="select * from master_doctor";
				$exec58=mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res58= mysqli_fetch_array($exec58);

				$doctorname=$res58['doctorname'];


				

				$query58="select * from master_doctor";
				$exec58=mysqli_query($GLOBALS["___mysqli_ston"], $query58) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res58= mysqli_fetch_array($exec58);

				$doctorname=$res58['doctorname'];

				





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
             
			    <td align="left" valign="center" class="bodytext31">
			       <div align="left"><?php echo $patientname; ?></div>
			    </td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $procedure_type; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $category; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $speacialityname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $surgerydatetime; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php
				$stringbigname1='';
				 $query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$bookingid'";
						$exec_surg_doc = mysqli_query($GLOBALS["___mysqli_ston"], $query_surg_doc) or die ("Error in query_surg_doc".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_surg_doc = mysqli_fetch_array($exec_surg_doc)){
							//
							$surg_id = $res_surg_doc['surgeon_id'];
/*							echo $surg_id;
*/
							$query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surg_id'";
				
				$exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));

				/*echo "<option value=''>Select Services</option>";*/
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
						echo $stringbigname1;

					 ?>	</td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $anesthesiatype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $estimatedtime; ?></td>
				<!--<td  align="center" valign="center" class="bodytext31">
					<?php 
						//echo $speacialityname; 
						$query3_0121 = "select * from master_ward where auto_number = '$ward'";
						$exec3_0121 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_0121) or die ("Error in Query3_0121".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_0121 = mysqli_fetch_array($exec3_0121)){
							//
							$ward_name = $res3_0121['ward'];

							echo $ward_name;
						
						}

					?>
				</td>-->

				<td  align="center" valign="center" class="bodytext31"><?php echo $cancelreason; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientstatus; ?></td>
				<td  align="center" valign="center" class="bodytext31">
					<?php 
					$stringbigname='';
						//echo $speacialityname; 
						
						$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid'";
						$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_012 = mysqli_fetch_array($exec3_012)){
							//
							$procedure_id = $res3_012['proceduretype_id'];
							//$proceduretype_anum= $res3_012['proceduretype_anum'];
							
							
							
							
				if($stringbigname=='')
				{
				$stringbigname= $procedure_id;
				}else
				{
				$stringbigname= $stringbigname.','.$procedure_id;
				}
							
						
						}
						echo $stringbigname;

					?>
				</td>
				
				<td  align="center" valign="center" class="bodytext31"><?php echo $docname2; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $approvalstatus; ?></td>
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="15" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

            
             	
             	</tr>
             	<tr>
             		<td>&nbsp;</td>
             	</tr>
          </tbody>
        </table>	
        <?php } ?>	
      <!-- loop end -->
    </td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
				<tr>
        <td>&nbsp;</td>
        </tr>  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>


      </tr>
    </table>
  </table>


