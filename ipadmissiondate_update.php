<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

include ("autocompletebuild_customeripbilling.php");
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
-->
</style>

<script type="text/javascript" src="ckeditor1/ckeditor.js"></script>
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<link href="css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.datetimepicker.full.min.js"></script>
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="js/bootstrap-datetimepicker.min.js"></script>
<link href="css/jquery.datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.datetimepicker.full.min.js"></script>
<script src="js/sweetalert.js"></script>

<script language="javascript">
var checkPastTime = function(currentDateTime) {

var d = new Date();
var todayDate = d.getDate();


if (currentDateTime.getDate() == todayDate) { // check today date
    this.setOptions({
        minTime: d.getHours() + ':00' //here pass current time hour
    });
} else
    this.setOptions({
        minTime: false
    });
};

$(document).ready(function(){
    jQuery('.admdatetime').datetimepicker({
    	step: 15,
    	maxDate : 0,
        onChangeDateTime:checkPastTime,
        onShow:checkPastTime
    });
});




function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here




function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcPopupOnLoad1();
}


	
</script>
<script type="text/javascript">


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
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

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}



	
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script>

$(document).ready(function(){
$(".saveitem").click(function() {
		var clickedid = $(this).attr('id');
		var idstr = clickedid.split('s_');
		var id = idstr[1];
		var visitcode = $('#visitcode'+id).val();
		var admdate = $('#admdate'+id).val();
		var disdate = $('#disdate'+id).val();
		$.ajax({
		  url: 'ajax/ajax_updateipadmissiondate.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      visitcode: visitcode, 
		      admdate: admdate, 
		      disdate: disdate, 
		  },
		  success: function (data) { 
		  	//alert(data)
		  	
		  	var msg = data.msg;
		  	if(data.status == 1)
		  	{
		  		alert(msg);
		  	}
		  	else
		  	{
		  		alert(msg);
		  	}
		  	
		  }
		});
		return false;
	})
	})
	
	

