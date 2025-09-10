<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

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
 
$thismonth=$year."-".$month."___";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
	}


// delete payment voucher
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	//$query3 = "update master_transactionpharmacy set recordstatus = 'deleted' where auto_number = '$delanum'";
	$query3 = "DELETE FROM master_theatre_booking WHERE auto_number = '$delanum' ";
	$query4 = "DELETE FROM master_theatre_equipments WHERE theatrebookingcode = '$delanum' ";

	//echo $query3;

	//exit;

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    header("Location: theatrebookinglist.php?st=success");	
}
?>


<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script src="js/datetimepicker_css.js"></script>
<script src="datetimepicker1_css.js"></script>
<style>
.hideClass
{display:none;}
</style>

<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
	}
}

function fundatesearch()
{
	alert();
	var fromdate = $("#ADate1").val();
	var todate = $("#ADate2").val();
	var sortfiled='';
	var sortfunc='';
	
	var dataString = 'fromdate='+fromdate+'&&todate='+todate;
	
	$.ajax({
		type: "POST",
		url: "opipcashbillsajax.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		alert(html);
			//$("#insertplan").empty();
			//$("#insertplan").append(html);
			//$("#hiddenplansearch").val('Searched');
			
		}
	});
}

function funcDeleteBooking(varBookingNumber)

{



     var varBookingNumber = varBookingNumber;

	 var fRet;

	fRet = confirm('Are you sure want to delete this Theatre Booking '+varBookingNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Theatre Booking Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Theatre Booking Delete Failed.");

		return false;

	}



}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top">
 <form name="cbform1" method="post">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> View Theatre Booking </strong></td>
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
                  <?php
						
					if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
                  
                  </td>
     
              </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
			    <tr>
            <!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <!--<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>-->
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $todaydate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $todaydate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <!--<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>-->
            </tr>
          </tbody>
        </table>
		</form>	
<table width="980" border="0" cellspacing="0" cellpadding="0" style="margin:30px;">
	<tr>
	    <td colspan="2" align="left">&nbsp;</td>
	</tr>
	
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><a href="theatreregisterreportexcel.php?ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>" target="_blank" style="background-color: green;border: none;color: white;padding: 5px 8px;text-align: center;text-decoration: none;display: inline-block;font-size: 12px;">EXPORT EXCEL</a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="120%" 
            align="left" border="0">
          <tbody>
          	<tr>
              <td colspan="16" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong><?php echo $theatre_nm;?></strong></div></td>
              </tr>
            <tr>
              
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
           
				 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code</strong></div></td>
				 <td width="6%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Procedure type</strong></div></td>
                <td width="3%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Specialty</strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Surgery Date</strong></div></td>
                <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Surgeon</strong></div></td>
                <!-- <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Anaesthesist</strong></div></td> -->
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Anaesthisia type</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Estimated time</strong></div></td>
                <!--<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>-->
                <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cancel reason</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient status</strong></div></td>
                <td width="8%"  align="left" valign="center" 
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


		    $query7812 = "select * from master_doctor where doctorcode='$surgeon'";
			  $exec7812 = mysqli_query($GLOBALS["___mysqli_ston"], $query7812) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7812 = mysqli_fetch_array($exec7812);
			  $surgeonname = $res7812['doctorname'];



		    $query7811 = "select * from master_theatre where auto_number='$theatrecode'";
			  $exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res7811 = mysqli_fetch_array($exec7811);
			  $theatrename = $res7811['theatrename'];
            
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
				
				
				
				$stringbigname12='';
				$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid' ";
				$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
				 $rowscount = mysqli_num_rows($exec3_012);
				 	if($rowscount>0){
				while($res3_012 = mysqli_fetch_array($exec3_012)){
					$speaclity='';
				$procedure_id = $res3_012['proceduretype_id'];
				$iparr = explode (" - ", $procedure_id);
				
				$speaclity 	=$iparr[1];	
				if($stringbigname12=='')
				{
				$stringbigname12= $speaclity;
				}else
				{
				$stringbigname12= $stringbigname12.','.$speaclity;
				}			
				}
				}
				
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
          <tr <?php echo $colorcode; ?>>
             
			    <td align="left" valign="center" class="bodytext31">
			       <div align="left"><?php echo $patientname; ?></div>
			    </td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $procedure_type; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $category; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $stringbigname12; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $surgerydatetime; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php
				
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
					echo $newdoctorname=$res_t['doctorname'];
					echo '<br><hr>' ;
				}
						}


					 ?>	
				
				</td>
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
						//echo $speacialityname; 
						$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid'";
						$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_012 = mysqli_fetch_array($exec3_012)){
							//
						echo	$procedure_id = $res3_012['proceduretype_id'];

							//echo $procedure_id;


							echo '<br><hr>';
						
						}

					?>
				</td>
				
				<td  align="center" valign="center" class="bodytext31"><?php echo $docname2; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $approvalstatus; ?></td>
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="16" align="left" valign="center" bordercolor="#f3f3f3" 
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
<?php include ("includes/footer1.php"); ?>
</body>
</html>

