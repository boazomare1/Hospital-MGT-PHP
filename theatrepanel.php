<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");
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
 

$thismonth=$year."-".$month."___";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
	}
?>

<?php
$id = isset($_REQUEST['id'])?$_REQUEST['id']: '';
//echo $id;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
if (isset($_REQUEST["cbfrmflag3"])) { $cbfrmflag3 = $_REQUEST["cbfrmflag3"]; } else { $cbfrmflag3 = ""; }
//print_r($_REQUEST["cbfrmflag1"]);
if ($cbfrmflag1 == 'cbfrmflag1')
{
    $booking_code = $_REQUEST['booking_code'];
    /*$surgeon = $_REQUEST['surgeon'];*/
    /*$scrub_nurse = $_REQUEST['scrub_nurse'];*/
    /*$anesthesia = $_REQUEST['anesthesia'];*/
    $anesthesiatype = $_REQUEST['anesthesiatype'];
    /*$circulating_nurse = $_REQUEST['circulating_nurse'];*/   
    // equipments
    $equipments = $_REQUEST['equipments'];
    $patientcode = $_REQUEST['patient_code'];
    $theatre = $_REQUEST['theatre'];
    $ward1=$_REQUEST['ward'];
    $proceduretype=$_REQUEST['proceduretype'];
    $category=$_REQUEST['category'];
    $startTime = date('Y-m-d H:i:s');
    $dateAdded = date('Y-m-d');
	$anaesthetisit_note = addslashes($_REQUEST['anaesthetisit_note']);

    $query_theatre = "UPDATE master_theatre_booking SET approvalstatus='Inprogress',anesthesiatype='$anesthesiatype',starttime='$startTime',category='$category', proceduretype='$proceduretype',theatrecode='$theatre',ward='$ward1',`anesthesiatype` = '$anesthesiatype',anaesthetisit_note='$anaesthetisit_note' WHERE auto_number = '$booking_code'";
   $exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre) or die ("Error in query_theatre".mysqli_error($GLOBALS["___mysqli_ston"]));
    $theatrebookingcode=$booking_code;
    /*print_r($_REQUEST);
    exit();*/
