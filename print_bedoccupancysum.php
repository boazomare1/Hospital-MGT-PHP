<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$ward=isset($_REQUEST['ward'])?$_REQUEST['ward']:'';
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date('Y-m-d', strtotime('-1 month'));
$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date('Y-m-d');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="bedoccupancysummary.xls"');
header('Cache-Control: max-age=80');
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ffffff;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<script>
$(document).ready(function()
{

});
</script>

<script type="text/javascript">

function Buildward()
{
<?php
	$query4 = "select locationname, locationcode from master_location where status = ''";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res4 = mysqli_fetch_array($exec4))
	{
	$res4locname = $res4['locationname'];
	$res4loccode = $res4['locationcode'];
	?>
		if(document.getElementById("location").value == "<?php echo $res4loccode; ?>")
		{
		//alert(document.getElementById("department").value);
		document.getElementById("ward").options.length=null; 
		var combo = document.getElementById('ward'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("All", ""); 
		<?php
		$query10 = "select auto_number, ward from master_ward where locationcode = '$res4loccode' and recordstatus <> 'deleted' order by ward";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10wardanum = $res10['auto_number'];
		$res10ward = $res10["ward"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10ward;?>", "<?php echo $res10wardanum;?>"); 
		<?php 
		}
		?>
		}
	<?php 
	}
	?>	
}

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

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "";
		return false;
	}
}


function funcPrintReceipt1()
{
	
}

</script>
<script>

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

</script>



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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
</style>
</head>



<body>
	
<?php
	$colorloopcount=0;
	$sno=0;
		$sno1=0;
	
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$totalday='0';
$totalbedday = '0';
$totalday1='0';
$totalbedday1 = '0';
$total1 = 0;
$total2 = 0;
$total3 = 0;
	//$searchpatient = $_POST['patient'];
	//$searchpatientcode=$_POST['patientcode'];
	//$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_REQUEST['ADate1'];
	 $todate=$_REQUEST['ADate2'];
	
	//$docnumber=$_POST['docnumber'];
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];
	


