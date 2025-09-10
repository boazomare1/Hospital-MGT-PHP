<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

ob_start();

$docno = $_SESSION['docno'];
$timeonly = date('H:i:s');
$dateonly=date("Y-m-d");

if(isset($_REQUEST['category_id'])){$category_id = $_REQUEST['category_id'];}else{$category_id='';}

if(isset($_REQUEST['searchstatus'])){$searchstatus = $_REQUEST['searchstatus'];}else{$searchstatus='';}
if(isset($_REQUEST['ADate1'])){$fromdate = $_REQUEST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_REQUEST['ADate2'])){$todate = $_REQUEST['ADate2'];}else{$todate=$transactiondateto;}
$patienttype=isset($_REQUEST['patienttype'])?$_REQUEST['patienttype']:'';
?>
<?php
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		 $locationcode=$location;
		}
		//location get end here
		?>
<style type="text/css">
<!--
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #fff; FONT-FAMILY: Tahoma
}
.number
{
padding-left:650px;
text-align:right;
font-weight:bold;
}
-->
</style>

<script language="javascript">

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



function cbcustomername1()
{
	document.cbform1.submit();
}

</script>

<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
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

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->

<?php
function calculate_age($birthday)
{
 
 if($birthday=="0000-00-00")
 {
  return "0 Days";
 }
 
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}
?>
<?php

function get_time($g_datetime){
$from=date_create(date('Y-m-d H:i:s',strtotime($g_datetime)));
$to=date_create(date('Y-m-d H:i:s'));
$diff=date_diff($to,$from);
//print_r($diff);
$y = $diff->y > 0 ? $diff->y.' Years <br>' : '';
$m = $diff->m > 0 ? $diff->m.' Months <br>' : '';
$d = $diff->d > 0 ? $diff->d.' Days <br>' : '';
$h = $diff->h > 0 ? $diff->h.' Hrs <br>' : '';
$mm = $diff->i > 0 ? $diff->i.' Mins <br>' : '';
$ss = $diff->s > 0 ? $diff->s.' Secs <br>' : '';

echo $y.' '.$m.' '.$d.' '.$h.' '.$mm.' '.$ss.' ';
}

?>
</style>


<table width="103%" border="0" cellspacing="0" cellpadding="2">

<tr bgcolor="#666666" style="color:#FFFFFF;font-weight:bold" >
	<td colspan="7">Pending Rquests</td><td colspan="2" align="right"><?= date('d-m-Y H:i:s') ?></td>
</tr>	
<tr bgcolor="#ccc" style="color:#000;">	
	<td colspan="2" >Period</td><td colspan="3"><?= date('d/m/Y',strtotime($fromdate))." to ".date('d/m/Y',strtotime($todate)); ?> </td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>

</tr>
<tr bgcolor="#ccc"  style="color:#000;">
	<td colspan="2" bgcolor="#ccc">Only Section </td><td colspan="3"><?php 	
	    $queryaa1 = "select * from master_categorylab where auto_number='$category_id' order by categoryname ";
			$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($resaa1 = mysqli_fetch_array($execaa1))
		{

			$data_count=0;
			echo $categoryname = $resaa1["categoryname"];
		}else{
		echo "All";
		}

	  ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr bgcolor="#ccc"  style="color:#000;">	
	<td colspan="2" >Patient Type</td><td  colspan="3"><?= $patienttype; ?> </td>
		<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>

</tr>
<tr bgcolor="#ccc"  style="color:#000;">	
	<td colspan="2" >Status</td><td colspan="3" ><?= $searchstatus; ?> </td>
		<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>

</tr>
<tr>
	<td><br /></td>
</tr>

    <?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_REQUEST['patient'];
	$searchpatientcode=$_REQUEST['patientcode'];
	$searchvisitcode = $_REQUEST['visitcode'];
	$fromdate=$_REQUEST['ADate1'];
	$todate=$_REQUEST['ADate2'];
	?>