</script>
<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="110%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="ipadmissiondate_update.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>IP Patient List </strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
          				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="location" id="location"  onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
						<?php
						}
						?>
                  </select>
                  </td>
				  </tr>

           <tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
				
             
              <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input   type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
            </td>
            </tr>
			    
             </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	 
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['customer'];
	$searchlocation = $_POST['location'];
	
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 
            align="left" border="0">
          <tbody>
             
			<tr>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Type.</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				
				<td width="" colspan="2"class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Provider </strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Admission Date</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>DateTime </strong></div></td>
				<td width="" class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="center"><strong>Discharge Date</strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Discharge DateTime </strong></div></td>
				<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
			</tr>
           <?php
		  $mainsno=0;
		  if($searchpatient != '')
		  { 
	  
		  	$colorloopcount1=0;
		  	$sno1=0;
           $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $paymentstatus = $res34['paymentstatus'];
		   $creditapprovalstatus = $res34['creditapprovalstatus'];
		   $recorddate = $res34['recorddate'];
		   //$recorddate1 = $res34['recorddate'];
		   $recordtime = $res34['recordtime'];

		   //include ('ipcreditaccountreport3_ipcredit.php');
			//$total = $overalltotal;
		  
		   $query71 = "select * from ip_discharge where locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   $res71 = mysqli_fetch_array($exec71);
		   if($num71 == 0)
		   {
			$dischargedate='';
			   $dischargetime='';
		   $status = 'Active';
		   }
		  else
		   {
			 if($res71['req_status']=='request'){
		       $status = 'Active';
			   $dischargedate='';
			   $dischargetime='';
			 }else{
				$status = 'Discharged';
				$dischargedate = $res71['recorddate'];
				$dischargetime = $res71['recordtime'];
			 }
		   }

			$query51 = "select * from ip_bedallocation where visitcode='$visitcode' and recordstatus='discharged' ";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num51 = mysqli_num_rows($exec51);
			$res51 = mysqli_fetch_array($exec51);
			if($num51 > 0)
			{
			$recorddate1=$res51['recorddate'];
			}else{
			$query51 = "select * from ip_bedtransfer where visitcode='$visitcode' and recordstatus='discharged' ";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num51 = mysqli_num_rows($exec51);
			$res51 = mysqli_fetch_array($exec51);
			$recorddate1=$res51['recorddate'];
			}
		   
		   $query82 = "select * from master_ipvisitentry where locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $conslt_timedate = $res82['consultationtime'];
		   $accountname = $res82['accountfullname'];
		   $ipvist_autonumber = $res82['auto_number'];
		   $patientlocationcode = $res82['locationcode'];
		   $type = $res82['type'];
		   $subtype_ledger = $res82['accountname'];
		   
$query15 = "select accountname from master_accountname where auto_number = '$subtype_ledger'";

$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

$res15 = mysqli_fetch_array($exec15);

$provider = $res15['accountname'];
		   if($type=='hospital')
		   {
			$type='H';   
		   }
		   if($type=='private')
		   {
			$type='P';   
		   }
		 
		   if($paymentstatus == '')
		   {
		   if($creditapprovalstatus == '')
		   {
			   $mainsno=$mainsno+1;
		   		$colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';	
			}
			?>
			
          <tr <?php echo $colorcode1; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $type; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $patientname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $patientcode; ?></div></td>
			
			<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $visitcode; ?>
			<input type="hidden" name="visitcode<?php echo $mainsno;?>" id="visitcode<?php echo $mainsno;?>" value="<?php echo $visitcode; ?>" />
			</div></td>
			<td class="bodytext31" valign="center"  align="left">&nbsp; </td>
			<td class="bodytext31" valign="center"  align="left">  <div align="center"><?php echo $provider; ?></div></td>
			<td class="bodytext31" valign="center"  align="left">  <div align="center"><?php echo $accountname; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center" style='color:<?php if($status=='Discharged') echo '#F00'; elseif($status=='Requested') echo '#3366cc'; else echo ''; ?>'><?php echo $status; ?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><strong><?php echo date("d/m/Y", strtotime($recorddate))." ".$recordtime; ?></strong></div></td>
			<td class="bodytext31" valign="center"  align="left"><input id="admdate<?php echo $mainsno;?>" name="admdate<?php echo $mainsno;?>" class='admdatetime' size="18" autocomplete="off" readonly type="text"  >		</td>
			<script>
			getdischargedate('<?php echo $recorddate1; ?>','<?php echo $mainsno;?>');
			function getdischargedate(recorddate,ser){
			var serno=ser;
			var startdate=recorddate;
			var enddate=new Date().toISOString().slice(0, 10);
			var checkPastTime1 = function(currentDateTime1) {

			var d = new Date();
			var todayDate = d.getDate();
			if (currentDateTime1.getDate() == todayDate) { // check today date
				this.setOptions({
					minTime: d.getHours() + ':00' //here pass current time hour
				});
			} else
				this.setOptions({
					minTime: false
				});
			};

			$(document).ready(function(){
				
				jQuery('.dischargedatetime'+serno).datetimepicker({
					step: 15,
					minDate: startdate,
					maxDate: enddate,
					onChangeDateTime:checkPastTime1,
					onShow:checkPastTime1
				});
				
			});
			}
			</script>
			<?php if($dischargedate!=''){?>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><strong><?php echo date("d/m/Y", strtotime($dischargedate))." ".$dischargetime; ?></strong></div></td>
			<td class="bodytext31" valign="center"  align="left"><input id="disdate<?php echo $mainsno;?>" name="disdate<?php echo $mainsno;?>" class='dischargedatetime<?php echo $mainsno;?>' size="18" autocomplete="off" readonly type="text"  >		</td>
			<?php } else{ ?>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><strong>&nbsp;</strong></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><strong>&nbsp;</strong></div></td>
			<?php } ?>
			<td class="bodytext31" valign="center"  align="center"><a  class="saveitem" id="s_<?php echo $mainsno; ?>" href="" ><strong>Update</strong></a></td>
		 </tr>
		  <?php
		  }
		  }
		 }
		  }else
		  {
		  	$colorloopcount1=0;
		  	$sno1=0;
		 $query34 = "select * from ip_bedallocation where locationcode='$searchlocation' and paymentstatus = '' and creditapprovalstatus = ''";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
			$recorddate = $res34['recorddate'];
			//$recorddate1 = $res34['recorddate'];
		   $recordtime = $res34['recordtime'];

		  //include ('ipcreditaccountreport3_ipcredit.php');
			//$total = $overalltotal;

		   $query71 = "select * from ip_discharge where  locationcode='$searchlocation' and visitcode='$visitcode'";
		   $exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num71 = mysqli_num_rows($exec71);
		   $res71 = mysqli_fetch_array($exec71);
		   if($num71 == 0)
		   {
			$dischargedate='';
			$dischargetime='';
		    $status = 'Active';
		   }
		   else
		   {
			 if($res71['req_status']=='request'){
		       $status = 'Active';
				$dischargedate='';
			$dischargetime='';
			 } else{
			   $status = 'Discharged';
		   $dischargedate = $res71['recorddate'];
				$dischargetime = $res71['recordtime'];
			 }
		   }

			$query51 = "select * from ip_bedallocation where visitcode='$visitcode' and recordstatus='discharged' ";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num51 = mysqli_num_rows($exec51);
			$res51 = mysqli_fetch_array($exec51);
			if($num51 > 0)
			{
			$recorddate1=$res51['recorddate'];
			}else{
			$query51 = "select * from ip_bedtransfer where visitcode='$visitcode' and recordstatus='discharged' ";
			$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$num51 = mysqli_num_rows($exec51);
			$res51 = mysqli_fetch_array($exec51);
			$recorddate1=$res51['recorddate'];
			}

		   
		   $query82 = "select * from master_ipvisitentry where  locationcode='$searchlocation' and patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res82 = mysqli_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $conslt_timedate = $res82['consultationtime'];
		   $ipvist_autonumber = $res82['auto_number'];
		   $accountname = $res82['accountfullname'];
		   $type=$res82['type'];
		   
		    $subtype_ledger = $res82['accountname'];
		   
			$query15 = "select accountname from master_accountname where auto_number = '$subtype_ledger'";

			$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res15 = mysqli_fetch_array($exec15);

			$provider = $res15['accountname'];
		  if($type=='hospital')
		   {
			$type='H';   
		   }
		   if($type=='private')
		   {
			$type='P';   
		   }

			$mainsno=$mainsno+1;
			$colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#ecf0f5"';
			}
			
			?>
			
         <tr <?php echo $colorcode1; ?>>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
					<td class="bodytext31" valign="center"  align="left" style="color:#F00"><div align="center"><?php echo $type.'2nd'; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $patientname; ?></div></td>

					<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $patientcode; ?></div></td>
					
					<td class="bodytext31" valign="center"  align="left">  <div align="center"><?php echo $visitcode; ?></div>
					<input type="hidden" name="visitcode<?php echo $mainsno;?>" id="visitcode<?php echo $mainsno;?>" value="<?php echo $visitcode; ?>" /></td>

			    	<td class="bodytext31" valign="center"  align="left">&nbsp; </td>
					<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $provider; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"> <div align="center"><?php echo $accountname; ?></div></td>

					<td class="bodytext31" valign="center"  align="left"> <div align="center" style='color:<?php if($status=='Discharged') echo '#F00'; elseif($status=='Requested') echo '#3366cc'; else echo ''; ?>'><?php echo $status; ?></div></td>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><strong><?php echo date("d/m/Y", strtotime($recorddate))." ".$recordtime; ?></strong></div></td>
					<td class="bodytext31" valign="center"  align="left"><input id="admdate<?php echo $mainsno;?>" name="admdate<?php echo $mainsno;?>" class='admdatetime' size="18" autocomplete="off" readonly type="text">	</td>
					
					<script>
			getdischargedate('<?php echo $recorddate1; ?>','<?php echo $mainsno;?>');
			function getdischargedate(recorddate,ser){
			var serno=ser;
			var startdate=recorddate;
			var enddate=new Date().toISOString().slice(0, 10);
			
			var checkPastTime1 = function(currentDateTime1) {

			var d = new Date();
			var todayDate = d.getDate();
			if (currentDateTime1.getDate() == todayDate) { // check today date
				this.setOptions({
					minTime: d.getHours() + ':00' //here pass current time hour
				});
			} else
				this.setOptions({
					minTime: false
				});
			};

			$(document).ready(function(){
				
				jQuery('.dischargedatetime'+serno).datetimepicker({
					step: 15,
					minDate: startdate,
					maxDate: enddate,
					onChangeDateTime:checkPastTime1,
					onShow:checkPastTime1
				});
				
			});
			}
			</script>
					<?php if($dischargedate!=''){?>
					<td class="bodytext31" valign="center"  align="left"><div align="center"><strong><?php echo date("d/m/Y", strtotime($dischargedate))." ".$dischargetime; ?></strong></div></td>
					<td class="bodytext31" valign="center"  align="left"><input id="disdate<?php echo $mainsno;?>" name="disdate<?php echo $mainsno;?>" class='dischargedatetime<?php echo $mainsno;?>' size="18" autocomplete="off" readonly type="text"  >		</td>
				   <?php } else{ ?>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>&nbsp;</strong></div></td>
				   <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>&nbsp;</strong></div></td>
				   <?php } ?>
			
					<td class="bodytext31" valign="center"  align="center"><a class="saveitem" id="s_<?php echo $mainsno; ?>" href="" ><strong>Update</strong></a></td>
			         </tr>
		  <?php
		  }
		  }
           ?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311"  colspan="2"valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			
			</tr>
			
          </tbody>
        </table>
<?php
}
?>	
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
    </table>
  </table>  
<?php include ("includes/footer1.php"); ?>
</body>
</html>

<script>


</script>
