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
    
    header("Location: theatreregistration.php?st=success");	
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
<script src="js/jquery-1.11.1.min.js"></script>
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
function view_pop(varCallFrom,id){
   
    window.open("popup_doctornotes.php?frm="+varCallFrom+'&id='+id,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	return false;

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
              <!--
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
                 
            </tr>
        -->
          </tbody>
        </table>
		</form>	
<table width="980" border="0" cellspacing="0" cellpadding="0" style="margin:30px;">
	<tr>
	    <td colspan="2">&nbsp;</td>
	</tr>
</table>
<table width="116%" border="0" cellspacing="0" cellpadding="0">

		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1300" 
            align="left" border="0">
          <tbody>
          	<tr>
              <td colspan="12" bgcolor="#ecf0f5" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Theatre Booking List</strong></div></td>
              </tr>
            <tr>
              
				 <td  width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name</strong></div></td>
           
				 <td  width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code</strong></div></td>
				 <td  width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Theatre</strong></div></td>
				 <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Procedure Type</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
				<!-- <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Speaciality</strong></div></td> -->
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Surgery Date</strong></div></td>
                <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
                <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Estimated Time</strong></div></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Elapsed Time</strong></div></td>
                <td width="40%"  colspan="2" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
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
			//$from_date_new = date('Y-m-d H:i:s', strtotime($fromdate));
			//$to_date_new = date('Y-m-d H:i:s', strtotime($todate));
            $timestamp = date('Y-m-d H:i:s');
			$from_date_new = date('Y-m-d 00:00:00');
			$to_date_new = date('Y-m-d 23:59:59');

			$query2 = "select * from master_theatre_booking where locationcode='$patientlocationcode' and approvalstatus != 'Closed' and recordstatus <> 'deleted'  order by proceduretype desc";
			//$query2 = "SELECT * from master_theatre_booking where locationcode='$patientlocationcode' and approvalstatus != 'Completed' and surgerydatetime between DATE_FORMAT('$fromdate', '%Y-%m-%d') and DATE_FORMAT('$todate', '%Y-%m-%d') order by auto_number desc";
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
			  
			  $query50 = "select * from master_theatrespeaciality where auto_number='$speaciality'";
              $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res50 = mysqli_fetch_array($exec50);
			  $speacialityname = $res50['speaciality_name'];
	

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
             
			    <td   align="left" valign="center" class="bodytext31">
			       <div align="left"><?php echo $patientname; ?></div>
			    </td>
				<td   align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td   align="center" valign="center" class="bodytext31"><?php echo $theatrename; ?></td>
				<td  align="center" valign="center" class="bodytext31">
					

					<?php 
						//echo $speacialityname; 
						$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid'";
						$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_012 = mysqli_fetch_array($exec3_012)){
							//
							$proceduretypename = $res3_012['proceduretype_id'];

							//echo $procedure_id;

							/*$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$procedure_id'";
							$exec3_013 = mysql_query($query3_013) or die ("Error in Query3_013".mysql_error());
							$res3_013 = mysql_fetch_array($exec3_013);
							$procedure = $res3_013['speaciality_subtype_name'];*/
							echo $proceduretypename;
							echo '<br><hr>' ;
						
						}

					?>


					
				</td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $category; ?></td>
				<!-- <td  align="center" valign="center" class="bodytext31"><?php echo $speacialityname; ?></td> -->
				<td  align="center" valign="center" class="bodytext31"><?php echo $surgerydatetime; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $approvalstatus; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $estimatedtime; ?>&nbsp;Mins.</td>
				<td  align="center" valign="center" class="bodytext31" style="color:red;">
					<?php 
					   if($approvalstatus =='Inprogress'){
 						     $now = date("Y-m-d H:i:s");

                			 $to_time = strtotime($now);
						     $from_time = strtotime($start_time);
							 

							 $delta_T = ($to_time - $from_time);
							 $day = round(($delta_T % 604800) / 86400); 
							 $hours = round((($delta_T % 604800) % 86400) / 3600); 
							 $minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
							 $sec = round((((($delta_T % 604800) % 86400) % 3600) % 60));

							 //echo $minutes. " Mins";
							 echo $hours . "<small>Hrs</small> &nbsp;".$minutes. " <small>Mins</small>";

					   } elseif($approvalstatus =='Completed'){
  						     $to_time = strtotime($stop_time);
						     $from_time = strtotime($start_time);
							 

							 $delta_T = ($to_time - $from_time);
							 $day = round(($delta_T % 604800) / 86400); 
							 $hours = round((($delta_T % 604800) % 86400) / 3600); 
							 $minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
							 $sec = round((((($delta_T % 604800) % 86400) % 3600) % 60));

							 //echo $minutes. " Mins";
							 echo $hours . "<small>Hrs</small> &nbsp;".$minutes. " <small>Mins</small>";
					   }elseif($approvalstatus =='Pending'){
					   	     echo "--";
					   }
					?>
				</td>
				<td  align="center" valign="center" class="bodytext31"  >				
	            <?php
	                // get master_theatre_patient code from master_company
	               // $query_222= "SELECT theatrepatient FROM master_company";
					// $exec_222= mysqli_query($GLOBALS["___mysqli_ston"], $query_222) or die ("Error in Query_222".mysqli_error($GLOBALS["___mysqli_ston"]));
					// while($res_222 = mysqli_fetch_array($exec_222)){
					//	//
					//	$mtp_id = $res_222['theatrepatient'];
					//}
	            //	if($patientcode != $mtp_id){
	            ?>
					<a <?php if($procedure_type=='emergency'){ ;?> style="color:red;" <?php } ?> href="theatrepanel.php?id=<?php echo $bookingid;?>"><strong>View</strong></a> | <select name='docnotes' id='docnotes' onChange="view_pop(this.options[this.selectedIndex].value,'<?php echo $bookingid;?>');"><option value=''>Select Doctor Notes</option><option value='pre'>Pre Doctor Notes</option>
					<option value='intra'>Intr Doctor Notes</option>
					<option value='post'>Post Doctor Notes</option>
					</select>
				<?php
					//}
				?>
				</td>
				<td  align="center" valign="center" class="bodytext31">
					<!--
					<span class="bodytext3">
                  		<a href="theatreregistration.php?anum=<?php echo $bookingid;?>?&&st=del" onClick="return funcDeleteBooking('<?php echo $bookingid;?>')">
                  		<img src="images/b_drop.png" width="16" height="16" border="0" /></a>
                  	</span> 
                  -->
					<!--<a href="theatrepanel.php?id=<?php echo $bookingid;?>">Cancel</a>-->
				</td>
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="12" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
            
             	
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
	    <tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <!--
					 <tr>
                     <td class="bodytext3">Priliminary Diseases</td>
				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>
                   </tr> -->
                     					
				      </table>
				  </td>
		        </tr>
				<tr>
        <td>&nbsp;</td>
        </tr>  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
                 
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