<?php
			$colorloopcount = '';
			$sno = '';

	if($category_id!='')
	{
	    $queryaa1 = "select * from master_categorylab where auto_number='$category_id' order by categoryname ";
	}else{
	    $queryaa1 = "select * from master_categorylab order by categoryname ";
		}
		$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($resaa1 = mysqli_fetch_array($execaa1))
		{

		$data_count=0;
		$categoryname = $resaa1["categoryname"];
		$auto_number = $resaa1["auto_number"];
?>


			<?php
			
			
			if($patienttype != 'IP')
			{
			
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.urgentstatus,a.consultationdate,a.paymentstatus,a.freestatus,a.username from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus='completed' and a.labsamplecoll='$searchstatus' and a.billtype='PAY NOW' and a.freestatus='' and a.patientcode <> 'walkin' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."' group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$freestatus = $res1['freestatus'];
			$username = $res1['username'];
			
			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
 			
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
			
			
			$query111 = "select age,gender,departmentname,patientcode from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcodedob'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
 $patientdob=$res69['dateofbirth'];
	
			$age = $res111['age'];
			
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFF"';
			}
						$data_count++;

			?>
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>

			
            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
             <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php  echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
 			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
             </tr>
			<?php
			}    
			?>
			<?php
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.username,a.urgentstatus,a.consultationdate,a.paymentstatus,a.freestatus from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.labsamplecoll='$searchstatus' and a.billtype='PAY NOW' and (a.freestatus='NO' or a.freestatus='Yes') and a.consultationdate between '$fromdate' and '$todate'  and a.locationcode='".$locationcode."' group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$username = $res1['username'];
				$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$freestatus = $res1['freestatus'];

			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

			$consultationdate = $res1['consultationdate'];
			$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
			$waitingtime = round($waitingtime);
			$waitingtime = abs($waitingtime);
				$waitingtime1 = $waitingtime;
				$days=$days;
								
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			if($patientcode=='walkin')
			{
				$username="self";
			}
			
			$query111 = "select age,gender,departmentname,patientcode from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcodedob'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$querymch1 = "select * from consultation_lab where paymentstatus='completed' and  labsamplecoll='$searchstatus' and billtype='PAY NOW' and freestatus='NO' and consultationdate between '$fromdate' and '$todate' and locationcode='".$locationcode."' group by patientvisitcode order by consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execmch1 = mysqli_query($GLOBALS["___mysqli_ston"], $querymch1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numsmch1 = mysqli_num_rows($execmch1);
			if($numsmch1 != 0)
			{
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFF"';
			}
						$data_count++;
			?>
			
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>
            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
             <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php   echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
 			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}
			else
			{
			if($freestatus == 'Yes')
			{
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
			
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
		  </tr>

            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
             <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob);  ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
 			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php 
			}
			} 
			}   
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.username,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.consultationdate,a.paymentstatus,a.urgentstatus from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus = 'completed' and a.labsamplecoll='$searchstatus' and a.billtype='PAY LATER' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."'  group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				$username = $res1['username'];

			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
				
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
				$querycheck = "select planpercentage from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' and transactiontype <> 'pharmacycredit'  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if($billpaylatercount==0 && $planpercentage=='0.00')
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select age,gender,departmentname,patientcode from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
			$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcodedob'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>		

			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
		  </tr>
				
            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
 			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}   } 
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.username,a.patientname,a.billnumber,a.consultationdate from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus='paid' and a.labsamplecoll='$searchstatus' and a.patientcode='walkin' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."' group by a.billnumber,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientfullname = $res1['patientname'];
			$username = $res1['username'];
			

			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
 			
			if($patientcode=="walkin")
			{
				$username="self";
			}
			
			
			$query111 = "select age,gender,patientcode from billing_external where patientname='$patientfullname'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);

			$patientcode = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			
			$query11="select * from billing_external where patientname='$patientfullname'";
			$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			$billnumber=$res1['billnumber'];
			
			$consultationdate = $res1['consultationdate'];
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
 
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>

              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
             <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo "DIRECT";?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo "DIRECT"; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php  echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo "EXTERNAL"; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}  
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientname,a.username,a.billnumber,a.consultationdate from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus='completed' and a.labsamplecoll='$searchstatus' and a.patientcode='walkin' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."' group by a.billnumber,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
		 	 $patientfullname = $res1['patientname'];
			$username = $res1['username'];
			
			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
			
			$query111 = "select age,gender,patientcode from billing_external where patientname='$patientfullname'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
				$patientcode = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			//$billnumber=$res111['billno'];
			
			$query11="select * from billing_external where patientname='$patientfullname'";
			$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			$billnumber=$res1['billnumber'];
			
			$consultationdate = $res1['consultationdate'];
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>

			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>

           <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
			  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo "DIRECT";?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo "DIRECT"; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
				 <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php  echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo "EXTERNAL"; ?></td>

     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}      
			?>
            
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.username,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.consultationdate,a.paymentstatus,a.urgentstatus from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus = 'pending' and a.labsamplecoll='$searchstatus' and a.billtype='PAY LATER' and a.approvalstatus!='0' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."' and a.copay <> 'completed'  group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				$username = $res1['username'];

			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;

			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];	
				
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				
				
				$querycheck = "select planpercentage,planname,planfixedamount from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			$plannumber = $rescheck['planname'];
			$planfixedamount = $rescheck['planfixedamount'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];		
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' and transactiontype <> 'pharmacycredit'   ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if($billpaylatercount==0 && $planpercentage!='0.00' && $planfixedamount==0.00)
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select age,gender,departmentname,patientcode from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
				$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcodedob'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
				<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
			  </tr>

		
            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
             <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
 			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>


     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}   } ?>
            
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.username,a.consultationid,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.consultationdate,a.paymentstatus,a.urgentstatus from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus = 'completed' and a.labsamplecoll='$searchstatus' and a.billtype='PAY LATER' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."'  and a.copay = 'completed'  group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				$username = $res1['username'];

			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
 				
				$consultationid = $res1['consultationid'];
				
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];	
				
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				
				
				$querycheck = "select planpercentage,planname from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			$plannumber = $rescheck['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."'  and transactiontype <> 'pharmacycredit'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if( $planpercentage!='0.00' && $planforall =='yes')
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select * from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
				$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcodedob'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
			
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
		  </tr>

            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
                <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
            <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php  echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}   } ?>
             <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			
				
			
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.patientname,a.username,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.consultationdate,a.paymentstatus,a.urgentstatus,a.consultationid from consultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.paymentstatus = 'completed' and a.labsamplecoll='$searchstatus' and a.billtype='PAY LATER' and a.consultationdate between '$fromdate' and '$todate' and a.locationcode='".$locationcode."'  and a.copay = 'completed'  group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate  ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			while ($res1 = mysqli_fetch_array($exec1))
			{
				$patientcode1 = $res1['patientcode'];
		    	$visitcode1 = $res1['patientvisitcode'];
				 $visitcode1patientname = $res1['patientname'];
				 $username = $res1['username'];
			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
 				
				$consultationid = $res1['consultationid'];
				$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
				if($patientcode1=='walkin')
			{
				$username="self";
			}
				
				$querycheck = "select planpercentage,planname from master_visitentry where patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execcheck = mysqli_query($GLOBALS["___mysqli_ston"], $querycheck) or die ("Error in Querycheck".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rescheck = mysqli_fetch_array($execcheck);
			$planpercentage = $rescheck['planpercentage'];
			$plannumber = $rescheck['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysqli_query($GLOBALS["___mysqli_ston"], $queryplanname) or die ("Error in Queryplanname".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resplanname = mysqli_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			
				$queryche = "select * from master_transactionpaylater where  patientcode ='".$patientcode1."' and visitcode ='".$visitcode1."' and locationcode='".$locationcode."' and transactiontype <> 'pharmacycredit' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execche = mysqli_query($GLOBALS["___mysqli_ston"], $queryche) or die ("Error in Queryche".mysqli_error($GLOBALS["___mysqli_ston"]));
			$billpaylatercount=mysqli_num_rows($execche);
				
			if( $planpercentage!='0.00' && $planforall =='')
			{	
			
			
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$query111 = "select age,gender,departmentname,patientcode from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
				$patientcodedob = $res111['patientcode'];
$query69="select * from master_customer where customercode='$patientcodedob'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$urgentstatus = $res1['urgentstatus'];
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
			
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
		  </tr>

            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
 			   <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>

     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}   }
			}?>
            
            <?php
            if($patienttype !='OP+EXTERNAL')
			{
            $triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.username,a.urgentstatus,a.consultationdate from ipconsultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.labsamplecoll='pending' and a.billtype='PAY NOW' and a.locationcode = '$location' and a.consultationdate between '$fromdate' and '$todate' group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$username = $res1['username'];


			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;
 
				$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
			
				if($patientcode=='walkin')
			{
				$username="self";
			}
			
			
				
			$query111 = "select age,gender,customercode from master_customer where customercode='$patientcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
				$customercode = $res111['customercode'];
$query69="select * from master_customer where customercode='$customercode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			
		 	$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered'))";
		
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
					if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
			$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
		  </tr>

            <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
                 <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob); ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
                  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $ward; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			}    
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select a.consultationtime,a.labitemcode,a.labitemname,a.refno,a.patientcode,a.patientvisitcode,a.patientname,a.accountname,a.username,a.consultationdate,a.urgentstatus from ipconsultation_lab as a JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname' where a.patientname like '%$searchpatient%' and a.patientcode like '%$searchpatientcode%' and a.patientvisitcode like '%$searchvisitcode%' and a.labsamplecoll='pending' and a.billtype='PAY LATER' and a.locationcode = '$location' and a.consultationdate between '$fromdate' and '$todate' group by a.patientvisitcode,a.labitemcode,a.refno order by a.consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$username = $res1['username'];
			$consultationdate = $res1['consultationdate'];

			$consultationtime = $res1['consultationtime'];
			$labitemcode = $res1['labitemcode'];
			$labitemname = $res1['labitemname'];
			$refno = $res1['refno'];

				$consultationdate = $res1['consultationdate'];
				$diff = abs(strtotime($consultationdate) - strtotime($dateonly));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

				$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
				$waitingtime = round($waitingtime);
				$waitingtime = abs($waitingtime);
					$waitingtime1 = $waitingtime;
					$days=$days;			
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
				$urgentstatus = $res1['urgentstatus'];
				$userfulldetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username' and locationcode='$locationcode' and username <> '' and status='Active'");
			$resuser=mysqli_fetch_array($userfulldetail);
			$userfullname=$resuser['employeename'];
				
					if($patientcode=='walkin')
			{
				$username="self";
			}
				
			
			$query111 = "select age,gender,customercode from master_customer where customercode='$patientcode'";
			$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res111 = mysqli_fetch_array($exec111);
				$customercode = $res111['customercode'];
