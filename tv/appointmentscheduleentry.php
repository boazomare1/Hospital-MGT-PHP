<?php

session_start();

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$errmsg = "";

$bgcolorcode = "";

$pagename = "";

$consultationfees1 = '';

$availablelimit = '';

$mrdno = '';

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];







$patientcode = '';

$patientname = '';



if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }

//$patientcode = 'MSS00000009';

if ($errorcode == 'errorcode1failed')

{

	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	

}



if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if($patientcode != '')

{

$query41 = "select * from master_customer where customercode='$patientcode'";

$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res41 = mysqli_fetch_array($exec41);

$patientname = $res41['customerfullname'];

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$patientcode = 'MSS00000009';

if ($st == 'success')

{

	$errmsg = 'Appointment Saved Successfully';	

}



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

if ($frmflag1 == 'frmflag1')

{

	$patientname=$_REQUEST["customer"];

	$patientcode=$_REQUEST["patientcode"];

	$appointmentdate = $_REQUEST["appointmentdate"];

	// $appointmenttime = $_REQUEST["appointmenttime"];

	$department = $_REQUEST["department"];

	$hour = $_REQUEST['hour'];

	$minute = $_REQUEST['minute'];

	$starttime = $hour.':'.$minute;

    $sess = $_REQUEST['sess'];

	

	$apnum = $_REQUEST['apnum'];

	$referal = $_REQUEST['referal'];

	$rate = $_REQUEST['rate4'];
	$mobile =$_REQUEST['mobile'];

	$remarks = $_REQUEST['remarks'];



	$query1 = "insert into appointmentschedule_entry (patientname,appointmentdate,appointmenttime,consultingdoctor,patientcode,department,session,recorddate,rate,username,ipaddress,phone,remarks) 

	values('$patientname','$appointmentdate','$starttime','$referal','$patientcode','$department','$sess','$updatedatetime','$rate','$username','$ipaddress','$mobile','$remarks')";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	
	$status = 'success';

		

	header("location:appointmentscheduleentry.php?st=$status");

}

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	$locationname = $res["locationname"];

	$locationcode = $res["locationcode"];

	$res12locationanum = $res["auto_number"];

include ("autocompletebuild_referal.php");

?>

<style type="text/css">

.ui-menu .ui-menu-item{ zoom:1 !important; }

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



<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script type="text/javascript" src="js/membervalidation.js"></script>
<style type="text/css">
.appi {
    display: none;
}
.max_apt2 {
display: none;
}
.update2 {
display: none;
}
.max_slot {
	display: none;
}
</style>

<script language="javascript">

// $(document).ready(function(e) {
// var doc = document.getElementById("referalcode").value;
 
// 	// alert(max_appt);
	
// });

function afterdate(){
	// var a = $(#appointmentdate).val();
	var app_date = document.getElementById("appointmentdate").value;
	var doc = document.getElementById("referalcode").value;
	// alert(doc);
		$.ajax({
				url: 'max_apt_results.php?docid='+doc+'&&app_date='+app_date+'',
				success: function( data ) {
				// alert(data);
				// $('#max_apt_remained').val(data);

				if(parseInt(data)<1)
				{
					$("#max_apt_remained").html('All Slots are Over. No More Booking Possible');
					$("#save").hide();
				}
				else
				{
					$("#max_apt_remained").html(data);
					$("#save").show();
				}

				$("#appi").show();
				}
		});
}
function maxdoc_appt(){
	 
	var doc = document.getElementById("referalcode").value;
	if(doc != ""){
			$("#max_apt2").show();
			$(".update2").show();
			$(".max_slot").show();
	// alert(doc);
		$.ajax({
				url: 'maxdoc_appt_fetch.php?docid='+doc+'',
				success: function( data ) {
				// alert(data);
				
				var arr=data.split("||");
                var departmentid = arr[1];
                var departmentname = arr[2];

                $('#max_apt2').val(arr[0]);
                $('#department').val(departmentid);
                $('#departmentname').val(departmentname);

				// $("#max_apt2").html(data);
				// $("#appi").show();
				}
		});
	}else{
		$('#max_apt2').val('');
		$('#department').val('');
                $('#departmentname').val('');
	}
}

function update_appt(){
	 
	var doc = document.getElementById("referalcode").value;
	var max_appt = document.getElementById("max_apt2").value;
	// alert(max_appt);
	 
	if((max_appt ==0) || max_appt==""){ alert('Value should not Empty');
		return false;
		}
		$.ajax({
				url: 'maxdoc_appt_save.php?docid='+doc+'&&max_appt_value='+max_appt+'',
				success: function( data ) {
				alert('Max Appointment Updated');
				return maxdoc_appt(); 
				// return afterdate(); 
				// $('#max_apt2').val(data);
				// // $("#max_apt2").html(data);
				// // $("#appi").show();
				}
		});
}


	var doctor_weekdays = [];
	var disable_weekdays = [];

function process1()

{

if (document.form1.customer.value == "")

	{

		alert ("Patient Name Cannot Be Empty.");

		document.form1.customer.focus();

		return false;

	}
	if (document.form1.referal.value == "")

	{

		alert ("doctor Cannot Be Empty.");

		document.form1.referal.focus();

		return false;

	}

	if (document.form1.department.value == "")

	{

		alert ("department Name Cannot Be Empty.");

		document.form1.department.focus();

		return false;

	}

	

	

	

}

function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function funcDepartmentChange1()

{

	<?php 

	$query12 = "select * from master_department where recordstatus = ''";

	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res12 = mysqli_fetch_array($exec12))

	{

	$res12departmentanum = $res12['auto_number'];

	?>

	if(document.getElementById("department").value=="<?php echo $res12departmentanum; ?>")

	{

		document.getElementById("doctor").options.length=null; 

		var combo = document.getElementById('doctor'); 	

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 

		<?php

		$query10 = "select * from master_doctor where auto_number = '$res12departmentanum' and status = ''";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		$res10doctoranum = $res10['auto_number'];

		$res10doctorname = $res10["doctorname"];

		?>

			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctoranum;?>"); 

		<?php 

		}

		?>

	}

	<?php

	}

	?>	

}

