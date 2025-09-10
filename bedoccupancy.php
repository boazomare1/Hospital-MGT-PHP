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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="jquery/jquery-1.11.1.min.js"></script>
<script>
$(document).ready(function()
{

});
</script>

<script type="text/javascript">

function Buildward()
{
<?php
	$query4 = "select * from master_location where status = ''";
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
		$query10 = "select * from master_ward where locationcode = '$res4loccode' and recordstatus <> 'deleted' order by ward";
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

<script src="js/datetimepicker_css.js"></script>


<body>
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><form name="cbform1" method="post" action="bedoccupancy.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Bed Occupancy Detailed</strong></td>
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
          <td width="165" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="379" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="69" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="155" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           <tr>
  			  <td width="165" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>
              <td width="379" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 <select name="location" id="location" onChange="return Buildward()">  
			 <option value="">Select</option>       	
                        <?php
						$query01="select locationcode,locationname from master_location where locationcode IN ('LTC-1','LTC-2')";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname']; ?> </option>		
						<?php 
						}
						?>
                      </select>
				
					 
              </span></td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
               <tr>
  			  <td width="165" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Ward</strong>			  </td>
              <td width="379" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 <select name="ward" id="ward"  >
                <option value="">All</option>  
					<?php 
				$query201="select auto_number,ward from master_ward where locationcode = '$location'";
				$exc201=mysqli_query($GLOBALS["___mysqli_ston"], $query201);
				$rr = mysqli_num_rows($exc201);
				while($res201=mysqli_fetch_array($exc201))
				{?>
					<option value="<?php echo $res201['auto_number'] ?>" <?php if($ward==$res201['auto_number']){ echo "selected";} ?>> <?php echo $res201['ward']; ?> </option>		
				<?php 
				}
				?>    
               </select>
				
					 
              </span></td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
						
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="bedoccupancy.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$totalday='0';
$totalbedday = '0';
	//$searchpatient = $_POST['patient'];
	//$searchpatientcode=$_POST['patientcode'];
	//$searchvisitcode=$_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	 $todate=$_POST['ADate2'];
	
	//$docnumber=$_POST['docnumber'];
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];
	



?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse; float:none" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1128" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="12" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Bed Occupancy Detailed</strong><label class="number"></label></div></td>
			 </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
				  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Reg. No. </strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Visit Code </strong></div></td>
             	<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Age </strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Gender </strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>From Date </strong></div></td>
                  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Admission Date </strong></div></td>
                  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Discharge Date </strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>To Date </strong></div></td>
                  <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Days </strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed Days </strong></div></td>
             </tr>
            

<?php	
			$totaldays = 0;
			$totalbeddays = 0;
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">												<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>								</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">												<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>								</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">								<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>				</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">								<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>				</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">								<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>				</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">								<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>				</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">								<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>				</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center">								<a target="_blank" href="ipemrview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><?php echo $visitcode; ?></a>				</div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $age; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $gender; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $fromdate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $admissiondate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dischargedate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $todate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totaldays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalbeddays; ?></div></td>  
              </tr>
		   <?php 
			}
	      ?>
        <tr>
        <td>&nbsp;</td>
        </tr>
         <tr>
             <?php if($sno > 0) { $avgstay= $totalbedday/$sno ; } else { $avgstay = '0.00'; } ?>
			  <td width="162"  align="left" valign="center" class="bodytext31">
			  <div class="bodytext31" align="left"><strong></strong></div></td>
               <td width="57"  align="left" valign="center" class="bodytext31"><div align="left"><strong>Total Patients:</strong></div></td>
               <td width="57"  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $sno ?></div></td>
			  <td width="143"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Total Days</strong></div></td>
                 <td width="61"  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $totalday ?></div></td>
				  <td width="143"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Total Bed Days</strong></div></td>
                 <td width="61"  align="left" valign="center" class="bodytext31"><div align="left"><?php echo $totalbedday ?></div></td>
				 <td width="156"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Average Length of Stay</strong></div></td>
				 <td width="174"  align="left" valign="center" class="bodytext31"><div align="left"><?php echo number_format($avgstay); ?></div></td>
                <td width="4%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><a target="_blank" href="print_bedoccupancy.php?&&location=<?php echo $location; ?>&&ward=<?= $ward ?>&&ADate1=<?= $fromdate ?>&&ADate2=<?= $todate ?>&&cbfrmflag1=cbfrmflag1"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
      </tr> 
              
               
              
        
         
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
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
      </tr>
		
          </tbody>
        </table>
		
<?php
		
}
			
?>	
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