$query69="select * from master_customer where customercode='$customercode'";
$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res69=mysqli_fetch_array($exec69);
$patientdob=$res69['dateofbirth'];

			$age = $res111['age'];
			$gender = $res111['gender'];
			
				$warddate="select ward from master_ward where auto_number in(select ward from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
			
			$exeward=mysqli_query($GLOBALS["___mysqli_ston"], $warddate);
			
			$resward=mysqli_fetch_array($exeward);
			$ward=$resward['ward'];
			$numrow=mysqli_num_rows($exeward);
			if($numrow =='0')

{			$warddate1="select ward from master_ward where auto_number in(select ward from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus NOT IN ('discharged','transfered') )";
		
			$exeward1=mysqli_query($GLOBALS["___mysqli_ston"], $warddate1);
			$resward1=mysqli_fetch_array($exeward1);
			$ward=$resward1['ward'];
			
}
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			 if($urgentstatus == 1)
			{
				$colorcode = 'bgcolor="#FFF"';
			}
			$data_count++;
			?>
			
   			<tr>
              <td style="border:1px #000 solid" width="3%"  align="left" valign="center"  
                 class="bodytext31"><strong>Sno</strong></td>          
              <td style="border:1px #000 solid" width="8%" align="left" valign="center"  
                 class="bodytext31"><strong>Date</strong></td>
              <td style="border:1px #000 solid" width="7%" align="left" valign="center"  
                 class="bodytext31"><strong>Time</strong></td>
             <td style="border:1px #000 solid" width="10%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patientcode </strong></td>
              <td style="border:1px #000 solid" width="9%"  align="left" valign="center" 
                 class="bodytext31"><strong>Visitcode</strong></td>
              <td style="border:1px #000 solid" width="20%"  align="left" valign="center" 
                 class="bodytext31"><strong>Patient</strong></td>
               <td style="border:1px #000 solid" width="6%"  align="left" valign="center" 
                 class="bodytext31"><strong>Age</strong></td>
              <td style="border:1px #000 solid" width="5%"  align="left" valign="center" 
                 class="bodytext31"><strong>Gender</strong></td>
              <td style="border:1px #000 solid" width="13%"  align="left" valign="center" 
                 class="bodytext31"><strong>Ward/Department</strong></td>
  </tr>

         <tr >
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $consultationtime; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
                 <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo calculate_age($patientdob);  ?></td>
				  <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td style="border:1px #000 solid" class="bodytext31" valign="center"  align="left"><?php echo $ward; ?></td>
     			</tr>
				<tr>				
              <td style="border:1px #000 solid" align="left" valign="center"  
                 class="bodytext31"><strong>Test</strong></td>
				 <td style="border:1px #000 solid" align="left" valign="center"  
                class="bodytext31" colspan="3" ><strong><?php echo $labitemname; ?></strong></td>

			  <td style="border:1px #000 solid" colspan="5" align="left" valign="center"  
                 class="bodytext31"> </td>
				
             </tr>  
			 
			 <tr style="border-left:none;border-right:none;border:none">
			  <td style="border-left:none;border-right:none" colspan="9"> <br><br></td>
			 
			 </tr>        
			<?php
			} 
			}
			?>
	
	<?php
		
	}
?> 
	       </tbody>
        </table>
	  <?php } ?>

<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
//$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
//$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 900, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Bankreport.pdf", array("Attachment" => 0)); 
?>	