$querynw1 = "select * from ip_discharge where locationcode='$locationcode1' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse; float:none" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1035" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="4" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed Occupancy Summary</strong></div></td>
			 </tr>
            <tr>
              <td width="281"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward Name</strong></div></td>
				<td width="211"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Patients</strong></div></td>
                  <td width="143"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Days </strong></div></td>
				<td width="142"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed Days </strong></div></td>
             </tr>
           <?php	
			$totaldays = 0;
			$totalbeddays = 0;
			$totalwarddays = 0;
			$totalwardbeddays = 0;
			$totalpatients = 0;
			
			$searchward = $ward;
			if($ward == ''){
			$query56 = "select auto_number, ward from master_ward where locationcode = '$locationcode1' and recordstatus <> 'deleted'";
			} else {
			$query56 = "select auto_number, ward from master_ward where auto_number = '$ward' and locationcode = '$locationcode1' and recordstatus <> 'deleted'";
			}
			$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die ("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res56 = mysqli_fetch_array($exec56))
			{
			$ward = $res56['auto_number'];
			$wardname = $res56['ward'];
			
			$totalwarddays = 0;
			$totalwardbeddays = 0;
			$patients = 0;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#ffffff"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#ffffff"';
			}
			?>
         	<?php	
			if($ward == ''){
  			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			} else {
			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
				
			$formvar='';
			$i1=0;			
			while($getmw=mysqli_fetch_array($execnw1))
			{ 
				$patientcode=$getmw['patientcode'];
				$visitcode=$getmw['visitcode'];
				$res2consultationdate=$getmw['recorddate'];
				$admissiondate = $getmw['recorddate'];
				
			$query02="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
			$res02=mysqli_fetch_array($exec02);
			
			$patientname=$res02['patientfullname'];
		   $gender=$res02['gender'];
		
					$query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res751 = mysqli_fetch_array($exec751);
		$dob = $res751['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3=mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			
			$res3recorddate=$res3['recorddate'];
			$dischargedate = $res3['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num3 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			
			}
			
			if($ward == ''){
  			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			} else {
			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw1 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw1) or die ("Error in Querynw1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw1=mysqli_num_rows($execnw1);
				
			$formvar='';
			$i1=0;			
			while($getmw=mysqli_fetch_array($execnw1))
			{ 
				$patientcode=$getmw['patientcode'];
				$visitcode=$getmw['visitcode'];
				
				$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysqli_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
			$query02="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
			$res02=mysqli_fetch_array($exec02);
			
			$patientname=$res02['patientfullname'];
		   $gender=$res02['gender'];
		
					$query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res751 = mysqli_fetch_array($exec751);
		$dob = $res751['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num3=mysqli_num_rows($exec3);
			$res3 = mysqli_fetch_array($exec3);
			
			$res3recorddate=$res3['recorddate'];
			$dischargedate = $res3['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num3 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
	       if($ward == ''){
  			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";
			} else {
			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw2=mysqli_num_rows($execnw2);
				
			$formvar='';
			$i1=0;			
			while($getmw2=mysqli_fetch_array($execnw2))
			{ 
				$patientcode=$getmw2['patientcode'];
				$visitcode=$getmw2['visitcode'];
				$res2consultationdate=$getmw2['recorddate'];
				$admissiondate = $getmw2['recorddate'];
				
		
			$query021="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec021=mysqli_query($GLOBALS["___mysqli_ston"], $query021);
			$res021=mysqli_fetch_array($exec021);
			
			$patientname=$res021['patientfullname'];
		   $gender=$res021['gender'];
		
					$query752 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec752 = mysqli_query($GLOBALS["___mysqli_ston"], $query752) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res752 = mysqli_fetch_array($exec752);
		$dob = $res752['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num31=mysqli_num_rows($exec31);
			$res31 = mysqli_fetch_array($exec31);
			
			$res31recorddate=$res31['recorddate'];
			$dischargedate = $res31['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num31 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
			if($ward == ''){
  			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";
			} else {
			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw2 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw2) or die ("Error in Querynw2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw2=mysqli_num_rows($execnw2);
				
			$formvar='';
			$i1=0;			
			while($getmw2=mysqli_fetch_array($execnw2))
			{ 
				$patientcode=$getmw2['patientcode'];
				$visitcode=$getmw2['visitcode'];
				
				$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysqli_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
				
			$query021="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec021=mysqli_query($GLOBALS["___mysqli_ston"], $query021);
			$res021=mysqli_fetch_array($exec021);
			
			$patientname=$res021['patientfullname'];
		   $gender=$res021['gender'];
		
					$query752 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec752 = mysqli_query($GLOBALS["___mysqli_ston"], $query752) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res752 = mysqli_fetch_array($exec752);
		$dob = $res752['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num31=mysqli_num_rows($exec31);
			$res31 = mysqli_fetch_array($exec31);
			
			$res31recorddate=$res31['recorddate'];
			$dischargedate = $res31['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num31 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
			if($ward == ''){
  			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";
			} else {
			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw8 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw8) or die ("Error in Querynw8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw8=mysqli_num_rows($execnw8);
				
			$formvar='';
			$i1=0;			
			while($getmw8=mysqli_fetch_array($execnw8))
			{ 
				$patientcode=$getmw8['patientcode'];
				$visitcode=$getmw8['visitcode'];
				$res2consultationdate=$getmw8['recorddate'];
				$admissiondate = $getmw8['recorddate'];
				
		
			$query081="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec081=mysqli_query($GLOBALS["___mysqli_ston"], $query081);
			$res081=mysqli_fetch_array($exec081);
			
			$patientname=$res081['patientfullname'];
		   $gender=$res081['gender'];
		
					$query758 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec758 = mysqli_query($GLOBALS["___mysqli_ston"], $query758) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res758 = mysqli_fetch_array($exec758);
		$dob = $res758['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num33=mysqli_num_rows($exec33);
			$res33 = mysqli_fetch_array($exec33);
			
			$res33recorddate=$res33['recorddate'];
			$dischargedate = $res33['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num33 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			 }
			
			if($ward == ''){
  			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";
			} else {
			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw8 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw8) or die ("Error in Querynw8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw8=mysqli_num_rows($execnw8);
				
			$formvar='';
			$i1=0;			
			while($getmw8=mysqli_fetch_array($execnw8))
			{ 
				$patientcode=$getmw8['patientcode'];
				$visitcode=$getmw8['visitcode'];
				
				$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysqli_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
				
			$query081="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec081=mysqli_query($GLOBALS["___mysqli_ston"], $query081);
			$res081=mysqli_fetch_array($exec081);
			
			$patientname=$res081['patientfullname'];
		   $gender=$res081['gender'];
		
					$query758 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec758 = mysqli_query($GLOBALS["___mysqli_ston"], $query758) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res758 = mysqli_fetch_array($exec758);
		$dob = $res758['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num33=mysqli_num_rows($exec33);
			$res33 = mysqli_fetch_array($exec33);
			
			$res33recorddate=$res33['recorddate'];
			$dischargedate = $res33['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num33 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			 }
			
			if($ward == ''){
  			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
			} else {
			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw3=mysqli_num_rows($execnw3);
				
			$formvar='';
			$i1=0;			
			while($getmw3=mysqli_fetch_array($execnw3))
			{
				$patientcode=$getmw3['patientcode'];
				$visitcode=$getmw3['visitcode'];
				$res2consultationdate=$getmw3['recorddate'];
				$admissiondate = $getmw3['recorddate'];
				
		
			$query022="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
			$res022=mysqli_fetch_array($exec022);
			
			$patientname=$res022['patientfullname'];
		   $gender=$res022['gender'];
		
					$query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res753 = mysqli_fetch_array($exec753);
		$dob = $res753['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num311=mysqli_num_rows($exec311);
			$res311 = mysqli_fetch_array($exec311);
			
			$res311recorddate=$res311['recorddate'];
			$dischargedate = $res311['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num311 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
			if($ward == ''){
  			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
			} else {
			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw3 = mysqli_query($GLOBALS["___mysqli_ston"], $querynw3) or die ("Error in Querynw3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resnw3=mysqli_num_rows($execnw3);
				
			$formvar='';
			$i1=0;			
			while($getmw3=mysqli_fetch_array($execnw3))
			{
				$patientcode=$getmw3['patientcode'];
				$visitcode=$getmw3['visitcode'];
				
				$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysqli_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
				
			$query022="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec022=mysqli_query($GLOBALS["___mysqli_ston"], $query022);
			$res022=mysqli_fetch_array($exec022);
			
			$patientname=$res022['patientfullname'];
		   $gender=$res022['gender'];
		

					$query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec753 = mysqli_query($GLOBALS["___mysqli_ston"], $query753) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res753 = mysqli_fetch_array($exec753);
		$dob = $res753['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die ("Error in Query311".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num311=mysqli_num_rows($exec311);
			$res311 = mysqli_fetch_array($exec311);
			
			$res311recorddate=$res311['recorddate'];
			$dischargedate = $res311['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num311 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
	      ?>
          <tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $wardname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patients; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalwarddays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalwardbeddays; ?></div></td>  
              </tr>
		   <?php 
			}
	      ?>
        <tr>
        <td>&nbsp;</td>
        </tr>
         <tr>
             <?php if($totalpatients > 0) { $avgstay= $totalbedday/$totalpatients ; } else { $avgstay = '0.00'; } ?>
			  
               <td width="57"  align="left" valign="center" class="bodytext31"><div align="left"><strong>Total Patients:</strong> <?php echo $totalpatients ?></div></td>
               
			  <td width="143"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Total Days :</strong> <?php echo $totalday ?></div></td>
				  <td width="143"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Total Bed Days :</strong> <?php echo $totalbedday ?></div></td>
				 <td width="156"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Average Length of Stay :</strong> <?php echo number_format($avgstay); ?></div></td>
               
      </tr> 
              
               
              
        
         
            <tr>
    
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff">&nbsp;</td>
      </tr>
		
          </tbody>
        </table>
		
<?php
		
}
			
?>	
	
	  
	  
	  
	 

</body>
</html>