</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>

<script language="javascript">

function funcOnLoadBodyFunctionCall()

{

	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.

	funcCustomerDropDownSearch7();

}

$(function() {

	

$('#customer').autocomplete({

		

	source:'ajaxcustomernewserach.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var code = ui.item.id;

			var customercode = ui.item.customercode;

			var accountname = ui.item.accountname;

			$('#patientcode').val(customercode);
			 $('#mobile').val(ui.item.mobile);


			$('#customerhiddentextbox').val(ui.item.value);

			
			},

    });

});

</script>



<?php include ("js/dropdownlist1newscripting1.php"); ?>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<?php include ("js/dropdownlist1scriptingreferal.php"); ?>

<script type="text/javascript" src="js/autocomplete_referal.js"></script>

<script type="text/javascript" src="js/autosuggestreferal1.js"></script>

<script type="text/javascript" src="js/autoreferalcodesearch2.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>



<script src="js/datetimepicker_css_new.js"></script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall()">

<table width="103%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5">

	<?php 

	

		include ("includes/menu1.php"); 

	

	//	include ("includes/menu2.php"); 

	

	?>	</td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top">&nbsp;</td>

    <td width="97%" valign="top">





      	  <form name="form1" id="form1" method="post" action="appointmentscheduleentry.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="860"><table width="736" height="177" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <tr bgcolor="#011E6A">

                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Appointment Schedule Entry</strong></td>

                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                </tr>

            <tr bgcolor="#011E6A">

              <td colspan="6" bgcolor="<?php if ($errmsg == '') { echo '#ecf0f5'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>

             </tr>

			 <tr>

			 <td  colspan="6"  class="bodytext3"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)</strong></td>

			 </tr>

            	<tr>

				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Name </td>

				  <td width="86%" align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="customer" id="customer" size="60" autocomplete="off" value="<?php echo $patientname; ?>">

				  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">

				  <input name="locationcode" id="locationcode" value="<?= $locationcode?>" type="hidden">				  </tr>

				<tr>
				  <td height="30" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Phone </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="mobile" id="mobile" size="20"  value=""/></td>
				  </tr>
				<tr>

				<tr>

                    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Doctor</td>
                    <td>
                    <table>
                    	<tr>
									<td>

									<input name="referal" type="text" id="referal" size="20" autocomplete="off" onChange="return maxdoc_appt();">

									<input type="hidden" name="referalcode" id="referalcode" value="">

									</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td class="max_slot"> Max. Slots : </td>

									<td><input type="text" name="max_apt2" id="max_apt2" size="7" class="max_apt2"></td>
									<td><input type="button" value="Update" onClick='return update_appt();' class="update2"></td>
                    	</tr>
                    </table>
                    </td>
                    <!-- <td>

						<input name="referal" type="text" id="referal" size="20" autocomplete="off" onChange="return maxdoc_appt();">

						 <input type="hidden" name="referalcode" id="referalcode" value="">

					</td> -->
					

					<input type="hidden" name="doctor_weekdaysid_str" id="doctor_weekdaysid_str" value="">

                  </tr>

				<tr>

				  <td height="30" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="patientcode" id="patientcode" size="20" readonly value="<?php echo $patientcode; ?>"/></td>

				  </tr>



				<tr>
					<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Appointment Date </td>
					<td>
					<table>
						<tr>
							<td align="left" valign="middle"  bgcolor="#ecf0f5">
								<input type="text" name="appointmentdate" id="appointmentdate" value="<?php //echo $registrationdate; ?>" onChange='return afterdate();' readonly="readonly" >
								<strong><span class="bodytext312"> 
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('appointmentdate','yyyyMMdd','','','','','future')"  style="cursor:pointer"/>
								<!-- onChange='return afterdate();' -->
								</span></strong>
								</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
								 <td> <div id="appi" class="appi">Remaining Slots : </div> </td>
								 <td><span style="color: red; font-size: 25px;"><b><div id="max_apt_remained"></div></b></span></td>
								 <!-- <td><input type="text" style="background: transparent; border: none;" name="max_apt_remained" id="max_apt_remained"></td>   -->
						</tr>
					</table>
					</td>
				  <!-- <td><input type="text" name="max_apt_remained" id="max_apt_remained"></td> -->

			    </tr>

                 <tr>

				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Appointment Time </td>

			      <td align="left" valign="middle"  bgcolor="#ecf0f5">

					<input type="text" name="hour" id="hour" size="4" placeholder="HH">

					<input type="text" name="minute" id="minute" size="4" placeholder="MM">

						<select name="sess" id="sess" width="10">

						<option value="am">AM</option>

						<option value="pm">PM</option>

						</select>				  </td>

				</tr>

                  <tr>

				<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Department</td>

			      <td align="left" valign="middle"  bgcolor="#ecf0f5">
			      <!-- 	<select name="department" id="department" onChange="return funcDepartmentChange1();">

                    <option value="" selected="selected">Select Department</option>

                    <?php

				// $query5 = "select * from master_department where recordstatus = '' order by auto_number";

				// $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

				// while ($res5 = mysql_fetch_array($exec5))

				// {

				// $res5anum = $res5["auto_number"];

				// $res5paymenttype = $res5["department"];

				// ?>

    //                 <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>

    //                 <?php

				// }

				?>

                  </select> -->
                  <input type="text" name="departmentname" readonly="readonly" id="departmentname" onChange="return funcDepartmentChange1();">
                  <input type="hidden" name="department" id="department" onChange="return funcDepartmentChange1();">

              </td>

				</tr>

                  

                  
				  <tr>

                    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Rate</td>

                    <td>

						<input name="rate4" type="text" id="rate4" size="20" autocomplete="off" readonly="readonly">

					</td>

                  </tr>

                  <tr>

                    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Remarks</td>

                    <td>

						<textarea rows="2" name="remarks" id="remarks"></textarea>

					</td>

                  </tr>

                  <tr>

				 <td></td>

				 <td>

				   <input type="hidden" name="frmflag1" value="frmflag1" />

                   <input name="Submit222" type="submit"  value="Save Appointment" class="button" id='save'/>

				</td>

                </tr>

                 <tr>

                   <td></td>

                   <td>&nbsp;</td>

                 </tr>

                 <tr>

                   <td></td>

                   <td>&nbsp;</td>

                 </tr>

            </tbody>

          </table></td>

        </tr>

        <tr>

          <td>&nbsp;</td>

        </tr>

    </table>

	</form>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>