/*if ($cbfrmflag3 == 'cbfrmflag3')
{
    $reason=$_REQUEST['reason'];
   echo $query_reason = "INSERT INTO `theatre_panel_late reason`(`booking_id`, `late_reason`) VALUES ('$theatrebookingcode', '$reason')";
            	
            	$exec_reason = mysql_query($query_reason) or die ("Error in query_reason".mysql_error());
            	print_r($reason);
            	exit();



            	header("Location: theatrepanel.php?id=$theatrebookingcode&&st=success");

}
exit();
*/




   /* $query_theatre = "UPDATE master_theatre_booking SET `patientcode` = '$patientcode',`theatrecode` = '$theatre', `proceduretype` = '$proceduretype', `category` = '$category',`surgerydatetime` = '$surgerydate', `estimated_endtime` = '$estimated_endtime' ,`estimatedtime` = '$estimatedtime', `starttime` = '', `endtime` = '', `approvalstatus` = 'Pending', `ipaddress` = '$ipaddress', `username` = '$username', `date` = '$dateAdded', `anesthesia` = '$anesthesia',`surgeon` = '$surgeon',`anesthesiatype` = '$anesthesiatype', `ward` = '$ward', `side` = '$side' WHERE auto_number = '$banum'";


		//echo $query_theatre;
		//exit;
		$exec_theatre = mysql_query($query_theatre) or die ("Error in query_theatre".mysql_error());
        $theatrebookingcode = $banum;
    */
    // update equipments
    foreach ($equipments as $key => $value) {
        	$get_equip_code = "SELECT * FROM master_equipments WHERE itemname = '$value'";
        	//$query_equip = "INSERT INTO `master_theatre_equipments`(`itemcode`, `patientcode`, `patientvisitcode`, `theatrebookingcode`, `ipaddress`, `username`, `locationcode`, `locationname`, `date`) VALUES ('$value', '$patientcode','','$theatrebookingcode','$ipaddress','$username','$locationcode1','$locationname1','$dateAdded')";

        	//check if item is already in db
        	$query_eq_check = "SELECT * FROM master_theatre_equipments WHERE itemcode = '$value' AND patientcode = '$patientcode' AND theatrebookingcode = '$theatrebookingcode'";
            $exec_eq_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_eq_check) or die ("Error in query_eq_check".mysqli_error($GLOBALS["___mysqli_ston"]));
            $check_rows_eq = mysqli_num_rows($exec_eq_check);

            //print_r($equipments); echo $value;exit;
            //echo $check_rows_eq;exit;

            if($check_rows_eq > 0){
            	// update
            	$query_equip = "UPDATE master_theatre_equipments SET itemcode = '$value' WHERE patientcode = '$patientcode' and theatrebookingcode = '$theatrebookingcode'";
        		//echo $query_equip;
        		$exec_equip = mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in query_equip".mysqli_error($GLOBALS["___mysqli_ston"]));
            }else{
            	// get loc code
            	$locationcode1 = 'LTC-1';
	            $locationname1 = '';
            	// insert
            	$query_equip = "INSERT INTO `master_theatre_equipments`(`itemcode`, `patientcode`, `patientvisitcode`, `theatrebookingcode`, `ipaddress`, `username`, `locationcode`, `locationname`, `date`) VALUES ('$value', '$patientcode','','$theatrebookingcode','$ipaddress','$username','$locationcode1','$locationname1','$dateAdded')";
            	
            	$exec_equip = mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in query_equip".mysqli_error($GLOBALS["___mysqli_ston"]));
            }

            

        }

        for ($n=1; $n < 30; $n++) { 
			# code...
			if(isset($_REQUEST['serv'.$n]) && $_REQUEST['serv'.$n]!=''){
			 $procedurenameid= $_REQUEST['serv'.$n];
			  $procedurenameanum= $_REQUEST['procedure'.$n];
			/* print_r($procedurenameid);
			 exit();*/
		 $postnewPname="INSERT INTO `theatre_booking_proceduretypes`(`booking_id`, `proceduretype_id`, `locationcode`, `username`, `ipaddress`,`proceduretype_anum`) VALUES ('$theatrebookingcode','$procedurenameid','$locationcode1', '$username','$ipaddress','$procedurenameanum')";
		        $postnewPname = mysqli_query($GLOBALS["___mysqli_ston"], $postnewPname) or die ("Error in postnewPname".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}

        for ($i=1; $i < 30; $i++) { 
			# code...
			if(isset($_REQUEST['surgeon_name'.$i]) && $_REQUEST['surgeon_name'.$i]!=''){
			$surgeonId= $_REQUEST['surgeon'.$i];

		 $posttonewDb="INSERT INTO `theatre_booking_surgeons`(`booking_id`, `surgeon_id`, `locationcode`, `username`, `ipaddress`) VALUES ('$theatrebookingcode','$surgeonId','$locationcode1', '$username','$ipaddress')";
		
		        $posttonewDb = mysqli_query($GLOBALS["___mysqli_ston"], $posttonewDb) or die ("Error in posttonewDb".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}
//done checked
		for ($f=1; $f < 30; $f++) { 
			# code...
			if(isset($_REQUEST['scrubnurse_name'.$f]) && $_REQUEST['scrubnurse_name'.$f]!=''){
			$scrubnurseId= $_REQUEST['scrubnurse'.$f];

	 	$postscrubnurse="INSERT INTO `theatre_panel_scrubnurses`(`booking_id`, `scrubnurse_id`, `locationcode`, `username`) VALUES ('$theatrebookingcode','$scrubnurseId','$locationcode1', '$username')";
		        $postscrubnurse = mysqli_query($GLOBALS["___mysqli_ston"], $postscrubnurse) or die ("Error in postscrubnurse".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}

		for ($g=1; $g < 30; $g++) { 
			# code...
			if(isset($_REQUEST['anesthesist_name'.$g]) && $_REQUEST['anesthesist_name'.$g]!=''){
			$anesthesistId= $_REQUEST['anesthesist'.$g];

		 $postanesthesist="INSERT INTO `theatre_panel_anesthesist`(`booking_id`, `anesthesist_id`, `locationcode`, `username`) VALUES ('$theatrebookingcode','$anesthesistId','$locationcode1', '$username')";
		        $postanesthesist = mysqli_query($GLOBALS["___mysqli_ston"], $postanesthesist) or die ("Error in postanesthesist".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}

		for ($l=1; $l < 30; $l++) { 
			# code...
			if(isset($_REQUEST['circnurse_name'.$l]) && $_REQUEST['circnurse_name'.$l]!=''){
			$circnurseId= $_REQUEST['circnurse'.$l];

	 	$postcircnurse="INSERT INTO `theatre_panel_circulating_nurse`(`booking_id`, `circulatingnurse_id`, `locationcode`, `username`) VALUES ('$theatrebookingcode','$circnurseId','$locationcode1', '$username')";
		        $postcircnurse = mysqli_query($GLOBALS["___mysqli_ston"], $postcircnurse) or die ("Error in postcircnurse".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}

		for ($a=1; $a < 30; $a++) { 
			# code...
			if(isset($_REQUEST['technician_name'.$a]) && $_REQUEST['technician_name'.$a]!=''){
			$technicianId= $_REQUEST['technician'.$a];

		 $posttechnician="INSERT INTO `theatre_panel_technician`(`booking_id`, `technician_id`, `locationcode`, `username`) VALUES ('$theatrebookingcode','$technicianId','$locationcode1', '$username')";
		        $posttechnician = mysqli_query($GLOBALS["___mysqli_ston"], $posttechnician) or die ("Error in posttechnician".mysqli_error($GLOBALS["___mysqli_ston"]));

			}
		}
    $bgcolorcode = 'Success';	
	$errmsg = "Theatre Procedure Started Successfully";

	header("Location:theatreregistration.php?id=$booking_code&&st=success");	
}

if ($cbfrmflag2 == 'cbfrmflag2')
{
    $booking_code = $_REQUEST['booking_code'];

    $comment = $_REQUEST['comment'];
    $patient_status = $_REQUEST['patient_status'];

    $stopTime = date('Y-m-d H:i:s');
    $intra_anaesthetisit_note = addslashes($_REQUEST['intra_anaesthetisit_note']);
	

    $query_theatre = "UPDATE master_theatre_booking SET approvalstatus='Completed',comment='$comment',patientstatus='$patient_status', endtime='$stopTime',intra_anaesthetist_notes='$intra_anaesthetisit_note' WHERE auto_number = '$booking_code'";
    $exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre) or die ("Error in query_theatre".mysqli_error($GLOBALS["___mysqli_ston"]));

    $bgcolorcode = 'Success';	
	$errmsg = "Theatre Procedure Stopped Successfully";

	header("Location:theatreregistration.php?id=$booking_code&&st=success");	
}

if ($cbfrmflag3 == 'cbfrmflag3')
{
    $booking_code = $_REQUEST['booking_code'];

    $stopTime = date('Y-m-d H:i:s');
    $post_anaesthetisit_note = addslashes($_REQUEST['post_anaesthetisit_note']);
	

    $query_theatre = "UPDATE master_theatre_booking SET closed_time='$stopTime',post_anaesthetist_notes='$post_anaesthetisit_note',approvalstatus='Closed' WHERE auto_number = '$booking_code'";
    $exec_theatre = mysqli_query($GLOBALS["___mysqli_ston"], $query_theatre) or die ("Error in query_theatre".mysqli_error($GLOBALS["___mysqli_ston"]));

    $bgcolorcode = 'Success';	
	$errmsg = "Theatre Procedure Closed Successfully";

	header("Location:theatreregistration.php?id=$booking_code&&st=success");	
}

?>
<style type="text/css">

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

.custom-header{
	background-color: #c3eeb7;
	color:#000;
	text-transform: bold;
	text-align: center;


}


.ui-menu .ui-menu-item{ zoom:1 !important; }

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma}


	.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}
</style>
<link href="autocomplete.css" rel="stylesheet">
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/multi-select.css">
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/jquery.multi-select.js" type="text/javascript"></script>



<script type="text/javascript" src="js/autocustomercodesearchtheatre.js"></script>
<script type="text/javascript" src="js/insertnewprocedure_1.js"></script>
<script type="text/javascript" src="js/insertnewsurgeon_1.js"></script>
<script type="text/javascript" src="js/insertnewscrubnurse_1.js"></script>
<script type="text/javascript" src="js/insertnewcircnurse_1.js"></script>
<script type="text/javascript" src="js/insertnewanesthesist_1.js"></script>
<script type="text/javascript" src="js/insertnewtechnician_1.js"></script>
<style>
.hideClass
{display:none;}
</style>
<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    /*margin: auto;*/
    top: 200px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
<script language="javascript">
	function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}

function upload_intra_new(autono,billno){
	FuncPopup();
	var autono_final = autono;
	var billno = billno;
    var property = document.getElementById('claimpdfa'+autono_final).files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();

        if(jQuery.inArray(image_extension,['pdf']) == -1){
          alert("Please Upload only the PDF files!");
          $("#imgloader").hide();
          $('#claimpdfa'+autono_final).val('');
          return false;
        }

        var check = confirm("Are you sure you want to Upload the "+image_name+"?");
        if (check != true) {
        	$("#imgloader").hide();
        	$('#claimpdfa'+autono_final).val('');
            return false;
        }

        var form_data = new FormData();
        form_data.append("file",property);
        $.ajax({
          url:'upload_intra_op.php?auto='+autono_final+'&&uploadtype=intra&&visit='+billno,
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          success:function(data){
             $('#claimpdfa'+autono_final).val('');
             $("#imgloader").hide();
             $("#showcalimpdf"+autono_final).show();
          }
        });
				
}

function process1()
{   
    
	/*var surgeon = document.getElementById("surgeon").value;
	//alert(surgeon);
	if(surgeon.length < 1)
	{
		alert("Please select surgeon");
		 document.getElementById("surgeon").focus();
			return false;
	}*/

	/*var scrub_nurse = document.getElementById("scrub_nurse").value;
	if(scrub_nurse.length < 1)
	{
		alert("Please select scrub nurse");
		 document.getElementById("scrub_nurse").focus();
			return false;
	}

	var anesthesia = document.getElementById("anesthesia").value;
	if(anesthesia.length < 1)
	{
		alert("Please select anesthesia");
		 document.getElementById("anesthesia").focus();
			return false;
	}

	var circulating_nurse = document.getElementById("circulating_nurse").value;
	if(circulating_nurse.length < 1)
	{
		alert("Please select circulating_nurse");
		 document.getElementById("circulating_nurse").focus();
			return false;
	}*/

	/*var currenttime = document.getElementById("currenttime").value;
    var estimatetime = document.getElementById("estimatetime").value;
    var comment = document.getElementById("comment").value;
     var strtime = document.getElementById("start_time").value;


     alert(currenttime);
     alert(strtime);*/
    
	

	/*alert('working');*/
    var currenttime = document.getElementById("currenttime").value;
    /*var estimatetime = document.getElementById("estimatetime").value;*/
    
     var strtime = document.getElementById("start_time").value;


    /* alert(currenttime);
     alert(strtime);*/

	var anaesthetisit_note = document.getElementById("anaesthetisit_note").value;
	if(anaesthetisit_note.length < 5)
	{
		 alert("Please enter Pre Anaesthesia notes");
		 document.getElementById("anaesthetisit_note").focus();
			return false;
	}

     if (currenttime>strtime) {


     	
     	document.getElementById("myForm").style.display = "block";
     	return false; 
     	 
                
               
           
     }

    

}

function process2(id){

	var patient_status = document.getElementById("patient_status").value;

	if(patient_status.length < 1)
	{
		alert("Please select patient status");
		 document.getElementById("patient_status").focus();
			return false;
	}
    
	if($('#showcalimpdf'+id).is(":visible"))
	{
	}else{
		 alert("Please upload OP Intra Form.");
		 return false;
	}

	var intra_anaesthetisit_note = document.getElementById("intra_anaesthetisit_note").value;
	if(intra_anaesthetisit_note.length < 5)
	{
		 alert("Please enter Intra Anaesthesia notes");
		 document.getElementById("intra_anaesthetisit_note").focus();
		 return false;
	}

	

	

	/*var currenttime = document.getElementById("currenttime").value;
    var estimatetime = document.getElementById("estimatetime").value;
    var comment = document.getElementById("comment").value;
     var strtime = document.getElementById("start_time").value;


     alert(currenttime);
    

     alert(strtotime(strtime));*/

}

function process3(id){

    if(document.getElementById("pre_doc_status").value==0)
	{
		 alert("Pending Pre Doctor's notes");
		 return false;
	}

	if(document.getElementById("intra_doc_status").value==0)
	{
		 alert("Pending Intra Doctor's notes");
		 return false;
	}

	if(document.getElementById("post_doc_status").value==0)
	{
		 alert("Pending Post Doctor's notes");
		 return false;
	}
	
	var post_anaesthetisit_note = document.getElementById("post_anaesthetisit_note").value;
	if(post_anaesthetisit_note.length < 5)
	{
		 alert("Please enter Post Anaesthesia notes");
		 document.getElementById("post_anaesthetisit_note").focus();
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

</script>

<script type="text/javascript">

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}


</style>
</head>



<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
		<div align="center" class="imgloader" id="imgloader1" style="display:;">
			<p style="text-align:center;"><strong>Upload in Progress <br><br> Please be patience...</strong></p>
			<img src="images/ajaxloader.gif">
		</div>
	</div>
<form name="cbform1" id="cbform1" method="post" action="theatrepanel.php">
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
     
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Procedure Panel </strong></td>
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
              <?php
                
			   //$query2 = "select * from master_ipvisitentry where locationcode='$res1locationcode' and discharge='completed'";
				$query21 = "select * from master_theatre_booking where auto_number='$id'  order by auto_number desc";
				$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num21=mysqli_num_rows($exec21);
				
				while($res21 = mysqli_fetch_array($exec21))
				{
					$estimate = $res21['estimatedtime'];
					$start_time = $res21['starttime'];
					$stop_time = $res21['endtime'];
					$approval_status = $res21['approvalstatus'];
					$theatre_code =$res21['theatrecode'];
					$ward = $res21['ward'];
					$procedure_type =$res21['proceduretype'];
					$category =$res21['category'];
					$surgerytime=$res21['surgerydatetime'];
				}
              ?>
             
			  <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" style="text-align:center;">
                	<h1><label>Estimated Time</label></h1>
                </td>
                
                <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" style="text-align:center;">
                	<h1><label>Elapsed Time</label></h1>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" style="text-align:center;color:green;">
                	<h1><label><?php echo $estimate;?>&nbsp;<small>Mins</small></label></h1>
                	<!-- time -->
                	
                </td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" style="text-align:center;color:red;">
                	<h1>
                		<label>
                			<?php 
                			  /*if($stop_time <= 0){
                			  	echo "--";
                			  }else{
                			  	$now = date("Y-m-d H:i:s");

                			  	$to_time = strtotime($stop_time);
								$from_time = strtotime($start_time);
								$elapsed = round(($to_time - $from_time) / 60,2);
								echo $elapsed. " Mins";
                			  }*/
                			  if($approval_status == 'Inprogress'){
                			  	$now = date("Y-m-d H:i:s");
								//echo $now.'<br>';
								//echo $start_time.'<br>';

                			  	$to_time = strtotime($now);
								$from_time = strtotime($start_time);

								$delta_T = ($to_time - $from_time);
								$day = round(($delta_T % 604800) / 86400); 
								$hours = round((($delta_T % 604800) % 86400) / 3600); 
								$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
								$sec = round((((($delta_T % 604800) % 86400) % 3600) % 60));
                                
								echo $hours . "<small>Hrs</small> &nbsp;".$minutes. " <small>Mins</small>";

                			  } elseif($approval_status == 'Completed'){
                			  	$to_time = strtotime($stop_time);
								$from_time = strtotime($start_time);

								$delta_T = ($to_time - $from_time);
								$day = round(($delta_T % 604800) / 86400); 
								$hours = round((($delta_T % 604800) % 86400) / 3600); 
								$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
								$sec = round((((($delta_T % 604800) % 86400) % 3600) % 60));

								echo $hours . "<small>Hrs</small> &nbsp;".$minutes. " <small>Mins</small>";

							}elseif ($approval_status == 'Pending') {
								echo "--";
							}
                			 ?>
                		</label>
                	</h1>
                	<?php
						$now = date("Y-m-d H:i:s");	  
        			  	$current_time = strtotime($now);

        			  	//estimate time
        			  	$e = $time = '+'.$estimate.' minutes';
        			  	$e_time = date('Y-m-d H:i:s', strtotime($e, strtotime($start_time)));
        			  	$e_time = strtotime($e_time);

        			  	$stime=strtotime($surgerytime);

        			  	/*$strtime1=strtotime($start_time);*/

                	?>
                	<input type="hidden" name="currenttime" id="currenttime" value="<?php echo $current_time;?>">
                	<!--<input type="text" name="estimatetime" id="estimatetime" value="<?php echo $estimate;?>">-->
                	<input type="hidden" name="estimatetime" id="estimatetime" value="<?php echo $e_time;?>">

                	<input type="hidden" name="start_time" id="start_time" value="<?php echo $stime;?>">
                </td>
              </tr>
          </tbody>
        </table>
		
<table width="980" border="0" cellspacing="0" cellpadding="0" style="margin:30px;">
	<tr>
	    <td colspan="2">&nbsp;</td>
	</tr>
</table>
<?php
   
   //$query2 = "select * from master_ipvisitentry where locationcode='$res1locationcode' and discharge='completed'";
	$query2 = "select * from master_theatre_booking where auto_number='$id'  order by auto_number desc";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num2=mysqli_num_rows($exec2);
	
	while($res2 = mysqli_fetch_array($exec2))
	{
	
	$bookingid= $res2['auto_number'];
	$patientcode=$res2['patientcode'];
	$anaesthetisit_note=$res2['anaesthetisit_note'];
	$intra_anaesthetisit_note=$res2['intra_anaesthetist_notes'];
	$visitcode = $res2['patientvisitcode'];
	$theatrecode = $res2['theatrecode'];
    $procedure_type = $res2['proceduretype'];
    $category = $res2['category'];
    $speaciality = $res2['speaciality'];
    $surgerydatetime = $res2['surgerydatetime'];
    $estimatedtime = $res2['estimatedtime'];
    $patient_type = $res2['patient_type'];
    $doctor_note = $res2['doctor_note'];
	$intra_doctor_notes = $res2['intra_doctor_notes'];
	$post_doctor_notes = $res2['post_doctor_notes'];
	
    $intra_op=$res2['intra_op'];
    // surgery details
    $surgeon1 = $res2['surgeon'];
    $scrubnurse1 = $res2['scrubnurse'];
    $anesthesia1 = $res2['anesthesia'];
    $anesthesiatype = $res2['anesthesiatype'];
    $circulatingnurse1 = $res2['circulatingnurse'];
    $ward = $res2['ward'];

    // get patient details
    // get age and gender
    $query67 = "select * from master_customer where customercode='$patientcode'";
	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
	$res67 = mysqli_fetch_array($exec67);
	$patientname=$res67['customername'].' '.$res67['customermiddlename'].' '.$res67['customerlastname'];
	$age = $res67['age'];
	$gender = $res67['gender'];

	$query7811 = "select * from master_theatre where auto_number='$theatrecode'";
	$exec7811 = mysqli_query($GLOBALS["___mysqli_ston"], $query7811) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7811 = mysqli_fetch_array($exec7811);
	$theatrename = $res7811['theatrename'];
	  
	$query50 = "select * from master_department where auto_number='$speaciality'";
	$exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res50 = mysqli_fetch_array($exec50);
	$speacialityname = $res50['department'];
}
?>
<table width="116%" border="0" cellspacing="0" cellpadding="0">
        <tr>
  			<td width="103%">
  				<table   border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	  				<tbody>
	                   <tr bgcolor="#011E6A">
	                   	  <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><strong>Patient Details</strong></td>
	                   </tr>
	                   <tr>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Reg No</strong></td>
						  <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientcode; ?>
							  <input type="hidden" name="booking_code" id="booking_code" value="<?php echo $bookingid; ?>">
							  <input type="hidden" name="patient_code" id="patient_code" value="<?php echo $patientcode; ?>">

						  </td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
						   <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Gender</strong></span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php echo $gender;?>
		                  </span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
						</tr>
						<tr>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient Name</strong></td>
						  <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $patientname; ?>
						  </td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
						   <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Age</strong></span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php echo $age;?>
		                  </span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
						</tr>
						<tr>
						  <!-- <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre</strong></td> -->
						  <!-- <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $theatrename; ?>
						  </td> -->

						 <!--  <td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="theatre" id="theatre" style="border: 1px solid #001E6A;">
							  		<option value="">Select Theatre</option>
							  		<?php
							  		 $query_th_1 = "SELECT * FROM master_theatre ORDER BY auto_number ASC";
							  		 $exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
									 while ($res_th_1 = mysqli_fetch_array($exec_th_1))
									 {
									 	$auto_number = $res_th_1['auto_number'];
									 	$theatre_name = $res_th_1['theatrename'];

							  		?>
							  			<option value="<?php echo $auto_number;?>" <?php if($theatre_code == $auto_number){ echo "selected";}?> ><?php echo $theatre_name;?></option>
							  	    <?php } ?>
							  	</select>
							</td> -->
						  <!-- <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td> -->
						   
						</tr>
						<tr>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
						  <!-- <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $category; ?>
						  </td> -->

						  <td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="category" id="category" style="border: 1px solid #001E6A;">
							  		<option value="">Select Category</option>
							  		<option value="major" <?php if($category == 'major'){ echo "selected";}?>>Major</option>
							  		<option value="minor" <?php if($category == 'minor'){ echo "selected";}?> >Minor</option>
							  	</select>
							</td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
						   <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Surgery Date</strong></span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php 


						  $timestamp=$surgerydatetime;

						  $splitTimeStamp = explode(" ",$timestamp);

						  $date = $splitTimeStamp[0];
							$time = $splitTimeStamp[1];

							echo $date;



						  ;?>
		                  </span></td>

		                  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Surgery Time</strong></span></td>
		                  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php echo $time;?>
		                  </span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>


						</tr>
						<td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong>Procedure Type</strong></span></td>
						  <!-- <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><?php echo $procedure_type;?>
		                  </span></td> -->

		                  <td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="proceduretype" id="proceduretype" style="border: 1px solid #001E6A;">
							  		<option value="">Select Procedure</option>
							  		<option value="emergency" <?php if($procedure_type == 'emergency'){ echo "selected";}?> >Emergency</option>
							  		<option value="elective" <?php if($procedure_type == 'elective'){ echo "selected";}?> >Elective</option>
							  	</select>
							</td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

						<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre</strong></td>
						  <!-- <td width="122" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><?php echo $theatrename; ?>
						  </td> -->

						  <td align="left" valign="middle"  bgcolor="#ecf0f5">
							  	<select name="theatre" id="theatre" style="border: 1px solid #001E6A;">
							  		<option value="">Select Theatre</option>
							  		<?php
							  		 $query_th_1 = "SELECT * FROM master_theatre ORDER BY auto_number ASC";
							  		 $exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
									 while ($res_th_1 = mysqli_fetch_array($exec_th_1))
									 {
									 	$auto_number = $res_th_1['auto_number'];
									 	$theatre_name = $res_th_1['theatrename'];

							  		?>
							  			<option value="<?php echo $auto_number;?>" <?php if($theatre_code == $auto_number){ echo "selected";}?> ><?php echo $theatre_name;?></option>
							  	    <?php } ?>
							  	</select>
							</td>
						<tr>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><!--Ward--></strong></td>
						  <!-- <td align="left" valign="middle" colspan="2"  bgcolor="#ecf0f5" class="bodytext3">
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
						  </td> -->

						  <td align="left" valign="middle"  bgcolor="#ecf0f5">
						  <?php
						  $auto_number = '';
						  ?>
	                     		<!--<select name="ward" id="ward" style="border: 1px solid #001E6A;">
							  		<option value="">Select Ward</option>
							  		<?php
							  		 $query_th_1 = "SELECT * FROM master_ward ORDER BY auto_number ASC";
							  		 $exec_th_1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_th_1) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
									 while ($res_th_1 = mysqli_fetch_array($exec_th_1))
									 {
									 	$auto_number = $res_th_1['auto_number'];
									 	$ward_name = $res_th_1['ward'];

							  		?>
							  			<option value="<?php echo $auto_number;?>" <?php if($ward == $auto_number){ echo "selected"; }?> ><?php echo $ward_name;?></option>
							  	    <?php } ?>
							  	</select>-->
								<input name="ward" id="ward" type="hidden" size="30" value="<?php echo $auto_number; ?>" />
	                     	</td>
						   <td align="left" valign="middle"  bgcolor="#ecf0f5" width="115"><span class="bodytext3"><strong></strong></span></td>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" width="113"><span class="bodytext3"><strong><!--Patient Type --></strong></td>
						 <td align="left" valign="middle"  bgcolor="#ecf0f5">
							  <!--	<select name="patient_type" id="patient_type" style="border: 1px solid #001E6A;">
							  		<option value="">Select Type</option>
							  		<option value="New" <?php if($patient_type == 'New'){ echo "selected";}?>>New</option>
							  		<option value="Active IP" <?php if($patient_type == 'Active IP'){ echo "selected";}?>>Active IP</option>
							  	</select>-->
								<input name="patient_type" id="patient_type" type="hidden" size="30" value="" />
							</td>
						</tr>
	                </tbody>
	            </table>
  			</td>
  		</tr>
  		<!-- doctor search and assignment-->
  		<tr>
  			<td width="103%">
  				<table  width="85%" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;margin-top:15px;">
	  				<tbody>
	                   <tr bgcolor="#011E6A">
	                   	  <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><strong>Surgery Procedure Details</strong></td>
	                   </tr>
	                   <!--<tr>
	                   	<td>
	                   		<a href="add_paneldoctors_theatre.php?id=<?php echo $bookingid;?>" onClick="return !window.open(this.href, 'Google', 'width=1200,height=800')"target="_blank"><button> + Add new</button></a>
	                   	</td>
	                   </tr>-->

	                   <tr>
	                   	<th align="left"  width="38%" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Surgeon(s)</strong></th>
	                   	<th align="left" width="35%" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Scrub Nurses</strong></th>
	                   	<th align="left" width="35%" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Anesthetist </strong></th>

	                   </tr>
					   
					   <tr>
					   <td width="38%">
				             <input type="hidden" name="serialnumber" id="serialnumber" value="1">
							<input type="hidden" name="auto_id" id="auto_id" value="0"/>
							<input type="text" name="surgeon_name[]" size="35" id="surgeon_name" autocomplete="off">
							<input type="hidden" name="surgeon" id="surgeon" autocomplete="off">
							<input type="button" name="addSurgeon" id="addSurgeon" onClick="return insertNewSurgeon()" value="Add" class="button" style="border: 1px solid #001E6A">
							<table id="insertrow">
							</table>
			           </td>
			
			
			         <td width="35%">
				<!-- scrub nurse db search -->
				<input type="hidden" name="serialnumberscrub" id="serialnumberscrub" value="1">
							<input type="hidden" name="autoscrub_id" id="autoscrub_id" value="0"/>
							<input type="text" name="scrubnurse_name[]" size="35" id="scrubnurse_name" autocomplete="off">
							<input type="hidden" name="scrubnurse" id="scrubnurse" autocomplete="off">
							<input type="button" name="addScrubnurse" id="addScrubnurse" onClick="return insertNewScrubnurse()" value="Add" class="button" style="border: 1px solid #001E6A">
							<table id="insertrowscrubnurse">
							</table>
			</td>
			
			<td width="35%">
				<!-- anaesthesits db search -->

				<input type="hidden" name="serialnumberanesthesist" id="serialnumberanesthesist" value="1">
							<input type="hidden" name="autoanesthesist_id" id="autoanesthesist_id" value="0"/>
							<input type="text" name="anesthesist_name[]" size="35" id="anesthesist_name" autocomplete="off">
							<input type="hidden" name="anesthesist" id="anesthesist" autocomplete="off">
							<input type="button" name="addanesthesist" id="addanesthesist" onClick="return insertNewanesthesist()" value="Add" class="button" style="border: 1px solid #001E6A">

							<table id="insertrowanesthesist">
										
							</table>
			</td>
			
					   
					   </tr>
					   
					   

	                   <tr>
	                   	<td  width="30%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" width="25%">
	                   		<table>
						  	 <?php
							 $sno_an=0;
					    		$query_surg_doc = "select * from theatre_booking_surgeons WHERE booking_id  = '$bookingid'";
								$exec_surg_doc = mysqli_query($GLOBALS["___mysqli_ston"], $query_surg_doc) or die ("Error in query_surg_doc".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($res_surg_doc = mysqli_fetch_array($exec_surg_doc)){
									$surg_id = $res_surg_doc['surgeon_id'];
									$idtodel= $res_surg_doc['auto_number'];
									$query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surg_id'";		
									$exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
									/*echo "<option value=''>Select Services</option>";*/
									while ($res_t = mysqli_fetch_assoc($exec_t))
									{  
										$newdoctorname=$res_t['doctorname'];
										/*echo '<br><hr>' . $newdoctorname;*/
										$newdoctorcode=$res_t['doctorcode'];
										$sno_an=$sno_an+1;
									}			
					 		?>		

					         <tr>
								<td width="250" style="border: 0px solid red; background-color: #FFFFFF;">
				<input id="surgeon<?php echo $sno_an; ?>" class="surgeon" name="surgeon<?php echo $sno_an; ?>" type="hidden" align="left" value="<?php echo ($newdoctorcode); ?>" >                      <?php echo  $newdoctorname;?>
						<span class="action"><a href="#" id="<?php echo $idtodel; ?>" class="delete" title="Delete" style="color:red;">&nbsp;X</a></span>   
								</td>
							</tr>
							<?php } ?>
							<input id="sno_an" class="sno_an" name="sno_an" type="hidden" align="left" value="<?php echo ($sno_an); ?>" >
							</table>
	                   	</td>

	                   	<td width="30%"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" width="25%">
	                   		<table>
								<?php 
								$sno_suc=0;
								    $query2 = "SELECT employeename, employeecode from master_employee where departmentname= 'Theatre' ";
									$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
									while ($res2 = mysqli_fetch_array($exec2))
									{
										$ename = $res2['employeename'];	  
										//$docauto = $res2['auto_number'];
										$ecode = $res2['employeecode'];
										
										
									}
									$query_scrubnurse = "select * from theatre_panel_scrubnurses WHERE booking_id  = '$bookingid'";
									$exec_surg_doc = mysqli_query($GLOBALS["___mysqli_ston"], $query_scrubnurse) or die ("Error in query_surg_doc".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($res_surg_doc = mysqli_fetch_array($exec_surg_doc)){
										//
										/*$surg_id = $res_surg_doc['surgeon_id'];

										$idtodel= $res_surg_doc['auto_number'];*/

										$ecode=$res_surg_doc['scrubnurse_id'];

										$scrubid=$res_surg_doc['auto_number'];

									$query2 = "SELECT employeename, employeecode from master_employee where  employeecode='$ecode' ";
									$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

									while ($res2 = mysqli_fetch_array($exec2))
									{
										$ename = $res2['employeename'];	  
										//$docauto = $res2['auto_number'];
										/*$ecode = $res2['employeecode'];
										*/
									$sno_suc=$sno_suc+1;	
									}
								?>
						
								<tr>
									<td style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
									
				<input id="scrubnurse<?php echo $sno_suc; ?>" class="scrubnurse" name="scrubnurse<?php echo $sno_suc; ?>" type="hidden" align="left" value="<?php echo ($ecode); ?>" >				
									
										<?php echo $ename; ?>						
      									 <span class="action"><a href="#" id="<?php echo $scrubid; ?>" class="deletescrub" title="Delete" style="color:red;">&nbsp;X</a></span>
									</td>
								</tr>
							<?php } ?>
							
							<input id="sno_suc" class="sno_suc" name="sno_suc" type="hidden" align="left" value="<?php echo ($sno_suc); ?>" >
							</table>
							
	                   	</td>
	                   	
	                   	<td width="30%"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" width="25%">
	                   		<table>

                            <?php
							$sno_anthe=0;
					 		$query_anesthesistdb = "select * from master_theatre_booking WHERE auto_number  = '$bookingid'";
							$exec_anesthesistdb = mysqli_query($GLOBALS["___mysqli_ston"], $query_anesthesistdb) or die ("Error in query_anesthesistdb".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res_anesthesistdb = mysqli_fetch_array($exec_anesthesistdb)){
							//
							$anamedb = $res_anesthesistdb['anesthesia'];}
							/*$autonoan=$res_anesthesistdb['auto_number'];*/
							if($anamedb!=''){
							$query_l = "SELECT doctorcode, doctorname FROM master_doctor WHERE doctorcode='$anamedb' AND status <> 'deleted' AND doctorname <> '' AND department in ('27','1')";
							$exec_l = mysqli_query($GLOBALS["___mysqli_ston"], $query_l) or die ("Error in Query_y".mysqli_error($GLOBALS["___mysqli_ston"]));
                            /*echo "<option value=''>Select Services</option>";*/
							while ($res_l = mysqli_fetch_assoc($exec_l))
							{  
							$anesthesistnamedb=$res_l['doctorname'];
							/*echo '<br><hr>' . $newdoctorname;*/
							$anesthesistcodedb=$res_l['doctorcode'];
							$sno_anthe=$sno_anthe+1;
							}
                            ?>	
					 	    <td style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
		<!--<input id="anesthesist<?php echo $sno_anthe; ?>" class="anesthesist" name="anesthesist<?php echo $sno_anthe; ?>" type="hidden" align="left" value="<?php echo ($anesthesistcodedb); ?>" >-->					
							
					 	    <?php echo $anesthesistnamedb;?>
					 		</td>
							
								 <?php }
								    $query_anesthesist = "select * from theatre_panel_anesthesist WHERE booking_id  = '$bookingid'";
									$exec_anesthesist = mysqli_query($GLOBALS["___mysqli_ston"], $query_anesthesist) or die ("Error in query_anesthesist".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($res_anesthesist = mysqli_fetch_array($exec_anesthesist)){
										//
										$aname = $res_anesthesist['anesthesist_id'];

										$autonoan=$res_anesthesist['auto_number'];

										$query_y = "SELECT doctorcode, doctorname FROM master_doctor WHERE doctorcode='$aname' AND status <> 'deleted' AND doctorname <> '' AND department = '42'";
										$exec_y = mysqli_query($GLOBALS["___mysqli_ston"], $query_y) or die ("Error in Query_y".mysqli_error($GLOBALS["___mysqli_ston"]));

										/*echo "<option value=''>Select Services</option>";*/
										while ($res_y = mysqli_fetch_assoc($exec_y))
										{  
											$anesthesistname=$res_y['doctorname'];
											/*echo '<br><hr>' . $newdoctorname;*/
											
											$sno_anthe=$sno_anthe+1;
										}
					 			 ?>	
					             <tr>
									<td style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
<input id="anesthesist<?php echo $sno_anthe; ?>" class="anesthesist" name="anesthesist<?php echo $sno_anthe; ?>" type="hidden" align="left" value="<?php echo ($aname); ?>" >	
										<?php 	
											echo $anesthesistname;
										?>							
       									<span class="action"><a href="#" id="<?php echo $autonoan; ?>" class="deletean" title="Delete" style="color:red;">&nbsp;X</a></span>
    
									</td>
								</tr>
								

							<?php } ?>

								<input id="sno_anthe" class="sno_anthe" name="sno_anthe" type="hidden" align="left" value="<?php echo ($sno_anthe); ?>" >
							</table>
	                   		
	                   	</td>

	                   	<!-- end of scrub-->

	                   	 <tr>
	                   	<th width="38%"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Circulating nurses</strong></th>
	                   	<th  width="35%"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Anaesthesia type</strong></th>
	                   	<th width="35%"  align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Technician</strong></th>
	                   	
	                   </tr>
					
					

                 <tr>
				 <td width="30%" >
				<!-- circulating nurse db search -->

				<input type="hidden" name="serialnumbercircnurse" id="serialnumbercircnurse" value="1">
							<input type="hidden" name="autocircnurse_id" id="autocircnurse_id" value="0"/>
							<input type="text" name="circnurse_name[]" size="35" id="circnurse_name" autocomplete="off">
							<input type="hidden" name="circnurse" id="circnurse" autocomplete="off">
							<input type="button" name="addcircnurse" id="addcircnurse" onClick="return insertNewcircnurse()" value="Add" class="button" style="border: 1px solid #001E6A">

							<table id="insertrowcircnurse">
										
							</table>
			   </td>
				 
				 <td  align="left" valign="middle"  bgcolor="#ecf0f5" colspan="1">
				 
								<select name="anesthesiatype" id="anesthesiatype" width="" style="border: 1px solid #001E6A;">
							  		<option value="">Anaesthesia Type</option>
		                            <option value="General Anesthesia" <?php if($anesthesiatype == 'General Anesthesia'){ echo "selected"; } ?> >General Anesthesia</option>
		                            <option value="Spinal Anesthesia" <?php if($anesthesiatype == 'Spinal Anesthesia'){ echo "selected"; } ?> >Spinal Anesthesia </option>
		                            <option value="Sedation Anesthesia" <?php if($anesthesiatype == 'Sedation Anesthesia'){ echo "selected"; } ?> >Sedation Anesthesia</option>
		                            <option value="Regional Block Anesthesia" <?php if($anesthesiatype == 'Regional Block Anesthesia'){ echo "selected"; } ?> >Regional Block Anesthesia</option>
		                            <option value="Local Anesthesia" <?php if($anesthesiatype == 'Local Anesthesia'){ echo "selected"; } ?> >Local Anesthesia</option>
							  	</select>
							</td>
				 
				 <td colspan="1">
				<!-- technician db search -->

				<input type="hidden" name="serialnumbertechnician" id="serialnumbertechnician" value="1">
							<input type="hidden" name="autotechnician_id" id="autotechnician_id" value="0"/>
							<input type="text" name="technician_name[]" size="35" id="technician_name" autocomplete="off">
							<input type="hidden" name="technician" id="technician" autocomplete="off">
							<input type="button" name="addtechnician" id="addtechnician" onClick="return insertNewtechnician()" value="Add" class="button" style="border: 1px solid #001E6A">

							<table id="insertrowtechnician">
										
							</table>
			</td>
				 
				 
				 </tr>
                 <tr>
				 
				 <td colspan="1" >
						
							<table>
								 <?php
								 $sno_cir=0;
					    $query_circnurse = "select * from theatre_panel_circulating_nurse WHERE booking_id  = '$bookingid'";
						$exec_circnurse = mysqli_query($GLOBALS["___mysqli_ston"], $query_circnurse) or die ("Error in query_anesthesist".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_circnurse = mysqli_fetch_array($exec_circnurse)){
							//
							$circname = $res_circnurse['circulatingnurse_id'];
							$circid=$res_circnurse['auto_number'];
							$circidcirculatingnurse_id=$res_circnurse['circulatingnurse_id'];
							
							$query_b = "SELECT employeename, employeecode from master_employee where  employeecode='$circname'";
				$exec_b = mysqli_query($GLOBALS["___mysqli_ston"], $query_b) or die ("Error in Query_b".mysqli_error($GLOBALS["___mysqli_ston"]));
				/*echo "<option value=''>Select Services</option>";*/
				while ($res_b = mysqli_fetch_assoc($exec_b))
				{  
					$circname=$res_b['employeename'];
					/*echo '<br><hr>' . $newdoctorname;*/
					$sno_cir=$sno_cir+1;
				}
					 ?>	
					 <tr>
						<td style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
	<input id="circnurse<?php echo $sno_cir; ?>" class="circnurse" name="circnurse<?php echo $sno_cir; ?>" type="hidden" align="left" value="<?php echo ($circidcirculatingnurse_id); ?>" >					
						
						
								<?php echo  $circname;	?>
								 <span class="action"><a href="#" id="<?php echo $circid; ?>" class="deletecirc" title="Delete" style="color:red;">&nbsp;X</a></span>
                        </td>
					</tr>
						<?php } ?>

							<table id="insertrowcircnurse">
										
							</table>
							<!--/insert-->
			<input id="sno_cir" class="sno_cir" name="sno_cir" type="hidden" align="left" value="<?php echo ($sno_cir); ?>" >				
							
							
						</td>
				 <td colspan="1"></td>
				 <td  colspan="1" >	
				 <table>
                        <?php
						$sno_tech=0;
					    $query_technician = "select * from theatre_panel_technician WHERE booking_id  = '$bookingid'";
						$exec_technician = mysqli_query($GLOBALS["___mysqli_ston"], $query_technician) or die ("Error in query_technician".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_technician = mysqli_fetch_array($exec_technician)){
							//
						$technicianname = $res_technician['technician_id'];
						$technicianid = $res_technician['auto_number'];
                        $query_z = "SELECT employeename, employeecode from master_employee where employeecode='$technicianname'";
						$exec_z = mysqli_query($GLOBALS["___mysqli_ston"], $query_z) or die ("Error in Query_z".mysqli_error($GLOBALS["___mysqli_ston"]));
                        /*echo "<option value=''>Select Services</option>";*/
				        while ($res_z = mysqli_fetch_assoc($exec_z))
				        {  
				     	$actualname=$res_z['employeename'];
					    /*echo '<br><hr>' . $newdoctorname;*/
						$sno_tech=$sno_tech+1;
				        }
					 ?>		
					 <tr>
					<td style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
<input id="technician<?php echo $sno_tech; ?>" class="technician" name="technician<?php echo $sno_tech; ?>" type="hidden" align="left" value="<?php echo ($technicianname); ?>" >
						<?php echo  $actualname;?>
					<span class="action"><a href="#" id="<?php echo $technicianid; ?>" class="deletetech" title="Delete" style="color:red;">&nbsp;X</a></span>
                    </td>
					</tr>
					<?php } ?>
					<table id="insertrowtechnician">
										
							</table>
							<!--/insert-->	
							
					<input id="sno_tech" class="sno_tech" name="sno_tech" type="hidden" align="left" value="<?php echo ($sno_tech); ?>" >			
				
				</td>
				
				 </tr>	
					
						<tr>
						  <?php 
						     // check patient stat
						     if ($approval_status == 'Inprogress'){
						  ?>
						  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><font color='red'>Patient Status</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							  <select width="140" name="patient_status" id="patient_status">
                              	<option value="">Select Patient Status</option>
                              	<option value="Alive">Alive</option>
                              	<option value="Dead">Dead</option>
                              </select>
						  </td>
						  <?php
						     }
						  ?>	
						</tr>
						<?php 
						     // check patient stat
						     if ($approval_status == 'Inprogress'){
						?>
						<tr>
							<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
								<strong>Comment</strong>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<textarea name="comment" id="comment"></textarea>
							</td>
							
							
						</tr>
						
					    <?php } ?>
	                </tbody>
	            </table>
  			</td>
  		</tr>
  		<!-- procedure details and equipments -->
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4" width="85%"   align="left" border="1">
          <tbody>
          	<!-- <tr>
              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                <input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />
                <div align="left"><strong>Procedure List</strong></div></td>
            </tr> -->
            <tr>
                 
                 <!-- <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>#</strong></div></td> -->
                <!--
				 <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Code</strong></div></td>-->
           
				 <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Procedure(s)</strong></td>
           
              <td align="left" valign="middle">
									
								<input type="hidden" name="serialnumberProcedure" id="serialnumberProcedure" value="1">
							
								<input type="hidden" name="auto_idProcedure" id="auto_idProcedure" value="0"/>
								<input type="text" name="procedure_name[]" size="25" id="serv" autocomplete="off">
								<input type="hidden" name="serv_procedure" id="procedure" autocomplete="off">
								<input type="button" name="addProcedure" id="addProcedure" onClick="return insertNewProcedure()" value="Add" class="button" style="border: 1px solid #001E6A"> 
								 <table id="insertrowProcedure"></table>
								<table>
						<?php 
                		//echo $speacialityname; 
						$sno_prod=0;
						$query3_012 = "select * from theatre_booking_proceduretypes where booking_id = '$bookingid'";
						$exec3_012 = mysqli_query($GLOBALS["___mysqli_ston"], $query3_012) or die ("Error in Query3_012".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res3_012 = mysqli_fetch_array($exec3_012)){
							//
						$proceduretypename = $res3_012['proceduretype_id'];
                        $idtodelp=$res3_012['auto_number'];
                        //echo $procedure_id;
						$sno_prod=$sno_prod+1;
							/*$query3_013 = "select * from master_theatrespeaciality_subtype WHERE auto_number  = '$procedure_id'";
							$exec3_013 = mysql_query($query3_013) or die ("Error in Query3_013".mysql_error());
							$res3_013 = mysql_fetch_array($exec3_013);
							$procedure = $res3_013['speaciality_subtype_name'];*/
                        ?>
						<tr>
							<td style="border: 0px solid #001E6A; background-color: #FFFFFF; text-align: left;">
<input id="procedure<?php echo $sno_prod; ?>" class="procedure" name="procedure<?php echo $sno_prod; ?>" type="hidden" align="left" value="<?php echo ($proceduretypename); ?>" >							
							
							
								<?php  echo  $proceduretypename;?>
							<span class="action"><a href="#" id="<?php echo $idtodelp; ?>" class="deletep" title="Delete" style="color:red;">&nbsp;X</a></span>
                            </td>
                         </tr>
						<?php } ?>
						
						
						
						</table>
             <input id="sno_prod" class="sno_prod" name="sno_prod" type="hidden" align="left" value="<?php echo ($sno_prod); ?>" >          
                        </td>
				<?php if(strtotime($start_time) == NULL ||  strtotime($start_time) < 0 ) { ?>
				<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><font color='red'>Pre Anaesthetist notes</font></strong></td>
				<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
					<textarea rows="5" cols="30" name="anaesthetisit_note" id="anaesthetisit_note"><?php echo stripslashes($anaesthetisit_note); ?></textarea>
				</td>
			
				<?php } else if(strtotime($start_time) > 0 && $approval_status == 'Inprogress') {
	            ?>
                 <td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><font color='red'>Intra Anaesthetist notes</font></strong></td>
				<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
					<textarea rows="5" cols="30" name="intra_anaesthetisit_note" id="intra_anaesthetisit_note"><?php echo stripslashes($intra_anaesthetisit_note); ?></textarea>
				</td>
				
				<?php } 
				else if(strtotime($start_time) > 0 && $approval_status == 'Completed') {
	            ?>
                 <td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong><font color='red'>Post Anaesthetist notes</font></strong></td>
				<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
					<textarea rows="5" cols="30" name="post_anaesthetisit_note" id="post_anaesthetisit_note"></textarea>
				</td>
				
				<?php }
				
				?>
				
				<!--<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Pre Doctor notes</strong></td>
				<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
					<textarea rows="2" cols="30" name="doctor_note" id="doctor_note"><?php echo $doctor_note; ?></textarea>
				</td>-->
				
		    </tr>
            
			

          	<tr>
				<td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Equipments</strong></td>	
	            <td align="left" valign="middle"  bgcolor="#ecf0f5">
					<select name="equipments[]" id='pre-selected-options' multiple='multiple'>
					    <?php 
					    // get equipments from masters
					    $query_equip= "SELECT * FROM master_equipments WHERE record_status <> 'deleted'";
						$exec_equip= mysqli_query($GLOBALS["___mysqli_ston"], $query_equip) or die ("Error in Query_speac".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res_equip = mysqli_fetch_array($exec_equip)){
							 //
							 $equip_id = $res_equip['auto_number'];
							 $equip_name = $res_equip['equipment_name'];

							 // get selected equipments
							 $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			                 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				             $res1 = mysqli_fetch_array($exec1);
				             $res1location = $res1["locationname"]; 
				             $res1locationcode = $res1["locationcode"];
				             $patientlocationcode = $res1locationcode;
				             // final
				             $equipment_id = '';
				             $query2 = "select * from master_theatre_equipments where locationcode='$patientlocationcode' and theatrebookingcode='$bookingid' and patientcode='$patientcode' and itemcode = '$equip_id' order by auto_number desc";
			                 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			                 while($res2 = mysqli_fetch_array($exec2))
			                 {
			                 	$equipment_id= $res2['itemcode'];
                             }
					     ?>  
						     <option value='<?php echo $equip_id;?>' <?php if($equipment_id == $equip_id){echo "selected"; } ?> >
						     	<?php echo $equip_name;?>
						     </option>
					     <?php } ?>
					</select>
			    </td>
				<?php if(strtotime($start_time) > 0 && $approval_status == 'Inprogress') { ?>
				<td align='left'>
				<div align='left'><a href='download_opsample.php' target='_blank'>Download Sample</a></div>
				<div>
				<br>
				<font color='red'>Intra OP Form :</font> <input type="file" name="claimpdf" class='claimpdf<?=$bookingid;?>' style="width: 90px;" id="claimpdfa<?=$bookingid;?>" onchange="upload_intra_new('<?=$bookingid;?>','<?=$visitcode;?>')"> 
				<a id='showcalimpdf<?=$bookingid;?>' style="<?php if($intra_op==''){ echo 'display:none;'; } ?>" target="_blank" href="view_uploaded_op.php?id=<?php echo $bookingid;?>">View Intra Form</a>  
				</div>
				</td>
				<?php } ?>
			
			</tr>
			
            <tr>
             	<td colspan="10" align="left" valign="center" 
                class="bodytext311">&nbsp;</td>
            
            </tr>
	            <?php if(strtotime($start_time) == NULL ||  strtotime($start_time) < 0 ) { 
			
				if($current_time>$stime){ ?>
	            	<tr id="buttonremarks">
	              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>				 
		          <td colspan="" align="right" valign="top"  bgcolor="#FFFFFF">
		          	<input  type="button" value="Back to registration" name="Submit" style="background-color: grey;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process_update();" /> </td>
				 
				 <td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">			
		              <input  type="button" value="START" name="Submit" id="submit1"  style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process1();" />
					  </td>	
					  
					  <tr id="buttonwithoutremarks" style="display:none">
	              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>				 
		          <td colspan="" align="right" valign="top"  bgcolor="#FFFFFF">
		          	<input  type="button" value="Back to registration" name="Submit" style="background-color: grey;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process_update();" /> </td>
				 
				 <td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">	
				    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">		
		              <input  type="submit" value="START" name="Submit" id="submit1"  style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;"  />
					  </td>				 
	            </tr>
					  			 
	            </tr>
				<?php } else { ?>
				<tr id="buttonwithoutremarks">
	              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>				 
		          <td colspan="" align="right" valign="top"  bgcolor="#FFFFFF">
		          	<input  type="button" value="Back to registration" name="Submit" style="background-color: grey;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process_update();" /> </td>
				 
				 <td colspan="" align="left" valign="top"  bgcolor="#FFFFFF">	
				    <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">		
		              <input  type="submit" value="START" name="Submit" id="submit1"  style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;"  />
					  </td>				 
	            </tr>
				
				<?php } ?>
	            <?php } ?>
	           
	          
				  <?php 
	              if(strtotime($start_time) > 0 && $approval_status == 'Inprogress') {
	            ?>
				  <tr>
	             <td  colspan="2" align="center" valign="top"  bgcolor="#FFFFFF">
				 <!--<input  type="button" value="Submit" name="Submit" style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process_update();"  /> -->
		        
				  
		          	<input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
		          	<button type="submit" style="background-color: red;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process2('<?php echo $bookingid;?>');">STOP</button>
		           </td>
				   </tr>
				   <?php } ?>


				    <?php 
	              if(strtotime($start_time) > 0 && $approval_status == 'Completed') {

					   if($doctor_note=='')
					        $pre_doc_status=0;
					   else
                            $pre_doc_status=1;

					   if($intra_doctor_notes=='')
					        $intra_doc_status=0;
					   else
                            $intra_doc_status=1;

					   if($post_doctor_notes=='')
					        $post_doc_status=0;
					   else
                            $post_doc_status=1;
	            ?>
				  <tr>
	             <td  colspan="2" align="center" valign="top"  bgcolor="#FFFFFF">
				 <!--<input  type="button" value="Submit" name="Submit" style="background-color: #4CAF50;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process_update();"  /> -->
		        
				    <input type="hidden" name="pre_doc_status" id="pre_doc_status" value="<?php echo $pre_doc_status;?>">
					<input type="hidden" name="intra_doc_status" id="intra_doc_status" value="<?php echo $intra_doc_status;?>">
					<input type="hidden" name="post_doc_status" id="post_doc_status" value="<?php echo $post_doc_status;?>">

		          	<input type="hidden" name="cbfrmflag3" value="cbfrmflag3">
		          	<button type="submit" style="background-color: red;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;" onClick="return process3('<?php echo $bookingid;?>');">Complete</button>
		           </td>
				   </tr>
				   <?php } ?>
	            
	            
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>

				<tr>
        <td>&nbsp;</td>
        </tr>  

        

    </table>
  </table>
  </form>
  <div>
  	
<div class="form-popup" id="myForm">
  <form id="myForm" class="form-container" method="post" >
    <h1>Reasons for starting later than scheduled time</h1>

   <select name="selectedReason" id="selectedReason">
  <option value="ward">Ward</option>
  <option value="surgeon">Surgeon</option>
  <option value="Anaesthetist">Anaesthetist</option>
  <option value="Equipment">Equipment</option>
  <option value="Instruments">Instruments</option>
  <option value="Patient checked in late">Patient Checked in late</option>
  <option value="Lab Investigation"> Lab Investigation</option>
  <option value="Blood">  Blood</option>
  <option value="Consent by patient">Consent by patient</option>
</select>

    <label for="psw"><b>Select reason</b></label>
    <input type="text" placeholder="Specify reason" name="reason" id="reason" required>
  <!-- <input type="hidden" name="cbfrmflag3" value="cbfrmflag3">-->
    <input type="hidden" name="bookingreason_code" id="bookingreason_code" value="<?php echo $id; ?>">
    <button type="submit" class="btn" id="button_reason">Submit</button>
    <button type="button" class="btn cancel"  onClick="closeForm()">Close</button>
  </form>
</div>
</div>	
<?php include ("includes/footer1.php"); ?>
<script type="text/javascript">


  $("#button_reason").click(function(){
	 /// alert("santu");
                var selectedReason=$("#selectedReason").val();
                var reason=$("#reason").val();
				 var bookingreason_code=$("#bookingreason_code").val();
                $.ajax({
                    url:'insertReason.php',
                    method:'POST',
					data:{ selectedReason:selectedReason,reason:reason,bookingreason_code:bookingreason_code},
                   
                   success:function(data){
                     //  alert(data);
					 $('#buttonremarks').hide();
					   $('#buttonwithoutremarks').show();
					   closeForm();
                   }
                });
				return false;
            });


function process_update()
{
var dataString='';
var fRet4; 
fRet4 = confirm('Are You Sure Want To Update?'); 
if (fRet4 == false)
{
return false;
}
var booking_code = document.getElementById("booking_code").value;
//surgeon
var sno_surg = document.getElementById("auto_id").value;
for(i=1;i<=sno_surg;i++){

var surgeon1 = document.getElementById("surgeon"+i).value;
if(surgeon1!=''){
var action='surgeon';
var dataString = dataString+"&booking_code="+booking_code+"&&surgeon1="+surgeon1+"&&action="+action;
//alert(dataString);
$.ajax({
		type: "get",
		url: "ajaxupdation_theatre.php",
		data: dataString,
		success: function(html){
		//alert(html);
		//alert("Sucess");
 		//location.reload();	
		}
	});
}}


//Scrub Nurses
var sno_scrub = document.getElementById("autoscrub_id").value;
for(i=1;i<=sno_scrub;i++){

var scrubnurse1 = document.getElementById("scrubnurse"+i).value;
if(scrubnurse1!=''){
var action='scrubnurse';
var dataString = dataString+"&booking_code="+booking_code+"&&scrubnurse1="+scrubnurse1+"&&action="+action;
//alert(dataString);
$.ajax({
		type: "get",
		url: "ajaxupdation_theatre.php",
		data: dataString,
		success: function(html){
		//alert(html);
		//alert("Sucess");
 		//location.reload();	
		}
	});
}
}


//Anesthetist
var sno_anesth = document.getElementById("autoanesthesist_id").value;
for(i=1;i<=sno_anesth;i++){

var anesthesist1 = document.getElementById("anesthesist"+i).value;
if(anesthesist1!=''){
var action='anesthesist';
var dataString = dataString+"&booking_code="+booking_code+"&&anesthesist1="+anesthesist1+"&&action="+action;
//alert(dataString);
$.ajax({
		type: "get",
		url: "ajaxupdation_theatre.php",
		data: dataString,
		success: function(html){
		//alert(html);
		//alert("Sucess");
 		//location.reload();	
		}
	});
}
}

//Circulating nurse
var sno_circnu = document.getElementById("autocircnurse_id").value;
for(i=1;i<=sno_circnu;i++){

var circnurse1 = document.getElementById("circnurse"+i).value;
if(circnurse1!=''){
var action='circnurse';
var dataString = dataString+"&booking_code="+booking_code+"&&circnurse1="+circnurse1+"&&action="+action;
//alert(dataString);
$.ajax({
		type: "get",
		url: "ajaxupdation_theatre.php",
		data: dataString,
		success: function(html){
		//alert(html);
		//alert("Sucess");
 		//location.reload();	
		}
	});
}
}

//Technician
var sno_tech = document.getElementById("autotechnician_id").value;
for(i=1;i<=sno_tech;i++){

var technician1 = document.getElementById("technician"+i).value;
if(technician1!=''){
var action='technician';
var dataString = dataString+"&booking_code="+booking_code+"&&technician1="+technician1+"&&action="+action;
//alert(dataString);
$.ajax({
		type: "get",
		url: "ajaxupdation_theatre.php",
		data: dataString,
		success: function(html){
		//alert(html);
		//alert("Sucess");
 		//location.reload();	
		}
	});
}
}


//Procedure
var sno_prod = document.getElementById("auto_idProcedure").value;
for(i=1;i<=sno_prod;i++){

var serv1 = document.getElementById("serv"+i).value;
if(serv1!=''){
var action='serv';
var dataString = dataString+"&booking_code="+booking_code+"&&serv1="+serv1+"&&action="+action;
//alert(dataString);
$.ajax({
		type: "get",
		url: "ajaxupdation_theatre.php",
		data: dataString,
		success: function(html){
		//alert(html);
		//alert("Sucess");
 		//location.reload();	
		}
	});
}
}


window.location ='theatreregistration.php';



}

	 // DB Searches
    $(function() {
    	var surgeonname = document.getElementById('surgeon_name');
	    $('#surgeon_name').autocomplete({		
			source:'ajaxtheatredoctor.php?term='+surgeonname, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var surgeonid=ui.item.docid;
					$('#surgeon').val(surgeonid);	
				}
		    });
	 });

    $(function() {
    	var circnurse = document.getElementById('circnurse');
	    $('#circnurse_name').autocomplete({		
			source:'ajaxtheatrecircnurse.php?term='+circnurse, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var circnurseid=ui.item.docid;
					$('#circnurse').val(circnurseid);	
				}
		    });
	 });

    $(function() {
    	var procedurename = document.getElementById('serv');
	    $('#serv').autocomplete({		
			source:'get_theatre_procedures.php',
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var procedurenameid=ui.item.docid;
					var specname=ui.item.spname;
					$('#procedure').val(procedurenameid);	
				}
		    });
	 });

    $(function() {
    	var scrubnurse = document.getElementById('scrubnurse_name');
	    $('#scrubnurse_name').autocomplete({		
			source:'ajaxscrubnurse.php?term='+scrubnurse, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var scrubnurseid=ui.item.docid;
					$('#scrubnurse').val(scrubnurseid);	
				}
		    });
	 });

    $(function() {
    	var technician = document.getElementById('technician_name');
	    $('#technician_name').autocomplete({		
			source:'ajaxtheatretechnician.php?term='+technician, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var technicianid=ui.item.docid;
					$('#technician').val(technicianid);	
				}
		    });
	 });

    $(function() {
    	var anesthesistname = document.getElementById('anesthesist_name');
	    $('#anesthesist_name').autocomplete({		
			source:'ajaxtheatrepanel.php?term='+anesthesistname, 
			
			minLength:2,
			delay: 0,
			html: true, 
				select: function(event,ui){
					var ana_id=ui.item.docid;
					$('#anesthesist').val(ana_id);	
				}
		    });
	 });
    $(function() {
$(".delete").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this surgeon?"))
{
 $.ajax({
   type: "POST",
   url: "deletesurgeon.php",
   data: info,
   success: function(){
var idf=document.getElementById('booking_code').value;

  window.location.href="theatrepanel.php?id="+idf;


    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
    $(function() {
$(".deletep").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this procedure type?"))
{
 $.ajax({
   type: "POST",
   url: "deleteprocedure.php",
   data: info,
   success: function(){
var idf=document.getElementById('booking_code').value;

  window.location.href="theatrepanel.php?id="+idf;


    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
     $(function() {
$(".deletescrub").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this scrub nurse?"))
{
 $.ajax({
   type: "POST",
   url: "deletescrubnurse.php",
   data: info,
   success: function(){
var idf=document.getElementById('booking_code').value;

  window.location.href="theatrepanel.php?id="+idf;


    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
    $(function() {
$(".deletecirc").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this nurse?"))
{
 $.ajax({
   type: "POST",
   url: "deletecircnurse.php",
   data: info,
   success: function(){
var idf=document.getElementById('booking_code').value;

  window.location.href="theatrepanel.php?id="+idf;


    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
     $(function() {
$(".deletetech").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this technician?"))
{
 $.ajax({
   type: "POST",
   url: "deletetecnician.php",
   data: info,
   success: function(){
var idf=document.getElementById('booking_code').value;

  window.location.href="theatrepanel.php?id="+idf;


    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
     $(function() {
$(".deletean").click(function(){
var element = $(this);
var del_id = element.attr("id");
var info = 'id=' + del_id;
if(confirm("Are you sure you want to delete this anesthesist?"))
{
 $.ajax({
   type: "POST",
   url: "deleteanesthesist.php",
   data: info,
   success: function(){
var idf=document.getElementById('booking_code').value;

  window.location.href="theatrepanel.php?id="+idf;


    
 }
});
  $(this).parents(".show").animate({ backgroundColor: "blue" }, "slow")
  .animate({ opacity: "hide" }, "slow");
 }
return false;
});
});
	/*
	var minutesLabel = document.getElementById("minutes");
	var secondsLabel = document.getElementById("seconds");
	var totalSeconds = 0;
	setInterval(setTime, 1000);

	function setTime() {
	  ++totalSeconds;
	  secondsLabel.innerHTML = pad(totalSeconds % 60);
	  minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
	}

	function pad(val) {
	  var valString = val + "";
	  if (valString.length < 2) {
	    return "0" + valString;
	  } else {
	    return valString;
	  }
	}*/

	// instantiate
	$('#pre-selected-options').multiSelect({
		  selectableHeader: "<div class='custom-header'>Equipments</div>",
		  selectionHeader: "<div class='custom-header'>Selected Equipments</div>",
	});


function btnDeleteClick10(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry 1?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	
	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowtechnician'); // tbody name.
	document.getElementById ('insertrowtechnician').removeChild(child2);
	document.getElementById ('technician').value='';
	
	console.log(parent2);
	var child2 = document.getElementById('technician_name'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowtechnician'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
	
	
}
function btnDeleteClick8(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry 3?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	
	
	
	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowcircnurse'); // tbody name.
	document.getElementById ('insertrowcircnurse').removeChild(child2);
	document.getElementById ('circnurse'+varDeleteID2).value='';
	console.log(parent2);
	var child2 = document.getElementById('circnurse_name'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowanesthesist'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
	
	
	

	
}
function btnDeleteClick7(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry 2?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowanesthesist'); // tbody name.
	document.getElementById ('insertrowanesthesist').removeChild(child2);
	document.getElementById('anesthesist'+varDeleteID2).value='';
	console.log(parent2);
	var child2 = document.getElementById('anesthesist_name'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowanesthesist'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
		
}
function btnDeleteClick6(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry6?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	
	
	
	var child2= document.getElementById('idTR1'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowProcedure'); // tbody name.
	document.getElementById ('insertrowProcedure').removeChild(child2);
	document.getElementById ('procedure'+varDeleteID2).value='';
	
	console.log(parent2);
	var child2 = document.getElementById('procedure'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowProcedure'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
	
}


function btnDeleteClick11(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry4?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	
	
	
	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowscrubnurse'); // tbody name.
	document.getElementById ('insertrowscrubnurse').removeChild(child2);
	document.getElementById ('scrubnurse'+varDeleteID2).value='';
	
	console.log(parent2);
	var child2 = document.getElementById('scrubnurse_name'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrowscrubnurse'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
	
	
	

	
}


function btnDeleteClick5(delID5)
{
	/*alert ("Inside btnDeleteClick.");*/
	//var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	
	
	
	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child2);
	document.getElementById ('surgeon'+varDeleteID2).value='';
	
	console.log(parent2);
	var child2 = document.getElementById('technician_name'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		alert ("Row Exsits.");
		//document.getElementById ('insertrow').removeChild(child2);
	}
	
}



	
	
</script>
</body>
</html>


</script>
</body>
</html>

